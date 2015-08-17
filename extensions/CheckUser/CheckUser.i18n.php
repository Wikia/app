<?php
/**
 * Internationalisation file for CheckUser extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Tim Starling
 * @author Aaron Schulz
 * @author John Du Hart
 */
$messages['en'] = array(
	'checkuser-summary'          => 'This tool scans recent changes to retrieve the IP addresses used by a user or show the edit/user data for an IP address.
Users and edits by a client IP address can be retrieved via XFF headers by appending the IP address with "/xff". IPv4 (CIDR 16-32) and IPv6 (CIDR 64-128) are supported.
No more than 5,000 edits will be returned for performance reasons.
Use this in accordance with policy.',
	'checkuser-desc'             => 'Grants users with the appropriate permission the ability to check user\'s IP addresses and other information',
	'checkuser-logcase'          => 'The log search is case sensitive.',
	'checkuser'                  => 'Check user',
	'checkuserlog'               => 'Check user log',
	'checkuser-contribs'         => 'check user IP addresses',
	'group-checkuser'            => 'Check users',
	'group-checkuser-member'     => '{{GENDER:$1|check user}}',
	'right-checkuser'            => "Check user's IP addresses and other information",
	'right-checkuser-log'        => 'View the checkuser log',
	'action-checkuser' => "check user's IP addresses and other information",
	'action-checkuser-log' => 'view the checkuser log',
	'grouppage-checkuser'        => '{{ns:project}}:Check user',
	'checkuser-reason'           => 'Reason:',
	'checkuser-reason-api'       => 'API: $1',
	'checkuser-showlog'          => 'Show log',
	'checkuser-query'            => 'Query recent changes',
	'checkuser-target'           => 'IP address or username:',
	'checkuser-users'            => 'Get users',
	'checkuser-edits'            => 'Get edits',
	'checkuser-ips'              => 'Get IP addresses',
	'checkuser-search'           => 'Search',
	'checkuser-period'           => 'Duration:',
	'checkuser-week-1'           => 'last week',
	'checkuser-week-2'           => 'last two weeks',
	'checkuser-month'            => 'last 30 days',
	'checkuser-all'              => 'all',
	'checkuser-cidr-label'       => 'Find common range and affected IP addresses for a list of IP addresses',
	'checkuser-cidr-res'         => 'Common CIDR:',
	'checkuser-empty'            => 'The log contains no items.',
	'checkuser-nomatch'          => 'No matches found.',
	'checkuser-nomatch-edits'    => 'No matches found.
Last edit was on $1 at $2.',
	'checkuser-check'            => 'Check',
	'checkuser-log-fail'         => 'Unable to add log entry',
	'checkuser-nolog'            => 'No log file found.',
	'checkuser-blocked'          => 'Blocked',
	'checkuser-gblocked'         => 'Blocked globally',
	'checkuser-locked'           => 'Locked',
	'checkuser-wasblocked'       => 'Previously blocked',
	'checkuser-localonly'        => 'Not unified',
	'checkuser-massblock'        => 'Block selected users',
	'checkuser-massblock-text'   => 'Selected accounts will be blocked indefinitely, with autoblocking of IP addresses enabled and account creation disabled.
IP addresses will be blocked for one week for anonymous users only and account creation will be disabled.',
	'checkuser-blocktag'         => 'Replace user pages with:',
	'checkuser-blocktag-talk'    => 'Replace talk pages with:',
	'checkuser-massblock-commit' => 'Block selected users',
	'checkuser-block-success'    => '\'\'\'The {{PLURAL:$2|user|users}} $1 {{PLURAL:$2|is|are}} now blocked.\'\'\'',
	'checkuser-block-failure'    => '\'\'\'No users blocked.\'\'\'',
	'checkuser-block-limit'      => 'Too many users selected.',
	'checkuser-block-noreason'   => 'You must give a reason for the blocks.',
	'checkuser-noreason'         => 'You must give a reason for this query.',
	'checkuser-accounts'         => '$1 new {{PLURAL:$1|account|accounts}}',
	'checkuser-too-many'         => 'Too many results (according to query estimate), please narrow down the CIDR.
Here are the IPs used (5000 max, sorted by address):',
	'checkuser-user-nonexistent' => 'The specified user does not exist.',
	'checkuser-search-form'      => 'Find log entries where the $1 is $2',
	'checkuser-search-submit'    => 'Search',
	'checkuser-search-initiator' => 'initiator',
	'checkuser-search-target'    => 'target',
	'checkuser-ipeditcount'      => '~$1 from all users',
	'checkuser-log-return'       => 'Switch to CheckUser main form',

	'checkuser-limited'          => '\'\'\'These results have been truncated for performance reasons.\'\'\'',

	'checkuser-log-userips'      => '$1 got IP addresses for $2',
	'checkuser-log-ipedits'      => '$1 got edits for $2',
	'checkuser-log-ipusers'      => '$1 got users for $2',
	'checkuser-log-ipedits-xff'  => '$1 got edits for XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 got users for XFF $2',
	'checkuser-log-useredits'    => '$1 got edits for $2',

	'checkuser-autocreate-action' => 'was automatically created',
	'checkuser-create-action' => 'was created',
	'checkuser-email-action'     => 'sent an email to user "$1"',
	'checkuser-reset-action'     => 'reset password for user "$1"',

	'checkuser-toollinks'        => '<span class="plainlinks">[[http://openrbl.org/query?$1 RDNS] ·
[http://www.robtex.com/rbls/$1.html RBLs] ·
[http://www.dnsstuff.com/tools/tracert.ch?ip=$1 Traceroute] ·
[http://www.ip2location.com/$1 Geolocate] ·
[http://toolserver.org/~overlordq/scripts/checktor.fcgi?ip=$1 Tor check] ·
[http://ws.arin.net/whois/?queryinput=$1 WHOIS]]</span>', # do not translate or duplicate this message to other languages
	'checkuser-token-fail'       => 'Session failure. Please try again.',
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author Dferg
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Kwj2772
 * @author Lejonel
 * @author Lloffiwr
 * @author Meno25
 * @author Mormegil
 * @author Purodha
 * @author Raymond
 * @author Siebrand
 * @author Slomox
 * @author Tgr
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'checkuser-summary' => "Explanation of CheckUser tool. See [http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface screenshot titled 'Basic CheckUser interface'].",
	'checkuser-desc' => '{{desc}}',
	'checkuser' => 'Check user extension. The name of the special page where checkusers can check the IP addresses of users. The message is used in the list of special pages, and at the top of [[Special:Checkuser]].

{{Identical|Check user}}',
	'checkuserlog' => 'The name of the special page where checkusers can look at a log of past checkuser actions. The message is used in the list of special pages, and at the top of [[Special:CheckUserLog]].',
	'group-checkuser' => '{{doc-group|checkuser}}
check is a noun, not a verb here

{{Identical|Check user}}',
	'group-checkuser-member' => '{{doc-group|checkuser|member}}
{{Identical|Check user}}',
	'right-checkuser' => '{{doc-right|checkuser}}',
	'right-checkuser-log' => '{{doc-right|checkuser-log}}',
	'action-checkuser' => '{{doc-action|checkuser}}',
	'action-checkuser-log' => '{{doc-action|checkuser-log}}',
	'grouppage-checkuser' => '{{doc-group|checkuser|page}}
{{Identical|Check user}}',
	'checkuser-reason' => "Field name on CheckUser Special page. See screenshot '[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Basic CheckUser interface]'.

{{Identical|Reason}}",
	'checkuser-reason-api' => 'Prefixes check user query reasons that are made through the API

* $1 = User specified reason',
	'checkuser-showlog' => "Label for link on CheckUser Special page. See screenshot '[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Basic CheckUser interface]'.",
	'checkuser-query' => "Fieldset label. See [http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface screenshot titled 'Basic CheckUser interface'].",
	'checkuser-target' => '{{Identical|IP address or username}}',
	'checkuser-users' => "Radio button option on CheckUser Special page. See screenshot '[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Basic CheckUser interface]'.",
	'checkuser-edits' => "Radio button option on CheckUser Special page. See screenshot '[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Basic CheckUser interface]'.",
	'checkuser-ips' => "Option on CheckUser Special page. See screenshot '[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Basic CheckUser interface]'.",
	'checkuser-search' => 'Heading of fieldset on log of CheckUser searches. See screenshot "[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Example log]".

{{Identical|Search}}',
	'checkuser-period' => "Field name next to drop-down input box on CheckUser Special page. See screenshot '[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Basic CheckUser interface]'.

{{Identical|Duration}}",
	'checkuser-week-1' => 'Option in drop-down input box "Duration" on CheckUser Special page. See screenshot \'[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Basic CheckUser interface]\'.',
	'checkuser-week-2' => 'Option in drop-down input box "Duration" on CheckUser Special page. See screenshot \'[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Basic CheckUser interface]\'.',
	'checkuser-month' => 'Option in drop-down input box "Duration" on CheckUser Special page. See screenshot \'[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Basic CheckUser interface]\'.',
	'checkuser-all' => 'Option in drop-down input box "Duration" on CheckUser Special page. See screenshot \'[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Basic CheckUser interface]\'.

{{Identical|All}}',
	'checkuser-cidr-res' => 'For an explanation of CIDR see [[WikiPedia:CIDR]].',
	'checkuser-nomatch-edits' => '* $1 = date
* $2 = time',
	'checkuser-check' => 'Button label on CheckUser Special page. See screenshot \'[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Basic CheckUser interface]\'.

Also appears to be used as link to new CheckUser check from the results page of a CheckUser check - see screenshot "Example IP check".',
	'checkuser-massblock' => '{{Identical|Block selected users}}',
	'checkuser-massblock-commit' => '{{Identical|Block selected users}}',
	'checkuser-block-success' => '* $1 is a list of one or more usernames
* $2 is the number of usernames in $1.',
	'checkuser-search-form' => 'This message is a search form for the checkuser log.
* $1 is a drop down box with search types
* $2 is a text input field for the search pattern

See screenshot "[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Example log]".',
	'checkuser-search-submit' => 'Button label on log of CheckUser searches. See screenshot "[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Example log]".

{{Identical|Search}}',
	'checkuser-search-initiator' => 'This message is an option in an input box on the search form for the checkuser log.
It is parameter $1 in the message {{msg-mw|Checkuser-search-form}}.

See screenshot "[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Example log]".

Initiator means the CheckUser who checks someone\'s information.',
	'checkuser-search-target' => 'The target of the check. The user checked.',
	'checkuser-ipeditcount' => "This information is shown on the result page of [[mw:Extension:CheckUser#Basic_interface|Special:CheckUser]] (when doing the ''{{int:Checkuser-users}}'' check), next to the individual listed IPs. See screenshot \"Example user name check\".

\$1 is an estimate of the total number of edits from the respective IP (i.e. the number of edits by all users, not only by the requested user). As the comment in the code says: ''If we get some results, it helps to know if the IP in general has a lot more edits, e.g. “tip of the iceberg”…''",
	'checkuser-log-return' => 'Link label on log of CheckUser searches. See screenshot "[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Example log]".',
	'checkuser-limited' => 'A message shown above CheckUser results if the result list would be longer than the specified limit (5000 entries), and has been truncated.',
	'checkuser-log-userips' => 'This is an entry in the checkuser log when a checkuser checks from which IP addresses a user has edited.
* Parameter $1 is the user who did the check
* Parameter $2 is the user that was checked, with links to talk page, contributions, and block (like this: [[User:Username|Username]] ( [[User talk|Talk]] | [[Special:Contributions/Username|contribs]] | [[Special:Blockip|block]]) )

See screenshot "[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Example log]".',
	'checkuser-log-ipedits' => 'This is an entry in the checkuser log when a checkuser checks which edits have been done from an IP address.
* Parameter $1 is the user who did the check
* Parameter $2 is the IP address that was checked

See screenshot "[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Example log]".',
	'checkuser-log-ipusers' => 'This is an entry in the checkuser log when a checkuser checks which users have used an IP address.
*Parameter $1 is the user who did the check
*Parameter $2 is the IP address

See screenshot "[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Example log]".',
	'checkuser-log-ipedits-xff' => 'This is an entry in the checkuser log when a checkuser checks which edits have been done from an XFF IP address (XFF means X-Forwarded-For. Some providers use proxies to forward user requests. This effectively means anonymization of requests. To make the requesting user identifiable again, the original requesting IP is transmitted in a separate HTTP header, the XFF header.).
* Parameter $1 is the user who did the check
* Parameter $2 is the IP address that was checked

See screenshot "[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Example log]".',
	'checkuser-log-ipusers-xff' => 'This is an entry in the checkuser log when a checkuser checks which users have used an XFF IP address (XFF means X-Forwarded-For. Some providers use proxies to forward user requests. This effectively means anonymization of requests. To make the requesting user identifiable again, the original requesting IP is transmitted in a separate HTTP header, the XFF header.).
*Parameter $1 is the user who did the check
*Parameter $2 is the IP address

See screenshot "[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Example log]".',
	'checkuser-log-useredits' => "This is an entry in the checkuser log when a checkuser checks which edits have been done from an IP address.
:'''\$1:''' name of checkuser
:'''\$2:''' name of user whose edits were inspected

See screenshot \"[http://www.mediawiki.org/wiki/Extension:CheckUser#Basic_interface Example log]\".",
	'checkuser-autocreate-action' => 'Text of the event displayed in the CheckUser results, corresponding to the automatic creation of a new user account (by CentralAuth).',
	'checkuser-token-fail' => 'Error message shown when the CSRF token does not match the current session.',
);

/** Karelian (Karjala)
 * @author Flrn
 */
$messages['krl'] = array(
	'checkuser-search' => 'Ečindy',
	'checkuser-search-submit' => 'Ečči',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'checkuser-reason' => 'Kakano:',
	'checkuser-search' => 'Kumi',
	'checkuser-search-submit' => 'Kumi',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'checkuser-desc' => 'Subsidies gebruikers met die toepaslike toestemming om die vermoë om gebruikers se IP-adresse om seker te maak en ander inligting',
	'checkuser-logcase' => 'Die logboek soek-funksie is kassensitief.',
	'checkuser' => 'Kontroleer gebruiker',
	'checkuserlog' => 'Gaan gebruiker log',
	'checkuser-contribs' => 'kontroleer gebruiker se IP-adresse',
	'group-checkuser' => 'Kontroleer gebruikers',
	'group-checkuser-member' => 'kontrolegebruiker',
	'right-checkuser' => 'Besigtig gebruikers se IP-adresse en ander gegewens',
	'right-checkuser-log' => 'Bekyk die Check User log',
	'action-checkuser' => 'sien gebruikers se IP-adresse en ander inligting',
	'action-checkuser-log' => 'oog die Check User log',
	'grouppage-checkuser' => '{{ns:project}}:Kontrolegebruiker',
	'checkuser-reason' => 'Rede:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Wys logboek',
	'checkuser-query' => 'Navraag op onlangse wysigings',
	'checkuser-target' => 'IP-adres of gebruikersnaam:',
	'checkuser-users' => 'Kry gebruikers',
	'checkuser-edits' => 'Kry wysigings',
	'checkuser-ips' => 'Kry IPs',
	'checkuser-search' => 'Soek',
	'checkuser-period' => 'Duur:',
	'checkuser-week-1' => 'laaste week',
	'checkuser-week-2' => 'laaste twee weke',
	'checkuser-month' => 'laaste 30 dae',
	'checkuser-all' => 'alle',
	'checkuser-cidr-label' => "Vind gemeenskaplike omvang en geaffekteerde IP-adresse vir 'n lys van IP-adresse",
	'checkuser-cidr-res' => 'Gemeenskaplike CIDR:',
	'checkuser-empty' => 'Die logboek het geen inskrywings nie.',
	'checkuser-nomatch' => 'Geen resultate gevind.',
	'checkuser-nomatch-edits' => 'Niks gevind nie.
Die Laaste wysig was op $1 op $2.',
	'checkuser-check' => 'Kontroleer',
	'checkuser-log-fail' => 'Kan nie logboek inskrywing byvoeg nie',
	'checkuser-nolog' => 'Logboek lêer nie gevind.',
	'checkuser-blocked' => 'Versper',
	'checkuser-gblocked' => 'Globaal geblokkeer',
	'checkuser-locked' => 'Gesluit',
	'checkuser-wasblocked' => 'Vantevore geblokkeer gewees',
	'checkuser-localonly' => 'Nie verenig nie',
	'checkuser-massblock' => 'Blok geselekteerde gebruikers',
	'checkuser-massblock-text' => 'Geselekteerde rekeninge sal onbepaald geblokkeer, met autoblocking van IP-adresse aangeskakel en skep afgeskakel.
IP-adresse word vir een week geblokkeer word slegs vir anonieme gebruikers en rekening word afgeskakel.',
	'checkuser-blocktag' => 'Vervang gebruikersbladsye met:',
	'checkuser-blocktag-talk' => 'Vervang besprekingsbladsye met:',
	'checkuser-massblock-commit' => 'Blok geselekteerde gebruikers',
	'checkuser-block-success' => "'''Die {{PLURAL:$2|gebruiker|gebruikers}} $1 {{PLURAL:$2|is|is}} nou geblokkeer.'''",
	'checkuser-block-failure' => "'''Geen gebruikers geblokkeer nie.'''",
	'checkuser-block-limit' => 'Te veel gebruikers gekies.',
	'checkuser-block-noreason' => "U moet 'n rede vir die blokkades verskaf.",
	'checkuser-noreason' => "U moet 'n rede vir hierdie navraag verskaf.",
	'checkuser-accounts' => '$1 nuwe {{PLURAL:$1|gebruiker|gebruikers}}',
	'checkuser-too-many' => 'Te veel resultate (volgens skatting). Maak die IP-reeks kleiner.
Hieronder word die gebruikte IP-adresse weergegee (maksimum 5000, op IP-adres gesorteer):',
	'checkuser-user-nonexistent' => 'Die gespesifiseerde gebruiker bestaan nie.',
	'checkuser-search-form' => 'Vind logboekinskrywings waar $1 $2 is',
	'checkuser-search-submit' => 'Soek',
	'checkuser-search-initiator' => 'aanvraer',
	'checkuser-search-target' => 'teiken',
	'checkuser-ipeditcount' => '~$1 van alle gebruikers',
	'checkuser-log-return' => 'Terug na Check User belangrikste vorm',
	'checkuser-limited' => "'''Hierdie resultate is vir prestasieredes afgekap.'''",
	'checkuser-log-userips' => '$1 het die IP-adresse deur $2 opgevra',
	'checkuser-log-ipedits' => '$1 het die wysigings deur $2 opgevra',
	'checkuser-log-ipusers' => '$1 het die gebruikers vir $2 opgevra',
	'checkuser-log-ipedits-xff' => '$1 het die wysigings deur XFF $2 opgevra',
	'checkuser-log-ipusers-xff' => '$1 het die gebruikers van XFF $2 opgevra',
	'checkuser-log-useredits' => '$1 het die wysigings deur $2 aangevra',
	'checkuser-autocreate-action' => 'is outomaties geskep',
	'checkuser-create-action' => 'is geskep',
	'checkuser-email-action' => 'het \'n e-pos aan gebruiker "$1" gestuur',
	'checkuser-reset-action' => 'herstel gebruiker "$1" se wagwoord',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'checkuser-reason' => 'ምክንያት:',
	'checkuser-search' => 'ፍለጋ',
	'checkuser-all' => 'ሁሉ',
	'checkuser-search-submit' => 'ፍለጋ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'checkuser-summary' => "Ista aina repasa os zaguers cambeos ta mirar as IPs usatas por un usuario u amostrar as edicions y datos d'usuario ta una adreza IP. Os usuarios y edicions feitos por un cliente IP pueden trobar-se por meyo de cabeceras XFF adhibindo a IP con \"/xff\". Se da soporte a IPv4 (CIDR 16-32) y IPv6 (CIDR 64-128).
No s'otendrán más de 5000 edicions por razons de prestacions. Faiga servir ista aina d'alcuerdo con as politicas d'o procheuto.",
	'checkuser-desc' => "Concede a os usuarios con o premiso adecuau a capacidat ta comprebar as adrezas IP d'os usuarios y atras informacions",
	'checkuser-logcase' => 'En mirar os rechistros se fa destinción entre mayusclas y minusclas.',
	'checkuser' => "Comprebación d'usuarios",
	'checkuserlog' => "Rechistro de CheckUser (comprebación d'usuarios)",
	'group-checkuser' => "Comprebadors d'usuarios",
	'group-checkuser-member' => "Comprebador d'usuarios",
	'right-checkuser' => "Comprebar as adrezas IP de l'usuario y atras informacions",
	'right-checkuser-log' => "Veyer o rechistro de comprebación d'usuarios",
	'grouppage-checkuser' => "{{ns:project}}:comprebación d'usuarios",
	'checkuser-reason' => 'Razón:',
	'checkuser-showlog' => 'Amostrar o rechistro',
	'checkuser-query' => 'Mirar en os zaguers cambeos',
	'checkuser-target' => "Nombre d'usuario u adreza IP",
	'checkuser-users' => "Otener os nombres d'usuario",
	'checkuser-edits' => 'Obtener as edicions',
	'checkuser-ips' => 'Otener as adrezas IP',
	'checkuser-search' => 'Mirar',
	'checkuser-all' => 'tot',
	'checkuser-empty' => 'No bi ha garra elemento en o rechistro.',
	'checkuser-nomatch' => "No s'ha trobato garra concordancia",
	'checkuser-check' => 'Comprebar',
	'checkuser-log-fail' => "No s'ha puesto adhibir ista dentrada ta o rechistro",
	'checkuser-nolog' => "No s'ha trobato garra fichero de rechistro.",
	'checkuser-blocked' => 'Bloqueyato',
	'checkuser-too-many' => "Bi ha masiaus resultaus (seguntes a estimación d'a busca), cal que emplegue un CIDR más chicot. Aquí bi son as adrezas IP emplegatas (maximo 5000, ordenatas por  adreza):",
	'checkuser-user-nonexistent' => 'O usuario especificato no existe.',
	'checkuser-search-form' => "Trobar dentradas d'o rechistro an que o $1 sía $2",
	'checkuser-search-submit' => 'Mirar',
	'checkuser-search-initiator' => "o encetador d'a consulta",
	'checkuser-search-target' => 'obchectivo',
	'checkuser-ipeditcount' => '~$1 de totz os usuarios',
	'checkuser-log-return' => "Tornar ta o formulario prencipal de CheckUser (Comprebación d'usuarios)",
	'checkuser-log-userips' => '$1 ha consultato as adrezas IP de $2',
	'checkuser-log-ipedits' => '$1 ha consultato as edicions de $2',
	'checkuser-log-ipusers' => "$1 ha consultato os nombres d'usuario de $2",
	'checkuser-log-ipedits-xff' => "$1 ha consultato as edicions d'o XFF $2",
	'checkuser-log-ipusers-xff' => "$1 ha consultato os nombres d'usuario d'o XFF $2",
);

/** Old English (Ænglisc) */
$messages['ang'] = array(
	'checkuser-reason' => 'Racu:',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author AwamerT
 * @author Ciphers
 * @author Meno25
 * @author Mido
 * @author OsamaK
 */
$messages['ar'] = array(
	'checkuser-summary' => 'هذه الأداة تفحص أحدث التغييرات لاسترجاع الأيبيهات المستخدمة بواسطة مستخدم أو عرض بيانات التعديل/المستخدم لأيبي.
المستخدمون والتعديلات بواسطة أيبي عميل يمكن استرجاعها من خلال عناوين XFF عبر طرق الأيبي IP ب"/xff". IPv4 (CIDR 16-32) و IPv6 (CIDR 64-128) مدعومان.
	لا أكثر من 5000 تعديل سيتم عرضها لأسباب تتعلق بالأداء.
استخدم هذا بالتوافق مع السياسة.',
	'checkuser-desc' => 'يمنح المستخدمين بالسماح المطلوب القدرة على فحص عناوين الأيبي لمستخدم ما ومعلومات أخرى',
	'checkuser-logcase' => 'بحث السجل حساس لحالة الحروف.',
	'checkuser' => 'تدقيق مستخدم',
	'checkuserlog' => 'سجل تدقيق المستخدم',
	'checkuser-contribs' => 'افحص عناوين أيبي المستخدم',
	'group-checkuser' => 'مدققو مستخدم',
	'group-checkuser-member' => 'مدقق مستخدم',
	'right-checkuser' => 'افحص عناوين أيبي المستخدم والمعلومات الأخرى',
	'right-checkuser-log' => 'رؤية سجل تدقيق المستخدم',
	'grouppage-checkuser' => '{{ns:project}}:تدقيق مستخدم',
	'checkuser-reason' => 'السبب:',
	'checkuser-reason-api' => 'واجهة برمجة التطبيقات',
	'checkuser-showlog' => 'عرض السجل',
	'checkuser-query' => 'فحص أحدث التغييرات',
	'checkuser-target' => 'عنوان الأيبي أو اسم المستخدم:',
	'checkuser-users' => 'اعرض المستخدمين',
	'checkuser-edits' => 'الحصول على التعديلات',
	'checkuser-ips' => 'اعرض الأيبيهات',
	'checkuser-search' => 'ابحث',
	'checkuser-period' => 'المدة:',
	'checkuser-week-1' => 'آخر أسبوع',
	'checkuser-week-2' => 'آخر أسبوعين',
	'checkuser-month' => 'آخر 30 يوم',
	'checkuser-all' => 'الكل',
	'checkuser-cidr-label' => 'جد النطاق المشترك والعناوين المتأثرة لقائمة من الأيبيهات',
	'checkuser-cidr-res' => 'CIDR مشترك:',
	'checkuser-empty' => 'لا توجد مدخلات في السجل.',
	'checkuser-nomatch' => 'لم يتم العثور على مدخلات مطابقة.',
	'checkuser-nomatch-edits' => 'لا تطابق تم العثور عليه.
آخر تعديل كان في $1 الساعة $2.',
	'checkuser-check' => 'فحص',
	'checkuser-log-fail' => 'غير قادر على إضافة مدخلة للسجل',
	'checkuser-nolog' => 'لم يتم العثور على ملف سجل.',
	'checkuser-blocked' => 'ممنوع',
	'checkuser-gblocked' => 'ممنوع منعا عاما',
	'checkuser-locked' => 'مغلق',
	'checkuser-wasblocked' => 'تم منعه مسبقا',
	'checkuser-localonly' => 'غير موحد',
	'checkuser-massblock' => 'امنع المستخدمين المختارين',
	'checkuser-massblock-text' => 'الحسابات المختارة سيتم منعها لا نهائيا، مع تفعيل المنع التلقائي وتعطيل إنشاء الحسابات.
عناوين الأيبي سيتم منعها لمدة 1 أسبوع لمستخدمي الأيبي فقط ومع تعطيل إنشاء الحسابات.',
	'checkuser-blocktag' => 'استبدل صفحات المستخدمين ب:',
	'checkuser-blocktag-talk' => 'استبدل صفحات النقاش ب:',
	'checkuser-massblock-commit' => 'منع المستخدمين المختارين',
	'checkuser-block-success' => "'''{{PLURAL:$2|المستخدم|المستخدمون}} $1 الآن {{PLURAL:$2|ممنوع|ممنوعون}}.'''",
	'checkuser-block-failure' => "'''لا مستخدمون تم منعهم.'''",
	'checkuser-block-limit' => 'تم اختيار عدد كبير من المستخدمين.',
	'checkuser-block-noreason' => 'يجب أن تعطي سببا لعمليات المنع.',
	'checkuser-noreason' => 'يجب أن تقدم سببًا لهذا الاستعلام.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|حساب|حساب}} جديد',
	'checkuser-too-many' => 'نتائج كثيرة جدا (بناء على استعلام تقريبي)، من فضلك قلل CIDR.
هذه هي الأيبيهات المستخدمة (5000 كحد أقصى، مرتبة بالعنوان):',
	'checkuser-user-nonexistent' => 'المستخدم المحدد غير موجود.',
	'checkuser-search-form' => 'اعثر على مدخلات السجل حيث $1 هو $2',
	'checkuser-search-submit' => 'ابحث',
	'checkuser-search-initiator' => 'بادىء',
	'checkuser-search-target' => 'هدف',
	'checkuser-ipeditcount' => '~$1 من كل المستخدمين',
	'checkuser-log-return' => 'ارجع إلى استمارة تدقيق المستخدم الرئيسية',
	'checkuser-limited' => "'''هذه النتائج تم اختصارها لأسباب تتعلق بالأداء.'''",
	'checkuser-log-userips' => '$1 حصل على آيبيهات $2',
	'checkuser-log-ipedits' => '$1 حصل على التعديلات ل $2',
	'checkuser-log-ipusers' => '$1 حصل على مستخدمي $2',
	'checkuser-log-ipedits-xff' => '$1 حصل على التعديلات للإكس إف إف $2',
	'checkuser-log-ipusers-xff' => '$1 حصل على المستخدمين للإكس إف إف $2',
	'checkuser-log-useredits' => '$1 حصل على تعديلات $2',
	'checkuser-autocreate-action' => 'تم إنشاؤه تلقائيا',
	'checkuser-create-action' => 'تم إنشاؤه',
	'checkuser-email-action' => 'أرسل بريدا إلكترونيا إلى "$1"',
	'checkuser-reset-action' => 'أعد ضبط كلمة السر للمستخدم "$1"',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author 334a
 * @author Basharh
 */
$messages['arc'] = array(
	'checkuser-reason' => 'ܥܠܬܐ:',
	'checkuser-showlog' => 'ܚܘܝ ܣܓܠܐ',
	'checkuser-search' => 'ܒܨܝܐ',
	'checkuser-week-1' => 'ܫܒܘܥܐ ܐܚܪܝܐ',
	'checkuser-week-2' => 'ܬܪܝܢ ܫܒܘܥ̈ܐ ܐܚܪ̈ܝܐ',
	'checkuser-month' => 'ܬܠܬܝܢ ܝܘܡܬ̈ܐ ܐܚܪ̈ܝܐ',
	'checkuser-all' => 'ܟܠ',
	'checkuser-blocked' => 'ܚܪܝܡܐ',
	'checkuser-locked' => 'ܩܦܝܠܐ',
	'checkuser-search-submit' => 'ܒܨܝܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'checkuser-summary' => 'الوسيلة دى بتدور فى احدث التغييرات علشان ترجع الايبيهات اللى استعملها يوزر او علشان تعرض بيانات التعديل/اليوزر لعنوان الاى بى.
اليوزرز و التعديلات اللى اتعملت من أى بى عميل ممكن تترجع عن طريق عناوين XFF لو زودت على الاى بى "/xff".
IPv4 (CIDR 16-32) و IPv6 (CIDR 64-128) مدعومين.
مش اكتر من 5000 تعديل ممكن تتعرض بسبب الاداء.
استخدم دا بطريقة موافقة للسياسة.',
	'checkuser-desc' => 'بيدى لليوزرز بعد الاذن المناسب القدرة على التشييك على  عنوان الاى بى بتاع اى يوزر و معلومات تانية',
	'checkuser-logcase' => 'التدوير فى السجل حساس لحالة الحروف',
	'checkuser' => 'التشييك على اليوزر',
	'checkuserlog' => 'سجل تشييك اليوزر',
	'group-checkuser' => 'التشييك على اليوزرز',
	'group-checkuser-member' => 'تشييك اليوزر',
	'right-checkuser' => 'التشييك على عناوين الاى بى لليوزرز و معلومات تانية',
	'right-checkuser-log' => 'اعرض السجل بتاع تشييك اليوزر',
	'grouppage-checkuser' => '{{ns:project}}:تشييك اليوزر',
	'checkuser-reason' => 'السبب:',
	'checkuser-showlog' => 'عرض السجل',
	'checkuser-query' => 'دور على احدث التغييرات',
	'checkuser-target' => 'اى بى او يوزر:',
	'checkuser-users' => 'هات اليوزرز',
	'checkuser-edits' => 'هات التعديلات من الاى بي',
	'checkuser-ips' => 'هات الايبيهات',
	'checkuser-search' => 'تدوير',
	'checkuser-period' => 'المدة:',
	'checkuser-week-1' => 'الاسبوع اللى فات',
	'checkuser-week-2' => 'الاسبوعين اللى فاتو',
	'checkuser-month' => 'الـ30 يوم اللى فاتو',
	'checkuser-all' => 'الكل',
	'checkuser-cidr-label' => 'لاقى النطاق المشترك و العنواين المتأثره لليستة الايبيهات.',
	'checkuser-cidr-res' => 'CIDR مشترك:',
	'checkuser-empty' => 'مافيش حاجة فى السجل.',
	'checkuser-nomatch' => 'مافيش اى حاجة متطابقة',
	'checkuser-nomatch-edits' => 'لا تطابق تم العثور عليه.
آخر تعديل كان فى $1 الساعة $2.',
	'checkuser-check' => 'فحص',
	'checkuser-log-fail' => 'مش قادر يضيف مدخلة للسجل',
	'checkuser-nolog' => 'سجل الملف ماتلقاش.',
	'checkuser-blocked' => 'ممنوع',
	'checkuser-gblocked' => 'ممنوع منعا عاما',
	'checkuser-locked' => 'مغلق',
	'checkuser-wasblocked' => 'اتمنع قبل كدا',
	'checkuser-localonly' => 'مش متوحد',
	'checkuser-massblock' => 'امنع اليوزرز اللى اخترتهم.',
	'checkuser-massblock-text' => 'الحسابات اللى انت اختارتها ح يتمنعو على طول،مش ح يقدرو يفتحو حسابات و ح يتمنعو اوتوماتيكى.
عناوين الاى بى ح تتمنع لمدة اسبوع واحد بالنسبة للى بيستعملو الاى بى و مش ح يقدرو يفتحو حسابات.',
	'checkuser-blocktag' => 'بدل صفحات اليوزرز بـ:',
	'checkuser-blocktag-talk' => 'بدل صفحة النقاش ب',
	'checkuser-massblock-commit' => 'امنع اليوزرز اللى اخترتهم',
	'checkuser-block-success' => "'''الـ {{PLURAL:$2|يوزر|يوزرز}} $1 {{PLURAL:$2|بقى ممنوع|بقو ممنوعين}} دلوقتى.'''",
	'checkuser-block-failure' => "'''مافيش يوزرز ممنوعين'''",
	'checkuser-block-limit' => 'انت اخترت يوزرز كتار جدا.',
	'checkuser-block-noreason' => 'لازم تدى سبب لعمليات المنع.',
	'checkuser-accounts' => '$1 جديد {{PLURAL:$1|حساب|حسابات}}',
	'checkuser-too-many' => 'فى نتايج كتيرة جدا, لو سمحت تقلل الـ CIDR.
دول الايبيهات المستعملة (5000 كحد اقصى, مترتبين بالعنوان):',
	'checkuser-user-nonexistent' => 'اليوزر المتحدد مش موجود',
	'checkuser-search-form' => 'لاقى مدخلات السجل لما يكون $1 هو $2',
	'checkuser-search-submit' => 'تدوير',
	'checkuser-search-initiator' => 'البادي',
	'checkuser-search-target' => 'هدف',
	'checkuser-ipeditcount' => '~$1 من كل اليوزرز',
	'checkuser-log-return' => 'ارجع للاستمارة الرئيسية بتاعة تشييك اليوزرز',
	'checkuser-limited' => "''' النتايج دى اتعملها اختصار لأسباب متعلقة  بالأداء.'''",
	'checkuser-log-userips' => '$1 جاب الاى بى بتوع $2',
	'checkuser-log-ipedits' => '$1 جاب التعديلات بتاعة $2',
	'checkuser-log-ipusers' => '$1 جاب اليوزرز بتوع $2',
	'checkuser-log-ipedits-xff' => '$1 جاب التعديلات للإكس إف إف $2',
	'checkuser-log-ipusers-xff' => '$1 جاب اليوزرز  لل اكس اف اف بتوع $2',
	'checkuser-log-useredits' => '$1 جاب التعديلات بتاعة$2',
	'checkuser-autocreate-action' => 'ابتدا اوتوماتيكى',
	'checkuser-email-action' => 'ابعت ايميل لليوزر "$1"',
	'checkuser-reset-action' => 'اضبط من تانى الباسورد بتاعة اليوزر "$1"',
);

/** Assamese (অসমীয়া)
 * @author Chaipau
 */
$messages['as'] = array(
	'checkuser-search' => 'সন্ধান কৰক',
	'checkuser-search-submit' => 'সন্ধান কৰক',
);

/** Asturian (Asturianu)
 * @author Dferg
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'checkuser-summary' => "Esta ferramienta escanea los cambeos recientes pa obtener les IP usaes por un usuariu o p'amosar les ediciones o usuarios d'una IP.
	Los usuarios y ediciones correspondientes a una IP puen obtenese per aciu de les cabeceres XFF añadiendo depués de la IP \\\"/xff\\\". Puen usase los protocolos IPv4 (CIDR 16-32) y IPv6 (CIDR 64-128).
	Por razones de rendimientu nun s'amosarán más de 5.000 ediciones. Emplega esta ferramienta  acordies cola política d'usu.",
	'checkuser-desc' => "Permite a los usuarios colos permisos afechiscos la posibilidá de comprobar les direiciones IP d'usuarios y otres informaciones",
	'checkuser-logcase' => 'La busca nel rexistru distingue ente mayúscules y minúscules.',
	'checkuser' => "Comprobador d'usuariu",
	'checkuserlog' => "Rexistru de comprobadores d'usuariu",
	'checkuser-contribs' => 'verificar IP del usuariu',
	'group-checkuser' => "Comprobadores d'usuariu",
	'group-checkuser-member' => 'comprobar {{GENDER:$1|usuariu|usuaria}}',
	'right-checkuser' => "Comprueba les direiciones IP d'un usuariu entre otres coses",
	'right-checkuser-log' => "Ver el rexistru de comprobación d'usuarios",
	'action-checkuser' => "comprueba les direiciones IP d'un usuariu y otra información",
	'action-checkuser-log' => "ver el rexistru de comprobación d'usuarios",
	'grouppage-checkuser' => "{{ns:project}}:Comprobador d'usuariu",
	'checkuser-reason' => 'Motivu:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Amosar el rexistru',
	'checkuser-query' => 'Buscar nos cambeos recientes',
	'checkuser-target' => 'IP o usuariu:',
	'checkuser-users' => 'Obtener usuarios',
	'checkuser-edits' => 'Obtener les ediciones',
	'checkuser-ips' => 'Obtener les IP',
	'checkuser-search' => 'Guetar',
	'checkuser-period' => 'Duración:',
	'checkuser-week-1' => 'cabera selmana',
	'checkuser-week-2' => 'caberes dos selmanes',
	'checkuser-month' => 'caberos 30 díes',
	'checkuser-all' => 'too',
	'checkuser-cidr-label' => "Alcontrar el rangu común y les direiciones IP afeutaes d'una llista de direiciones IP",
	'checkuser-cidr-res' => 'CIDR común:',
	'checkuser-empty' => 'El rexistru nun tien nengún elementu.',
	'checkuser-nomatch' => "Nun s'atoparon coincidencies.",
	'checkuser-nomatch-edits' => "Nun s'atoparon coincidencies. 
La cabera edición foi en $1 a $2",
	'checkuser-check' => 'Comprobar',
	'checkuser-log-fail' => 'Nun se pue añader la entrada nel rexistru',
	'checkuser-nolog' => "Nun s'atopó l'archivu del rexistru.",
	'checkuser-blocked' => 'Bloquiáu',
	'checkuser-gblocked' => 'Bloquiáu globalmente',
	'checkuser-locked' => 'Candáu',
	'checkuser-wasblocked' => 'Bloquiáu previamente',
	'checkuser-localonly' => 'Non unificada',
	'checkuser-massblock' => 'Bloquias usuarios seleicionaos',
	'checkuser-massblock-text' => 'Les cuentes seleicionaes van se bloquiaes de forma indefinida, col autobloquéu activáu y la creación de cuentes desactivada.
Les direiciones IP van ser bloquiaes 1 selmana namái pa usuarios IP y cola creación de cuentes desactivada.',
	'checkuser-blocktag' => "Sustituyir páxines d'usuariu con:",
	'checkuser-blocktag-talk' => "Sustituyir páxines d'alderique con:",
	'checkuser-massblock-commit' => 'Bloquiar usuarios seleicionaos',
	'checkuser-block-success' => "'''{{PLURAL:$2|L'usuariu|Los usuarios}} $1 yá {{PLURAL:$2|ta bloquiáu.|tán bloquiaos.}}'''",
	'checkuser-block-failure' => "'''Nengún usuariu bloquiáu.'''",
	'checkuser-block-limit' => 'Demasiaos usuarios seleicionaos.',
	'checkuser-block-noreason' => 'Tienes que dar un motivu pa los bloqueos.',
	'checkuser-noreason' => 'Tien de dar un motivu pa esta consulta.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|cuenta nueva|cuentes nueves}}',
	'checkuser-too-many' => "Demasiaos resultaos (d'alcuerdu col albidru de consulta), mengua la CIDR.
Estes son les IPs usaes (5000 max, axeitaes por direición):",
	'checkuser-user-nonexistent' => "L'usuariu especificáu nun esiste.",
	'checkuser-search-form' => 'Atopar les entraes de rexistru onde $1 ye $2',
	'checkuser-search-submit' => 'Guetar',
	'checkuser-search-initiator' => 'aniciador',
	'checkuser-search-target' => 'oxetivu',
	'checkuser-ipeditcount' => '~$1 de tolos usuarios',
	'checkuser-log-return' => "Volver al formulariu principal de comprobador d'usuariu",
	'checkuser-limited' => "'''Estos resultaos fueron truncaos por motivos de rendimientu.'''",
	'checkuser-log-userips' => '$1 obtuvo les IP pa $2',
	'checkuser-log-ipedits' => '$1 obtuvo les ediciones pa $2',
	'checkuser-log-ipusers' => '$1 obtuvo los usuarios pa $2',
	'checkuser-log-ipedits-xff' => '$1 obtuvo les ediciones pa XFF $2',
	'checkuser-log-ipusers-xff' => '$1 obtuvo los usuarios pa XFF $2',
	'checkuser-log-useredits' => '$1 obtuvo les ediciones de $2',
	'checkuser-autocreate-action' => 'creóse automáticamente',
	'checkuser-create-action' => 'se creó',
	'checkuser-email-action' => 'unvió un corréu electrónicu a "$1"',
	'checkuser-reset-action' => 'reestableció la conseña del usuariu «$1»',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'checkuser' => 'Stujera va favesik',
	'group-checkuser' => 'Stujera va favesik',
	'group-checkuser-member' => 'Stujera va favesik',
	'grouppage-checkuser' => '{{ns:project}}:Stujera va favesik',
	'checkuser-reason' => 'Lazava :',
	'checkuser-showlog' => 'Nedira va "log"',
	'checkuser-target' => 'Favesik ok IP mane',
	'checkuser-search' => 'Aneyara',
	'checkuser-empty' => '"Log" iyeltak tir vlardaf.',
	'checkuser-nomatch' => 'Nedoy trasiks',
	'checkuser-check' => 'Stujera',
	'checkuser-nolog' => 'Mek trasiyin "log" iyeltak.',
	'checkuser-blocked' => 'Elekan',
	'checkuser-search-submit' => 'Aneyara',
	'checkuser-search-target' => 'jala',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Emperyan
 * @author PPerviz
 * @author Vago
 * @author Vugar 1981
 */
$messages['az'] = array(
	'checkuser' => 'Təftişçi',
	'checkuserlog' => 'Təftişçi qeydi',
	'group-checkuser' => 'Təftişçilər',
	'grouppage-checkuser' => '{{ns:project}}:Təftişçi',
	'checkuser-reason' => 'Səbəb:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-search' => 'Axtar',
	'checkuser-period' => 'Müddəti:',
	'checkuser-week-1' => 'Son həftə',
	'checkuser-week-2' => 'son iki həftə',
	'checkuser-month' => 'son 30 gün',
	'checkuser-all' => 'bütün',
	'checkuser-check' => 'Yoxla',
	'checkuser-log-fail' => 'Gündəlik girdilər əlavə etilemiyor.',
	'checkuser-blocked' => 'Bloklanmış',
	'checkuser-gblocked' => 'Qlobal bloklanmış',
	'checkuser-locked' => 'Bloklanıb',
	'checkuser-search-submit' => 'Axtar',
	'checkuser-create-action' => 'yaradılıb',
);

/** Bashkir (Башҡортса)
 * @author Assele
 * @author Haqmar
 */
$messages['ba'] = array(
	'checkuser-summary' => 'Был ҡорал ҡатнашыусы тарафынан ҡулланылған IP адрестарҙы алыр өсөн йәки IP адрестан эшләнгән үҙгәртеүҙәрҙе/ҡатнашыусыларҙы ҡарар өсөн ҡулланыла ала.
IP адрестан эшләнгән үҙгәртеүҙәр һәм ҡатнашыусылар күрһәтелгән XFF-башлыҡтар аша, IP адрестан һуң "/xff" өҫтәп, алына ала. IPv4 (CIDR 16-32) һәм IPv6 (CIDR 64-128) ҡулланыла ала.
Етештереүсәнлек маҡсаттарында тәүге 5000 үҙгәртеү генә күрһәтеләсәк.
Был ҡоралды ҡағиҙәләргә ярашлы ҡулланығыҙ.',
	'checkuser-desc' => 'Ҡатнашыусыларҙың IP адрестарын һәм башҡа мәғлүмәтте тикшереү хоҡуғын  ҡатнашыусыларға бирә',
	'checkuser-logcase' => 'Журнал яҙмаларында эҙләү ҙур/бәләкәй хәрефкә һиҙгер.',
	'checkuser' => 'Ҡулланыусыны тикшер',
	'checkuserlog' => 'Ҡулланыусыларҙы тикшереү журналы',
	'checkuser-contribs' => 'Ҡулланыусынын IP адресын тикшерергә',
	'group-checkuser' => 'Ҡулланыусыларҙы тикшереүселәр',
	'group-checkuser-member' => 'Ҡулланыусыларҙы тикшереүсе',
	'right-checkuser' => 'Ҡулланыусыларҙың IP адрестарын һәм башҡа мәғлүмәттәрен тикшереү',
	'right-checkuser-log' => 'Ҡулланыусыларҙы тикшереү журналын ҡарау',
	'grouppage-checkuser' => '{{ns:project}}:Ҡулланыусыларҙы тикшереү',
	'checkuser-reason' => 'Сәбәп:',
	'checkuser-showlog' => 'Журналды күрһәт',
	'checkuser-query' => 'Һуңғы үҙгәрештәрҙе һоратырға',
	'checkuser-target' => 'Ҡулланыусының IP-адресы йәки исеме:',
	'checkuser-users' => 'Ҡулланыусыларҙы килтер',
	'checkuser-edits' => 'Төҙәтеүҙәрҙе алырға',
	'checkuser-ips' => 'IP-адрестарҙы килтер',
	'checkuser-search' => 'Эҙләү',
	'checkuser-period' => 'Оҙайлыҡ:',
	'checkuser-week-1' => 'һуңғы аҙна',
	'checkuser-week-2' => 'һуңғы ике аҙна',
	'checkuser-month' => 'һуңғы 30 көн',
	'checkuser-all' => 'барыһы',
	'checkuser-cidr-label' => 'IP исемлеге өсөн уртаҡ арауыҡты һәм йоғонто яһалған адрестарҙы табырға',
	'checkuser-cidr-res' => 'Уртаҡ CIDR:',
	'checkuser-empty' => 'Журнал буш.',
	'checkuser-nomatch' => 'Тап килеүҙәр табылманы.',
	'checkuser-nomatch-edits' => 'Тап килгәндәр юҡ.
Һуңғы төҙәтеү ваҡыты: $1 $2.',
	'checkuser-check' => 'Тикшерергә',
	'checkuser-log-fail' => 'Журналға яҙыу өҫтәп булмай',
	'checkuser-nolog' => 'Журнал файлы табылманы',
	'checkuser-blocked' => 'Бикле',
	'checkuser-gblocked' => 'Глобаль кимәлдә бикле',
	'checkuser-locked' => 'Бикле',
	'checkuser-wasblocked' => 'Элек бикләнгән',
	'checkuser-localonly' => 'Глобаль түгел',
	'checkuser-massblock' => 'Һайланған ҡулланыусыларҙы бикләргә',
	'checkuser-massblock-text' => 'Һайланған иҫәп яҙмалары сикләнмәгән ваҡытҡа IP адрестарҙы автоматик рәүештә бикләү һәм яңы иҫәп яҙмаһын булдырыуҙы тыйыу менән бикләнәсәк.
IP адрестар танылмаған ҡатнашыусылар өсөн 1 айға бикләнәсәк, яңы иҫәп яҙмаһын булдырыу тыйыласаҡ.',
	'checkuser-blocktag' => 'Ҡатнашыусыларҙың битен ошоға алыштырырға:',
	'checkuser-blocktag-talk' => 'Фекер алышыу биттәрен ошоға алыштырырға:',
	'checkuser-massblock-commit' => 'Һайланған ҡулланыусыларҙы бикләргә',
	'checkuser-block-success' => "'''Әлеге ваҡытта $1 {{PLURAL:$2|ҡулланыусы}} бикләнгән.'''",
	'checkuser-block-failure' => "'''Бикләнгән ҡулланыусы юҡ.'''",
	'checkuser-block-limit' => 'Бигерәк күп ҡатнашыусы һайланған.',
	'checkuser-block-noreason' => 'Һеҙ бикләүҙең сәбәбен күрһәтергә тейешһегеҙ.',
	'checkuser-noreason' => 'Һеҙ был һорауҙың сәбәбен күрһәтергә тейешһегеҙ.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|яңы иҫәп яҙмаһы}}',
	'checkuser-too-many' => 'Бигерәк күп һөҙөмтә (һорауҙы баһалау быйынса), зинһар, CIDR-ҙы тарайтығыҙ.
Ҡулланылған IP адрестар (иң күбе — 5000, адрестары буйынса тәртипкә килтерелгән):',
	'checkuser-user-nonexistent' => 'Күрһәтелгән ҡатнашыусы юк.',
	'checkuser-search-form' => '$1 — $2 булған яҙмаларҙы табырға',
	'checkuser-search-submit' => 'Эҙләү',
	'checkuser-search-initiator' => 'башлаусы',
	'checkuser-search-target' => 'маҡсат',
	'checkuser-ipeditcount' => 'бөтә ҡатнашыусыларҙан ~$1',
	'checkuser-log-return' => 'Ҡатнашыусыларҙы тикшереү битенә кире ҡайтырға',
	'checkuser-limited' => "'''Һөҙөмтәләр етештереүсәнлек маҡсаттарында киҫелде.'''",
	'checkuser-log-userips' => '$1 $2 өсөн IP адрестар алған',
	'checkuser-log-ipedits' => '$1 $2 адресы өсөн үҙгәртеүҙәр алған',
	'checkuser-log-ipusers' => '$1 $2 адресы өсөн ҡатнашыусыларҙы алған',
	'checkuser-log-ipedits-xff' => '$1 XFF $2 өсөн үҙгәртеүҙәр алған',
	'checkuser-log-ipusers-xff' => '$1 XFF $2 өсөн ҡатнашыусыларҙы алған',
	'checkuser-log-useredits' => '$1 $2 өсөн үҙгәртеүҙәр алған',
	'checkuser-autocreate-action' => 'үҙенән-үҙе булдырылған',
	'checkuser-email-action' => '"$1" ҡатнашыусыһына электрон хат ебәргән',
	'checkuser-reset-action' => '"$1" ҡатнашыусыһының паролен үҙгәртергә',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'checkuser-desc' => 'کاربرانء اجازت دن  گون مناسبین اجازت آدرسان آی پی یک کاربری و دگه اطلاعاتء کنترل بکنت',
	'checkuser-logcase' => 'گردگ ته آمار به الفبای هورد و مزنین حساسنت.',
	'checkuser' => 'کنترل کاربر',
	'checkuserlog' => 'آمار کنترل کاربر',
	'group-checkuser' => 'کنترل کابران',
	'group-checkuser-member' => 'کنترل کاربر',
	'right-checkuser' => 'کنترل کن آی پی کاربران و دگه اطلاعاتء',
	'grouppage-checkuser' => '{{ns:project}}:کنترل کاربر',
	'checkuser-reason' => 'دلیل:',
	'checkuser-showlog' => 'آمار پیش دار',
	'checkuser-query' => 'درخواست نوکین تغییرات',
	'checkuser-target' => 'کاربر یا آی پی',
	'checkuser-users' => 'بگر کابرانء',
	'checkuser-edits' => 'چه آی پی آن اصلاح بگر',
	'checkuser-ips' => 'آی پی آن گر',
	'checkuser-search' => 'گردگ',
	'checkuser-empty' => 'آمار شمال هچ آیتمی نهنت.',
	'checkuser-nomatch' => 'هچ همدابی در نکپت',
	'checkuser-check' => 'کنترل',
	'checkuser-log-fail' => 'نه تونی ورودی آمار اضافه کنت',
	'checkuser-nolog' => 'فایل آماری در نه کپت',
	'checkuser-blocked' => 'محدود',
	'checkuser-too-many' => 'بازگین نتیجه, لطفا CIDR هورد تر کن.
ادان آی پی آنی هستند که استفاده کننت(5000 ماکسیمم، گون آدرس ردیف بوتگن):',
	'checkuser-user-nonexistent' => 'مشخص بوتگین کاربر موجود نهنت',
	'checkuser-search-form' => 'دیرگیز آمار ورودی جاهی که  $1 هست  $2',
	'checkuser-search-submit' => 'گردگ',
	'checkuser-search-initiator' => 'شروع کنوک',
	'checkuser-search-target' => 'هدف',
	'checkuser-ipeditcount' => '~$1 چه کلی کابران',
	'checkuser-log-return' => 'په فرم اصلی کنترل کاربر تر',
	'checkuser-log-userips' => '$1 گریت آی پی په $2',
	'checkuser-log-ipedits' => '$1 گریت اصلاح په  $2',
	'checkuser-log-ipusers' => '$1 کابران گریت په $2',
	'checkuser-log-ipedits-xff' => '$1 اصلاح کنت په XFF $2',
	'checkuser-log-ipusers-xff' => '$1 گریت کابران په XFF $2',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'checkuser-reason' => 'Rason:',
	'checkuser-showlog' => 'Ipahiling an mga historial',
	'checkuser-target' => 'Parágamit o IP',
	'checkuser-users' => 'Kûanón',
	'checkuser-ips' => 'Kûanón an mga IP',
	'checkuser-search' => 'Hanápon',
	'checkuser-blocked' => 'Pigbágat',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'checkuser-reason' => 'Прычына:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'checkuser-summary' => 'Гэты інструмэнт праглядае апошнія зьмены для атрыманьня ІР-адрасоў удзельніка альбо паказвае рэдагаваньні/зьвесткі ўдзельніка па ІР-адрасе.
Удзельнікі і рэдагаваньні, якія рабіліся з ІР-адрасу, пазначаным ў загалоўках XFF, можна атрымаць, дадаўшы да ІР-адрасу «/xff». Падтрымліваюцца IPv4 (CIDR 16-32) і IPv6 (CIDR 64-128).
З прычыны прадукцыйнасьці будуць паказаны ня больш за 5000 рэдагаваньняў.
Карыстайцеся гэтым інструмэнтам толькі згодна з правіламі.',
	'checkuser-desc' => 'Дае магчымасьць удзельнікам з адпаведнымі правамі правяраць ІР-адрасы і іншую інфармацыю ўдзельнікаў',
	'checkuser-logcase' => 'Пошук па журнале адчувальны да рэгістру літараў.',
	'checkuser' => 'Праверыць удзельніка',
	'checkuserlog' => 'Журнал праверак удзельнікаў',
	'checkuser-contribs' => 'праверыць IP-адрасы ўдзельніка',
	'group-checkuser' => 'Правяраючыя ўдзельнікаў',
	'group-checkuser-member' => '{{GENDER:$1|правяраючы|правяраючая}} ўдзельнікаў',
	'right-checkuser' => 'Праверка ІР-адрасоў і іншай інфармацыі ўдзельніка',
	'right-checkuser-log' => 'Прагляд журнала праверкі ўдзельнікаў',
	'action-checkuser' => 'праверку ІР-адрасоў і іншай інфармацыі ўдзельніка',
	'action-checkuser-log' => 'прагляд журнала праверкі ўдзельнікаў',
	'grouppage-checkuser' => '{{ns:project}}:Праверка ўдзельнікаў',
	'checkuser-reason' => 'Прычына:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Паказаць журнал',
	'checkuser-query' => 'Запытаць апошнія зьмены',
	'checkuser-target' => 'IP-адрас альбо рахунак удзельніка:',
	'checkuser-users' => 'Атрымаць рахункі ўдзельнікаў',
	'checkuser-edits' => 'Атрымаць рэдагаваньні',
	'checkuser-ips' => 'Атрымаць IP-адрасы',
	'checkuser-search' => 'Шукаць',
	'checkuser-period' => 'Працягласьць:',
	'checkuser-week-1' => 'апошні тыдзень',
	'checkuser-week-2' => 'апошнія два тыдні',
	'checkuser-month' => 'апошнія 30 дзён',
	'checkuser-all' => 'усе',
	'checkuser-cidr-label' => 'Знайсьці агульны дыяпазон і зьвязаныя адрасы па сьпісе ІР-адрасоў',
	'checkuser-cidr-res' => 'Агульны CIDR:',
	'checkuser-empty' => 'Журнал ня ўтрымлівае запісаў.',
	'checkuser-nomatch' => 'Супадзеньні ня знойдзеныя.',
	'checkuser-nomatch-edits' => 'Супадзеньняў ня знойдзена.
Апошняе рэдагаваньне зроблена $1 у $2.',
	'checkuser-check' => 'Праверыць',
	'checkuser-log-fail' => 'Немагчыма дадаць запіс у журнал',
	'checkuser-nolog' => 'Ня знойдзены файл журнала.',
	'checkuser-blocked' => 'Заблякаваны',
	'checkuser-gblocked' => 'Заблякаваны глябальна',
	'checkuser-locked' => 'Заблякаваны',
	'checkuser-wasblocked' => 'Заблякаваны раней',
	'checkuser-localonly' => "Не аб'яднаны",
	'checkuser-massblock' => 'Заблякаваць выбраныя рахункі ўдзельнікаў',
	'checkuser-massblock-text' => 'Выбраныя рахункі будуць заблякаваны назаўсёды з аўтаматычным блякаваньнем і забаронай стварэньня новых рахункаў.
ІР-адрасы будуць заблякаваныя на 1 тыдзень для незарэгістраваных удзельнікаў з забаронай стварэньня новых рахункаў.',
	'checkuser-blocktag' => 'Замяніць старонкі ўдзельнікаў на:',
	'checkuser-blocktag-talk' => 'Замяніць старонкі гутарак удзельнікаў на:',
	'checkuser-massblock-commit' => 'Заблякаваць выбраныя рахункі ўдзельнікаў',
	'checkuser-block-success' => "'''Цяпер $2 {{PLURAL:$2|рахунак удзельніка|рахункі удзельнікаў|рахункаў удзельнікаў}} $1 {{PLURAL:$2|заблякаваны|заблякаваныя|заблякаваныя}}.'''",
	'checkuser-block-failure' => "'''Няма заблякаваных рахункаў удзельнікаў.'''",
	'checkuser-block-limit' => 'Выбрана зашмат рахункаў удзельнікаў.',
	'checkuser-block-noreason' => 'Вам неабходна пазначыць прычыну блякаваньня.',
	'checkuser-noreason' => 'Вам неабходна падаць прычыну гэтага запыту.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|новы рахунак|новыя рахункі|новых рахункаў}}',
	'checkuser-too-many' => 'Зашмат вынікаў (згодна з адзнакай запыту), калі ласка, абмяжуйце CIDR.
Тут пададзеныя ўжытыя ІР-адрасы (максымум 5000, адсартаваныя паводле адрасу):',
	'checkuser-user-nonexistent' => 'Пазначанага рахунку ўдзельніка не існуе.',
	'checkuser-search-form' => 'Пошук запісаў у журнале, дзе $1 зьяўляецца $2',
	'checkuser-search-submit' => 'Шукаць',
	'checkuser-search-initiator' => 'ініцыятар',
	'checkuser-search-target' => 'мэта',
	'checkuser-ipeditcount' => '~$1 ад усіх удзельнікаў',
	'checkuser-log-return' => 'Вярнуцца да галоўнай формы праверкі ўдзельнікаў',
	'checkuser-limited' => "'''Гэты вынік быў скарочаны, з прычыны прадукцыйнасьці сыстэмы.'''",
	'checkuser-log-userips' => '$1 атрымаў IP-адрасы для $2',
	'checkuser-log-ipedits' => '$1 атрымаў рэдагаваньні для $2',
	'checkuser-log-ipusers' => '$1 атрымаў рахункі ўдзельнікаў для $2',
	'checkuser-log-ipedits-xff' => '$1 атрымаў рэдагаваньні для XFF $2',
	'checkuser-log-ipusers-xff' => '$1 атрымаў рахункі ўдзельнікаў для XFF $2',
	'checkuser-log-useredits' => '$1 атрымаў рэдагаваньні для $2',
	'checkuser-autocreate-action' => 'быў створаны аўтаматычна',
	'checkuser-create-action' => 'створаны',
	'checkuser-email-action' => 'даслаць ліст удзельніку «$1»',
	'checkuser-reset-action' => 'скасаваў пароль для ўдзельніка «$1»',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'checkuser-summary' => 'Този инструмент сканира последните промени и извлича IP адресите, използвани от потребител или показва информацията за редакциите/потребителя за посоченото IP.
	Потребители и редакции по клиентско IP могат да бъдат извлечени чрез XFF headers като се добави IP с "/xff". Поддържат се IPv4 (CIDR 16-32) и IPv6 (CIDR 64-128).
	От съображения, свързани с производителността на уикито, ще бъдат показани не повече от 5000 редакции. Използвайте инструмента съобразно установената политика.',
	'checkuser-desc' => 'Предоставя на потребители с подходящите права възможност за проверка на потребителски IP адреси и друга информация',
	'checkuser-logcase' => 'Търсенето в дневника различава главни от малки букви.',
	'checkuser' => 'Проверяване на потребител',
	'checkuserlog' => 'Дневник на проверяващите',
	'checkuser-contribs' => 'проверка на IP-адреса на потребителя',
	'group-checkuser' => 'Проверяващи',
	'group-checkuser-member' => 'Проверяващ',
	'right-checkuser' => 'проверяване на потребителски IP адреси и друга информация',
	'right-checkuser-log' => 'Преглеждане на дневника с проверки на потребители',
	'grouppage-checkuser' => '{{ns:project}}:Проверяващи',
	'checkuser-reason' => 'Причина:',
	'checkuser-showlog' => 'Показване на дневника',
	'checkuser-query' => 'Заявка към последните промени',
	'checkuser-target' => 'IP-адрес или потребителско име:',
	'checkuser-users' => 'Извличане на потребители',
	'checkuser-edits' => 'Извличане на редакции',
	'checkuser-ips' => 'Извличане на IP адреси',
	'checkuser-search' => 'Търсене',
	'checkuser-period' => 'Продължителност:',
	'checkuser-week-1' => 'последната седмица',
	'checkuser-week-2' => 'последните 2 седмици',
	'checkuser-month' => 'последните 30 дни',
	'checkuser-all' => 'всички',
	'checkuser-empty' => 'Дневникът не съдържа записи.',
	'checkuser-nomatch' => 'Няма открити съвпадения.',
	'checkuser-nomatch-edits' => 'Не бяха открити съвпадения.
Последната редакция е била на $1 в $2.',
	'checkuser-check' => 'Проверка',
	'checkuser-log-fail' => 'Беше невъзможно да се добави запис в дневника',
	'checkuser-nolog' => 'Не беше открит дневник.',
	'checkuser-blocked' => 'Блокиран',
	'checkuser-gblocked' => 'Глобално блокиран',
	'checkuser-locked' => 'Заключено',
	'checkuser-wasblocked' => 'Блокиран преди време',
	'checkuser-massblock' => 'Блокиране на избраните потребители',
	'checkuser-massblock-text' => 'Избраните потребителски сметки ще бъдат блокирани безсрочно, като създаването на сметки ще бъде забранено и ще бъде включена автоблокировка на IP адресите.
Само за анонимни потребители IP адресите ще бъдат блокирани за една седмица и ще бъде забранено създаването на потребителски сметки.',
	'checkuser-blocktag' => 'Заместване на потребителските страници с:',
	'checkuser-blocktag-talk' => 'Заместване на беседите с:',
	'checkuser-massblock-commit' => 'Блокиране на избраните потребители',
	'checkuser-block-success' => "'''{{PLURAL:$2|Потребител|Потребители}} $1 {{PLURAL:$2|беше блокиран|бяха блокирани}}.'''",
	'checkuser-block-failure' => "'''Няма блокирани потребители.'''",
	'checkuser-block-limit' => 'Избрани са твърде много потребители.',
	'checkuser-block-noreason' => 'Трябва да се посочи причина за блокиранията.',
	'checkuser-noreason' => 'Необходимо е да се посочи основание за тази заявка.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|нова сметка|нови сметки}}',
	'checkuser-too-many' => 'Твърде много резултати. Показани са използваните IP адреси (най-много 5000, сортирани по адрес):',
	'checkuser-user-nonexistent' => 'Посоченият потребител не съществува.',
	'checkuser-search-form' => 'Намиране на записи от дневника, в които $1 е $2',
	'checkuser-search-submit' => 'Търсене',
	'checkuser-search-initiator' => 'инициатор',
	'checkuser-search-target' => 'цел',
	'checkuser-ipeditcount' => '~$1 от всички потребители',
	'checkuser-log-return' => 'Връщане към основния формуляр за проверка',
	'checkuser-limited' => "'''Резултатите бяха съкратени от съображения, свързани с производителността на системата.'''",
	'checkuser-log-userips' => '$1 е получил айпи адреси за $2',
	'checkuser-log-ipedits' => '$1 е получил редакции за $2',
	'checkuser-log-ipusers' => '$1 е получил потребители за $2',
	'checkuser-log-ipedits-xff' => '$1 е получил редакции за XFF $2',
	'checkuser-log-ipusers-xff' => '$1 е получил потребители за XFF $2',
	'checkuser-email-action' => 'изпрати е-писмо на потребител „$1“',
	'checkuser-reset-action' => 'промяна на парола за потребител "$1"',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 * @author Zaheen
 */
$messages['bn'] = array(
	'checkuser-summary' => 'এই সরঞ্জামটি সাম্প্রতিক পরিবর্তনসমূহ বিশ্লেষণ করে কোন ব্যবহারকারীর ব্যবহৃত আইপিগুলি নিয়ে আসে কিংবা কোন একটি আইপির জন্য সম্পাদনা/ব্যবহারকারী উপাত্ত প্রদর্শন করে।
কোন ক্লায়েন্ট আইপি-র জন্য ব্যবহারকারী ও সম্পাদনা XFF হেডারসমূহের সাহায্যে নিয়ে আসা যায়; এজন্য আইপির সাথে "/xff" যোগ করতে হয়।
IPv4 (CIDR 16-32) এবং IPv6 (CIDR 64-128) এই সরঞ্জামে সমর্থিত।
দক্ষতাজনিত কারণে ৫০০০-এর বেশি সম্পাদনা নিয়ে আসা হবে না। নীতিমালা মেনে এটি ব্যবহার করুন।',
	'checkuser-desc' => 'যথাযথ অনুমোদনপ্রাপ্ত ব্যবহারকারীদেরকে অন্য ব্যবহারকারীদের আইপি ঠিকানা এবং অন্যান্য তথ্য পরীক্ষা করার ক্ষমতা দেয়',
	'checkuser-logcase' => 'লগ অনুসন্ধান বড়/ছোট হাতের অক্ষরের উপর নির্ভরশীল',
	'checkuser' => 'ব্যবহারকারী পরীক্ষণ',
	'checkuserlog' => 'ব্যবহারকারী পরীক্ষণ লগ',
	'group-checkuser' => 'ব্যবহারকারী পরীক্ষক',
	'group-checkuser-member' => 'ব্যবহারকারী পরীক্ষক',
	'grouppage-checkuser' => '{{ns:project}}:ব্যবহারকারী পরীক্ষণ',
	'checkuser-reason' => 'কারণ:',
	'checkuser-showlog' => 'লগ দেখাও',
	'checkuser-query' => 'সাম্প্রতিক পরিবর্তনসমূহ জানুন',
	'checkuser-target' => 'আইপি ঠিকানা বা ব্যবহারকারীর নাম:',
	'checkuser-users' => 'ব্যবহারকারী সমূহ পাওয়া যাবে',
	'checkuser-edits' => 'আইপি থেকে সম্পাদনাসমূহ পাওয়া যাবে',
	'checkuser-ips' => 'আইপি সমূহ পাওয়া যাবে',
	'checkuser-search' => 'অনুসন্ধান',
	'checkuser-period' => 'সময়:',
	'checkuser-week-1' => 'পূর্ববর্তী সপ্তাহ',
	'checkuser-week-2' => 'পূর্ববর্তী দুই সপ্তাহ',
	'checkuser-month' => 'পূর্ববর্তী ৩০ দিন',
	'checkuser-all' => 'সমস্ত',
	'checkuser-cidr-res' => 'সাধারণ সিআইডিআর:',
	'checkuser-empty' => 'এই লগে কিছুই নেই।',
	'checkuser-nomatch' => 'এর সাথে মিলে এমন কিছু পাওয়া যায়নি।',
	'checkuser-check' => 'পরীক্ষা করুন',
	'checkuser-log-fail' => 'লগ ভুক্তিতে যোগ করা সম্ভব হচ্ছে না',
	'checkuser-nolog' => 'কোন লগ ফাইল পাওয়া যায়নি।',
	'checkuser-blocked' => 'বাধা দেওয়া হয়েছে',
	'checkuser-gblocked' => 'গ্লোবালি বাধাদানকৃত',
	'checkuser-locked' => 'অবরুদ্ধ',
	'checkuser-wasblocked' => 'পূর্বে বাধাদানকৃত ছিলো',
	'checkuser-localonly' => 'কোনো একত্রকীকরণ নেই',
	'checkuser-massblock' => 'নির্বাচিত ব্যবহারকারীদের বাধা দিন',
	'checkuser-blocktag' => 'যেটির মাধ্যমে ব্যবহারকারী পাতা প্রতিস্থাপন করবেন:',
	'checkuser-blocktag-talk' => 'যেটির মাধ্যমে আলাপ পাতা প্রতিস্থাপন করবেন:',
	'checkuser-massblock-commit' => 'নির্বাচিত ব্যবহারকারীদের বাধা দিন',
	'checkuser-block-failure' => "'''বাধাদানকৃত কোনো ব্যবহারকারী নেই।'''",
	'checkuser-block-limit' => 'অনেক বেশি ব্যবহারকারী নির্বাচিত করা হয়েছে।',
	'checkuser-block-noreason' => 'আপনাকে অবশ্যই এই ব্লকগুলোর জন্য একটি কারণ উল্লেখ করতে হবে।',
	'checkuser-noreason' => 'আপনাকে অবশ্যই এই কোয়েরির জন্য একটি কারণ উল্লেখ করতে হবে।',
	'checkuser-accounts' => '$1 নতুন {{PLURAL:$1|অ্যাকাউন্ট|অ্যাকাউন্টসমূহ}}',
	'checkuser-too-many' => 'অত্যধিক সংখ্যক ফলাফল, অনুগ্রহ করে CIDR সীমিত করুন। নিচের আইপিগুলি ব্যবহৃত হয়েছে (সর্বোচ্চ ৫০০০, ঠিকানা অনুযায়ী বিন্যস্ত):',
	'checkuser-user-nonexistent' => 'এই নির্দিষ্ট ব্যবহারকারী নেই।',
	'checkuser-search-form' => 'এমনসব লগ ভুক্তি খুঁজে বের করুন যেখানে $1 হল $2',
	'checkuser-search-submit' => 'অনুসন্ধান',
	'checkuser-search-initiator' => 'আরম্ভকারী',
	'checkuser-search-target' => 'লক্ষ্য',
	'checkuser-ipeditcount' => '~$1 সমস্ত ব্যবহাকারী থেকে',
	'checkuser-log-return' => 'CheckUser মূল ফর্মে ফেরত যান',
	'checkuser-log-userips' => '$2 এর জন্য $1 আইপি  সমূহ পেয়েছে',
	'checkuser-log-ipedits' => '$2 এর জন্য $1 সম্পাদনাসমূহ পেয়েছে',
	'checkuser-log-ipusers' => '$2 এর জন্য $1 ব্যবহারকারীসমূহ পেয়েছে',
	'checkuser-log-ipedits-xff' => '$2 এর জন্য XFF $1 সম্পাদনাসমূহ পেয়েছে',
	'checkuser-log-ipusers-xff' => '$2 এর জন্য XFF $1 ব্যবহারকারীসমূহ পেয়েছে',
	'checkuser-autocreate-action' => 'স্বয়ংক্রিয়ভাবে তৈরি হয়েছিলো',
	'checkuser-email-action' => 'ব্যবহারকারী "$1"-এর কাছে একটি ই-মেইল পাঠাও',
	'checkuser-reset-action' => 'ব্যবহারকারী "$1"-এর জন্য শব্দচাবি রিসেট করো',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'checkuser-summary' => "Furchal a ra an ostilh-mañ ar c'hemmoù diwezhañ a-benn klask ar chomlec'h IP implijet gant un implijer bennak, diskouez a ra holl degasadennoù ur chomlec'h IP (ha pa vefe bet enrollet), pe roll ar c'hontoù implijet gant ur chomlec'h IP. Gallout a ra ar c'hontoù hag ar c'hemmoù bezañ kavet gant un IP XFF mard echu gant \"/xff\". Posupl eo implijout ar protokoloù IPv4 (CIDR 16-32) hag IPv6 (CIDR 64-128). Bevennet eo an niver a gemmoù a c'haller lakaat war wel da {{formatnum:5000}} evit abegoù nerzh ar servijer. Grit gant an ostilh-mañ en ur zoujañ d'ar garta implijout.",
	'checkuser-desc' => "Reiñ a ra an tu d'an dud aotreet evit se da wiriañ chomlec'hioù IP an implijerien ha da gaout titouroù all",
	'checkuser-logcase' => "Kizidik eo ar c'hlask er marilh ouzh an direnneg (pennlizherennoù/lizherennoù munud)",
	'checkuser' => 'Gwiriañ an implijer',
	'checkuserlog' => 'Marilh kontrolliñ an implijerien',
	'checkuser-contribs' => "gwiriañ chomlec'hioù IP an implijer",
	'group-checkuser' => 'Gwiriañ an implijerien',
	'group-checkuser-member' => '{{GENDER:$1|gwirier implijerien|gwirierez implijerien}}',
	'right-checkuser' => "Gwiriañ chomlec'hioù IP ha titouroù all an implijer",
	'right-checkuser-log' => 'Gwelet marilh gwiriekadurioù an implijerien',
	'action-checkuser' => "Gwiriañ chomlec'hioù IP an implijer ha titouroù all",
	'action-checkuser-log' => 'Gwelet marilh gwiriañ an implijerien',
	'grouppage-checkuser' => '{{ns:project}}:Gwiriañ an implijer',
	'checkuser-reason' => 'Abeg :',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Diskouez ar marilh',
	'checkuser-query' => "Klask dre ar c'hemmoù diwezhañ",
	'checkuser-target' => 'Anv implijer pe IP :',
	'checkuser-users' => 'Kavout an implijerien',
	'checkuser-edits' => "Tapout ar c'hemmoù",
	'checkuser-ips' => "Kavout ar chomlec'hioù IP",
	'checkuser-search' => 'Klask',
	'checkuser-period' => 'Pad :',
	'checkuser-week-1' => 'Er sizhun ziwezhañ',
	'checkuser-week-2' => 'en div sizhunvezh ziwezhañ',
	'checkuser-month' => 'en 30 devezh diwezhañ',
	'checkuser-all' => 'pep tra',
	'checkuser-cidr-label' => "Klask ur renk boutin hag ar chomlec'hioù sellet outo en ur roll chomlec'hioù IP",
	'checkuser-cidr-res' => 'Lijorenn CIDR boutin :',
	'checkuser-empty' => "N'eus pennad ebet er marilh",
	'checkuser-nomatch' => "N'eus bet kavet netra.",
	'checkuser-nomatch-edits' => "Kenglot ebet kavet.
D'an $1 da $2 eo bet graet ar c'hemm diwezhañ.",
	'checkuser-check' => 'Gwiriañ',
	'checkuser-log-fail' => "Dibosupl ouzhpennañ ar moned d'ar marilh",
	'checkuser-nolog' => 'Restr ebet er marilh',
	'checkuser-blocked' => 'Stanket',
	'checkuser-gblocked' => 'Stankañ dre-vras',
	'checkuser-locked' => 'Prennet',
	'checkuser-wasblocked' => 'Bet stanket a-raok',
	'checkuser-localonly' => "N'eo ket unvanet",
	'checkuser-massblock' => 'Stankañ an implijerien dibabet',
	'checkuser-massblock-text' => "Stanket e vo ar c'hontoù dibabet da viken, gweredekaet ar stankañ emgefre ha diweredekaet ar c'hrouiñ kontoù.
Stanket e vo ar chomlec'hioù IP ur sizhunvezh-pad evit an implijerien dindan IP nemetken, gant ar c'hrouiñ kontoù diweredekaet.",
	'checkuser-blocktag' => "Erlec'hiañ ar pajennoù implijer gant :",
	'checkuser-blocktag-talk' => "Erlec'hiañ ar pajennoù kaozeal gant :",
	'checkuser-massblock-commit' => 'Stankañ an implijerien diuzet',
	'checkuser-block-success' => "'''Stanket eo an {{PLURAL:$2|implijer|implijerien}} $1 bremañ'''",
	'checkuser-block-failure' => "'''Implijer ebet stanket.'''",
	'checkuser-block-limit' => 'Re a implijerien diuzet.',
	'checkuser-block-noreason' => "Ret eo deoc'h reizhabegiñ ar stankadennoù.",
	'checkuser-noreason' => "Ret eo deoc'h reizhabegiñ an enklask-mañ.",
	'checkuser-accounts' => '$1 {{PLURAL:$1|kont|kont}} nevez',
	'checkuser-too-many' => "Re a zisoc'hoù (hervez istimadur ar reked), strishaat ar CIDR mar plij.
Setu an IPoù implijet (5000 d'ar muiañ, urzhiet dre ar chomlec'h) :",
	'checkuser-user-nonexistent' => "N'eus ket eus an implijer merket",
	'checkuser-search-form' => "Kavout marilh ar monedoù m'eo $1 evit $2",
	'checkuser-search-submit' => 'Klask',
	'checkuser-search-initiator' => 'deraouer',
	'checkuser-search-target' => 'pal',
	'checkuser-ipeditcount' => '~$1 gant an holl implijerien',
	'checkuser-log-return' => "Distreiñ da furmskrid pennañ ar c'hontrolliñ implijerien",
	'checkuser-limited' => "'''Krennet eo bet an disoc'hoù-mañ evit abegoù efeduster.'''",
	'checkuser-log-userips' => '$1 en deus kavet IPoù evit $2',
	'checkuser-log-ipedits' => '$1 en deus bet kemmoù evit $2',
	'checkuser-log-ipusers' => '$1 en deus kavet implijerien evit $2',
	'checkuser-log-ipedits-xff' => '$1 en deus kavet kemmoù evit $2 dre XFF',
	'checkuser-log-ipusers-xff' => 'Kavet en deus $1 implijerien $2 dre XFF',
	'checkuser-log-useredits' => '$1 en deus bet kemmoù evit $2',
	'checkuser-autocreate-action' => 'zo bet krouet ent emgefre',
	'checkuser-create-action' => 'zo bet krouet',
	'checkuser-email-action' => "en deus kaset ur postel d'an implijer « $1 »",
	'checkuser-reset-action' => 'adderaouekaat a ra ger-tremen an implijer "$1"',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'checkuser-summary' => 'Ovaj alat skenira nedavne promjene te vraća IP adrese koje koriste korisnici ili prikazuje podatke o izmjenama i korisnicima za pojedinu IP adresu.
Korisnici i izmjene nekog IP klijenta mogu biti nađene preko XFF zaglavlja uz primjenu oznake "/xff" pored IP-a. Podržani su i IPv4 (CIDR 16-32) i IPv6 (CIDR 64-128).
Zbog boljih performansi, neće biti prikazano više od 5000 izmjena.
Koristite ovo u skladu s pravilima.',
	'checkuser-desc' => 'Omogućuje korisnicima sa adekvatnim dopuštenjima sposobnost da provjeravaju korisničke IP adrese i druge podatke',
	'checkuser-logcase' => 'Pretraga zapisa razlikuje velika i mala slova.',
	'checkuser' => 'Provjera korisnika',
	'checkuserlog' => 'Zapis CheckUsera',
	'checkuser-contribs' => 'provjeri korisničke IPe',
	'group-checkuser' => 'Provjera korisnika',
	'group-checkuser-member' => 'Provjera korisnika',
	'right-checkuser' => 'Provjera korisničkih IP adresa i drugih informacija',
	'right-checkuser-log' => 'Pregledanje zapisa provjere korisnika',
	'grouppage-checkuser' => '{{ns:project}}:Provjera korisnika',
	'checkuser-reason' => 'Razlog:',
	'checkuser-showlog' => 'Prikaži zapis',
	'checkuser-query' => 'Pretraži nedavne izmjene',
	'checkuser-target' => 'IP adresa ili korisničko ime:',
	'checkuser-users' => 'Nađi korisnike',
	'checkuser-edits' => 'Nađi izmjene',
	'checkuser-ips' => 'Nađi IP adrese',
	'checkuser-search' => 'Traži',
	'checkuser-period' => 'Trajanje:',
	'checkuser-week-1' => 'zadnja sedmica',
	'checkuser-week-2' => 'zadnje dvije sedmice',
	'checkuser-month' => 'zadnjih 30 dana',
	'checkuser-all' => 'sve',
	'checkuser-cidr-label' => 'Pronađi zajednički opseg i pogođene adrese za spisak IPova',
	'checkuser-cidr-res' => 'Zajednički CIDR:',
	'checkuser-empty' => 'Zapis ne sadrži stavke.',
	'checkuser-nomatch' => 'Nisu nađeni traženi rezultati.',
	'checkuser-nomatch-edits' => 'Nije pronađen traženi upit.
Zadnja izmjena je bila dana $1 u $2.',
	'checkuser-check' => 'Provjeri',
	'checkuser-log-fail' => 'Nije moguće dodati stavku zapisa',
	'checkuser-nolog' => 'Nije pronađena datoteka zapisa.',
	'checkuser-blocked' => 'Blokiran',
	'checkuser-gblocked' => 'Blokiran globalno',
	'checkuser-locked' => 'Zaključano',
	'checkuser-wasblocked' => 'Ranije blokiran',
	'checkuser-localonly' => 'Nije spojeno',
	'checkuser-massblock' => 'Blokiraj odabrane korisnike',
	'checkuser-massblock-text' => 'Odabrani računi će biti neograničeno blokirani, sa omogućenom automatskom blokadom i onemogućenim pravljenjem računa.
IP adrese će biti blokirane u periodu od jedne sedmice samo za IP korisnike i sa onemogućenim pravljenjem računa.',
	'checkuser-blocktag' => 'Mijenja korisničku stranicu sa:',
	'checkuser-blocktag-talk' => 'Mijenja sadržaj stranice za razgovor sa:',
	'checkuser-massblock-commit' => 'Blokiraj odabrane korisnike',
	'checkuser-block-success' => "'''{{PLURAL:$2|Korisnik|Korisnici}} $1 {{PLURAL:$2|je sad blokiran|su sada blokirani}}.'''",
	'checkuser-block-failure' => "'''Nijedan korisnik nije blokiran.'''",
	'checkuser-block-limit' => 'Previše korisnika odabrano.',
	'checkuser-block-noreason' => 'Morate navesti razlog za blokiranje.',
	'checkuser-noreason' => 'Morate navesti razlog za ovaj upit.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|novi korisnik|nova korisnika|novih korisnika}}',
	'checkuser-too-many' => 'Pronađeno previše rezultata (po procjeni upita), molimo da suzite CIDR.
Ovdje su prikazane korištene IP adrese (najviše 5000, poredano po adresi):',
	'checkuser-user-nonexistent' => 'Navedeni korisnik ne postoji.',
	'checkuser-search-form' => 'Nađi stavke zapisa gdje je $1 jednako $2',
	'checkuser-search-submit' => 'Traži',
	'checkuser-search-initiator' => 'pokretač',
	'checkuser-search-target' => 'cilj',
	'checkuser-ipeditcount' => '~$1 od svih korisnika',
	'checkuser-log-return' => 'Povratak na glavni obrazac provjere korisnika',
	'checkuser-limited' => "'''Ovi rezultati su skraćeni iz razloga bolje performanse.'''",
	'checkuser-log-userips' => 'Korisnik $1 je našao IP adrese za $2',
	'checkuser-log-ipedits' => 'Korisnik $1 je našao izmjene za $2',
	'checkuser-log-ipusers' => '$1 je našao korisnike na $2',
	'checkuser-log-ipedits-xff' => '$1 je našao izmjene za XFF $2',
	'checkuser-log-ipusers-xff' => 'Korisnik $1 je našao korisnike za XFF $2',
	'checkuser-log-useredits' => '$1 nađene izmjene za $2',
	'checkuser-autocreate-action' => 'je automatski napravljen',
	'checkuser-create-action' => 'je napravljen',
	'checkuser-email-action' => 'slanje e-mail korisniku "$1"',
	'checkuser-reset-action' => 'poništi šifru za korisnika "$1"',
);

/** Catalan (Català)
 * @author Aleator
 * @author El libre
 * @author Jordi Roqué
 * @author Juanpabl
 * @author Paucabot
 * @author SMP
 * @author Solde
 * @author Ssola
 * @author Toniher
 */
$messages['ca'] = array(
	'checkuser-summary' => "Aquest instrument efectua una cerca als canvis recents per a comprovar les adreces IP fetes servir per un usuari o per a mostrar les edicions d'una certa adreça IP.
Les edicions i usuaris d'un client IP es poden obtenir via capçaleres XFF afegint /xff al final de la IP. Tant les adreces IPv4 (CIDR 16-32) com les IPv6 (CIDR 64-128) són admeses.
Per raons d'efectivitat i de memòria no es retornen més de 5000 edicions. Recordeu que aquesta eina només es pot usar d'acord amb les polítiques corresponents i amb respecte a la legislació sobre privadesa.",
	'checkuser-desc' => "Permet als usuaris amb els permisos adients l'habilitat de comprovar les adreces IP que fan servir els usuaris enregistrats.",
	'checkuser-logcase' => 'Les majúscules es tracten de manera diferenciada en la cerca dins el registre.',
	'checkuser' => "Comprova l'usuari",
	'checkuserlog' => 'Registre de Checkuser',
	'checkuser-contribs' => "comprova les IP de l'usuari",
	'group-checkuser' => 'Checkusers',
	'group-checkuser-member' => 'CheckUser',
	'right-checkuser' => 'Comprovar les adreces IP i altra informació dels usuaris',
	'right-checkuser-log' => 'Veure el registre de checkuser',
	'grouppage-checkuser' => '{{ns:project}}:Checkuser',
	'checkuser-reason' => 'Motiu:',
	'checkuser-showlog' => 'Mostra registre',
	'checkuser-query' => 'Cerca als canvis recents',
	'checkuser-target' => "Adreça IP o nom d'usuari:",
	'checkuser-users' => 'Retorna els usuaris',
	'checkuser-edits' => 'Obté edicions',
	'checkuser-ips' => 'Retorna adreces IP',
	'checkuser-search' => 'Cerca',
	'checkuser-period' => 'Durada:',
	'checkuser-week-1' => 'Darrera setmana',
	'checkuser-week-2' => 'Darreres dues setmanes',
	'checkuser-month' => 'Darrers 30 dies',
	'checkuser-all' => 'tot',
	'checkuser-cidr-label' => "Troba un rang comú i les adreces afectades per una llista d'IP",
	'checkuser-cidr-res' => 'CIDR comú:',
	'checkuser-empty' => 'El registre no conté entrades.',
	'checkuser-nomatch' => "No s'han trobat coincidències.",
	'checkuser-nomatch-edits' => "No s'ha trobat.
L'última modificació va ser el $1 a $2.",
	'checkuser-check' => 'Comprova',
	'checkuser-log-fail' => "No s'ha pogut afegir al registre",
	'checkuser-nolog' => "No s'ha trobat el fitxer del registre.",
	'checkuser-blocked' => 'Blocat',
	'checkuser-gblocked' => 'Blocat globalment',
	'checkuser-locked' => 'Blocat',
	'checkuser-wasblocked' => 'Prèviament bloquejat',
	'checkuser-localonly' => 'No unificat',
	'checkuser-massblock' => 'Bloqueja els usuaris seleccionats',
	'checkuser-massblock-text' => "Els comptes seleccionats seran blocat indefinidament, amb l'''autoblocking'' activat i prohibint la creació de nous comptes.
Les adreces IP seran blocades per una setmana només amb la prohibició de crear comptes.",
	'checkuser-blocktag' => "Canvia les pàgines d'usuari per:",
	'checkuser-blocktag-talk' => 'Reemplaça les pàgines de discussió amb:',
	'checkuser-massblock-commit' => 'Bloqueja usuaris seleccionats',
	'checkuser-block-success' => "'''{{PLURAL:$2|L'usuari|Els usuaris}} $1 {{PLURAL:$2|ha estat blocat|han estat blocats}}.'''",
	'checkuser-block-failure' => "'''No s'han blocat usuaris.'''",
	'checkuser-block-limit' => 'Massa usuaris seleccionats.',
	'checkuser-block-noreason' => "Heu d'indicar un motiu pels bloquejos.",
	'checkuser-noreason' => 'Heu de donar un motiu per a executar aquesta consulta.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nou compte|nous comptes}}',
	'checkuser-too-many' => "Hi ha massa resultats (d'acord amb l'estimació de la consulta), cal que useu un CIDR més petit.
Aquí teniu les IP usades (màx. 5000 ordenades per adreça):",
	'checkuser-user-nonexistent' => "L'usuari especificat no existeix.",
	'checkuser-search-form' => 'Cerca entrades al registre on $1 és $2',
	'checkuser-search-submit' => 'Cerca',
	'checkuser-search-initiator' => "l'iniciador",
	'checkuser-search-target' => 'el consultat',
	'checkuser-ipeditcount' => '~$1 de tots els usuaris',
	'checkuser-log-return' => 'Retorna al formulari de CheckUser',
	'checkuser-limited' => "'''Els resultats s'han trucat per raons de rendiment.'''",
	'checkuser-log-userips' => '$1 consulta les IP de $2',
	'checkuser-log-ipedits' => '$1 consulta les edicions de $2',
	'checkuser-log-ipusers' => '$1 consulta els usuaris de $2',
	'checkuser-log-ipedits-xff' => '$1 consulta les edicions del XFF $2',
	'checkuser-log-ipusers-xff' => '$1 consulta els usuaris del XFF $2',
	'checkuser-log-useredits' => '$1 consulta les edicions de $2',
	'checkuser-autocreate-action' => 'fou automàticament creat',
	'checkuser-create-action' => 'va ser creat',
	'checkuser-email-action' => "S'ha enviat un missatge de correu electrònic a {{GENDER:$1|l'usuari|la usuària}} $1",
	'checkuser-reset-action' => "reinicia la contrasenya de l'usuari «$1»",
);

/** Min Dong Chinese (Mìng-dĕ̤ng-ngṳ̄) */
$messages['cdo'] = array(
	'checkuser-search' => 'Sìng-tō̤',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'group-checkuser' => 'Даржахошка хьовсурш',
	'checkuser-reason' => 'Бахьан:',
	'checkuser-target' => 'IP-долу меттиг йа декъашхон цlе:',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'checkuser-search' => 'Aligao',
	'checkuser-search-submit' => 'Aligao',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'checkuser-reason' => 'هۆکار:',
	'checkuser-search' => 'گەڕان',
	'checkuser-search-submit' => 'گەڕان',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'group-checkuser' => 'Controllori',
	'group-checkuser-member' => 'Controllore',
	'grouppage-checkuser' => '{{ns:project}}:Controllori',
);

/** Czech (Česky)
 * @author Beren
 * @author Danny B.
 * @author Li-sung
 * @author Mormegil
 */
$messages['cs'] = array(
	'checkuser-summary' => 'Tento nástroj zkoumá poslední změny a umožňuje získat IP adresy uživatelů nebo zobrazit editace a uživatele z dané IP adresy.
Uživatele a editace z klientské IP adresy lze získat z hlaviček XFF přidáním „/xff“ k IP. Je podporováno IPv4 (CIDR 16–32) a IPv6 (CIDR 64–128).
Z výkonnostních důvodů lze zobrazit maximálně 5000 editací. Používejte tento nástroj v souladu s pravidly.',
	'checkuser-desc' => 'Poskytuje uživatelům s příslušným oprávněním možnost zjišťovat IP adresy uživatelů a další související informace',
	'checkuser-logcase' => 'Hledání v záznamech rozlišuje velikosti písmen.',
	'checkuser' => 'Kontrola uživatele',
	'checkuserlog' => 'Kniha kontroly uživatelů',
	'checkuser-contribs' => 'kontrola uživatelových IP',
	'group-checkuser' => 'Revizoři',
	'group-checkuser-member' => '{{GENDER:$1|revizor|revizorka|revizor}}',
	'right-checkuser' => 'Kontrolování uživatelské IP adresy a dalších informací',
	'right-checkuser-log' => 'Prohlížení protokolovacích záznamů revize uživatelů',
	'action-checkuser' => 'kontrolovat uživatelovy IP adresy a další údaje',
	'action-checkuser-log' => 'prohlížet protokolovací záznamy revize uživatelů',
	'grouppage-checkuser' => '{{ns:project}}:Revize uživatele',
	'checkuser-reason' => 'Důvod:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Zobrazit záznamy',
	'checkuser-query' => 'Dotaz na poslední změny',
	'checkuser-target' => 'IP adresa nebo uživatelské jméno:',
	'checkuser-users' => 'Najít uživatele',
	'checkuser-edits' => 'Najít editace',
	'checkuser-ips' => 'Najít IP adresy',
	'checkuser-search' => 'Hledat',
	'checkuser-period' => 'Období:',
	'checkuser-week-1' => 'poslední týden',
	'checkuser-week-2' => 'poslední dva týdny',
	'checkuser-month' => 'posledních 30 dní',
	'checkuser-all' => 'všechno',
	'checkuser-cidr-label' => 'Zjištění společného rozsahu ze seznamu IP adres',
	'checkuser-cidr-res' => 'Společný CIDR:',
	'checkuser-empty' => 'Kniha neobsahuje žádné položky',
	'checkuser-nomatch' => 'Nic odpovídajícího nebylo nalezeno.',
	'checkuser-nomatch-edits' => 'Nic odpovídajícího nebylo nalezeno. Poslední editace proběhla $2, $1.',
	'checkuser-check' => 'Zkontrolovat',
	'checkuser-log-fail' => 'Nepodařilo se zapsat do záznamů',
	'checkuser-nolog' => 'Soubor záznamů nebyl nalezen.',
	'checkuser-blocked' => 'zablokováno',
	'checkuser-gblocked' => 'globálně zablokováno',
	'checkuser-locked' => 'zamčeno',
	'checkuser-wasblocked' => 'dříve blokováno',
	'checkuser-localonly' => 'Nesjednocený',
	'checkuser-massblock' => 'Zablokovat vybrané uživatele',
	'checkuser-massblock-text' => 'Vybrané účty budou zablokovány do odvolání, se zapnutým automatickým blokováním a zákazem tvorby nových účtů. IP adresy budou zablokovány na týden, pouze pro neregistrované uživatele a se zákazem tvorby nových účtů.',
	'checkuser-blocktag' => 'Nahradit obsah uživatelských stránek textem:',
	'checkuser-blocktag-talk' => 'Nahradit obsah uživatelských diskusí textem:',
	'checkuser-massblock-commit' => 'Zablokovat vybrané uživatele',
	'checkuser-block-success' => "'''{{PLURAL:$2|Uživatel|Uživatelé}} $1 {{PLURAL:$2|je zablokován|jsou zablokováni}}.'''",
	'checkuser-block-failure' => "'''Žádný uživatel nebyl zablokován.'''",
	'checkuser-block-limit' => 'Vybráno příliš mnoho uživatelů',
	'checkuser-block-noreason' => 'Musíte zadat důvod blokování',
	'checkuser-noreason' => 'K tomuto dotazu musíte uvést důvod.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nový účet|nové účty|nových účtů}}',
	'checkuser-too-many' => 'Příliš mnoho výsledků (podle odhadu dotazu), zkuste omezit CIDR.
Níže jsou použité IP adresy (nejvýše 5000, seřazené podle adresy):',
	'checkuser-user-nonexistent' => 'Zadaný uživatel neexistuje.',
	'checkuser-search-form' => 'Hledej záznamy, kde $1 je $2',
	'checkuser-search-submit' => 'Hledat',
	'checkuser-search-initiator' => 'kontrolující',
	'checkuser-search-target' => 'kontrolováno',
	'checkuser-ipeditcount' => 'asi $1 od všech uživatelů',
	'checkuser-log-return' => 'Návrat na hlavní formulář Kontroly uživatele',
	'checkuser-limited' => "'''Výsledky byly z výkonnostních důvodů zkráceny.'''",
	'checkuser-log-userips' => '$1 zjišťuje IP adresy uživatele $2',
	'checkuser-log-ipedits' => '$1 zjišťuje editace z IP $2',
	'checkuser-log-ipusers' => '$1 zjišťuje uživatele z IP $2',
	'checkuser-log-ipedits-xff' => '$1 zjišťuje editace s XFF $2',
	'checkuser-log-ipusers-xff' => '$1 zjišťuje uživatele s XFF $2',
	'checkuser-log-useredits' => '$1 zjišťuje editace od $2',
	'checkuser-autocreate-action' => 'byl automaticky vytvořen',
	'checkuser-create-action' => 'byl vytvořen',
	'checkuser-email-action' => 'odeslal e-mail uživateli „$1“',
	'checkuser-reset-action' => 'požádal o nové heslo pro uživatele „$1“',
);

/** Kashubian (Kaszëbsczi)
 * @author Byulent
 */
$messages['csb'] = array(
	'checkuser-search' => 'Szëkba',
	'checkuser-all' => 'wszëtczé',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'checkuser-target' => 'IP число или по́льꙃєватєлꙗ и́мѧ :',
	'checkuser-search' => 'исканиѥ',
	'checkuser-search-submit' => 'ищи́',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'checkuser-summary' => "Mae'r teclyn hwn yn sganio newidiadau diweddar i gael hyd i'r cyfeiriadau IP a ddefnyddir gan ddefnyddiwr, neu i ddangos data golygu neu ddata defnyddiwr ar gyfer rhyw gyfeiriad IP. 
Gall y teclyn gael hyd i ddefnyddwyr rhyw gyfeiriad IP cleient, neu'r golygiadau a ddaw ohono, drwy atodi \"/xff\" i'r cyfeiriad IP. Mae IPv4 (CIDR 16-32) a IPv6 (CIDR 64-128) yn cael eu cynnal. 
Ni chaiff mwy na 5,000 o olygiadau eu dychwelyd er mwyn peidio amharu ar berfformiad y wefan. 
Defnyddiwch hwn yn unol â'n polisi.",
	'checkuser-desc' => "Yn rhoi'r gallu i ddefnyddwyr awdurdodedig archwilio cyfeiriadau IP defnyddwyr a gwybodaeth arall amdanynt.",
	'checkuser-logcase' => 'Yn gwahaniaethu rhwng llythrennau mawr a bach wrth chwilio.',
	'checkuser' => 'Archwilio defnyddwyr',
	'checkuserlog' => 'Lòg archwilio defnyddwyr',
	'checkuser-contribs' => 'archwilio IP y defnyddiwr',
	'group-checkuser' => 'Archwilwyr defnyddwyr',
	'group-checkuser-member' => '{{GENDER:$1|Archwiliwr defnyddwyr}}',
	'right-checkuser' => 'Archwilio cyfeiriadau IP defnyddwyr a gwybodaeth arall amdanynt',
	'right-checkuser-log' => 'Gweld y lòg archwilio defnyddwyr',
	'action-checkuser' => 'archwilio cyfeiriadau IP defnyddwyr a gwybodaeth arall amdanynt',
	'action-checkuser-log' => 'gweld y lòg archwilio defnyddwyr',
	'grouppage-checkuser' => '{{ns:project}}:Archwilio defnyddwyr',
	'checkuser-reason' => 'Rheswm:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Dangos y lòg',
	'checkuser-query' => "Chwilio'r newidiadau diweddar",
	'checkuser-target' => 'Defnyddiwr neu gyfeiriad IP:',
	'checkuser-users' => 'Nôl defnyddwyr',
	'checkuser-edits' => 'Nôl golygiadau',
	'checkuser-ips' => 'Nôl cyfeiriadau IP',
	'checkuser-search' => 'Chwilio',
	'checkuser-period' => 'Cyfnod:',
	'checkuser-week-1' => 'yr wythnos ddiwethaf',
	'checkuser-week-2' => 'y pythefnos ddiwethaf',
	'checkuser-month' => 'y 30 diwrnod diwethaf',
	'checkuser-all' => 'oll',
	'checkuser-cidr-label' => "Dod o hyd i'r ystod yn gyffredin ar restr o gyfeiriadau IP a'r cyfeiriadau IP cysylltiedig",
	'checkuser-cidr-res' => 'CIDR yn gyffredin:',
	'checkuser-empty' => "Mae'r lòg yn wag.",
	'checkuser-nomatch' => "Ni chafwyd hyd i ddim yn cyfateb â'r chwiliad.",
	'checkuser-nomatch-edits' => "Dim yn cyfateb i'r chwiliad.
Golygwyd ddiwethaf ar $1 am $2.",
	'checkuser-check' => 'Archwilier',
	'checkuser-log-fail' => 'Yn methu ychwanegu cofnod lòg',
	'checkuser-nolog' => "Dim ffeil lòg i'w gael.",
	'checkuser-blocked' => 'Wedi ei flocio',
	'checkuser-gblocked' => "Wedi ei flocio'n gydwici",
	'checkuser-locked' => 'Ar glo',
	'checkuser-wasblocked' => "Wedi ei flocio o'r blaen",
	'checkuser-localonly' => 'Ddim yn unedig',
	'checkuser-massblock' => 'Blocio twr o defnyddwyr',
	'checkuser-massblock-text' => 'Caiff y cyfrifon dewisedig eu blocio am gyfnod amhenodol, gyda blocio awtomatig wedi ei alluogi a chreu cyfrifon wedi ei analluogi.
Caiff cyfeiriadau IP defnyddwyr anhysbys yn unig eu blocio am wythnos, gyda chreu cyfrifon wedi ei analluogi.',
	'checkuser-blocktag' => "Gosod hyn yn lle tudalennau'r defnyddwyr:",
	'checkuser-blocktag-talk' => 'Gosod hyn yn lle tudalennau sgwrs:',
	'checkuser-massblock-commit' => 'Blocier y defnyddwyr dewisedig',
	'checkuser-block-success' => "'''Gosodwyd bloc ar y {{PLURAL:$2||defnyddiwr|defnyddwyr|defnyddwyr|defnyddwyr|defnyddwyr}} $1.'''",
	'checkuser-block-failure' => "'''Dim defnyddwyr wedi eu blocio.'''",
	'checkuser-block-limit' => 'Dewiswyd gormod o ddefnyddwyr.',
	'checkuser-block-noreason' => 'Rhaid cynnig rheswm dros y blociau.',
	'checkuser-noreason' => 'Rhaid cynnig rheswm dros yr ymholiad hwn.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|cyfrif|cyfrif|gyfrif|chyfrif|chyfrif|cyfrif}} newydd',
	'checkuser-too-many' => "Mae gormod o lawer o ganlyniadau (yn ôl amcangyfrif yr ymholiad), cyfyngwch y CIDR os gwelwch yn dda. Dyma'r IPau a ddefnyddiwyd (hyd at 5000 ohonynt, yn nhrefn y cyfeiriadau):",
	'checkuser-user-nonexistent' => "Nid yw'r defnyddiwr a enwyd ar gael.",
	'checkuser-search-form' => "Canfod y cofnodion lòg sy'n ymwneud â'r $1 $2",
	'checkuser-search-submit' => 'Chwilier',
	'checkuser-search-initiator' => 'archwiliwr',
	'checkuser-search-target' => 'y targed',
	'checkuser-ipeditcount' => '~$1 gan holl ddefnyddwyr y cyfeiriad IP',
	'checkuser-log-return' => 'Dychwelyd at brif ffurflen Archwilio Defnyddwyr',
	'checkuser-limited' => "'''Cwtogwyd ar y canlyniadau hyn er mwyn gallu perfformio'r dasg.'''",
	'checkuser-log-userips' => '$1 wedi nôl y cyfeiriadau IP ynghlwm wrth $2',
	'checkuser-log-ipedits' => '$1 wedi nôl y golygiadau gan $2',
	'checkuser-log-ipusers' => "$1 wedi nôl y defnyddwyr sy'n defnyddio $2",
	'checkuser-log-ipedits-xff' => "$1 wedi nôl y golygiadau o'r cyfeiriad XFF $2",
	'checkuser-log-ipusers-xff' => "$1 wedi nôl y defnyddwyr sy'n defnyddio'r cyfeiriad XFF $2",
	'checkuser-log-useredits' => '$1 wedi nôl y golygiadau gan $2',
	'checkuser-autocreate-action' => "wedi ei greu'n awtomatig",
	'checkuser-create-action' => 'wedi ei greu',
	'checkuser-email-action' => 'wedi anfon e-bost at y defnyddiwr "$1"',
	'checkuser-reset-action' => 'wedi ailosod y cyfrinair ar gyfer y defnyddiwr "$1"',
);

/** Danish (Dansk)
 * @author Amjaabc
 * @author Byrial
 * @author Emilkris33
 * @author Fredelige
 * @author Masz
 * @author Morten LJ
 * @author Peter Alberti
 * @author Sarrus
 */
$messages['da'] = array(
	'checkuser-summary' => 'Dette værktøj scanner Seneste ændringer for at finde IP\'er brugt af en bestemt bruger, eller for at vise redigerings- eller brugerdata for en IP.
Bruger og redigeringer fra en klient IP kan hentes via XFF headers ved at tilføje "/xff" til IP\'en. Ipv4 (CIRD 16-32) og IPv6 (CIDR 64-128) er understøttet.
For at sikre programmelets ydeevne kan maksimalt 5000 redigeringer returneres. Brug kun dette værktøj i overensstemmelse med gældende politiker på {{SITENAME}}.',
	'checkuser-desc' => 'Giver brugere med den rette godkendelse muligheden for at checke brugeres IP-adresser og anden information',
	'checkuser-logcase' => 'Logsøgning er case sensitiv (der gøres forskel på store og små bogstaver)',
	'checkuser' => 'Checkbruger',
	'checkuserlog' => 'Checkbrugerlog',
	'checkuser-contribs' => 'Tjek brugerens ip-adresser',
	'group-checkuser' => 'Checkbrugere',
	'group-checkuser-member' => '{{GENDER:$1|checkbruger}}',
	'right-checkuser' => 'Tjekke en brugers IP-adresser og andre oplysninger',
	'right-checkuser-log' => 'Se checkuser-loggen',
	'action-checkuser' => 'tjekke brugeres IP-adresser og andre oplysninger',
	'action-checkuser-log' => 'se checkuser-loggen',
	'grouppage-checkuser' => '{{ns:project}}:Checkbruger',
	'checkuser-reason' => 'Begrundelse:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Vis log',
	'checkuser-query' => 'Søg i seneste ændringer',
	'checkuser-target' => 'IP-adresse eller brugernavn:',
	'checkuser-users' => 'Hent brugere',
	'checkuser-edits' => 'Hent redigeringer',
	'checkuser-ips' => "Hent IP'er",
	'checkuser-search' => 'Søg',
	'checkuser-period' => 'Varighed:',
	'checkuser-week-1' => 'forrige uge',
	'checkuser-week-2' => 'sidste to uger',
	'checkuser-month' => 'sidste 30 dage',
	'checkuser-all' => 'alle',
	'checkuser-cidr-label' => 'Find fælles interval og påvirkede IP-adresser for en liste af IP-adresser',
	'checkuser-cidr-res' => 'Fælles CIDR:',
	'checkuser-empty' => 'Loggen indeholder ingen poster.',
	'checkuser-nomatch' => 'Ingen matchende resultater blev fundet.',
	'checkuser-nomatch-edits' => 'Ingen matchende resultater blev fundet.
Seneste redigering var $1 $2.',
	'checkuser-check' => 'Check',
	'checkuser-log-fail' => 'Kunne ikke tilføje log-post',
	'checkuser-nolog' => 'Logfilen blev ikke fundet.',
	'checkuser-blocked' => 'Blokeret',
	'checkuser-gblocked' => 'Blokeret globalt',
	'checkuser-locked' => 'Låst',
	'checkuser-wasblocked' => 'Tidligere blokeret',
	'checkuser-localonly' => 'Ikke slået sammen',
	'checkuser-massblock' => 'Bloker valgte brugere',
	'checkuser-massblock-text' => 'De valgte konti vil blive blokeret uendeligt, med autoblok aktiveret og kontooprettelse blokeret. <br />IP-adresser vil blive blokeret i en uge (en blokering, der kun gælder for ip-adresser) og med kontooprettelse blokeret.',
	'checkuser-blocktag' => 'Erstat brugersider med:',
	'checkuser-blocktag-talk' => 'Erstat diskussionssider med:',
	'checkuser-massblock-commit' => 'Bloker valgte brugere',
	'checkuser-block-success' => '{{PLURAL:$2|Brugeren|Brugerne}} $1 {{PLURAL:$2|er|er}} nu {{PLURAL:$2|blokeret|blokerede}}',
	'checkuser-block-failure' => "'''Ingen brugere blev blokeret.'''",
	'checkuser-block-limit' => 'Der er valgt for mange brugere.',
	'checkuser-block-noreason' => 'Du skal angive en blokeringsgrund.',
	'checkuser-noreason' => 'Du skal angive en begrundelse for denne forespørgsel.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|ny konto|nye kontoer}}',
	'checkuser-too-many' => "For mange resultater, gør CIDR'en mindre. Her er de brugte IP'er (max 5000, sorteret efter adresse):",
	'checkuser-user-nonexistent' => 'Den anførte bruger eksisterer ikke.',
	'checkuser-search-form' => 'Find log-poster hvor $1 er $2',
	'checkuser-search-submit' => 'Søg',
	'checkuser-search-initiator' => 'initiativtager',
	'checkuser-search-target' => 'mål',
	'checkuser-ipeditcount' => '~$1 fra alle brugere',
	'checkuser-log-return' => 'Gå tilbage til hovedformularen for checkbruger',
	'checkuser-limited' => "'''Disse resultater er blevet afkortet af hensyn til ydeevnen.'''",
	'checkuser-log-userips' => "$1 fik IP'er for $2",
	'checkuser-log-ipedits' => '$1 fik redigeringer for $2',
	'checkuser-log-ipusers' => '$1 fik brugere for $2',
	'checkuser-log-ipedits-xff' => '$1 fik redigeringer for XFF $2',
	'checkuser-log-ipusers-xff' => '$1 fik brugere for XFF $2',
	'checkuser-log-useredits' => '$1 hentede redigeringer for $2',
	'checkuser-autocreate-action' => 'blev oprettet automatisk',
	'checkuser-create-action' => 'blev oprettet',
	'checkuser-email-action' => 'sendte en email til "$1"',
	'checkuser-reset-action' => 'nulstillede adgangskoden for "$1"',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 * @author Pill
 * @author Purodha
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'checkuser-summary' => 'Dieses Werkzeug durchsucht die letzten Änderungen, um die IP-Adressen eines Benutzers bzw. die Bearbeitungen/Benutzernamen für eine IP-Adresse zu ermitteln. Benutzer und Bearbeitungen einer IP-Adresse können auch nach Informationen aus den XFF-Headern abgefragt werden, indem der IP-Adresse ein „/xff“ angehängt wird. IPv4 (CIDR 16-32) und IPv6 (CIDR 64-128) werden unterstützt.
Aus Performance-Gründen werden maximal 5000 Bearbeitungen ausgegeben. Benutze CheckUser ausschließlich in Übereinstimmung mit den Datenschutzrichtlinien.',
	'checkuser-desc' => 'Ermöglicht die Überprüfung von IP-Adressen sowie weiterer Informationen von Benutzern',
	'checkuser-logcase' => 'Die Suche im Logbuch unterscheidet zwischen Groß- und Kleinschreibung.',
	'checkuser' => 'Checkuser',
	'checkuserlog' => 'Checkuser-Logbuch',
	'checkuser-contribs' => 'IP-Adressen von Benutzer prüfen',
	'group-checkuser' => 'Checkuser',
	'group-checkuser-member' => '{{GENDER:$1|Checkuser-Berechtigter|Checkuser-Berechtigte}}',
	'right-checkuser' => 'IP-Adressen sowie Zusammenhänge zwischen IP-Adressen und angemeldeten Benutzern prüfen',
	'right-checkuser-log' => 'Checkuser-Logbuch einsehen',
	'action-checkuser' => 'IP-Adressen sowie Zusammenhänge zwischen IP-Adressen und angemeldeten Benutzern zu prüfen',
	'action-checkuser-log' => 'das Checkuser-Logbuch einzusehen',
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Grund:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Logbuch anzeigen',
	'checkuser-query' => 'Letzte Änderungen abfragen',
	'checkuser-target' => 'IP-Adresse oder Benutzername:',
	'checkuser-users' => 'Hole Benutzer',
	'checkuser-edits' => 'Bearbeitungen abrufen',
	'checkuser-ips' => 'Hole IP-Adressen',
	'checkuser-search' => 'Suchen',
	'checkuser-period' => 'Dauer:',
	'checkuser-week-1' => 'letzte 7 Tage',
	'checkuser-week-2' => 'letzte 14 Tage',
	'checkuser-month' => 'letzte 30 Tage',
	'checkuser-all' => 'alle',
	'checkuser-cidr-label' => 'Finde gemeinsamen Adressbereich und betroffene Adressen für eine Liste von IP-Adressen',
	'checkuser-cidr-res' => 'Gemeinschaftliche CIDR:',
	'checkuser-empty' => 'Das Logbuch enthält keine Einträge.',
	'checkuser-nomatch' => 'Keine Übereinstimmungen gefunden.',
	'checkuser-nomatch-edits' => 'Keine Übereinstimmungen gefunden. Letzte Bearbeitung hat am $1 um $2 Uhr stattgefunden.',
	'checkuser-check' => 'Ausführen',
	'checkuser-log-fail' => 'Logbuch-Eintrag kann nicht hinzugefügt werden.',
	'checkuser-nolog' => 'Keine Logbuchdatei vorhanden.',
	'checkuser-blocked' => 'gesperrt',
	'checkuser-gblocked' => 'global gesperrt',
	'checkuser-locked' => 'geschlossen',
	'checkuser-wasblocked' => 'ehemals gesperrt',
	'checkuser-localonly' => 'nicht zusammengeführt',
	'checkuser-massblock' => 'Ausgewählte Benutzer sperren',
	'checkuser-massblock-text' => 'Die ausgewählten Benutzerkonten werden dauerhaft gesperrt (Autoblock ist aktiv, die Anlage neuer Benutzerkonten wird unterbunden).
IP-Adressen werden für eine Woche gesperrt (nur für unangemeldete Benutzer, die Anlage neuer Benutzerkonten wird unterbunden).',
	'checkuser-blocktag' => 'Inhalt der Benutzerseite ersetzen durch:',
	'checkuser-blocktag-talk' => 'Diskussionsseiten ersetzen durch:',
	'checkuser-massblock-commit' => 'Ausgewählte Benutzer sperren',
	'checkuser-block-success' => "'''{{PLURAL:$2|Der Benutzer|Die Benutzer}} $1 {{PLURAL:$2|wurde|wurden}} gesperrt.'''",
	'checkuser-block-failure' => "'''Es wurden keine Benutzer gesperrt.'''",
	'checkuser-block-limit' => 'Es wurden zuviele Benutzer ausgewählt.',
	'checkuser-block-noreason' => 'Du musst einen Grund für die Sperre angeben.',
	'checkuser-noreason' => 'Für diese Abfrage muss eine Begründung angegeben werden.',
	'checkuser-accounts' => '{{PLURAL:$1|1 neues Benutzerkonto|$1 neue Benutzerkonten}}',
	'checkuser-too-many' => 'Die Ergebnisliste ist zu lang (nach der Schätzung), bitte grenze den IP-Bereich weiter ein. Hier sind die benutzten IP-Adressen (maximal 5000, sortiert nach Adresse):',
	'checkuser-user-nonexistent' => 'Das angegebene Benutzerkonto ist nicht vorhanden.',
	'checkuser-search-form' => 'Suche Logbucheinträge, bei denen $1 $2 ist.',
	'checkuser-search-submit' => 'Suche',
	'checkuser-search-initiator' => 'CheckUser-Berechtigter',
	'checkuser-search-target' => 'Abfrageziel (Benutzerkonto/IP-Adresse)',
	'checkuser-ipeditcount' => '~ $1 von allen Benutzern',
	'checkuser-log-return' => 'Zum CheckUser-Hauptformular wechseln',
	'checkuser-limited' => "'''Die Ergebnisliste wurde aus Performancegründen gekürzt.'''",
	'checkuser-log-userips' => '$1 holte IP-Adressen für $2',
	'checkuser-log-ipedits' => '$1 holte Bearbeitungen für $2',
	'checkuser-log-ipusers' => '$1 holte Benutzer für $2',
	'checkuser-log-ipedits-xff' => '$1 holte Bearbeitungen für XFF $2',
	'checkuser-log-ipusers-xff' => '$1 holte Benutzer für XFF $2',
	'checkuser-log-useredits' => '$1 holte Bearbeitungen für $2',
	'checkuser-autocreate-action' => 'automatisch erstellt',
	'checkuser-create-action' => 'wurde erstellt',
	'checkuser-email-action' => 'sendete E-Mail an „$1“',
	'checkuser-reset-action' => 'Anforderung eines neuen Passwortes für „Benutzer:$1“',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'checkuser-summary' => 'Dieses Werkzeug durchsucht die letzten Änderungen, um die IP-Adressen eines Benutzers bzw. die Bearbeitungen/Benutzernamen für eine IP-Adresse zu ermitteln. Benutzer und Bearbeitungen einer IP-Adresse können auch nach Informationen aus den XFF-Headern abgefragt werden, indem der IP-Adresse ein „/xff“ angehängt wird. IPv4 (CIDR 16-32) und IPv6 (CIDR 64-128) werden unterstützt.
Aus Performance-Gründen werden maximal 5000 Bearbeitungen ausgegeben. Benutzen Sie CheckUser ausschließlich in Übereinstimmung mit den Datenschutzrichtlinien.',
	'checkuser-block-noreason' => 'Sie müssen einen Grund für die Sperre angeben.',
	'checkuser-too-many' => 'Die Ergebnisliste ist zu lang (nach der Schätzung), bitte grenzen Sie den IP-Bereich weiter ein. Hier sind die benutzten IP-Adressen (maximal 5000, sortiert nach Adresse):',
);

/** Zazaki (Zazaki)
 * @author Mirzali
 * @author Xoser
 */
$messages['diq'] = array(
	'checkuser-summary' => 'Ena xacet vurnayişanê neweyî skan keno ke adresanê IPyan reyan biyaro ke bimucne datayê karberî ser yew adresê IPyî.
Karberan u vurnayîşan ke yew IPyê karberî kerd reyna yeno pê XFF u "/xff". IPv4 (CIDR 16-32) u IPv6 (CIDR 64-128) rê zi destek beno.
5000 zafyer vurnayîşan sero netice nidano, qe performans hedi beno.
Ena politika ma ser kar bike.',
	'checkuser-desc' => 'Karberan rê destur bide ke adresanê IPyan u enformasyonê bînan kontrol bike',
	'checkuser-logcase' => 'Ena bigêrayîşê logî case sensitive o.',
	'checkuser' => 'Karber kontrol bike',
	'checkuserlog' => 'Cıkewtışê karberi qontrol ke',
	'checkuser-contribs' => 'Adresê IP yê karberî kontrol bike',
	'group-checkuser' => 'Karberî kontrol bike',
	'group-checkuser-member' => 'Karber kontrol bike',
	'right-checkuser' => 'Adresê IP yê karberî u enformasyonê binî kontrol bike',
	'right-checkuser-log' => 'Logê karber-kontrolî bivîne',
	'grouppage-checkuser' => '{{ns:project}}:Karber kontrol bike',
	'checkuser-reason' => 'Sebeb:',
	'checkuser-showlog' => 'Logê mucnayîşî',
	'checkuser-query' => 'Bigêrayîşî de vurnayîşanê penîyan',
	'checkuser-target' => 'Adresa IPi ya zi namey karberi:',
	'checkuser-users' => 'Karberî bivîne',
	'checkuser-edits' => 'Bivîne vurnayîşê ke IP ra',
	'checkuser-ips' => 'Adresê IPyî bivîne',
	'checkuser-search' => 'Bigêre',
	'checkuser-period' => 'Sure:',
	'checkuser-week-1' => 'hefteyê verînî',
	'checkuser-week-2' => 'di hefteyê verînî',
	'checkuser-month' => '30 rocê verînî',
	'checkuser-all' => 'hemî',
	'checkuser-cidr-label' => 'Qe yew listeyê IPyanî, yew menzilê ortakî u adresanê IPyanî bivîne',
	'checkuser-cidr-res' => 'CIDRê muşterekî',
	'checkuser-empty' => 'Ena log de çik çin o.',
	'checkuser-nomatch' => 'Çik çin o.',
	'checkuser-nomatch-edits' => 'Çik çin o.
Vurnayîşê tewr penî seet $1 u rocê $2 de biyo.',
	'checkuser-check' => 'Kontrol bike',
	'checkuser-log-fail' => 'Nieşkeno log debiker',
	'checkuser-nolog' => 'Dosyayê logî çin o.',
	'checkuser-blocked' => 'Blok biya',
	'checkuser-gblocked' => 'Global de blok biya',
	'checkuser-locked' => 'Kilit biya',
	'checkuser-wasblocked' => 'Verni de blok biya',
	'checkuser-localonly' => 'Yew niyo',
	'checkuser-massblock' => 'Karberê ke ti weçîno înan blok bike',
	'checkuser-massblock-text' => 'Hesabanê weçineye ebedi blok beno, pê otoblokî a biyo u hesab viraştişî qefilnayo.
Adresanê IPyan yew hefte blok beno, pê hesab viraştişî qefilnayo.',
	'checkuser-blocktag' => 'Pelanê karberan pê înan bivurne:',
	'checkuser-blocktag-talk' => 'Pelanê minaqeşeyî pê înan bivurne:',
	'checkuser-massblock-commit' => 'Karberê ke ti weçîno înan blok bike',
	'checkuser-block-success' => "'''{{PLURAL:$2|Karber|Karberan}} $1 eka blok bi{{PLURAL:$2|y|yê}}.'''",
	'checkuser-block-failure' => "'''Çew blok nibiya.'''",
	'checkuser-block-limit' => 'Ti zaf karberan weçino.',
	'checkuser-block-noreason' => 'Qe blokan, ti gani yew sebeb bide.',
	'checkuser-noreason' => 'Qe bigêrayîşî, ti gani yew sebeb bide.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|hesab|hesaban}} newî',
	'checkuser-too-many' => 'Zaf neticiyan esto (ser texminê cigeyrayîşî), şima ra rica keno CIDR qickek bike.
Tiya de IPyan ke sero kar biyo  (5000 max, pê adresan):',
	'checkuser-user-nonexistent' => 'Karbero ke ti specife kerd, ay database ma de niesto.',
	'checkuser-search-form' => 'Entryanê logan ke $1 biy $2, înan bivîne',
	'checkuser-search-submit' => 'Bigêre',
	'checkuser-search-initiator' => 'başlî kerdoğ',
	'checkuser-search-target' => 'hedef',
	'checkuser-ipeditcount' => '~$1 karberanê hemî ra',
	'checkuser-log-return' => 'Farmê serî CheckUser rê reyna şî',
	'checkuser-limited' => "'''Ena neticeyan qe sebabanê performansî ra kilm kerd.'''",
	'checkuser-log-userips' => 'Qe $2, $1adresanê IPyan girewt',
	'checkuser-log-ipedits' => 'Qe $2, $1vurnayîşan girewt',
	'checkuser-log-ipusers' => 'Qe $2, $1 karberan girewt',
	'checkuser-log-ipedits-xff' => 'Qe $2, $1vurnayîşan ser XFF girewt',
	'checkuser-log-ipusers-xff' => 'Qe $2, $1karberan ser XFF girewt',
	'checkuser-log-useredits' => 'Qe $2, $1vurnayîşan girewt',
	'checkuser-autocreate-action' => 'otomatikî ra virziyo',
	'checkuser-email-action' => 'karberê $1î rê email şîravt',
	'checkuser-reset-action' => "qe karberê ''$1''î parola reset bike",
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'checkuser-summary' => 'Toś ten rěd skanujo aktualne změny, aby wótwołał IP-adresy wužywarja abo pokazał změny/wužywarske daty za IP-adresu.
Wužywarje a změny IP-adresy daju se pśez głowowe smužki XFF wótwołaś, z tym až "/xff" pśidawa se IP-adresy. IPv4 (CIDR 16-32) a IPv6 (CIDR 64-128) se pódpěratej.
Z pśicynow wugbałosći wróśijo se nic wěcej ako 5000 změnow. Wužyj CheckUser pó zasadach priwatnosći.',
	'checkuser-desc' => 'Dajo wužywarjam z wótpowědnym pšawom móžnosć IP-adrese a druge informacije wužywarja kontrolowaś',
	'checkuser-logcase' => 'Pytanje w protokolu rozeznawaju mjazy wjeliko- a małopisanjom.',
	'checkuser' => 'Kontrola wužywarjow',
	'checkuserlog' => 'Protokol kontrole wužywarjow',
	'checkuser-contribs' => 'Wužywarske IP pśeglědaś',
	'group-checkuser' => 'Kontrolery wužywarjow',
	'group-checkuser-member' => '{{GENDER:$1|kontroler wužywarjow|kontrolerka wužywarjow}}',
	'right-checkuser' => 'Wužywarske IP-adrese a druge informacije kontrolěrowaś',
	'right-checkuser-log' => 'Protokol kontrole wužywarjow se woglědaś',
	'action-checkuser' => 'Wužywarske IP-adrese a druge informacije kontrolěrowaś',
	'action-checkuser-log' => 'Protokol kontrolnego wužywarja se woglědaś',
	'grouppage-checkuser' => '{{ns:project}}:Kontroler wužywarjow',
	'checkuser-reason' => 'Pśicyna:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Protokol pokazaś',
	'checkuser-query' => 'Aktualne změny wótpšašaś',
	'checkuser-target' => 'IP-adresa abo wužywarske mě:',
	'checkuser-users' => 'Wužywarjow wobstaraś',
	'checkuser-edits' => 'Změny wótwołaś',
	'checkuser-ips' => 'IP-adrese wobstraś',
	'checkuser-search' => 'Pytaś',
	'checkuser-period' => 'Cas:',
	'checkuser-week-1' => 'slědny tyźeń',
	'checkuser-week-2' => 'slědnej dwa tyźenja',
	'checkuser-month' => 'slědnych 30 dnjow',
	'checkuser-all' => 'wše',
	'checkuser-cidr-label' => 'Zgromadny wobcerk a pótrjefjone adrese za lisćinu IP-adresow namakaś',
	'checkuser-cidr-res' => 'Zgromadny CIDR:',
	'checkuser-empty' => 'Protokol njewopśimujo žedne zapiski.',
	'checkuser-nomatch' => 'Žedne wótpowědniki namakane.',
	'checkuser-nomatch-edits' => 'Žedne wótpowědniki namakane.
Slědna změna jo $1 $2 była.',
	'checkuser-check' => 'Kontrolěrowaś',
	'checkuser-log-fail' => 'Protokolowy zapisk njedajo se pśidaś',
	'checkuser-nolog' => 'Žedna protokolowa dataja namakana.',
	'checkuser-blocked' => 'Blokěrowany',
	'checkuser-gblocked' => 'Globalnje blokěrowany',
	'checkuser-locked' => 'Zastajony',
	'checkuser-wasblocked' => 'Do togo blokěrowany',
	'checkuser-localonly' => 'Njezjadnośone',
	'checkuser-massblock' => 'Wubranych wužywarjow blokěrowaś',
	'checkuser-massblock-text' => 'Wubrane konta blokěruju se na njewěsty cas - awtomatiske blokěrowanje jo aktiwne a załoženje kontow jo znjemóžnjone.
IP-adrese budu se jano za IP-wužywarjow na 1 tyźeń blokěrowaś - załoženje kontow jo znjemóžnjone.',
	'checkuser-blocktag' => 'Wužywarske boki narownaś pśez:',
	'checkuser-blocktag-talk' => 'Diskusijne boki narownaś pśez:',
	'checkuser-massblock-commit' => 'Wubranych wužywarjow blokěrowaś',
	'checkuser-block-success' => "'''{{PLURAL:$2|Wužywaŕ|Wužywarja|Wužywarje|Wužywarje}} $1 {{PLURAL:$2|jo|stej|su|su}} něnto {{PLURAL:$2|blokěrowany|blokěrowanej|blokěrowane|blokěrowane}}.'''",
	'checkuser-block-failure' => "'''Žedne wužywarje blokěrowane.'''",
	'checkuser-block-limit' => 'Pśewjele wužywarjow wubrane.',
	'checkuser-block-noreason' => 'Musyš pśicynu za blokěrowanja pódaś.',
	'checkuser-noreason' => 'Musyš pśicynu za toś to wótpšašanje pódaś.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nowe konto|nowej konśe|nowe konta|nowych kontow}}',
	'checkuser-too-many' => 'Pśewjele wuslědkow (pó pówoblicenju napšašowanja), pšosym wobgranicuj CIDR. How su wužywane IP-adrese (maks. 5000, pséwuběrane pó adresu):',
	'checkuser-user-nonexistent' => 'Pódany wužywaŕ njeeksistěrujo.',
	'checkuser-search-form' => 'Protokolowe zapiski namakaś, źož $1 jo $2',
	'checkuser-search-submit' => 'Pytaś',
	'checkuser-search-initiator' => 'iniciator',
	'checkuser-search-target' => 'cel',
	'checkuser-ipeditcount' => '~$1 ze wšych wužywarjow',
	'checkuser-log-return' => 'Slědk ku głownemu formularoju CheckUser',
	'checkuser-limited' => "'''Toś te wuslědki su se z pśicynow wugbałosći wobrězali.'''",
	'checkuser-log-userips' => '$1 jo IP-adrese za $2 wobstarał',
	'checkuser-log-ipedits' => '$1 jo změny za $2 wobstarał',
	'checkuser-log-ipusers' => '$1 jo wužywarjow za $2 wobstarał',
	'checkuser-log-ipedits-xff' => '$1 jo změny za XFF $2 wobstarał',
	'checkuser-log-ipusers-xff' => '$1 jo wužywarjow za XFF $2 wobstarał',
	'checkuser-log-useredits' => '$1 jo změny za $2 wobstarał',
	'checkuser-autocreate-action' => 'jo se awtomatiski załožyło',
	'checkuser-create-action' => 'jo se napórał',
	'checkuser-email-action' => 'jo e-mail na wužywarja "$1" pósłał',
	'checkuser-reset-action' => 'gronidło za wužywarja "$1" wótnowiś',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'checkuser-search' => 'Dii',
	'checkuser-search-submit' => 'Dii',
);

/** Greek (Ελληνικά)
 * @author AK
 * @author Assassingr
 * @author Consta
 * @author Crazymadlover
 * @author Glavkos
 * @author K sal 15
 * @author Konsnos
 * @author Omnipaedista
 * @author ZaDiak
 * @author Απεργός
 */
$messages['el'] = array(
	'checkuser-summary' => 'Αυτό το εργαλείο σαρώνει τις πρόσφατες αλλαγές για να ανακτήσει τις IP διευθύνσεις που χρησιμοποιούνται από ένα χρήστη ή για να δείξει τα δεδομένα επεξεργασιών/χρηστών για μία IP.
Χρήστες και επεξεργασίες από μία σταθερή IP μπορούν να ανακτηθούν μέσω XFF επικεφαλίδων προσαρτώντας "/xff" στην IP. Το IPv4 (CIDR 16-32) και το IPv6 (CIDR 64-128) υποστηρίζονται.
Όχι περισσότερες από 5000 επεξεργασίες θα επιστραφούν για λόγους απόδοσης.
Χρησιμοποιήστε αυτό σύμφωνα με την πολιτική.',
	'checkuser-desc' => 'Παρέχει στους χρήστες με την κατάλληλη άδεια την ικανότητα να ελέγχουν τη διεύθυνση IP ενός χρήστη καθώς και άλλες πληροφορίες',
	'checkuser-logcase' => 'Η αναζήτηση στο αρχείο καταγραφής διακρίνει πεζά από κεφαλαία.',
	'checkuser' => 'Ελεγκτής',
	'checkuserlog' => 'Αρχείο καταγραφής ελεγχών',
	'checkuser-contribs' => 'έλεγχος των IP χρηστών',
	'group-checkuser' => 'Ελεγκτές',
	'group-checkuser-member' => 'Ελεγκτής',
	'right-checkuser' => 'Έλεγχος IP διεύθυνσης και άλλων πληροφοριών χρήστη',
	'right-checkuser-log' => 'Δείτε τις καταγραφές ελέγχων',
	'action-checkuser' => 'ελέγξτε διευθύνσεις IP των χρηστών καθώς και άλλες πληροφορίες',
	'grouppage-checkuser' => '{{ns:project}}:Ελεγκτής',
	'checkuser-reason' => 'Λόγος:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Εμφάνιση αρχείου καταγραφής',
	'checkuser-query' => 'Αναζήτηση στις πρόσφατες αλλαγές',
	'checkuser-target' => 'Διεύθυνση IP ή όνομα χρήστη:',
	'checkuser-users' => 'Λήψη χρηστών',
	'checkuser-edits' => 'Λήψη επεξεργασιών',
	'checkuser-ips' => 'Λήψη των IP',
	'checkuser-search' => 'Αναζήτηση',
	'checkuser-period' => 'Διάρκεια:',
	'checkuser-week-1' => 'τελευταία εβδομάδα',
	'checkuser-week-2' => 'τις τελευταίες δύο εβδομάδες',
	'checkuser-month' => 'τις τελευταίες 30 ημέρες',
	'checkuser-all' => 'όλα',
	'checkuser-cidr-label' => 'Εύρεση κοινής σειράς και επηρεασμένων διευθύνσεων για μια λίστα IP',
	'checkuser-cidr-res' => 'Κοινό CIDR:',
	'checkuser-empty' => 'Το αρχείο καταγραφής δεν περιέχει κανένα αντικείμενο.',
	'checkuser-nomatch' => 'Δεν βρέθηκαν σχετικές σελίδες.',
	'checkuser-nomatch-edits' => 'Δεν βρέθηκαν αποτελέσματα που να ταιριάζουν.
Η τελευταία επεξεργασία ήταν στις $1 στις $2.',
	'checkuser-check' => 'Έλεγχος',
	'checkuser-log-fail' => 'Δεν είναι δυνατή η προσθήκη εγγραφής στο αρχείο καταγραφών',
	'checkuser-nolog' => 'Δεν βρέθηκε κανένα αρχείο καταγραφής.',
	'checkuser-blocked' => 'Φραγμένος',
	'checkuser-gblocked' => 'Καθολικά φραγμένος',
	'checkuser-locked' => 'Κλειδωμένο',
	'checkuser-wasblocked' => 'Προηγουμένως φραγμένος',
	'checkuser-localonly' => 'Μη ενοποιημένο',
	'checkuser-massblock' => 'Επιβολή φραγής στους επιλεγμένους χρήστες',
	'checkuser-massblock-text' => "Οι επιλεγμένοι λογαριασμοί θα φραγούν επ' αόριστον, με την αυτόματη φραγή ενεργοποιημένη και με αδύνατη τη δημιουργία λογαριασμού.
Οι διευθύνσεις IP θα φραγούν για 1 εβδομάδα μόνο για τους χρήστες από IP και με αδύνατη τη δημιουργία λογαριασμού.",
	'checkuser-blocktag' => 'Αντικατάσταση των σελίδων των χρηστών με:',
	'checkuser-blocktag-talk' => 'Αντικαταστήστε τις σελίδες συζήτησης με:',
	'checkuser-massblock-commit' => 'Φραγή επιλεγμένων χρηστών',
	'checkuser-block-success' => "'''{{PLURAL:$2|Ο χρήστης|Οι χρήστες}} $1 είναι τώρα {{PLURAL:$2|φραγμένος|φραγμένοι}}.'''",
	'checkuser-block-failure' => "'''Κανένας χρήστης φραγμένος.'''",
	'checkuser-block-limit' => 'Έχουν επιλεχθεί πάρα πολλοί χρήστες.',
	'checkuser-block-noreason' => 'Πρέπει να αιτιολογήσετε τις φραγές.',
	'checkuser-noreason' => 'Πρέπει να δώσετε μια αιτία για αυτή την ερώτηση.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|νέος λογαριασμός|νέοι λογαριασμοί}}',
	'checkuser-too-many' => 'Πάρα πολλά αποτελέσματα (σύμφωνα με την εκτίμηση σειράς), παρακαλούμε στενέψτε το CIDR.
Παρακάτω είναι οι διευθύνσεις IP που χρησιμοποιούνται (με ανώτατο όριο τις 5000, ταξινομημένες κατά διεύθυνση):',
	'checkuser-user-nonexistent' => 'Ο συγκεκριμένος χρήστης δεν υπάρχει.',
	'checkuser-search-form' => 'Εύρεση εγγραφών του αρχείου καταγραφής στις οποίες ο $1 είναι $2',
	'checkuser-search-submit' => 'Αναζήτηση',
	'checkuser-search-initiator' => 'ελεγκτής',
	'checkuser-search-target' => 'στόχος',
	'checkuser-ipeditcount' => '~$1 από όλους τους χρήστες',
	'checkuser-log-return' => 'Επιστροφή στην κύρια φόρμα ελέγχου χρήστη',
	'checkuser-limited' => "'''Αυτά τα αποτελέσματα περικόπησαν για λόγους απόδοσης.'''",
	'checkuser-log-userips' => 'Ο $1 πήρε τις IP διευθύνσεις για τον $2',
	'checkuser-log-ipedits' => 'Ο $1 πήρε τις επεξεργασίες για το $2',
	'checkuser-log-ipusers' => 'Ο $1 πήρε τους χρήστες για το $2',
	'checkuser-log-ipedits-xff' => 'Ο $1 πήρε τις επεξεργασίες για το XFF $2',
	'checkuser-log-ipusers-xff' => 'Ο $1 πήρε τους χρήστες για το XFF $2',
	'checkuser-log-useredits' => '$1 έλαβε τις επεξεργασίες για τον $2',
	'checkuser-autocreate-action' => 'δημιουργήθηκε αυτόματα',
	'checkuser-create-action' => 'δημιουργήθηκε',
	'checkuser-email-action' => 'έστειλε ένα ηλεκτρονικό μήνυμα στον χρήστη "$1"',
	'checkuser-reset-action' => 'αποστολή νέου κωδικού για τον χρήστη "$1"',
);

/** Esperanto (Esperanto)
 * @author Blahma
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'checkuser-summary' => 'Ĉi tiu ilo skanas lastajn ŝanĝojn por akiri la IP-adresojn uzatajn de uzanto aŭ montri la datenojn de redakto/uzanto por aparta IP-adreso.
Uzantoj kaj redaktoj de klienta IP-adreso povas esti akirita per XFF-titolaro postaldonante al la IP-adreso kun "/xff".
IPv4 (CIDR 16-32) kaj IPv6 (CIDR 64-128) estas subtenataj.
Neniom pli ol 5000 redaktoj estos montrita pro bona datumbaza funkciado.
Uzu ĉi tion laŭ regularo.',
	'checkuser-desc' => 'Rajtigas al uzantoj kun la taŭga permeso la kapableco kontroli la IP-adreson de uzanto kaj alia informo',
	'checkuser-logcase' => 'La protokola serĉo estas usklecodistinga.',
	'checkuser' => 'Kontrolanto de IP-adresoj',
	'checkuserlog' => 'Protokolo pri kontrolado de uzantoj',
	'checkuser-contribs' => 'kontroli IP-adresojn de uzantoj',
	'group-checkuser' => 'Kontrolaj uzantoj',
	'group-checkuser-member' => '{{GENDER:$1|Kontrolanto de IP-adresoj|Kontrolantino de IP-adresoj}}',
	'right-checkuser' => 'Kontroli la IP-adreson kaj alian informon de uzanto',
	'right-checkuser-log' => 'Vidi la protokolon pri kontrolantoj de IP-adresoj',
	'action-checkuser' => 'kontroli la IP-adreson kaj aliajn informojn de la uzanto',
	'action-checkuser-log' => 'vidi la protokolon pri kontrolantoj de IP-adresoj',
	'grouppage-checkuser' => '{{ns:project}}:Kontrolanto de IP-adresoj',
	'checkuser-reason' => 'Kialo:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Montri protokolon',
	'checkuser-query' => 'Informomendi lastatempajn ŝanĝojn',
	'checkuser-target' => 'IP-adreso aŭ salutnomo:',
	'checkuser-users' => 'Akiri uzantojn',
	'checkuser-edits' => 'Mendi redaktojn',
	'checkuser-ips' => 'Preni IP-adresojn',
	'checkuser-search' => 'Serĉi',
	'checkuser-period' => 'Daŭro:',
	'checkuser-week-1' => 'lasta semajno',
	'checkuser-week-2' => 'lastaj du semajnoj',
	'checkuser-month' => 'lastaj 30 tagoj',
	'checkuser-all' => 'ĉiuj',
	'checkuser-cidr-label' => 'Trovi komuna intervalo kaj efektitaj adresoj por listo de IP-adresoj',
	'checkuser-cidr-res' => 'Komuna CIDR:',
	'checkuser-empty' => 'La protokolo estas malplena.',
	'checkuser-nomatch' => 'Neniujn pafojn trovis.',
	'checkuser-nomatch-edits' => 'Neniuj trafoj troviĝis. Lasta redakto estis je $1, $2.',
	'checkuser-check' => 'Kontroli',
	'checkuser-log-fail' => 'Ne eblis aldoni protokoleron.',
	'checkuser-nolog' => 'Neniu protokolo estas trovita.',
	'checkuser-blocked' => 'Forbarita',
	'checkuser-gblocked' => 'Forbarita ĝenerale',
	'checkuser-locked' => 'Ŝlosita',
	'checkuser-wasblocked' => 'Antaŭe forbarita',
	'checkuser-localonly' => 'Nekunigita',
	'checkuser-massblock' => 'Forbari elektitajn uzantojn',
	'checkuser-massblock-text' => 'Elektitaj kontoj estos forbaritaj senlime, kun aŭtomata forbaro ŝaltita kaj kont-kreado malŝaltita.
IP-adresoj estos forbarita 1 semajnon por IP-uzantoj kun kont-kreado malŝaltita.',
	'checkuser-blocktag' => 'Anstataŭigi uzanto-paĝojn kun:',
	'checkuser-blocktag-talk' => 'Anstataŭigi diskuto-paĝojn kun:',
	'checkuser-massblock-commit' => 'Forbari elektitajn uzantojn',
	'checkuser-block-success' => "'''La {{PLURAL:$2|uzanto|uzantoj}} $1 estas nun {{PLURAL:$2|forbarita|forbaritaj}}.'''",
	'checkuser-block-failure' => "'''Neniuj uzantoj forbariĝis.'''",
	'checkuser-block-limit' => 'Tro da uzantoj elektitaj.',
	'checkuser-block-noreason' => 'Vi devas doni kialon por la forbaroj.',
	'checkuser-noreason' => 'Vi devas doni kialon por ĉi tiu informomendo.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nova konto|novaj kontoj}}',
	'checkuser-too-many' => 'Tro da rezultoj, laŭ taskoj de serĉomendo. Bonvolu malvastigi la CIDR.
Jen la IP-adresoj uzitaj (maksimume 5000, ordigita laŭ adresoj):',
	'checkuser-user-nonexistent' => 'La donata uzanto ne ekzistas.',
	'checkuser-search-form' => 'Trovi protokolerojn en kiu la $1 estas $2',
	'checkuser-search-submit' => 'Serĉi',
	'checkuser-search-initiator' => 'inicianto',
	'checkuser-search-target' => 'celo',
	'checkuser-ipeditcount' => '~$1 de ĉiuj uzantoj',
	'checkuser-log-return' => 'Reiru al ĉefa kamparo por kontroli uzantojn',
	'checkuser-limited' => "'''Ĉi tiuj rezultoj estis stumpigitaj pro laborecaj kialoj.",
	'checkuser-log-userips' => '$1 akiris IP-adresojn por $2',
	'checkuser-log-ipedits' => '$1 akiris redaktojn por $2',
	'checkuser-log-ipusers' => '$1 akiris uzantojn por $2',
	'checkuser-log-ipedits-xff' => '$1 akiris redaktojn por XFF $2',
	'checkuser-log-ipusers-xff' => '$1 akiris uzantojn por XFF $2',
	'checkuser-log-useredits' => '$1 tenis redaktojn por $2',
	'checkuser-autocreate-action' => 'estis aŭtomate kreita',
	'checkuser-create-action' => 'estis kreita',
	'checkuser-email-action' => 'sendis retpoŝton al uzanto "$1"',
	'checkuser-reset-action' => 'restarigis pasvorton por uzanto "$1"',
);

/** Spanish (Español)
 * @author Aleator
 * @author AlimanRuna
 * @author Armando-Martin
 * @author Crazymadlover
 * @author Dferg
 * @author Dmcdevit
 * @author Imre
 * @author Jatrobat
 * @author Lin linao
 * @author Locos epraix
 * @author Manuelt15
 * @author Muro de Aguas
 * @author Piolinfax
 * @author Platonides
 * @author Remember the dot
 * @author Sanbec
 * @author Spacebirdy
 * @author Titoxd
 * @author VegaDark
 */
$messages['es'] = array(
	'checkuser-summary' => 'Esta herramienta explora los cambios recientes para obtener las IPs utilizadas por un usuario o para mostrar la información de ediciones/usuarios de una IP.
También se pueden obtener los usuarios y las ediciones de un cliente IP vía XFF añadiendo "/xff" al final de la IP. IPv4 (CIDR 16-32) y IPv6 (CIDR 64-128) funcionan.
No se muestran más de 5000 ediciones por motivos de rendimiento.
Usa esta herramienta de acuerdo con las políticas correspondientes.',
	'checkuser-desc' => 'Permite a los usuarios que tienen los permisos apropiados comprobar las direcciones IP de los usuarios además de otra información.',
	'checkuser-logcase' => 'La búsqueda en el registro distingue entre mayúsculas y minúsculas.',
	'checkuser' => 'Verificador de usuarios',
	'checkuserlog' => 'Registro de verificación de usuarios',
	'checkuser-contribs' => 'verificar las direcciones IP del usuario',
	'group-checkuser' => 'Verificadores de usuarios',
	'group-checkuser-member' => '{{GENDER:$1|verificador de usuarios|verificadora de usuarios}}',
	'right-checkuser' => 'Comprobar las IPs de los usuarios y obtener otra información relacionada',
	'right-checkuser-log' => 'Ver el registro de verificación de usuarios',
	'action-checkuser' => 'Comprobar las IPs de los usuarios y obtener otra información relacionada',
	'action-checkuser-log' => 'ver el registro de checkuser',
	'grouppage-checkuser' => '{{ns:project}}:Verificador de usuarios',
	'checkuser-reason' => 'Motivo:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Ver registro',
	'checkuser-query' => 'Buscar en cambios recientes',
	'checkuser-target' => 'Usuario o dirección IP:',
	'checkuser-users' => 'Obtener usuarios',
	'checkuser-edits' => 'Obtener ediciones',
	'checkuser-ips' => 'Obtener IP',
	'checkuser-search' => 'Buscar',
	'checkuser-period' => 'Duración:',
	'checkuser-week-1' => 'la semana pasada',
	'checkuser-week-2' => 'últimas dos semanas',
	'checkuser-month' => 'últimos 30 días',
	'checkuser-all' => 'todos',
	'checkuser-cidr-label' => 'Encontrar rango común y afectados de una lista de direcciones de IP',
	'checkuser-cidr-res' => 'CIDR común:',
	'checkuser-empty' => 'No hay elementos en el registro.',
	'checkuser-nomatch' => 'No hay elementos en el registro con esas condiciones.',
	'checkuser-nomatch-edits' => 'No se encontraron coincidencias.
La última edición fue el $1 a las $2',
	'checkuser-check' => 'Examinar',
	'checkuser-log-fail' => 'No se puede añadir este elemento al registro.',
	'checkuser-nolog' => 'No se encuentra ningún archivo del registro',
	'checkuser-blocked' => 'Bloqueado',
	'checkuser-gblocked' => 'Bloqueado globalmente',
	'checkuser-locked' => 'Cuenta bloqueada globalmente',
	'checkuser-wasblocked' => 'Bloqueado anteriormente',
	'checkuser-localonly' => 'No unificada',
	'checkuser-massblock' => 'Bloquear usuarios seleccionados',
	'checkuser-massblock-text' => 'Las cuentas seleccionadas serán bloqueadas de forma indefinida, con el autobloqueo habilitado y la creación de cuentas deshabilitada.
Las direcciones IP serán bloqueadas durante una semana para usuarios anónimos sólamente con la creación de cuentas deshabilitada.',
	'checkuser-blocktag' => 'Reemplazar páginas del usuario con:',
	'checkuser-blocktag-talk' => 'Reemplazar las páginas de discusión con:',
	'checkuser-massblock-commit' => 'Bloquear usuarios seleccionados',
	'checkuser-block-success' => "'''{{PLURAL:$2|El usuario|Los usuarios}} $1 {{PLURAL:$2|está bloqueado|están bloqueados}}.'''",
	'checkuser-block-failure' => "'''No hay usuarios bloqueados.'''",
	'checkuser-block-limit' => 'Demasiados usarios seleccionados.',
	'checkuser-block-noreason' => 'Debe dar una razón para los bloqueos.',
	'checkuser-noreason' => 'Debes dar una razón para esta consulta.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|cuenta nueva|cuentas nuevas}}',
	'checkuser-too-many' => 'Hay demasiados resultados (estimado), por favor limita el CIDR.
Aquí se ven las IPs usadas (máximo 5000, ordenadas según dirección):',
	'checkuser-user-nonexistent' => 'El usuario especificado no existe.',
	'checkuser-search-form' => 'Encontrar entradas de registros en las que el $1 es $2',
	'checkuser-search-submit' => 'Buscar',
	'checkuser-search-initiator' => 'verificador',
	'checkuser-search-target' => 'usuario verificado',
	'checkuser-ipeditcount' => '~$1 de todos los usuarios',
	'checkuser-log-return' => 'Volver al formulario principal de CheckUser',
	'checkuser-limited' => "'''Estos resultados han sido truncados por motivos de rendimiento.'''",
	'checkuser-log-userips' => '$1 obtuvo las direcciones IP de $2',
	'checkuser-log-ipedits' => '$1 obtuvo las contribuciones de $2',
	'checkuser-log-ipusers' => '$1 obtuvo los usuarios de $2',
	'checkuser-log-ipedits-xff' => '$1 obtuvo las contribuciones de XFF de $2',
	'checkuser-log-ipusers-xff' => '$1 obtuvo los usuarios para XFF $2',
	'checkuser-log-useredits' => '$1 obtuvo las contribuciones de $2',
	'checkuser-autocreate-action' => 'fue creada automáticamente',
	'checkuser-create-action' => 'fue creado',
	'checkuser-email-action' => 'envió un correo electrónico al usuario «$1»',
	'checkuser-reset-action' => 'solicitó un recordatorio de contraseña para el usuario «$1»',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 * @author WikedKentaur
 */
$messages['et'] = array(
	'checkuser-desc' => 'Võimaldab vajalike õigustega kasutajal teise kasutaja IP-aadresse ja muud teavet kontrollida.',
	'checkuser-logcase' => 'Logi otsing on tõusutundlik.',
	'checkuser' => 'Kasutajakontroll',
	'checkuserlog' => 'Kasutajakontrolli logi',
	'checkuser-contribs' => 'kasutaja IP-aadresside kontroll',
	'group-checkuser' => 'Kontrollkasutajad',
	'group-checkuser-member' => 'kontrollkasutaja',
	'right-checkuser' => 'Kontrollida kasutajate IP-aadresse ja muud teavet',
	'right-checkuser-log' => 'Vaadata kasutajakontrolli logi',
	'action-checkuser' => 'kontrollida kasutaja IP-aadresse ja muid andmeid',
	'action-checkuser-log' => 'vaadata kasutajakontrolli logi',
	'grouppage-checkuser' => '{{ns:project}}:Kontrollkasutajad',
	'checkuser-reason' => 'Põhjus:',
	'checkuser-showlog' => 'Näita logi',
	'checkuser-query' => 'Viimaste muudatuste päring',
	'checkuser-target' => 'IP-aadress või kasutajanimi:',
	'checkuser-users' => 'Hangi kasutajad',
	'checkuser-edits' => 'Hangi muudatused',
	'checkuser-ips' => 'Hangi IP-aadressid',
	'checkuser-search' => 'Otsi',
	'checkuser-period' => 'Ajavahemik:',
	'checkuser-week-1' => 'viimane nädal',
	'checkuser-week-2' => 'viimased kaks nädalat',
	'checkuser-month' => 'viimased 30 päeva',
	'checkuser-all' => 'kõik',
	'checkuser-empty' => 'Logi ei sisalda üksusi.',
	'checkuser-nomatch' => 'Tulemusi ei leitud.',
	'checkuser-nomatch-edits' => 'Vasteid ei leitud.
Viimane redigeerimisaeg: $1, $2.',
	'checkuser-check' => 'Kontrolli',
	'checkuser-log-fail' => 'Logisissekande lisamine ei õnnestu.',
	'checkuser-nolog' => 'Logifaili ei leitud.',
	'checkuser-blocked' => 'Blokeeritud',
	'checkuser-gblocked' => 'Globaalselt blokeeritud',
	'checkuser-locked' => 'Lukustatud',
	'checkuser-wasblocked' => 'Eelnevalt blokeeritud',
	'checkuser-localonly' => 'Ei ole globaalset kontot',
	'checkuser-massblock' => 'Blokeeri valitud kasutajad',
	'checkuser-massblock-text' => 'Valitud kontod blokeeritakse igaveseks, seejuures IP-aadressid blokeeritakse automaatselt ja keelatakse uute kontode tegemine.
Ainult anonüümsed kasutajad blokeeritakse nädalaks ja neil keelatakse uute kontode tegemine.',
	'checkuser-blocktag' => 'Asenda kasutajalehed:',
	'checkuser-blocktag-talk' => 'Asenda arutelulehed:',
	'checkuser-massblock-commit' => 'Blokeeri valitud kasutajad',
	'checkuser-block-success' => "'''{{PLURAL:$2|Kasutaja|Kasutajad}} $1 on nüüd blokeeritud.'''",
	'checkuser-block-failure' => "'''Ühtegi kasutajat ei blokeeritud.'''",
	'checkuser-block-limit' => 'Liiga palju kasutajaid valitud.',
	'checkuser-block-noreason' => 'Blokeeringule peab andma põhjenduse.',
	'checkuser-noreason' => 'Päringu jaoks peab põhjuse andma.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|uus konto|uut kontot}}',
	'checkuser-user-nonexistent' => 'Etteantud kasutajat pole olemas.',
	'checkuser-search-form' => 'Leia logisissekanded, kus $1 on $2',
	'checkuser-search-submit' => 'Otsi',
	'checkuser-search-initiator' => 'kontrollija',
	'checkuser-search-target' => 'kontrollitav',
	'checkuser-ipeditcount' => '~$1 kõigilt kasutajatelt',
	'checkuser-log-return' => 'Naase kasutajakontrolli peavormi juurde',
	'checkuser-log-userips' => '$1 hankis kasutaja $2 IP-aadressid',
	'checkuser-log-ipedits' => '$1 hankis IP-aadressi $2 tehtud muudatused',
	'checkuser-log-ipusers' => '$1 hankis IP-aadressi $2 kasutajad',
	'checkuser-log-ipedits-xff' => '$1 hankis IP-aadressi (XFF) $2 tehtud muudatused',
	'checkuser-log-ipusers-xff' => '$1 hankis IP-aadressi (XFF) $2 kasutajad',
	'checkuser-log-useredits' => '$1 hankis kasutaja $2 tehtud muudatused',
	'checkuser-autocreate-action' => 'loodud automaatselt',
	'checkuser-create-action' => 'loodud',
	'checkuser-email-action' => 'e-kiri kasutajale "$1" saadetud',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'checkuser' => 'Erabiltzailea egiaztatu',
	'group-checkuser' => 'Erabiltzaileak egiaztatu',
	'group-checkuser-member' => 'Erabiltzailea egiaztatu',
	'grouppage-checkuser' => '{{ns:project}}:Lankidea egiaztatu',
	'checkuser-reason' => 'Arrazoia:',
	'checkuser-showlog' => 'Erregistroa erakutsi',
	'checkuser-target' => 'IP helbide edo lankide izena:',
	'checkuser-users' => 'Lankideak ikusi',
	'checkuser-edits' => 'Aldaketak ikusi',
	'checkuser-ips' => 'IPak ikusi',
	'checkuser-search' => 'Bilatu',
	'checkuser-period' => 'Iraupena:',
	'checkuser-week-1' => 'azken astea',
	'checkuser-week-2' => 'azken bi asteak',
	'checkuser-month' => 'azken 30 egunak',
	'checkuser-all' => 'guztiak',
	'checkuser-nomatch' => 'Ez da bat datorren emaitzarik aurkitu.',
	'checkuser-check' => 'Egiaztatu',
	'checkuser-blocked' => 'Blokeatua',
	'checkuser-gblocked' => 'Proiektu guztietarako blokeatua',
	'checkuser-locked' => 'Babestua',
	'checkuser-wasblocked' => 'Aurretik blokeatua',
	'checkuser-localonly' => 'Batu gabe',
	'checkuser-massblock' => 'Hautatutako lankideak blokeatu',
	'checkuser-massblock-commit' => 'Aukeratutako erabiltzaileak blokeatu',
	'checkuser-block-success' => "'''$1 {{PLURAL:$2|erabiltzailea|erabiltzaileak}} blokeaturik {{PLURAL:$2|dago|daude}} orain.'''",
	'checkuser-block-limit' => 'Lankide gehiegi hautatu duzu.',
	'checkuser-search-submit' => 'Bilatu',
	'checkuser-search-target' => 'helburua',
	'checkuser-autocreate-action' => 'automatikoki sortua izan da',
	'checkuser-email-action' => '"$1" lankideari posta elektroniko bat bidali',
	'checkuser-reset-action' => '"$1" lankideari pasahitza berrezarri',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'checkuser-reason' => 'Razón:',
	'checkuser-search' => 'Landeal',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author MehranVB
 * @author Mjbmr
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'checkuser-summary' => 'این ابزار تغییرات اخیر را برای به دست آوردن نشانی‌های آی‌پی استفاده شده توسط یک کاربر و یا تعیین ویرایش‌ها و اطلاعات کاربری مرتبط با یک نشانی آی‌پی جستجو می‌کند.
کاربرها و ویرایش‌های مرتبط با یک نشانی آی‌پی را می‌توان با توجه به اطلاعات سرآیند XFF (با افزودن «‏‎/xff» به انتهای نشانی آی‌پی) پیدا کرد.
هر دو پروتکل IPv4 (معادل CIDR 16-32) و IPv6 (معادل CIDR 64-128) توسط این ابزار پشتیبانی می‌شوند.
بنا به دلایل عملکردی، بیش از ۵۰۰۰ ویرایش بازگردانده نمی‌شود.
از این ابزار طبق سیاست‌ها استفاده کنید.',
	'checkuser-desc' => 'به کاربرها اختیارات لازم را برای بررسی نشانی آی‌پی کاربرها و اطلاعات دیگر می‌دهد',
	'checkuser-logcase' => 'جستجوی سیاهه به کوچک یا بزرگ بودن حروف حساس است.',
	'checkuser' => 'بازرسی کاربر',
	'checkuserlog' => 'سیاههٔ بازرسی کاربر',
	'checkuser-contribs' => 'بازرسی نشانی‌های آی‌پی کاربر',
	'group-checkuser' => 'بازرسان کاربر',
	'group-checkuser-member' => 'بازرس کاربر',
	'right-checkuser' => 'بازرسی نشانی‌های آی‌پی و دیگر اطلاعات کاربر',
	'right-checkuser-log' => 'مشاهدهٔ سیاههٔ بازرسی کاربر',
	'action-checkuser' => 'بازرسی نشانی‌های آی‌پی و دیگر اطلاعات کاربر',
	'action-checkuser-log' => 'نمایش سیاههٔ بازرسی کاربر',
	'grouppage-checkuser' => '{{ns:project}}:بازرسی کاربر',
	'checkuser-reason' => 'دلیل:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'نمایش سیاهه',
	'checkuser-query' => 'جستجوی تغییرات اخیر',
	'checkuser-target' => 'نشانی آی‌پی یا نام کاربری:',
	'checkuser-users' => 'فهرست کردن کاربرها',
	'checkuser-edits' => 'نمایش ویرایش‌ها',
	'checkuser-ips' => 'فهرست کردن نشانی‌های آی‌پی',
	'checkuser-search' => 'جستجو',
	'checkuser-period' => 'بازهٔ زمانی:',
	'checkuser-week-1' => 'هفتهٔ گذشته',
	'checkuser-week-2' => 'دو هفتهٔ گذشته',
	'checkuser-month' => '۳۰ روز گذشته',
	'checkuser-all' => 'همه',
	'checkuser-cidr-label' => 'پیدا کردن بازه‌های مشترک آی‌پی و آی‌پی‌های تاثیرپذیرفته برای یک فهرست از نشانی‌های آی‌پی',
	'checkuser-cidr-res' => 'CIDR مشترک',
	'checkuser-empty' => 'سیاهه خالی است.',
	'checkuser-nomatch' => 'موردی که مطابقت داشته باشد پیدا نشد.',
	'checkuser-nomatch-edits' => 'مورد مطابق پیدا نشد.
آخرین ویرایش در $1 ساعت $2 بود.',
	'checkuser-check' => 'بازرسی',
	'checkuser-log-fail' => 'امکان افزودن اطلاعات به سیاهه وجود ندارد',
	'checkuser-nolog' => 'پرونده سیاهه پیدا نشد.',
	'checkuser-blocked' => 'بسته شده',
	'checkuser-gblocked' => 'بسته شده سرتاسری',
	'checkuser-locked' => 'قفل شده',
	'checkuser-wasblocked' => 'قبلاً بسته شده',
	'checkuser-localonly' => 'یکی نشده',
	'checkuser-massblock' => 'بستن کاربرهای انتخاب شده',
	'checkuser-massblock-text' => 'حساب‌های انتخاب شده برای همیشه بسته خواهند شد، قطع دسترسی خودکار هم فعال خواهد بود و از ایجاد حساب کاربری هم جلوگیری خواهد شد. نشانی‌های آی‌پی برای یک هفته فقط برای کاربران ناشناس بسته خواهند شد و از ایجاد حساب کاربری توسط آنان جلوگیری خواهد شد.',
	'checkuser-blocktag' => 'جایگزین کردن صفحهٔ کاربرها با:',
	'checkuser-blocktag-talk' => 'جایگزین کردن صفحه‌های بحث با:',
	'checkuser-massblock-commit' => 'بستن کاربرهای انتخاب شده',
	'checkuser-block-success' => "'''دسترسی {{PLURAL:$2|حساب|حساب‌های}} $1 اینک {{PLURAL:$2|بسته‌است|بسته‌است}}.'''",
	'checkuser-block-failure' => "'''هیچ کاربری بسته نشد.'''",
	'checkuser-block-limit' => 'تعداد بیش از اندازه‌ای از کاربران انتخاب شده‌اند.',
	'checkuser-block-noreason' => 'شما باید دلیلی برای قطع دسترسی‌ها ارائه کنید.',
	'checkuser-noreason' => 'شما باید دلیلی برای این درخواست وارد کنید.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|حساب|حساب}} کاربری جدید',
	'checkuser-too-many' => 'تعداد نتایج بسیار زیاد است (طبق تخمین‌ها)، لطفاً CIDR را محدودتر کنید.
در زیر نشانی‌های آی‌پی استفاده شده را می‌بینید (حداکثر ۵۰۰۰ مورد، به ترتیب نشانی):',
	'checkuser-user-nonexistent' => 'کاربر مورد نظر وجود ندارد.',
	'checkuser-search-form' => 'پیدا کردن مواردی در سیاهه‌ها که $1 برابر است با $2',
	'checkuser-search-submit' => 'جستجو',
	'checkuser-search-initiator' => 'آغازگر',
	'checkuser-search-target' => 'هدف',
	'checkuser-ipeditcount' => '~$1 از همهٔ کاربران',
	'checkuser-log-return' => 'بازگشت به فرم اصلی بازرسی کاربر',
	'checkuser-limited' => "'''این نتایج برای کارآیی سامانه کوتاه شده‌اند.'''",
	'checkuser-log-userips' => '$1 نشانی‌های آی‌پی $2 را گرفت',
	'checkuser-log-ipedits' => '$1 ویرایش‌های $2 را گرفت',
	'checkuser-log-ipusers' => '$1 کاربرهای مربوط به $2 را گرفت',
	'checkuser-log-ipedits-xff' => '$1 ویرایش‌های XFF $2 را گرفت',
	'checkuser-log-ipusers-xff' => '$1 کاربرهای مربوط به XFF $2 را گرفت',
	'checkuser-log-useredits' => '$1 ویرایش‌های $2 را گرفت',
	'checkuser-autocreate-action' => 'به طور خودکار ساخته شد',
	'checkuser-create-action' => 'ایجاد گردید',
	'checkuser-email-action' => 'به کاربر «$1» پست الکترونیکی ارسال شد',
	'checkuser-reset-action' => 'گذرواژه کاربر «$1» را از نو تنظیم کرد',
);

/** Finnish (Suomi)
 * @author Agony
 * @author Cimon Avaro
 * @author Crt
 * @author Jaakonam
 * @author Jack Phoenix
 * @author Nike
 * @author Olli
 * @author Str4nd
 * @author Varusmies
 * @author ZeiP
 */
$messages['fi'] = array(
	'checkuser-summary' => 'Tämän työkalun avulla voidaan tutkia tuoreet muutokset ja paljastaa käyttäjien IP-osoitteet tai noutaa IP-osoitteiden muokkaukset ja käyttäjätiedot.
	Käyttäjät ja muokkaukset voidaan hakea myös uudelleenohjausosoitteen (X-Forwarded-For) takaa käyttämällä IP-osoitteen perässä <tt>/xff</tt> -merkintää. Työkalu tukee sekä IPv4 (CIDR 16–32) ja IPv6 (CIDR 64–128) -standardeja.',
	'checkuser-desc' => 'Antaa oikeutetuille käyttäjille mahdollisuuden tarkistaa käyttäjän IP-osoitteet ja muita tietoja.',
	'checkuser-logcase' => 'Haku lokista on kirjainkokoriippuvainen.',
	'checkuser' => 'Osoitepaljastin',
	'checkuserlog' => 'Osoitepaljastinloki',
	'checkuser-contribs' => 'tarkista käyttäjän IP-osoitteet',
	'group-checkuser' => 'osoitepaljastimen käyttäjät',
	'group-checkuser-member' => '{{GENDER:$1|osoitepaljastimen käyttäjä}}',
	'right-checkuser' => 'Tarkistaa käyttäjän IP-osoitteet ja muut tiedot',
	'right-checkuser-log' => 'Tarkastella osoitepaljastuslokia',
	'action-checkuser' => 'tarkistaa käyttäjän IP-osoitteet ja muut tiedot',
	'action-checkuser-log' => 'tarkastella osoitepaljastuslokia',
	'grouppage-checkuser' => '{{ns:project}}:Osoitepaljastin',
	'checkuser-reason' => 'Syy',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Näytä loki',
	'checkuser-query' => 'Hae tuoreet muutokset',
	'checkuser-target' => 'IP-osoite tai käyttäjätunnus',
	'checkuser-users' => 'Hae käyttäjät',
	'checkuser-edits' => 'Hae muokkaukset',
	'checkuser-ips' => 'Hae IP-osoitteet',
	'checkuser-search' => 'Etsi',
	'checkuser-period' => 'Aikaväli:',
	'checkuser-week-1' => 'viimeisin viikko',
	'checkuser-week-2' => 'viimeiset kaksi viikkoa',
	'checkuser-month' => 'viimeiset 30 päivää',
	'checkuser-all' => 'kaikki',
	'checkuser-cidr-label' => 'Etsi yleinen osoiteavaruus annetulle IP-luettelolle',
	'checkuser-cidr-res' => 'Yleinen CIDR',
	'checkuser-empty' => 'Ei lokitapahtumia.',
	'checkuser-nomatch' => 'Hakuehtoihin sopivia tuloksia ei löytynyt.',
	'checkuser-nomatch-edits' => 'Osumia ei löytynyt.
Viimeinen muokkaus on tehty $1 kello $2.',
	'checkuser-check' => 'Tarkasta',
	'checkuser-log-fail' => 'Lokitapahtuman lisäys epäonnistui',
	'checkuser-nolog' => 'Lokitiedostoa ei löytynyt.',
	'checkuser-blocked' => 'Estetty',
	'checkuser-gblocked' => 'Estetty globaalisti',
	'checkuser-locked' => 'Lukittu',
	'checkuser-wasblocked' => 'Aiemmin estetyt',
	'checkuser-localonly' => 'Ei yhdistettynä',
	'checkuser-massblock' => 'Estä valitut käyttäjät',
	'checkuser-massblock-text' => 'Valitut tunnukset estetään toistaiseksi ("autoblocking", "tunnusten luonti estetty").
Vain rekisteröimättömien käyttäjien IP-osoitteet estetään yhdeksi viikoksi (myös tunnusten luonti estetty).',
	'checkuser-blocktag' => 'Korvaa käyttäjäsivut sisällöllä:',
	'checkuser-blocktag-talk' => 'Korvaa keskustelusivut sisällöllä:',
	'checkuser-massblock-commit' => 'Estä valitut käyttäjät',
	'checkuser-block-success' => "'''{{PLURAL:$2|Käyttäjä|Käyttäjät}} $1 {{PLURAL:$2|on|ovat}} nyt estetty.'''",
	'checkuser-block-failure' => "'''Yhtään käyttäjää ei estetty.'''",
	'checkuser-block-limit' => 'Liian monta käyttäjää valittu.',
	'checkuser-block-noreason' => 'Estoille on annettava syy.',
	'checkuser-noreason' => 'Sinun tulee antaa syy tälle kyselylle.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|uusi tunnus|uutta tunnusta}}',
	'checkuser-too-many' => 'Liian monta tulosta (kyselyarvion mukaan), pienennä CIDR-aluetta.
Käytetyt IP:t (enintään 5000, järjestetty osoitteen mukaan):',
	'checkuser-user-nonexistent' => 'Määritettyä käyttäjää ei ole olemassa.',
	'checkuser-search-form' => 'Etsi lokimerkintöjä, joissa $1 on $2',
	'checkuser-search-submit' => 'Hae',
	'checkuser-search-initiator' => 'alullepanija',
	'checkuser-search-target' => 'kohde',
	'checkuser-ipeditcount' => 'noin $1 muokkausta kaikilta käyttäjiltä',
	'checkuser-log-return' => 'Palaa osoitepaljastimen päälomakkeeseen',
	'checkuser-limited' => "'''Nämä tulokset on lyhennetty suorituskykysyistä.'''",
	'checkuser-log-userips' => '$1 haki käyttäjän $2 IP-osoitteet',
	'checkuser-log-ipedits' => '$1 haki käyttäjän $2 muokkaukset',
	'checkuser-log-ipusers' => '$1 haki osoitteen $2 käyttämät tunnukset',
	'checkuser-log-ipedits-xff' => '$1 haki muokkaukset XFF-osoitteesta $2',
	'checkuser-log-ipusers-xff' => '$1 haki käyttäjät XFF-osoitteesta $2',
	'checkuser-log-useredits' => '$1 haki käyttäjän $2 muokkaukset',
	'checkuser-autocreate-action' => 'luotiin automaattisesti',
	'checkuser-create-action' => 'luotiin',
	'checkuser-email-action' => 'käyttäjälle ”$1” lähetetty sähköpostiviesti',
	'checkuser-reset-action' => 'käyttäjän ”$1” salasana nollattu',
);

/** Faroese (Føroyskt)
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'checkuser' => 'Rannsakanar brúkari',
	'group-checkuser' => 'Rannsakanar brúkari',
	'group-checkuser-member' => 'Rannsakanar brúkarir',
	'grouppage-checkuser' => '{{ns:project}}:Rannsakanar brúkari',
	'checkuser-search' => 'Leita',
);

/** French (Français)
 * @author ChrisPtDe
 * @author Gomoko
 * @author Grondin
 * @author IAlex
 * @author Peter17
 * @author PieRRoMaN
 * @author Quentinv57
 * @author Sherbrooke
 * @author Verdy p
 * @author Wyz
 * @author Zetud
 */
$messages['fr'] = array(
	'checkuser-summary' => 'Cet outil parcourt la liste des changements récents à la recherche des adresses IP employées par un utilisateur, affiche toutes les modifications d’une adresse IP (même enregistrée), ou liste les comptes utilisés par une adresse IP.
Les comptes et les modifications faites par une adresse IP cliente d’un serveur mandataire approuvé peuvent être récupérés via les entêtes XFF en suffisant l’IP avec « /xff ». Les adresses IPv4 (CIDR /16 à /32) et IPv6 (CIDR /64 à /128) sont supportées.
Le nombre de modifications affichables est limité à {{formatnum:5000}} pour des questions de performance.
Veuillez utiliser cet outil dans le respect de la charte d’utilisation.',
	'checkuser-desc' => 'Donne la possibilité aux utilisateurs dûment autorisés de vérifier les adresses IP des utilisateurs ainsi que d’autres informations les concernant',
	'checkuser-logcase' => 'La recherche dans le journal est sensible à la casse.',
	'checkuser' => 'Vérificateur d’utilisateur',
	'checkuserlog' => 'Journal des vérifications d’utilisateurs',
	'checkuser-contribs' => 'vérifier les adresses IP',
	'group-checkuser' => 'Vérificateurs d’utilisateurs',
	'group-checkuser-member' => '{{GENDER:$1|vérificateur d’utilisateur|vérificatrice d’utilisateur}}',
	'right-checkuser' => 'Vérifier les adresses IP et autres informations d’un utilisateur',
	'right-checkuser-log' => 'Visualiser le journal des vérifications d’utilisateurs',
	'action-checkuser' => "vérifier les adresses IP de l'utilisateur et d'autres informations",
	'action-checkuser-log' => 'Visualiser le journal des vérifications des utilisateurs',
	'grouppage-checkuser' => '{{ns:project}}:Vérificateurs d’utilisateurs',
	'checkuser-reason' => 'Motif :',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Afficher le journal',
	'checkuser-query' => 'Recherche des modifications récentes',
	'checkuser-target' => 'Nom d’utilisateur ou adresse IP :',
	'checkuser-users' => 'Obtenir les utilisateurs',
	'checkuser-edits' => 'Obtenir les modifications',
	'checkuser-ips' => 'Obtenir les adresses IP',
	'checkuser-search' => 'Rechercher',
	'checkuser-period' => 'Durée :',
	'checkuser-week-1' => 'la dernière semaine',
	'checkuser-week-2' => 'les deux dernières semaines',
	'checkuser-month' => 'les trente derniers jours',
	'checkuser-all' => 'tout',
	'checkuser-cidr-label' => 'Chercher une plage commune et les adresses affectées pour une liste d’adresses IP',
	'checkuser-cidr-res' => 'Plage CIDR commune :',
	'checkuser-empty' => 'Le journal ne contient aucun élément.',
	'checkuser-nomatch' => 'Recherches infructueuses.',
	'checkuser-nomatch-edits' => 'Aucune occurrence trouvée. La dernière modification a eu lieu le $1 à $2.',
	'checkuser-check' => 'Vérifier',
	'checkuser-log-fail' => 'Impossible d’ajouter l’entrée du journal.',
	'checkuser-nolog' => 'Aucun fichier journal trouvé.',
	'checkuser-blocked' => 'Bloqué',
	'checkuser-gblocked' => 'Bloqué globalement',
	'checkuser-locked' => 'Verrouillé',
	'checkuser-wasblocked' => 'Bloqué précédemment',
	'checkuser-localonly' => 'Non unifié',
	'checkuser-massblock' => 'Bloquer les utilisateurs sélectionnés',
	'checkuser-massblock-text' => 'Les comptes sélectionnés seront bloqués indéfiniment, avec le blocage automatique activé et la création de compte désactivée.
Les adresses IP seront bloquées pendant une semaine uniquement pour les utilisateurs sous IP et avec la création de compte désactivée.',
	'checkuser-blocktag' => 'Remplacer les pages utilisateur par :',
	'checkuser-blocktag-talk' => 'Remplacer les pages de discussion par :',
	'checkuser-massblock-commit' => 'Bloquer les utilisateurs sélectionnés',
	'checkuser-block-success' => "'''{{PLURAL:$2|L’utilisateur $1 est maintenant bloqué|Les $2 utilisateurs suivants sont maintenant bloqués : $1}}.'''",
	'checkuser-block-failure' => "'''Aucun utilisateur bloqué.'''",
	'checkuser-block-limit' => 'Trop d’utilisateurs sélectionnés.',
	'checkuser-block-noreason' => 'Vous devez donner un motif justifiant les blocages.',
	'checkuser-noreason' => 'Vous devez donner une raison pour cette requête.',
	'checkuser-accounts' => '$1 nouveau{{PLURAL:$1||x}} compte{{PLURAL:$1||s}}',
	'checkuser-too-many' => "Trop de résultats (selon l'estimation de la requête), veuillez affiner l’étendue CIDR.
Voici un extrait des IP utilisées ({{formatnum:5000}} maximum, triées par adresse) :",
	'checkuser-user-nonexistent' => 'L’utilisateur indiqué n’existe pas.',
	'checkuser-search-form' => 'Chercher les entrées de journal où $1 est $2.',
	'checkuser-search-submit' => 'Rechercher',
	'checkuser-search-initiator' => 'l’initiateur',
	'checkuser-search-target' => 'la cible',
	'checkuser-ipeditcount' => '~$1 par tous les utilisateurs',
	'checkuser-log-return' => 'Retourner au formulaire principal du vérificateur d’utilisateur',
	'checkuser-limited' => "'''Ces résultats ont été tronqués pour des raisons liées à la performance.'''",
	'checkuser-log-userips' => '$1 a obtenu des IP utilisées par « $2 »',
	'checkuser-log-ipedits' => '$1 a obtenu des modifications par l’adresse $2',
	'checkuser-log-ipusers' => '$1 a obtenu des utilisateurs à l’adresse $2',
	'checkuser-log-ipedits-xff' => '$1 a obtenu des modifications par l’adresse XFF $2',
	'checkuser-log-ipusers-xff' => '$1 a obtenu des utilisateurs à l’adresse XFF $2',
	'checkuser-log-useredits' => '$1 a obtenu des modifications par $2',
	'checkuser-autocreate-action' => 'a été créé automatiquement',
	'checkuser-create-action' => 'a été créé',
	'checkuser-email-action' => 'a envoyé un courriel à l’utilisateur « $1 »',
	'checkuser-reset-action' => 'réinitialise le mot de passe de l’utilisateur « $1 »',
);

/** Cajun French (Français cadien)
 * @author JeanVoisin
 */
$messages['frc'] = array(
	'checkuser-summary' => 'Cet outil observe les derniers changements pour récupérer l’adresse IP de l’useur ou pour montrer les données de modification et de l’useur de cette adresse IP.
Les useurs et les modifications par l’adresse IP d’un client peuvent être récupérés par les en-têtes XFF en ajoutant « /xff » à l’adresse IP. Les adresses IPv4 (CIDR 16–32) et IPv6 (CIDR 64–128) sont supportées.
Pour des raisons de performance, cet outil ne retourne pas plus de 5&nbsp;000 modifications.
Usez ça ici en accord avec les régulations.',
	'checkuser-logcase' => 'La charche des notes est sensible aux lettres basses ou hautes.',
	'checkuser' => "'Gardez-voir à l'useur encore",
	'checkuserlog' => "Notes de la Garde d'useur",
	'group-checkuser' => "'Gardez-voir aux useurs encore",
	'group-checkuser-member' => "'Gardez-voir à l'useur encore",
	'grouppage-checkuser' => "{{ns:project}}:'Gardez-voir à l'useur encore",
	'checkuser-reason' => 'Raison:',
	'checkuser-showlog' => 'Montrer les notes',
	'checkuser-query' => 'Charchez les nouveaux changements',
	'checkuser-target' => "Nom de l'useur ou IP",
	'checkuser-users' => 'Obtenir les useurs',
	'checkuser-edits' => 'Obtenir les modifications du IP',
	'checkuser-ips' => 'Obtenir les adresses IP',
	'checkuser-search' => 'Charche',
	'checkuser-empty' => 'Les notes sont vides.',
	'checkuser-nomatch' => 'Rien pareil trouvé.',
	'checkuser-check' => 'Charche',
	'checkuser-log-fail' => "Pas capable d'additionner la note",
	'checkuser-nolog' => 'Rien trouvé dans les notes.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'checkuser-summary' => "Ceti outil parcôrt los dèrriérs changements a la rechèrche de les adrèces IP empleyês per un usanciér, montre tôs los changements d’una adrèce IP (méma encartâ), ou ben liste los comptos utilisâs per una adrèce IP.
Los comptos et los changements fêts per una adrèce IP clianta d’un sèrvor mandatèro (''proxy'') aprovâ pôvont étre rècupèrâs avouéc les en-tétes XFF en apondent l’adrèce IP avouéc « /xff ». Les adrèces IPv4 (CIDR /16 a /32) et IPv6 (CIDR /64 a /128) sont recognues.
Lo nombro de changements montrâblos est limitâ a {{formatnum:5000}} por des quèstions de pèrformence.
Lo volyéd utilisar dedens les limites de la chârta d’usâjo.",
	'checkuser-desc' => 'Balye la possibilitât a les gens qu’ont la pèrmission que vat avouéc de controlar les adrèces IP des usanciérs et pués d’ôtres enformacions los regardent.',
	'checkuser-logcase' => 'La rechèrche dens lo jornal est sensibla a la câssa.',
	'checkuser' => 'Controlor d’usanciér',
	'checkuserlog' => 'Jornal des contrôlos d’usanciérs',
	'checkuser-contribs' => 'controlar les adrèces IP ux usanciérs',
	'group-checkuser' => 'Controlors d’usanciér',
	'group-checkuser-member' => 'controlo{{GENDER:$1|r|sa}} d’usanciér',
	'right-checkuser' => 'Controlar les adrèces IP ux usanciérs et ôtres enformacions',
	'right-checkuser-log' => 'Vêre lo jornal des contrôlos d’usanciérs',
	'action-checkuser' => 'controlar les adrèces IP ux usanciérs et ôtres enformacions',
	'action-checkuser-log' => 'vêre lo jornal des contrôlos d’usanciérs',
	'grouppage-checkuser' => '{{ns:project}}:Controlors d’usanciér',
	'checkuser-reason' => 'Rêson :',
	'checkuser-reason-api' => 'API : $1',
	'checkuser-showlog' => 'Afichiér lo jornal',
	'checkuser-query' => 'Rechèrche per los dèrriérs changements',
	'checkuser-target' => 'Adrèce IP ou ben nom d’usanciér :',
	'checkuser-users' => 'Avêr los usanciérs',
	'checkuser-edits' => 'Avêr los changements',
	'checkuser-ips' => 'Avêr les adrèces IP',
	'checkuser-search' => 'Rechèrche',
	'checkuser-period' => 'Temps :',
	'checkuser-week-1' => 'la semana passâ',
	'checkuser-week-2' => 'les doves semanes passâs',
	'checkuser-month' => 'los 30 jorns passâs',
	'checkuser-all' => 'tot',
	'checkuser-cidr-label' => 'Chèrchiér una plage comena et les adrèces afèctâs por una lista d’adrèces IP',
	'checkuser-cidr-res' => 'Plage CIDR comena :',
	'checkuser-empty' => 'Lo jornal contint gins d’articllo.',
	'checkuser-nomatch' => 'Rechèrches que balyont ren.',
	'checkuser-nomatch-edits' => 'Gins de corrèspondance trovâ.
Lo dèrriér changement est arrevâ lo $1 a $2.',
	'checkuser-check' => 'Rechèrche',
	'checkuser-log-fail' => 'Empossiblo d’apondre l’entrâ du jornal.',
	'checkuser-nolog' => 'Gins de fichiér jornal trovâ.',
	'checkuser-blocked' => 'Blocâ',
	'checkuser-gblocked' => 'Blocâ dens l’ensemblo',
	'checkuser-locked' => 'Vèrrolyê',
	'checkuser-wasblocked' => 'Blocâ dês devant',
	'checkuser-localonly' => 'Pas unifiâ',
	'checkuser-massblock' => 'Blocar los usanciérs chouèsis',
	'checkuser-massblock-text' => 'Los comptos chouèsis seront blocâs sen fin, avouéc lo blocâjo ôtomatico activâ et la crèacion de compto dèsactivâ.
Les adrèces IP seront blocâs pendent yona semana ren que por los usanciérs pas encartâs et pués la crèacion de compto serat dèsactivâ.',
	'checkuser-blocktag' => 'Remplaciér les pâges usanciér per :',
	'checkuser-blocktag-talk' => 'Remplaciér les pâges de discussion per :',
	'checkuser-massblock-commit' => 'Blocar los usanciérs chouèsis',
	'checkuser-block-success' => "'''{{PLURAL:$2|L’usanciér $1 est ora blocâ|Cetos $2 usanciérs sont ora blocâs : $1}}.'''",
	'checkuser-block-failure' => "'''Gins d’usanciér blocâ.'''",
	'checkuser-block-limit' => 'Trop d’usanciérs chouèsis.',
	'checkuser-block-noreason' => 'Vos dête balyér una rêson por los blocâjos.',
	'checkuser-noreason' => 'Vos dête balyér una rêson por cela requéta.',
	'checkuser-accounts' => '$1 compto{{PLURAL:$1||s}} novél{{PLURAL:$1||s}}',
	'checkuser-too-many' => 'Trop de rèsultats (d’aprés l’èstimacion de la requéta), volyéd èpurar l’ètendua CIDR.
Vê-que un èxtrèt a les adrèces IP utilisâs ({{formatnum:5000}} u més, triyês per adrèce) :',
	'checkuser-user-nonexistent' => 'L’usanciér endicâ ègziste pas.',
	'checkuser-search-form' => 'Chèrchiér lo jornal de les entrâs yô que $1 est $2.',
	'checkuser-search-submit' => 'Rechèrchiér',
	'checkuser-search-initiator' => 'l’iniciator',
	'checkuser-search-target' => 'la ciba',
	'checkuser-ipeditcount' => '~$1 per tôs los usanciérs',
	'checkuser-log-return' => 'Tornar u formulèro principâl du contrôlo d’usanciér',
	'checkuser-limited' => "'''Cetos rèsultats ont étâ tronchiês por des rêsons liyês a la pèrformence.'''",
	'checkuser-log-userips' => '$1 at obtegnu des IP por $2',
	'checkuser-log-ipedits' => '$1 at avu des changements per l’adrèce IP $2',
	'checkuser-log-ipusers' => '$1 at obtegnu des usanciérs por $2',
	'checkuser-log-ipedits-xff' => '$1 at avu des changements per l’adrèce XFF $2',
	'checkuser-log-ipusers-xff' => '$1 at obtegnu des usanciérs por XFF $2',
	'checkuser-log-useredits' => '$1 at avu des changements per $2',
	'checkuser-autocreate-action' => 'at étâ fêt ôtomaticament',
	'checkuser-create-action' => 'at étâ fêt',
	'checkuser-email-action' => 'at mandâ un mèssâjo a l’usanciér « $1 »',
	'checkuser-reset-action' => 'tôrne inicialisar lo contresegno por l’usanciér « $1 »',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'checkuser-search' => 'Sykje',
	'checkuser-search-submit' => 'Sykje',
);

/** Irish (Gaeilge)
 * @author Alison
 * @author Tameamseo
 */
$messages['ga'] = array(
	'checkuser-summary' => 'Scanann an uirlis seo na athruithe is déanaí chun na seolaidh IP úsáideoira a fháil ná taispeáin na sonraí eagarthóireachta/úsáideoira don seoladh IP.
Is féidir úsáideoirí agus eagarthóireachta mar IP cliant a fháil le ceanntáisc XFF mar an IP a iarcheangail le "/xff". IPv4 (CIDR 16-32) agus IPv6 (CIDR 64-128) atá tacaíocht.
Le fáth feidhmiúcháin, ní féidir níos mó ná 5000 eagarthóireachta a thabhairt ar ais ar an am cheana. Déan úsáid de réir polsaí.',
	'checkuser-logcase' => 'Tá na logaí seo cásíogair.',
	'checkuser' => 'Seic úsáideoir',
	'checkuserlog' => 'Logaí checkuser',
	'group-checkuser' => 'Seiceanna úsáideoir',
	'group-checkuser-member' => 'Seic úsáideoir',
	'right-checkuser-log' => 'Féach ar an log seic úsáideoir',
	'checkuser-reason' => 'Fáth:',
	'checkuser-showlog' => 'Taispeáin logaí',
	'checkuser-query' => 'Iarratais ar athruithe úrnua',
	'checkuser-target' => 'Seoladh IP ná úsáideoir:',
	'checkuser-users' => 'Faigh úsáideoira',
	'checkuser-edits' => 'Faigh athruithe don seoladh IP seo',
	'checkuser-ips' => 'Faigh Seolaidh IP',
	'checkuser-search' => 'Cuardaigh',
	'checkuser-week-1' => 'an tseachtain seo caite',
	'checkuser-week-2' => 'dhá sheachtain seo caite',
	'checkuser-month' => '30 lae seo caite',
	'checkuser-all' => 'iad uile',
	'checkuser-empty' => 'Níl aon míreanna sa log.',
	'checkuser-nomatch' => 'Ní faigheann aon comhoiriúnaigh.',
	'checkuser-check' => 'Iarratais',
	'checkuser-log-fail' => 'Ní féidir iontráil a cur sa log',
	'checkuser-nolog' => 'Ní bhfaigheann comhad loga.',
	'checkuser-blocked' => 'Cosanta',
	'checkuser-gblocked' => 'Cosanta domhandach',
	'checkuser-locked' => 'Glasáilte',
	'checkuser-massblock' => 'Cuir cosc ar na húsáideoirí roghnaithe',
	'checkuser-massblock-commit' => 'Cur cosc ar na n-úsáideoirí roghnaithe',
	'checkuser-block-success' => "'''Tá {{PLURAL:$2|an úsáideoir|na n-úsáideoirí}} $1 coiscthe anois.'''",
	'checkuser-block-failure' => "'''Níl aon úsáideoirí coiscthe.'''",
	'checkuser-accounts' => '{{PLURAL:$1|Cuntas amháin|$1 cuntais}} nua',
	'checkuser-too-many' => "Tá le mórán torthaí (de réir meastachán cheist), caolaigh an CIDR le d'thoil.
Seo iad na seolaidh IP (5000 uasta, sórtáilte le seoladh):",
	'checkuser-search-submit' => 'Cuardaigh',
	'checkuser-search-initiator' => 'tionscnóir',
	'checkuser-search-target' => 'targaid',
	'checkuser-ipeditcount' => '~$1 as na n-úsáideoir go léir',
	'checkuser-log-userips' => 'Fuair $1 seolaidh IP le $2',
	'checkuser-log-ipedits' => 'Fuair $1 athruithe le $2',
	'checkuser-log-ipusers' => 'Fuair $1 úsáideoirí le $2',
	'checkuser-log-ipedits-xff' => 'Fuair $1 athruithe le XFF $2',
	'checkuser-log-ipusers-xff' => 'Fuair $1 úsáideoirí le XFF $2',
	'checkuser-log-useredits' => 'Fuair $1 athruithe le $2',
	'checkuser-autocreate-action' => 'a chruthú go huathoibríoch',
	'checkuser-email-action' => 'a chur riomhphoist do úsáideoir "$1"',
	'checkuser-reset-action' => 'a athshocrú pásfhocal le úsáideoir "$1"',
);

/** Simplified Gan script (‪赣语(简体)‬) */
$messages['gan-hans'] = array(
	'checkuser-search' => '寻吖',
	'checkuser-search-submit' => '寻吖',
);

/** Traditional Gan script (‪贛語(繁體)‬)
 * @author Symane
 */
$messages['gan-hant'] = array(
	'checkuser-search' => '尋吖',
	'checkuser-search-submit' => '尋吖',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'checkuser-summary' => 'Esta ferramenta analiza os cambios para recuperar os enderezos IP utilizados por un usuario ou mostrar as edicións/datos do usuario dun enderezo IP.
Os usuarios e as edicións por un cliente IP poden ser recuperados a través das cabeceiras XFF engadindo o enderezo IP con "/xff". IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128) están soportados.
Non se devolverán máis de 5.000 edicións por motivos de rendemento.
Use isto de acordo coas políticas.',
	'checkuser-desc' => 'Garante que usuarios cos permisos apropiados poidan comprobar os enderezos IP dos usuarios e acceder a outra información',
	'checkuser-logcase' => 'O rexistro de búsqueda é sensíbel a maiúsculas e minúsculas.',
	'checkuser' => 'Verificador de usuarios',
	'checkuserlog' => 'Rexistro de comprobacións de usuarios',
	'checkuser-contribs' => 'comprobar os enderezos IP do usuario',
	'group-checkuser' => 'Verificadores de usuarios',
	'group-checkuser-member' => '{{GENDER:$1|verificador|verificadora}} de usuarios',
	'right-checkuser' => 'Comprobar os enderezos IP dos usuarios e outra información',
	'right-checkuser-log' => 'Ver o rexistro de verificadores de usuarios',
	'action-checkuser' => 'comprobar os enderezos IP dos usuarios e outra información',
	'action-checkuser-log' => 'ver o rexistro de verificadores de usuarios',
	'grouppage-checkuser' => '{{ns:project}}:Verificadores de usuarios',
	'checkuser-reason' => 'Motivo:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Mostrar o rexistro',
	'checkuser-query' => 'Consulta de cambios recentes',
	'checkuser-target' => 'Enderezo IP ou nome de usuario:',
	'checkuser-users' => 'Obter os usuarios',
	'checkuser-edits' => 'Obter as edicións',
	'checkuser-ips' => 'Obter os enderezos IP',
	'checkuser-search' => 'Procurar',
	'checkuser-period' => 'Período:',
	'checkuser-week-1' => 'última semana',
	'checkuser-week-2' => 'últimas dúas semanas',
	'checkuser-month' => 'últimos 30 días',
	'checkuser-all' => 'todos',
	'checkuser-cidr-label' => 'Atopar rangos comúns e enderezos afectados para unha lista de enderezos IP',
	'checkuser-cidr-res' => 'CIDR común:',
	'checkuser-empty' => 'O rexistro non contén elementos.',
	'checkuser-nomatch' => 'Non se atoparon coincidencias.',
	'checkuser-nomatch-edits' => 'Non se atoparon coincidencias.
A última edición foi feita o $1 ás $2.',
	'checkuser-check' => 'Comprobar',
	'checkuser-log-fail' => 'Non é posible engadir unha entrada no rexistro',
	'checkuser-nolog' => 'Ningún arquivo de rexistro.',
	'checkuser-blocked' => 'Bloqueado',
	'checkuser-gblocked' => 'Bloqueado globalmente',
	'checkuser-locked' => 'Bloqueado',
	'checkuser-wasblocked' => 'Bloqueados anteriormente',
	'checkuser-localonly' => 'Sen unificar',
	'checkuser-massblock' => 'Bloquear os usuarios seleccionados',
	'checkuser-massblock-text' => 'As contas seleccionadas bloquearanse indefinidamente, co bloqueo automático activado e a creación de contas desactivada.
Os enderezos IP bloquearanse cun tempo de duración dunha semana só para os usuarios anónimos e coa creación de contas desactivada.',
	'checkuser-blocktag' => 'Substituír as páxinas de usuario por:',
	'checkuser-blocktag-talk' => 'Substituír as conversas con:',
	'checkuser-massblock-commit' => 'Bloquear os usuarios seleccionados',
	'checkuser-block-success' => "'''{{PLURAL:$2|O usuario|Os usuarios}} $1 xa {{PLURAL:$2|está|están}} bloqueados.'''",
	'checkuser-block-failure' => "'''Non hai ningún usuario bloqueado.'''",
	'checkuser-block-limit' => 'Hai seleccionados demasiados usuarios.',
	'checkuser-block-noreason' => 'Debe dar unha razón para os bloqueos.',
	'checkuser-noreason' => 'Debe dar unha razón para esta pescuda.',
	'checkuser-accounts' => '{{PLURAL:$1|Unha nova conta|$1 novas contas}}',
	'checkuser-too-many' => 'Hai demasiados resultados (segundo a estimación da pescuda), restrinxa o CIDR.
Aquí están os enderezos IP usados (máximo de 5.000, ordenados por enderezo):',
	'checkuser-user-nonexistent' => 'O usuario especificado non existe.',
	'checkuser-search-form' => 'Atopar as entradas do rexistro nas que $1 é $2',
	'checkuser-search-submit' => 'Procurar',
	'checkuser-search-initiator' => 'iniciador',
	'checkuser-search-target' => 'destino',
	'checkuser-ipeditcount' => '~$1 de todos os usuarios',
	'checkuser-log-return' => 'Volver ao formulario principal de verificador de usuarios',
	'checkuser-limited' => "'''Estes resultados foron truncados por motivos de rendemento.'''",
	'checkuser-log-userips' => '$1 obteu os enderezos IP de "$2"',
	'checkuser-log-ipedits' => '$1 obteu as edicións de "$2"',
	'checkuser-log-ipusers' => '$1 obteu os usuarios de "$2"',
	'checkuser-log-ipedits-xff' => '$1 obteu as edicións de XFF $2',
	'checkuser-log-ipusers-xff' => '$1 obteu os usuarios de XFF $2',
	'checkuser-log-useredits' => '"$1" obteu as edicións de "$2"',
	'checkuser-autocreate-action' => 'foi creada automaticamente',
	'checkuser-create-action' => 'foi creada',
	'checkuser-email-action' => 'envioulle un correo electrónico ao usuario "$1"',
	'checkuser-reset-action' => 'envioulle un novo contrasinal ao usuario "$1"',
);

/** Gothic (Gothic) */
$messages['got'] = array(
	'checkuser-reason' => '𐍆𐌰𐌹𐍂𐌹𐌽𐌰:',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 * @author SPQRobin
 */
$messages['grc'] = array(
	'grouppage-checkuser' => '{{ns:project}}:Ἔλεγχος χρωμένου',
	'checkuser-reason' => 'Αἰτία:',
	'checkuser-search' => 'Ζητεῖν',
	'checkuser-period' => 'Διάρκεια:',
	'checkuser-all' => 'ἅπασαι',
	'checkuser-check' => 'Ἐλέγχειν',
	'checkuser-wasblocked' => 'Προηγουμένως πεφραγμένος',
	'checkuser-search-submit' => 'Ζητεῖν',
	'checkuser-search-initiator' => 'ἐγκαινιαστής',
	'checkuser-search-target' => 'στόχος',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'checkuser-summary' => 'Des Wärchzyyg dursuecht di letschten Änderige go d IP-Adrässe vun eme Benutzers bzw. d Bearbeitige/Benutzernäme fir e IP-Adräss usefinde. Benutzer un Bearbeitige vun ere IP-Adräss chenne au noch Informatione us dr XFF-Header abgfrogt wäre. Doderzue muess dr IP-Adräss e „/xff“ aaghänkt wäre. IPv4 (CIDR 16-32) un IPv6 (CIDR 64-128) wäre unterstitzt.
Us Performance-Grind wäre hegschtens 5000 Bearbeitige usgee. Nimm CheckUser usschließli in Ibereinstimmig mit dr Dateschutzrichtlinie.',
	'checkuser-desc' => 'Erlaubt Benutzer mit dr jewyylige Rächt d IP-Adrässe un wyteri Informatione vu Benutzer z priefe',
	'checkuser-logcase' => 'D Suech im Logbuech unterscheidet zwische Groß- un Chleischreibig.',
	'checkuser' => 'Checkuser',
	'checkuserlog' => 'Checkuser-Logbuech',
	'checkuser-contribs' => 'IP-Adrässe vu Benutzer priefe',
	'group-checkuser' => 'Checkuser',
	'group-checkuser-member' => '{{GENDER:$1|Checkuser-Berächtigter|Checkuser-Berächtigti}}',
	'right-checkuser' => 'Priefig vu IP-Adrässe un Verbindunge zwische IP un aagmäldete Benutzer',
	'right-checkuser-log' => 'Checkuser-Logbuech aaluege',
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Grund:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Logbuech aazeige',
	'checkuser-query' => 'Letchte Änderige abfroge',
	'checkuser-target' => 'IP-Adräss oder Benutzername:',
	'checkuser-users' => 'Hol Benutzer',
	'checkuser-edits' => 'Bearbeitige abruefe',
	'checkuser-ips' => 'Hol IP-Adrässe',
	'checkuser-search' => 'Sueche',
	'checkuser-period' => 'Zytruum:',
	'checkuser-week-1' => 'letschti 7 Täg',
	'checkuser-week-2' => 'letschti 14 Täg',
	'checkuser-month' => 'letschti 30 Täg',
	'checkuser-all' => 'alli',
	'checkuser-cidr-label' => 'Gmeinschaftligi Range finden un Adrässe, wu s betrifft, fir e Lischt vu IP-Adrässe',
	'checkuser-cidr-res' => 'Gmeinschaftligi CIDR:',
	'checkuser-empty' => 'Im Logbuech het s kei Yyträg.',
	'checkuser-nomatch' => 'Kei Ibereinstimmige gfunde.',
	'checkuser-nomatch-edits' => 'Kei Ibereinstimmige gfunde. Letschti Bearbeitig isch am $1 am $2 gsi.',
	'checkuser-check' => 'Usfiere',
	'checkuser-log-fail' => 'Logbuech-Yytrag cha nit zuegfiegt wäre.',
	'checkuser-nolog' => 'Kei Logbuechdatei vorhande.',
	'checkuser-blocked' => 'Gsperrt',
	'checkuser-gblocked' => 'Wältwyt gsperrt',
	'checkuser-locked' => 'Zue',
	'checkuser-wasblocked' => 'Friejer gsperrt gsi',
	'checkuser-localonly' => 'Nit zämegfiert',
	'checkuser-massblock' => 'Sperr di usgwählte Benutzer',
	'checkuser-massblock-text' => 'Di usgwählte Benutzerkonte wäre fir immer gsperrt (Autoblock isch aktiv un s Aalege vu neije Benutzerkonte wird unterbunde).
IP-Adrässe wäre fir ei Wuche gsperrt (nume fir anonymi Benutzer, s Aalege vu neije Benutzerkonten wird unterbunde).',
	'checkuser-blocktag' => 'Inhalt vu dr Benutzersyte ersetze dur:',
	'checkuser-blocktag-talk' => 'Diskussionssyte ersetze dur:',
	'checkuser-massblock-commit' => 'Sperr di usgwählte Benutzer',
	'checkuser-block-success' => "'''{{PLURAL:$2|Dr Benutzer|D Benutzer}} $1 {{PLURAL:$2|isch|sin}} gsperrt wore.'''",
	'checkuser-block-failure' => "'''S sin kei Benutzer gsperrt wore.'''",
	'checkuser-block-limit' => 'S sin zvyl Benutzer usgwählt wore.',
	'checkuser-block-noreason' => 'Du muesch e Grund fir d Sperri aagee.',
	'checkuser-noreason' => 'Du muesch e Grund fir die Abfrog aagee.',
	'checkuser-accounts' => '{{PLURAL:$1|1 nej Benutzerkonto|$1 neiji Benutzerkonte}}',
	'checkuser-too-many' => 'D Ergebnislischt isch z lang (noch ere Abfrogs-Schätzig), bitte gränz dr IP-Beryych wyter yy. Do sin di benutzten IP-Adrässe (maximal 5000, sortiert noch Adrässe):',
	'checkuser-user-nonexistent' => 'S Benutzerkonto, wu Du aagee hesch, isch nit vorhande.',
	'checkuser-search-form' => 'Suech Logbuechyyträg, wu $1 byyn ene $2 isch.',
	'checkuser-search-submit' => 'Suech',
	'checkuser-search-initiator' => 'CheckUser-Berächtigter',
	'checkuser-search-target' => 'Abfrogziil (Benutzerkonto/IP)',
	'checkuser-ipeditcount' => '~$1 vu allene Benutzer',
	'checkuser-log-return' => 'Zruck zum CheckUser-Hauptformular',
	'checkuser-limited' => "'''D Ergebnislischt isch us Performancegrind gchirzt wore.'''",
	'checkuser-log-userips' => '$1 het IP-Adrässe fir $2 gholt',
	'checkuser-log-ipedits' => '$1 het Bearbeitige fir $2 gholt',
	'checkuser-log-ipusers' => '$1 het Benutzer fir $2 gholt',
	'checkuser-log-ipedits-xff' => '$1 het Bearbeitige fir XFF $2 gholt',
	'checkuser-log-ipusers-xff' => '$1 het Benutzer fir XFF $2 gholt',
	'checkuser-log-useredits' => '$1 het Bearbeitige fir $2 gholt',
	'checkuser-autocreate-action' => 'isch automatisch aagleit wore',
	'checkuser-create-action' => 'isch erstellt worde',
	'checkuser-email-action' => 'het e E-Mail an „$1“ gschickt',
	'checkuser-reset-action' => 'Aaforderig vun eme neije Passwort fir „Benutzer:$1“',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 */
$messages['gu'] = array(
	'checkuser-reason' => 'કારણ:',
	'checkuser-search' => 'શોધો',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'checkuser-reason' => 'Fa:',
	'checkuser-search' => 'Ronsee',
	'checkuser-search-submit' => 'Ronsee',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'checkuser-reason' => 'Dalili:',
	'checkuser-search' => 'Nema',
	'checkuser-all' => 'duka',
	'checkuser-search-submit' => 'Nema',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'checkuser-search' => 'Chhìm-cháu',
	'checkuser-search-submit' => 'Chhìm-cháu',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'checkuser-reason' => 'Kumu:',
	'checkuser-search' => 'Huli',
	'checkuser-search-submit' => 'Huli',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotem Liss
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'checkuser-summary' => 'כלי זה סורק את השינויים האחרונים במטרה למצוא את כתובות ה־IP שהשתמש בהן משתמש מסוים או כדי להציג את כל המידע על המשתמשים שהשתמשו בכתובת IP ועל העריכות שבוצעו ממנה.
ניתן לקבל עריכות ומשתמשים מכתובות IP של הכותרת X-Forwarded-For באמצעות הוספת הטקסט "/xff" לסוף הכתובת. הן כתובות IPv4 (כלומר, CIDR 16-32) והן כתובות IPv6 (כלומר, CIDR 64-128) נתמכות.
לא יוחזרו יותר מ־5000 עריכות מסיבות של עומס על השרתים. אנא השתמשו בכלי זה בהתאם למדיניות.',
	'checkuser-desc' => 'מאפשר למשתמשים עם ההרשאות המתאימות לבדוק את כתובת ה־IP של משתמשים',
	'checkuser-logcase' => 'החיפוש ביומנים הוא תלוי־רישיות.',
	'checkuser' => 'בדיקת משתמש',
	'checkuserlog' => 'יומן בדיקות',
	'checkuser-contribs' => 'בדיקת כתובות ה־IP',
	'group-checkuser' => 'בודקים',
	'group-checkuser-member' => '{{GENDER:$1|בודק|בודקת}}',
	'right-checkuser' => 'מציאת כתובות IP של משתמשים ומידע נוסף',
	'right-checkuser-log' => 'צפייה ביומן הבדיקות',
	'action-checkuser' => 'בדיקה של כתובות ה־IP של המשתמש הזה ומידע אחר',
	'action-checkuser-log' => 'להציג את יומן בדיקת המשתמשים',
	'grouppage-checkuser' => '{{ns:project}}:בודק',
	'checkuser-reason' => 'סיבה:',
	'checkuser-reason-api' => 'API‏: $1',
	'checkuser-showlog' => 'הצגת יומן',
	'checkuser-query' => 'בדיקת שינויים אחרונים',
	'checkuser-target' => 'כתובת IP או שם משתמש:',
	'checkuser-users' => 'הצגת משתמשים',
	'checkuser-edits' => 'קבלת עריכות',
	'checkuser-ips' => 'הצגת כתובות IP',
	'checkuser-search' => 'חיפוש',
	'checkuser-period' => 'פרק זמן:',
	'checkuser-week-1' => 'השבוע האחרון',
	'checkuser-week-2' => 'השבועיים האחרונים',
	'checkuser-month' => '30 הימים האחרונים',
	'checkuser-all' => 'הכול',
	'checkuser-cidr-label' => 'מציאת טווח משותף וכתובות מושפעות עבור רשימה של כתובות IP',
	'checkuser-cidr-res' => 'CIDR משותף:',
	'checkuser-empty' => 'אין פריטים ביומן.',
	'checkuser-nomatch' => 'לא נמצאו התאמות.',
	'checkuser-nomatch-edits' => 'לא נמצאו התאמות.
העריכה האחרונה בוצעה ב־$2, $1.',
	'checkuser-check' => 'בדיקה',
	'checkuser-log-fail' => 'לא ניתן היה להוסיף פריט ליומן',
	'checkuser-nolog' => 'לא נמצא קובץ יומן.',
	'checkuser-blocked' => 'חסום',
	'checkuser-gblocked' => 'חסום באופן גלובלי',
	'checkuser-locked' => 'נעול',
	'checkuser-wasblocked' => 'נחסם בעבר',
	'checkuser-localonly' => 'חשבון לא מאוחד',
	'checkuser-massblock' => 'חסימת המשתמשים שנבחרו',
	'checkuser-massblock-text' => 'חשבונות המשתמש שנבחרו ייחסמו לצמיתות, עם חסימה אוטומטית וחסימה של יצירת החשבונות.
כתובות IP ייחסמו לשבוע אחד, עבור משתמשים אנונימיים בלבד, ועם חסימה של יצירת החשבונות.',
	'checkuser-blocktag' => 'החלפת דפי המשתמש עם:',
	'checkuser-blocktag-talk' => 'החלפת דפי השיחה עם:',
	'checkuser-massblock-commit' => 'חסימת המשתמשים שנבחרו',
	'checkuser-block-success' => "'''The {{PLURAL:$2|המשתמש|המשתמשים}} $1 {{PLURAL:$2|חסום|חסומים}} כעת.'''",
	'checkuser-block-failure' => "'''לא נחסמו משתמשים.'''",
	'checkuser-block-limit' => 'נבחרו יותר מדי משתמשים.',
	'checkuser-block-noreason' => 'עליכם לתת סיבה לחסימות.',
	'checkuser-noreason' => 'עליכם לכתוב סיבה לבדיקה זו.',
	'checkuser-accounts' => '{{PLURAL:$1|חשבון חדש אחד|$1 חשבונות חדשים}}',
	'checkuser-too-many' => 'נמצאו תוצאות רבות מדי (לפי הערכה של השאילתה), אנא צמצמו את טווח כתובות ה־IP.
להלן כתובות ה־IP שנעשה בהן שימוש (מוצגות 5,000 לכל היותר, וממוינות לפי כתובת):',
	'checkuser-user-nonexistent' => 'המשתמש לא נמצא.',
	'checkuser-search-form' => 'מציאת ערכים ביומן שבהם ה$1 הוא $2',
	'checkuser-search-submit' => 'חיפוש',
	'checkuser-search-initiator' => 'בודק',
	'checkuser-search-target' => 'נבדק',
	'checkuser-ipeditcount' => 'בערך $1 מכל המשתמשים',
	'checkuser-log-return' => 'חזרה לטופס הבדיקה הכללי',
	'checkuser-limited' => "'''הדף נקטע כדי לחסוך במשאבים.'''",
	'checkuser-log-userips' => '$1 בדק את כתובות ה־IP של $2',
	'checkuser-log-ipedits' => '$1 בדק את העריכות של $2',
	'checkuser-log-ipusers' => '$1 בדק את המשתמשים של $2',
	'checkuser-log-ipedits-xff' => '$1 בדק את העריכות של כתובת ה־XFF $2',
	'checkuser-log-ipusers-xff' => '$1 בדק את המשתמשים של כתובת ה־XFF $2',
	'checkuser-log-useredits' => '$1 בדק את העריכות של $2',
	'checkuser-autocreate-action' => 'נוצר אוטומטית',
	'checkuser-create-action' => 'נוצר',
	'checkuser-email-action' => 'שלח דואר אלקטרוני למשתמש "$1"',
	'checkuser-reset-action' => 'איפס את הסיסמה של המשתמש "$1"',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 * @author Kaustubh
 * @author Shyam
 */
$messages['hi'] = array(
	'checkuser-summary' => 'यह उपकरण एक सदस्य द्वारा हाल में किये गए परिवर्तनों के लिए काम में ली गई सारी IPs को जांचता है, अथवा एक IP का उपयोग करने वाले सभी सदस्यों को जांचता है।
एक मुवक्किल IP द्वारा किया गए संपादन एवं प्रयोग में ले रहे सभी सदस्यों को "/xff" से IP को जोड़ते हुए XFF शीर्षक के माध्यम से पता लगता है। IPv4 (CIDR 16-32) और IPv6 (CIDR 64-128) द्वारा प्रमाणित है।
प्रदर्शन के कारण कि वजह से ५००० सम्पादानों से ज्यादा नहीं दिखा पायेगा।
इसे नीति के अनुसार प्रयोग करें।',
	'checkuser-desc' => 'सदस्यको अन्य सदस्योंके आईपी एड्रेस एवम्‌ अन्य ज़ानकारी देखने की अनुमति देता हैं।',
	'checkuser-logcase' => 'लॉगमें खोज लिपी पर आधारित (case sensitive) हैं।',
	'checkuser' => 'सदस्य जाँच',
	'checkuserlog' => 'सदस्यजाँच लॉग',
	'checkuser-contribs' => 'सदस्य आईपी पते जाँच करें',
	'group-checkuser' => 'सदस्य जाँचे',
	'group-checkuser-member' => 'सदस्य जाँच',
	'right-checkuser' => 'सदस्य का आइपी एड्रेस एवम्‌ अन्य ज़ानकारी जाँचें',
	'right-checkuser-log' => 'चेकईउजर लॉग देखें',
	'action-checkuser' => 'सदस्य का आइपी पते और अन्य ज़ानकारी जाँचें',
	'action-checkuser-log' => 'चेकईउजर लॉग देखें',
	'grouppage-checkuser' => '{{ns:project}}: सदस्य जाँच',
	'checkuser-reason' => 'कारण:',
	'checkuser-reason-api' => 'एपीआई: $1',
	'checkuser-showlog' => 'लॉग दिखायें',
	'checkuser-query' => 'हाल में हुए बदलाव देखें',
	'checkuser-target' => 'सदस्य या आईपी',
	'checkuser-users' => 'सदस्य खोजें',
	'checkuser-edits' => 'आईपीसे हुए बदलाव खोजें',
	'checkuser-ips' => 'आईपी खोजें',
	'checkuser-search' => 'खोजें',
	'checkuser-period' => 'अवधि:',
	'checkuser-week-1' => 'पिछले सप्ताह',
	'checkuser-week-2' => 'पिछले दो सप्ताह',
	'checkuser-month' => 'पिछले 30 दिनों',
	'checkuser-all' => 'सभी',
	'checkuser-cidr-res' => 'समन्वय CIDR:',
	'checkuser-empty' => 'इस लॉगमें एकभी आइटेम नहीं हैं।',
	'checkuser-nomatch' => 'मिलते जुलते लॉग मिले नहीं।',
	'checkuser-check' => 'जाँचें',
	'checkuser-log-fail' => 'लॉग एन्ट्री बढा नहीं पायें।',
	'checkuser-nolog' => 'लॉग फ़ाईल मिली नहीं।',
	'checkuser-blocked' => 'ब्लॉक किया हुआ हैं',
	'checkuser-gblocked' => 'दुनिया भर में ब्लॉक किया गया',
	'checkuser-locked' => 'अवरोधित',
	'checkuser-wasblocked' => 'पहले से ही अवरोध है',
	'checkuser-localonly' => 'एकीकृत नहीं',
	'checkuser-massblock' => 'चयनित सदस्यों को रोकें',
	'checkuser-blocktag' => 'सदस्य पृष्ठ बदलें:',
	'checkuser-blocktag-talk' => 'सदस्य वार्ता पृष्ठ बदलें:',
	'checkuser-massblock-commit' => 'चयनित सदस्यों को रोकें',
	'checkuser-block-success' => "'''{{PLURAL:$2|सदस्य|सदस्यों}} $1 अब अवरोधित हैं ।'''",
	'checkuser-block-failure' => "'''कोई सदस्य अवरोध नहीं हैं ।'''",
	'checkuser-block-limit' => 'बहत ज़्यादा सदस्य चुना है ।',
	'checkuser-block-noreason' => 'आपको अवरोध की कारण दर्शाना होगा ।',
	'checkuser-noreason' => 'आपको इस प्रश्न की कारण दर्शाना होगा ।',
	'checkuser-accounts' => '$1 नया {{PLURAL:$1|खाता|खाते}}',
	'checkuser-too-many' => 'बहुत सारे रिज़ल्ट, कृपया CIDRमें बदलाव करें।
नीचे इस्तेमाल हुए आईपी की सूची हैं (ज्यादा से ज्यादा ५०००, अनुक्रममें):',
	'checkuser-user-nonexistent' => 'दिया हुआ सदस्यनाम अस्तित्वमें नहीं हैं।',
	'checkuser-search-form' => 'ऐसे लॉग खोजें जहां $1 यह $2 हैं',
	'checkuser-search-submit' => 'खोजें',
	'checkuser-search-initiator' => 'चालक',
	'checkuser-search-target' => 'लक्ष्य',
	'checkuser-ipeditcount' => '~$1 सभी सदस्योंसे',
	'checkuser-log-return' => 'सदस्यजाँच मुखपृष्ठपर वापस जायें',
	'checkuser-log-userips' => '$1 के पास $2 के लिये आईपी हैं',
	'checkuser-log-ipedits' => '$1 के पास $2 के लिये बदलाव हैं',
	'checkuser-log-ipusers' => '$1 के पास $2 के लिये सदस्य हैं',
	'checkuser-log-ipedits-xff' => '$1 के पास $2 के लिये XFF बदलाव हैं',
	'checkuser-log-ipusers-xff' => '$1 के पास $2 के लिये XFF सदस्य हैं',
	'checkuser-log-useredits' => '$2 के लिए $1 को सम्पादन मिला',
	'checkuser-autocreate-action' => 'अपने आप निर्मित हुआ था',
	'checkuser-create-action' => 'बनाया गया था',
	'checkuser-email-action' => 'सदस्य "$1" को ईमेल भेजा गया',
	'checkuser-reset-action' => 'पासवर्ड रीसेट करें "$1" के लिए',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'checkuser-reason' => 'Rason:',
	'checkuser-search' => 'Pangita-a',
	'checkuser-search-submit' => 'Pangita-a',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Ex13
 * @author Excaliboor
 * @author SpeedyGonsales
 * @author Tivek
 */
$messages['hr'] = array(
	'checkuser-summary' => 'Ovaj alat pretražuje nedavne promjene i pronalazi IP adrese suradnika ili prikazuje uređivanja/ime suradnika ako je zadana IP adresa. Suradnici i uređivanja mogu biti dobiveni po XFF zaglavljima dodavanjem "/xff" na kraj IP adrese. Podržane su IPv4 (CIDR 16-32) i IPv6 (CIDR 64-128) adrese. Rezultat ima maksimalno 5.000 zapisa iz tehničkih razloga. Rabite ovaj alat u skladu s pravilima.',
	'checkuser-desc' => 'Daje suradniku pravo za provjeriti IP adrese suradnika i druge informacije',
	'checkuser-logcase' => 'Pretraživanje evidencije razlikuje velika i mala slova',
	'checkuser' => 'Provjeri suradnika',
	'checkuserlog' => 'Evidencija provjere suradnika',
	'checkuser-contribs' => 'provjeri suradničke IP adrese',
	'group-checkuser' => 'Provjeritelji',
	'group-checkuser-member' => 'Provjeritelj',
	'right-checkuser' => 'Provjeravanje IP adrese suradnika i drugih informacija',
	'right-checkuser-log' => 'Gledanje evidencije provjere suradnika',
	'grouppage-checkuser' => '{{ns:project}}:Provjeritelji',
	'checkuser-reason' => 'Razlog:',
	'checkuser-showlog' => 'Pokaži evidenciju',
	'checkuser-query' => 'Provjeri nedavne promjene',
	'checkuser-target' => 'IP adresa ili suradnik:',
	'checkuser-users' => 'Suradnička imena',
	'checkuser-edits' => 'Nađi izmjene',
	'checkuser-ips' => 'IP adrese',
	'checkuser-search' => 'Traži',
	'checkuser-period' => 'Vrijeme:',
	'checkuser-week-1' => 'zadnji tjedan',
	'checkuser-week-2' => 'zadnja dva tjedna',
	'checkuser-month' => 'zadnjih 30 dana',
	'checkuser-all' => 'sve',
	'checkuser-cidr-label' => 'Pronađite zajednički raspon i zahvaćene adrese za popis IP-ova',
	'checkuser-cidr-res' => 'Zajednički CIDR:',
	'checkuser-empty' => 'Evidencija je prazna.',
	'checkuser-nomatch' => 'Nema suradnika s tom IP adresom.',
	'checkuser-nomatch-edits' => 'Nema poklapanja.
Zadnja izmjena je bila $1 u $2.',
	'checkuser-check' => 'Provjeri',
	'checkuser-log-fail' => 'Ne mogu dodati zapis',
	'checkuser-nolog' => 'Evidencijska datoteka nije nađena',
	'checkuser-blocked' => 'Blokiran',
	'checkuser-gblocked' => 'Globalno blokiran',
	'checkuser-locked' => 'Zaključan',
	'checkuser-wasblocked' => 'Prethodno blokiran',
	'checkuser-localonly' => 'Nije sjedinjen',
	'checkuser-massblock' => 'Blokiraj odabrane suradnike',
	'checkuser-massblock-text' => 'Odabrani suradnički računi će biti blokirani na neograničeno, s uključenim autoblokiranjem i onemogućenim stvaranjem novih računa.
IP adrese će biti blokirane na 1 tjedan samo za IP suradnike s onemogućenim stvaranjem računa.',
	'checkuser-blocktag' => 'Zamijeni suradničke stranica sa:',
	'checkuser-blocktag-talk' => 'Zamijeni stranice za razgovor sa:',
	'checkuser-massblock-commit' => 'Blokiraj odabrane suradnike',
	'checkuser-block-success' => "'''{{PLURAL:$2|suradnik|suradnici}} $1 {{PLURAL:$2|je blokiran|su blokirani}}.'''",
	'checkuser-block-failure' => "'''Nema blokiranih suradnika.'''",
	'checkuser-block-limit' => 'Odabrano je previše suradnika.',
	'checkuser-block-noreason' => 'Morate upisati razlog za blokiranje.',
	'checkuser-noreason' => 'Morate navesti razlog za ovaj upit.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|novi račun|novih računa}}',
	'checkuser-too-many' => 'Previše rezultata, molimo suzite opseg (CIDR). Slijede korištene IP adrese (max 5000, poredano adresno):',
	'checkuser-user-nonexistent' => 'Traženi suradnik (suradničko ime) ne postoji.',
	'checkuser-search-form' => 'Nađi zapise u evidenciji gdje $1 je $2',
	'checkuser-search-submit' => 'Traži',
	'checkuser-search-initiator' => 'provjeritelj',
	'checkuser-search-target' => 'cilj (traženi pojam)',
	'checkuser-ipeditcount' => '~$1 od svih suradnika',
	'checkuser-log-return' => 'Vrati se na stranicu za provjeru',
	'checkuser-limited' => "'''Ovi rezultati su skraćeni zbog veće učinkovitosti izvođenja.'''",
	'checkuser-log-userips' => '$1 tražio je IP adrese suradnika $2',
	'checkuser-log-ipedits' => '$1 tražio je uređivanja suradnika $2',
	'checkuser-log-ipusers' => '$1 tražio je suradnička imena za IP adresu $2',
	'checkuser-log-ipedits-xff' => '$1 tražio je uređivanja za XFF $2',
	'checkuser-log-ipusers-xff' => '$1 tražio je imena suradnika za XFF $2',
	'checkuser-log-useredits' => '$1 tražio je uređivanja za $2',
	'checkuser-autocreate-action' => 'je automatski stvoren',
	'checkuser-email-action' => 'poslan email za "$1"',
	'checkuser-reset-action' => 'ponovno postavi lozinku za suradnika "$1"',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'checkuser-summary' => 'Tutón nastroj přepytuje aktualne změny, zo by IP-adresy wužiwarja zwěsćił abo změny abo wužiwarske daty za IP pokazał.
Wužiwarjo a změny IP-adresy dadźa so přez XFF-hłowy wotwołać, připowěšo "/xff" na IP-adresu. IPv4 (CIDR 16-32) a IPv6 (CIDR 64-128) so podpěrujetej.',
	'checkuser-desc' => 'Dawa wužiwarjam z trěbnym prawom móžnosć IP-adresy a druhe informacije wužiwarja kontrolować',
	'checkuser-logcase' => 'Pytanje w protokolu rozeznawa mjez wulko- a małopisanjom.',
	'checkuser' => 'Wužiwarja kontrolować',
	'checkuserlog' => 'Protokol wužiwarskeje kontrole',
	'checkuser-contribs' => 'Wužiwarske IP přepruwować',
	'group-checkuser' => 'Kontrolerojo',
	'group-checkuser-member' => '{{GENDER:$1|kontroler wužiwarjow|kontrolerka wužiwarjow}}',
	'right-checkuser' => 'Pruwowanje IP-adresow a druhe informacije wužiwarjow',
	'right-checkuser-log' => 'Protokol wužiwarskeje kontrole wobhladać',
	'action-checkuser' => 'IP-adresy wužiwarjow a druhe informacije přepruwować',
	'action-checkuser-log' => 'Protokol kontrolneho wužiwarja sej wobhladać',
	'grouppage-checkuser' => '{{ns:project}}:Checkuser',
	'checkuser-reason' => 'Přičina:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Protokol pokazać',
	'checkuser-query' => 'Poslednje změny wotprašeć',
	'checkuser-target' => 'IP-adresa abo wužiwarske mjeno:',
	'checkuser-users' => 'Wužiwarjow pokazać',
	'checkuser-edits' => 'Změny wołać',
	'checkuser-ips' => 'IP-adresy pokazać',
	'checkuser-search' => 'Pytać',
	'checkuser-period' => 'Traće:',
	'checkuser-week-1' => 'posledni tydźeń',
	'checkuser-week-2' => 'poslednjej dwě njedźeli',
	'checkuser-month' => 'poslednich 30 dnjow',
	'checkuser-all' => 'wšitcy',
	'checkuser-cidr-label' => 'Zhromadny wobłuk a potrjehene adresy za lisćinu IP-adresow namakać',
	'checkuser-cidr-res' => 'Zhromadny CIDR:',
	'checkuser-empty' => 'Protokol njewobsahuje zapiski.',
	'checkuser-nomatch' => 'Žane wotpowědniki namakane.',
	'checkuser-nomatch-edits' => 'Žane wotpowědowanja namakane.
Poslednja změna bě $1 $2.',
	'checkuser-check' => 'Pruwować',
	'checkuser-log-fail' => 'Njemóžno protokolowy zapisk přidać.',
	'checkuser-nolog' => 'Žadyn protokol namakany.',
	'checkuser-blocked' => 'Zablokowany',
	'checkuser-gblocked' => 'Globalnje zablokowany',
	'checkuser-locked' => 'Zawrjeny',
	'checkuser-wasblocked' => 'Prjedy zablokowany',
	'checkuser-localonly' => 'njezjednoćene',
	'checkuser-massblock' => 'Wubranych wužiwarjow blokować',
	'checkuser-massblock-text' => 'Wubrane konta budu so na přeco blokować, awtomatiske blokowanje je aktiwne a załoženje kontow je znjemóžnjene.
IP-adresy budu so na 1 tydźeń blokować (jenož za IP-wužiwarjow) a załoženje kontow je znjemóžnjene.',
	'checkuser-blocktag' => 'Wužiwarske strony narunać přez:',
	'checkuser-blocktag-talk' => 'Diskusijne strony narunać přez:',
	'checkuser-massblock-commit' => 'Wubranych wužiwarjow blokować',
	'checkuser-block-success' => "'''{{PLURAL:$2|Wužiwar|Wužiwarjej|Wužiwarjo|Wužiwarjo}} $1 {{PLURAL:$2|bu|buštaj|buchu|buchu}} nětko {{PLURAL:$2|zablokowany|zablokowanaj|zablokowani|zablokowani}}.'''",
	'checkuser-block-failure' => "'''Žane wužiwarjo zablokowani.'''",
	'checkuser-block-limit' => 'Přewjele wužiwarjow wubrane.',
	'checkuser-block-noreason' => 'Dyrbiš přičinu za zablokowanja podać.',
	'checkuser-noreason' => 'Dyrbiš přičinu za tute wotprašowanje podać.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nowe konto|nowej konće|nowe konta|nowych kontow}}',
	'checkuser-too-many' => 'Přewjele wuslědkow (po taksowanju naprašowanja), prošu zamjezuj CIDR.
Tu su wužiwane IP (maks. 5000, po adresy sortěrowane):',
	'checkuser-user-nonexistent' => 'Podaty wužiwar njeeksistuje.',
	'checkuser-search-form' => 'Protokolowe zapiski namakać, hdźež $1 je $2',
	'checkuser-search-submit' => 'Pytać',
	'checkuser-search-initiator' => 'iniciator',
	'checkuser-search-target' => 'cil',
	'checkuser-ipeditcount' => '~$1 wot wšěch wužiwarjow',
	'checkuser-log-return' => 'Wróćo k hłownemu formularej CheckUser',
	'checkuser-limited' => "'''Tute wuslědki buchu z wukonowych přičinow wobrězane.'''",
	'checkuser-log-userips' => '$1 dósta IP za $2',
	'checkuser-log-ipedits' => '$1 dósta změny za $2',
	'checkuser-log-ipusers' => '$1 dósta wužiwarjow za $2',
	'checkuser-log-ipedits-xff' => '$1 dósta změny za XFF $2',
	'checkuser-log-ipusers-xff' => '$1 dósta wužiwarjow za XFF $2',
	'checkuser-log-useredits' => '$1 je změny za $2 wobstarał',
	'checkuser-autocreate-action' => 'bu awtomatisce załožene',
	'checkuser-create-action' => 'bu wutworjeny',
	'checkuser-email-action' => 'pósła e-mejlku na wužiwarja "$1"',
	'checkuser-reset-action' => 'hesło za wužiwarja "$1" wobnowić',
);

/** Hungarian (Magyar)
 * @author Bináris
 * @author Dani
 * @author Dj
 * @author Dorgan
 * @author Glanthor Reviol
 * @author Grin
 * @author Hunyadym
 * @author KossuthRad
 * @author Terik
 * @author Tgr
 */
$messages['hu'] = array(
	'checkuser-summary' => 'Ez az eszköz végigvizsgálja a friss változásokat, hogy lekérje egy adott felhasználó IP-címeit vagy megjelenítse egy adott IP-címet használó szerkesztőket és az IP szerkesztéseit.
Egy kliens IP-cím által végzett szerkesztések és felhasználói XFF fejlécek segítségével kérhetőek le, az IP-cím utáni „/xff” parancssal. Az IPv4 (CIDR 16-32) és az IPv6 (CIDR 64-128) is támogatott.
Maximum 5000 szerkesztés fog megjelenni teljesítményi okok miatt. Az eszközt a szabályoknak megfelelően használd.',
	'checkuser-desc' => 'Lehetővé teszi olyan felhasználói jogok kiosztását, mely segítségével megtekinthetőek a felhasználók IP-címei és más adatok',
	'checkuser-logcase' => 'A kereső kis- és nagybetűérzékeny.',
	'checkuser' => 'IP-ellenőr',
	'checkuserlog' => 'IP-ellenőr-napló',
	'checkuser-contribs' => 'a szerkesztő IP-ellenőrzése',
	'group-checkuser' => 'IP-ellenőrök',
	'group-checkuser-member' => 'IP-ellenőr',
	'right-checkuser' => 'a felhasználók IP-címének és más adatainak ellenőrzése',
	'right-checkuser-log' => 'IP-ellenőri napló megtekintése',
	'action-checkuser' => 'a felhasználó IP-címének és más adatainak ellenőrzése',
	'action-checkuser-log' => 'felhasználó ellenőrzési napló megtekintése',
	'grouppage-checkuser' => '{{ns:project}}:IP-ellenőrök',
	'checkuser-reason' => 'Ok:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Napló megjelenítése',
	'checkuser-query' => 'Kétséges aktuális változások',
	'checkuser-target' => 'IP-cím vagy felhasználónév:',
	'checkuser-users' => 'Felhasználók keresése',
	'checkuser-edits' => 'Szerkesztések lekérése',
	'checkuser-ips' => 'IP-címek keresése',
	'checkuser-search' => 'Keresés',
	'checkuser-period' => 'Időtartam:',
	'checkuser-week-1' => 'előző hét',
	'checkuser-week-2' => 'előző két hét',
	'checkuser-month' => 'előző harminc nap',
	'checkuser-all' => 'összes',
	'checkuser-cidr-label' => 'IP-címek listája alapján azok közös tartományának és az érintett címek megkeresése',
	'checkuser-cidr-res' => 'Közös CIDR:',
	'checkuser-empty' => 'A napló nem tartalmaz elemeket.',
	'checkuser-nomatch' => 'Nincs egyezés.',
	'checkuser-nomatch-edits' => 'Nincs találat.
Az utolsó szerkesztés $1, $2-kor történt.',
	'checkuser-check' => 'Ellenőrzés',
	'checkuser-log-fail' => 'Nem sikerült az elem hozzáadása',
	'checkuser-nolog' => 'A naplófájl nem található.',
	'checkuser-blocked' => 'Blokkolva',
	'checkuser-gblocked' => 'Globálisan blokkolva',
	'checkuser-locked' => 'Zárva',
	'checkuser-wasblocked' => 'Korábban blokkolva',
	'checkuser-localonly' => 'Nincs egységesítve',
	'checkuser-massblock' => 'Kijelölt szerkesztők blokkolása',
	'checkuser-massblock-text' => 'A kiválasztott fiókok örökre blokkolva lesznek autoblokkal és letiltott fiókkészítéssel.
Az IP-címeknél csak a be nem jelentkezett felhasználók lesznek blokkolva 1 hétre, letiltott fiókkészítéssel.',
	'checkuser-blocktag' => 'Szerkesztői lapok cseréje erre:',
	'checkuser-blocktag-talk' => 'Vitalapok cseréje erre:',
	'checkuser-massblock-commit' => 'Kiválasztott szerkesztők blokkolása',
	'checkuser-block-success' => "'''A következő {{PLURAL:$2|szerkesztő|szerkesztők}} blokkolva {{PLURAL:$2|lett|lettek}}: $1.'''",
	'checkuser-block-failure' => "'''Nem lettek szerkesztők blokkolva.'''",
	'checkuser-block-limit' => 'Túl sok szerkesztőt választottál ki.',
	'checkuser-block-noreason' => 'Meg kell adnod a blokkolások okát.',
	'checkuser-noreason' => 'Meg kell adnod a lekérdezés okát.',
	'checkuser-accounts' => '{{PLURAL:$1|egy|$1}} új felhasználói fiók',
	'checkuser-too-many' => 'Túl sok találat (a lekérdezési becslés szerint), kérlek, szűkítsd le a CIDR-t.
Itt vannak a használt IP-címek (maximum 5000, cím alapján rendezve):',
	'checkuser-user-nonexistent' => 'A megadott szerkesztő nem létezik.',
	'checkuser-search-form' => 'Naplóbejegyzések keresése, ahol $1 $2',
	'checkuser-search-submit' => 'Keresés',
	'checkuser-search-initiator' => 'kezdeményező',
	'checkuser-search-target' => 'Cél',
	'checkuser-ipeditcount' => '~$1 az összes szerkesztő által',
	'checkuser-log-return' => 'Vissza az IP-ellenőri oldalra',
	'checkuser-limited' => "'''Teljesítményi okok miatt nem az összes találat lett megjelenítve.'''",
	'checkuser-log-userips' => '$1 lekérte $2 IP-címeit',
	'checkuser-log-ipedits' => '$1 lekérte $2 szerkesztéseit',
	'checkuser-log-ipusers' => '$1 lekérte a(z) $2 IP-címhez tartozó szerkesztőket',
	'checkuser-log-ipedits-xff' => '$1 lekérte XFF $2 szerkesztéseit',
	'checkuser-log-ipusers-xff' => '$1 lekérte XFF $2 szerkesztőit',
	'checkuser-log-useredits' => '$1 lekérdezte $2 szerkesztéseit',
	'checkuser-autocreate-action' => 'automatikusan létrehozva',
	'checkuser-create-action' => 'készült',
	'checkuser-email-action' => 'e-mailt küldött „$1” szerkesztőnek',
	'checkuser-reset-action' => 'lecserélte „$1” jelszavát',
);

/** Armenian (Հայերեն)
 * @author Togaed
 */
$messages['hy'] = array(
	'checkuser-search' => 'Որոնել',
	'checkuser-search-submit' => 'Որոնել',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'checkuser-summary' => 'Iste instrumento analysa le modificationes recente pro recuperar le adresses IP usate per un usator o pro monstrar le datos de modificationes e de usatores pro un adresse IP.
Le usatores e modificationes facite desde un adresse IP de cliente pote esser recuperate via capites XFF per appender "/xff" al IP.
Es supportate le adresses IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128).
Non plus de 5000 modificationes essera retornate pro non supercargar le systema.
Tote uso de iste instrumento debe esser conforme al politicas in vigor.',
	'checkuser-desc' => 'Concede al usatores con le autorisation appropriate le capabilitate de verificar le adresses IP e altere informationes de usatores',
	'checkuser-logcase' => 'Le recerca del registros distingue inter majusculas e minusculas.',
	'checkuser' => 'Verificar usator',
	'checkuserlog' => 'Registro de verification de usatores',
	'checkuser-contribs' => 'verificar IPs de usatores',
	'group-checkuser' => 'Verificatores de usatores',
	'group-checkuser-member' => '{{GENDER:$1|verificator|verificatrice}} de usatores',
	'right-checkuser' => 'Verificar le adresses IP e altere informationes del usator',
	'right-checkuser-log' => 'Vider le registro de verification de usatores',
	'action-checkuser' => 'verificar le adresses IP e altere informationes del usator',
	'action-checkuser-log' => 'vider le registro de verification de usatores',
	'grouppage-checkuser' => '{{ns:project}}:Verificator de usatores',
	'checkuser-reason' => 'Motivo:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Monstrar registro',
	'checkuser-query' => 'Consultar le modificationes recente',
	'checkuser-target' => 'Adresse IP o nomine de usator:',
	'checkuser-users' => 'Cercar usatores',
	'checkuser-edits' => 'Obtener modificationes',
	'checkuser-ips' => 'Cercar IPs',
	'checkuser-search' => 'Cercar',
	'checkuser-period' => 'Durata:',
	'checkuser-week-1' => 'ultime septimana',
	'checkuser-week-2' => 'ultime duo septimanas',
	'checkuser-month' => 'ultime 30 dies',
	'checkuser-all' => 'totes',
	'checkuser-cidr-label' => 'Cercar le gamma commun e le adresses afficite pro un lista de IPs',
	'checkuser-cidr-res' => 'CIDR commun:',
	'checkuser-empty' => 'Le registro non contine entratas.',
	'checkuser-nomatch' => 'Nihil trovate.',
	'checkuser-nomatch-edits' => 'Nulle resultato trovate.
Le ultime modification esseva le $1 a $2.',
	'checkuser-check' => 'Verificar',
	'checkuser-log-fail' => 'Impossibile adder entrata al registro',
	'checkuser-nolog' => 'Nulle file de registro trovate.',
	'checkuser-blocked' => 'Blocate',
	'checkuser-gblocked' => 'Globalmente blocate',
	'checkuser-locked' => 'Serrate',
	'checkuser-wasblocked' => 'Anteriormente blocate',
	'checkuser-localonly' => 'Non unificate',
	'checkuser-massblock' => 'Blocar usatores seligite',
	'checkuser-massblock-text' => 'Le contos seligite essera blocate infinitemente, con le blocada automatic activate e le creation de contos disactivate.
Le adresses IP essera blocate durante 1 septimana pro usatores IP solmente e con le creation de contos disactivate.',
	'checkuser-blocktag' => 'Reimplaciar paginas de usatores con:',
	'checkuser-blocktag-talk' => 'Reimplaciar le paginas de discussion per:',
	'checkuser-massblock-commit' => 'Blocar usatores seligite',
	'checkuser-block-success' => "'''Le {{PLURAL:$2|usator|usatores}} $1 es ora blocate.'''",
	'checkuser-block-failure' => "'''Nulle usator blocate.'''",
	'checkuser-block-limit' => 'Troppo de usatores seligite.',
	'checkuser-block-noreason' => 'Tu debe indicar un motivo pro le blocadas.',
	'checkuser-noreason' => 'Tu debe dar un motivo pro iste consulta.',
	'checkuser-accounts' => '$1 nove {{PLURAL:$1|conto|contos}}',
	'checkuser-too-many' => 'Troppo de resultatos (secundo un estimation del consulta). Per favor restringe le CIDR.
Ecce le IPs usate (max. 5000, ordinate per adresse):',
	'checkuser-user-nonexistent' => 'Le usator specificate non existe.',
	'checkuser-search-form' => 'Cercar entratas in le registro ubi le $1 es $2',
	'checkuser-search-submit' => 'Cercar',
	'checkuser-search-initiator' => 'initiator',
	'checkuser-search-target' => 'objectivo',
	'checkuser-ipeditcount' => '~$1 de tote le usatores',
	'checkuser-log-return' => 'Retornar al formulario principal del verification de usatores',
	'checkuser-limited' => "'''Iste resultatos ha essite truncate pro motivos de prestationes.'''",
	'checkuser-log-userips' => '$1 obteneva IPs pro $2',
	'checkuser-log-ipedits' => '$1 obteneva modificationes pro $2',
	'checkuser-log-ipusers' => '$1 obteneva usatores pro $2',
	'checkuser-log-ipedits-xff' => '$1 obteneva modificationes pro XFF $2',
	'checkuser-log-ipusers-xff' => '$1 obteneva usatores pro XFF $2',
	'checkuser-log-useredits' => '$1 obteneva modificationes de $2',
	'checkuser-autocreate-action' => 'ha essite create automaticamente',
	'checkuser-create-action' => 'ha essite create',
	'checkuser-email-action' => 'inviava un e-mail al usator "$1"',
	'checkuser-reset-action' => 'redefiniva contrasigno pro usator "$1"',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Borgx
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 * @author Iwan Novirion
 * @author Kenrick95
 * @author Rex
 */
$messages['id'] = array(
	'checkuser-summary' => 'Peralatan ini memindai perubahan terbaru untuk mengetahui IP seorang pengguna atau menampilkan data suntingan/pengguna untuk suatu IP.
Pengguna dan suntingan suatu IP dapat diketahui melalui kepala XFF dengan menambahkan "/xff" pada IP tersebut. Alat ini mendukung baik IPv4 (CIDR 16-32) maupun IPv6 (CIDR 64-128).
Karena alasan kinerja, maksimum hanya 5000 suntingan yang dapat diambil.
Harap gunakan peralatan ini sesuai dengan kebijakan yang ada.',
	'checkuser-desc' => 'Memberikan fasilitas bagi pengguna yang memiliki hak akses untuk memeriksa alamat IP dan informasi lain dari pengguna',
	'checkuser-logcase' => 'Log ini bersifat sensitif terhadap kapitalisasi.',
	'checkuser' => 'Pemeriksaan pengguna',
	'checkuserlog' => 'Log pemeriksaan pengguna',
	'checkuser-contribs' => 'memeriksa IP pengguna',
	'group-checkuser' => 'Pemeriksa',
	'group-checkuser-member' => 'Pemeriksa',
	'right-checkuser' => 'Memeriksa alamat IP pengguna dan informasi lainnya',
	'right-checkuser-log' => 'Melihat log pemeriksa',
	'grouppage-checkuser' => '{{ns:project}}:Pemeriksa',
	'checkuser-reason' => 'Alasan:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Tampilkan log',
	'checkuser-query' => 'Kueri perubahan terbaru',
	'checkuser-target' => 'Alamat IP atau nama pengguna:',
	'checkuser-users' => 'Cari pengguna',
	'checkuser-edits' => 'Cari suntingan',
	'checkuser-ips' => 'Cari IP',
	'checkuser-search' => 'Cari',
	'checkuser-period' => 'Jangka waktu:',
	'checkuser-week-1' => 'minggu lalu',
	'checkuser-week-2' => 'dua minggu terakhir',
	'checkuser-month' => '30 hari terakhir',
	'checkuser-all' => 'semua',
	'checkuser-cidr-label' => 'Mencari jangkauan umum dan alamat yang dipengaruhi dari sebuah daftar IP',
	'checkuser-cidr-res' => 'CIDR umum:',
	'checkuser-empty' => 'Log kosong.',
	'checkuser-nomatch' => 'Tidak ditemukan data yang cocok.',
	'checkuser-nomatch-edits' => 'Tidak ditemukan hasil sesuai kriteria yang diberikan.
Suntingan terakhir dilakukan pada $1 $2.',
	'checkuser-check' => 'Periksa',
	'checkuser-log-fail' => 'Entri log tidak dapat ditambahkan',
	'checkuser-nolog' => 'Berkas log tidak ditemukan.',
	'checkuser-blocked' => 'Diblok',
	'checkuser-gblocked' => 'Diblokir secara global',
	'checkuser-locked' => 'Terkunci',
	'checkuser-wasblocked' => 'Telah diblokir sebelumnya',
	'checkuser-localonly' => 'Tidak digabungkan',
	'checkuser-massblock' => 'Blokir pengguna yang dipilih',
	'checkuser-massblock-text' => 'Akun-akun yang dipilih akan diblokir selamanya, alamat-alamat IP terakhir yang digunakan otomatis diblokir dan tidak diperbolehkan membuat akun.
Alamat-alamat IP akan diblokir selama 1 minggu untuk pengguna anonim dan tidak diperbolehkan membuat akun.',
	'checkuser-blocktag' => 'Ganti halaman pengguna dengan:',
	'checkuser-blocktag-talk' => 'Ganti halaman pembicaraan dengan:',
	'checkuser-massblock-commit' => 'Blokir pengguna yang dipilih',
	'checkuser-block-success' => "'''{{PLURAL:$2|Pengguna|Pengguna}} $1 berhasil diblokir.'''",
	'checkuser-block-failure' => "'''Tidak ada pengguna yang diblokir.'''",
	'checkuser-block-limit' => 'Jumlah pengguna yang dipilih terlalu banyak.',
	'checkuser-block-noreason' => 'Anda harus mengisi alasan pemblokiran.',
	'checkuser-noreason' => 'Anda harus memberikan alasan untuk kueri ini.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|akun|akun-akun}} baru',
	'checkuser-too-many' => 'Terlalu banyak hasil pencarian (menurut perkiraan permintaan), mohon persempit CIDR. Berikut adalah alamat-alamat IP yang digunakan (5000 maks, diurut berdasarkan alamat):',
	'checkuser-user-nonexistent' => 'Pengguna yang dimaksud tidak ditemukan',
	'checkuser-search-form' => 'Cari catatan log dengan $1 adalah $2',
	'checkuser-search-submit' => 'Cari',
	'checkuser-search-initiator' => 'pemeriksa',
	'checkuser-search-target' => 'target',
	'checkuser-ipeditcount' => '~$1 dari seluruh pengguna',
	'checkuser-log-return' => 'Kembali ke halaman utama Pemeriksa',
	'checkuser-limited' => "'''Hasil berikut telah dipotong agar tidak menurunkan kinerja.'''",
	'checkuser-log-userips' => '$1 melihat IP dari $2',
	'checkuser-log-ipedits' => '$1 melihat suntingan dari $2',
	'checkuser-log-ipusers' => '$1 melihat nama pengguna dari $2',
	'checkuser-log-ipedits-xff' => '$1 melihat suntingan dari XFF $2',
	'checkuser-log-ipusers-xff' => '$1 melihat nama pengguna dari XFF $2',
	'checkuser-log-useredits' => '$1 memiliki suntingan-suntingan untuk $2',
	'checkuser-autocreate-action' => 'dibuat secara otomatis',
	'checkuser-create-action' => 'dibuat',
	'checkuser-email-action' => 'mengirimkan surel ke "$1"',
	'checkuser-reset-action' => 'Set ulang kata sandi pengguna "$1"',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'checkuser' => "Lé ọ'bànifé anya",
	'group-checkuser' => "Lé ọ'bànifé anya",
	'group-checkuser-member' => "Lé ọ'bànifé anya",
	'checkuser-reason' => 'Mgbághapụtà:',
	'checkuser-showlog' => 'Zí ndétu nchétá',
	'checkuser-users' => "Wèté ọ'bànifé",
	'checkuser-edits' => 'Gá nwèté orü shí IP',
	'checkuser-ips' => 'Gá nwèté ónúọgụgụ IP',
	'checkuser-search' => 'Chọwa',
	'checkuser-period' => 'Ógè ȯ wèrè:',
	'checkuser-week-1' => 'izù nke gáráni',
	'checkuser-month' => 'úbochi 30 gárání',
	'checkuser-all' => 'nke nílé',
	'checkuser-check' => 'Lechányá',
	'checkuser-blocked' => 'Kwàchịrị',
	'checkuser-locked' => 'Gbàchịrị',
	'checkuser-search-submit' => 'Chọwa',
	'checkuser-search-initiator' => 'onyé bịdòrò',
	'checkuser-search-target' => 'nkèọnejé',
	'checkuser-log-useredits' => '$1 nwèrè orü màkà $2',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'checkuser-summary' => 'Daytoy a ramit ket ag-scan kadagiti kaudian a balbaliw tapno agala kadagiti IP a pagtaengan nga inus-usar ti agar-aramat wenno agiparang ti data ti inurnos/agar-aramat para iti IP a pagtaengan.
Dagiti agar-aramat ket inurnos babaen ti kliente ti IP a pagtaengan ket maala babaen dagiti XFF a paulo babaen ti panagala ti IP a pagtaengan nga addaan ti "/xff". Nasuportaran ti IPv4 (CIDR 16-32) ken IPv6 (CIDR 64-128) .

Usaren daytoy babaen ti annuroten.',
	'checkuser-desc' => 'Agited kadagiti agar-aramat ti maibagay a pammalubos ti abilidad nga agkita kadagiti IP a pagtaengan ti agar-aramat ken sabsabali pay a pakaammo.',
	'checkuser-logcase' => 'Ti panag-biruk ti listaan ket sensitibo ti kadakkel ti letra.',
	'checkuser' => 'Kitaen ti agar-aramat',
	'checkuserlog' => 'Kitaen ti listaan ti agar-aramat',
	'checkuser-contribs' => 'kitaen ti IP a pagtaengan ti agar-aramat',
	'group-checkuser' => 'Kitaen dagiti agar-aramat',
	'group-checkuser-member' => '{{GENDER:$1|kitaen ti agar-aramat}}',
	'right-checkuser' => 'Kitaen dagiti IP a pagtaengan ti agar-aramat ken sabsabali a pakaammo.',
	'right-checkuser-log' => 'Kitaen ti listaan ti panagkita ti agar-aramat',
	'action-checkuser' => 'kitaen dagiti IP a pagtaengan ti agar-aramat ken sabsabali a pakaammo',
	'action-checkuser-log' => 'kitaen ti listaan ti panagkita ti agar-aramat',
	'grouppage-checkuser' => '{{ns:project}}:Kitaen ti agar-aramat',
	'checkuser-reason' => 'Rason:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Ipakita ti listaan',
	'checkuser-query' => 'Sapulen dagiti kaudian a balbaliw',
	'checkuser-target' => 'IP a pagtaengan wenno nagan ti agar-aramat:',
	'checkuser-users' => 'Alaen dagiti agar-aramat',
	'checkuser-edits' => 'Alaen dagiti inurnos',
	'checkuser-ips' => 'Alaen dagiti IP a pagtaengan',
	'checkuser-search' => 'Biruken',
	'checkuser-period' => 'Kabayag:',
	'checkuser-week-1' => 'napalabas a lawas',
	'checkuser-week-2' => 'dua a lawas a napalabas',
	'checkuser-month' => 'napalabas a 30 nga al-aldaw',
	'checkuser-all' => 'amin',
	'checkuser-cidr-label' => 'Biruken ti kadawyan a sakup ken maaringan nga IP a pagtaengan para ti listaan iti IP a pagtaengan',
	'checkuser-cidr-res' => 'Kadawyan a CIDR:',
	'checkuser-empty' => 'Ti listaan ket awanen ti banbanag.',
	'checkuser-nomatch' => 'Awan ti kapadpada a nabirukan.',
	'checkuser-nomatch-edits' => 'Awan ti nabirukan a kapadpada.
Ti naudi a naurnos ket idi $1 iti oras a $2.',
	'checkuser-check' => 'Kitaen',
	'checkuser-log-fail' => 'Saan a makanayon idiay listaan',
	'checkuser-nolog' => 'Awan ti listaan a papeles ti nabirukan.',
	'checkuser-blocked' => 'Naserraan',
	'checkuser-gblocked' => 'Sangalubongan a naserraan',
	'checkuser-locked' => 'Napengdan',
	'checkuser-wasblocked' => 'Naserraan idi',
	'checkuser-localonly' => 'Saan a naitipon',
	'checkuser-massblock' => 'Serran dagiti napili nga agar-aramat',
	'checkuser-massblock-text' => 'Dagiti napili a pakabilangan ket maserraan ingat ingana, nga addaan ti automatiko a panagserra dagiti IP a pagtaengan ke napakabaelan ken ti panagramid ti pakabilangan ket nabaldado.',
	'checkuser-blocktag' => 'Sukatan dagiti panid ti agar-aramid iti:',
	'checkuser-blocktag-talk' => 'Sukatan dagiti patungtungan a panid ti agar-aramid iti:',
	'checkuser-massblock-commit' => 'Serran dagiti napili nga agar-aramat',
	'checkuser-block-success' => "''' {{PLURAL:$2|Ti agar-aramat|Dagiti agar-aramat}} $1 {{PLURAL:$2|ket|ket}} naserran dan.'''",
	'checkuser-block-failure' => "'''Awan ti agar-aramat  a naserraan.'''",
	'checkuser-block-limit' => 'Adu unay ti agar-aramat a napili.',
	'checkuser-block-noreason' => 'Masapul nga agited ka ti rason para kadagiti panag-serra.',
	'checkuser-noreason' => 'Masapul nga agited ka ti rason para kadagitoy panagsapul.',
	'checkuser-accounts' => '$1 baro {{PLURAL:$1|a pakabilangan|a dagiti pakabilangan}}',
	'checkuser-too-many' => 'Adu unay dagiti nagbanagan (babaen ti karkulo ti panagsapul), pangngaasi a pabassiten ti CIDR.
Adda ditoy dagiti IP a nausar ( 5000 kangato, nailasin babaen ti pagtaengan):',
	'checkuser-user-nonexistent' => 'Ti nainaganan nga agar-aramat ket awanen.',
	'checkuser-search-form' => 'Agbiruk kadagiti naikabil iti listaan ti ayan ti $1 ket $2',
	'checkuser-search-submit' => 'Biruken',
	'checkuser-search-initiator' => 'nangrugi',
	'checkuser-search-target' => 'puntaan',
	'checkuser-ipeditcount' => '~$1 manipud kadagiti agar-aramat',
	'checkuser-log-return' => 'Agsubli idiay umuna a nakabuklan ti CheckUser',
	'checkuser-limited' => "'''Dagitoy a nagbanagan ket napasardeng para iti pannaka-aramid a rason.'''",
	'checkuser-log-userips' => '$1 ket nakaala ti IP a pagtaengan para iti $2',
	'checkuser-log-ipedits' => '$1 nakaala dagiti inurnos para iti $2',
	'checkuser-log-ipusers' => '$1 nakala dagiti agar-aramat para iti $2',
	'checkuser-log-ipedits-xff' => '$1 nakaala kadagiti inurnos para iti XFF $2',
	'checkuser-log-ipusers-xff' => '$1 nakaala kadagiti agar-aramat para iti XFF $2',
	'checkuser-log-useredits' => '$1 nakaala dagiti inurnos para iti $2',
	'checkuser-autocreate-action' => 'ket automatiko a naaramid',
	'checkuser-create-action' => 'ket naaramid',
	'checkuser-email-action' => 'nagipatulod ti e-surat ti agar-aramat "$1"',
	'checkuser-reset-action' => 'isubli ti kontrasenias para ti agar-aramat "$1"',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'checkuser-reason' => 'Motivo:',
	'checkuser-target' => 'IP-adreso od uzanto-nomo:',
	'checkuser-week-1' => 'lasta semano',
	'checkuser-week-2' => 'lasta du semani',
	'checkuser-month' => 'lasta 30 dii',
	'checkuser-all' => 'omna',
	'checkuser-cidr-res' => 'Komuna CIDR:',
	'checkuser-accounts' => '$1 nova {{PLURAL:$1|konto|konti}}',
	'checkuser-search-submit' => 'Serchar',
	'checkuser-ipeditcount' => '~$1 di omna uzanti',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author Snævar
 * @author Spacebirdy
 */
$messages['is'] = array(
	'checkuser-desc' => 'Veitir notendum réttindi til að athuga vistföng notenda og aðrar notendaupplýsingar.',
	'checkuser' => 'Notenda athugandi',
	'group-checkuser' => 'Notenda athugandi',
	'group-checkuser-member' => '{{GENDER:$1|notenda athugandi}}',
	'grouppage-checkuser' => '{{ns:project}}:Notenda athugandi',
	'checkuser-reason' => 'Ástæða:',
	'checkuser-showlog' => 'Sýna skrá',
	'checkuser-query' => 'Sækja nýlegar breytingar',
	'checkuser-target' => 'Notandi eða vistfang',
	'checkuser-users' => 'Sækja notendur',
	'checkuser-edits' => 'Sækja breytingar eftir vistang',
	'checkuser-ips' => 'Sækja vistföng',
	'checkuser-search' => 'Leita',
	'checkuser-nomatch' => 'Engin samsvörun fannst.',
	'checkuser-check' => 'Athuga',
	'checkuser-nolog' => 'Engin skrá fundin.',
	'checkuser-blocked' => 'Bannaður',
	'checkuser-locked' => 'Læstur',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nýr aðgangur|nýir aðgangar}}',
	'checkuser-search-submit' => 'Leita',
);

/** Italian (Italiano)
 * @author .anaconda
 * @author Aushulz
 * @author Beta16
 * @author BrokenArrow
 * @author Darth Kule
 * @author F. Cosoleto
 * @author Gianfranco
 * @author Melos
 * @author Nemo bis
 * @author Pietrodn
 * @author Stefano-c
 */
$messages['it'] = array(
	'checkuser-summary' => 'Questo strumento analizza le modifiche recenti per recuperare gli indirizzi IP utilizzati da un utente o mostrare contributi e dati di un IP. Utenti e contributi di un client IP possono essere rintracciati attraverso gli header XFF aggiungendo all\'IP il suffisso "/xff". Sono supportati IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128). Non saranno restituite più di 5.000 modifiche, per ragioni di prestazioni. Usa questo strumento in stretta conformità alle policy.',
	'checkuser-desc' => 'Consente agli utenti con le opportune autorizzazioni di sottoporre a verifica gli indirizzi IP e altre informazioni relative agli utenti',
	'checkuser-logcase' => "La ricerca nei log è ''case sensitive'' (distingue fra maiuscole e minuscole).",
	'checkuser' => 'Controllo utenze',
	'checkuserlog' => 'Registro dei controlli utente',
	'checkuser-contribs' => "controlla gli indirizzi IP dell'utente",
	'group-checkuser' => 'Check users',
	'group-checkuser-member' => '{{GENDER:$1|Check user}}',
	'right-checkuser' => "Visualizza gli indirizzi IP usati dall'utente e altre informazioni",
	'right-checkuser-log' => 'Visualizza il log dei checkuser',
	'action-checkuser' => "controlla gli indirizzi IP dell'utente e altre informazioni",
	'action-checkuser-log' => 'vedere il log dei checkuser',
	'grouppage-checkuser' => '{{ns:project}}:Check user',
	'checkuser-reason' => 'Motivo:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Mostra il log',
	'checkuser-query' => 'Cerca nelle ultime modifiche',
	'checkuser-target' => 'Indirizzo IP o nome utente:',
	'checkuser-users' => 'Cerca utenti',
	'checkuser-edits' => 'Vedi i contributi',
	'checkuser-ips' => 'Cerca IP',
	'checkuser-search' => 'Cerca',
	'checkuser-period' => 'Periodo:',
	'checkuser-week-1' => 'ultima settimana',
	'checkuser-week-2' => 'ultime due settimane',
	'checkuser-month' => 'ultimi 30 giorni',
	'checkuser-all' => 'tutti gli edit',
	'checkuser-cidr-label' => "Trova l'intervallo comune e gli indirizzi interessati per una lista di IP",
	'checkuser-cidr-res' => 'CIDR comune:',
	'checkuser-empty' => 'Il log non contiene dati.',
	'checkuser-nomatch' => 'Nessun risultato trovato.',
	'checkuser-nomatch-edits' => 'Nessun risultato trovato.
Ultimo edit risalente alle $2 del $1.',
	'checkuser-check' => 'Controlla',
	'checkuser-log-fail' => 'Impossibile aggiungere la voce al log',
	'checkuser-nolog' => 'Non è stato trovato alcun file di log.',
	'checkuser-blocked' => 'Bloccato',
	'checkuser-gblocked' => 'Bloccato globalmente',
	'checkuser-locked' => 'Disabilitato',
	'checkuser-wasblocked' => 'Bloccato precedentemente',
	'checkuser-localonly' => 'Non unificato',
	'checkuser-massblock' => 'Blocca utenti selezionati',
	'checkuser-massblock-text' => 'Gli account selezionati saranno bloccati infinito, con il blocco automatico attivato e la creazione di nuovi account disattivata.
Gli indirizzi IP saranno bloccati per una settimana solo per gli utenti anonimi e con la creazione account disattivata.',
	'checkuser-blocktag' => 'Sostituisci pagine utente con:',
	'checkuser-blocktag-talk' => 'Sostituisci pagine di discussione con:',
	'checkuser-massblock-commit' => 'Blocca utenti selezionati',
	'checkuser-block-success' => "'''{{PLURAL:$2|L'utente|Gli utenti}} $1 {{PLURAL:$2|è adesso bloccato|sono adesso bloccati}}.'''",
	'checkuser-block-failure' => "'''Nessun utente bloccato.'''",
	'checkuser-block-limit' => 'Troppi utenti selezionati.',
	'checkuser-block-noreason' => 'È obbligatorio fornire una motivazione per i blocchi.',
	'checkuser-noreason' => 'È necessario fornire una motivazione per questa query.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nuovo|nuovi}} account',
	'checkuser-too-many' => 'Troppi risultati (per la query), usa un CIDR più ristretto.
Di seguito sono indicati gli indirizzi IP utilizzati (fino a un massimo di 5000, ordinati per indirizzo):',
	'checkuser-user-nonexistent' => "L'utente indicato non esiste.",
	'checkuser-search-form' => 'Trova le voci del log per le quali $1 è $2',
	'checkuser-search-submit' => 'Ricerca',
	'checkuser-search-initiator' => 'iniziatore',
	'checkuser-search-target' => 'obiettivo',
	'checkuser-ipeditcount' => '~$1 complessivamente',
	'checkuser-log-return' => 'Torna al modulo principale di Controllo utenze',
	'checkuser-limited' => "'''I risultati sono stati troncati per motivi di prestazioni.'''",
	'checkuser-log-userips' => '$1 ha ottenuto gli indirizzi IP di $2',
	'checkuser-log-ipedits' => '$1 ha ottenuto le modifiche di $2',
	'checkuser-log-ipusers' => '$1 ha ottenuto le utenze di $2',
	'checkuser-log-ipedits-xff' => '$1 ha ottenuto le modifiche di $2 via XFF',
	'checkuser-log-ipusers-xff' => '$1 ha ottenuto le utenze di $2 via XFF',
	'checkuser-log-useredits' => '$1 ha ottenuto i contributi di $2',
	'checkuser-autocreate-action' => 'è stato creato automaticamente',
	'checkuser-create-action' => 'è stato creato',
	'checkuser-email-action' => 'ha inviato una e-mail a "$1"',
	'checkuser-reset-action' => 'reimposta password per l\'utente "$1"',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author JtFuruhata
 * @author Kahusi
 * @author Kanjy
 * @author Marine-Blue
 * @author Muttley
 * @author Schu
 * @author Suisui
 * @author Vigorous action
 * @author 青子守歌
 */
$messages['ja'] = array(
	'checkuser-summary' => 'このツールは最近の更新を元に、ある利用者が使用したIPアドレスの検索、または、あるIPアドレスからなされた編集および利用者名の表示を行います。
IPアドレスと共に「/xff」オプションを指定すると、XFF (X-Forwarded-For) ヘッダを通じてクライアントIPアドレスを取得し、そこからなされた編集および利用者名の検索をすることが可能です。
IPv4 (16から32ビットのCIDR表記) と IPv6 (96から128ビットのCIDR表記) をサポートしています。
パフォーマンス上の理由により、最大5000件の編集しか表示出来ません。
方針に従って使用してください。',
	'checkuser-desc' => '特定の権限を付与された利用者に対して、利用者のIPアドレスなどの情報の確認を可能にします。',
	'checkuser-logcase' => 'ログの検索では大文字と小文字を区別します。',
	'checkuser' => '利用者の調査',
	'checkuserlog' => '利用者の調査記録',
	'checkuser-contribs' => '利用者のIPを調査',
	'group-checkuser' => '利用者調査者',
	'group-checkuser-member' => '利用者調査者',
	'right-checkuser' => '利用者のIPアドレスやその他の情報を調査',
	'right-checkuser-log' => '利用者調査ログを表示',
	'grouppage-checkuser' => '{{ns:project}}:利用者調査者',
	'checkuser-reason' => '理由：',
	'checkuser-showlog' => 'ログを閲覧',
	'checkuser-query' => '最近の更新を照会',
	'checkuser-target' => 'IPアドレスまたは利用者名：',
	'checkuser-users' => '利用者名を取得',
	'checkuser-edits' => '編集を取得',
	'checkuser-ips' => 'IPアドレスを取得',
	'checkuser-search' => '検索',
	'checkuser-period' => '期間:',
	'checkuser-week-1' => '先週',
	'checkuser-week-2' => '前2週',
	'checkuser-month' => '前30日間',
	'checkuser-all' => 'すべて',
	'checkuser-cidr-label' => 'IPアドレス一覧から共通レンジと影響を受けるアドレスを見つけ出す',
	'checkuser-cidr-res' => '共通CIDR:',
	'checkuser-empty' => 'ログ内に項目がありません。',
	'checkuser-nomatch' => '該当するものはありません。',
	'checkuser-nomatch-edits' => '該当するものはありません。
最終編集は $1 $2 です。',
	'checkuser-check' => '調査',
	'checkuser-log-fail' => 'ログに追加することができません',
	'checkuser-nolog' => 'ログファイルが見つかりません。',
	'checkuser-blocked' => 'ブロック済',
	'checkuser-gblocked' => 'グローバルブロックされています',
	'checkuser-locked' => 'ロック済',
	'checkuser-wasblocked' => '過去にブロックの記録あり',
	'checkuser-localonly' => '統一されていません',
	'checkuser-massblock' => '選択した利用者をブロックする',
	'checkuser-massblock-text' => '選択した利用者は無期限ブロックされ、同時に自動ブロックが作動しアカウント作成も禁止されます。IPアドレスはIP利用者向けに1週間ブロックされ、アカウント作成が禁止されます。',
	'checkuser-blocktag' => '利用者ページを以下で置き換える:',
	'checkuser-blocktag-talk' => 'トークページを置換:',
	'checkuser-massblock-commit' => '選択した利用者をブロック',
	'checkuser-block-success' => "'''{{PLURAL:$2|利用者}} $1 はブロック{{PLURAL:$2|されました}}。'''",
	'checkuser-block-failure' => "'''ブロックされた利用者はありません。'''",
	'checkuser-block-limit' => '選択した利用者の数が多すぎます。',
	'checkuser-block-noreason' => 'ブロック理由の記入が必要です。',
	'checkuser-noreason' => 'この照会には理由を与えなければなりません。',
	'checkuser-accounts' => '$1つの新しい{{PLURAL:$1|アカウント}}',
	'checkuser-too-many' => '（照会を推定したところ）検索結果が多すぎます。CIDRの指定を小さく絞り込んでください。利用されたIPは以下の通りです（5000件を上限に、アドレス順で整列されています）:',
	'checkuser-user-nonexistent' => '指定された利用者は存在しません。',
	'checkuser-search-form' => '$1 が $2 であるログ項目を探す',
	'checkuser-search-submit' => '検索',
	'checkuser-search-initiator' => '調査実行者',
	'checkuser-search-target' => '調査対象者',
	'checkuser-ipeditcount' => '全利用者からの編集回数～$1',
	'checkuser-log-return' => '利用者調査のメインフォームへ戻る',
	'checkuser-limited' => "'''パフォーマンスの都合から結果は省略されています。'''",
	'checkuser-log-userips' => '$1 は $2 が使用したIPアドレスを取得',
	'checkuser-log-ipedits' => '$1 は $2 からなされた編集を取得',
	'checkuser-log-ipusers' => '$1 は $2 からアクセスされた利用者名を取得',
	'checkuser-log-ipedits-xff' => '$1 は XFF $2 からなされた編集を取得',
	'checkuser-log-ipusers-xff' => '$1 は XFF $2 からアクセスされた利用者名を取得',
	'checkuser-log-useredits' => '$1 は $2 による編集を取得',
	'checkuser-autocreate-action' => '自動的に作成',
	'checkuser-create-action' => '作成済',
	'checkuser-email-action' => '利用者"$1"へメールを送る',
	'checkuser-reset-action' => '利用者"$1"のパスワードをリセット',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'checkuser-summary' => 'Dette værktøj scanner Seneste ændringer for at finde IP\'er brugt af en bestemt bruger, eller for at vise redigerings- eller brugerdata for en IP.
Bruger og redigeringer fra en klient IP kan hentes via XFF headers ved at tilføje "/xff" til IP\'en. Ipv4 (CIRD 16-32) og IPv6 (CIDR 64-128) er understøttet.
For at sikre programmelets ydeevne kan maksimalt 5000 redigeringer returneres. Brug kun dette værktøj i overensstemmelse med gældende politiker på {{SITENAME}}.',
	'checkuser-desc' => 'Giver brugere med den rette godkendelse muligheden for at checke brugeres IP-adresser og anden information',
	'checkuser-logcase' => 'Logsøgning er case sensitiv (der gøres forskel på store og små bogstaver)',
	'checkuser' => 'Check user',
	'checkuserlog' => 'CheckUser log',
	'group-checkuser' => 'Check users',
	'group-checkuser-member' => 'Check user',
	'grouppage-checkuser' => '{{ns:project}}:Check user',
	'checkuser-reason' => 'Begrundelse:',
	'checkuser-showlog' => "Se'n log",
	'checkuser-query' => 'Søĝ i seneste ændrenger',
	'checkuser-target' => 'Bruger æller IP',
	'checkuser-users' => 'Gæt bruger!',
	'checkuser-edits' => 'Gæt redigærer IPs!',
	'checkuser-ips' => 'Gæt IP!',
	'checkuser-search' => 'Søĝ',
	'checkuser-empty' => 'Loggen indeholder ingen poster.',
	'checkuser-nomatch' => 'Ingen matchende resultater blev fundet.',
	'checkuser-check' => 'Check',
	'checkuser-log-fail' => 'Kunne ikke tilføje log-post',
	'checkuser-nolog' => 'Logfilen blev ikke fundet.',
	'checkuser-blocked' => 'Blokeret',
	'checkuser-too-many' => "For mange resultater, gør CIDR'en smallere. Her er de brugte IP'er (max 5000, sorteret efter adresse):",
	'checkuser-user-nonexistent' => 'Den anførte bruger eksisterer ikke.',
	'checkuser-search-form' => 'Find log-poster hvor $1 er $2',
	'checkuser-search-submit' => 'Søg',
	'checkuser-search-initiator' => 'initiatår',
	'checkuser-search-target' => 'mål',
	'checkuser-log-return' => 'Gå tilbage til hovedformularen for checkbruger',
	'checkuser-log-userips' => "$1 fik IP'er for $2",
	'checkuser-log-ipedits' => '$1 fik redigeringer for $2',
	'checkuser-log-ipusers' => '$1 fik brugere for $2',
	'checkuser-log-ipedits-xff' => '$1 fik redigeringer for XFF $2',
	'checkuser-log-ipusers-xff' => '$1 fik brugere for XFF $2',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'checkuser-summary' => 'Piranti iki nlusuri owah-owahan pungkasan kanggo golèk IP sing dienggo déning sawijining panganggo utawa nuduhaké data suntingan/panganggo kanggo sawijining IP.
Panganggo lan suntingan bisa dirunut saka sawijining IP XFF mawa nambahaké "/xff" ing sawijining IP. IPv4 (CIDR 16-32) IPv6 (CIDR 64-128) bisa dienggo.
Amerga déning alesan kinerja, ora luwih saka 5.000 suntingan sing bisa dijupuk. Mangga gunakna piranti iki miturut kawicaksanan sing wis ditetepaké.',
	'checkuser-desc' => 'Mènèhi panganggo fasilitas kanggo panganggo sing duwé idin kanggo mriksa alamat IP panganggo lan informasi liyané',
	'checkuser-logcase' => 'Log iki sènsitif marang panrapan aksara gedhé apa cilik',
	'checkuser' => 'Pamriksan panganggo',
	'checkuserlog' => 'Log pamriksan panganggo',
	'group-checkuser' => 'Pamriksa panganggo',
	'group-checkuser-member' => 'Pamriksa panganggo',
	'right-checkuser' => 'Priksa alamat-alamat IP panganggo lan informasi liyané',
	'right-checkuser-log' => 'Pirsani log pamriksa',
	'grouppage-checkuser' => '{{ns:project}}:Pamriksa panganggo',
	'checkuser-reason' => 'Alesan:',
	'checkuser-showlog' => 'Tuduhna log',
	'checkuser-query' => 'Pitakonan owah-owahan pungkasan',
	'checkuser-target' => 'Panganggo utawa IP',
	'checkuser-users' => 'Golèk panganggo',
	'checkuser-edits' => 'Golèk suntingan saka IP',
	'checkuser-ips' => 'Golèk IP',
	'checkuser-search' => 'Golèk',
	'checkuser-period' => 'Jangka wektu:',
	'checkuser-week-1' => 'minggu kapungkur',
	'checkuser-week-2' => 'rong minggu kapungkur',
	'checkuser-month' => '30 dina pungkasan',
	'checkuser-all' => 'kabèh',
	'checkuser-empty' => 'Log iki kosong.',
	'checkuser-nomatch' => 'Ora ana data sing cocog bisa ditemokaké.',
	'checkuser-nomatch-edits' => 'Ora ana sing cocog.
Suntingan pungkasan ing $2, $1.',
	'checkuser-check' => 'Priksa',
	'checkuser-log-fail' => 'Log èntri ora bisa ditambahaké',
	'checkuser-nolog' => 'Ora ditemokaké berkas log.',
	'checkuser-blocked' => 'Diblokir',
	'checkuser-gblocked' => 'Diblokir sacara global',
	'checkuser-locked' => 'Dikunci',
	'checkuser-wasblocked' => 'Wis diblokir sadurungé',
	'checkuser-massblock' => 'Blokir panganggo kapilih',
	'checkuser-massblock-text' => 'Akun-akun kapilih bakal diblokir salawasé, alamat-alamat IP pungkasan sing dipigunakaké otomatis diblokir lan ora bisa gawé akun.
Alamat-alamat IP bakal diblokir jroning 1 minggu tumrap panganggo anonim lan ora bisa gawé akun.',
	'checkuser-blocktag' => 'Ganti kaca panganggo dadi:',
	'checkuser-blocktag-talk' => 'Ganti kaca wicara nganggo:',
	'checkuser-massblock-commit' => 'Blokir panganggo kapilih',
	'checkuser-block-success' => "'''{{PLURAL:$2|Panganggo|panganggo}} $1 {{PLURAL:$2|wis|wis}} diblokir.'''",
	'checkuser-block-failure' => "'''Ora ana panganggo sing diblokir.'''",
	'checkuser-block-limit' => 'Cacahing panganggo sing dipilih kakèhan.',
	'checkuser-block-noreason' => 'Panjenengan kudu mènèhi alesan pamblokiran',
	'checkuser-accounts' => '$1 {{PLURAL:$1|akun|akun-akun}} anyar',
	'checkuser-too-many' => 'Kakèhan pituwas (miturut estimasi piakonan), tulung CIDR diciyutaké.
Ing ngisor iki kapacak alamat-alamat IP sing dianggo (maks. 5.000, diurutaké miturut alamat):',
	'checkuser-user-nonexistent' => 'Panganggo iki ora ana.',
	'checkuser-search-form' => 'Temokna cathetan log ing ngendi $1 iku $2',
	'checkuser-search-submit' => 'Golèk',
	'checkuser-search-initiator' => 'pamriksa',
	'checkuser-search-target' => 'tujuan',
	'checkuser-ipeditcount' => '~$1 saka kabèh panganggo',
	'checkuser-log-return' => 'Bali menyang kaca utama pamriksa',
	'checkuser-limited' => "'''Kasil iki wis dicekak amarga alesan kinerja.'''",
	'checkuser-log-userips' => '$1 ndeleng IP saka $2',
	'checkuser-log-ipedits' => '$1 ndeleng suntingan saka $2',
	'checkuser-log-ipusers' => '$1 ndeleng jeneng panganggo saka $2',
	'checkuser-log-ipedits-xff' => '$1 ndeleng suntingan saka XFF $2',
	'checkuser-log-ipusers-xff' => '$1 ndeleng jeneng panganggo saka XFF $2',
	'checkuser-log-useredits' => '$1 nduwèni suntingan-suntingan kanggo $2',
	'checkuser-autocreate-action' => 'digawé sacara otomatis',
	'checkuser-email-action' => 'Wis ngirim layang-e menyang panganggo "$1"',
	'checkuser-reset-action' => 'Sèt ulang tembung sandi panganggo "$1"',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author Dawid Deutschland
 * @author Malafaya
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'checkuser-desc' => 'ეძლევა შესაძლებლობა შეამოწმოს  IP და მომხმარებლების დამატებითი ინფორმაცია',
	'checkuser' => 'მომხმარებლის შემოწმება',
	'checkuserlog' => 'შემოწმებული მომხმარებელთა ჟურნალი',
	'checkuser-contribs' => 'შეამოწმეთ მომხმარებლის IP მისამართები',
	'group-checkuser' => 'ჩეკიუზერები',
	'group-checkuser-member' => 'მომხმარებლის შემოწმება',
	'right-checkuser' => 'მომხმარებლების IP მისამართებისა და სხვა ინფორმაციების შემოწმება',
	'right-checkuser-log' => 'მომხმარებლთა შემოწმების ჟურნალის ხილვა',
	'grouppage-checkuser' => '{{ns:project}}:მომხმარებლის შემოწმება',
	'checkuser-reason' => 'მიზეზი:',
	'checkuser-showlog' => 'ჟურნალის ჩვენება',
	'checkuser-query' => 'ბოლო ცვლილებების მოთხოვნა',
	'checkuser-target' => 'IP მისამართი ან მომხმარებლის სახელი:',
	'checkuser-users' => 'მომხმარებლების ნახვა',
	'checkuser-edits' => 'რედაქტირებების მიღება',
	'checkuser-ips' => 'მოითხოვეთ IP',
	'checkuser-search' => 'ძიება',
	'checkuser-period' => 'ხანგძლივობა:',
	'checkuser-week-1' => 'გასულ კვირას',
	'checkuser-week-2' => 'ბოლო ორ კვირას',
	'checkuser-month' => 'უკანასკნელი 30 დღის მანძილზე',
	'checkuser-all' => 'ყველა',
	'checkuser-cidr-label' => 'იპოვეთ საერთო დიაპაზონი IP-სთვის',
	'checkuser-cidr-res' => 'საერთო  CIDR:',
	'checkuser-empty' => 'ჟურნალი ცარიელია.',
	'checkuser-nomatch' => 'დამთხვევა ვერ მოიძებნა.',
	'checkuser-nomatch-edits' => 'დამთხვევა ვერ მოიძებნა.
ბოლო ცვლილება მოხდა $1-ზე $2-ზე.',
	'checkuser-check' => 'შემოწმება',
	'checkuser-log-fail' => 'ჟურნალის ჩანაწერის დამატება შეუძლებელია',
	'checkuser-nolog' => 'ჟურნალის ფაილი ვერ მოიძებნა.',
	'checkuser-blocked' => 'დაბლოკილია',
	'checkuser-gblocked' => 'გლობალურად ბლოკირებული',
	'checkuser-locked' => 'დახურვა',
	'checkuser-wasblocked' => 'უწინ დაბლოკილი',
	'checkuser-localonly' => 'არ არის გაერთიანებული',
	'checkuser-massblock' => 'დაბლოკეთ არჩეული მომხმარებლები',
	'checkuser-massblock-text' => 'არჩეული ანგარიშები დაიბლოკება ახალი ანგარიშების ნებართვის შექმნის გარეშე.
IP დაიბლოკება ერთი კვირით.',
	'checkuser-blocktag' => 'ჩაანაცვლეთ მომხმარებლის გვერდები:',
	'checkuser-blocktag-talk' => 'შეცვალეთ მომხმარებლის გვერდები:',
	'checkuser-massblock-commit' => 'დაბლოკეთ არჩეული მომხმარებლები',
	'checkuser-block-success' => "'''ეს {{PLURAL:$2|მომხმარებელი|მომხმარებლები}} $1 {{PLURAL:$2|არის|არიან}} დაბლოკილები.'''",
	'checkuser-block-failure' => "'''არც-ერთი მომხმარებელი არის დაბლოკილი.'''",
	'checkuser-block-limit' => 'არჩეულია ზედმეტად ბევრი მომხმარებელი.',
	'checkuser-block-noreason' => 'თქვენ უნდა მიუთითოთ ბლოკირების მიზეზი.',
	'checkuser-noreason' => 'თქვენ უნდა მიუთითოთ მიზეზი ამ შეკითხვისთვის.',
	'checkuser-accounts' => '$1 ახალი {{PLURAL:$1|ანგარიში|ანგარიშები}}',
	'checkuser-too-many' => 'ძალიან ბევრი რეზულტატი, გთხოვთ შეავიწროოთ CIDR-ი.
გამოყენებული  IP  (მაქსიმუმ 500, სორტირებულია მისამართის თანახმად)',
	'checkuser-user-nonexistent' => 'ეს მომხმარებელი არ არსებობს.',
	'checkuser-search-form' => 'იპოვეთ ჟურნალის ჩანაწერები, სადაც $1 არის $2',
	'checkuser-search-submit' => 'ძიება',
	'checkuser-search-initiator' => 'ინიციატორი',
	'checkuser-search-target' => 'მიზანი',
	'checkuser-ipeditcount' => '~$1 ყველა მომხმარებლისგან',
	'checkuser-log-return' => 'მომხმარებელთა შემოწმების გვერდზე დაბრუნება',
	'checkuser-limited' => "'''რეზულტატები შეიკუმშა სერვერზე დამატებითი დატვირთვის არ შექმნის მიზნით.'''",
	'checkuser-log-userips' => '$1 მიიღო IP  $2-თვის',
	'checkuser-log-ipedits' => '$1 მიიღო რედაქტირებები $2-თვის',
	'checkuser-log-ipusers' => '$1 მიიღო მომხმარებლები $2-თვის',
	'checkuser-log-ipedits-xff' => '$1 მიიღო რედაქტირებები XFF $2-თვის',
	'checkuser-log-ipusers-xff' => '$1 მიიღო მომხმარებლები XFF $2-თვის',
	'checkuser-log-useredits' => '$1 მიიღო რედაქტირებები $2-თვის',
	'checkuser-autocreate-action' => 'ავტომატურად შეიქმნა',
	'checkuser-create-action' => 'შეიქმნა',
	'checkuser-email-action' => 'გაუგზავნა წერილი მომხმარებელ «$1»-ს',
	'checkuser-reset-action' => 'პაროლის შეცვლა მომხმარებლისთვის "$1"',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'checkuser-summary' => 'بۇل قۇرال پايدالانۋشى قولدانعان IP جايلار ٴۇشىن, نەمەسە IP جاي تۇزەتۋ/پايدالانۋشى دەرەكتەرىن كورسەتۋ ٴۇشىن جۋىقتاعى وزگەرىستەردى قاراپ شىعادى.
	پايدالانۋشىلاردى مەن تۇزەتۋلەردى XFF IP ارقىلى IP جايعا «/xff» دەگەندى قوسىپ كەلتىرۋگە بولادى. IPv4 (CIDR 16-32) جانە IPv6 (CIDR 64-128) ارقاۋلانادى.
	ورىنداۋشىلىق سەبەپتەرىمەن 5000 تۇزەتۋدەن ارتىق قايتارىلمايدى. بۇنى ەرەجەلەرگە سايكەس پايدالانىڭىز.',
	'checkuser-logcase' => 'جۋرنالدان ىزدەۋ ٴارىپ باس-كىشىلىگىن ايىرادى.',
	'checkuser' => 'قاتىسۋشىنى سىناۋ',
	'checkuserlog' => 'قاتىسۋشى سىناۋ جۋرنالى',
	'group-checkuser' => 'قاتىسۋشى سىناۋشىلار',
	'group-checkuser-member' => 'قاتىسۋشى سىناۋشى',
	'grouppage-checkuser' => '{{ns:project}}:قاتىسۋشىنى سىناۋ',
	'checkuser-reason' => 'سەبەبى:',
	'checkuser-showlog' => 'جۋرنالدى كورسەت',
	'checkuser-query' => 'جۋىقتاعى وزگەرىستەردى سۇرانىمداۋ',
	'checkuser-target' => 'قاتىسۋشى اتى / IP جاي',
	'checkuser-users' => 'قاتىسۋشىلاردى كەلتىرۋ',
	'checkuser-edits' => 'IP جايدان جاسالعان تۇزەتۋلەردى كەلتىرۋ',
	'checkuser-ips' => 'IP جايلاردى كەلتىرۋ',
	'checkuser-search' => 'ىزدەۋ',
	'checkuser-empty' => 'جۋرنالدا ەش جازبا جوق.',
	'checkuser-nomatch' => 'سايكەس تابىلمادى.',
	'checkuser-check' => 'سىناۋ',
	'checkuser-log-fail' => 'جۋرنالعا جازبا ۇستەلىنبەدى',
	'checkuser-nolog' => 'جۋرنال فايلى تابىلمادى.',
	'checkuser-blocked' => 'بۇعاتتالعان',
	'checkuser-too-many' => 'تىم كوپ ناتىيجە كەلتىرىلدى, CIDR دەگەندى تارىلتىپ كورىڭىز. مىندا پايدالانىلعان IP جايلار كورسەتىلگەن (بارىنشا 5000, جايىمەن سۇرىپتالعان):',
	'checkuser-user-nonexistent' => 'ەنگىزىلگەن قاتىسۋشى جوق.',
	'checkuser-search-form' => 'جۋرنالداعى وقىيعالاردى تابۋ ($1 دەگەن $2 ەكەن جايىنداعى)',
	'checkuser-search-submit' => 'ىزدەۋ',
	'checkuser-search-initiator' => 'باستاماشى',
	'checkuser-search-target' => 'نىسانا',
	'checkuser-log-return' => 'CheckUser باسقى پىشىنىنە  ورالۋ',
	'checkuser-log-userips' => '$2 ٴۇشىن $1 IP جاي الىندى',
	'checkuser-log-ipedits' => '$2 ٴۇشىن $1 تۇزەتۋ الىندى',
	'checkuser-log-ipusers' => '$2 ٴۇشىن $1 IP قاتىسۋشى الىندى',
	'checkuser-log-ipedits-xff' => 'XFF $2 ٴۇشىن $1 تۇزەتۋ الىندى',
	'checkuser-log-ipusers-xff' => 'XFF $2 ٴۇشىن $1 قاتىسۋشى الىندى',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬) */
$messages['kk-cyrl'] = array(
	'checkuser-summary' => 'Бұл құрал пайдаланушы қолданған IP жайлар үшін, немесе IP жай түзету/пайдаланушы деректерін көрсету үшін жуықтағы өзгерістерді қарап шығады.
	Пайдаланушыларды мен түзетулерді XFF IP арқылы IP жайға «/xff» дегенді қосып келтіруге болады. IPv4 (CIDR 16-32) және IPv6 (CIDR 64-128) арқауланады.
	Орындаушылық себептерімен 5000 түзетуден артық қайтарылмайды. Бұны ережелерге сәйкес пайдаланыңыз.',
	'checkuser-logcase' => 'Журналдан іздеу әріп бас-кішілігін айырады.',
	'checkuser' => 'Қатысушыны сынау',
	'checkuserlog' => 'Қатысушы сынау журналы',
	'group-checkuser' => 'Қатысушы сынаушылар',
	'group-checkuser-member' => 'қатысушы сынаушы',
	'grouppage-checkuser' => '{{ns:project}}:Қатысушыны сынау',
	'checkuser-reason' => 'Себебі:',
	'checkuser-showlog' => 'Журналды көрсет',
	'checkuser-query' => 'Жуықтағы өзгерістерді сұранымдау',
	'checkuser-target' => 'Қатысушы аты / IP жай',
	'checkuser-users' => 'Қатысушыларды келтіру',
	'checkuser-edits' => 'IP жайдан жасалған түзетулерді келтіру',
	'checkuser-ips' => 'IP жайларды келтіру',
	'checkuser-search' => 'Іздеу',
	'checkuser-empty' => 'Журналда еш жазба жоқ.',
	'checkuser-nomatch' => 'Сәйкес табылмады.',
	'checkuser-check' => 'Сынау',
	'checkuser-log-fail' => 'Журналға жазба үстелінбеді',
	'checkuser-nolog' => 'Журнал файлы табылмады.',
	'checkuser-blocked' => 'Бұғатталған',
	'checkuser-too-many' => 'Тым көп нәтиже келтірілді, CIDR дегенді тарылтып көріңіз. Мында пайдаланылған IP жайлар көрсетілген (барынша 5000, жайымен сұрыпталған):',
	'checkuser-user-nonexistent' => 'Енгізілген қатысушы жоқ.',
	'checkuser-search-form' => 'Журналдағы оқиғаларды табу ($1 деген $2 екен жайындағы)',
	'checkuser-search-submit' => 'Іздеу',
	'checkuser-search-initiator' => 'бастамашы',
	'checkuser-search-target' => 'нысана',
	'checkuser-log-return' => 'CheckUser басқы пішініне  оралу',
	'checkuser-log-userips' => '$2 үшін $1 IP жай алынды',
	'checkuser-log-ipedits' => '$2 үшін $1 түзету алынды',
	'checkuser-log-ipusers' => '$2 үшін $1 IP қатысушы алынды',
	'checkuser-log-ipedits-xff' => 'XFF $2 үшін $1 түзету алынды',
	'checkuser-log-ipusers-xff' => 'XFF $2 үшін $1 қатысушы алынды',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬) */
$messages['kk-latn'] = array(
	'checkuser-summary' => 'Bul qural paýdalanwşı qoldanğan IP jaýlar üşin, nemese IP jaý tüzetw/paýdalanwşı derekterin körsetw üşin jwıqtağı özgeristerdi qarap şığadı.
	Paýdalanwşılardı men tüzetwlerdi XFF IP arqılı IP jaýğa «/xff» degendi qosıp keltirwge boladı. IPv4 (CIDR 16-32) jäne IPv6 (CIDR 64-128) arqawlanadı.
	Orındawşılıq sebepterimen 5000 tüzetwden artıq qaýtarılmaýdı. Bunı erejelerge säýkes paýdalanıñız.',
	'checkuser-logcase' => 'Jwrnaldan izdew ärip bas-kişiligin aýıradı.',
	'checkuser' => 'Qatıswşını sınaw',
	'checkuserlog' => 'Qatıswşı sınaw jwrnalı',
	'group-checkuser' => 'Qatıswşı sınawşılar',
	'group-checkuser-member' => 'qatıswşı sınawşı',
	'grouppage-checkuser' => '{{ns:project}}:Qatıswşını sınaw',
	'checkuser-reason' => 'Sebebi:',
	'checkuser-showlog' => 'Jwrnaldı körset',
	'checkuser-query' => 'Jwıqtağı özgeristerdi suranımdaw',
	'checkuser-target' => 'Qatıswşı atı / IP jaý',
	'checkuser-users' => 'Qatıswşılardı keltirw',
	'checkuser-edits' => 'IP jaýdan jasalğan tüzetwlerdi keltirw',
	'checkuser-ips' => 'IP jaýlardı keltirw',
	'checkuser-search' => 'İzdew',
	'checkuser-empty' => 'Jwrnalda eş jazba joq.',
	'checkuser-nomatch' => 'Säýkes tabılmadı.',
	'checkuser-check' => 'Sınaw',
	'checkuser-log-fail' => 'Jwrnalğa jazba üstelinbedi',
	'checkuser-nolog' => 'Jwrnal faýlı tabılmadı.',
	'checkuser-blocked' => 'Buğattalğan',
	'checkuser-too-many' => 'Tım köp nätïje keltirildi, CIDR degendi tarıltıp köriñiz. Mında paýdalanılğan IP jaýlar körsetilgen (barınşa 5000, jaýımen surıptalğan):',
	'checkuser-user-nonexistent' => 'Engizilgen qatıswşı joq.',
	'checkuser-search-form' => 'Jwrnaldağı oqïğalardı tabw ($1 degen $2 eken jaýındağı)',
	'checkuser-search-submit' => 'İzdew',
	'checkuser-search-initiator' => 'bastamaşı',
	'checkuser-search-target' => 'nısana',
	'checkuser-log-return' => 'CheckUser basqı pişinine  oralw',
	'checkuser-log-userips' => '$2 üşin $1 IP jaý alındı',
	'checkuser-log-ipedits' => '$2 üşin $1 tüzetw alındı',
	'checkuser-log-ipusers' => '$2 üşin $1 IP qatıswşı alındı',
	'checkuser-log-ipedits-xff' => 'XFF $2 üşin $1 tüzetw alındı',
	'checkuser-log-ipusers-xff' => 'XFF $2 üşin $1 qatıswşı alındı',
);

/** Kalaallisut (Kalaallisut)
 * @author Qaqqalik
 */
$messages['kl'] = array(
	'checkuser-search' => 'Ujarlerit',
	'checkuser-search-submit' => 'Ujarlerit',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'checkuser-desc' => 'ផ្ដល់ឱ្យអ្នកប្រើប្រាស់​នូវការអនុញ្ញាតសមគួរដើម្បី​ទទួលបាននូវ​សមត្ថភាព​ក្នុងការត្រួតពិនិត្យអាសយដ្ឋាន IP របស់អ្នកប្រើប្រាស់និង​ព័ត៌មានផ្សេងៗទៀត',
	'checkuser-logcase' => 'ការស្វែងរកកំណត់ហេតុដោយបែងចែកអក្សរធំ អក្សរតូច។',
	'checkuser' => 'ត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'checkuserlog' => 'កំណត់ហេតុនៃការត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'checkuser-contribs' => 'ត្រួតពិនិត្យ ​IP របស់​អ្នកប្រើប្រាស់',
	'group-checkuser' => 'អ្នកត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'group-checkuser-member' => '{{GENDER:$1|អ្នកត្រួតពិនិត្យអ្នកប្រើប្រាស់}}',
	'right-checkuser' => 'អាសយដ្ឋានIPនិងព័ត៌មានដ៏ទៃទៀតនៃការត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'right-checkuser-log' => 'មើលកំណត់ហេតុនៃការត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'grouppage-checkuser' => '{{ns:project}}:អ្នកត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'checkuser-reason' => 'មូលហេតុ៖',
	'checkuser-reason-api' => 'API៖ $1',
	'checkuser-showlog' => 'បង្ហាញកំណត់ហេតុ',
	'checkuser-query' => 'សំណើសុំបំលាស់ប្ដូរថ្មីៗ',
	'checkuser-target' => 'អាសយដ្ឋានIP ឬ អត្តនាម៖',
	'checkuser-users' => 'ទទួលអ្នកប្រើប្រាស់',
	'checkuser-edits' => 'ទទួលកំណែប្រែ',
	'checkuser-ips' => 'ទទួលIP',
	'checkuser-search' => 'ស្វែងរក',
	'checkuser-period' => 'រយៈពេល៖',
	'checkuser-week-1' => 'សប្តាហ៍មុន',
	'checkuser-week-2' => '២សប្តាហ៍មុន',
	'checkuser-month' => '៣០ថ្ងៃមុន',
	'checkuser-all' => 'ទាំងអស់',
	'checkuser-cidr-res' => 'CIDR ធម្មតា៖',
	'checkuser-empty' => 'មិនមានអ្វីនៅក្នុងកំណត់ហេតុនេះទេ។',
	'checkuser-nomatch' => 'មិន​មាន​ការគូ​ផ្គង​ដូច​គ្នា​ត្រូវ​បាន​រក​ឃើញ​ទេ។',
	'checkuser-check' => 'ត្រួតពិនិត្យ',
	'checkuser-nolog' => 'ឯកសារកំណត់ហេតុមិនត្រូវបានរកឃើញទេ។',
	'checkuser-blocked' => 'បានហាមឃាត់',
	'checkuser-gblocked' => 'ត្រូវបានរាំងខ្ទប់ជាសាកល',
	'checkuser-locked' => 'បានចាក់សោ',
	'checkuser-wasblocked' => 'ត្រូវបានរាំងខ្ទប់មុននេះ',
	'checkuser-massblock' => 'រាំងខ្ទប់អ្នកប្រើប្រាស់ដែលត្រូវបានជ្រើសរើស',
	'checkuser-blocktag' => 'ជំនួសទំព័រអ្នកប្រើប្រាស់ដោយ៖',
	'checkuser-blocktag-talk' => 'ជំនួស​ទំព័រពិភាក្សា​ជាមួយ​៖',
	'checkuser-massblock-commit' => 'រាំងខ្ទប់អ្នកប្រើប្រាស់ដែលត្រូវបានជ្រើសរើស',
	'checkuser-block-success' => "'''{{PLURAL:$2|អ្នកប្រើប្រាស់|អ្នកប្រើប្រាស់}} $1 {{PLURAL:$2|ត្រូវ|ត្រូវ}}បានរាំងខ្ទប់ហើយ។'''",
	'checkuser-block-failure' => "'''គ្មានអ្នកប្រើប្រាស់ណាម្នាក់ត្រូវបានរាំងខ្ទប់ទេ។'''",
	'checkuser-block-limit' => 'មានអ្នកប្រើប្រាស់ច្រើនពេកហើយត្រូវបានជ្រើសរើស។',
	'checkuser-block-noreason' => 'អ្នកត្រូវតែផ្ដល់មូលហេតុសម្រាប់ការរាំងខ្ទប់។',
	'checkuser-noreason' => 'អ្នកត្រូវតែផ្ដល់មូលហេតុសំរាប់សំណើសុំនេះ។',
	'checkuser-accounts' => 'គណនីថ្មីចំនួន $1',
	'checkuser-too-many' => 'លទ្ធផល​ច្រើនពេក (ផ្អែកតាមការប៉ាន់ស្មាន)។ សូមបង្រួម CIDR ។
នេះគឺ IP ដែលបានប្រើប្រាស់ (អតិបរមា ៥០០០, រៀបតាម​អាសយដ្ឋាន)​៖',
	'checkuser-user-nonexistent' => 'មិនមានអ្នកប្រើប្រាស់ដូចដែលបានបញ្ជាក់ទេ។',
	'checkuser-search-form' => 'ស្វែងរកការបញ្ចូលកំណត់ហេតុដែល $1 គឺជា $2',
	'checkuser-search-submit' => 'ស្វែងរក',
	'checkuser-search-initiator' => 'អ្នកផ្ដួចផ្ដើម',
	'checkuser-search-target' => 'គោលដៅ',
	'checkuser-ipeditcount' => '~$1 ពីគ្រប់អ្នកប្រើប្រាស់ទាំងអស់',
	'checkuser-log-return' => 'ត្រឡប់ទៅកាន់បែបបទដើមនៃការត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'checkuser-log-userips' => '$1បានទទួល IPs ដែល$2បានប្រើប្រាស់',
	'checkuser-log-ipedits' => '$1បានទទួលចំនួនកំណែប្រែពី$2',
	'checkuser-log-ipedits-xff' => '$1 បានទទួលកំណែប្រែពី XFF $2',
	'checkuser-log-useredits' => '$1 បានទទួលកំណែប្រែពី $2',
	'checkuser-autocreate-action' => 'ត្រូវបានបង្កើតដោយស្វ័យប្រវត្តិ',
	'checkuser-email-action' => 'បានផ្ញើអ៊ីមែលទៅកាន់អ្នកប្រើប្រាស់ "$1"',
	'checkuser-reset-action' => 'កំណត់ឡើងវិញនូវពាក្យសម្ងាត់របស់អ្នកប្រើប្រាស់"$1"',
);

/** Kannada (ಕನ್ನಡ)
 * @author HPNadig
 * @author Nayvik
 */
$messages['kn'] = array(
	'checkuser' => 'ಸದಸ್ಯನನ್ನು ಚೆಕ್ ಮಾಡಿ',
	'checkuser-reason' => 'ಕಾರಣ:',
	'checkuser-search' => 'ಹುಡುಕು',
	'checkuser-all' => 'ಎಲ್ಲಾ',
	'checkuser-search-submit' => 'ಹುಡುಕು',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Ficell
 * @author Klutzy
 * @author Kwj2772
 * @author ToePeu
 */
$messages['ko'] = array(
	'checkuser-summary' => '이 도구는 특정 사용자가 이용한 IP 또는 특정 IP에 대한 편집/사용자 정보를 조사합니다.
클라이언트 IP를 통한 사용자와 편집은 IP 주소 뒤에 "/xff"를 더함으로서 XFF 제공자를 통해 조사할 수 있습니다. IPv4 (CIDR 16-32) 와 IPv6 (CIDR 64-128)을 지원합니다.
성능상의 이유로 최대 5000개의 편집만 보여질 것입니다.
이 도구는 정책에 맞게 사용하십시오.',
	'checkuser-desc' => '사용자의 IP 주소를 포함한 정보를 볼 수 있는 권한을 특정한 사용자에게 준다.',
	'checkuser-logcase' => '이 기록 검색은 대소문자를 구분합니다.',
	'checkuser' => '체크유저',
	'checkuserlog' => '체크유저 기록',
	'checkuser-contribs' => '사용자 IP를 확인',
	'group-checkuser' => '체크유저',
	'group-checkuser-member' => '{{GENDER:$1|체크유저}}',
	'right-checkuser' => '사용자의 IP 주소와 다른 정보를 확인',
	'right-checkuser-log' => '체크유저 기록 보기',
	'action-checkuser' => '사용자의 IP 주소와 다른 정보를 확인할',
	'action-checkuser-log' => '체크유저 기록을 볼',
	'grouppage-checkuser' => '{{ns:project}}:체크유저',
	'checkuser-reason' => '이유:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => '기록 보기',
	'checkuser-query' => '쿼리 최근 바뀜',
	'checkuser-target' => 'IP 주소 또는 계정 이름:',
	'checkuser-users' => '특정 IP를 사용한 사용자 확인',
	'checkuser-edits' => '편집을 확인',
	'checkuser-ips' => 'IP 주소 확인',
	'checkuser-search' => '찾기',
	'checkuser-period' => '기간:',
	'checkuser-week-1' => '지난 1주일',
	'checkuser-week-2' => '지난 2주일',
	'checkuser-month' => '지난 30일',
	'checkuser-all' => '모두',
	'checkuser-cidr-label' => 'IP의 공통 범위와 영향을 받는 주소 목록 찾기',
	'checkuser-cidr-res' => '공통 CIDR:',
	'checkuser-empty' => '기록이 없습니다.',
	'checkuser-nomatch' => '일치하는 결과가 없습니다.',
	'checkuser-nomatch-edits' => '일치하는 결과가 없습니다.
마지막 편집은 $1 $2에 있었습니다.',
	'checkuser-check' => '확인',
	'checkuser-log-fail' => '기록을 남길 수 없습니다',
	'checkuser-nolog' => '로그 파일이 없습니다.',
	'checkuser-blocked' => '차단됨',
	'checkuser-gblocked' => '전체 위키에서 차단됨',
	'checkuser-locked' => '잠김',
	'checkuser-wasblocked' => '이미 차단됨',
	'checkuser-localonly' => '계정이 통합되지 않음',
	'checkuser-massblock' => '선택한 사용자 차단',
	'checkuser-massblock-text' => '선택된 계정은 무기한 (자동 차단 활성화, 계정 생성 금지됨) 차단될 것입니다.
IP 주소는 1주일 (IP만 막음, 계정 생성 금지됨) 차단될 것입니다.',
	'checkuser-blocktag' => '사용자 문서를 다음 내용으로 바꾸기:',
	'checkuser-blocktag-talk' => '토론 문서를 다음 내용으로 바꾸기:',
	'checkuser-massblock-commit' => '선택한 사용자를 차단',
	'checkuser-block-success' => "'''다음 $2명의 사용자 ($1) 가 성공적으로 차단되었습니다.'''",
	'checkuser-block-failure' => "'''차단된 사용자가 없습니다.'''",
	'checkuser-block-limit' => '너무 많은 사용자를 선택하였습니다.',
	'checkuser-block-noreason' => '차단하는 이유를 반드시 입력해야 합니다.',
	'checkuser-noreason' => '이 명령에 대한 이유를 반드시 제시해야 합니다.',
	'checkuser-accounts' => '$1개의 새 계정',
	'checkuser-too-many' => '쿼리 정보의 결과가 너무 많습니다. CIDR 범위를 좁혀 주세요.
다음은 사용되고 있는 IP의 목록입니다 (최대 5000개, 주소별로 정렬됨):',
	'checkuser-user-nonexistent' => '해당 사용자가 존재하지 않습니다.',
	'checkuser-search-form' => '$1이 $2인 기록 찾기',
	'checkuser-search-submit' => '찾기',
	'checkuser-search-initiator' => '체크유저',
	'checkuser-search-target' => '대상',
	'checkuser-ipeditcount' => '모든 사용자로부터 $1개의 편집',
	'checkuser-log-return' => '체크유저 양식으로 돌아가기',
	'checkuser-limited' => "'''성능상의 이유로 결과 중 일부만 보여줍니다.'''",
	'checkuser-log-userips' => '$1 사용자는 $2 사용자가 사용한 IP 주소를 열람했습니다.',
	'checkuser-log-ipedits' => '$1 사용자는 $2의 편집을 열람했습니다.',
	'checkuser-log-ipusers' => '$1 사용자가 $2 IP 주소를 사용한 사용자를 확인하였습니다.',
	'checkuser-log-ipedits-xff' => '$1 사용자가 XFF $2 IP 주소에서의 편집을 열람하였습니다.',
	'checkuser-log-ipusers-xff' => '$1 사용자가 XFF $2 IP 주소를 사용한 사용자의 목록을 열람하였습니다.',
	'checkuser-log-useredits' => '$1 사용자가 $2 사용자의 편집을 열람하였습니다.',
	'checkuser-autocreate-action' => '계정이 자동으로 생성되었습니다.',
	'checkuser-create-action' => '생성되었습니다',
	'checkuser-email-action' => '"$1" 사용자에게 이메일을 보냄',
	'checkuser-reset-action' => '"$1" 사용자의 암호를 변경함',
);

/** Karachay-Balkar (Къарачай-Малкъар)
 * @author Iltever
 */
$messages['krc'] = array(
	'group-checkuser' => 'Къошулуучуланы тинтиучюле',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'checkuser-search' => 'Luk foh am',
	'checkuser-search-submit' => 'Luk foh am',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'checkuser-search' => 'Sagap',
	'checkuser-search-submit' => 'Sagap',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'checkuser-summary' => 'Met däm Werkzüch he kam_mer de <i en="en">IP </i>-Addresse fun Metmaacher fenge, di en de {{int:Recentchanges}} shtonn, un mer kann de Metmaacher-Date un Änderonge fenge för en <i lang="en">IP</i>-Adress.

Metmaacher un ier Änderong för an <i lang="en">IP</i>-Address wäde övver <i lang="en">XFF-header</i> jezeich, wam_mer aan di <i lang="en">IP</i>-Address en „<code>/xff</code>“ aanhängk. Dobei wäde <i lang="en">IPv4 (CIDR 16-32)</i> un <i lang="en">IPv6 (CIDR 64-128)</i> ongershtöz. Leßte jon beß 5000 Änderonge, öm der ẞööver nit zo doll ze beschäfteje.

Donn op de Räjelle för dat Werrkzeuch obach jevve, un et nit bruche, wann De nit darrefs!',
	'checkuser-desc' => 'Metmaacher met däm Rääsch dozoh könne de IP-Adresse un annder Date fun de Metmaacher pröfe.',
	'checkuser-logcase' => 'Dat Söke em Logboch deit zwesche jruße un kleine Bochshtave ongerscheide.',
	'checkuser' => 'Metmaacher Pröfe',
	'checkuserlog' => 'Logboch fum Metmaacher-Pröfe',
	'checkuser-contribs' => 'Metmaacher ier <code lang="en">IP-</code>Addresse pröfe',
	'group-checkuser' => 'Metmaacher-Pröfer',
	'group-checkuser-member' => '{{GENDER:$1|Metmaacher-Pröfer}}',
	'right-checkuser' => 'IP-Adresse un ier Bezösch zo de aanjemeldte Metmaacher övverpröfe, un Metmacher ier Date aanlore',
	'right-checkuser-log' => 'En et Logboch lohre, fum Övverpröfe fun IP-Adresse un ier Bezösch zo de aanjemeldte Metmaacher, uew.',
	'grouppage-checkuser' => '{{ns:project}}:Metmaacher-Pröfer',
	'checkuser-reason' => 'Aanlass:',
	'checkuser-reason-api' => '<i lang="en">AP</i>I: $1',
	'checkuser-showlog' => 'et Logboch aanzeije',
	'checkuser-query' => 'En de {{LCFIRST:{{int:recentchanges}}}} frore',
	'checkuser-target' => '<code lang="en">IP</code>-Addräß udder Metmaacher-Name:',
	'checkuser-users' => 'Metmaacher holle!',
	'checkuser-edits' => 'Änderonge holle!',
	'checkuser-ips' => 'IP-Addresse holle!',
	'checkuser-search' => 'Söhke',
	'checkuser-period' => 'Dor:',
	'checkuser-week-1' => 'letz Woch',
	'checkuser-week-2' => 'de letzte zwei Woche',
	'checkuser-month' => 'de letz drißich Daach',
	'checkuser-all' => 'all',
	'checkuser-cidr-label' => 'Fengk der jemeinsame Berett, un de betroffe Addresse, för en Leß vun IP-Addresse',
	'checkuser-cidr-res' => 'Dä jemeinsame <i lang="en">CIDR</i>:',
	'checkuser-empty' => 'En däm Logboch shteit nix dren.',
	'checkuser-nomatch' => 'Nix zopaß jefonge.',
	'checkuser-nomatch-edits' => 'Keine Treffer jefonge. De letzte Änderung wohr aam $1 öm $2 Uhr.',
	'checkuser-check' => 'Pröfe!',
	'checkuser-log-fail' => 'Kann nix em Logboch dobei schriive',
	'checkuser-nolog' => 'Kein Logboch jefonge.',
	'checkuser-blocked' => 'jesperrt',
	'checkuser-gblocked' => 'En alle Wikis jesperrt',
	'checkuser-locked' => 'Zohjemaat un afjeschloße',
	'checkuser-wasblocked' => 'Fröjer jesperrt',
	'checkuser-localonly' => 'Nit zusamme jelaat',
	'checkuser-massblock' => 'Don de usjesoohte Metmaacher sperre',
	'checkuser-massblock-text' => 'De ußjesoohte Metmaacher wäde för iewich jesperrt, met automattesch
wigger sperre ennjeschalldt un et Metmaacher-Neu-Aanlääje es verbodde.
De namelose Metmaacher un ier IP-Adresse wäde för en Woch jesperrt — enlogge fun do es ävver wigger müjjelesch — un et Metmaacher-Neu-Aanlääje
es doh och verbodde.',
	'checkuser-blocktag' => 'Der Metmaacher ier Sigge iere Ennhalt ußtuusche jäje:',
	'checkuser-blocktag-talk' => 'Donn de Klaafsigge övverschriive met:',
	'checkuser-massblock-commit' => 'Ußjesoohte Metmaacher sperre',
	'checkuser-block-success' => "'''{{PLURAL:$2|Dä|De|Keine}} Metmaacher $1 {{PLURAL:$2|es|sin|is}} jetz jesperrt.'''",
	'checkuser-block-failure' => "'''Keine Metmaacher jesperrt.'''",
	'checkuser-block-limit' => 'Zoo fill Metmaacher ußjesoht.',
	'checkuser-block-noreason' => 'Do moß ävver ene Jrund för et Sperre aanjevve.',
	'checkuser-noreason' => 'Do moß ene Jrond för hee di Froch aanjävve.',
	'checkuser-accounts' => '{{PLURAL:$1|Eine|$1|Keine}} neue Metmaacher',
	'checkuser-too-many' => 'Zoo fill jefonge, pä Övverschlaach. Beß esu joot un maach dä CIDR kleijner.
Hee sin de eetßte 5000 IP-Addresse, zoteeet:',
	'checkuser-user-nonexistent' => 'Dä Metmaacher jidd_et ja nit.',
	'checkuser-search-form' => 'Sök noh Enndräsch em Logboch, woh $1 $2 es.',
	'checkuser-search-submit' => 'Söök!',
	'checkuser-search-initiator' => 'Metmaacher-Pröfer',
	'checkuser-search-target' => 'Wat eß jefrooch? (Metmaacher-Name udder IP-Address)',
	'checkuser-ipeditcount' => '~$1 Änderonge fun alle Metmaacher',
	'checkuser-log-return' => 'Zerök zor Sigg „Metmaacher Pröfe“',
	'checkuser-limited' => "'''De Leß es affjeschnedde, öm nit der Server unnüdesch ze belaste.'''",
	'checkuser-log-userips' => '$1 hät IP-Adresse jehollt för $2',
	'checkuser-log-ipedits' => '$1 hät de Änderonge jehollt för $2',
	'checkuser-log-ipusers' => '$1 hät de Metmaacher jehollt för $2',
	'checkuser-log-ipedits-xff' => '$1 hät de Änderonge jehollt för XFF $2',
	'checkuser-log-ipusers-xff' => '$1 hät de Metmaacher jehollt för XFF $2',
	'checkuser-log-useredits' => 'dä Metmmacher „$1“ hät dem Metmaacher „$2“ sing Änderunge aanjeloort',
	'checkuser-autocreate-action' => 'wohd automattesch aanjelaat',
	'checkuser-create-action' => 'wood aanjelaat',
	'checkuser-email-action' => 'en e-mail aan „$1“ jescheck',
	'checkuser-reset-action' => 'Däm Metmaacher „$1“ sing Paßwoot automattesch neu setze',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author Bangin
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'checkuser-reason' => 'Sedem:',
	'checkuser-search' => 'Lêbigere',
	'checkuser-all' => 'hemû',
	'checkuser-search-submit' => 'Lêbigere',
);

/** Latin (Latina)
 * @author SPQRobin
 * @author UV
 */
$messages['la'] = array(
	'checkuser-reason' => 'Causa:',
	'checkuser-search' => 'Quaerere',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'checkuser-summary' => "Dës Fonctioun scannt déi rezent Ännerunge fir d'Ip-Adressen, déi vun engem Benotzer benotzt goufen, ze fannen, repektiv d'Ännerunge pro Benotzer fir eng IP.
Benotzer an Ännerunge vun enger IP-Adress kënnen och iwwer den XFF header gesicht ginn andeems hannert d'IP-Adress \"/xff\" hannendrugehaange gëtt. IPv4 (CIDR 16-32) an IPv6 (CIDR 64-128) ginn ënnerstëtzt.
Net méi wéi 5000 Ännerunge ginn aus Performance-Grënn zréckgeschéckt.
Benotzt dës Fonctioun am Aklang mat den Direktiven.",
	'checkuser-desc' => "Gëtt Benotzer mat den néidege Rechter d'Méiglechkeet d'IP-Adressen esou wéi aner Informatiounen iwwert d'Benotzer z'iwwerpréifen",
	'checkuser-logcase' => "D'Sichen am Logbuch mécht en Ënnerscheed tëschent groussen a klenge Buschtawen.",
	'checkuser' => 'Benotzer-Check',
	'checkuserlog' => 'Lëscht vun de Benotzerkontrollen',
	'checkuser-contribs' => 'De Benotzer hir Ip-Adrssen iwwerpréifen',
	'group-checkuser' => 'Benotzer Kontrolleren',
	'group-checkuser-member' => '{{GENDER:$1|Benotzer Kontroller|Benotzer Kontrollerin}}',
	'right-checkuser' => 'Iwwerpréif de Benotzer hir IP-Adressen an aner Informatiounen',
	'right-checkuser-log' => "D'Lëscht vun den ''checkuser''-Ufroe weisen",
	'action-checkuser' => 'IP-Adressen an aner Informatioune vu Benotzer iwwerpréiwen',
	'action-checkuser-log' => 'Checkuser-Logbuch weisen',
	'grouppage-checkuser' => '{{ns:project}}:Benotzer-Kontroller',
	'checkuser-reason' => 'Grond:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Logbuch weisen',
	'checkuser-query' => 'Rezent Ännerungen offroen',
	'checkuser-target' => 'IP-Adress oder Benotzernumm:',
	'checkuser-users' => 'Benotzer kréien',
	'checkuser-edits' => 'Ännerunge kréien',
	'checkuser-ips' => 'IP-Adresse kréien/weisen',
	'checkuser-search' => 'Sichen',
	'checkuser-period' => 'Zäitraum:',
	'checkuser-week-1' => 'lescht Woch',
	'checkuser-week-2' => 'lescht 2 Wochen',
	'checkuser-month' => 'lescht 30 Deeg',
	'checkuser-all' => 'all',
	'checkuser-cidr-label' => 'Gemeinsamen Adressberäich a betraffen Adressen fir eng Lëscht vun IP-Adresse fannen',
	'checkuser-cidr-res' => 'Gemeinsam CIDR:',
	'checkuser-empty' => 'Dës Lëscht ass eidel.',
	'checkuser-nomatch' => 'Et goufe keng Iwwereneestëmmunge fonnt.',
	'checkuser-nomatch-edits' => 'Et gouf näischt esou fonnt.
Déi lescht Ännerung war de() $1 ëm $2.',
	'checkuser-check' => 'Kontrolléieren',
	'checkuser-log-fail' => "D'Aschreiwung an d'Logbuch konnt net gemaach ginn",
	'checkuser-nolog' => "D'Logbuch gouf net fonnt.",
	'checkuser-blocked' => 'Gespaart',
	'checkuser-gblocked' => 'global gespaart',
	'checkuser-locked' => 'Gespaart',
	'checkuser-wasblocked' => 'Virdru gespaart',
	'checkuser-localonly' => 'Net zesummegeluecht',
	'checkuser-massblock' => 'Ausgewielte Benotzer spären',
	'checkuser-massblock-text' => "Déi erausgesichte Benotzerkonte gi fir eng onbestëmmten Zäit gespaart, Autoblock ass ageschalt an d'Opmaache vu Benotzerkonten ass ausgeschalt., IP-Adresse gifir1 Woch gespaart fir IP Benotzer an d'Opmaache vu Benotzerkonten ass ausgeschalt.",
	'checkuser-blocktag' => 'Benotzersäiten duerch dëst ersetzen:',
	'checkuser-blocktag-talk' => 'Diskussiounssäiten ersetzen duerch:',
	'checkuser-massblock-commit' => 'Ausgewielte Benotzer spären',
	'checkuser-block-success' => "'''{{PLURAL:$2|De Benotzer|D'Benotzer}} $1 {{PLURAL:$2|ass|sinn}} elo gespaart.'''",
	'checkuser-block-failure' => "'''Et si keng Benotzer gespaart.'''",
	'checkuser-block-limit' => 'Zevill Benotzer ugewielt.',
	'checkuser-block-noreason' => "Dir musst e Grond fir d'Spären uginn.",
	'checkuser-noreason' => 'Dir musst e Grond fir dës Ufro uginn.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|neie Benotzerkont|nei Benotzerkonten}}',
	'checkuser-too-many' => 'Zevill Resultater (am Vergäich zu der Schätzung vun der Ufro), gitt w.e.g. méi e klenge Beräich vum CIDR un.
Hei sinn déi benotzten IP-Adressen (max 5000, zortéiert no der Adress):',
	'checkuser-user-nonexistent' => 'De gesichte Benotzer gëtt et net.',
	'checkuser-search-form' => 'An de Lëschten fannen, wou den $1 den $2 ass',
	'checkuser-search-submit' => 'Sichen',
	'checkuser-search-initiator' => 'Initiator',
	'checkuser-search-target' => 'Zil',
	'checkuser-ipeditcount' => '~$1 vun alle Benotzer',
	'checkuser-log-return' => 'Zréck op den Haaptformulaire vun der Benotzerkontroll',
	'checkuser-limited' => "'''Dës Lëscht gouf aus Grënn vun der performance vun de Servere gekierzt.'''",
	'checkuser-log-userips' => '$1 krut IPen fir $2',
	'checkuser-log-ipedits' => '$1 huet Ännerunge kritt fir $2',
	'checkuser-log-ipusers' => '$1 huet Benotzer kritt fir $2',
	'checkuser-log-ipedits-xff' => '$1 krut ännerunge fir XFF $2',
	'checkuser-log-ipusers-xff' => "$1 krut d'Benotzer fir XFF $2",
	'checkuser-log-useredits' => "$1 huet d'Ännerunge fir $2 kritt",
	'checkuser-autocreate-action' => 'gouf automatesch ugeluecht',
	'checkuser-create-action' => 'gouf ugeluecht',
	'checkuser-email-action' => 'dem Benotzer "$1" eng E-Mail geschéckt',
	'checkuser-reset-action' => 'huet d\'Passwuert fir de Benotzer "$1" zréckgesat',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'checkuser-search' => 'Xerca',
	'checkuser-search-submit' => 'Xerca',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 * @author Pahles
 */
$messages['li'] = array(
	'checkuser-summary' => "Dit hölpmiddel bekiek recènte verangeringe óm IP-adresse die 'ne gebroeker haet gebroek te achterhaole of toeantj de bewèrkings- en gebroekersgegaeves veur 'n IP-adres.
Gebroekers en bewèrkinge van 'n IP-adres van 'ne cliënt kinne achterhaoldj waere via XFF-headers door \"/xff\" achter 't IP-adres toe te voege. IPv4 (CIDR 16-32) en IPv6 (CIDR 64-128) waere óngersteundj.
Óm prestatiereej waere neet mieë es 5.000 bewèrkinge getoeantj. Gebroek dit hölpmiddel volges 't vasgesteldje beleid.",
	'checkuser-desc' => 'Läöt geautproseerde gebroekers IP-adresse en angere informatie van gebroekers achterhaole',
	'checkuser-logcase' => "Zeuke in 't logbook is huidlèttergeveulig.",
	'checkuser' => 'Konterleer gebroeker',
	'checkuserlog' => 'Logbook KonterleerGebroeker',
	'checkuser-contribs' => 'Controleer gebroekers-IP',
	'group-checkuser' => 'Gebroekerkonterleerders',
	'group-checkuser-member' => '{{GENDER:$1|Gebroekerkónterläör}}',
	'right-checkuser' => 'IP-adrèsser en anger gegaeves van gebroekers naokieke',
	'right-checkuser-log' => "Biek 't checkuserlog",
	'action-checkuser' => 'IP-adresse en anger gegaeves van gebroekers te betrachte',
	'action-checkuser-log' => "'t checkuser logbook te betrachte",
	'grouppage-checkuser' => '{{ns:project}}:Gebroekerkonterleerder',
	'checkuser-reason' => 'Reeje:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Toean logbook',
	'checkuser-query' => 'Bevraog recènte verangeringe',
	'checkuser-target' => 'IP-adres of gebroekersnaam:',
	'checkuser-users' => 'Vraog gebroekers op',
	'checkuser-edits' => 'Vraog bewirkinge óp',
	'checkuser-ips' => 'Vraof IP-adresse op',
	'checkuser-search' => 'Zeuk',
	'checkuser-period' => 'Doer:',
	'checkuser-week-1' => 'leste waek',
	'checkuser-week-2' => 'leste twee waek',
	'checkuser-month' => 'leste 30 daag',
	'checkuser-all' => 'als',
	'checkuser-cidr-label' => "Zeuk gemeinsjappelikke reeks en getróffe adresse oet 'n IP-adresselies.",
	'checkuser-cidr-res' => 'Gemeine CIDR:',
	'checkuser-empty' => "'t Logbook bevat gein regels.",
	'checkuser-nomatch' => 'Gein euvereinkómste gevónje.',
	'checkuser-nomatch-edits' => 'Nieks gevónje.
De lèste bewèrking woor óp $1 óm $2.',
	'checkuser-check' => 'Conterleer',
	'checkuser-log-fail' => 'Logbookregel toevoege neet meugelik',
	'checkuser-nolog' => 'Gein logbook gevónje.',
	'checkuser-blocked' => 'Geblokkeerdj',
	'checkuser-gblocked' => 'Globaal vas',
	'checkuser-locked' => 'Aafgeslaote',
	'checkuser-wasblocked' => 'Ieëder vas',
	'checkuser-localonly' => 'Neet samegevoog',
	'checkuser-massblock' => 'Geselekteerde gebroekers blokkere',
	'checkuser-massblock-text' => "De geselkteerde gebroekers waere tiedelik geblok mit IP-blokkaasj èn 't neet-aanmake ven gebroekers aan.
IP's waere ein waek geblok veur anoniem gebroekers, mit 't aanmake ven nuuj gebroekers oet.",
	'checkuser-blocktag' => 'Vervang gebroekerspaaazjes door:',
	'checkuser-blocktag-talk' => 'Vervang euverlèkpaazjes door:',
	'checkuser-massblock-commit' => 'Geselekteerde gebroekers blokke',
	'checkuser-block-success' => "'''De {{PLURAL:$2|gebroeker|gebroekers}} $1 {{PLURAL:$1|is|zeen}} geblók.'''",
	'checkuser-block-failure' => "'''Gein gebroekers geblók.'''",
	'checkuser-block-limit' => 'Te väöl gebroekers gevas.',
	'checkuser-block-noreason' => "De mós 'ne rieë ópgaeve veure blokkaazjes.",
	'checkuser-noreason' => "De mós 'ne rieë ópgaeve veure zeukópdrach.",
	'checkuser-accounts' => '$1 {{PLURAL:$1|nuuje gebroeker|nuuj gebroekers}}',
	'checkuser-too-many' => 'Te väöl rezultaote. Maak de IP-reiks kleinder:
Hie zeen de gebroekde IPs (max 5000, op adres gesorteerd):',
	'checkuser-user-nonexistent' => 'De opgegaeve gebroeker besteit neet.',
	'checkuser-search-form' => 'Logbookregels zeuke wo de $1 $2 is',
	'checkuser-search-submit' => 'Zeuk',
	'checkuser-search-initiator' => 'aanvraoger',
	'checkuser-search-target' => 'óngerwèrp',
	'checkuser-ipeditcount' => '~$1 van alle gebroekers',
	'checkuser-log-return' => "Nao 't huidformeleer van KonterleerGebroeker trökgaon",
	'checkuser-limited' => "'''Dees rizzeltaote zeen neet gans óm perstaasjereeje.'''",
	'checkuser-log-userips' => '$1 haet IP-adresse veur $2',
	'checkuser-log-ipedits' => '$1 haet bewèrkinge veur $2',
	'checkuser-log-ipusers' => '$1 haet gebroekers veur $2',
	'checkuser-log-ipedits-xff' => '$1 haet bewèrkinge veur XFF $2',
	'checkuser-log-ipusers-xff' => '$1 haet gebrokers veur XFF $2',
	'checkuser-log-useredits' => '$1 haet bewèrkinger veur $2',
	'checkuser-autocreate-action' => 'is autematisch aangemaak',
	'checkuser-create-action' => 'is aangemaak',
	'checkuser-email-action' => 'haet get pós gestuurdj aan "$1"',
	'checkuser-reset-action' => 'vóng wachwaord veur "$1"',
);

/** Lao (ລາວ) */
$messages['lo'] = array(
	'checkuser' => 'ກວດຜູ້ໃຊ້',
	'checkuserlog' => 'ບັນທຶກການກວດຜູ້ໃຊ້',
	'checkuser-reason' => 'ເຫດຜົນ:',
	'checkuser-showlog' => 'ສະແດງບັນທຶກ',
	'checkuser-target' => 'ຜູ້ໃຊ້ ຫຼື IP',
	'checkuser-edits' => 'ເອົາ ການດັດແກ້ ຈາກ ທີ່ຢູ່ IP',
	'checkuser-ips' => 'ເອົາ ທີ່ຢູ່ IP',
	'checkuser-search' => 'ຊອກຫາ',
	'checkuser-empty' => 'ບໍ່ມີເນື້ອໃນຖືກບັນທຶກ',
	'checkuser-nomatch' => 'ບໍ່ພົບສິ່ງທີ່ຊອກຫາ',
	'checkuser-check' => 'ກວດ',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Homo
 * @author Matasg
 */
$messages['lt'] = array(
	'checkuser' => 'Patikrinkite vartotoją',
	'checkuser-contribs' => 'Patikrinkite vartotojo IP adresus',
	'group-checkuser' => 'Patikrinkite vartotojus',
	'group-checkuser-member' => 'Patikrinkite vartotoją',
	'right-checkuser' => 'Tikrinti naudotojo IP adresus ir kitą informaciją',
	'action-checkuser' => 'patikrinti vartotojo IP adresą ir kita informaciją',
	'checkuser-reason' => 'Priežastis:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Rodyti sąrašą',
	'checkuser-target' => 'Naudotojas arba IP',
	'checkuser-users' => 'Gauti naudotojus',
	'checkuser-edits' => 'Gauti redagavimus iš IP',
	'checkuser-ips' => 'Gauti IP',
	'checkuser-search' => 'Ieškoti',
	'checkuser-period' => 'Trukmė:',
	'checkuser-week-1' => 'Praeitą savaitę',
	'checkuser-week-2' => 'Paskutines dvi savaites',
	'checkuser-month' => 'paskutines 30 dienų',
	'checkuser-all' => 'visi',
	'checkuser-nomatch' => 'Atitikmenų nerasta.',
	'checkuser-check' => 'Tikrinti',
	'checkuser-blocked' => 'Užblokuotas',
	'checkuser-gblocked' => 'Užblokuotas globaliai',
	'checkuser-locked' => 'Užrakintas',
	'checkuser-massblock' => 'Blokuoti pasirinktus naudotojus',
	'checkuser-massblock-commit' => 'Blokuoti pasirinktus naudotojus',
	'checkuser-block-failure' => "'''Nėra užblokuotų vartotijų.'''",
	'checkuser-block-limit' => 'Pasirinkta per daug naudotojų.',
	'checkuser-block-noreason' => 'Jūs turite nurodyti blokavimų priežastį.',
	'checkuser-accounts' => '$1 nauja {{PLURAL:$1|paskyra|paskyros}}',
	'checkuser-too-many' => 'Per daug rezultatų, susiaurinkite CIDR.
Čia pateikiami naudojami IP adresai (daugiausiai 5000, suskirstyti pagal adresus):',
	'checkuser-user-nonexistent' => 'Nurodytas naudotojas neegzistuoja.',
	'checkuser-search-submit' => 'Ieškoti',
	'checkuser-search-target' => 'taikinys',
	'checkuser-ipeditcount' => '~$1 iš visų vartotojų',
	'checkuser-log-userips' => '$1 gavo IP adresų $2',
	'checkuser-autocreate-action' => 'buvo automatiškai sukurtas',
	'checkuser-create-action' => 'buvo sukurta',
	'checkuser-email-action' => 'siųsti el. laišką vartotojui " $1 "',
	'checkuser-reset-action' => 'atstatyti slaptažodį naudotojui "$1"',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'checkuser-all' => 'vyss',
);

/** Latvian (Latviešu)
 * @author Geimeris
 * @author GreenZeb
 * @author Papuass
 * @author Xil
 * @author Yyy
 */
$messages['lv'] = array(
	'checkuser-desc' => 'Atļauj lietotājiem ar attiecīgām pilnvarām pārbaudīt lietotāja IP adresi un citu informāciju.',
	'checkuser' => 'Pārbaudīt lietotāju',
	'checkuser-contribs' => 'pārbaudīt lietotāja IP adreses',
	'group-checkuser' => 'Pārbaudītāji',
	'group-checkuser-member' => 'Pārbaudīt lietotāju',
	'right-checkuser' => 'Pārbaudīt lietotāja IP adreses un citu informāciju',
	'checkuser-reason' => 'Iemesls:',
	'checkuser-showlog' => 'Rādīt reģistru',
	'checkuser-target' => 'IP adrese vai lietotājvārds:',
	'checkuser-users' => 'Iegūt lietotājus',
	'checkuser-edits' => 'Iegūt labojumus',
	'checkuser-ips' => 'Iegūt IP adreses',
	'checkuser-search' => 'Meklēt',
	'checkuser-period' => 'Ilgums:',
	'checkuser-week-1' => 'pēdējā nedēļa',
	'checkuser-week-2' => 'pēdējās divas nedēļas',
	'checkuser-month' => 'pēdējās 30 dienas',
	'checkuser-all' => 'viss',
	'checkuser-check' => 'Pārbaudīt',
	'checkuser-blocked' => 'Bloķēts',
	'checkuser-wasblocked' => 'Iepriekš bloķēts',
	'checkuser-localonly' => 'Nav apvienots',
	'checkuser-massblock' => 'Bloķēt izvēlētos lietotājus',
	'checkuser-blocktag-talk' => 'Aizstāt lietotāja diskusijas lapu ar:',
	'checkuser-massblock-commit' => 'Bloķēt izvēlētos lietotājus.',
	'checkuser-block-failure' => '"\' Neviens lietotājs netika bloķēts." "',
	'checkuser-block-limit' => 'Izvēlēti pārāk daudzi lietotāji.',
	'checkuser-block-noreason' => 'Jums jānorāda bloķēšanas iemesli.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|jauns konts|jauni konti}}',
	'checkuser-search-submit' => 'Meklēt',
	'checkuser-email-action' => 'aizsūtīt ziņu uz lietotāja "$1" e-pastu',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'checkuser-nolog' => 'Tsy nahitana rakitra laogy.',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'checkuser-reason' => 'Амал:',
	'checkuser-search' => 'Кычал',
	'checkuser-all' => 'чыла',
	'checkuser-search-submit' => 'Кычал',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 * @author Misos
 */
$messages['mk'] = array(
	'checkuser-summary' => 'Оваа алатка врши преглед на скорешни промени за да ги добие IP-адресите користени од некој корисник или да ги прикаже податоците за уредувања/корисници за некоја IP-адреса.
Корисниците и уредувањата од клиентска IP-адреса можат да се добијат преку XFF наслови со додавање на „/xff“ на IP-адресата. Поддржани се IPv4 (CIDR 16-32) и IPv6 (CIDR 64-128).
Ќе се прикажат највеќе до 5000 уредувања од функционални причини.
Користете го ова во согласност со правилата.',
	'checkuser-desc' => 'Доделува право за проверка на кориснички IP-адреси и други информации',
	'checkuser-logcase' => 'Пребарувањето на дневникот разликува големи и букви.',
	'checkuser' => 'Провери корисник',
	'checkuserlog' => 'Дневник на проверки',
	'checkuser-contribs' => 'провери IP-адреси на корисникот',
	'group-checkuser' => 'Проверувачи',
	'group-checkuser-member' => '{{GENDER:$1|проверувач на корисници}}',
	'right-checkuser' => 'Проверување на корисничка IP-адреса и други информации',
	'right-checkuser-log' => 'Гледање дневник на проверување на корисник',
	'action-checkuser' => 'проверување на корисничка IP-адреса и други информации',
	'action-checkuser-log' => 'гледање дневник на проверување на корисник',
	'grouppage-checkuser' => '{{ns:project}}:Проверувачи',
	'checkuser-reason' => 'Причина:',
	'checkuser-reason-api' => 'API:',
	'checkuser-showlog' => 'Прикажи дневник',
	'checkuser-query' => 'Побарај скорешни промени',
	'checkuser-target' => 'IP-адреса или корисничко име:',
	'checkuser-users' => 'Види корисници',
	'checkuser-edits' => 'Прикажи уредувања',
	'checkuser-ips' => 'Прикажи IP-адреси',
	'checkuser-search' => 'Пребарај',
	'checkuser-period' => 'Траење:',
	'checkuser-week-1' => 'последна седмица',
	'checkuser-week-2' => 'последни две седмици',
	'checkuser-month' => 'последни 30 дена',
	'checkuser-all' => 'сите',
	'checkuser-cidr-label' => 'Најди заедничка низа и погодени адреси за список на IP-адреси',
	'checkuser-cidr-res' => 'Заеднички CIDR:',
	'checkuser-empty' => 'Дневникот не содржи записи.',
	'checkuser-nomatch' => 'Нема совпаѓања.',
	'checkuser-nomatch-edits' => 'Нема совпаѓања.
Последното уредување се случило на $1 во $2.',
	'checkuser-check' => 'Провери',
	'checkuser-log-fail' => 'Не можам да додадам ставка во дневникот',
	'checkuser-nolog' => 'Дневникот не е пронајден.',
	'checkuser-blocked' => 'Блокиран',
	'checkuser-gblocked' => 'Блокиран глобално',
	'checkuser-locked' => 'Заклучено',
	'checkuser-wasblocked' => 'Претходно блокиран',
	'checkuser-localonly' => 'Необединета',
	'checkuser-massblock' => 'Блокирај ги избраните корисници',
	'checkuser-massblock-text' => 'Избраните сметки ќе бидат трајно блокирани, со овозможено автоблокирање и оневозможено создавање на сметки.
IP-адресите ќе бидат блокирани 1 недела за само за корисници со IP-адреса, и со оневозможено создавање на сметка.',
	'checkuser-blocktag' => 'Замени ги корисничките страници со:',
	'checkuser-blocktag-talk' => 'Замени ги страниците за разговор со:',
	'checkuser-massblock-commit' => 'Блокирај ги избраните корисници',
	'checkuser-block-success' => "'''{{PLURAL:$2|Корисникот|Корисниците}} $1 {{PLURAL:$2|е|се}} {{PLURAL:$2|блокиран|блокирани}}.'''",
	'checkuser-block-failure' => "'''Никој не е блокиран.'''",
	'checkuser-block-limit' => 'Избравте премногу корисници.',
	'checkuser-block-noreason' => 'Мора да наведете причина за блокирањата.',
	'checkuser-noreason' => 'Мора да наведете причина за ова барање.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|нова сметка|нови сметки}}',
	'checkuser-too-many' => 'Премногу резултати (според процената на барањето), истенчете го CIDR.
Еве ги користените IP-адреси (највеќе 5000, сортирани по адреса):',
	'checkuser-user-nonexistent' => 'Наведениот корисник не постои.',
	'checkuser-search-form' => 'Пронајди ставки во дневникот каде $1 е $2',
	'checkuser-search-submit' => 'Пребарај',
	'checkuser-search-initiator' => 'иницијатор',
	'checkuser-search-target' => 'цел',
	'checkuser-ipeditcount' => '~$1 од сите корисници',
	'checkuser-log-return' => 'Назад на главниот образец за проверување корисници',
	'checkuser-limited' => "'''Резултатите се скратени од функционални причини.'''",
	'checkuser-log-userips' => '$1 добил(а) IP-адреси за $2',
	'checkuser-log-ipedits' => '$1 добил(а) уредувања за $2',
	'checkuser-log-ipusers' => '$1 добил(а) корисници за $2',
	'checkuser-log-ipedits-xff' => '$1 добил(а) уредувања за XFF $2',
	'checkuser-log-ipusers-xff' => '$1 добил(а) корисници за XFF $2',
	'checkuser-log-useredits' => '$1 добил(а) уредувања за $2',
	'checkuser-autocreate-action' => 'беше автоматски создадена',
	'checkuser-create-action' => 'е создаден',
	'checkuser-email-action' => 'му испратил(а) е-пошта на корисникот „$1“',
	'checkuser-reset-action' => 'смени лозинка за корисникот „$1“',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'checkuser-summary' => 'ഈ ഉപകരണം സമീപകാലമാറ്റങ്ങൾ പരിശോധിക്കുകയും, ഒരുപയോക്താവ് ഉപയോഗിച്ച ഐ.പി. വിലാസങ്ങൾ ശേഖരിക്കുകയോ അല്ലെങ്കിൽ തിരുത്തലിന്റെ/ഉപയോക്താവിന്റെ വിവരങ്ങൾ പ്രദർശിപ്പിക്കുകയോ ചെയ്യുന്നു.
ഒരു ക്ലയന്റ് ഐ.പി. വിലാസത്തിൽ നിന്നുള്ള ഉപയോക്താക്കളേയും തിരുത്തലുകളേയും കുറിച്ചുള്ള വിവരങ്ങൾ എക്സ്.എഫ്.എഫ്. (XFF) വഴി ശേഖരിക്കാൻ, ഐ.പി. വിലാസത്തിനൊടുവിൽ  "/xff" എന്നു ചേർത്ത് സാധിക്കുന്നതാണ്. IPv4 (CIDR 16-32) ഒപ്പം IPv6 (CIDR 64-128) എന്നിവ പിന്തുണയ്ക്കുന്നു.
പ്രവർത്തനഗുണം പരിപാലിക്കുന്നതിനായി 5000 തിരുത്തലുകളിലധികം ശേഖരിക്കുന്നതല്ല.
ഈ സൗകര്യം നയങ്ങൾക്കനുസരിച്ചു മാത്രം ഉപയോഗിക്കേണ്ടതാകുന്നു.',
	'checkuser-desc' => 'ഉപയോക്താക്കൾ ഉപയോഗിച്ച ഐ.പി. വിലാസവും മറ്റുവിവരങ്ങളും പരിശോധിക്കുവാനുള്ള അവകാശം കൊടുക്കാൻ പ്രാപ്തമാക്കുന്നു',
	'checkuser-logcase' => 'പ്രവർത്തന രേഖകൾക്കു വേണ്ടിയുള്ള തിരച്ചിൽ കേസ് സെൻസിറ്റീവ് ആണ്‌.',
	'checkuser' => 'ചെക്ക് യൂസർ',
	'checkuserlog' => 'ചെക്ക് യൂസർ പ്രവർത്തനരേഖ',
	'checkuser-contribs' => 'ഉപയോക്തൃ ഐ.പി. വിലാസങ്ങൾ പരിശോധിക്കുക',
	'group-checkuser' => 'ചെക്ക് യൂസർമാർ',
	'group-checkuser-member' => '{{GENDER:$1|ഉപയോക്തൃ പരിശോധകൻ|ഉപയോക്തൃ പരിശോധക}}',
	'right-checkuser' => 'ചെക്ക് യൂസറിന്റെ ഐ.പി. വിലാസവും മറ്റു വിവരങ്ങളും',
	'right-checkuser-log' => 'ചെക്ക്‌‌യൂസർ രേഖ കാണുക',
	'action-checkuser' => 'ചെക്ക് യൂസറിന്റെ ഐ.പി. വിലാസവും മറ്റു വിവരങ്ങളും',
	'action-checkuser-log' => 'ചെക്ക്‌‌യൂസർ രേഖ കാണുക',
	'grouppage-checkuser' => '{{ns:project}}:ചെക്ക് യൂസർ',
	'checkuser-reason' => 'കാരണം:',
	'checkuser-reason-api' => 'എ.പി.ഐ.: $1',
	'checkuser-showlog' => 'പ്രവർത്തനരേഖ കാട്ടുക',
	'checkuser-query' => 'സമീപകാല മാറ്റങ്ങൾ എടുക്കുക',
	'checkuser-target' => 'ഐ.പി. വിലാസം അഥവാ ഉപയോക്തൃനാമം:',
	'checkuser-users' => 'ഉപയോക്താക്കളെ കാട്ടുക',
	'checkuser-edits' => 'തിരുത്തലുകൾ കാട്ടുക',
	'checkuser-ips' => 'ഐ.പി.കളെ കാട്ടുക',
	'checkuser-search' => 'തിരയൂ',
	'checkuser-period' => 'കാലയളവ്:',
	'checkuser-week-1' => 'കഴിഞ്ഞ ആഴ്‌‌ച്ച',
	'checkuser-week-2' => 'കഴിഞ്ഞ രണ്ട് ആഴ്ച്ച',
	'checkuser-month' => 'കഴിഞ്ഞ 30 ദിവസം',
	'checkuser-all' => 'എല്ലാം',
	'checkuser-cidr-label' => 'ഐ.പി. വിലാസങ്ങളുടെ പട്ടികയിൽ നിന്നും ബാധകമായ ഐ.പി. വിലാസങ്ങളുടെ സാധാരണ പരിധി കണ്ടെത്തുക',
	'checkuser-cidr-res' => 'സാധാരണ CIDR:',
	'checkuser-empty' => 'പ്രവർത്തനരേഖയിൽ ഇനങ്ങൾ ഒന്നുമില്ല',
	'checkuser-nomatch' => 'ചേർച്ചയുള്ളതൊന്നും കണ്ടില്ല',
	'checkuser-nomatch-edits' => 'ഒത്തുപോകുന്നവ കണ്ടെത്താനായില്ല.
അവസാന തിരുത്തൽ $2 $1-നു ആണ് നടന്നത്.',
	'checkuser-check' => 'പരിശോധിക്കുക',
	'checkuser-log-fail' => 'പ്രവർത്തനരേഖയിൽ ഇനം ചേർക്കുന്നതിനു കഴിഞ്ഞില്ല',
	'checkuser-nolog' => 'പ്രവർത്തനരേഖ പ്രമാണം കണ്ടില്ല.',
	'checkuser-blocked' => 'തടയപ്പെട്ടിരിക്കുന്നു',
	'checkuser-gblocked' => 'ആഗോളമായി തടയപ്പെട്ടിരിക്കുന്നു',
	'checkuser-locked' => 'പൂട്ടിയിരിക്കുന്നു',
	'checkuser-wasblocked' => 'മുമ്പേ തടയപ്പെട്ടിരിക്കുന്നു',
	'checkuser-localonly' => 'സംയോജിതമാക്കപ്പെട്ടിട്ടില്ല',
	'checkuser-massblock' => 'തിരഞ്ഞെടുത്ത ഉപയോക്താക്കളെ തടയുക',
	'checkuser-massblock-text' => 'സ്വയം തടയൽ ബാധകമായും അംഗത്വ സൃഷ്ടി സാധ്യമല്ലാതെയും തിരഞ്ഞെടുത്ത അംഗത്വങ്ങൾ ക്ലിപ്തമല്ലാത്ത കാലത്തേയ്ക്ക് തടഞ്ഞിരിക്കുന്നു.
ഐ.പി. വിലാസങ്ങൾ അംഗത്വ സൃഷ്ടി സാധ്യമല്ലാത്ത വിധത്തിൽ ഐ.പി. ഉപയോക്താക്കളെ ഒരു ആഴ്ചത്തേയ്ക്ക് തടഞ്ഞിരിക്കുന്നു.',
	'checkuser-blocktag' => 'ഉപയോക്തൃതാളുകൾ ഇതുകൊണ്ട് മാറ്റുക:',
	'checkuser-blocktag-talk' => 'സംവാദം താളുകൾ ഇതുകൊണ്ട് മാറ്റുക:',
	'checkuser-massblock-commit' => 'തിരഞ്ഞെടുത്ത ഉപയോക്താക്കളെ തടയുക',
	'checkuser-block-success' => "'''$1  {{PLURAL:$2|ഉപയോക്താവ്|ഉപയോക്താക്കൾ}} ഇപ്പോൾ തടയപ്പെട്ടിരിക്കുന്നു'''",
	'checkuser-block-failure' => "'''ഒരു ഉപയോക്താവും തടയപ്പെട്ടില്ല.'''",
	'checkuser-block-limit' => 'നിരവധി ഉപയോക്താക്കളെ തിരഞ്ഞെടുത്തിരിക്കുന്നു.',
	'checkuser-block-noreason' => 'തടയലിനു ഒരു കാരണം താങ്കൾ നൽകുക.',
	'checkuser-noreason' => 'ഈ ചോദ്യത്തിനു താങ്കൾ നിർബന്ധമായും കാരണം നൽകേണ്ടതാണ്.',
	'checkuser-accounts' => 'പുതിയ {{PLURAL:$1|അംഗത്വം|$1അംഗത്വങ്ങൾ}}',
	'checkuser-too-many' => 'വളരെയധികം ഫലങ്ങൾ (ലഭിച്ച ക്വറി അനുസരിച്ച്). CIDR ചുരുക്കുക.
ഉപയോഗിച്ച IPകൾ താഴെ പ്രദർശിപ്പിച്ചിരിക്കുന്നു (പരമാവധി 5000, വിലാസം അനുസരിച്ച് ക്രമീകരിച്ചത്):',
	'checkuser-user-nonexistent' => 'ഇങ്ങനൊരു ഉപയോക്താവ് വിക്കിയിൽ നിലവിലില്ല.',
	'checkuser-search-form' => '$1, $2 ആയ പ്രവർത്തനരേഖാ ഇനങ്ങൾ കണ്ടെത്തുന്നു',
	'checkuser-search-submit' => 'തിരയൂ',
	'checkuser-search-initiator' => 'മുൻകൈ എടുക്കുന്ന ആൾ',
	'checkuser-search-target' => 'ലക്ഷ്യം',
	'checkuser-ipeditcount' => '~$1എല്ലാ ഉപയോക്താക്കളിൽ നിന്നും',
	'checkuser-log-return' => 'ചെക്ക് യൂസറിന്റെ പ്രധാന ഫോമിലേക്ക് തിരിച്ചു പോവുക',
	'checkuser-limited' => "'''പ്രവർത്തന മികവു സംബന്ധിച്ച പ്രശ്നങ്ങളാൽ ഫലങ്ങൾ വെട്ടിച്ചുരുക്കിയിരിക്കുന്നു.'''",
	'checkuser-log-userips' => '$1നു $2ൽ ഐ.പി.കൾ ഉണ്ട്',
	'checkuser-log-ipedits' => '$1നു $2ൽ തിരുത്തലുകൾ ഉണ്ട്',
	'checkuser-log-ipusers' => '$1നു $2ൽ ഉപയോക്താക്കൾ ഉണ്ട്',
	'checkuser-log-ipedits-xff' => '$1നു XFF $2ൽ തിരുത്തലുകൾ ഉണ്ട്',
	'checkuser-log-ipusers-xff' => '$1നു XFF $2ൽ ഉപയോക്താക്കൾ ഉണ്ട്',
	'checkuser-log-useredits' => '$2 നടത്തിയ തിരുത്തലുകൾ $1 പിടിച്ചിരിക്കുന്നു',
	'checkuser-autocreate-action' => 'സ്വയം സൃഷ്ടിച്ചതാണ്',
	'checkuser-create-action' => 'സൃഷ്ടിച്ചിരിക്കുന്നു',
	'checkuser-email-action' => '"$1" എന്ന ഉപയോക്താവിന് ഇമെയിൽ അയച്ചുകഴിഞ്ഞു',
	'checkuser-reset-action' => '"$1" എന്ന ഉപയോക്താവിന്റെ രഹസ്യവാക്ക് പുനഃക്രമീകരിക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'checkuser' => 'Шалгагч хэрэглэгч',
	'group-checkuser' => 'Шалгагч хэрэглэгчид',
	'group-checkuser-member' => 'Шалгагч хэрэглэгч',
	'grouppage-checkuser' => '{{ns:project}}:Шалгагч хэрэглэгч',
	'checkuser-reason' => 'Шалтгаан:',
	'checkuser-search' => 'Хайх',
	'checkuser-all' => 'бүгдийг',
	'checkuser-blocked' => 'Түгжигдсэн',
	'checkuser-search-submit' => 'Хайх',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'checkuser-summary' => 'हे उपकरण अलीकडील बदलांमधून एखाद्या सदस्याने वापरलेले अंकपत्ते किंवा एखाद्या अंकपत्त्याची संपादने/सदस्य दाखविते.
क्लायंट अंकपत्त्यावरील सदस्य अथवा संपादने पाहण्यासाठी अंकपत्त्यानंतर "/xff" द्यावे लागेल.
IPv4 (CIDR 16-32) आणि IPv6 (CIDR 64-128) वापरता येऊ शकेल.
एका वेळी ५००० पेक्षा जास्त संपादने दाखविली जाणार नाहीत. हे उपकरण पॉलिसीच्या नियमांना धरून वापरावे.',
	'checkuser-desc' => 'सदस्याला इतर सदस्यांचे आंतरजाल अंकपत्ते (आयपी) तपासण्याची तसेच इतर माहिती पाहण्याची परवानगी देतो.',
	'checkuser-logcase' => 'लॉगमधील शोध हा लिपीशी संबंधित (case-sensitive) आहे.',
	'checkuser' => 'सदस्य तपासा',
	'checkuserlog' => 'Checkuse लॉग',
	'group-checkuser' => 'सदस्य तपासा',
	'group-checkuser-member' => 'सदस्य तपासा',
	'right-checkuser' => 'सदस्याचा आयपी अंकपत्ता व इतर माहिती तपासा',
	'grouppage-checkuser' => '{{ns:project}}:सदस्य तपासा',
	'checkuser-reason' => 'कारण:',
	'checkuser-showlog' => 'लॉग दाखवा',
	'checkuser-query' => 'अलीकडील बदल पृच्छा',
	'checkuser-target' => 'सदस्य किंवा अंकपत्ता',
	'checkuser-users' => 'सदस्य शोधा',
	'checkuser-edits' => 'अंकपत्त्याची संपादने मिळवा',
	'checkuser-ips' => 'अंकपत्ते शोधा',
	'checkuser-search' => 'शोधा',
	'checkuser-all' => 'सर्व',
	'checkuser-empty' => 'लॉग मध्ये एकही नोंद नाही',
	'checkuser-nomatch' => 'नोंदी सापडल्या नाहीत',
	'checkuser-check' => 'पडताळा',
	'checkuser-log-fail' => 'लॉगमध्ये नोंद वाढविता आलेली नाही.',
	'checkuser-nolog' => 'लॉग संचिका सापडलेली नाही.',
	'checkuser-blocked' => 'ब्लॉक केलेले आहे',
	'checkuser-locked' => 'कुलुपबंद',
	'checkuser-too-many' => 'खूप निकाल आलेले आहेत, कृपया शोधशब्दांमध्ये योग्य बदल करा. खाली वापरलेल्या अंकपत्त्यांची यादी आहे (जास्तीत जास्त ५०००, अनुक्रमे):',
	'checkuser-user-nonexistent' => 'हे सदस्यनाम अस्तित्त्वात नाही.',
	'checkuser-search-form' => 'अशा नोंदी शोधा जिथे $1 हा $2 आहे.',
	'checkuser-search-submit' => 'शोधा',
	'checkuser-search-initiator' => 'चालक (चालना देणारा)',
	'checkuser-search-target' => 'लक्ष्य',
	'checkuser-ipeditcount' => '~$1 सर्व सदस्यांकडून',
	'checkuser-log-return' => 'CheckUser मुख्य अर्जाकडे परत जा',
	'checkuser-log-userips' => '$1 कडे $2 साठीचे अंकपत्ते आहेत',
	'checkuser-log-ipedits' => '$1 कडे $2 साठीची संपादने आहेत',
	'checkuser-log-ipusers' => '$1 कडे $2 साठीचे सदस्य आहेत',
	'checkuser-log-ipedits-xff' => '$1 कडे XFF $2 साठीची संपादने आहेत',
	'checkuser-log-ipusers-xff' => '$1 कडे XFF $2 साठीचे सदस्य आहेत',
	'checkuser-log-useredits' => '$1 कडे $2 साठीची संपादने आहेत',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 * @author Izzudin
 * @author Kurniasan
 */
$messages['ms'] = array(
	'checkuser-summary' => 'Alat ini mengimbas senarai perubahan terkini untuk mendapatkan senarai IP yang digunakan oleh seseorang pengguna atau memaparkan data sunting/pengguna bagi sesebuah IP. Pengguna dan suntingan oleh sesebuah IP boleh didapatkan melalui pengatas XFF dengan menambah \\"/xff\\" selepas IP tersebut. Kedua-dua format IPv4 (CIDR 16-32) dan IPv6 (CIDR 64-128) disokong. Atas sebab-sebab prestasi, pulangan dihadkan kepada 5000 buah suntingan sahaja. Sila patuhi dasar yang telah ditetapkan.',
	'checkuser-desc' => 'Melantik pengguna dengan keizinan untuk membongkar alamat IP pengguna tertentu berserta maklumat-maklumat sulit lain',
	'checkuser-logcase' => 'Carian log ini sensitif huruf (mengambil kisah kecil besar huruf).',
	'checkuser' => 'Periksa pengguna',
	'checkuserlog' => 'Log pemeriksa',
	'checkuser-contribs' => 'periksa alamat IP pengguna',
	'group-checkuser' => 'Pemeriksa',
	'group-checkuser-member' => '{{GENDER:$1|pemeriksa}}',
	'right-checkuser' => 'Memeriksa alamat IP dan maklumat-maklumat lain bagi pengguna',
	'right-checkuser-log' => 'Melihat log pemeriksa',
	'action-checkuser' => 'memeriksa alamat IP dan maklumat-maklumat lain',
	'action-checkuser-log' => 'melihat log pemeriksa',
	'grouppage-checkuser' => '{{ns:project}}:Pemeriksa',
	'checkuser-reason' => 'Sebab:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Tunjukkan log',
	'checkuser-query' => 'Imbas perubahan terkini',
	'checkuser-target' => 'Alamat IP atau nama pengguna:',
	'checkuser-users' => 'Dapatkan senarai pengguna',
	'checkuser-edits' => 'Dapatkan suntingan',
	'checkuser-ips' => 'Dapatkan senarai IP',
	'checkuser-search' => 'Cari',
	'checkuser-period' => 'Tempoh:',
	'checkuser-week-1' => 'minggu lepas',
	'checkuser-week-2' => 'dua minggu lepas',
	'checkuser-month' => '30 hari lepas',
	'checkuser-all' => 'semua',
	'checkuser-cidr-label' => 'Cari julat biasa dan alamat-alamat terlibat untuk sebuah senarai IP',
	'checkuser-cidr-res' => 'CIDR biasa:',
	'checkuser-empty' => 'Log ini kosong.',
	'checkuser-nomatch' => 'Tiada padanan.',
	'checkuser-nomatch-edits' => 'Tiada padanan. Suntingan terakhir ialah pada $1, $2.',
	'checkuser-check' => 'Periksa',
	'checkuser-log-fail' => 'Daftar log tidak dapat ditambah',
	'checkuser-nolog' => 'Fail log tiada.',
	'checkuser-blocked' => 'Disekat',
	'checkuser-gblocked' => 'Disekat secara sejagat',
	'checkuser-locked' => 'Dikunci',
	'checkuser-wasblocked' => 'Pernah disekat',
	'checkuser-localonly' => 'Tidak digabungkan',
	'checkuser-massblock' => 'Sekat pengguna yang ditanda',
	'checkuser-massblock-text' => 'Akaun-akaun yang dinyatakan akan disekat tanpa had, dengan sekatan automatik diaktifkan dan penciptaan akaun baru dimatikan.
Bagi pengguna tanpa nama, alamat IP-nya akan disekat selama seminggu, dengan penciptaan akaun dimatikan.',
	'checkuser-blocktag' => 'Ganti laman pengguna tersebut dengan:',
	'checkuser-blocktag-talk' => 'Ganti laman perbincangan dengan:',
	'checkuser-massblock-commit' => 'Sekat pengguna yang ditanda',
	'checkuser-block-success' => "'''{{PLURAL:$2|Pengguna tersebut|$1 orang pengguna}} telah disekat.'''",
	'checkuser-block-failure' => "'''Tiada pengguna disekat.'''",
	'checkuser-block-limit' => 'Terlalu banyak pengguna dipilih.',
	'checkuser-block-noreason' => 'Anda hendaklah memberikan sebab sekatan.',
	'checkuser-noreason' => 'Anda hendaklah memberikan sebab bagi pertanyaan ini.',
	'checkuser-accounts' => '$1 akaun baru',
	'checkuser-too-many' => 'Terlalu banyak keputusan (berdasarkan anggaran pertanyaan); sila kecilkan CIDR. Yang berikut ialah senarai IP yang digunakan (had 5000, diisihkan mengikut alamat):',
	'checkuser-user-nonexistent' => 'Pengguna yang dinyatakan tidak wujud.',
	'checkuser-search-form' => 'Cari daftar-daftar log di mana $1 adalah $2',
	'checkuser-search-submit' => 'Cari',
	'checkuser-search-initiator' => 'pengasal',
	'checkuser-search-target' => 'sasaran',
	'checkuser-ipeditcount' => '~$1 daripada semua pengguna',
	'checkuser-log-return' => 'Kembali ke borang utama Pemeriksa',
	'checkuser-limited' => 'Hasil-hasil berikut telah dipendekkan atas sebab-sebab prestasi.',
	'checkuser-log-userips' => '$1 mendapatkan senarai IP bagi $2',
	'checkuser-log-ipedits' => '$1 mendapatkan senarai suntingan bagi $2',
	'checkuser-log-ipusers' => '$1 mendapatkan senarai pengguna bagi $2',
	'checkuser-log-ipedits-xff' => '$1 mendapatkan senarai suntingan bagi XFF $2',
	'checkuser-log-ipusers-xff' => '$1 mendapatkan senarai pengguna bagi XFF $2',
	'checkuser-log-useredits' => '$1 mendapatkan senarai suntingan bagi $2',
	'checkuser-autocreate-action' => 'dicipta secara automatik',
	'checkuser-create-action' => 'telah dicipta',
	'checkuser-email-action' => 'hantar e-mel kepada "$1"',
	'checkuser-reset-action' => 'set semula kata laluan "$1"',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'checkuser' => 'Iċċekkja l-utent',
	'checkuser-contribs' => 'ikkontrolla l-indirizzi IP tal-utent',
	'group-checkuser' => 'Kontrollatur',
	'group-checkuser-member' => 'Kontrollatur',
);

/** Erzya (Эрзянь)
 * @author Amdf
 * @author Botuzhaleny-sodamo
 * @author Tupikovs
 */
$messages['myv'] = array(
	'checkuser-reason' => 'Тувталось:',
	'checkuser-showlog' => 'Невтемс журналонзо',
	'checkuser-target' => 'IP-адресэсь эли совицясь:',
	'checkuser-search' => 'Вешнэмс',
	'checkuser-period' => 'Зярс моли:',
	'checkuser-week-1' => 'меельсе тарго',
	'checkuser-week-2' => 'меельсе кавто таргт',
	'checkuser-month' => 'меельсе 30 чить',
	'checkuser-all' => 'весе',
	'checkuser-blocked' => 'Саймес саезь',
	'checkuser-locked' => 'Сёлгозь',
	'checkuser-search-submit' => 'Вешнэмс',
	'checkuser-search-initiator' => 'ушодксонь теиця',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 * @author Teòtlalili
 */
$messages['nah'] = array(
	'checkuser-reason' => 'Īxtlamatiliztli:',
	'checkuser-search' => 'Motèmòs',
	'checkuser-search-submit' => 'Motèmòs',
);

/** Neapolitan (Nnapulitano) */
$messages['nap'] = array(
	'checkuser-search' => 'Truova',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Finnrind
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'checkuser-summary' => 'Dette verktøyet går gjennom siste endringer for å hente IP-ene som er brukt av en bruker, eller viser redigerings- eller brukerinformasjonen for en IP.

Brukere og redigeringer kan hentes med en XFF-IP ved å legge til «/xff» bak IP-en. IPv4 (CIDR 16-32) og IPv6 (CIDR 64-128) støttes.

Av ytelsesgrunner vises maksimalt 5000 redigeringer. Bruk dette verktøyet i samsvar med retningslinjer.',
	'checkuser-desc' => 'Gir brukere med de tilhørende rettighetene muligheten til å sjekke brukeres IP-adresser og annen informasjon',
	'checkuser-logcase' => 'Loggsøket er sensitivt for store/små bokstaver.',
	'checkuser' => 'Brukersjekk',
	'checkuserlog' => 'Brukersjekkingslogg',
	'checkuser-contribs' => 'kontroller brukerens IP-adresser',
	'group-checkuser' => 'IP-kontrollører',
	'group-checkuser-member' => 'IP-kontrollør',
	'right-checkuser' => 'Sjekke brukeres IP-adresser og annen informasjon',
	'right-checkuser-log' => 'Se IP-kontrolloggen',
	'grouppage-checkuser' => '{{ns:project}}:IP-kontrollør',
	'checkuser-reason' => 'Årsak:',
	'checkuser-showlog' => 'Vis logg',
	'checkuser-query' => 'Søk i siste endringer',
	'checkuser-target' => 'IP-adresse eller brukernavn:',
	'checkuser-users' => 'Få brukere',
	'checkuser-edits' => 'Hent redigeringer',
	'checkuser-ips' => 'Få IP-er',
	'checkuser-search' => 'Søk',
	'checkuser-period' => 'Varighet:',
	'checkuser-week-1' => 'forrige uke',
	'checkuser-week-2' => 'siste to uker',
	'checkuser-month' => 'siste måned',
	'checkuser-all' => 'alle',
	'checkuser-cidr-label' => 'Finn felles adresseområde og påvirkede adresser for en liste over IP-adresser',
	'checkuser-cidr-res' => 'Felles CIDR:',
	'checkuser-empty' => 'Loggen inneholder ingen elementer.',
	'checkuser-nomatch' => 'Ingen treff.',
	'checkuser-nomatch-edits' => 'Ingen treff.
Siste redigering var $2 $1.',
	'checkuser-check' => 'Sjekk',
	'checkuser-log-fail' => 'Kunne ikke legge til loggelement.',
	'checkuser-nolog' => 'Ingen loggfil funnet.',
	'checkuser-blocked' => 'Blokkert',
	'checkuser-gblocked' => 'Blokkert globalt',
	'checkuser-locked' => 'Låst',
	'checkuser-wasblocked' => 'Tidligere blokkert',
	'checkuser-localonly' => 'Ikke sammenslått',
	'checkuser-massblock' => 'Blokker valgte brukere',
	'checkuser-massblock-text' => 'Valgte kontoer vil blokkeres på ubestemt tid, med autoblokkering slått på og kontooppretting slått av.
IP-adresser vil blokkeres i én uke for anonyme brukere, med kontooppretting slått av.',
	'checkuser-blocktag' => 'Erstatt brukersider med:',
	'checkuser-blocktag-talk' => 'Erstatt diskusjonssider med:',
	'checkuser-massblock-commit' => 'Blokker valgte brukere',
	'checkuser-block-success' => "'''{{PLURAL:$2|Brukeren|Brukerne}} $1 er nå blokkert.'''",
	'checkuser-block-failure' => "'''Ingen brukere blokkert.'''",
	'checkuser-block-limit' => 'For mange brukere valgt.',
	'checkuser-block-noreason' => 'Du må oppgi en blokkeringsgrunn.',
	'checkuser-noreason' => 'Du må oppgi en grunn for denne spørringen.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|ny konto|nye kontoer}}',
	'checkuser-too-many' => 'For mange resultater (ifølge overslag for spørringen), vennligst innskrenk CIDR.
Her er de brukte IP-ene (maks 5000, sortert etter adresse):',
	'checkuser-user-nonexistent' => 'Det gitte brukernavnet finnes ikke.',
	'checkuser-search-form' => 'Finn loggelementer der $1 er $2',
	'checkuser-search-submit' => 'Søk',
	'checkuser-search-initiator' => 'IP-kontrolløren',
	'checkuser-search-target' => 'målet',
	'checkuser-ipeditcount' => '~$1 fra alle brukere',
	'checkuser-log-return' => 'Tilbake til hovedskjema for brukersjekking',
	'checkuser-limited' => "'''Disse resultatene har blitt avkortet av ytelsesgrunner.'''",
	'checkuser-log-userips' => '$1 fikk IP-adressene til $2',
	'checkuser-log-ipedits' => '$1 fikk endringer av $2',
	'checkuser-log-ipusers' => '$1 fikk brukere av $2',
	'checkuser-log-ipedits-xff' => '$1 fikk endringer av XFF-en $2',
	'checkuser-log-ipusers-xff' => '$1 fikk brukere av XFF-en $2',
	'checkuser-log-useredits' => '$1 hentet redigeringer for $2',
	'checkuser-autocreate-action' => 'ble automatisk opprettet',
	'checkuser-create-action' => 'ble opprettet',
	'checkuser-email-action' => 'sendte e-post til «$1»',
	'checkuser-reset-action' => 'nullstilte passord for «$1»',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'checkuser-summary' => 'Dit Warktüüch dörsöcht de lesten Ännern na de IP-Adressen, de en Bruker bruukt hett, oder na de Ännern un Brukernaams, de vun en bestimmte IP maakt/bruukt worrn sünd.
Brukers un Ännern vun XFF-IPs ut köönt ankeken warrn, wenn „/xff“ achter de IP toschreven warrt. IPv4 (CIDR 16-32) un IPv6 (CIDR 64-128) warrt all beid ünnerstütt.
De Maximaltall vun trüchlevert Ännern is 5000.
Dit Warktüüch dröff blot na de Regeln mit de Richtlienen bruukt warrn.',
	'checkuser-desc' => 'Verlöövt Brukers mit de nödigen Rechten, de IP-Adressen un annere Infos vun Brukers natokieken',
	'checkuser-logcase' => 'De Logbook-Söök maakt en Ünnerscheed twischen grote un lütte Bookstaven.',
	'checkuser' => 'Bruker nakieken',
	'checkuserlog' => 'Checkuser-Logbook',
	'checkuser-contribs' => 'IP-Adressen vun Bruker prüfen',
	'group-checkuser' => 'Brukers nakieken',
	'group-checkuser-member' => 'Bruker nakieken',
	'right-checkuser' => 'IP-Adressen un annere Infos vun Brukers bekieken',
	'right-checkuser-log' => 'Checkuser-Logbook ankieken',
	'grouppage-checkuser' => '{{ns:project}}:Checkuser',
	'checkuser-reason' => 'Grund:',
	'checkuser-showlog' => 'Logbook wiesen',
	'checkuser-query' => 'Toletzt ännert affragen',
	'checkuser-target' => 'Bruker oder IP',
	'checkuser-users' => 'Brukers kriegen',
	'checkuser-edits' => 'Ännern vun IP-Adress wiesen',
	'checkuser-ips' => 'IPs kriegen',
	'checkuser-search' => 'Söken',
	'checkuser-period' => 'Duur:',
	'checkuser-week-1' => 'leste Week',
	'checkuser-week-2' => 'leste twee Weken',
	'checkuser-month' => 'leste 30 Daag',
	'checkuser-all' => 'all',
	'checkuser-cidr-label' => 'Söök gemeensamen IP-Block un bedrapen Adressen för en List vun IP-Adressen',
	'checkuser-cidr-res' => 'Gemeensam CIDR:',
	'checkuser-empty' => 'Dat Logbook is leddig.',
	'checkuser-nomatch' => 'Nix funnen, wat övereenstimmt.',
	'checkuser-nomatch-edits' => 'Nix funnen.
Lest Ännern weer an’n $1 üm $2.',
	'checkuser-check' => 'Los',
	'checkuser-log-fail' => 'Kunn keen Logbook-Indrag tofögen',
	'checkuser-nolog' => 'Keen Loogbook funnen.',
	'checkuser-blocked' => 'Sperrt',
	'checkuser-gblocked' => 'global sperrt',
	'checkuser-locked' => 'slaten',
	'checkuser-wasblocked' => 'ehrder al sperrt',
	'checkuser-localonly' => 'Nich tohoopföhrt',
	'checkuser-massblock' => 'Utwählt Brukers sperren',
	'checkuser-massblock-text' => 'De utwählten Brukerkonten warrt duurhaftig sperrt, de automaatsche Sperr warrt inschalt un dat Brukerkonto opstellen utschalt.
IP-Adressen warrt för IP-Brukers för een Week sperrt un dat Brukerkonto opstellen is utschalt.',
	'checkuser-blocktag' => 'Brukersieden utwesseln gegen:',
	'checkuser-blocktag-talk' => 'Diskuschoonssieden utwesseln gegen:',
	'checkuser-massblock-commit' => 'Sperr de utwählten Brukers',
	'checkuser-block-success' => "'''De {{PLURAL:$2|Bruker|Brukers}} $1 {{PLURAL:$2|is|sünd}} nu sperrt.'''",
	'checkuser-block-failure' => "'''Kene Brukers sperrt.'''",
	'checkuser-block-limit' => 'Toveel Brukers utwählt.',
	'checkuser-block-noreason' => 'Du musst en Grund för de Sperr angeven.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nee Brukerkonto|ne’e Brukerkonten}}',
	'checkuser-too-many' => 'To veel funnen, grenz de IP-Reeg wieder in. Dit sünd de bruukten IP-Adressen (maximal 5000, sorteert na Adress):',
	'checkuser-user-nonexistent' => 'Den angevene Bruker gifft dat nich.',
	'checkuser-search-form' => 'Söök na Logbook-Indrääg, bi de $1 $2 is.',
	'checkuser-search-submit' => 'Söök',
	'checkuser-search-initiator' => 'Initiater',
	'checkuser-search-target' => 'Ziel',
	'checkuser-ipeditcount' => '~$1 vun all Brukers',
	'checkuser-log-return' => 'Trüch na dat CheckUser-Hööftformular',
	'checkuser-limited' => "'''De List mit Resultaten is to lang wesen un körter maakt worrn.'''",
	'checkuser-log-userips' => '$1 hett IP-Adressen för $2 rutsöcht',
	'checkuser-log-ipedits' => '$1 hett Ännern vun $2 rutsöcht',
	'checkuser-log-ipusers' => '$1 hett Brukers för $2 rutsöcht',
	'checkuser-log-ipedits-xff' => '$1 hett Ännern för de XFF-IP $2 rutsöcht',
	'checkuser-log-ipusers-xff' => '$1 hett Brukers för de XFF-IP $2 rutsöcht',
	'checkuser-log-useredits' => '$1 hett Ännern för $2 haalt',
	'checkuser-autocreate-action' => 'automaatsch opstellt',
	'checkuser-email-action' => 'hett Bruker „$1“ en E-Mail tostüürt',
	'checkuser-reset-action' => 'hett en nee Passwoord för Bruker „$1“ feddert',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'checkuser-summary' => 'Dit hulpmiddel bekiekt de leste wiezigingen um IP-adressen weerumme te haolen die gebruukt bin deur n gebruker of geeft de bewarkings-/gebrukersgegevens weer veur n IP-adres. Gebrukers en bewarkingen kunnen weerummehaold wörden mit n XFF-IP deur "/xff" an t IP-adres toe te voegen. IPv4 (CIDR 16-32) en IPv6 (CIDR 64-128) wörden ondersteund. Wie laoten niet meer as 5.000 bewarkingen zien vanwegen prestasieredens. Gebruuk dit in overeenstemming mit t beleid.',
	'checkuser-desc' => 'Laot gebrukers mit de beneudigen rechten IP-adressen en aandere informasie van gebrukers achterhaolen.',
	'checkuser-logcase' => 'De zeukfunksie van t logboek is heufdlettergeveulig',
	'checkuser' => 'Gebruker naokieken',
	'checkuserlog' => 'Logboek gebrukersscheumers',
	'group-checkuser' => 'gebrukers naokieken',
	'group-checkuser-member' => 'gebrukersscheumerd',
	'grouppage-checkuser' => '{{ns:project}}:Gebrukersscheumerd',
	'checkuser-reason' => 'Reden:',
	'checkuser-showlog' => 'Logboek bekieken',
	'checkuser-query' => 'Zeukopdrachte leste wiezigingen',
	'checkuser-target' => 'IP-adres of gebrukersnaam:',
	'checkuser-users' => 'Gebrukers naokieken',
	'checkuser-edits' => 'Bewarkingen opvragen',
	'checkuser-ips' => 'IP-adressen naokieken',
	'checkuser-search' => 'Zeuken',
	'checkuser-empty' => 'Der steet gien informasie in t logboek.',
	'checkuser-nomatch' => 'Gien overeenkomsten evunnen.',
	'checkuser-check' => 'Naokieken',
	'checkuser-log-fail' => 'Kon gien logboekantekeningen maken',
	'checkuser-nolog' => 'Gien logboek evunnen.',
	'checkuser-blocked' => 'Eblokkeerd',
	'checkuser-too-many' => 'Te veule resultaoten (volgens de schatting). Maakt de IP-reeks kleinder:
Hieronder staon de gebruken IP-aderssen (maximaal 5.000, op IP-adres ekontroleerd):',
	'checkuser-user-nonexistent' => 'De op-egeven gebruker besteet niet.',
	'checkuser-search-form' => 'Logboekregels zeuken waor de $1 $2 is',
	'checkuser-search-submit' => 'Zeuken',
	'checkuser-search-initiator' => 'anvrager',
	'checkuser-search-target' => 'onderwarp',
);

/** Nepali (नेपाली)
 * @author Bhawani Gautam
 * @author Bhawani Gautam Rhk
 */
$messages['ne'] = array(
	'checkuser-search' => 'खोज्ने',
	'checkuser-log-userips' => '$2को लागि $1 आइ पी ठेगाना पाइयो',
);

/** Dutch (Nederlands)
 * @author Erwin
 * @author SPQRobin
 * @author Siebrand
 * @author Troefkaart
 */
$messages['nl'] = array(
	'checkuser-summary' => 'Dit hulpmiddel bekijkt recente wijzigingen om IP-adressen die een gebruiker heeft gebruikt te achterhalen of geeft de bewerkings- en gebruikersgegegevens weer voor een IP-adres.
Gebruikers en bewerkingen van een IP-adres van een client kunnen achterhaald worden via XFF-headers door "/xff" achter het IP-adres toe te voegen. IPv4 (CIDR 16-32) en IPv6 (CIDR 64-128) worden ondersteund.
Om prestatieredenen worden niet meer dan 5.000 bewerkingen weergegeven.
Gebruik dit hulpmiddel volgens het vastgestelde beleid.',
	'checkuser-desc' => 'Laat bevoegde gebruikers IP-adressen en andere informatie van gebruikers achterhalen',
	'checkuser-logcase' => 'Zoeken in het logboek is hoofdlettergevoelig.',
	'checkuser' => 'Gebruiker controleren',
	'checkuserlog' => 'Logboek controleren gebruikers',
	'checkuser-contribs' => 'IP-adressen van gebruiker controleren',
	'group-checkuser' => 'controlegebruikers',
	'group-checkuser-member' => '{{GENDER:$1|controlegebruiker}}',
	'right-checkuser' => 'IP-adressen en andere gegevens van gebruikers bekijken',
	'right-checkuser-log' => 'Het Logboek controleren gebruikers bekijken',
	'action-checkuser' => 'IP-adressen en andere gegevens van gebruikers te bekijken',
	'action-checkuser-log' => 'het Logboek controleren gebruikers te bekijken',
	'grouppage-checkuser' => '{{ns:project}}:Controlegebruiker',
	'checkuser-reason' => 'Reden:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Logboek weergeven',
	'checkuser-query' => 'Bevraag recente wijzigingen',
	'checkuser-target' => 'IP-adres of gebruikersnaam:',
	'checkuser-users' => 'Gebruikers opvragen',
	'checkuser-edits' => 'Bewerkingen opvragen',
	'checkuser-ips' => 'IP-adressen opvragen',
	'checkuser-search' => 'Zoeken',
	'checkuser-period' => 'Duur:',
	'checkuser-week-1' => 'laatste week',
	'checkuser-week-2' => 'laatste twee weken',
	'checkuser-month' => 'laatste 30 dagen',
	'checkuser-all' => 'alle',
	'checkuser-cidr-label' => 'Gemeenschappelijke reeks en getroffen adressen zoeken uit een lijst van IP-adressen',
	'checkuser-cidr-res' => 'Gemeenschappelijke CIDR:',
	'checkuser-empty' => 'Het logboek bevat geen regels.',
	'checkuser-nomatch' => 'Geen overeenkomsten gevonden.',
	'checkuser-nomatch-edits' => 'Niets gevonden.
De laatste bewerking was op $1 om $2.',
	'checkuser-check' => 'Controleren',
	'checkuser-log-fail' => 'Logboekregel toevoegen niet mogelijk',
	'checkuser-nolog' => 'Geen logboek gevonden.',
	'checkuser-blocked' => 'Geblokkeerd',
	'checkuser-gblocked' => 'Globaal geblokkeerd',
	'checkuser-locked' => 'Afgesloten',
	'checkuser-wasblocked' => 'Eerder geblokkeerd',
	'checkuser-localonly' => 'Niet samengevoegd',
	'checkuser-massblock' => 'Geselecteerde gebruikers blokkeren',
	'checkuser-massblock-text' => 'De geselecteerde gebruikers worden voor onbepaalde tijd geblokkeerd, met automatische IP-adresblokkade ingeschakeld en het aanmaken van nieuwe gebruikers uitgeschakeld.
IP-adressen worden één week geblokkeerd voor anonieme gebruikers, met het aanmaken van nieuwe gebruikers uitgeschakeld.',
	'checkuser-blocktag' => "Gebruikerspagina's vervangen door:",
	'checkuser-blocktag-talk' => "Overlegpagina's vervangen door:",
	'checkuser-massblock-commit' => 'Geselecteerde gebruikers blokkeren',
	'checkuser-block-success' => "'''De {{PLURAL:$2|gebruiker|gebruikers}} $1 {{PLURAL:$2|is|zijn}} geblokkeerd.'''",
	'checkuser-block-failure' => "'''Geen gebruikers geblokkeerd.'''",
	'checkuser-block-limit' => 'Te veel gebruikers geselecteerd.',
	'checkuser-block-noreason' => 'U moet een reden opgeven voor de blokkades.',
	'checkuser-noreason' => 'U moet een reden opgeven voor deze zoekopdracht.',
	'checkuser-accounts' => '$1 nieuwe {{PLURAL:$1|gebruiker|gebruikers}}',
	'checkuser-too-many' => 'Te veel resultaten (volgens de schatting). Maak de IP-reeks kleiner:
Hieronder worden de gebruikte IP-adressen weergegeven (maximaal 5000, op IP-adres gesorteerd):',
	'checkuser-user-nonexistent' => 'De opgegeven gebruiker bestaat niet.',
	'checkuser-search-form' => 'Logboekregels zoeken waar de $1 $2 is',
	'checkuser-search-submit' => 'Zoeken',
	'checkuser-search-initiator' => 'aanvrager',
	'checkuser-search-target' => 'onderwerp',
	'checkuser-ipeditcount' => '~$1 van alle gebruikers',
	'checkuser-log-return' => 'Naar het hoofdformulier van GebruikerControleren terugkeren',
	'checkuser-limited' => "'''Deze resultaten zijn niet volledig om prestatieredenen.'''",
	'checkuser-log-userips' => '$1 heeft de IP-adressen door $2 opgevraagd',
	'checkuser-log-ipedits' => '$1 heeft de bewerkingen door $2 opgevraagd',
	'checkuser-log-ipusers' => '$1 heeft de gebruikers voor $2 opgevraagd',
	'checkuser-log-ipedits-xff' => '$1 heeft de bewerkingen door XFF $2 opgevraagd',
	'checkuser-log-ipusers-xff' => '$1 heeft de gebruikers van XFF $2 opgevraagd',
	'checkuser-log-useredits' => '$1 heeft de bewerkingen door $2 opgevraagd',
	'checkuser-autocreate-action' => 'is automatisch aangemaakt',
	'checkuser-create-action' => 'is aangemaakt',
	'checkuser-email-action' => 'heeft een e-mail gestuurd aan "$1"',
	'checkuser-reset-action' => 'heeft het wachtwoord voor gebruiker "$1" opnieuw ingesteld',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'checkuser-summary' => 'Dette verktøyet går gjennom siste endringar for å henta IP-ane som er nytta av ein brukar, eller syner endrings- eller brukarinformasjon for ein IP.

Brukarar og endringar frå ein klient-IP kan verta henta gjennom XFF ved å leggja til «/xff» bak IP-en. IPv4 (CIDR 16-32) og IPv6 (CIDR 64-128) er støtta.

Av yteårsaker vert høgst 5000 endringar viste.
Nytt dette verktøyet i samsvar med retningsliner.',
	'checkuser-desc' => 'Gjev brukarar med dei rette rettane moglegheita til å sjekka IP-adressene til og annan informasjon om brukarar.',
	'checkuser-logcase' => 'Loggsøket tek omsyn til små og store bokstavar.',
	'checkuser' => 'Brukarsjekk',
	'checkuserlog' => 'Logg over brukarkontrollering',
	'checkuser-contribs' => 'finn brukaren sine IP-adresser',
	'group-checkuser' => 'Brukarkontrollørar',
	'group-checkuser-member' => 'Brukarkontrollør',
	'right-checkuser' => 'Sjekka IP-adressene til brukarar i tillegg til annan informasjon.',
	'right-checkuser-log' => 'Sjå brukarkontroll-loggen',
	'grouppage-checkuser' => '{{ns:project}}:Brukarkontrollør',
	'checkuser-reason' => 'Årsak:',
	'checkuser-showlog' => 'Syn logg',
	'checkuser-query' => 'Søk i siste endringar',
	'checkuser-target' => 'Brukar eller IP:',
	'checkuser-users' => 'Hent brukarar',
	'checkuser-edits' => 'Hent endringar frå IP',
	'checkuser-ips' => 'Hent IP-ar',
	'checkuser-search' => 'Søk',
	'checkuser-period' => 'Varigskap:',
	'checkuser-week-1' => 'førre veka',
	'checkuser-week-2' => 'siste to veker',
	'checkuser-month' => 'siste 30 dagar',
	'checkuser-all' => 'alle',
	'checkuser-cidr-label' => 'Finn sams talrekkjer og adresser for ei liste over IP-adresser',
	'checkuser-cidr-res' => 'Sams CIDR:',
	'checkuser-empty' => 'Loggen inneheld ingen element.',
	'checkuser-nomatch' => 'Ingen treff.',
	'checkuser-nomatch-edits' => 'Ingen treff.
Siste endringar skjedde $1 $2.',
	'checkuser-check' => 'Sjekk',
	'checkuser-log-fail' => 'Kunne ikkje leggja til loggelement.',
	'checkuser-nolog' => 'Fann inga loggfil.',
	'checkuser-blocked' => 'Blokkert',
	'checkuser-gblocked' => 'Blokkert globalt',
	'checkuser-locked' => 'Låst',
	'checkuser-wasblocked' => 'Tidlegare blokkert',
	'checkuser-localonly' => 'Ikkje samanslege',
	'checkuser-massblock' => 'Blokker valte brukarar',
	'checkuser-massblock-text' => 'Valte kontoar vil verta blokkerte endelaust, med autoblokkering slege på og kontooppretting slege av.
IP-adresser vil verta blokkerte for éi veka for uregistrerte, med kontooppretting slege av.',
	'checkuser-blocktag' => 'Erstatt brukarsider med:',
	'checkuser-blocktag-talk' => 'Erstatt diskusjonssider med:',
	'checkuser-massblock-commit' => 'Blokker valte brukarar',
	'checkuser-block-success' => "'''{{PLURAL:$2|Brukaren|Brukarane}} $1 er no {{PLURAL:$2|blokkert|blokkerte}}.'''",
	'checkuser-block-failure' => "'''Ingen brukarar blokkerte.'''",
	'checkuser-block-limit' => 'For mange brukarar er valte.',
	'checkuser-block-noreason' => 'Du må oppgje ei blokkeringsårsak.',
	'checkuser-noreason' => 'Du må gje opp ei grunngjeving for denne spørjinga.',
	'checkuser-accounts' => '{{PLURAL:$1|Éin ny konto|$1 nye kontoar}}',
	'checkuser-too-many' => 'For mange resultat, (i høve til overslag for spørjinga)  ver venleg og reduser CIDR.
Her er IP-ane nytta (høgst 5000, sorterte etter adressa):',
	'checkuser-user-nonexistent' => 'Brukarnamnet du oppgav finst ikkje.',
	'checkuser-search-form' => 'Finn loggelement der $1 er $2',
	'checkuser-search-submit' => 'Søk',
	'checkuser-search-initiator' => 'igangsetjar',
	'checkuser-search-target' => 'mål',
	'checkuser-ipeditcount' => '~$1 frå alle brukarar',
	'checkuser-log-return' => 'Attende til hovudskjema for brukarsjekking',
	'checkuser-limited' => "'''Desse resultata har vortne avkorta av ytegrunnar.'''",
	'checkuser-log-userips' => '$1 fekk IP-adressene til $2',
	'checkuser-log-ipedits' => '$1 fekk endringar av $2',
	'checkuser-log-ipusers' => '$1 fekk brukarar av $2',
	'checkuser-log-ipedits-xff' => '$1 fekk endringar av XFF-en $2',
	'checkuser-log-ipusers-xff' => '$1 fekk brukarar av XFF-en $2',
	'checkuser-log-useredits' => '$1 henta endringar for $2',
	'checkuser-autocreate-action' => 'vart automatisk oppretta',
	'checkuser-email-action' => 'sendte e-post til «$1»',
	'checkuser-reset-action' => 'nullstilte passord for «$1»',
);

/** Novial (Novial)
 * @author MF-Warburg
 * @author Malafaya
 */
$messages['nov'] = array(
	'checkuser-reason' => 'Resone:',
	'checkuser-search' => 'Sercha',
);

/** Nouormand (Nouormand)
 * @author Crochet.david
 */
$messages['nrm'] = array(
	'checkuser-search' => 'Trachi',
	'checkuser-all' => 'touot',
	'checkuser-search-submit' => 'Trachi',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'checkuser-reason' => 'Lebaka:',
	'checkuser-target' => 'IP atrese goba Mošomiši',
	'checkuser-search' => 'Fetleka',
	'checkuser-week-1' => 'Beke yago feta',
	'checkuser-week-2' => 'Beke tše pedi tšago feta',
	'checkuser-blocked' => 'Thibilwe',
	'checkuser-search-submit' => 'Fetleka',
);

/** Occitan (Occitan)
 * @author Boulaur
 * @author Cedric31
 */
$messages['oc'] = array(
	'checkuser-summary' => "Aquesta aisina passa en revista los cambiaments recents per recercar l'IPS emplegada per un utilizaire, mostrar totas las edicions fachas per una IP, o per enumerar los utilizaires qu'an emplegat las IPs. Los utilizaires e las modificacions pòdon èsser trobatss amb una IP XFF se s'acaba amb « /xff ». IPv4 (CIDR 16-32) e IPv6(CIDR 64-128) son suportats. Emplegatz aquò segon las cadenas de caractèrs.",
	'checkuser-desc' => 'Balha la possibilitat a las personas exprèssament autorizadas de verificar las adreças IP dels utilizaires e mai d’autras entresenhas los concernent',
	'checkuser-logcase' => 'La recèrca dins lo Jornal es sensibla a la cassa.',
	'checkuser' => 'Verificator d’utilizaire',
	'checkuserlog' => "Notacion de Verificator d'utilizaire",
	'checkuser-contribs' => 'verificar las adreças IP',
	'group-checkuser' => 'Verificators d’utilizaire',
	'group-checkuser-member' => 'Verificator d’utilizaire',
	'right-checkuser' => "Verificar l'adreça IP dels utilizaires e autras entresenhas",
	'right-checkuser-log' => 'Veire lo jornal de verificacion d’adreça',
	'grouppage-checkuser' => '{{ns:project}}:Verificator d’utilizaire',
	'checkuser-reason' => 'Motiu :',
	'checkuser-showlog' => 'Afichar lo jornal',
	'checkuser-query' => 'Recèrca pels darrièrs cambiaments',
	'checkuser-target' => "Nom d'utilizaire o adreça IP :",
	'checkuser-users' => 'Obténer los utilizaires',
	'checkuser-edits' => "Obténer las modificacions de l'IP",
	'checkuser-ips' => 'Obténer las adreças IP',
	'checkuser-search' => 'Recèrca',
	'checkuser-period' => 'Durada :',
	'checkuser-week-1' => 'darrièra setmana',
	'checkuser-week-2' => 'las doas darrièras setmanas',
	'checkuser-month' => 'los 30 darrièrs jorns',
	'checkuser-all' => 'tot',
	'checkuser-cidr-label' => "Cercar una plaja comuna e las adreças afectadas per una lista d'adreças IP",
	'checkuser-cidr-res' => 'Plaja CIDR comuna :',
	'checkuser-empty' => "Lo jornal conten pas cap d'article",
	'checkuser-nomatch' => 'Recèrcas infructuosas.',
	'checkuser-nomatch-edits' => "Cap d'ocurréncia pas trobada.
La darrièra modificacion èra lo $1 a $2.",
	'checkuser-check' => 'Recèrca',
	'checkuser-log-fail' => "Incapable d'apondre l'entrada del jornal.",
	'checkuser-nolog' => 'Cap de fichièr jornal pas trobat.',
	'checkuser-blocked' => 'Blocat',
	'checkuser-gblocked' => 'Globalament blocat',
	'checkuser-locked' => 'Varrolhat',
	'checkuser-wasblocked' => 'Blocat precedentament',
	'checkuser-localonly' => 'Pas unificat',
	'checkuser-massblock' => 'Utilizaires de la plaja seleccionada',
	'checkuser-massblock-text' => 'Los comptes seleccionats seràn blocats indefinidament, amb lo blocatge automatic activat e la creacion de compte desactivada.
Las adreças IP seràn blocadas pendent una setmana unicament pels utilizaires jos IP e la creacion de compte desactivada.',
	'checkuser-blocktag' => "Remplaça las paginas d'utilizaire per :",
	'checkuser-blocktag-talk' => 'Remplaçar las paginas de discussion amb :',
	'checkuser-massblock-commit' => 'Blocar los utilizaires seleccionats',
	'checkuser-block-success' => "'''{{PLURAL:$2|L’utilizaire|Los utilizaires}} $1 {{PLURAL:$2|ara es blocat|ara son blocats}}.'''",
	'checkuser-block-failure' => "'''Cap d'utilizaire pas blocat.'''",
	'checkuser-block-limit' => "Tròp d'utilizaires seleccionats.",
	'checkuser-block-noreason' => 'Vos cal especificar un motiu pels blocatges.',
	'checkuser-noreason' => 'Vos cal balhar una rason per aquesta requèsta.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|compte novèl|comptes novèls}}',
	'checkuser-too-many' => "Tròp de resultats (segon l'estimacion de la requèsta), afinatz l’espandida CIDR.
Vaquí un extrach de las IP utilizadas ({{formatnum:5000}} maximum, triadas per adreça) :",
	'checkuser-user-nonexistent' => 'L’utilizaire indicat existís pas',
	'checkuser-search-form' => 'Cercar lo jornal de las entradas ont $1 es $2.',
	'checkuser-search-submit' => 'Recercar',
	'checkuser-search-initiator' => 'l’iniciaire',
	'checkuser-search-target' => 'la cibla',
	'checkuser-ipeditcount' => '~$1 per totes los utilizaires',
	'checkuser-log-return' => "Tornar al formulari principal de la verificacion d'utilizaire",
	'checkuser-limited' => "'''Aquestes resultats son estats troncats per de rasons ligadas a la performància.'''",
	'checkuser-log-userips' => "$1 a obtengut d'IP per $2",
	'checkuser-log-ipedits' => '$1 a obtengut de modificacions per $2',
	'checkuser-log-ipusers' => "$1 a obtengut d'utilizaires per $2",
	'checkuser-log-ipedits-xff' => '$1 a obtengut de modificacions per XFF  $2',
	'checkuser-log-ipusers-xff' => "$1 a obtengut d'utilizaires per XFF $2",
	'checkuser-log-useredits' => '$1 a obtengut las modificacions per $2',
	'checkuser-autocreate-action' => 'es estat creat automaticament',
	'checkuser-create-action' => 'es estat creat',
	'checkuser-email-action' => 'a mandat un corrièr electronic a « $1 »',
	'checkuser-reset-action' => 'torna inicializar lo senhal per « $1 »',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 * @author Jose77
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'checkuser' => 'ତନଖି ଚାଳକ',
	'checkuserlog' => 'ବ୍ୟବହାରକାରୀ ଇତିହାସ ପରଖିବେ',
	'checkuser-contribs' => 'ଆପଣା ବ୍ୟବହାରକାରୀ IP ଠିକଣା ପରଖନ୍ତୁ',
	'group-checkuser' => 'ତନଖି ଚାଳକ',
	'group-checkuser-member' => '{{GENDER:$1|ବ୍ୟବହାରକାରୀଙ୍କୁ ପରଖନ୍ତୁ}}',
	'right-checkuser' => 'ବ୍ୟବହାରକାରୀଙ୍କର IP ଠିକଣା ଓ ବାକି ତଥ୍ୟ ପରଖନ୍ତୁ',
	'right-checkuser-log' => 'ପରଖ ବ୍ୟବହାରକାରୀଙ୍କ ଇତିହାସ ଦେଖିବେ',
	'action-checkuser' => 'ବ୍ୟବହାରକାରୀଙ୍କର IP ଠିକଣା ଓ ବାକି ତଥ୍ୟ ପରଖନ୍ତୁ',
	'action-checkuser-log' => 'ପରଖ ବ୍ୟବହାରକାରୀଙ୍କ ଇତିହାସ ଦେଖିବେ',
	'grouppage-checkuser' => '{{ns:project}}:ବ୍ୟବହାରକାରୀ ପରଖିବେ',
	'checkuser-reason' => 'କାରଣ:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'ଲଗ ଦେଖିବେ',
	'checkuser-query' => 'ନଗଦ ବଦଳ ପ୍ରଶ୍ନ',
	'checkuser-target' => 'ବ୍ୟବହାରକାରୀଙ୍କର IP ଠିକଣା ବା ଇଉଜର ନାମ:',
	'checkuser-users' => 'ବ୍ୟବହାରକାରୀଙ୍କୁ ପାଇବେ',
	'checkuser-edits' => 'ସମ୍ପାଦନା ପାଇବେ',
	'checkuser-ips' => 'IP ଠିକଣା ପାଇବେ',
	'checkuser-search' => 'ଖୋଜିବା',
	'checkuser-period' => 'ଅବଧି:',
	'checkuser-week-1' => 'ଶେଷ ସପ୍ତାହ',
	'checkuser-week-2' => 'ଶେଷ ଦୁଇ ସପ୍ତାହ',
	'checkuser-month' => 'ଶେଷ ୩୦ ଦିନ',
	'checkuser-all' => 'ସବୁ',
	'checkuser-cidr-label' => 'ଏକ IP ଠିକଣାର ତାଲିକା ନିମନ୍ତେ ଏକ ସାଧାରଣ ସୀମା ଓ ପ୍ରଭାବିତ IP ଠିକଣାମାନ ଦିଅନ୍ତୁ',
	'checkuser-cidr-res' => 'ସାଧାରଣ CIDR:',
	'checkuser-empty' => 'ଇତିହାସରେ କିଛି ବି ବିଷୟ ନାହିଁ ।',
	'checkuser-nomatch' => 'କିଛି ମେଳହେଲା ନାହିଁ ।',
	'checkuser-nomatch-edits' => 'କିଛି ବି ମେଳ ଖାଇଲା ନାହିଁ ।
ଶେଷ ବଦଳଟି $1 ଦିନ $2 ବେଳେ ହୋଇଥିଲା ।',
	'checkuser-check' => 'ଯାଞ୍ଚ କରିବା',
	'checkuser-log-fail' => 'ଇତିହାସ ନିବେଶ କରିବାକୁ ଅକ୍ଷମ',
	'checkuser-nolog' => 'ଇତିହାସ ଫାଇଲ ମିଳିଲା ନାହିଁ ।',
	'checkuser-blocked' => 'ଅଟକାଯାଇଥିବା',
	'checkuser-gblocked' => 'ଜଗତସାରା ଅଟକାଯାଇଛି',
	'checkuser-locked' => 'କିଳାଯାଇଅଛି',
	'checkuser-wasblocked' => 'ଆଗରୁ ଅଟକାଯାଇଥିବା',
	'checkuser-localonly' => 'ଏକୀକରଣ ହୋଇନାହିଁ',
	'checkuser-massblock' => 'ବଛା ବ୍ୟବହାରକାରୀ ଅଟକାନ୍ତୁ',
	'checkuser-blocktag' => 'ବ୍ୟବହାରକାରୀ ପୃଷ୍ଠାର ପ୍ରତିବଦଳ କରିବେ:',
	'checkuser-blocktag-talk' => 'ବ୍ୟବହାରକାରୀ ପୃଷ୍ଠାର ପ୍ରତିବଦଳ କରିବେ:',
	'checkuser-massblock-commit' => 'ବଛା ବ୍ୟବହାରକାରୀ ଅଟକାନ୍ତୁ',
	'checkuser-block-success' => "'''{{PLURAL:$2|ବ୍ୟବହାରକାରୀ|ବ୍ୟବହାରକାରୀଗଣ}}ଙ୍କୁ $1 {{PLURAL:$2|ଅଟକାଗଲା|ଅଟକାଗଲା}} ।'''",
	'checkuser-block-failure' => "'''କୌଣସି ବ୍ୟବହାରକାରୀଙ୍କୁ ଅଟକାଯାଇନାହିଁ ।'''",
	'checkuser-block-limit' => 'ବହୁ ଅଧିକ ବ୍ୟବହାରକାରୀଙ୍କୁ ବଛାଗଲା ।',
	'checkuser-block-noreason' => 'ଆପଣଙ୍କୁ ଅଟକ ପାଇଁ ଏକ କାରଣ ଦେବାକୁ ପଡ଼ିବ ।',
	'checkuser-noreason' => 'ଆପଣଙ୍କୁ ଏହି ପ୍ରଶ୍ନ ପାଇଁ ଏକ କାରଣ ଦେବାକୁ ପଡ଼ିବ ।',
	'checkuser-accounts' => '$1 ଗୋଟି ନୂଆ {{PLURAL:$1|ଖାତା|ଖାତା}}',
	'checkuser-user-nonexistent' => 'ଆପଣ ଖୋଜୁଥିବା ବ୍ୟବହାରକାରୀ ମିଳୁନାହାନ୍ତି ।',
	'checkuser-search-form' => '$1 ଯେଉଁଠି $2 ସେହିସବୁ ଇତିହାସ ନିବେଶ ଖୋଜିବେ',
	'checkuser-search-submit' => 'ଖୋଜିବା',
	'checkuser-search-initiator' => 'ଆରମ୍ଭକାରୀ',
	'checkuser-search-target' => 'ଲକ୍ଷ',
	'checkuser-ipeditcount' => 'ସବୁ ବ୍ୟବହରକାରୀଙ୍କ ଠାରୁ ~$1',
	'checkuser-log-return' => 'CheckUser ମୂଳ ଆବେଦନ ପତ୍ରକୁ ଫେରିଯାନ୍ତୁ',
	'checkuser-log-userips' => '$1ଙ୍କ ପାଖରେ $2 ପାଇଁ IP ଠିକଣା ରହିଛି',
	'checkuser-log-ipedits' => '$1, $2ଙ୍କ ପାଇଁ ସମ୍ପାଦନା କରିଛନ୍ତି',
	'checkuser-log-ipusers' => '$1ରେ $2 ପାଇଁ ବ୍ୟବହାରକାରୀ ଅଛନ୍ତି',
	'checkuser-log-ipedits-xff' => '$1 XFF $2 ପାଇଁ ସମ୍ପାଦନା କରିଛନ୍ତି',
	'checkuser-log-ipusers-xff' => '$1ରେ XFF $2 ପାଇଁ ସମ୍ପାଦନା ଅଛି',
	'checkuser-log-useredits' => '$1ରେ $2ପାଇଁ ସମ୍ପାଦନା ଅଛି',
	'checkuser-autocreate-action' => 'ଆପେଆପେ ଗଢ଼ାହୋଇଥିଲା',
	'checkuser-create-action' => 'ଗଢ଼ାଗଲା',
	'checkuser-email-action' => '"$1"ଙ୍କୁ ଇମେଲଟିଏ ପଠାଗଲା',
	'checkuser-reset-action' => '"$1"ଙ୍କ ପାଇଁ ପାସୱାର୍ଡ଼ ଆଉଥରେ ଖଞ୍ଜିବେ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'checkuser-reason' => 'Аххос:',
);

/** Pangasinan (Pangasinan) */
$messages['pag'] = array(
	'checkuser-reason' => 'Katonongan',
	'checkuser-target' => 'Manag-usar odino IP',
	'checkuser-users' => 'Alaen so manag-usar',
	'checkuser-search' => 'Anapen',
);

/** Pampanga (Kapampangan) */
$messages['pam'] = array(
	'checkuser' => 'Surian ya ing gagamit',
	'checkuser-reason' => 'Sangkan:',
	'checkuser-showlog' => 'Pakit ya ing log',
	'checkuser-search' => 'Manintun',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'checkuser-reason' => 'Grund:',
	'checkuser-target' => 'IP-Adress odder Yuusernaame:',
	'checkuser-search' => 'Uffgucke',
	'checkuser-week-1' => 'letscht Woch',
	'checkuser-week-2' => 'letschte zwo Woche',
	'checkuser-month' => 'letschte 30 Daag',
	'checkuser-all' => 'all',
	'checkuser-blocked' => "g'baerrt",
	'checkuser-gblocked' => "Iwwerall g'baerrt",
	'checkuser-search-submit' => 'Guck uff',
);

/** Polish (Polski)
 * @author Beau
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
 * @author Woytecr
 * @author Wpedzich
 */
$messages['pl'] = array(
	'checkuser-summary' => 'Narzędzie skanuje ostatnie zmiany, by odnaleźć adresy IP użyte przez użytkownika lub by pokazać edycje i użytkowników dla zadanego adresu IP.
Użytkownicy i edycje spod adresu IP mogą być pozyskani przez nagłówki XFF przez dodanie do IP „/xff”. Obsługiwane są adresy IPv4 (CIDR 16-32) I IPv6 (CIDR 64-128).
Ze względu na wydajność, zostanie zwróconych nie więcej niż 5000 edycji.
Używaj tego narzędzia zgodnie z zasadami.',
	'checkuser-desc' => 'Umożliwia uprawnionym użytkownikom sprawdzenie adresów IP użytkowników oraz innych informacji',
	'checkuser-logcase' => 'Szukanie w rejestrze jest czułe na wielkość znaków.',
	'checkuser' => 'Sprawdź IP użytkownika',
	'checkuserlog' => 'Rejestr CheckUser',
	'checkuser-contribs' => 'sprawdzić adresy IP użytkownika',
	'group-checkuser' => 'CheckUser',
	'group-checkuser-member' => '{{GENDER:$1|checkuser|checkuserka}}',
	'right-checkuser' => 'Sprawdzanie adresów IP oraz innych informacji o użytkownikach',
	'right-checkuser-log' => 'Przeglądanie rejestru checkuser',
	'action-checkuser' => 'sprawdzania adresów IP uzytkowników i innych informacji',
	'action-checkuser-log' => 'przeglądania rejestru checkuser',
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Powód',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Pokaż rejestr',
	'checkuser-query' => 'Przeanalizuj ostatnie zmiany',
	'checkuser-target' => 'Adres IP lub nazwa użytkownika',
	'checkuser-users' => 'Znajdź użytkowników',
	'checkuser-edits' => 'Edycje',
	'checkuser-ips' => 'Znajdź adresy IP',
	'checkuser-search' => 'Szukaj',
	'checkuser-period' => 'Okres',
	'checkuser-week-1' => 'ostatni tydzień',
	'checkuser-week-2' => 'ostatnie dwa tygodnie',
	'checkuser-month' => 'ostatnie 30 dni',
	'checkuser-all' => 'wszystkie',
	'checkuser-cidr-label' => 'Znajdź wspólny zakres i wpływ na adresy IP z listy',
	'checkuser-cidr-res' => 'Wspólny CIDR:',
	'checkuser-empty' => 'Rejestr nie zawiera żadnych wpisów.',
	'checkuser-nomatch' => 'Nie odnaleziono niczego.',
	'checkuser-nomatch-edits' => 'Nie odnaleziono.
Ostatnia edycja została wykonana $1 o $2.',
	'checkuser-check' => 'sprawdź',
	'checkuser-log-fail' => 'Nie udało się dodać wpisu do rejestru',
	'checkuser-nolog' => 'Nie znaleziono pliku rejestru.',
	'checkuser-blocked' => 'Zablokowany',
	'checkuser-gblocked' => 'Zablokowany globalnie',
	'checkuser-locked' => 'Zablokowany',
	'checkuser-wasblocked' => 'Poprzednie blokady',
	'checkuser-localonly' => 'Nie posiada konta uniwersalnego',
	'checkuser-massblock' => 'Blokowanie wybranych użytkowników',
	'checkuser-massblock-text' => 'Wybrane konta zostaną zablokowane na zawsze (z włączoną funkcją automatycznego blokowania adresów IP, spod których łączą się te konta oraz wyłączoną funkcją zapobiegania utworzenia konta).
Adresy IP anonimowych użytkowników będą blokowane na 1 tydzień z wyłączoną funkcją zapobiegania utworzenia konta.',
	'checkuser-blocktag' => 'Podmień stronę użytkowników na',
	'checkuser-blocktag-talk' => 'Podmień strony dyskusji użytkowników na',
	'checkuser-massblock-commit' => 'Zablokuj wybranych użytkowników',
	'checkuser-block-success' => "'''{{PLURAL:$2|Użytkownik|Użytkownicy}} $1 {{PLURAL:$2|jest|są}} obecnie {{PLURAL:$2|zablokowany|zablokowani}}.'''",
	'checkuser-block-failure' => "'''Brak zablokowanych użytkowników.'''",
	'checkuser-block-limit' => 'Wybrano zbyt wielu użytkowników.',
	'checkuser-block-noreason' => 'Należy podać powód blokad.',
	'checkuser-noreason' => 'Musisz podać powód wykonania zapytania.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nowe konto|nowe konta|nowych kont}}',
	'checkuser-too-many' => 'Zbyt wiele wyników (według szacunku zapytania); ogranicz CIDR.
Użytych adresów IP jest (nie więcej niż 5000, posortowane według adresu):',
	'checkuser-user-nonexistent' => 'Taki użytkownik nie istnieje.',
	'checkuser-search-form' => 'Szukaj wpisów w rejestrze, dla których $1 był $2',
	'checkuser-search-submit' => 'Szukaj',
	'checkuser-search-initiator' => 'sprawdzającym',
	'checkuser-search-target' => 'sprawdzanym',
	'checkuser-ipeditcount' => '~$1 od wszystkich użytkowników',
	'checkuser-log-return' => 'Przejście do głównego formularza CheckUser',
	'checkuser-limited' => "'''Długość listy wyników została ograniczona ze względu na wydajność.'''",
	'checkuser-log-userips' => '$1 otrzymał adresy IP używane przez $2',
	'checkuser-log-ipedits' => '$1 otrzymał historię edycji dla $2',
	'checkuser-log-ipusers' => '$1 otrzymał listę użytkowników korzystających z adresu IP $2',
	'checkuser-log-ipedits-xff' => '$1 otrzymał listę edycji dla XFF $2',
	'checkuser-log-ipusers-xff' => '$1 otrzymał listę użytkowników dla XFF $2',
	'checkuser-log-useredits' => '$1 otrzymał historię edycji wykonane przez $2',
	'checkuser-autocreate-action' => 'został automatycznie utworzony',
	'checkuser-create-action' => 'utworzono',
	'checkuser-email-action' => 'wysłał e‐mail do użytkownika „$1”',
	'checkuser-reset-action' => 'reset hasła dla użytkownika „$1”',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'checkuser-summary' => "St'utiss-sì as passa j'ùltime modìfiche për tiré sù j'adrësse IP dovra da n'utent ò pura mostré lòn ch'as fa da n'adrëssa IP e che dat utent ch'a l'abia associà.
	J'utent ch'a dòvro n'adrëssa IP e le modìfiche faite d'ambelelì as peulo tiresse sù ën dovrand le testà XFF, për felo tache-ie dapress l'adrëssa e \"/xff\". A travaja tant con la forma IPv4 (CIDR 16-32) che con cola IPv6 (CIDR 64-128).
	Për na question ëd caria ëd travaj a tira nen sù pì che 5000 modìfiche. A va dovrà comforma a ij deuit për ël process ëd contròl.",
	'checkuser-desc' => "A dà a j'utent con ij përmess aproprià la possibilità ëd controlé j'adrësse IP dj'utent e àutre anformassion",
	'checkuser-logcase' => "L'arsërca ant ël registr a conta ëdcò maiùscole e minùscole.",
	'checkuser' => "Contròl dj'utent",
	'checkuserlog' => "Registr dël contròl dj'utent",
	'checkuser-contribs' => "contròla l'adrëssa IP ëd l'utent",
	'group-checkuser' => 'Controlor',
	'group-checkuser-member' => '{{GENDER:$1|controlor}}',
	'right-checkuser' => "Contròla l'adrëssa IP ëd l'utent e àutre anformassion",
	'right-checkuser-log' => 'Varda ël registr dël controlor',
	'action-checkuser' => "controlé l'adrëssa IP ëd l'utent e d'àutre anformassion",
	'action-checkuser-log' => 'varda ël registr dël controlor',
	'grouppage-checkuser' => "{{ns:project}}:Contròl dj'utent",
	'checkuser-reason' => 'Rason:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Smon ël registr',
	'checkuser-query' => "Anterogassion dj'ùltime modìfiche",
	'checkuser-target' => 'Adrëssa IP o nòm utent:',
	'checkuser-users' => "Tira sù j'utent",
	'checkuser-edits' => 'Oten-e le modìfiche',
	'checkuser-ips' => "Tiré sù j'adrësse IP",
	'checkuser-search' => 'Sërca',
	'checkuser-period' => 'Durà:',
	'checkuser-week-1' => 'ùltima sman-a',
	'checkuser-week-2' => 'ùltime doe sman-e',
	'checkuser-month' => 'ùltim 30 di',
	'checkuser-all' => 'tut',
	'checkuser-cidr-label' => "Treuva n'antërval comun e j'adrësse IP antëressà da na lista d'adrësse IP",
	'checkuser-cidr-res' => 'CIDR comun:',
	'checkuser-empty' => "Ës registr-sì a l'é veujd.",
	'checkuser-nomatch' => 'A-i é pa gnun-a ròba parej.',
	'checkuser-nomatch-edits' => "Gnun arzultà trovà.
L'ùltima modìfica a l'era ël $1 a $2.",
	'checkuser-check' => 'Contròl',
	'checkuser-log-fail' => 'I-i la fom nen a gionte-ie na riga ant sël registr',
	'checkuser-nolog' => "Pa gnun registr ch'a sia trovasse.",
	'checkuser-blocked' => 'Blocà',
	'checkuser-gblocked' => 'Blocà globalment',
	'checkuser-locked' => 'Sarà',
	'checkuser-wasblocked' => 'Blocà già prima',
	'checkuser-localonly' => 'Pa unificà',
	'checkuser-massblock' => "Blòca j'utent selessionà",
	'checkuser-massblock-text' => "Ij cont selessionà a saran blocà për sempe, con blocagi automàtich abilità e creassion ëd cont disabilità.
J'adrësse IP a saran blocà për 1 sman-a mach për j'adrësse IP e con creassion ëd cont disabilità.",
	'checkuser-blocktag' => 'Rimpiassa le pàgine utent con:',
	'checkuser-blocktag-talk' => 'Rimpiassa le pàgine ëd ciaciarada con:',
	'checkuser-massblock-commit' => "Blòca j'utent selessionà",
	'checkuser-block-success' => "'''{{PLURAL:$2|L'utent|J'utent}} $1 {{PLURAL:$2|a l'é|a son}} adess blocà.'''",
	'checkuser-block-failure' => "'''Pa gnun utent blocà.'''",
	'checkuser-block-limit' => 'Tròpi utent selessionà.',
	'checkuser-block-noreason' => 'It deve dé na rason për ij blocagi.',
	'checkuser-noreason' => 'It deve dé na rason për costa arcesta.',
	'checkuser-accounts' => '$1 neuv {{PLURAL:$1|cont|cont}}',
	'checkuser-too-many' => "Tròpi arzultà (scond la stima dl'arcesta), për piasì strenz ël CIDR.
Sì a-i son j'IP dovrà (5000 al pi, ordinà për adrëssa):",
	'checkuser-user-nonexistent' => "L'utent specificà a esist pa.",
	'checkuser-search-form' => "Treuva j'intrade dël registr andoa $1 a l'é $2",
	'checkuser-search-submit' => 'Serca',
	'checkuser-search-initiator' => 'inissiador',
	'checkuser-search-target' => 'obietiv',
	'checkuser-ipeditcount' => "~$1 da tùit j'utent",
	'checkuser-log-return' => "Torna a la forma prinsipal dël Controlor dj'utent",
	'checkuser-limited' => "'''Sti arzultà-sì a son ëstàit troncà për rason ëd prestassion.'''",
	'checkuser-log-userips' => "$1 a l'ha pijà j'adrësse IP da $2",
	'checkuser-log-ipedits' => "$1 a l'ha pijà le modìfiche për $2",
	'checkuser-log-ipusers' => "$1 a l'ha pijà j'utent për $2",
	'checkuser-log-ipedits-xff' => "$1 a l'ha pijà le modìfiche për XFF $2",
	'checkuser-log-ipusers-xff' => "$1 a l'ha pijà j'utent për XFF $2",
	'checkuser-log-useredits' => "$1 a l'ha otnù le modìfiche për $2",
	'checkuser-autocreate-action' => "a l'é stàit creà automaticament",
	'checkuser-create-action' => "a l'é stàit creà",
	'checkuser-email-action' => 'a l\'ha mandà un mëssagi ëd pòsta eletrònica a l\'utent "$1"',
	'checkuser-reset-action' => 'torna amposté la ciav për l\'utent "$1"',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'checkuser' => 'کره کتونکی کارن',
	'group-checkuser' => 'کره کتونکي کارنان',
	'group-checkuser-member' => '{{GENDER:$1|کره کتونکی کارن}}',
	'checkuser-reason' => 'سبب:',
	'checkuser-showlog' => 'يادښت کتل',
	'checkuser-target' => 'کارن يا IP پته:',
	'checkuser-users' => 'کارنان راغوښتل',
	'checkuser-ips' => 'آی پي پتې ترلاسه کول',
	'checkuser-search' => 'پلټل',
	'checkuser-period' => 'موده:',
	'checkuser-week-1' => 'تېره اوونۍ',
	'checkuser-week-2' => 'تېرې دوه اوونۍ',
	'checkuser-month' => 'تېرې ۳۰ ورځې',
	'checkuser-all' => 'ټول',
	'checkuser-check' => 'کره کتل',
	'checkuser-nolog' => 'يادښت دوتنه و نه موندل شوه.',
	'checkuser-blocked' => 'بنديز لګېدلی',
	'checkuser-gblocked' => 'نړېواله بنديز لګېدلی',
	'checkuser-locked' => 'تړل شوی',
	'checkuser-massblock' => 'په ټاکلو کارنانو بنديز لګول',
	'checkuser-blocktag-talk' => 'د خبرو اترو مخونه ځايناستول سره د:',
	'checkuser-massblock-commit' => 'په ټاکلو کارنانو بنديز لګول',
	'checkuser-block-success' => "'''دم مهال د $1 په {{PLURAL:$2|کارن|کارنانو}} {{PLURAL:$2|بنديز لګېدلی|بنديز لګېدلی}}.'''",
	'checkuser-block-failure' => "'''په هېڅ کارن بنديز پلي نشو.'''",
	'checkuser-block-limit' => 'له حد نه ډېر زيات کارنان ټاکل شوي.',
	'checkuser-block-noreason' => 'د بنديز لګولو لپاره بايد تاسې يو سبب څرګند کړی.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|نوی ګڼون|نوي ګڼونونه}}',
	'checkuser-search-submit' => 'پلټل',
	'checkuser-search-initiator' => 'پېلوونکی',
	'checkuser-search-target' => 'موخه',
	'checkuser-ipeditcount' => '~$1 د ټولو کارنانو نه',
	'checkuser-log-userips' => '$1 د $2 آی پي پتې ترلاسه کړې',
	'checkuser-autocreate-action' => 'په خپلکاره توګه جوړ شو',
	'checkuser-create-action' => 'جوړ شو',
	'checkuser-email-action' => 'د "$1" کارن ته يو برېښليک ولېږل شو',
	'checkuser-reset-action' => 'د "$1" کارن د پټنوم بيا پرځای کول',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Sir Lestaty de Lioncourt
 * @author Waldir
 */
$messages['pt'] = array(
	'checkuser-summary' => 'Esta ferramenta varre as mudanças recentes para obter os endereços IP de um utilizador ou para apresentar os dados de edições/utilizadores para um determinado IP.
Os utilizadores e edições de um determinado IP, podem ser obtidos através de cabeçalhos XFF, acrescentando "/xff" no final do endereço.
São suportados endereços IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128).
Por motivos de desempenho não serão fornecidas mais do que 5000 edições.
O uso desta ferramenta deverá respeitar as normas e recomendações.',
	'checkuser-desc' => 'Concede a utilizadores com a permissão apropriada a possibilidade de verificar os endereços IP de um utilizador e outra informação',
	'checkuser-logcase' => 'As buscas nos registos distinguem maiúsculas de minúsculas.',
	'checkuser' => 'Verificar utilizador',
	'checkuserlog' => 'Registos de verificação de utilizadores',
	'checkuser-contribs' => 'verificar IPs do utilizador',
	'group-checkuser' => 'CheckUser',
	'group-checkuser-member' => 'CheckUser',
	'right-checkuser' => 'Verificar o endereço IP de um utilizador e outras informações',
	'right-checkuser-log' => 'Ver o registo das verificações de utilizador',
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Motivo:',
	'checkuser-showlog' => 'Mostrar registos',
	'checkuser-query' => 'Examinar as Mudanças recentes',
	'checkuser-target' => 'Endereço IP ou nome do utilizador:',
	'checkuser-users' => 'Obter utilizadores',
	'checkuser-edits' => 'Obter edições',
	'checkuser-ips' => 'Obter IPs',
	'checkuser-search' => 'Pesquisar',
	'checkuser-period' => 'Duração:',
	'checkuser-week-1' => 'última semana',
	'checkuser-week-2' => 'últimas duas semanas',
	'checkuser-month' => 'últimos 30 dias',
	'checkuser-all' => 'todos',
	'checkuser-cidr-label' => 'Encontrar intervalo comum e endereços afetados para uma lista de IPs',
	'checkuser-cidr-res' => 'CIDR comum:',
	'checkuser-empty' => 'O registo não contém entradas.',
	'checkuser-nomatch' => 'Não foram encontrados resultados.',
	'checkuser-nomatch-edits' => 'Não foi encontrado nenhum resultado.
A última edição foi a $1 às $2.',
	'checkuser-check' => 'Verificar',
	'checkuser-log-fail' => 'Não foi possível adicionar entradas ao registo',
	'checkuser-nolog' => 'Não foi encontrado nenhum ficheiro de registos.',
	'checkuser-blocked' => 'Bloqueado',
	'checkuser-gblocked' => 'Bloqueado globalmente',
	'checkuser-locked' => 'Bloqueado',
	'checkuser-wasblocked' => 'Previamente bloqueado',
	'checkuser-localonly' => 'Não unificada',
	'checkuser-massblock' => 'Bloquear utilizadores seleccionados',
	'checkuser-massblock-text' => 'As contas seleccionadas serão bloqueadas indefinidamente, com o bloqueio automático activado e a criação de conta impossibilitada.
Endereços IP serão bloqueados por 1 semana com a criação de conta impossibilitada.',
	'checkuser-blocktag' => 'Substituir páginas de utilizador com:',
	'checkuser-blocktag-talk' => 'Substituir páginas de discussão por:',
	'checkuser-massblock-commit' => 'Bloquear utilizadores seleccionados',
	'checkuser-block-success' => "'''{{PLURAL:$2|O utilizador|Os utilizadores}} $1 {{PLURAL:$2|está|estão}} agora {{PLURAL:$2|bloqueado|bloqueados}}.'''",
	'checkuser-block-failure' => "'''Nenhum utilizador bloqueado.'''",
	'checkuser-block-limit' => 'Demasiados utilizadores selecionados.',
	'checkuser-block-noreason' => 'Tem de especificar um motivo para os bloqueios.',
	'checkuser-noreason' => 'Deverá fornecer um motivo para esta pesquisa.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nova conta|novas contas}}',
	'checkuser-too-many' => 'Há demasiados resultados (segundo estimativa da pesquisa); por favor, restrinja o CIDR.
Aqui estão os IPs usados (5000 no máx., ordenados por endereço):',
	'checkuser-user-nonexistent' => 'O utilizador especificado não existe.',
	'checkuser-search-form' => 'Procurar entradas no registo onde $1 seja $2',
	'checkuser-search-submit' => 'Procurar',
	'checkuser-search-initiator' => 'iniciador',
	'checkuser-search-target' => 'alvo',
	'checkuser-ipeditcount' => '~$1 de todos os utilizadores',
	'checkuser-log-return' => 'Retornar ao formulário principal de CheckUser',
	'checkuser-limited' => "'''Estes resultados foram removidos por motivos de performance.'''",
	'checkuser-log-userips' => '$1 obteve IPs de $2',
	'checkuser-log-ipedits' => '$1 obteve edições de $2',
	'checkuser-log-ipusers' => '$1 obteve utilizadores de $2',
	'checkuser-log-ipedits-xff' => '$1 obteve edições para o XFF $2',
	'checkuser-log-ipusers-xff' => '$1 obteve utilizadores para o XFF $2',
	'checkuser-log-useredits' => '$1 obteve edições de $2',
	'checkuser-autocreate-action' => 'foi criada automaticamente',
	'checkuser-create-action' => 'foi criada',
	'checkuser-email-action' => 'correio electrónico enviado para o utilizador "$1"',
	'checkuser-reset-action' => 'foi reiniciada a palavra-chave do utilizador "$1"',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 * @author Helder.wiki
 * @author Heldergeovane
 * @author Jesielt
 * @author Luckas Blade
 * @author Pedroca cerebral
 */
$messages['pt-br'] = array(
	'checkuser-summary' => 'Esta ferramenta varre as Mudanças recentes para obter os endereços de IP de um usuário ou para exibir os dados de edições/usuários para um IP.
Usuários e edições podem ser obtidos por um IP XFF colocando-se "/xff" no final do endereço. São suportados endereços IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128).
Não serão retornadas mais de 5000 edições por motivos de desempenho. O uso desta ferramenta deverá estar de acordo com as políticas.',
	'checkuser-desc' => 'Concede a usuários com a permissão apropriada a possibilidade de verificar os endereços IP de um usuário e outras informações',
	'checkuser-logcase' => 'As buscas nos registros são sensíveis a letras maiúsculas ou minúsculas.',
	'checkuser' => 'Verificar usuário',
	'checkuserlog' => 'Registros de verificação de usuários',
	'checkuser-contribs' => 'Verificar IPs do usuário',
	'group-checkuser' => 'CheckUser',
	'group-checkuser-member' => 'CheckUser',
	'right-checkuser' => 'Verificar os endereços de IP de um usuários e outras informações',
	'right-checkuser-log' => 'Ver os registros das verificações',
	'action-checkuser' => 'verificar os endereços IP do usuário e outras informações.',
	'action-checkuser-log' => 'Ver os registros das verificações',
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Motivo:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Exibir registros',
	'checkuser-query' => 'Examinar as Mudanças recentes',
	'checkuser-target' => 'Endereço IP ou nome do usuário:',
	'checkuser-users' => 'Obter usuários',
	'checkuser-edits' => 'Obter edições',
	'checkuser-ips' => 'Obter IPs',
	'checkuser-search' => 'Pesquisar',
	'checkuser-period' => 'Duração:',
	'checkuser-week-1' => 'última semana',
	'checkuser-week-2' => 'últimas duas semanas',
	'checkuser-month' => 'últimos 30 dias',
	'checkuser-all' => 'todos',
	'checkuser-cidr-label' => 'Encontrar intervalo comum e endereços afetados para uma lista de IPs',
	'checkuser-cidr-res' => 'CIDR comum:',
	'checkuser-empty' => 'O registro não contém ítens.',
	'checkuser-nomatch' => 'Não foram encontrados resultados.',
	'checkuser-nomatch-edits' => 'Nenhum resultado encontrado.
A última edição foi em $1 às $2.',
	'checkuser-check' => 'Verificar',
	'checkuser-log-fail' => 'Não foi possível adicionar entradas ao registro',
	'checkuser-nolog' => 'Não foi encontrado um arquivo de registros.',
	'checkuser-blocked' => 'Bloqueado',
	'checkuser-gblocked' => 'Bloqueado globalmente',
	'checkuser-locked' => 'Bloqueado',
	'checkuser-wasblocked' => 'Previamente bloqueado',
	'checkuser-localonly' => 'Não unificada',
	'checkuser-massblock' => 'Bloquear usuários selecionados',
	'checkuser-massblock-text' => 'As contas selecionadas serão bloqueadas indefinidamente, com bloqueio automático ativado e criação de conta desabilitada.
Endereços IP serão bloqueados por 1 semana com criação de conta desabilitada.',
	'checkuser-blocktag' => 'Substituir páginas de usuário com:',
	'checkuser-blocktag-talk' => 'Substituir páginas de discussão por:',
	'checkuser-massblock-commit' => 'Bloquear usuários selecionados',
	'checkuser-block-success' => "'''{{PLURAL:$2|O usuário|Os usuários}} $1 {{PLURAL:$2|está|estão}} agora {{PLURAL:$2|bloqueado|bloqueados}}.'''",
	'checkuser-block-failure' => "'''Nenhum usuário bloqueado.'''",
	'checkuser-block-limit' => 'Muitos usuários selecionados.',
	'checkuser-block-noreason' => 'Você deve especificar um motivo para os bloqueios.',
	'checkuser-noreason' => 'Você deve fornecer um motivo para esta pesquisa.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nova conta|novas contas}}',
	'checkuser-too-many' => 'Há muitos resultados; por favor, restrinja o CIDR. Aqui estão os IPs usados (5000 no máx., ordenados por endereço):',
	'checkuser-user-nonexistent' => 'O usuário especificado não existe.',
	'checkuser-search-form' => 'Procurar entradas no registo onde $1 seja $2',
	'checkuser-search-submit' => 'Pesquisar',
	'checkuser-search-initiator' => 'iniciador',
	'checkuser-search-target' => 'alvo',
	'checkuser-ipeditcount' => '~$1 de todos os usuários',
	'checkuser-log-return' => 'Retornar ao formulário principal de CheckUser',
	'checkuser-limited' => "'''Estes resultados foram removidos por motivos de performance.'''",
	'checkuser-log-userips' => '$1 obteve IPs de $2',
	'checkuser-log-ipedits' => '$1 obteve edições de $2',
	'checkuser-log-ipusers' => '$1 obteve usuários de $2',
	'checkuser-log-ipedits-xff' => '$1 obteve edições para o XFF $2',
	'checkuser-log-ipusers-xff' => '$1 obteve usuários para o XFF $2',
	'checkuser-log-useredits' => '$1 obteve edições de $2',
	'checkuser-autocreate-action' => 'foi automaticamente criada',
	'checkuser-create-action' => 'foi criada',
	'checkuser-email-action' => 'Enviar email para o usuário "$1"',
	'checkuser-reset-action' => 'suprimir a senha do usuário "$1"',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'checkuser-summary' => "Kay llamk'anaqa ñaqha hukchasqakunapim maskaykun huk ruraqpa llamk'achisqan IP huchhakunata chaskinapaq icha huk IP huchhap llamk'apusqamanta/ruraqmanta willankunata rikuchinapaq.
Ruraqkunata icha mink'akuq IP huchhap rurasqankunatapas XFF uma siq'iwanmi chaskiyta atinki IP huchhata \"/xff\" nisqawan yapaspa. IPv4 (CIDR 16-32), IPv6 (CIDR 64-128) nisqakunam llamk'akun.
Pichqa waranqamanta aswan llamk'apusqakunaqa manam kutimunqachu, allin rikuchinarayku. Kay llamk'anataqa kawpayllakama rurachiy.",
	'checkuser-logcase' => "Hallch'a maskaqqa hatun sananchata uchuy sananchamantam sapaqchan.",
	'checkuser' => 'Ruraqta llanchiy',
	'checkuserlog' => "Ruraq llanchiy hallch'a",
	'group-checkuser' => 'Ruraqkunata llanchiy',
	'group-checkuser-member' => '{{GENDER:$1|}}Ruraqta llanchiy',
	'grouppage-checkuser' => '{{ns:project}}:Ruraqta llanchiy',
	'checkuser-reason' => 'Kayrayku:',
	'checkuser-showlog' => "Hallch'ata rikuchiy",
	'checkuser-query' => 'Ñaqha hukchasqakunapi maskay',
	'checkuser-target' => 'IP huchha icha ruraqpa sutin:',
	'checkuser-users' => 'Ruraqkunata chaskiy',
	'checkuser-edits' => "Llamk'apusqakunata chaskiy",
	'checkuser-ips' => 'IP huchhakunata chaskiy',
	'checkuser-search' => 'Maskay',
	'checkuser-period' => "Kay mit'alla:",
	'checkuser-week-1' => 'qayna simana',
	'checkuser-week-2' => 'qayna iskay simana',
	'checkuser-month' => "qayna kimsa chunka p'unchaw",
	'checkuser-all' => 'tukuy',
	'checkuser-empty' => "Manam kanchu ima hallch'asqapas.",
	'checkuser-nomatch' => 'Manam imapas taripasqachu.',
	'checkuser-check' => 'Llanchiy',
	'checkuser-log-fail' => "Manam atinichu hallch'aman yapayta",
	'checkuser-nolog' => "Manam hallch'ayta tarinichu",
	'checkuser-blocked' => "Hark'asqa",
	'checkuser-gblocked' => "Sapsintinpi hark'asqa",
	'checkuser-locked' => "Wichq'asqa",
	'checkuser-wasblocked' => "Ñawpaqta hark'asqa",
	'checkuser-localonly' => 'Manam hukllasqachu',
	'checkuser-massblock' => "Akllasqa ruraqkunata hark'ay",
	'checkuser-too-many' => "Nisyum tarisqakuna (chhikaynasqakama), ama hina kaspa CIDR nisqata k'ichkichay. Kaymi llamk'achisqa IP huchhakuna (5000-kama, tiyay sutikama siq'inchasqa):",
	'checkuser-user-nonexistent' => 'Nisqayki ruraqqa manam kanchu.',
	'checkuser-search-submit' => 'Maskay',
	'checkuser-search-initiator' => 'qallarichiq',
	'checkuser-search-target' => 'taripana',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'checkuser-search' => 'Tarzzut',
	'checkuser-search-submit' => 'Tarzzut',
);

/** Romansh (Rumantsch)
 * @author Gion-andri
 */
$messages['rm'] = array(
	'checkuser-reason' => 'Motiv:',
	'checkuser-showlog' => 'Mussar il log',
	'checkuser-target' => "Adressa IP u num d'utilisader:",
	'checkuser-search' => 'Tschertgar',
);

/** Romanian (Română)
 * @author AdiJapan
 * @author Emily
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Memo18
 * @author Mihai
 * @author Minisarm
 */
$messages['ro'] = array(
	'checkuser-summary' => 'Acestă unealtă scanează schimbările recente pentru a regăsi IP-urile folosite de un utilizator sau arată modificările/utilizator pentru un anumit IP.
Utilizatorii și modificările efectuate de un client IP pot fi regăsite prin antetele XFF atașând IP-ul prin intermediul "/xff". IPv4 (CIDR 16-32) și IPv6 (CIDR 64-128) sunt suportate.
Nu mai mult de 5000 de editări vor fi întoarse din motive de performanță.
Folosește unealta în concordanță cu politica sitului.',
	'checkuser-desc' => 'Autorizează utilizatorii cu drepturile specifice să poată verifica adresele IP și alte informații',
	'checkuser-logcase' => 'Căutarea în jurnal este sensibilă la majuscule - minuscule',
	'checkuser' => 'Verifică utilizatorul',
	'checkuserlog' => 'Jurnal verificare utilizator',
	'checkuser-contribs' => 'verifică IP-urile utilizatorilor',
	'group-checkuser' => 'Checkuseri',
	'group-checkuser-member' => '{{GENDER:$1|checkuser}}',
	'right-checkuser' => 'Verifică adresele IP ale utilizatorilor și alte informații',
	'right-checkuser-log' => 'Vezi jurnalul checkuser',
	'action-checkuser' => 'verifică adresa IP a utilizatorului și alte informații',
	'action-checkuser-log' => 'vizualizează jurnalul checkuser',
	'grouppage-checkuser' => '{{ns:project}}:Checkuser',
	'checkuser-reason' => 'Motiv:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Arată jurnal',
	'checkuser-query' => 'Interoghează schimbările recente',
	'checkuser-target' => 'Adresă IP sau nume de utilizator:',
	'checkuser-users' => 'Arată utilizatorii',
	'checkuser-edits' => 'Arată editările',
	'checkuser-ips' => 'Arată IP-urile',
	'checkuser-search' => 'Caută',
	'checkuser-period' => 'Durată:',
	'checkuser-week-1' => 'săptămâna trecută',
	'checkuser-week-2' => 'ultimele două săptămâni',
	'checkuser-month' => 'ultimele 30 de zile',
	'checkuser-all' => 'toate',
	'checkuser-cidr-label' => 'Găsește o serie comună și adresele afectate pentru o listă de adrese IP',
	'checkuser-cidr-res' => 'CIDR comun:',
	'checkuser-empty' => 'Jurnalul nu conține înregistrări.',
	'checkuser-nomatch' => 'Nu au fost găsite potriviri.',
	'checkuser-nomatch-edits' => 'Niciun rezultat.
Ultima modificare a fost efectuată pe $1 la ora $2.',
	'checkuser-check' => 'Verifică',
	'checkuser-log-fail' => 'Imposibil de adăugat intrări în jurnal',
	'checkuser-nolog' => 'Nu a fost găsit un jurnal.',
	'checkuser-blocked' => 'Blocat',
	'checkuser-gblocked' => 'Blocat global',
	'checkuser-locked' => 'Blocat',
	'checkuser-wasblocked' => 'Blocări anterioare',
	'checkuser-localonly' => 'Neunificat',
	'checkuser-massblock' => 'Blochează utilizatorii aleși',
	'checkuser-massblock-text' => 'Conturile alese vor fi blocate definitiv, cu blocarea automată activată și crearea de conturi dezactivată.
Adresele IP vor fi blocate timp de o săptămână și crearea de conturi va fi dezactivată.',
	'checkuser-blocktag' => 'Înlocuiește paginile de utilizator cu:',
	'checkuser-blocktag-talk' => 'Înlocuiește paginile de discuții cu:',
	'checkuser-massblock-commit' => 'Blochează utilizatorii aleși',
	'checkuser-block-success' => "'''{{PLURAL:$2|Utilizatorul|Utilizatorii}} $1 {{PLURAL:$2|este blocat|sunt blocați}}.'''",
	'checkuser-block-failure' => "'''Niciun utilizator nu este blocat.'''",
	'checkuser-block-limit' => 'Prea mulți utilizatori selectați.',
	'checkuser-block-noreason' => 'Trebuie să specificați un motiv pentru blocări.',
	'checkuser-noreason' => 'Trebuie să specifici un motiv pentru această interogare.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|cont nou|conturi noi}}',
	'checkuser-too-many' => 'Prea multe rezultate (după estimarea interogării), vă rugăm să limitați CIDR.
Iată IP-urile folosite (maxim 5000, sortate după adresă):',
	'checkuser-user-nonexistent' => 'Utilizatorul specificat nu există.',
	'checkuser-search-form' => 'Găsește intrările în jurnal unde $1 este $2',
	'checkuser-search-submit' => 'Caută',
	'checkuser-search-initiator' => 'inițiator',
	'checkuser-search-target' => 'destinație',
	'checkuser-ipeditcount' => '~$1 de la toți utilizatorii',
	'checkuser-log-return' => 'Revenire la formularul principal Verifică Utilizatorul',
	'checkuser-limited' => "'''Aceste rezultate au fost sortate din motive de performanță.'''",
	'checkuser-log-userips' => '$1 a verificat IP-urile lui $2',
	'checkuser-log-ipedits' => '$1 a verificat modificările efectuate de $2',
	'checkuser-log-ipusers' => '$1 a verificat conturile lui $2',
	'checkuser-log-ipedits-xff' => '$1 a verificat modificările efectuate de la adresa XFF $2',
	'checkuser-log-ipusers-xff' => '$1 a verificat conturile lui XFF $2',
	'checkuser-log-useredits' => '$1 a verificat modificările efectuate de $2',
	'checkuser-autocreate-action' => 'a fost creat automat',
	'checkuser-create-action' => 'a fost creat',
	'checkuser-email-action' => 'trimite email utilizatorului "$1"',
	'checkuser-reset-action' => 'schimbă parola pentru utilizatorul "$1"',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 * @author Reder
 */
$messages['roa-tara'] = array(
	'checkuser-summary' => "'Stù strumènde condrolle le cangiaminde recende pe' recuperà le 'nderizze IP ausate da 'nu utinde o pe' mostrà le date cangiaminde/utinde dape' 'nu inderizze IP.
Le utinde e le cangiaminde pòtene essere recuperate da 'nu inderizze IP d'u client ausanne l'indestazione XFF sckaffanne a le 'nderizze IP \"/xff\". IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128) sonde supportate.
No cchiù de 5,000 cangiaminde honne a essere restituite pe' motive de prestazione.
Ause quiste d'accorde c'a polìteche.",
	'checkuser-desc' => "Congede a le utinde cu l'autorizzazzione appropriate 'a capacetata de condrollà le 'nderizze IP de l'utinde e otre 'mbormazzione",
	'checkuser-logcase' => "L'archivije de ricerche jè sensibbele a le maiuscole e minuscole.",
	'checkuser' => 'Utende verificatore',
	'checkuserlog' => 'Archivije de le CheckUser',
	'checkuser-contribs' => "condrolle le 'nderizze IP de le utinde",
	'group-checkuser' => 'Utinde verificature',
	'group-checkuser-member' => '{{GENDER:$1|utende verificatore}}',
	'right-checkuser' => "Condrolle le 'nderizze IP de le utinde e otre 'mbormazziune",
	'right-checkuser-log' => "Vide l'archivije de le checkuser",
	'action-checkuser' => "Condrolle le 'nderizze IP de le utinde e otre 'mbormazziune",
	'action-checkuser-log' => "Vide 'u registre de le checkuser",
	'grouppage-checkuser' => '{{ns:project}}:Utende ca verifiche',
	'checkuser-reason' => 'Mutive:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => "Fà vedè l'archivije",
	'checkuser-query' => "Inderroghe l'urteme cangiaminde",
	'checkuser-target' => 'Indirizze IP o utende:',
	'checkuser-users' => "Pigghje l'utende",
	'checkuser-edits' => 'Pigghje le cangiaminde',
	'checkuser-ips' => "Pigghje l'IP",
	'checkuser-search' => 'Cirche',
	'checkuser-period' => 'Durete:',
	'checkuser-week-1' => 'urtema sumane',
	'checkuser-week-2' => 'urteme doje sumane',
	'checkuser-month' => 'urteme 30 giurne',
	'checkuser-all' => 'tutte',
	'checkuser-cidr-label' => "Acchije 'na gamme comune e l'IP colpite pe' 'nu elenghe de inderizze IP",
	'checkuser-cidr-res' => 'CIDR Comune:',
	'checkuser-empty' => "L'archivije non ge condène eleminde.",
	'checkuser-nomatch' => "Non g'agghie acchiate ninde.",
	'checkuser-nomatch-edits' => "Non g'agghie acchiate ninde.<br />
L'urteme cangiamende ha state fatte 'u $1 a le $2.",
	'checkuser-check' => 'Verifiche',
	'checkuser-log-fail' => "'Mbossibbele aggiungiere 'a vôsce d'u reggistre",
	'checkuser-nolog' => 'Nisciune archivije de file acchiate.',
	'checkuser-blocked' => 'Bloccate',
	'checkuser-gblocked' => 'Bloccate globbalmende',
	'checkuser-locked' => 'Bloccate',
	'checkuser-wasblocked' => 'Bloccate precedendemende',
	'checkuser-localonly' => 'Non unificate',
	'checkuser-massblock' => "Bluecche l'utinde scacchiate",
	'checkuser-massblock-text' => "Le cunde utinde scacchiate honne a essere bloccate pe' 'nu timbe 'ndeterminate, c'u blocche automateche de le inderizze IP e 'a ccrejàzione cunde utinde desattevate.
Le inderizze IP honne a essere bloccate pe' 'na sumáne sule pe' l'utinde anonime e 'a ccrejàzione cunde utinde ha ddà esere desattevate.",
	'checkuser-blocktag' => 'Sostituisce le pàggene utinde cu:',
	'checkuser-blocktag-talk' => "Sostituisce le pàggene de le 'ngazzaminde cu:",
	'checkuser-massblock-commit' => "Bluecche l'utinde scacchiate",
	'checkuser-block-success' => "'''L'{{PLURAL:$2|utende|utinde}} $1 {{PLURAL:$2|è|sonde}} bloccate.'''",
	'checkuser-block-failure' => "'''Nisciune utende blccate.'''",
	'checkuser-block-limit' => 'Troppe utinde scacchiate.',
	'checkuser-block-noreason' => "Tu à dà 'nu mutive pe le blocche.",
	'checkuser-noreason' => "Tu à dà 'nu mutive pe st'inderrogazione.",
	'checkuser-accounts' => '$1 {{PLURAL:$1|cunde utende|cunde utinde}} nuève',
	'checkuser-too-many' => "Ce stonne assaje resultate (seconne 'a stime fatte), pe' piacere restringe 'u CIDR.
Aqquà ce stonne le IP ausate (5000 masseme, ordenate pe' inderizze):",
	'checkuser-user-nonexistent' => "L'utende specificate non g'esiste.",
	'checkuser-search-form' => "Acchie le vôsce d'u reggistre addò $1 jè $2",
	'checkuser-search-submit' => 'Cirche',
	'checkuser-search-initiator' => 'iniziatore',
	'checkuser-search-target' => 'destinazione',
	'checkuser-ipeditcount' => "~$1 da tutte l'utinde",
	'checkuser-log-return' => "Tuèrne a 'u module prengepale de CheckUser",
	'checkuser-limited' => "'''Chiste resultate onne state tagghiate pe mutive de performance.'''",
	'checkuser-log-userips' => '$1 ha pigghiete le IP pe $2',
	'checkuser-log-ipedits' => '$1 ha pigghiete le cangiaminde pe $2',
	'checkuser-log-ipusers' => '$1 ha pigghiete le utinde pe $2',
	'checkuser-log-ipedits-xff' => '$1 ha pigghiete le cangiaminde pe XFF $2',
	'checkuser-log-ipusers-xff' => '$1 ha pigghiete le utinde pe XFF $2',
	'checkuser-log-useredits' => '$1 ha pigghiete le cangiaminde pe $2',
	'checkuser-autocreate-action' => 'ha state ccrejete automaticamende',
	'checkuser-create-action' => 'ha state ccrejate',
	'checkuser-email-action' => 'mannate \'na mail a l\'utende "$1"',
	'checkuser-reset-action' => 'azzere \'a password pe l\'utende "$1"',
);

/** Russian (Русский)
 * @author DCamer
 * @author EugeneZelenko
 * @author Ferrer
 * @author Ilya Voyager
 * @author Kaganer
 * @author Kv75
 * @author Lockal
 * @author Ole Yves
 * @author Prima klasy4na
 * @author Putnik
 * @author Silence
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'checkuser-summary' => "Данный инструмент может быть использован, чтобы получить IP-адреса, использовавшиеся участником, либо чтобы показать правки/участников, работавших с IP-адреса.
Правки и пользователи, которые правили с определённого IP-адреса, указанного в X-Forwarded-For, можно получить, добавив постфикс <code>/xff</code> к IP-адресу. Поддерживаемые версии IP: 4 (CIDR 16—32) и 6 (CIDR 64—128).
Из соображений производительности будут показаны только первые 5000 правок.
Используйте эту страницу '''только в соответствии с правилами'''.",
	'checkuser-desc' => 'Предоставляет возможность проверять IP-адреса и дополнительную информацию участников',
	'checkuser-logcase' => 'Поиск по журналу чувствителен к регистру.',
	'checkuser' => 'Проверить участника',
	'checkuserlog' => 'Журнал проверки участников',
	'checkuser-contribs' => 'проверить IP-адреса участника',
	'group-checkuser' => 'Проверяющие участников',
	'group-checkuser-member' => '{{GENDER:$1|проверяющий участников|проверяющая участников}}',
	'right-checkuser' => 'проверка IP-адресов и другой информации об участниках',
	'right-checkuser-log' => 'просмотр журнала проверки участников',
	'action-checkuser' => 'проверка IP-адресов и другой информации об участниках',
	'action-checkuser-log' => 'просмотр журнала проверки участников',
	'grouppage-checkuser' => '{{ns:project}}:Проверка участников',
	'checkuser-reason' => 'Причина:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Показать журнал',
	'checkuser-query' => 'Запросить свежие правки',
	'checkuser-target' => 'IP-адрес или имя участника:',
	'checkuser-users' => 'Получить участников',
	'checkuser-edits' => 'Получить правки',
	'checkuser-ips' => 'Запросить IP-адреса',
	'checkuser-search' => 'Найти',
	'checkuser-period' => 'Длительность:',
	'checkuser-week-1' => 'последняя неделя',
	'checkuser-week-2' => 'последние две недели',
	'checkuser-month' => 'последние 30 дней',
	'checkuser-all' => 'все',
	'checkuser-cidr-label' => 'Найти общий диапазон и затрагиваемые адреса для списка IP',
	'checkuser-cidr-res' => 'Общая CIDR:',
	'checkuser-empty' => 'Журнал пуст.',
	'checkuser-nomatch' => 'Совпадений не найдено.',
	'checkuser-nomatch-edits' => 'Совпадений не найдено.
Последняя правка сделана $1 в $2.',
	'checkuser-check' => 'Проверить',
	'checkuser-log-fail' => 'Невозможно добавить запись в журнал',
	'checkuser-nolog' => 'Файл журнала не найден.',
	'checkuser-blocked' => 'Заблокирован',
	'checkuser-gblocked' => 'Заблокирован глобально',
	'checkuser-locked' => 'Заблокирован',
	'checkuser-wasblocked' => 'Подвергался блокировке',
	'checkuser-localonly' => 'Не глобальная',
	'checkuser-massblock' => 'Заблокировать выбранных участников',
	'checkuser-massblock-text' => 'Выбранные учётные записи будут заблокированы бессрочно с автоблокировкой и запретом создания новых учётных записей.
IP-адреса будут заблокированы на 1 неделю для непредставившихся участников, будет включён запрет на создание учётных записей.',
	'checkuser-blocktag' => 'Заменить страницы участников на:',
	'checkuser-blocktag-talk' => 'Заменить страницы обсуждения на:',
	'checkuser-massblock-commit' => 'Заблокировать выбранных участников',
	'checkuser-block-success' => "'''Сейчас {{PLURAL:$2|заблокирован $1 участник|заблокированы $1 участника|заблокированы $1 участников}}.'''",
	'checkuser-block-failure' => "'''Нет заблокированных участников.'''",
	'checkuser-block-limit' => 'Выбрано слишком много участников.',
	'checkuser-block-noreason' => 'Вы должны указать причину блокировок.',
	'checkuser-noreason' => 'Вы должны указать причину для этого запроса.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|новая учётная запись|новых учётных записи|новых учётных записей}}',
	'checkuser-too-many' => 'Слишком много результатов (согласно оценке запроса), пожалуйста, сузьте CIDR.
Использованные IP (максимум 5000, отсортировано по адресу):',
	'checkuser-user-nonexistent' => 'Указанного участника не существует',
	'checkuser-search-form' => 'Найти записи журнала, где $1 является $2',
	'checkuser-search-submit' => 'Найти',
	'checkuser-search-initiator' => 'инициатор',
	'checkuser-search-target' => 'цель',
	'checkuser-ipeditcount' => '~$1 от всех участников',
	'checkuser-log-return' => 'Возврат к странице проверки участников',
	'checkuser-limited' => "'''Результаты были усечены чтобы не создавать дополнительной нагрузки на сервер.'''",
	'checkuser-log-userips' => '$1 получил IP адреса для $2',
	'checkuser-log-ipedits' => '$1 получил правки для $2',
	'checkuser-log-ipusers' => '$1 получил учётные записи для $2',
	'checkuser-log-ipedits-xff' => '$1 получил правки для XFF $2',
	'checkuser-log-ipusers-xff' => '$1 получил учётные записи для XFF $2',
	'checkuser-log-useredits' => '$1 получил правки $2',
	'checkuser-autocreate-action' => 'был создан автоматически',
	'checkuser-create-action' => 'создан',
	'checkuser-email-action' => 'отправил письмо участнику «$1»',
	'checkuser-reset-action' => 'сбросил пароль для участника $1',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'checkuser-summary' => 'Тот інштрумент бадать послїднї зміны і уможнює здобыти IP адресы хоснователїв або указати едітованя і хоснователя з даной  IP адресы.
Хоснователї і едітованя з кліентской IP адресы ся дають здобыти з головок XFF приданём „/xff“ ку IP. Є підпороване IPv4 (CIDR 16–32) і IPv6 (CIDR 64–128).
З огляду на выкон ся дасть указати максімално 5000 едітовань. Хоснуйте тот інштрумент в згодї з правилами.',
	'checkuser-desc' => 'Додавать хоснователям з одповідаючіма правами можность здобывати IP адресы хоснователїв і далшы повязаны інформації',
	'checkuser-logcase' => 'Гляданя в записах чутливе на великость букв.',
	'checkuser' => 'Перевірити хоснователя',
	'checkuserlog' => 'Лоґ перевіркы хоснователїв',
	'checkuser-contribs' => 'перевірити IP адресы хоснователя',
	'group-checkuser' => 'Ревізоры',
	'group-checkuser-member' => 'Ревізор',
	'right-checkuser' => 'Перевірка хосновательской IP адресы і далшых інформацій',
	'right-checkuser-log' => 'Перегляд лоґу перевіркы хоснователїв',
	'grouppage-checkuser' => '{{ns:project}}:Перевірка хоснователїв',
	'checkuser-reason' => 'Причіна:',
	'checkuser-showlog' => 'Указати лоґ',
	'checkuser-query' => 'Перезерати послїднї зміны',
	'checkuser-target' => 'IP-адреса або імя хоснователя:',
	'checkuser-users' => 'Найти хоснователїв',
	'checkuser-edits' => 'Найти едітованя',
	'checkuser-ips' => 'Найти IP адресы',
	'checkuser-search' => 'Найти',
	'checkuser-period' => 'Тырваня:',
	'checkuser-week-1' => 'послїднїй тыждень',
	'checkuser-week-2' => 'остатнї два тыжднї',
	'checkuser-month' => 'остатнїх 30 днїв',
	'checkuser-all' => 'вшыткы',
	'checkuser-cidr-label' => 'Здобытя сполочного россягу із списку IP адрес',
	'checkuser-cidr-res' => 'Сполочный CIDR:',
	'checkuser-empty' => 'Лоґ не обсягує жадны положкы.',
	'checkuser-nomatch' => 'Згода ненайджена.',
	'checkuser-nomatch-edits' => 'Згода ненайджена.
Остатнє едітованя зроблене $1 о $2.',
	'checkuser-check' => 'Перевірити',
	'checkuser-log-fail' => 'Не подарило ся записати до лоґу',
	'checkuser-nolog' => 'Файл лоґованя ся не нашов.',
	'checkuser-blocked' => 'Заблокованый',
	'checkuser-gblocked' => 'Заблокованый ґлобално',
	'checkuser-locked' => 'Замкнуто',
	'checkuser-wasblocked' => 'Скоре блокованый',
	'checkuser-localonly' => 'Незъєдноченый',
	'checkuser-massblock' => 'Заблоковати выбраных хоснователїв',
	'checkuser-massblock-text' => 'Выбраны конта будуть заблокованы до одволаня із запнутым автоматічным блокованём і заказом створёваня новых конт. IP адресы будуть заблокованы на тыждень, лем про нереґістрованых хоснователїв і із заказом створёваня новых конт.',
	'checkuser-blocktag' => 'Замінити сторінкы хоснователїв на:',
	'checkuser-blocktag-talk' => 'Замінити сторінкы діскузії на:',
	'checkuser-massblock-commit' => 'Заблоковати выбраных хоснователїв',
	'checkuser-block-success' => "'''{{PLURAL:$2|Хоснователь|Хоснователї}} $1 {{PLURAL:$2|є заблокованый|суть заблокованы}}.'''",
	'checkuser-block-failure' => "'''Жаден хоснователь не быв заблокованый.'''",
	'checkuser-block-limit' => 'Выбрано дуже много хоснователїв.',
	'checkuser-block-noreason' => 'Мусите задати причіну блокованя.',
	'checkuser-noreason' => 'Ку тому запыту мусите увести причіну.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|нове конто|новы конта|новых конт}}',
	'checkuser-too-many' => 'Дуже много резултатів (подля оцінкы пожадавкы), спробуйте обмеджіти CIDR.
Ниже суть хоснованы IP адресы (найвеце 5000, сортованы подля адресы):',
	'checkuser-user-nonexistent' => 'Зазначеный хоснователь не єствує.',
	'checkuser-search-form' => 'Глядай записы, де $1 є $2',
	'checkuser-search-submit' => 'Глядати',
	'checkuser-search-initiator' => 'ініціатор',
	'checkuser-search-target' => 'ціль',
	'checkuser-ipeditcount' => 'асі $1 од вшыткых хоснователїв',
	'checkuser-log-return' => 'Навернутя на головный формуларь Перевіркы хоснователя',
	'checkuser-limited' => "'''Резултаты были з выконостных причін скорочены.'''",
	'checkuser-log-userips' => '$1 обтримав IP адресы про $2',
	'checkuser-log-ipedits' => '$1 отбримав едітованя про $2',
	'checkuser-log-ipusers' => '$1 обтримав конта про $2',
	'checkuser-log-ipedits-xff' => '$1 обтримав едітованя про XFF $2',
	'checkuser-log-ipusers-xff' => '$1 обтримав конта про XFF $2',
	'checkuser-log-useredits' => '$1 обтримав едітованя про $2',
	'checkuser-autocreate-action' => 'створеный автоматічно',
	'checkuser-create-action' => 'створено',
	'checkuser-email-action' => 'послав ел. пошту хоснователёві „$1“',
	'checkuser-reset-action' => 'пожадав о нове гесло про хоснователя $1',
);

/** Aromanian (Armãneashce)
 * @author Hakka
 */
$messages['rup'] = array(
	'checkuser-reason' => 'Itia:',
	'checkuser-search' => 'Caftã',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'checkuser-reason' => 'कारणम् :',
	'checkuser-search' => 'अन्वेषणम्',
	'checkuser-all' => 'सर्वाणि',
	'checkuser-search-submit' => 'अन्वेषणम्',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'checkuser-summary' => "Бу үстүрүмүөнү кыттааччы IP-ларын көрөргө, эбэтэр IP-аадырыһы туһаммыт хас да кыттааччы уларытыыларын көрөргө туттуохха сөп.
Биир IP-аадырыстан оҥоһуллубут көннөрүүлэри, эбэтэр ону туһаммыт X-Forwarded-For ыйыллыбыт кыттааччылары көрөргө, бу префиксы IP-га туруоран биэр: <code>/xff</code>. Поддерживаемые версии IP: 4 (CIDR 16—32) и 6 (CIDR 64—128).
Систиэмэни ноҕуруускалаамаары бастакы 5000 көннөрүү эрэ көрдөрүллүөҕэ. Бу сирэйи '''сиэрдээхтик''' тутун.",
	'checkuser-desc' => 'Кыттаачылар IP-ларын уонна кинилэр тустарынан атын сибидиэнньэлэри көрөр кыаҕы биэрии.',
	'checkuser-logcase' => 'Сурунаалга көрдөөһүн улахан/кыра буукубалары араарар.',
	'checkuser' => 'Кыттааччыны бэрэбиэркэлээ',
	'checkuserlog' => 'Кыттаачылары бэрэбиэркэлээһин сурунаала',
	'checkuser-contribs' => 'кыттааччы IP-тын тургутуу',
	'group-checkuser' => 'Кыттааччылары бэрэбиэркэлээччилэр',
	'group-checkuser-member' => 'Кыттааччылары бэрэбиэркэлээччи',
	'right-checkuser' => 'Кыттааччылар IP-ларын уонна атын сибидиэнньэлэрин тургутуу',
	'right-checkuser-log' => 'Кыттаачылары тургутуу сурунаалын көрүү',
	'grouppage-checkuser' => '{{ns:project}}:Кыттааччылары бэрэбиэркэлээһин',
	'checkuser-reason' => 'Төрүөтэ:',
	'checkuser-showlog' => 'Сурунаалы көрдөр',
	'checkuser-query' => 'Саҥа көннөрүүлэри көрдөр',
	'checkuser-target' => 'Кыттааччы аата эбэтэр IP-та',
	'checkuser-users' => 'Кыттаачылары ыларга',
	'checkuser-edits' => 'Көннөрүүлэри көрүү',
	'checkuser-ips' => 'IP-лары көрдөр',
	'checkuser-search' => 'Көрдөө',
	'checkuser-period' => 'Уһуна:',
	'checkuser-week-1' => 'бүтэһик нэдиэлэ',
	'checkuser-week-2' => 'бүтэһик икки нэдиэлэ',
	'checkuser-month' => 'бүтэһик 30 хонук',
	'checkuser-all' => 'барыта',
	'checkuser-cidr-label' => 'IP тиһигин уопсай диапазонун уонна таарыллар аадырыстарын булуу',
	'checkuser-cidr-res' => 'Уопсай CIDR:',
	'checkuser-empty' => 'Сурунаал кураанах',
	'checkuser-nomatch' => 'Сөп түбэһиилэр көстүбэтилэр',
	'checkuser-nomatch-edits' => 'Сөп түбэһии көстубэтэ.
Бүтэһик көннөрүү $1, $2 оҥоһуллубут.',
	'checkuser-check' => 'Бэрэбиэркэлээ',
	'checkuser-log-fail' => 'Сурунаалга сурук эбэр табыллыбат(а)',
	'checkuser-nolog' => 'Сурунаал билэтэ көстүбэтэ',
	'checkuser-blocked' => 'Тугу эмэ гынара бобуллубут',
	'checkuser-gblocked' => 'Төгүрүччү хааччахтаммыт',
	'checkuser-locked' => 'Эбии кыахтара сабыллыбыт',
	'checkuser-wasblocked' => 'Урут бобуллубут',
	'checkuser-localonly' => 'Биирдэһиллибит аан аат буолбатах',
	'checkuser-massblock' => 'Талыллыбыт кыттааччылары боп',
	'checkuser-massblock-text' => 'Талыллыбыт ааттар болдьоҕо суох бобуллуохтара. Бу ааттар аптамаатынан бобуллуохтара, маннык ааты саҥаттан оҥоруу эмиэ бобуллуо.
IP-аадырыстартан бэлиэтэммэккэ киирии уонна саҥа ааты оҥоруу 1 нэдиэлэҕэ бобуллуо.',
	'checkuser-blocktag' => 'Кыттааччылар сирэйдэрин манныкка уларыт:',
	'checkuser-blocktag-talk' => 'Ырытыы сирэйдэрин манныкка уларыт:',
	'checkuser-massblock-commit' => 'Талыллыбыт кыттааччылары боп',
	'checkuser-block-success' => "'''Билигин {{PLURAL:$2|$1 кыттааччы бобуллубут|$1 кыттааччы бобуллубут}}.'''",
	'checkuser-block-failure' => "'''Бобуллубут кыттааччы суох.'''",
	'checkuser-block-limit' => 'Наһаа элбэх киһини талбыккын',
	'checkuser-block-noreason' => 'Бобуу төрүөтүн этиэхтээххин.',
	'checkuser-noreason' => 'Бу ыйытык төрүөтүн ааттыахтааххын.',
	'checkuser-accounts' => '$1 саҥа {{PLURAL:$1|аат|ааттар}}',
	'checkuser-too-many' => 'Наһаа элбэх булулунна (көрдөбүл түмүгүнэн), бука диэн CIDR кыччатан биэр. 
Туһаныллыбыт IP (саамай элбэҕэ 5000, бу аадырыһынан наардаммыт):',
	'checkuser-user-nonexistent' => 'Маннык ааттаах кыттааччы суох',
	'checkuser-search-form' => '$1 сурунаалга $2 буоларын бул',
	'checkuser-search-submit' => 'Буларга',
	'checkuser-search-initiator' => 'саҕалааччы',
	'checkuser-search-target' => 'сыал-сорук',
	'checkuser-ipeditcount' => '~$1 бары кыттааччылартан',
	'checkuser-log-return' => 'Кытааччылары бэрэбиэркэлээһин сүрүн сирэйигэр төнүн',
	'checkuser-limited' => "'''Түмүк, сиэрбэри наһаа ноҕуруускалаамаары, сорҕото быһыллыбыт.'''",
	'checkuser-log-userips' => '$1 манна анаан $2 IP аадырыстаах',
	'checkuser-log-ipedits' => '$1 манна анаан $2 көннөрүүлэрдээх',
	'checkuser-log-ipusers' => '$1 манна анаан $2 ааттардаах (учётные записи)',
	'checkuser-log-ipedits-xff' => '$1 манна анаан XFF $2 көннөрүүлэрдээх',
	'checkuser-log-ipusers-xff' => '$1 кыттаачылары ылбыт (для XFF $2)',
	'checkuser-log-useredits' => '$1 $2 көннөрүүлэрин ылбыт',
	'checkuser-autocreate-action' => 'аптамаатынан оҥоһуллубут',
	'checkuser-create-action' => 'оҥоһуллубут',
	'checkuser-email-action' => '"$1" кыттаачыга сурук ыыппыт',
	'checkuser-reset-action' => '"$1" киирии тылын бырахпыт',
);

/** Sardinian (Sardu)
 * @author Andria
 * @author Marzedu
 */
$messages['sc'] = array(
	'checkuser-reason' => 'Motivu:',
	'checkuser-target' => 'Indiritzu IP o nùmene usuàriu:',
	'checkuser-search' => 'Chirca',
	'checkuser-period' => 'Durada:',
	'checkuser-week-1' => 'ùrtima chida',
	'checkuser-week-2' => 'ùrtimas duas chidas',
	'checkuser-month' => 'ùrtimas 30 dies',
	'checkuser-all' => 'totu',
	'checkuser-search-submit' => 'Chirca',
	'checkuser-ipeditcount' => '~$1 dae totu is usuàrios',
);

/** Sicilian (Sicilianu)
 * @author Melos
 * @author Santu
 */
$messages['scn'] = array(
	'checkuser-summary' => "Stu strumentu analizza li mudìfichi fatti di picca pi ricupirari li nnirizzi IP utilizzati di n'utenti o ammustrari cuntribbuti e dati di nu IP. Utenti e cuntribbuti di nu client IP ponnu èssiri rintracciati pi menzu dî header XFF juncennu a l'IP lu suffissu \"/xff\". Sunnu suppurtati IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128). Non vènunu turnati chiossai di 5.000 mudifichi, pi mutivi di pristazzioni. Usa stu strumentu 'n stritta cunfurmità a li policy.",
	'checkuser-desc' => "Pirmetti a l'utenti cu li giusti autorizzazzioni du suttapuniri a virifica li nnirizzi IP e àutri nfurmazzioni di l'utenti stissi",
	'checkuser-logcase' => "La circata nnê log è ''case sensitive'' (diffirènzia ntra maiùsculi e minùsculi)",
	'checkuser' => 'Cuntrolli utenzi',
	'checkuserlog' => 'Log di li checkuser',
	'checkuser-contribs' => "cuntrolla l'indirizzi IP dô utenti",
	'group-checkuser' => 'Cuntrullori',
	'group-checkuser-member' => 'Cuntrullori',
	'right-checkuser' => "Talìa li nnirizzi IP usati di l'utenti a àutri nfurmazzioni",
	'right-checkuser-log' => 'Talìa li log di li checkuser',
	'grouppage-checkuser' => '{{ns:project}}:Cuntrollu utenzi',
	'checkuser-reason' => 'Mutivu:',
	'checkuser-showlog' => 'Ammustra lu log',
	'checkuser-query' => "Cera nta l'ùrtimi mudìfichi",
	'checkuser-target' => 'Utenti o IP',
	'checkuser-users' => 'Cerca utenti',
	'checkuser-edits' => 'Talìa li cuntribbuti di li IP',
	'checkuser-ips' => 'Cerca IP',
	'checkuser-search' => 'Cerca',
	'checkuser-period' => 'Pirìudu:',
	'checkuser-week-1' => 'ùrtima simana',
	'checkuser-week-2' => 'ùrtimi dui simani',
	'checkuser-month' => 'ùrtimi 30 jorna',
	'checkuser-all' => 'tutti li canciamenti',
	'checkuser-cidr-label' => "Trova l'intervallu e l'indirizzi intirissati pi na lista di IP",
	'checkuser-cidr-res' => 'CIDR comuni:',
	'checkuser-empty' => 'Lu log non havi dati.',
	'checkuser-nomatch' => 'Nuddu risurtatu attruvatu.',
	'checkuser-nomatch-edits' => 'Nuddu risurtatu attruvatu.
Ùrtimu canciamentu fattu a li $2 di lu $1.',
	'checkuser-check' => 'Cuntrolla',
	'checkuser-log-fail' => 'Mpussìbbili junciri la vuci a lu log',
	'checkuser-nolog' => 'Non vinni atruvatu nuddu file di log.',
	'checkuser-blocked' => 'Bluccatu',
	'checkuser-gblocked' => 'Bluccattu glubbarmenti',
	'checkuser-locked' => 'Chiuruti',
	'checkuser-wasblocked' => 'Bluccatu prima di ora',
	'checkuser-localonly' => 'No unificata',
	'checkuser-massblock' => "Blocca l'utenti silizziunati",
	'checkuser-massblock-text' => "L'account silizziunati vennu  bluccati pi sempri, cô bloccu autumàticu attivatu e la criazzioni di novi account disattivata.
Li nnirizzi IP vennu bluccati pi na simana sulu pi l'utenti anònimi e câ criazzioni account disattivata.",
	'checkuser-blocktag' => 'Scancia pàggini utenti cu:',
	'checkuser-blocktag-talk' => 'Scancia pàggini utenti di discussioni cu:',
	'checkuser-massblock-commit' => 'Blocca utenti silizziunati',
	'checkuser-block-success' => "'''{{PLURAL:$2|L'utenti|Li utenti}} $1 {{PLURAL:$2|è ora bluccatu|sunnu ora bluccati}}.'''",
	'checkuser-block-failure' => "'''Nuddu utenti bluccatu.'''",
	'checkuser-block-limit' => 'Troppi utenti silizziunati.',
	'checkuser-block-noreason' => 'È òbbricu dari na mutivazzioni pi li blocchi.',
	'checkuser-noreason' => 'Havi a ndicari nu mutivu pi sta query.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|novo|novi}} account',
	'checkuser-too-many' => "Li nùmmira dî risulrtati è troppu assai, usari nu CIDR cchiù nicu. Si sècutu sù nnicati li nnirizzi IP utilizzati (nzinu a non chiossai di 5000, misi 'n òrdini pi nnirizzu):",
	'checkuser-user-nonexistent' => "L'utenti nnicatu non esisti.",
	'checkuser-search-form' => 'Attrova li vuci di li log pi li quali $1 è $2',
	'checkuser-search-submit' => 'Circata',
	'checkuser-search-initiator' => 'Nizziaturi',
	'checkuser-search-target' => 'ubbiettivu',
	'checkuser-ipeditcount' => "~$1 pi tutti pari l'utenti",
	'checkuser-log-return' => 'Torna ô mòdulu principali di Cuntrollu utenzi',
	'checkuser-limited' => "'''Li risurtati foru truncati pi mutivi di pristazzioni.'''",
	'checkuser-log-userips' => '$1 uttinìu li nnirizzi IP di $2',
	'checkuser-log-ipedits' => '$1 uttinìu li mudìfichi di $2',
	'checkuser-log-ipusers' => '$1 uttinìu li utenzi di $2',
	'checkuser-log-ipedits-xff' => '$1 uttinìu li mudìfichi di $2 pi XFF',
	'checkuser-log-ipusers-xff' => "$1 uttinìu l'utenzi di $2 pi XFF",
	'checkuser-log-useredits' => '$1 uttinìu li cuntribbuti di $2',
	'checkuser-autocreate-action' => 'fu criatu autumàticamenti',
	'checkuser-email-action' => 'inviau n\' e-mail a "$1"',
	'checkuser-reset-action' => 'mposta n\'àutra vota password pi l\'utenti "$1"',
);

/** Sinhala (සිංහල)
 * @author නන්දිමිතුරු
 * @author පසිඳු කාවින්ද
 * @author බිඟුවා
 */
$messages['si'] = array(
	'checkuser-logcase' => 'ලඝු සෙවීම අවස්ථා සංවේදියි.',
	'checkuser' => 'පරීක්ෂක නිළධරයා',
	'checkuserlog' => 'පරිශීලක ලඝු සටහන පිරික්සන්න',
	'checkuser-contribs' => 'පරිශීලකයාගේ අයිපී ලිපිනය පරික්ෂා කරන්න',
	'group-checkuser' => 'පරීක්ෂක නිළධරයින්',
	'group-checkuser-member' => '{{GENDER:$1|පරීක්ෂක නිලධාරියා}}',
	'right-checkuser' => 'පරිශීලකයන්ගේ අයිපී ලිපින සහ වෙනත් තොරතුරු පිරික්සන්න',
	'right-checkuser-log' => 'පරිශීලකපිරික්සුම් ලඝු සටහන නරඹන්න',
	'action-checkuser' => 'පරිශීලකයන්ගේ අයිපී ලිපින සහ වෙනත් තොරතුරු පිරික්සන්න',
	'action-checkuser-log' => 'පරිශීලකපිරික්සුම් ලඝු සටහන නරඹන්න',
	'grouppage-checkuser' => '{{ns:project}}:පරීක්ෂක නිළධරයා',
	'checkuser-reason' => 'හේතුව:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'ලඝු-සටහන පෙන්වන්න',
	'checkuser-query' => 'මෑත වෙනස්වීම් ප්‍රශ්න කරන්න',
	'checkuser-target' => 'අන්තර්ජාල ලිපිනය හෝ පරිශීලක නාමය:',
	'checkuser-users' => 'පරිශීලකයින් ගන්න',
	'checkuser-edits' => 'සංස්කරණ ගන්න',
	'checkuser-ips' => 'අයිපී ලිපින ලබා ගන්න',
	'checkuser-search' => 'ගවේෂණය',
	'checkuser-period' => 'කාල සීමාව:',
	'checkuser-week-1' => 'පසුගිය සතිය',
	'checkuser-week-2' => 'පසුගිය සති දෙක',
	'checkuser-month' => 'පසුගිය දින 30',
	'checkuser-all' => 'සියල්ල',
	'checkuser-cidr-res' => 'පොදු CIDR:',
	'checkuser-empty' => 'ලඝු-සටහනෙහි කිසිදු අයිතමයක් නොමැත.',
	'checkuser-nomatch' => 'කිසිදු ගැලපුමක් සමුනොවිනි.',
	'checkuser-nomatch-edits' => 'කිසිදු ගැලපුමක් සමුනොවිනි.
අවසන් සංස්කරණය $1 ට $2 හීදී සිදුකොට තිබිණි.',
	'checkuser-check' => 'පරික්ෂා කරන්න',
	'checkuser-log-fail' => 'ලඝු-සටහනක් එකතු කිරීමට නොහැක',
	'checkuser-nolog' => 'ලඝු-සටහන් ගොනුවක් හමු නොවිණි.',
	'checkuser-blocked' => 'ඇහිරීම',
	'checkuser-gblocked' => 'ගෝලීය වශයෙන් වාරණය කරන ලද',
	'checkuser-locked' => 'අගුළුලා ඇත',
	'checkuser-wasblocked' => 'පෙර වාරණය කරන ලද',
	'checkuser-localonly' => 'අනුමතකොට නැත',
	'checkuser-massblock' => 'තෝරාගත් පරිශිලකයන් වාරණය කරන්න',
	'checkuser-blocktag' => 'මේ සමඟ පරිශීලක පිටු ප්‍රතිස්ථාපනය කරන්න:',
	'checkuser-blocktag-talk' => 'මේ සමඟ සාකච්ඡා පිටු ප්‍රතිස්ථාපනය කරන්න:',
	'checkuser-massblock-commit' => 'තෝරාගත් පරිශිලකයන් වාරණය කරන්න',
	'checkuser-block-failure' => "'''කිසිදු පරිශීලකයෙකු වාරණය කර නොමැත.'''",
	'checkuser-block-limit' => 'තෝරාගත් පරිශීලකයන් ගණන වැඩියි.',
	'checkuser-block-noreason' => 'වාරණ සඳහා ඔබ විසින් හේතුවක් ලබා දිය යුතුය.',
	'checkuser-noreason' => 'මෙම ප්‍රශ්නය සඳහා ඔබ විසින් හේතුවක් ලබා දිය යුතුය.',
	'checkuser-accounts' => 'නව {{PLURAL:$1|ගිණුම්|ගිණුම්}} $1 ක්',
	'checkuser-user-nonexistent' => 'විශේෂණය කෙරූ පරිශීලකයා නොපවතියි.',
	'checkuser-search-submit' => 'ගවේෂණය',
	'checkuser-search-initiator' => 'ආරම්භකය',
	'checkuser-search-target' => 'ඉලක්කය',
	'checkuser-ipeditcount' => '~$1 සියලුම පරිශිලකයන්ගෙන්',
	'checkuser-log-return' => 'පරිශීලකපිරික්සුම් ප්‍රධාන ෆෝරමය වෙත නැවත යන්න',
	'checkuser-limited' => "'''කාර්ය සාධනය හේතුන් නිසා ප්‍රතිපල ලුප්ත කරන ලදී.'''",
	'checkuser-log-userips' => 'සංස්කරණය සඳහා  $2 විසින් භාවිත කෙරුණු අන්තර්ජාල ලිපිනයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-log-ipedits' => '$2 අන්තර්ජාල ලිපිනය වෙතින් සිදු කෙරුණු සංස්කරණයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-log-ipusers' => '$2 අන්තර්ජාල ලිපිනය භාවිතා කල පරිශීලකයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-log-ipedits-xff' => '$2 XFF අන්තර්ජාල ලිපිනය මගින් සිදු කෙරුණු සංස්කරණයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-log-ipusers-xff' => '$2 XFF අන්තර්ජාල ලිපිනය භාවිතා කල පරිශීලකයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-log-useredits' => '$2 අන්තර්ජාල ලිපිනය වෙතින් සිදු කෙරුණු සංස්කරණයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-autocreate-action' => 'ස්වයංක්‍රීය ලෙස තැනිණි',
	'checkuser-create-action' => 'තනන ලදී',
	'checkuser-email-action' => ' "$1" පරිශීලක වෙත විද්‍යුත්-ගැපෑලක් යැවිණි',
	'checkuser-reset-action' => 'පරිශිලක "$1" සඳහා මුරපදය යලි සකසන්න',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Martin Kozák
 */
$messages['sk'] = array(
	'checkuser-summary' => 'Tento nástroj kontroluje Posledné úpravy, aby získal IP adresy používané používateľom alebo zobrazil úpravy/používateľské dáta IP adresy.
	Používateľov a úpravy je možné získať s XFF IP pridaním „/xff“ k IP. Sú podporované IPv4 (CIDR 16-32) a IPv6 (CIDR 64-128).
	Z dôvodov výkonnosti nebude vrátených viac ako 5000 úprav. Túto funkciu využívajte len v súlade s platnou politikou.',
	'checkuser-desc' => 'Dáva používateľom s príslušným oprávnením možnosť overovať IP adresu a iné informácie o používateľovi',
	'checkuser-logcase' => 'Vyhľadávanie v zázname zohľadňuje veľkosť písmen.',
	'checkuser' => 'Overiť používateľa',
	'checkuserlog' => 'Záznam kontroly používateľov',
	'checkuser-contribs' => 'skontrolovať IP používateľa',
	'group-checkuser' => 'Revízor',
	'group-checkuser-member' => 'Revízori',
	'right-checkuser' => 'Skontrolovať IP adresy a iné informácie používateľov',
	'right-checkuser-log' => 'Zobraziť záznam kontrol používateľov',
	'grouppage-checkuser' => '{{ns:project}}:Revízia používateľa',
	'checkuser-reason' => 'Dôvod:',
	'checkuser-showlog' => 'Zobraziť záznam',
	'checkuser-query' => 'Získať z posledných úprav',
	'checkuser-target' => 'IP adresa alebo meno používateľa:',
	'checkuser-users' => 'Získať používateľov',
	'checkuser-edits' => 'Získať úpravy',
	'checkuser-ips' => 'Získať IP adresy',
	'checkuser-search' => 'Hľadať',
	'checkuser-period' => 'Trvanie:',
	'checkuser-week-1' => 'posledný týždeň',
	'checkuser-week-2' => 'posledné dva týždne',
	'checkuser-month' => 'posledných 30 dní',
	'checkuser-all' => 'všetky',
	'checkuser-cidr-label' => 'Nájsť spoločný rozsah zoznam IP adries a doňho patriace adresy',
	'checkuser-cidr-res' => 'Spoločná sieť v CIDR zápise:',
	'checkuser-empty' => 'Záznam neobsahuje žiadne položky.',
	'checkuser-nomatch' => 'Žiadny vyhovujúci záznam.',
	'checkuser-nomatch-edits' => 'Neboli nájdené zhody.
Posledná úprava bola $1 o $2.',
	'checkuser-check' => 'Skontrolovať',
	'checkuser-log-fail' => 'Nebolo možné pridať položku záznamu',
	'checkuser-nolog' => 'Nebol nájdený súbor záznamu.',
	'checkuser-blocked' => 'Zablokovaný',
	'checkuser-gblocked' => 'Globálne zablokovaný',
	'checkuser-locked' => 'Zamknutý',
	'checkuser-wasblocked' => 'už bol zablokovaný',
	'checkuser-localonly' => 'Nezjednotené',
	'checkuser-massblock' => 'Zablokovať vybraných používateľov',
	'checkuser-massblock-text' => 'Vybrané účty sa zablokujú na neurčito, automatické blokovanie bude zapnuté a vytváranie účtov vypnuté.
IP adresy sa zablokujú na 1 týždeň pri iba anonymných používateľoch a vytváranie účtov bude vypnuté.',
	'checkuser-blocktag' => 'Nahradiť používateľké stránky textom:',
	'checkuser-blocktag-talk' => 'nahradiť diskusné stránky čím:',
	'checkuser-massblock-commit' => 'Zablokovať vybraných používateľov',
	'checkuser-block-success' => "'''{{PLURAL:$2|Používateľ|Používatelia}} $1 {{PLURAL:$2|je|sú}} odteraz zablokovaní.'''",
	'checkuser-block-failure' => "'''Žiaden používateľ nebol zablokovaný.'''",
	'checkuser-block-limit' => 'Bolo zvolených príliš veľa používateľov.',
	'checkuser-block-noreason' => 'Musíte zadať dôvod blokovaní.',
	'checkuser-noreason' => 'Musíte uviesť dôvod tejto požiadavky.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nový účet|nové účty|nových účtov}}',
	'checkuser-too-many' => 'Príliš veľa výsledkov (podľa odhadu požiadavky), prosím zúžte CIDR.
Tu sú použité IP (max. 5 000, zoradené podľa adresy):',
	'checkuser-user-nonexistent' => 'Uvedený používateľ neexistuje.',
	'checkuser-search-form' => 'Nájsť položky záznamu, kde $1 je $2',
	'checkuser-search-submit' => 'Hľadať',
	'checkuser-search-initiator' => 'začínajúci',
	'checkuser-search-target' => 'cieľ',
	'checkuser-ipeditcount' => 'asi $1 zo všetkých používateľov',
	'checkuser-log-return' => 'Vrátiť sa na hlavný formulár CheckUser',
	'checkuser-limited' => "'''Tieto výsledky boli z výkonnostných dôvodov skrátené.'''",
	'checkuser-log-userips' => '$1 má IP adresy $2',
	'checkuser-log-ipedits' => '$1 má úpravy $2',
	'checkuser-log-ipusers' => '$1 má používateľov $2',
	'checkuser-log-ipedits-xff' => '$1 má úpravy XFF $2',
	'checkuser-log-ipusers-xff' => '$1 má používateľov XFF $2',
	'checkuser-log-useredits' => '$1 má úpravy $2',
	'checkuser-autocreate-action' => 'bol automaticky vytvorený',
	'checkuser-email-action' => 'poslaný email používateľovi „$1”',
	'checkuser-reset-action' => 'vytvoriť nové heslo pre používateľa „$1”',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'checkuser-summary' => 'Orodje pregleda zadnje spremembe, da pridobi IP-naslove, ki jih uporablja uporabnik, ali prikaže podatke urejanja/uporabniške podatke IP-naslova.
Uporabniki in urejanja odjemalčevega IP-naslova se lahko pridobijo preko glav XFF tako, da se IP-naslovu pripne »/xff«. Podprta sta IPv4 (CIDR 16-32) in IPv6 (CIDR 64-128).
Zaradi zmogljivostnih razlogov se ne prikaže več kot 5.000 urejanj.
Orodje uporabljajte v skladu s pravilnikom.',
	'checkuser-desc' => 'Dodeli uporabnikom s primernimi dovoljenji možnost preverjanja uporabnikovih IP-naslovov in drugih informacij',
	'checkuser-logcase' => 'Iskanje po dnevniku je občutljivo na velikost črk.',
	'checkuser' => 'Preveri uporabnika',
	'checkuserlog' => 'Dnevnik CheckUser',
	'checkuser-contribs' => 'preveri uporabnikove IP-naslove',
	'group-checkuser' => 'Preveri uporabnike',
	'group-checkuser-member' => '{{GENDER:$1|preverjalec|preverjalka}} uporabnikov',
	'right-checkuser' => 'Preverjanje uporabnikovih IP-naslovov in drugih informacij',
	'right-checkuser-log' => 'Ogled dnevnika preverjanja uporabnikov',
	'action-checkuser' => 'preverjanje uporabnikovih IP-naslovov in drugih informacij',
	'action-checkuser-log' => 'ogled dnevnika preverjanja uporabnikov',
	'grouppage-checkuser' => '{{ns:project}}:Preveri uporabnika',
	'checkuser-reason' => 'Razlog:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Prikaži dnevnik',
	'checkuser-query' => 'Poizvedi zadnje spremembe',
	'checkuser-target' => 'IP-naslov ali uporabniško ime:',
	'checkuser-users' => 'Dobi uporabnike',
	'checkuser-edits' => 'Dobi urejanja',
	'checkuser-ips' => 'Dobi IP-naslove',
	'checkuser-search' => 'Iskanje',
	'checkuser-period' => 'Trajanje:',
	'checkuser-week-1' => 'pretekli teden',
	'checkuser-week-2' => 'pretekla dva tedna',
	'checkuser-month' => 'preteklih 30 dni',
	'checkuser-all' => 'vse',
	'checkuser-cidr-label' => 'Poišči skupni obseg in dotaknjene IP-naslove za seznam IP-naslovov',
	'checkuser-cidr-res' => 'Pogost CIDR:',
	'checkuser-empty' => 'Dnevnik ne vsebuje vnosov.',
	'checkuser-nomatch' => 'Ni zadetkov.',
	'checkuser-nomatch-edits' => 'Ni zadetkov.
Zadnje urejanje je bilo dne $1 ob $2.',
	'checkuser-check' => 'Preveri',
	'checkuser-log-fail' => 'Dnevniku ne morem dodati vnosa',
	'checkuser-nolog' => 'Ne najdem datoteke dnevnika.',
	'checkuser-blocked' => 'Blokiran',
	'checkuser-gblocked' => 'Blokiran globalno',
	'checkuser-locked' => 'Zaklenjeno',
	'checkuser-wasblocked' => 'Predhodno blokiran',
	'checkuser-localonly' => 'Ni enoten',
	'checkuser-massblock' => 'Blokiraj izbrane uporabnike',
	'checkuser-massblock-text' => 'Izbrani računi bodo blokirani za nedoločen čas, z omogočenim samodejnim blokiranjem IP-naslovov in onemogočenim ustvarjanjem računov.
IP-naslovi brezimnih uporabnikov bodo blokirani samo za en teden in ustvarjanje računov bo nemogočeno.',
	'checkuser-blocktag' => 'Zamenjaj uporabniške strani z:',
	'checkuser-blocktag-talk' => 'Zamenjaj pogovorne strani z:',
	'checkuser-massblock-commit' => 'Blokiraj izbrane uporabnike',
	'checkuser-block-success' => "'''{{PLURAL:$2|Uporabnik|Uporabnika|Uporabniki}} $1 {{PLURAL:$2|je zdaj blokiran|sta zdaj blokirana|so zdaj blokirani}}.'''",
	'checkuser-block-failure' => "'''Noben uporabnik ni bil blokiran.'''",
	'checkuser-block-limit' => 'Izbranih je preveč uporabnikov.',
	'checkuser-block-noreason' => 'Morate navesti razlog za blokade.',
	'checkuser-noreason' => 'Morate navesti razlog za to poizvedbo.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nov račun|nova računa|novi računi|novih računov}}',
	'checkuser-too-many' => 'Preveč rezultatov (glede na oceno poizvedbe), prosimo zožite CIDR.
Tukaj so uporabljeni IP-ju (največ 5000, razvrščeni po naslovu):',
	'checkuser-user-nonexistent' => 'Določen uporabnik ne obstaja.',
	'checkuser-search-form' => 'Najdi dnevniške vnose, kjer je $1 enak $2',
	'checkuser-search-submit' => 'Išči',
	'checkuser-search-initiator' => 'sprožitelj',
	'checkuser-search-target' => 'cilj',
	'checkuser-ipeditcount' => '~$1 od vseh uporabnikov',
	'checkuser-log-return' => 'Vrnitev na glavni obrazec CheckUser',
	'checkuser-limited' => "'''Rezultati so bili okrnjeni iz zmogljivostnih razlogov.'''",
	'checkuser-log-userips' => '$1 je pridobil(-a) IP-naslove $2',
	'checkuser-log-ipedits' => '$1 je pridobil(-a) urejanja $2',
	'checkuser-log-ipusers' => '$1 je pridobil(-a) uporabnike $2',
	'checkuser-log-ipedits-xff' => '$1 je pridobil(-a) urejanja XFF $2',
	'checkuser-log-ipusers-xff' => '$1 je pridobil(-a) uporabnike XFF $2',
	'checkuser-log-useredits' => '$1 je pridobil(-a) urejanja $2',
	'checkuser-autocreate-action' => 'je bil samodejno ustvarjen',
	'checkuser-create-action' => 'je bil ustvarjen',
	'checkuser-email-action' => 'pošlji e-pošto uporabniku »$1«',
	'checkuser-reset-action' => 'ponastavi geslo uporabnika »$1«',
);

/** Somali (Soomaaliga)
 * @author Maax
 */
$messages['so'] = array(
	'checkuser-search' => 'Raadi',
	'checkuser-search-submit' => 'Raadi',
);

/** Albanian (Shqip)
 * @author Dori
 */
$messages['sq'] = array(
	'checkuser' => 'Kontrollo përdoruesin',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Verlor
 * @author Јованвб
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 * @author Обрадовић Горан
 */
$messages['sr-ec'] = array(
	'checkuser-summary' => 'Ова алатка прегледа скорашње измене и враћа IP адресе које је корисник користио или показује податке о кориснику/изменама за дати IP. Корисници и измене клијентског IP се могу добавити преко XFF заглавља додавањем "/xff" иза IP. Подржани су формати IPv4 (CIDR 16-32) и IPv6 (CIDR 64-128).
Због перформанси неће бити враћено више од 5000 измена.
Алатку користите у складу са политиком.',
	'checkuser-desc' => 'Даје корисницима са одговарајућим правима могућност да провере ИП адресе корисника и друге информације.',
	'checkuser-logcase' => 'Претрага извештаја је осетљива на мала и велика слова.',
	'checkuser' => 'Чекјузер',
	'checkuserlog' => 'Дневник чекјузера',
	'checkuser-contribs' => 'Провери корисникове ИП адресе',
	'group-checkuser' => 'Чекјузери',
	'group-checkuser-member' => '{{GENDER:$1|чекјузер}}',
	'right-checkuser' => 'проверавање корисничких ИП адреса и других података',
	'right-checkuser-log' => 'гледање историје чекјузера',
	'action-checkuser' => 'проверавање корисничких ИП адреса и других података',
	'action-checkuser-log' => 'гледање историје чекјузера',
	'grouppage-checkuser' => '{{ns:project}}:Чекјузер',
	'checkuser-reason' => 'Разлог:',
	'checkuser-reason-api' => 'АПИ: $1',
	'checkuser-showlog' => 'Прикажи лог.',
	'checkuser-query' => 'Упит на скорашње измене.',
	'checkuser-target' => 'Корисничко име или ИП адреса:',
	'checkuser-users' => 'Прикупљање корисничких имена.',
	'checkuser-edits' => 'Прикажи измене',
	'checkuser-ips' => 'Прикажи ИП адресе',
	'checkuser-search' => 'Претрага',
	'checkuser-period' => 'Трајање:',
	'checkuser-week-1' => 'последња недеља',
	'checkuser-week-2' => 'последње две недеље',
	'checkuser-month' => 'последњих 30 дана',
	'checkuser-all' => 'све',
	'checkuser-cidr-label' => 'Пронађи уобичајени опсег и захваћене адресе за списак IP адреса.',
	'checkuser-cidr-res' => 'Уобичајени CIDR',
	'checkuser-empty' => 'Дневник је празан.',
	'checkuser-nomatch' => 'Нема погодака.',
	'checkuser-nomatch-edits' => 'Нису нађена поклапања.
Последња измена је била на $1 у $2.',
	'checkuser-check' => 'Провера',
	'checkuser-log-fail' => 'Не могу да додам ставку у дневник',
	'checkuser-nolog' => 'Дневник није пронађен.',
	'checkuser-blocked' => 'Блокиран',
	'checkuser-gblocked' => 'Блокиран глобално',
	'checkuser-locked' => 'Закључано',
	'checkuser-wasblocked' => 'Претходно блокиран',
	'checkuser-localonly' => 'Није унифицирано',
	'checkuser-massblock' => 'Блокирај изабраног корисника',
	'checkuser-massblock-text' => 'Изабрани налози ће бити блокирани на неодређено, уз обележене опције аутоблокирања и забране прављења налога.
IP адресе ће бити блокиране на недељу дана за IP кориснике, уз забрану прављења налога.',
	'checkuser-blocktag' => 'Замени корисничке странице са:',
	'checkuser-blocktag-talk' => 'Замени стране за разговор са:',
	'checkuser-massblock-commit' => 'Блокирај изабраног корисника',
	'checkuser-block-success' => "'''{{PLURAL:$2|Корисник|Корисници}} $1 {{PLURAL:$2|је сада блокиран|су сада блокирани}}.'''",
	'checkuser-block-failure' => "'''Нема блокираних корисника.'''",
	'checkuser-block-limit' => 'Изабрано је превише корисника.',
	'checkuser-block-noreason' => 'Морате дати разлог за блок.',
	'checkuser-noreason' => 'Морате да наведете разлог за овај упит.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|нови налог|нових налога}}',
	'checkuser-too-many' => 'Нађено је превише резултата (према процени захтева). Молимо Вас да сузите CIDR.
Овде су коришћене IP адресе (највише 5.000, сортираних по адреси):',
	'checkuser-user-nonexistent' => 'Наведени корисник не постоји.',
	'checkuser-search-form' => 'Пронађи ставке у дневнику где је $1 једнако $2',
	'checkuser-search-submit' => 'Претражи',
	'checkuser-search-initiator' => 'покретач',
	'checkuser-search-target' => 'циљ',
	'checkuser-ipeditcount' => '~$1 од свих корисника',
	'checkuser-log-return' => 'Повратак на основну форму чекјузера.',
	'checkuser-limited' => "'''Ови резултати су скраћени због перформанси.'''",
	'checkuser-log-userips' => '$1 је добио ИП адресе за $2',
	'checkuser-log-ipedits' => '$1 је добио измене за $2',
	'checkuser-log-ipusers' => '$1 је добио кориснике за $2',
	'checkuser-log-ipedits-xff' => '$1 је добио измене за XFF $2',
	'checkuser-log-ipusers-xff' => '$1 је добио кориснике за XFF $2',
	'checkuser-log-useredits' => '$1 преузео измене од $2',
	'checkuser-autocreate-action' => 'је аутоматски направљен',
	'checkuser-create-action' => 'је направљен',
	'checkuser-email-action' => 'е-порука је послата кориснику „$1“',
	'checkuser-reset-action' => 'поништи лозинку корисника „$1“',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-el'] = array(
	'checkuser-summary' => 'Ova alatka pregleda skorašnje izmene i vraća IP adrese koje je korisnik koristio ili pokazuje podatke o korisniku/izmenama za dati IP. Korisnici i izmene klijentskog IP se mogu dobaviti preko XFF zaglavlja dodavanjem "/xff" iza IP. Podržani su formati IPv4 (CIDR 16-32) i IPv6 (CIDR 64-128).
Zbog performansi neće biti vraćeno više od 5000 izmena.
Alatku koristite u skladu sa politikom.',
	'checkuser-desc' => 'Daje korisnicima sa odgovarajućim pravima mogućnost da provere IP adrese korisnika i druge informacije.',
	'checkuser-logcase' => 'Pretraga loga je osetljiva na mala i velika slova.',
	'checkuser' => 'Čekjuzer',
	'checkuserlog' => 'Log čekjuzera.',
	'checkuser-contribs' => 'Proveri korisnikove IP adrese.',
	'group-checkuser' => 'Čekjuzeri',
	'group-checkuser-member' => '{{GENDER:$1|čekjuzer}}',
	'right-checkuser' => 'proverava korisničke IP adrese i druge informacije',
	'right-checkuser-log' => 'Pogledaj čekjuzer log',
	'grouppage-checkuser' => '{{ns:project}}:Čekjuzer',
	'checkuser-reason' => 'Razlog:',
	'checkuser-showlog' => 'Prikaži log.',
	'checkuser-query' => 'Upit na skorašnje izmene.',
	'checkuser-target' => 'Korisničko ime  ili IP adresa',
	'checkuser-users' => 'Prikupljanje korisničkih imena.',
	'checkuser-edits' => 'Prikaži izmene',
	'checkuser-ips' => 'Prikuplja IP adrese.',
	'checkuser-search' => 'Pretraga',
	'checkuser-period' => 'Trajanje:',
	'checkuser-week-1' => 'poslednja nedelja',
	'checkuser-week-2' => 'poslednje dve nedelje',
	'checkuser-month' => 'poslednjih 30 dana',
	'checkuser-all' => 'sve',
	'checkuser-cidr-label' => 'Pronađi uobičajeni opseg i zahvaćene adrese za spisak IP adresa.',
	'checkuser-cidr-res' => 'Uobičajeni CIDR',
	'checkuser-empty' => 'Log ne sadrži ništa.',
	'checkuser-nomatch' => 'Nema pogodaka.',
	'checkuser-nomatch-edits' => 'Nisu nađena poklapanja.
Poslednja izmena je bila na $1 u $2.',
	'checkuser-check' => 'Provera',
	'checkuser-log-fail' => 'Nije bilo moguće dodati podatak u log.',
	'checkuser-nolog' => 'Nijedan fajl s logovima nije pronađen.',
	'checkuser-blocked' => 'Blokiran',
	'checkuser-gblocked' => 'Blokiran globalno',
	'checkuser-locked' => 'Zaključano',
	'checkuser-wasblocked' => 'Prethodno blokiran',
	'checkuser-localonly' => 'Nije unificirano',
	'checkuser-massblock' => 'Blokiraj izabranog korisnika',
	'checkuser-massblock-text' => 'Izabrani nalozi će biti blokirani na neodređeno, uz obeležene opcije autoblokiranja i zabrane pravljenja naloga.
IP adrese će biti blokirane na nedelju dana za IP korisnike, uz zabranu pravljenja naloga.',
	'checkuser-blocktag' => 'Zameni korisničke stranice sa:',
	'checkuser-blocktag-talk' => 'Zameni strane za razgovor sa:',
	'checkuser-massblock-commit' => 'Blokiraj izabranog korisnika',
	'checkuser-block-success' => "'''{{PLURAL:$2|Korisnik|Korisnici}} $1 {{PLURAL:$2|je sada blokiran|su sada blokirani}}.'''",
	'checkuser-block-failure' => "'''Nema blokiranih korisnika.'''",
	'checkuser-block-limit' => 'Previše korisnika je izabrano.',
	'checkuser-block-noreason' => 'Morate dati razlog za blok.',
	'checkuser-noreason' => 'Morate da navedete razlog za ovaj upit.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|novi nalog|novih naloga}}',
	'checkuser-too-many' => 'Nađeno je previše rezultata (prema proceni zahteva). Molimo Vas da suzite CIDR.
Ovde su korišćene IP adrese (najviše 5.000, sortiranih po adresi):',
	'checkuser-user-nonexistent' => 'Traženi korisnik ne postoji.',
	'checkuser-search-form' => 'Pretraga loga gde je $1 jednako $2.',
	'checkuser-search-submit' => 'Pretraga',
	'checkuser-search-initiator' => 'pokretač',
	'checkuser-search-target' => 'cilj',
	'checkuser-ipeditcount' => '~$1 od svih korisnika',
	'checkuser-log-return' => 'Povratak na osnovnu formu čekjuzera.',
	'checkuser-limited' => "'''Ovi rezultati su skraćeni zbog performansi.'''",
	'checkuser-log-userips' => '$1 je dobio IP adrese za $2',
	'checkuser-log-ipedits' => '$1 je dobio izmene za $2',
	'checkuser-log-ipusers' => '$1 je dobio korisnike za $2',
	'checkuser-log-ipedits-xff' => '$1 je dobio izmene za XFF $2',
	'checkuser-log-ipusers-xff' => '$1 je dobio korisnike za XFF $2',
	'checkuser-log-useredits' => '$1 preuzeo izmene od $2',
	'checkuser-autocreate-action' => 'je automatski napravljen',
	'checkuser-email-action' => 'poslat je mejl korisniku "$1"',
	'checkuser-reset-action' => 'obnovi lozinku za korisnika "$1"',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'checkuser-summary' => 'Disse Reewe truchsäkt do lääste Annerengen, uum ju IP-Adresse fon n Benutser
	blw. do Beoarbaidengen/Benutsernoomen foar ne IP-Adresse fäästtoustaalen. Benutsere un
Beoarbaidengen fon ne IP-Adresse konnen uk ätter Informatione uut do XFF-Headere
	oufräiged wäide, as an ju IP-Adresse n „/xff“ anhonged wäd. (CIDR 16-32) un IPv6 (CIDR 64-128) wäide unnerstutsed.
	Uut Perfomance-Gruunde wäide maximoal 5000 Beoarbaidengen uutroat. Benutsje CheckUser bloot in Uureenstämmenge mäd do Doatenskutsgjuchtlienjen.',
	'checkuser-desc' => 'Ferlööwet Benutsere mäd do äntspreekende Gjuchte do IP-Adressen as uk wiedere Informatione fon Benutsere tou wröigjen.',
	'checkuser-logcase' => 'Ju Säike in dät Logbouk unnerskat twiske Groot- un Littikskrieuwen.',
	'checkuser' => 'Checkuser',
	'checkuserlog' => 'Checkuser-Logbouk',
	'checkuser-contribs' => 'IP-Adrässen Benutser wröigje',
	'group-checkuser' => 'Checkusers',
	'group-checkuser-member' => 'Checkuser-Begjuchtigde',
	'right-checkuser' => 'Wröigenge fon IP-Adressen as uk Ferbiendengen twiske IPs un ounmäldede Benutsere',
	'right-checkuser-log' => 'Bekiekjen fon dät Checkuser-Logbouk',
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Gruund:',
	'checkuser-showlog' => 'Logbouk anwiese',
	'checkuser-query' => 'Lääste Annerengen oufräigje',
	'checkuser-target' => 'IP-Adresse of Benutsernoome:',
	'checkuser-users' => 'Hoal Benutsere',
	'checkuser-edits' => 'Beoarbaidengen ouroupe',
	'checkuser-ips' => 'Hoal IP-Adressen',
	'checkuser-search' => 'Säike (uk ap Düütsk4)',
	'checkuser-period' => 'Tiedruumte:',
	'checkuser-week-1' => 'lääste 7 Deege',
	'checkuser-week-2' => 'lääste 14 Deege',
	'checkuser-month' => 'lääste 30 Deege',
	'checkuser-all' => 'aal',
	'checkuser-cidr-label' => 'Fiend gemeensoamen Adressberäk un betroffene Adresse foar ne Lieste fon IP-Adressen',
	'checkuser-cidr-res' => 'Gemeenskuppelke CIDR:',
	'checkuser-empty' => 'Dät Logbouk änthaalt neen Iendraage.',
	'checkuser-nomatch' => 'Neen Uureenstämmengen fuunen.',
	'checkuser-nomatch-edits' => 'Neen Uureenstimmengen fuunen. Lääste Beoarbaidenge waas an n $1 uum $2.',
	'checkuser-check' => 'Uutfiere',
	'checkuser-log-fail' => 'Logbouk-Iendraach kon nit bietouföiged wäide.',
	'checkuser-nolog' => 'Neen Logbouk fuunen.',
	'checkuser-blocked' => 'speerd',
	'checkuser-gblocked' => 'globoal speerd',
	'checkuser-locked' => 'sleeten',
	'checkuser-wasblocked' => 'fröier speerd',
	'checkuser-localonly' => 'nit touhoopefierd',
	'checkuser-massblock' => 'Speer do uutwäälde Benutsere',
	'checkuser-massblock-text' => 'Do uutwäälde Benutserkonten wäide duurhaft speerd (Autoblock is aktiv un ju Anloage fon näie Benutserkonten wäd unnerbuunen).
IP-Adressen wäide foar een Wiek speerd (bloot foar anonyme Benutsere, ju Anloage fon näie Benutserkonten wäd unnerbuunen).',
	'checkuser-blocktag' => 'Inhoold fon ju Benutsersiede ärsätte truch:',
	'checkuser-blocktag-talk' => 'Diskussionssieden ärsätte truch:',
	'checkuser-massblock-commit' => 'Speer do uutwäälde Benutsere',
	'checkuser-block-success' => "'''{{PLURAL:$2|Die Benutser|Do Benutsere}} $1 {{PLURAL:$2|wuud|wuuden}} speerd.'''",
	'checkuser-block-failure' => "'''Der wuuden neen Benutsere speerd.'''",
	'checkuser-block-limit' => 'Der wuuden toufuul Benutsere uutwääld.',
	'checkuser-block-noreason' => 'Du moast n Gruund foar ju Speere anreeke.',
	'checkuser-noreason' => 'Foar disse Oufroage mout ne Begruundenge ounroat wäide.',
	'checkuser-accounts' => '{{PLURAL:$1|1 näi Benutserkonto|$1 näie Benutserkonten}}',
	'checkuser-too-many' => 'Ju Lieste fon Resultoate is tou loang (ätter ju Skätsenge), gränsje dän IP-Beräk fääre ien. Hier sunt do benutsede IP-Adressen (maximoal 5000, sortierd ätter Adresse):',
	'checkuser-user-nonexistent' => 'Die anroate Benutser bestoant nit.',
	'checkuser-search-form' => 'Säik Lochboukiendraage, wier $1 $2 is.',
	'checkuser-search-submit' => 'Säik',
	'checkuser-search-initiator' => 'Initiator',
	'checkuser-search-target' => 'Siel',
	'checkuser-ipeditcount' => '~$1 fon aal Benutsere',
	'checkuser-log-return' => 'Tourääch ätter dät CheckUser-Haudformular',
	'checkuser-limited' => "'''Ju Resultoatelieste wuud uut Performancegruunden kuuted.'''",
	'checkuser-log-userips' => '$1 hoalde IP-Adressen foar $2',
	'checkuser-log-ipedits' => '$1 hoalde Beoarbaidengen foar $2',
	'checkuser-log-ipusers' => '$1 hoalde Benutsere foar $2',
	'checkuser-log-ipedits-xff' => '$1 hoalde Beoarbaidengen foar XFF $2',
	'checkuser-log-ipusers-xff' => '$1 hoalde Benutsere foar XFF $2',
	'checkuser-log-useredits' => '$1 hoalde Beoarbaidengen foar $2',
	'checkuser-autocreate-action' => 'automatisk moaked',
	'checkuser-email-action' => 'E-Mail an „$1“ soand',
	'checkuser-reset-action' => 'Anfoarderenge fon n näi Paaswoud foar „Benutser:$1“',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'checkuser-desc' => 'Leler kawenangan pikeun mariksa alamat IP jeung émbaran lianna ti hiji pamaké',
	'checkuser-logcase' => 'Panyungsi log ngabédakeun kapitalisasi.',
	'checkuser' => 'Pamaké pamariksa',
	'checkuserlog' => 'Log PamakéPamariksa',
	'group-checkuser' => 'Pamaké pamariksa',
	'group-checkuser-member' => 'Pamaké pamariksa',
	'grouppage-checkuser' => '{{ns:project}}:Pamaké pamariksa',
	'checkuser-reason' => 'Alesan:',
	'checkuser-showlog' => 'Témbongkeun log',
	'checkuser-target' => 'Landihan atawa IP',
	'checkuser-users' => 'Sungsi pamaké',
	'checkuser-edits' => 'Sungsi éditan ti IP',
	'checkuser-ips' => 'Sungsi IP',
	'checkuser-search' => 'Sungsi',
	'checkuser-empty' => 'Logna kosong.',
	'checkuser-nomatch' => 'Euweuh nu cocog.',
	'checkuser-check' => 'Pariksa',
	'checkuser-log-fail' => 'Teu bisa nambahkeun kana log',
	'checkuser-nolog' => 'Koropak log teu kapanggih.',
	'checkuser-blocked' => 'Dipeungpeuk',
	'checkuser-too-many' => 'Hasilna loba teuing, heureutan CIDR-na.
Di handap ieu béréndélan IP nu dipaké (paling loba 5000, disusun dumasar alamat):',
	'checkuser-user-nonexistent' => 'Euweuh pamaké nu cocog jeung pamundut.',
	'checkuser-search-form' => 'Téang éntri log nu $1-na sarua jeung $2',
	'checkuser-search-submit' => 'Sungsi',
	'checkuser-search-initiator' => 'inisiator',
	'checkuser-search-target' => 'tujul',
	'checkuser-ipeditcount' => '~$1 ti sakumna pamaké',
	'checkuser-log-return' => 'Balik ka formulir utama PamakéPamariksa',
	'checkuser-log-userips' => '$1 manggih IP ti $2',
	'checkuser-log-ipedits' => '$1 manggih éditan ti $2',
	'checkuser-log-ipusers' => '$1 manggih pamaké ti $2',
	'checkuser-log-ipedits-xff' => '$1 manggih éditan ti XFF $2',
	'checkuser-log-ipusers-xff' => '$1 manggih pamaké ti XFF $2',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 * @author Leo Johannes
 * @author M.M.S.
 * @author MagnusA
 * @author Najami
 * @author Per
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'checkuser-summary' => 'Det här verktyget söker igenom de senaste ändringarna för att hämta IP-adresser för en användare, eller redigeringar och användare för en IP-adress.
Användare och redigeringar kan visas med IP-adress från XFF genom att lägga till "/xff" efter IP-adressen. Verktyget stödjer IPv4 (CIDR 16-32) och IPv6 (CIDR 64-128).
På grund av prestandaskäl så visas inte mer än 5000 redigeringar. Använd verktyget i enlighet med policy.',
	'checkuser-desc' => 'Ger möjlighet för användare med speciell behörighet att kontrollera användares IP-adresser och viss annan information',
	'checkuser-logcase' => 'Loggsökning är skiftlägeskänslig.',
	'checkuser' => 'Kontrollera användare',
	'checkuserlog' => 'Logg över användarkontroller',
	'checkuser-contribs' => 'kontrollera användarens IP-adresser',
	'group-checkuser' => 'Användarkontrollanter',
	'group-checkuser-member' => '{{GENDER:$1|användarkontrollant}}',
	'right-checkuser' => 'Kontrollera användares IP-adresser och annan information',
	'right-checkuser-log' => 'Se loggen över användarkontroller',
	'action-checkuser' => 'kontrollera användarens IP-adresser och annan information',
	'grouppage-checkuser' => '{{ns:project}}:Användarkontrollant',
	'checkuser-reason' => 'Anledning:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Visa logg',
	'checkuser-query' => 'Sök de senaste ändringarna',
	'checkuser-target' => 'IP-adress eller användarnamn:',
	'checkuser-users' => 'Hämta användare',
	'checkuser-edits' => 'Hämta redigeringar',
	'checkuser-ips' => 'Hämta IP-adresser',
	'checkuser-search' => 'Sök',
	'checkuser-period' => 'Tidsperiod:',
	'checkuser-week-1' => 'senaste veckan',
	'checkuser-week-2' => 'senaste två veckorna',
	'checkuser-month' => 'senaste 30 dygnen',
	'checkuser-all' => 'alla',
	'checkuser-cidr-label' => 'Hitta gemensam range och påverkade adresser för en IP-lista.',
	'checkuser-cidr-res' => 'Gemensam CIDR:',
	'checkuser-empty' => 'Loggen innehåller inga poster.',
	'checkuser-nomatch' => 'Inga träffar hittades.',
	'checkuser-nomatch-edits' => 'Fick ingen träff.
Senaste redigering var $1 kl $2.',
	'checkuser-check' => 'Kontrollera',
	'checkuser-log-fail' => 'Loggposten kunde inte läggas i loggfilen.',
	'checkuser-nolog' => 'Hittade ingen loggfil.',
	'checkuser-blocked' => 'Blockerad',
	'checkuser-gblocked' => 'Blockerad globalt',
	'checkuser-locked' => 'Låst',
	'checkuser-wasblocked' => 'Tidigare blockerad',
	'checkuser-localonly' => 'Inte sammanslaget',
	'checkuser-massblock' => 'Blockera valda användare',
	'checkuser-massblock-text' => 'Valda konton kommer blockeras på obestämd tid, med autoblockering aktiverad och kontoskapande avaktiverat.
IP-adresser kommer blockeras i en vecka för anonyma användare, med kontoskapande avaktiverat.',
	'checkuser-blocktag' => 'Ersätt användarsidor med:',
	'checkuser-blocktag-talk' => 'Ersätt diskussionssidor med:',
	'checkuser-massblock-commit' => 'Blockera valda användare',
	'checkuser-block-success' => "'''{{PLURAL:$2|Användaren|Användarna}} $1 är nu {{PLURAL:$2|blockerad|blockerade}}.'''",
	'checkuser-block-failure' => "'''Ingen användare blockerades.'''",
	'checkuser-block-limit' => 'För många användare valda.',
	'checkuser-block-noreason' => 'Du måste ange en anledning för blockeringarna.',
	'checkuser-noreason' => 'Du måste uppge en anledning för den här frågan.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nytt konto|nya konton}}',
	'checkuser-too-many' => 'För många resultat (enligt uppskattning), du bör söka i ett mindre CIDR-block. Här följer de IP-adresser som använts (högst 5000, sorterade efter adress):',
	'checkuser-user-nonexistent' => 'Användarnamnet som angavs finns inte.',
	'checkuser-search-form' => 'Sök efter poster där $1 är $2',
	'checkuser-search-submit' => 'Sök',
	'checkuser-search-initiator' => 'kontrollanten',
	'checkuser-search-target' => 'kontrollmålet',
	'checkuser-ipeditcount' => '~$1 från alla användare',
	'checkuser-log-return' => 'Gå tillbaka till formuläret för användarkontroll',
	'checkuser-limited' => "'''Dessa resultat har av prestandaskäl blivit avkortade.'''",
	'checkuser-log-userips' => '$1 hämtade IP-adresser för $2',
	'checkuser-log-ipedits' => '$1 hämtade redigeringar från $2',
	'checkuser-log-ipusers' => '$1 hämtade användare från $2',
	'checkuser-log-ipedits-xff' => '$1 hämtade redigeringar från XFF $2',
	'checkuser-log-ipusers-xff' => '$1 hämtade användare från XFF $2',
	'checkuser-log-useredits' => '$1 hämtade redigeringar för $2',
	'checkuser-autocreate-action' => 'skapades automatiskt',
	'checkuser-create-action' => 'skapades',
	'checkuser-email-action' => 'skickade ett mejl till användare "$1"',
	'checkuser-reset-action' => 'återställ lösenord för användare "$1"',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 */
$messages['sw'] = array(
	'checkuser-desc' => 'Inawezesha watumiaji wenye ruksa wakague anwani za IP za watumiaji na data zingine',
	'checkuser' => 'Mkaguzi wa watumiaji',
	'checkuserlog' => 'Kumbukumbu za kukagua Watumiaji',
	'checkuser-contribs' => 'kagua anwani za IP (Itifaki Wavuti) za watumiaji',
	'group-checkuser' => 'Wakaguzi wa watumiaji',
	'group-checkuser-member' => 'Mkaguzi wa watumiaji',
	'right-checkuser' => 'Kukagua anwani za IP na data zingine za watumiaji',
	'right-checkuser-log' => 'Kutazama kumbukumbu za kukagua watumiaji',
	'grouppage-checkuser' => '{{ns:project}}:Mkaguzi wa watumiaji',
	'checkuser-reason' => 'Sababu:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Onyesha kumbukumbu',
	'checkuser-target' => 'Anwani ya IP au jina la mtumiaji:',
	'checkuser-users' => 'Leta watumiaji',
	'checkuser-edits' => 'Leta haririo zilizotoka anwani ya IP fulani',
	'checkuser-ips' => 'Leta anwani za IP',
	'checkuser-search' => 'Tafuta',
	'checkuser-period' => 'Muda:',
	'checkuser-week-1' => 'wiki iliyopita',
	'checkuser-week-2' => 'wiki mbili zilizopita',
	'checkuser-month' => 'siku 30 zilizopita',
	'checkuser-all' => 'wote',
	'checkuser-empty' => 'Kumbukumbu haina kitu.',
	'checkuser-check' => 'Chagua',
	'checkuser-search-submit' => 'Tafuta',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'checkuser-reason' => 'Čymu:',
	'checkuser-search' => 'Šnupej',
	'checkuser-search-submit' => 'Šnupej',
);

/** Tamil (தமிழ்)
 * @author Karthi.dr
 * @author Shanmugamp7
 * @author Sodabottle
 * @author TRYPPN
 * @author Trengarasu
 * @author செல்வா
 */
$messages['ta'] = array(
	'checkuser' => 'பயனரை கவனி',
	'checkuserlog' => 'பயனர் குறிப்பேட்டை சரிபார்',
	'checkuser-contribs' => 'பயனர் IP முகவரிகளை சரிபார்',
	'group-checkuser' => 'பயனர் சோதனை',
	'group-checkuser-member' => '{{GENDER:$1|பயனரை சரிபார்}}',
	'right-checkuser' => 'பயனீட்டாளரின் IP முகவரிகள் மற்றும் மற்ற தகவல்களை சரிபார்',
	'right-checkuser-log' => 'பயனர்சரிபார்த்தல் குறிப்பேடு காண்',
	'action-checkuser' => 'பயனீட்டாளரின் IP முகவரிகள் மற்றும் மற்ற தகவல்களை சரிபார்',
	'action-checkuser-log' => 'பயனர்சரிபார்த்தல் குறிப்பேடு காண்',
	'grouppage-checkuser' => '{{ns:project}}:பயனரை சரிபார்',
	'checkuser-reason' => 'காரணம்:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'குறிப்பேடு காண்பி',
	'checkuser-query' => 'சமீபத்திய மாற்றங்களில் கேள்வி',
	'checkuser-target' => 'ஐ.பி. முகவரி அல்லது பயனர் பெயர்:',
	'checkuser-users' => 'பயனீட்டாளர்களை பெறு',
	'checkuser-edits' => 'திருத்தங்களை பெறு',
	'checkuser-ips' => 'IP முகவரிகளை பெறு',
	'checkuser-search' => 'தேடுக',
	'checkuser-period' => 'இடைப்பட்ட காலம்:',
	'checkuser-week-1' => 'கடந்த கிழமை (வாரம்)',
	'checkuser-week-2' => 'கடந்த இரண்டு கிழமைகள் (வாரங்கள்)',
	'checkuser-month' => 'கடந்த 30 நாட்கள்',
	'checkuser-all' => 'அனைத்தும்',
	'checkuser-cidr-res' => 'பொதுவான CIDR:',
	'checkuser-empty' => 'இந்த குறிப்பேட்டில் உருப்படிகள் எதுவும் இல்லை.',
	'checkuser-nomatch' => 'பொருத்தமானவைகள் ஒன்றும் காணப்படவில்லை.',
	'checkuser-nomatch-edits' => 'பொருத்தங்கள் கண்டறியப்படவில்லை.
கடைசி திருத்தம் $1 ல் $2 மணிக்கு.',
	'checkuser-check' => 'சரிபார்க்கவும்',
	'checkuser-log-fail' => 'குறிப்பேடு உள்ளீட்டைச் சேர்க்க இயலவில்லை',
	'checkuser-nolog' => 'குறிப்பேடு கோப்பு காணப்படவில்லை.',
	'checkuser-blocked' => 'தடுக்கப்பட்டது',
	'checkuser-gblocked' => 'உலக அளவில் தடை செய்யப்பட்டுள்ளது',
	'checkuser-locked' => 'மூடப்பட்டது',
	'checkuser-wasblocked' => 'முன்னரே தடைசெய்யப்பட்டது',
	'checkuser-localonly' => 'ஒன்றாக்கப்டவில்லை',
	'checkuser-massblock' => 'தெரிவு செய்யப்பட்ட பயனர்களைத் தடை செய்யவும்',
	'checkuser-blocktag' => 'பயனீட்டாளர் பக்கங்கள் உடன் மாற்றிடு:',
	'checkuser-block-limit' => 'மிக அதிகமான பயனர்கள் தேர்ந்தெடுக்கப்பட்டுள்ளது.',
	'checkuser-search-submit' => 'தேடுக',
	'checkuser-search-initiator' => 'தொடக்கக்காரர்',
	'checkuser-search-target' => 'இலக்கு',
	'checkuser-autocreate-action' => 'தானகவே உருவாக்கப்பட்டது',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Mpradeep
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'checkuser-summary' => 'ఈ పరికరం ఓ వాడుకరి వాడిన ఐపీలను, లేదా ఒక ఐపీకి చెందిన దిద్దుబాట్లు, వాడుకరుల డేటాను చూపిస్తుంది.
క్లయంటు ఐపీకి చెందిన వాడుకరులు, దిద్దుబాట్లను ఐపీకి /xff అని చేర్చి, XFF హెడర్ల ద్వారా వెలికితీయవచ్చు. IPv4 (CIDR 16-32) and IPv6 (CIDR 64-128) లు పనిచేస్తాయి.
పనితనపు కారణాల వలన 5000 దిద్దుబాట్లకు మించి చూపించము. విధానాల కనుగుణంగా దీన్ని వాడండి.',
	'checkuser-desc' => 'వాడుకరి ఐపీ అడ్రసు, ఇతర సమాచారాన్ని చూడగలిగే అనుమతులను వాడుకరులకు ఇస్తుంది',
	'checkuser-logcase' => 'చిచ్చా అన్వేషణ కోసం ఇంగ్లీషు అన్వేషకం ఇస్తే, అది కేస్ సెన్సిటివ్.',
	'checkuser' => 'వాడుకరి తనిఖీ',
	'checkuserlog' => 'వాడుకరిపరిశీలనల చిట్టా',
	'checkuser-contribs' => 'వాడుకరి ఐపీ అడ్రసులను పరిశీలించు',
	'group-checkuser' => 'వాడుకరుల తనిఖీదార్లు',
	'group-checkuser-member' => 'వాడుకరుల తనిఖీదారు',
	'right-checkuser' => 'వాడుకరి ఐపీ అడ్రసును, ఇతర సమాచారాన్ని చూడు',
	'grouppage-checkuser' => '{{ns:project}}:వాడుకరిని పరిశీలించు',
	'checkuser-reason' => 'కారణం:',
	'checkuser-showlog' => 'చిట్టాని చూపించు',
	'checkuser-query' => 'ఇటీవలి మార్పుల్లో చూడండి',
	'checkuser-target' => 'ఐపీ చిరునామా లేదా వాడుకరిపేరు:',
	'checkuser-users' => 'వాడుకరులను తీసుకురా',
	'checkuser-edits' => 'మార్పుచేర్పులను తీసుకురా',
	'checkuser-ips' => 'ఐపీలను తీసుకురా',
	'checkuser-search' => 'వెతుకు',
	'checkuser-period' => 'నిడివి:',
	'checkuser-week-1' => 'గత వారం',
	'checkuser-week-2' => 'గత రెండు వారాలు',
	'checkuser-month' => 'గత 30 రోజులు',
	'checkuser-all' => 'అందరూ',
	'checkuser-empty' => 'చిట్టాలో అంశాలేమీ లేవు.',
	'checkuser-nomatch' => 'సామీప్యాలు ఏమీ కనబడలేదు.',
	'checkuser-check' => 'తనిఖీ',
	'checkuser-log-fail' => 'చిట్టాలో పద్దుని చేర్చలేకపోయాం',
	'checkuser-nolog' => 'చిట్టా ఫైలేమీ కనపడలేదు.',
	'checkuser-blocked' => 'నిరోధించాం',
	'checkuser-gblocked' => 'సార్వత్రికంగా నిరోధించారు',
	'checkuser-wasblocked' => 'గతంలో నిరోధించబడ్డారు',
	'checkuser-massblock' => 'ఎంచుకున్న వాడుకరులను నిరోధించు',
	'checkuser-massblock-commit' => 'ఎంచుకున్న వాడుకరులను నిరోధించు',
	'checkuser-block-success' => "'''{{PLURAL:$2|వాడుకరి|వాడుకరులు}} $1 ఇప్పుడు {{PLURAL:$2|నిరోధించబడ్డారు|నిరోధించబడ్డారు}}.'''",
	'checkuser-block-failure' => "'''వాడుకరులెవరూ నిరోధించబడలేదు.'''",
	'checkuser-block-limit' => 'చాలా మంది వాడుకరులను ఎంచుకున్నారు.',
	'checkuser-block-noreason' => 'ఈ నిరోధాలకి మీరు తప్పనిసరిగా కారణం ఇవ్వాలి.',
	'checkuser-noreason' => 'ఈ విచారణకి మీరు తప్పనిసరిగా ఒక కారణాన్ని ఇవ్వాలి.',
	'checkuser-accounts' => '$1 కొత్త {{PLURAL:$1|ఖాతా|ఖాతాలు}}',
	'checkuser-too-many' => 'మరీ ఎక్కువ ఫలితాలొచ్చాయి. CIDR ను మరింత కుదించండి. వాడిన ఐపీలివిగో (గరిష్ఠంగా 5000 -అడ్రసు వారీగా పేర్చి)',
	'checkuser-user-nonexistent' => 'ఆ వాడుకరి ఉనికిలో లేరు.',
	'checkuser-search-form' => '$1 అనేది $2గా ఉన్న చిట్టా పద్దులను కనుగొనండి',
	'checkuser-search-submit' => 'వెతుకు',
	'checkuser-search-initiator' => 'ఆరంభకుడు',
	'checkuser-search-target' => 'లక్ష్యం',
	'checkuser-ipeditcount' => 'వాడుకరులందరి నుండి ~$1',
	'checkuser-log-return' => 'CheckUser ముఖ్య ఫారముకు వెళ్ళు',
	'checkuser-log-userips' => '$2 కోసం $1 ఐపీలను తెచ్చింది',
	'checkuser-log-ipedits' => '$2 కోసం $1 దిద్దుబాట్లను తెచ్చింది',
	'checkuser-log-ipusers' => '$2 కోసం $1 వాడుకరులను తెచ్చింది',
	'checkuser-log-ipedits-xff' => 'XFF $2 కోసం $1, దిద్దుబాట్లను తెచ్చింది',
	'checkuser-log-ipusers-xff' => 'XFF $2 కోసం $1, వాడుకరులను తెచ్చింది',
	'checkuser-email-action' => 'వాడుకరి "$1"కి ఈమెయిలు పంపించాం',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'checkuser' => "Verifika uza-na'in",
	'checkuserlog' => 'Lista checkuser',
	'checkuser-contribs' => "verifika diresaun IP uza-na'in nian",
	'group-checkuser' => 'CheckUser',
	'group-checkuser-member' => "{{GENDER:$1|Ema ne'ebé bele halo CheckUser}}",
	'right-checkuser' => "verifika diresaun IP uza-na'in nian no informasaun seluk",
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Motivu:',
	'checkuser-target' => "Diresaun IP ka naran uza-na'in:",
	'checkuser-users' => "Uza-na'in sira",
	'checkuser-edits' => 'Hetan kontribuisaun',
	'checkuser-ips' => 'IP sira',
	'checkuser-search' => 'Buka',
	'checkuser-all' => 'hotu',
	'checkuser-search-submit' => 'Buka',
);

/** Tajik (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg'] = array(
	'right-checkuser-log' => 'Мушоҳидаи гузоришҳои бозрасии корбарӣ',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'checkuser-summary' => 'Ин абзор тағйироти охирро барои ба даст овардани нишонаҳои интернетӣ IP  истифода шуда тавассути як корбар ё таъйини вироишҳои анчом шуда тариқи як нишонаи интернетӣ IP, ҷустуҷӯ мекунад.
Корбарон ва вироишҳои як нишонаи интернетии IP-ро метавон бо таваҷҷӯҳ ба иттилоот сар оянд тариқи XFF бо афзудан нишонаи интернетӣ IP бо "/xff" пайдо кард. Ҳар ду протокол IPv4 (CIDR 16-32) ва IPv6 (CIDR 64-128) тавассути ин абзор пуштибонӣ мешаванд.
На беш аз 5000 вироиш бо далелҳои зудкорӣ баргардонида хоҳанд шуд. Бо мувофиқи сиёсат ва қоидаҳо инро истода кунед.',
	'checkuser-desc' => 'Ба корбарон ихтиёроти лозимиро барои баррасии нишонаҳои интернетӣ IP корбарон ва иттилооти дигар, иҷозат медиҳад',
	'checkuser-logcase' => 'Ҷустуҷӯи гузориш ба хурд ё бузрг будани ҳарфҳо ҳасос аст.',
	'checkuser' => 'Бозрасии корбар',
	'checkuserlog' => 'БозрасиКорбар гузориш',
	'group-checkuser' => 'Бозрасии корбарон',
	'group-checkuser-member' => 'Бозрасии корбар',
	'right-checkuser' => 'Барраси кардани нишонаи IP ва дигар иттилооти корбар',
	'grouppage-checkuser' => '{{ns:project}}:Бозрасии корбар',
	'checkuser-reason' => 'Сабаб:',
	'checkuser-showlog' => 'Намоиши гузориш',
	'checkuser-query' => 'Ҷустуҷӯи тағйироти охир',
	'checkuser-target' => 'Корбар ё нишонаи IP',
	'checkuser-users' => 'Феҳрист кардани корбарон',
	'checkuser-edits' => 'Намоиши вироишҳои марбут ба ин нишонаи IP',
	'checkuser-ips' => 'Феҳрист кардани нишонаҳои IP',
	'checkuser-search' => 'Ҷустуҷӯ',
	'checkuser-period' => 'Тӯл:',
	'checkuser-week-1' => 'ҳафта гузашта',
	'checkuser-week-2' => 'ду ҳафтаи гузашта',
	'checkuser-month' => '30 рӯзи гузашта',
	'checkuser-all' => 'ҳама',
	'checkuser-empty' => 'Гузориш холӣ аст.',
	'checkuser-nomatch' => 'Мавриде ки мутобиқат дошта бошад пайдо нашуд',
	'checkuser-nomatch-edits' => 'Ҳеҷ мутобиқате ёфт нашуд.
Охирин вироиш дар $1 соати $2 буд.',
	'checkuser-check' => 'Барраси',
	'checkuser-log-fail' => 'Имкони афзудани иттилоот ба гузориш вуҷуд надорад',
	'checkuser-nolog' => 'Парвандаи гузориш пайдо нашуд.',
	'checkuser-blocked' => 'Дастрасӣ қатъ шуд',
	'checkuser-gblocked' => 'Басташуда сартосарӣ',
	'checkuser-wasblocked' => 'Қаблан баста шуда',
	'checkuser-localonly' => 'Якка нашуда',
	'checkuser-massblock' => 'Корбарони интихобшуда баста шаванд',
	'checkuser-blocktag' => 'Ҷойгузин кардани саҳифаҳои корбарон бо:',
	'checkuser-blocktag-talk' => 'Ҷойгузин кардани саҳифаҳои баҳс бо:',
	'checkuser-block-limit' => 'Теъдоди беш аз шумораи корбарон интихоб шудаанд.',
	'checkuser-too-many' => 'Теъдоди натоиҷ бисёр зиёд аст. Лутфан CIDRро бориктар кунед. Дар зер нишонаҳои IP-ро мебинед (5000 ҳадди аксар, аз рбатартиби нинона):',
	'checkuser-user-nonexistent' => 'Корбари мавриди назар вуҷуд надорад.',
	'checkuser-search-form' => 'Пайдо кардани маворид дар гузоришҳо, ки $1 дар он $2 аст',
	'checkuser-search-submit' => 'Ҷустуҷӯ',
	'checkuser-search-initiator' => 'оғозгар',
	'checkuser-search-target' => 'ҳадаф',
	'checkuser-log-return' => 'Бозгашт ба форми аслии бозрасии корбар',
	'checkuser-log-userips' => '$1 нишонаҳои интернетии IP-ҳои $2ро гирифт',
	'checkuser-log-ipedits' => '$1 вироишҳои $2ро гирифт',
	'checkuser-log-ipusers' => '$1 корбарони марбут ба $2ро гирифт',
	'checkuser-log-ipedits-xff' => '$1 вироишҳои XFF $2ро гирифт',
	'checkuser-log-ipusers-xff' => '$1 корбарони марбут ба XFF $2ро гирифт',
	'checkuser-autocreate-action' => 'ба таври худкор эҷод шуда буд',
	'checkuser-email-action' => 'почтаи электронӣ ба корбар "$1" фиристода шуд',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'checkuser-summary' => 'In abzor taƣjiroti oxirro baroi ba dast ovardani nişonahoi internetī IP  istifoda şuda tavassuti jak korbar jo ta\'jini viroişhoi ancom şuda tariqi jak nişonai internetī IP, çustuçū mekunad.
Korbaron va viroişhoi jak nişonai internetiji IP-ro metavon bo tavaççūh ba ittiloot sar ojand tariqi XFF bo afzudan nişonai internetī IP bo "/xff" pajdo kard. Har du protokol IPv4 (CIDR 16-32) va IPv6 (CIDR 64-128) tavassuti in abzor puştibonī meşavand.
Na beş az 5000 viroiş bo dalelhoi zudkorī bargardonida xohand şud. Bo muvofiqi sijosat va qoidaho inro istoda kuned.',
	'checkuser-desc' => 'Ba korbaron ixtijoroti lozimiro baroi barrasiji nişonahoi internetī IP korbaron va ittilooti digar, içozat medihad',
	'checkuser-logcase' => 'Çustuçūi guzoriş ba xurd jo buzrg budani harfho hasos ast.',
	'checkuser' => 'Bozrasiji korbar',
	'checkuserlog' => 'BozrasiKorbar guzoriş',
	'group-checkuser' => 'Bozrasiji korbaron',
	'group-checkuser-member' => 'Bozrasiji korbar',
	'right-checkuser' => 'Barrasi kardani nişonai IP va digar ittilooti korbar',
	'grouppage-checkuser' => '{{ns:project}}:Bozrasiji korbar',
	'checkuser-reason' => 'Sabab:',
	'checkuser-showlog' => 'Namoişi guzoriş',
	'checkuser-query' => 'Çustuçūi taƣjiroti oxir',
	'checkuser-users' => 'Fehrist kardani korbaron',
	'checkuser-edits' => 'Namoişi viroişhoi marbut ba in nişonai IP',
	'checkuser-ips' => 'Fehrist kardani nişonahoi IP',
	'checkuser-search' => 'Çustuçū',
	'checkuser-period' => 'Tūl:',
	'checkuser-week-1' => 'hafta guzaşta',
	'checkuser-week-2' => 'du haftai guzaşta',
	'checkuser-month' => '30 rūzi guzaşta',
	'checkuser-all' => 'hama',
	'checkuser-empty' => 'Guzoriş xolī ast.',
	'checkuser-nomatch' => 'Mavride ki mutobiqat doşta boşad pajdo naşud',
	'checkuser-nomatch-edits' => 'Heç mutobiqate joft naşud.
Oxirin viroiş dar $1 soati $2 bud.',
	'checkuser-check' => 'Barrasi',
	'checkuser-log-fail' => 'Imkoni afzudani ittiloot ba guzoriş vuçud nadorad',
	'checkuser-nolog' => 'Parvandai guzoriş pajdo naşud.',
	'checkuser-blocked' => "Dastrasī qat' şud",
	'checkuser-gblocked' => 'Bastaşuda sartosarī',
	'checkuser-wasblocked' => 'Qablan basta şuda',
	'checkuser-localonly' => 'Jakka naşuda',
	'checkuser-massblock' => 'Korbaroni intixobşuda basta şavand',
	'checkuser-blocktag' => 'Çojguzin kardani sahifahoi korbaron bo:',
	'checkuser-blocktag-talk' => 'Çojguzin kardani sahifahoi bahs bo:',
	'checkuser-block-limit' => "Te'dodi beş az şumorai korbaron intixob şudaand.",
	'checkuser-user-nonexistent' => 'Korbari mavridi nazar vuçud nadorad.',
	'checkuser-search-form' => 'Pajdo kardani mavorid dar guzorişho, ki $1 dar on $2 ast',
	'checkuser-search-submit' => 'Çustuçū',
	'checkuser-search-initiator' => 'oƣozgar',
	'checkuser-search-target' => 'hadaf',
	'checkuser-log-return' => 'Bozgaşt ba formi asliji bozrasiji korbar',
	'checkuser-log-userips' => '$1 nişonahoi internetiji IP-hoi $2ro girift',
	'checkuser-log-ipedits' => '$1 viroişhoi $2ro girift',
	'checkuser-log-ipusers' => '$1 korbaroni marbut ba $2ro girift',
	'checkuser-log-ipedits-xff' => '$1 viroişhoi XFF $2ro girift',
	'checkuser-log-ipusers-xff' => '$1 korbaroni marbut ba XFF $2ro girift',
	'checkuser-autocreate-action' => 'ba tavri xudkor eçod şuda bud',
	'checkuser-email-action' => 'poctai elektronī ba korbar "$1" firistoda şud',
);

/** Thai (ไทย)
 * @author Mopza
 * @author Octahedron80
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'checkuser' => 'ตรวจสอบผู้ใช้',
	'checkuserlog' => 'ประวัติการตรวจสอบผู้ใช้',
	'checkuser-contribs' => 'ตรวจสอบหมายเลขไอพีของผู้ใช้',
	'group-checkuser' => 'ตรวจสอบผู้ใช้',
	'group-checkuser-member' => 'ตรวจสอบผู้ใช้',
	'right-checkuser' => 'ตรวจสอบหมายเลขไอพีของผู้ใช้และข้อมูลอื่นๆ',
	'right-checkuser-log' => 'ดูประวัติการตรวจสอบผู้ใช้',
	'grouppage-checkuser' => '{{ns:project}}:ตรวจสอบผู้ใช้',
	'checkuser-reason' => 'เหตุผล:',
	'checkuser-showlog' => 'แสดงประวัติ',
	'checkuser-query' => 'แบบสอบถามการเปลี่ยนแปลงล่าสุด',
	'checkuser-target' => 'หมายเลขไอพีหรือชื่อผู้ใช้:',
	'checkuser-users' => 'รับชื่อผู้ใช้',
	'checkuser-edits' => 'รับรายการแก้ไขจากหมายเลขไอพี',
	'checkuser-ips' => 'รับรายการหมายเลขไอพี',
	'checkuser-search' => 'สืบค้น',
	'checkuser-period' => 'ระยะเวลา:',
	'checkuser-week-1' => 'สัปดาห์ที่แล้ว',
	'checkuser-week-2' => '2 สัปดาห์ที่แล้ว',
	'checkuser-month' => '30 วันที่แล้ว',
	'checkuser-all' => 'ทั้งหมด',
	'checkuser-nomatch' => 'ไม่พบสิ่งที่ค้นหา',
	'checkuser-blocktag' => 'แทนที่หน้าผู้ใช้ด้วย:',
	'checkuser-blocktag-talk' => 'แทนที่หน้าพูดคุยด้วย:',
	'checkuser-massblock-commit' => 'ระงับผู้ใช้ที่เลือก',
	'checkuser-block-success' => "'''{{PLURAL:$2|ผู้ใช้|ผู้ใช้}}ชื่อ $1 {{PLURAL:$2|ได้ถูก|ได้ถูก}}ระงับการใช้แล้ว'''",
	'checkuser-block-failure' => "'''ไม่มีผู้ใช้ถูกระงับ'''",
	'checkuser-block-limit' => 'เลือกผู้ใช้มากเกินไป',
	'checkuser-block-noreason' => 'คุณต้องให้เหตุผลในการระงับด้วย',
	'checkuser-too-many' => 'มีผลลัพธ์มากเกินไป (จากการคาดคะเนของแบบสอบถาม) กรุณาทำให้ CIDR เฉพาะเจาะจงมากขึ้น
นี่คือหมายเลขไอพีที่ถูกใช้ (สูงสุด 5000 เรียงตามหมายเลขไอพี)',
	'checkuser-user-nonexistent' => 'ไม่พบผู้ใช้ที่กำหนด',
	'checkuser-search-submit' => 'สืบค้น',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'checkuser-desc' => 'Ulanyjylaryň IP adreslerini we beýleki maglumatlaryny barlamak hukugy üçin degişli rugsatlary ulanyjylara berýär',
	'checkuser-logcase' => 'Gündelik gözlegi baş-setir harpa duýgurdyr.',
	'checkuser' => 'Ulanyjy barla',
	'checkuserlog' => 'Ulanyjy barlaýjysy gündeligi',
	'checkuser-contribs' => 'ulanyjy IP adreslerini barla',
	'group-checkuser' => 'Ulanyjy barlaýjylary',
	'group-checkuser-member' => 'Ulanyjy barlaýjysy',
	'right-checkuser' => 'Ulanyjylaryň IP adreslerini we baş maglumatlaryny barla',
	'right-checkuser-log' => 'Ulanyjy barlaýjysy gündeligini görkez',
	'grouppage-checkuser' => '{{ns:project}}:Ulanyjy barlaýjysy',
	'checkuser-reason' => 'Sebäp:',
	'checkuser-showlog' => 'Gündeligi görkez',
	'checkuser-query' => 'Soňky üýtgeşmeleri sora',
	'checkuser-target' => 'IP adresi ýa-da ulanyjy ady:',
	'checkuser-users' => 'Ulanyjylary al',
	'checkuser-edits' => 'IP-den özgerdişleri al',
	'checkuser-ips' => 'IP adreslerini al',
	'checkuser-search' => 'Gözle',
	'checkuser-period' => 'Dowamlylyk:',
	'checkuser-week-1' => 'soňky hepde',
	'checkuser-week-2' => 'soňky iki hepde',
	'checkuser-month' => 'soňky 30 gün',
	'checkuser-all' => 'ählisi',
	'checkuser-cidr-res' => 'Umumy CIDR:',
	'checkuser-empty' => 'Gündelikde hiç zat ýok.',
	'checkuser-nomatch' => 'Gabat gelýän zat tapylmady.',
	'checkuser-nomatch-edits' => 'Gabat gelýän zat tapylmady.
Soňky özgerdiş $2, $1 senesinde.',
	'checkuser-check' => 'Barla',
	'checkuser-log-fail' => 'Gündelik girişini goşup bolmaýar',
	'checkuser-nolog' => 'Hiç hili gündelik faýly tapylmady.',
	'checkuser-blocked' => 'Blokirlendi',
	'checkuser-gblocked' => 'Global blokirlendi',
	'checkuser-locked' => 'Gulply',
	'checkuser-wasblocked' => 'Ozaldan blokirlenen',
	'checkuser-localonly' => 'Birleşdirilmedik',
	'checkuser-massblock' => 'Saýlanylan ulanyjylary blokirle',
	'checkuser-blocktag' => 'Ulanyjy sahypalaryny şuňa çalşyr:',
	'checkuser-blocktag-talk' => 'Pikir alyşma sahypalaryny şuňa çalşyr:',
	'checkuser-massblock-commit' => 'Saýlanylan ulanyjylary blokirle',
	'checkuser-block-success' => "'''$1 {{PLURAL:$2|ulanyjy|ulanyjy}} indi blokirlendi.'''",
	'checkuser-block-failure' => "'''Hiç bir ulanyjy blokirlenmedi.'''",
	'checkuser-block-limit' => 'Aşa köp ulanyjy saýlanyldy.',
	'checkuser-block-noreason' => 'Blokirlemeler üçin sebäp görkezmeli.',
	'checkuser-noreason' => 'Bu talap üçin sebäp görkezmeli.',
	'checkuser-accounts' => '$1 täze {{PLURAL:$1|hasap|hasap}}',
	'checkuser-user-nonexistent' => 'Görkezilen ulanyjy ýok.',
	'checkuser-search-form' => '$1-iň $2 bolan gündelik girişlerini tap',
	'checkuser-search-submit' => 'Gözle',
	'checkuser-search-initiator' => 'başladan',
	'checkuser-search-target' => 'niýetlenilýän',
	'checkuser-ipeditcount' => 'ähli ulanyjylardan ~$1',
	'checkuser-log-userips' => '$1, $2 üçin IP adresleri aldy',
	'checkuser-log-ipedits' => '$1, $2 üçin özgerdişleri aldy',
	'checkuser-log-ipusers' => '$1, $2 üçin ulanyjylary aldy',
	'checkuser-log-ipedits-xff' => '$1, XFF $2 üçin özgerdişleri aldy',
	'checkuser-log-ipusers-xff' => '$1, XFF $2 üçin ulanyjylary aldy',
	'checkuser-log-useredits' => '$1, $2 üçin özgerdişleri aldy',
	'checkuser-autocreate-action' => 'awtomatik döredildi',
	'checkuser-email-action' => '"$1" ulanyjysyna e-poçta iberdi',
	'checkuser-reset-action' => '"$1" ulanyjysy üçin paroly başky ýagdaýa getirdi',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'checkuser-summary' => 'Nagmamasid ng kamakailang mga pagbabago ang kasangkapang ito upang makuhang muli ang ginamit na mga IP ng tagagamit o ipakita ang dato ng pagbabago/tagagamit para sa isang IP.
Ang mga tagagamit at mga pagbabagong ginawa ng isang IP ng kliyente ay maaaring kuhaning muli sa pamamagitan ng paggamit ng mga paulong XFF sa pamamagitan ng pagkakabit ng "/xff" sa IP.
Sinusuportahan ang IPv4 (CIDR 16-32) at ang IPv6 (CIDR 64-128).
Walang mas mataas sa 5000 mga pagbabago ang ibabalik dahil sa mga kadahilanang pangpagsasagawa.
Gamitin ito ayon sa patakaran.',
	'checkuser-desc' => 'Nagbibigay sa mga tagagamit ng naaangkop na pahintulot ang kakayahang suriin ang mga adres ng IP ng tagagamit at iba pang kabatiran (impormasyon)',
	'checkuser-logcase' => 'May kaselanan sa pagmamakinilya ng panitik ang paghahanap ng talaan.',
	'checkuser' => 'Suriin ang tagagamit',
	'checkuserlog' => 'Talaang SuriinTagagamit',
	'checkuser-contribs' => 'suriin ang mga adres ng IP ng tagagamit',
	'group-checkuser' => 'Suriin ang mga tagagamit',
	'group-checkuser-member' => 'Suriin ang tagagamit',
	'right-checkuser' => 'Suriin ang adres ng IP at iba pang mga kabatiran (impormasyon) ng tagagamit',
	'right-checkuser-log' => 'Tingnan ang talaan ng pagsuri sa tagagamit',
	'grouppage-checkuser' => '{{ns:project}}:Suriin ang tagagamit',
	'checkuser-reason' => 'Dahilan:',
	'checkuser-showlog' => 'Ipakita ang talaan',
	'checkuser-query' => 'Magtanong hinggil sa kamakailang mga pagbabago',
	'checkuser-target' => 'Adres ng IP o tagagamit:',
	'checkuser-users' => 'Kunin ang mga tagagamit',
	'checkuser-edits' => 'Kunin ang mga pagbabago',
	'checkuser-ips' => 'Kunin ang mga IP',
	'checkuser-search' => 'Maghanap',
	'checkuser-period' => 'Tagal ng panahon:',
	'checkuser-week-1' => 'nakaraang linggo',
	'checkuser-week-2' => 'huling dalawang mga linggo',
	'checkuser-month' => 'huling 30 mga araw',
	'checkuser-all' => 'lahat',
	'checkuser-cidr-label' => 'Hanapin ang karaniwang saklaw at apektadong mga adres para sa isang talaan ng mga IP',
	'checkuser-cidr-res' => 'Karaniwang CIDR:',
	'checkuser-empty' => 'Walang lamang mga bagay ang talaan.',
	'checkuser-nomatch' => 'Walang natagpuang mga pagtutugma.',
	'checkuser-nomatch-edits' => 'Walang natagpuang mga pagtutugma.
Ang huling pagbabago ay noong $1 sa $2.',
	'checkuser-check' => 'Suriin',
	'checkuser-log-fail' => 'Hindi nagawang idagdag ang ipinasok sa talaan',
	'checkuser-nolog' => 'Walang natagpuang talaksan ng talaan.',
	'checkuser-blocked' => 'Hinadlangan',
	'checkuser-gblocked' => 'Hinadlangan na pandaigdigan',
	'checkuser-locked' => 'Ikinandado',
	'checkuser-wasblocked' => 'Hinadlangan dati',
	'checkuser-localonly' => 'Hindi pinag-isa',
	'checkuser-massblock' => 'Harangin ang napiling mga tagagamit',
	'checkuser-massblock-text' => 'Ang napiling mga kuwenta ay hahadlangan magpasawalang hanggan, na may pinagaganang kusang pagharang at hindi pinaaandar na paglikha ng akawnt.
Hahadlangan ang mga adres ng IP sa loob ng 1 linggo para sa mga tagagamit ng IP lamang at hindi pinagagana ang paglikha ng kuwenta.',
	'checkuser-blocktag' => 'Palitan ang mga pahina ng tagagamit ng:',
	'checkuser-blocktag-talk' => 'Palitan ang mga pahina ng usapan ng:',
	'checkuser-massblock-commit' => 'Hadlangan ang napiling mga tagagamit',
	'checkuser-block-success' => "'''Ang {{PLURAL:$2|tagagamit|mga tagagamit}} na si/sina $1 {{PLURAL:$2|ay|ay mga}} hinadlangan na ngayon.'''",
	'checkuser-block-failure' => "'''Walang nahadlangang mga tagagamit.'''",
	'checkuser-block-limit' => 'Napakaraming napiling mga tagagamit.',
	'checkuser-block-noreason' => 'Dapat kang magbigay ng isang dahilan para sa mga paghahadlang.',
	'checkuser-noreason' => 'Dapat kang magbigay ng dahilan para sa tanong na ito.',
	'checkuser-accounts' => '$1 bagong {{PLURAL:$1|kuwenta|mga kuwenta}}',
	'checkuser-too-many' => 'Napakaraming mga resulta (ayon sa taya ng pagtatanong), pakikiputan pababa ang CIDR.
Narito ang ginamit na mga IP (5000 pinakamarami, inayos ayon sa adres):',
	'checkuser-user-nonexistent' => 'Hindi umiiral ang tinukoy na tagagamit.',
	'checkuser-search-form' => 'Maghanap ng mga paglalagay sa talaan kung saan ang $1 ay $2',
	'checkuser-search-submit' => 'Hanapin',
	'checkuser-search-initiator' => 'tagapagsimula',
	'checkuser-search-target' => 'puntirya',
	'checkuser-ipeditcount' => '~$1 mula sa lahat ng mga tagagamit',
	'checkuser-log-return' => 'Bumalik sa pangunahing pormularyong SuriinTagagamit<!--CheckUser-->',
	'checkuser-limited' => "'''Pinutol o pinungusan ang mga resulta dahil sa mga kadahilanang panggawain (pagsasagawa).'''",
	'checkuser-log-userips' => 'Nakakuha si $1 ng mga IP para kay $2',
	'checkuser-log-ipedits' => 'Nakakuha si $1 ng mga pagbabago para kay $2',
	'checkuser-log-ipusers' => 'Nakakuha si $1 ng mga tagagamit para sa $2',
	'checkuser-log-ipedits-xff' => 'Nakakuha si $1 ng mga pagbabago para sa XFF na $2',
	'checkuser-log-ipusers-xff' => 'Nakakuha si $1 ng mga tagagamit para sa XFF na $2',
	'checkuser-log-useredits' => 'Nakakuha si $1 ng mga pagbabago para sa $2',
	'checkuser-autocreate-action' => 'ay kusang nalikha',
	'checkuser-email-action' => 'nagpadala ng isang e-liham patungo kay tagagamit na "$1"',
	'checkuser-reset-action' => 'muling itakda ang hudyat para kay tagagamit na "$1"',
);

/** Tongan (lea faka-Tonga) */
$messages['to'] = array(
	'checkuser' => 'Siviʻi ʻa e ʻetita',
	'group-checkuser' => 'Siviʻi kau ʻetita',
	'group-checkuser-member' => 'Siviʻi ʻa e ʻetita',
);

/** Tok Pisin (Tok Pisin)
 * @author Iketsi
 */
$messages['tpi'] = array(
	'checkuser-search' => 'Painim',
	'checkuser-search-submit' => 'Painim',
);

/** Turkish (Türkçe)
 * @author Dbl2010
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Karduelis
 * @author Mach
 * @author Suelnur
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'checkuser-summary' => "Bu araç bir kullanıcı tarafından kullanılan IP'leri almak için son değişiklikleri tarar ya da bir IP için değişiklik/kullanıcı verisini gösterir.
Alıcı IP'deki kullanıcı ve değişiklikler, IP'ye \"/xff\" eklenmesiyle XFF başlıklarıyla alınabilir. IPv4 (CIDR 16-32) ve IPv6 (CIDR 64-128) desteklenmektedir.
Performans nedeniyle 5000'den fazla değişiklik dönmeyecektir.
Bunu ilkelere uygun olarak kullanın.",
	'checkuser-desc' => 'Kullanıcıların IP adreslerini ve diğer bilgilerini denetleme yeteneği için, uygun izinleri kullanıcılara tahsis eder',
	'checkuser-logcase' => 'Günlük araması büyük-küçük harfe duyarlıdır.',
	'checkuser' => 'IP denetçisi',
	'checkuserlog' => 'Denetçi kaydı',
	'checkuser-contribs' => 'kullanıcı IPlerini kontrol et',
	'group-checkuser' => 'Denetçiler',
	'group-checkuser-member' => 'Denetçi',
	'right-checkuser' => 'Kullanıcıların IP adreslerini ve diğer bilgilerini denetle',
	'right-checkuser-log' => 'Kullanıcıdenetle günlüğünü gör',
	'grouppage-checkuser' => '{{ns:project}}:Denetçi',
	'checkuser-reason' => 'Gerekçe:',
	'checkuser-showlog' => 'Logu göster',
	'checkuser-query' => 'Son değişiklikleri sorgula',
	'checkuser-target' => 'IP adresi veya kullanıcı adı:',
	'checkuser-users' => 'Kullanıcıları bulup getir',
	'checkuser-edits' => 'Değişiklikleri al',
	'checkuser-ips' => 'IPleri bulup getir',
	'checkuser-search' => 'Ara',
	'checkuser-period' => 'Süre:',
	'checkuser-week-1' => 'son hafta',
	'checkuser-week-2' => 'son iki hafta',
	'checkuser-month' => 'son 30 gün',
	'checkuser-all' => 'hepsi',
	'checkuser-cidr-label' => 'Bir IP listesi için ortak aralığı ve etkilenen adresleri bul',
	'checkuser-cidr-res' => 'Ortak CIDR:',
	'checkuser-empty' => 'Günlükte başka öğe yok.',
	'checkuser-nomatch' => 'Eşleşen bulunamadı.',
	'checkuser-nomatch-edits' => 'Eşleşen bulunamadı.
Son değişiklik $1 tarihinde $2 saatinde.',
	'checkuser-check' => 'Kontrol et',
	'checkuser-log-fail' => 'Günlük girdisi eklenemiyor',
	'checkuser-nolog' => 'Günlük dosyası bulunamadı.',
	'checkuser-blocked' => 'Engellendi',
	'checkuser-gblocked' => 'Küresel olarak engellendi',
	'checkuser-locked' => 'Kilitli',
	'checkuser-wasblocked' => 'Önceden engellenmiş',
	'checkuser-localonly' => 'Birleştirilmemiş',
	'checkuser-massblock' => 'Seçili kullanıcıları engelle',
	'checkuser-massblock-text' => 'Seçili hesaplar süresiz olarak engellenecektir, otomatik engelleme devrede ve hesap oluşturma devre dışı olarak.
IP adresleri sadece IP kullanıcıları için 1 hafta boyunca engellenecektir ve hesap oluşturma devre dışı olacaktır.',
	'checkuser-blocktag' => 'Kullanıcı sayfalarını şununla yer değiştir:',
	'checkuser-blocktag-talk' => 'Tartışma sayfalarını şununla yer değiştir:',
	'checkuser-massblock-commit' => 'Seçili kullanıcıları engelle',
	'checkuser-block-success' => "'''$1 {{PLURAL:$2|kullanıcısı|kullanıcıları}} artık engellendi.'''",
	'checkuser-block-failure' => "'''Hiçbir kullanıcı engellenmedi.'''",
	'checkuser-block-limit' => 'Çok fazla kullanıcı seçildi.',
	'checkuser-block-noreason' => 'Engellemeler için bir neden belirtmelisiniz.',
	'checkuser-noreason' => 'Bu sorgu için bir sebep göstermelisiniz.',
	'checkuser-accounts' => '$1 yeni {{PLURAL:$1|hesap|hesap}}',
	'checkuser-too-many' => "Çok fazla sonuç var (sorgu tahminine göre), lütfen CIDR'ı daraltın.
Kullanılan IP'ler (max 5000, adrese göre sıralı):",
	'checkuser-user-nonexistent' => 'Belirtilen kullanıcı mevcut değil.',
	'checkuser-search-form' => "$1'in $2 olduğu günlük girişlerini bul",
	'checkuser-search-submit' => 'Ara',
	'checkuser-search-initiator' => 'Başlatan',
	'checkuser-search-target' => 'Hedef',
	'checkuser-ipeditcount' => 'tüm kullanıcılardan ~$1',
	'checkuser-log-return' => 'KullancıDenetle ana formuna geri dön',
	'checkuser-limited' => "'''Performans nedeniyle sonuçlar kırpıldı.'''",
	'checkuser-log-userips' => '$1, $2 için IPleri aldı',
	'checkuser-log-ipedits' => '$1, $2 için değişiklikleri aldı',
	'checkuser-log-ipusers' => '$1, $2 için kullanıcıları aldı',
	'checkuser-log-ipedits-xff' => '$1, XFF $2 için değişiklikleri aldı',
	'checkuser-log-ipusers-xff' => '$1, XFF $2 için kullanıcıları aldı',
	'checkuser-log-useredits' => '$1, $2 için değişiklikleri aldı',
	'checkuser-autocreate-action' => 'otomatik olarak oluşturuldu',
	'checkuser-email-action' => '"$1" kullanıcısına e-posta gönder',
	'checkuser-reset-action' => '"$1" kullanıcısı için parolayı sıfırla',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'group-checkuser' => 'Кулланучыларны тикшереп торучылар',
	'group-checkuser-member' => 'кулланучыларны тикшереп торучы',
	'right-checkuser' => 'куланучының IP-юлламасын тикшерү',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Dim Grits
 * @author NickK
 * @author Prima klasy4na
 * @author Sodmy
 * @author Тест
 */
$messages['uk'] = array(
	'checkuser-summary' => 'Цей засіб переглядає нові редагування для отримання IP-адрес, які використовував певний користувач, або щоб знайти редагування/користувача за IP-адресою.
Редагування і користувачів, що редагували з певної IP-адреси, заначеної в X-Forwarded-For, можна отримати, додавши префікс <code>/xff</code> до IP-адреси. Підтримувані версії IP: 4 (CIDR 16—32) і 6 (CIDR 64—128).
З огляду на продуктивність буде показано не більше 5000 редагувань.
Використовуйте цей засіб тільки відповідно до правил.',
	'checkuser-desc' => 'Надання можливості перевіряти IP-адреси та іншу інформацію користувачів',
	'checkuser-logcase' => 'Пошук у журналі чутливий до регістру.',
	'checkuser' => 'Перевірити користувача',
	'checkuserlog' => 'Журнал перевірки користувачів',
	'checkuser-contribs' => 'перевірити IP-адреси користувача',
	'group-checkuser' => "Чек'юзери",
	'group-checkuser-member' => "чек'юзер",
	'right-checkuser' => 'Перевірка IP-адрес та іншої інформації користувача',
	'right-checkuser-log' => 'Перегляд журналу перевірки користувачів',
	'action-checkuser' => 'перевіряти IP-адреси користувача та іншу інформацію',
	'action-checkuser-log' => 'перегляд журналу перевірки користувачів',
	'grouppage-checkuser' => '{{ns:project}}:Перевірка користувачів',
	'checkuser-reason' => 'Причина:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Показати журнал',
	'checkuser-query' => 'Переглянути останні зміни',
	'checkuser-target' => "IP-адреса або ім'я користувача:",
	'checkuser-users' => 'Отримати користувачів',
	'checkuser-edits' => 'Отримати редагування',
	'checkuser-ips' => 'Отримати IP-адреси',
	'checkuser-search' => 'Знайти',
	'checkuser-period' => 'Тривалість:',
	'checkuser-week-1' => 'останній тиждень',
	'checkuser-week-2' => 'останні два тижні',
	'checkuser-month' => 'останні 30 днів',
	'checkuser-all' => 'усі',
	'checkuser-cidr-label' => 'Знайти загальний діапазон і задіяні адреси для списку IP-адрес',
	'checkuser-cidr-res' => 'Спільний CIDR:',
	'checkuser-empty' => 'Журнал порожній.',
	'checkuser-nomatch' => 'Не знайдено збігів.',
	'checkuser-nomatch-edits' => 'Збіги не знайдені.
Останнє редагування зроблене $1 о $2.',
	'checkuser-check' => 'Перевірити',
	'checkuser-log-fail' => 'Не в змозі додати запис до журналу',
	'checkuser-nolog' => 'Файл журналу не знайдений.',
	'checkuser-blocked' => 'Заблокований',
	'checkuser-gblocked' => 'Заблокований глобально',
	'checkuser-locked' => 'Закритий',
	'checkuser-wasblocked' => 'Раніше заблокований',
	'checkuser-localonly' => "Не об'єднана",
	'checkuser-massblock' => 'Заблокувати вибраних користувачів',
	'checkuser-massblock-text' => 'Вибрані облікові записи будуть заблоковані безстроково з автоблокуванням і забороною створення нових облікових записів.
IP-адреси користувачів, які не увійшли до системи будуть заблоковані на 1 тиждень із забороною створення нових облікових записів.',
	'checkuser-blocktag' => 'Замінити сторінки користувачів на:',
	'checkuser-blocktag-talk' => 'Замінити сторінки обговорення на:',
	'checkuser-massblock-commit' => 'Заблокувати вибраних користувачів',
	'checkuser-block-success' => "'''Зараз {{PLURAL:$2|заблокований $1 користувач|заблоковані $1 користувачі|заблоковані $1 користувачів}}.'''",
	'checkuser-block-failure' => "'''Немає заблокованих користувачів.'''",
	'checkuser-block-limit' => 'Вибрано забагато користувачів.',
	'checkuser-block-noreason' => 'Ви повинні вказати причину блокувань.',
	'checkuser-noreason' => 'Вам необхідно зазначити причину цього запиту.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|новий обліковий запис|нові облікові записи|нових облікових записів}}',
	'checkuser-too-many' => 'Забагато результатів (згідно з оцінкою запиту), будь ласка, звузьте CIDR.
Використані IP (максимум 5000, відсортовані за адресою):',
	'checkuser-user-nonexistent' => 'Зазначений користувач не існує.',
	'checkuser-search-form' => 'Знайти записи журналу, де $1 є $2',
	'checkuser-search-submit' => 'Знайти',
	'checkuser-search-initiator' => 'ініціатор',
	'checkuser-search-target' => 'ціль',
	'checkuser-ipeditcount' => '~$1 від усіх користувачів',
	'checkuser-log-return' => 'Повернення до головної форми перевірки користувачів',
	'checkuser-limited' => "'''Результати урізано, щоб не обтяжувати сервер.'''",
	'checkuser-log-userips' => '$1 отримав IP-адреси для $2',
	'checkuser-log-ipedits' => '$1 отримав редагування для $2',
	'checkuser-log-ipusers' => '$1 отримав облікові записи для $2',
	'checkuser-log-ipedits-xff' => '$1 отримав редагування для XFF $2',
	'checkuser-log-ipusers-xff' => '$1 отримав облікові записи для XFF $2',
	'checkuser-log-useredits' => '$1 отримав редагування $2',
	'checkuser-autocreate-action' => 'створений автоматично',
	'checkuser-create-action' => 'створено',
	'checkuser-email-action' => 'надіслав листа користувачеві «$1»',
	'checkuser-reset-action' => 'скинув пароль для користувача $1',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'checkuser-reason' => 'وجہ:',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'checkuser-summary' => 'Sto strumento qua l\'analiza le modifiche reçenti par recuperar i indirizi IP doparà da un utente o mostrar contributi e dati de un IP. Utenti e contributi de un client IP i se pol rintraciar atraverso i header XFF, zontàndoghe a l\'IP el suffisso "/xff". Xe suportà IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128). No sarà restituìe piassè de 5.000 modifiche, par ragioni de prestazioni. Dòpara sto strumento in streta conformità a le policy.',
	'checkuser-desc' => 'Consente ai utenti co le oportune autorizazion de sotopor a verifica i indirizi IP e altre informazion relative ai utenti',
	'checkuser-logcase' => "La riçerca nei registri la xe ''case sensitive'' (cioè la distingue fra majuscole e minuscole).",
	'checkuser' => 'Controlo utenze',
	'checkuserlog' => 'Registro dei checkuser',
	'checkuser-contribs' => 'controlar i indirissi IP',
	'group-checkuser' => 'Controlori',
	'group-checkuser-member' => 'Controlor',
	'right-checkuser' => "Controla i indirissi IP de l'utente e altre informassion",
	'right-checkuser-log' => 'Varda el registro del controlo utenti (checkuser)',
	'grouppage-checkuser' => '{{ns:project}}:Controlo utenze',
	'checkuser-reason' => 'Motivo:',
	'checkuser-showlog' => 'Mostra el registro',
	'checkuser-query' => 'Çerca ne le ultime modifiche',
	'checkuser-target' => 'Utente o indirisso IP:',
	'checkuser-users' => 'Çerca utenti',
	'checkuser-edits' => 'Varda i contributi dei IP',
	'checkuser-ips' => 'Çerca IP',
	'checkuser-search' => 'Çerca',
	'checkuser-period' => 'Par quanto:',
	'checkuser-week-1' => 'ultima stimana',
	'checkuser-week-2' => 'ultime do stimane',
	'checkuser-month' => 'ultimi 30 zorni',
	'checkuser-all' => 'tuti quanti',
	'checkuser-cidr-label' => 'Sercar un interval comune e i indirissi interessà par na lista de IP',
	'checkuser-cidr-res' => 'CIDR comune:',
	'checkuser-empty' => "El registro no'l contien dati.",
	'checkuser-nomatch' => 'Nissun risultato catà.',
	'checkuser-nomatch-edits' => "No xe stà catà nissun risultato.
L'ultima modìfega la xe stà a le ore $2 del $1.",
	'checkuser-check' => 'Controla',
	'checkuser-log-fail' => 'Inpossibile zontar la voçe al registro',
	'checkuser-nolog' => 'No xe stà catà nissun file de registro.',
	'checkuser-blocked' => 'Blocà',
	'checkuser-gblocked' => 'Blocà globalmente',
	'checkuser-locked' => 'Blocà',
	'checkuser-wasblocked' => 'Blocà zà in precedensa',
	'checkuser-localonly' => 'Mia unifegà',
	'checkuser-massblock' => 'Bloca i utenti selessionà',
	'checkuser-massblock-text' => "Le utense selezionà le vegnarà blocà par senpre, col bloco automatico inpizà e la creazion de utense nove disativà.
I indirissi IP i vegnarà blocà par na stimana solo par i utenti anonimi e co' la creazion de utense disativà.",
	'checkuser-blocktag' => 'Sostituìssi le pagine utente con:',
	'checkuser-blocktag-talk' => 'Rinpiazza le pàxene de discussion con:',
	'checkuser-massblock-commit' => 'Bloca i utenti selessionà',
	'checkuser-block-success' => "'''{{PLURAL:$2|L'utente|I utenti}} $1 {{PLURAL:$2|el|i}} xe stà blocà.'''",
	'checkuser-block-failure' => "'''Nissun utente blocà.'''",
	'checkuser-block-limit' => 'Ti gà selessionà massa utenti.',
	'checkuser-block-noreason' => 'Ti gà da dar na motivassion par i blochi.',
	'checkuser-noreason' => 'Te ghè da indicar na motivassion par sta richiesta.',
	'checkuser-accounts' => '$1 account {{PLURAL:$1|novo|novi}}',
	'checkuser-too-many' => 'Vien fora massa risultati (secondo la stima), par piaser dòpara un CIDR piassè ristreto.
Sti qua i xe i IP doparà (fin a un massimo de 5000, ordinà par indirizo):',
	'checkuser-user-nonexistent' => "L'utente indicà no l'esiste mìa.",
	'checkuser-search-form' => 'Cata fora le voçi del registro par le quali $1 el xe $2',
	'checkuser-search-submit' => 'Riçerca',
	'checkuser-search-initiator' => 'iniziator',
	'checkuser-search-target' => 'obietivo',
	'checkuser-ipeditcount' => '~$1 par tuti i utenti',
	'checkuser-log-return' => 'Torna al modulo prinçipal de Controlo utenze',
	'checkuser-limited' => "'''Sti risultati i xe stà tajà a metà par motivi de prestazion.'''",
	'checkuser-log-userips' => '$1 el gà otegnù i indirizi IP de $2',
	'checkuser-log-ipedits' => '$1 el gà otegnù le modifiche de $2',
	'checkuser-log-ipusers' => '$1 el gà otegnù le utenze de $2',
	'checkuser-log-ipedits-xff' => '$1 el gà otegnù le modifiche de $2 via XFF',
	'checkuser-log-ipusers-xff' => '$1 el gà otegnù le utenze de $2 via XFF',
	'checkuser-log-useredits' => '$1 gà otegnù i contributi de $2',
	'checkuser-autocreate-action' => 'xe stà creà automaticamente',
	'checkuser-email-action' => 'gà mandà na e-mail a "$1"',
	'checkuser-reset-action' => 'reinposta la password par l\'utente "$1"',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'checkuser' => 'Kodvda kävutajad',
	'checkuserlog' => 'Kävutajiden kodvindan aigkirj',
	'group-checkuser' => 'Kodvda kävutajid',
	'checkuser-reason' => 'Sü:',
	'checkuser-showlog' => 'Ozutada aigkirj',
	'checkuser-query' => 'Ozutada veresid toižetusid',
	'checkuser-target' => 'Kävutai vai IP-adres',
	'checkuser-users' => 'Sada kävutajid',
	'checkuser-edits' => 'Sada toižetusid, kudambad oma tehtud IP-adresalpäi',
	'checkuser-search' => 'Ectä',
	'checkuser-all' => 'kaik',
	'checkuser-blocked' => 'Blokiruidud',
	'checkuser-locked' => 'Luklostadud',
	'checkuser-search-submit' => 'Ectä',
	'checkuser-search-initiator' => 'iniciator',
	'checkuser-search-target' => 'met',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'checkuser-summary' => 'Công cụ này sẽ quét các thay đổi gần đây để lấy ra các IP được một thành viên sử dụng hoặc hiển thị dữ liệu sửa đổi/tài khoản của một IP. Các tài khoản và sửa đổi của một IP có thể được trích ra từ tiêu đề XFF bằng cách thêm vào IP “/xff”. IPv4 (CIDR 16-32) và IPv6 (CIDR 64-128) đều được hỗ trợ. Không quá 5000 sửa đổi sẽ được trả về vì lý do hiệu suất. Hãy dùng công cụ này theo đúng quy định.',
	'checkuser-desc' => 'Cung cấp cho những người đủ tiêu chuẩn khả năng kiểm tra địa chỉ IP và thông tin khác của người dùng khác',
	'checkuser-logcase' => 'Tìm kiếm nhật trình có phân biệt chữ hoa chữ thường',
	'checkuser' => 'Kiểm định viên',
	'checkuserlog' => 'Nhật trình CheckUser',
	'checkuser-contribs' => 'kiểm tra IP của người dùng',
	'group-checkuser' => 'Kiểm định viên',
	'group-checkuser-member' => '{{GENDER:$1}}kiểm định viên',
	'right-checkuser' => 'Kiểm tra địa chỉ IP và các thông tin khác của thành viên',
	'right-checkuser-log' => 'Xem nhật trình CheckUser',
	'action-checkuser' => 'kiểm tra địa chỉ IP và các thông tin khác của thành viên',
	'action-checkuser-log' => 'xem nhật trình CheckUser',
	'grouppage-checkuser' => '{{ns:project}}:Kiểm định viên',
	'checkuser-reason' => 'Lý do:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'Xem nhật trình',
	'checkuser-query' => 'Truy vấn các thay đổi gần đây',
	'checkuser-target' => 'Tên người dùng hay địa chỉ IP:',
	'checkuser-users' => 'Lấy ra thành viên',
	'checkuser-edits' => 'Lấy ra sửa đổi',
	'checkuser-ips' => 'Lấy ra IP',
	'checkuser-search' => 'Tìm kiếm',
	'checkuser-period' => 'Thời gian:',
	'checkuser-week-1' => 'tuần trước',
	'checkuser-week-2' => 'hai tuần trước',
	'checkuser-month' => '30 ngày trước',
	'checkuser-all' => 'tất cả',
	'checkuser-cidr-label' => 'Tìm dãy phổ biến và các địa chỉ bị ảnh hưởng của danh sách IP',
	'checkuser-cidr-res' => 'CIDR thông thường:',
	'checkuser-empty' => 'Nhật trình hiện chưa có gì.',
	'checkuser-nomatch' => 'Không tìm thấy kết quả.',
	'checkuser-nomatch-edits' => 'Không tìm thấy kết quả.
Lần sửa đổi cuối xảy ra $1 lúc $2.',
	'checkuser-check' => 'Kiểm tra',
	'checkuser-log-fail' => 'Không thể ghi vào nhật trình',
	'checkuser-nolog' => 'Không tìm thấy tập tin nhật trình',
	'checkuser-blocked' => 'Đã cấm',
	'checkuser-gblocked' => 'Cấm toàn cầu',
	'checkuser-locked' => 'Khóa',
	'checkuser-wasblocked' => 'Đã từng bị cấm',
	'checkuser-localonly' => 'Chưa thống nhất',
	'checkuser-massblock' => 'Cấm các người dùng được chọn',
	'checkuser-massblock-text' => 'Các tài khoản được chọn sẽ bị cấm vô hạn, cũng cấm mở tài khoản và tự động cấm các địa chỉ IP. Những người dùng những địa chỉ IP này sẽ bị cấm một tuần và không được mở tài khoản.',
	'checkuser-blocktag' => 'Thay thế các trang cá nhân bằng:',
	'checkuser-blocktag-talk' => 'Thay các trang thảo luận bằng:',
	'checkuser-massblock-commit' => 'Cấm những người dùng được chọn',
	'checkuser-block-success' => "'''{{PLURAL:$2|Người|Các người}} dùng $1 mới bị cấm.'''",
	'checkuser-block-failure' => "'''Không ai bị cấm.'''",
	'checkuser-block-limit' => 'Đã chọn nhiều người dùng quá.',
	'checkuser-block-noreason' => 'Phải đưa ra lý do cấm.',
	'checkuser-noreason' => 'Bạn phải đưa ra lý do truy vấn.',
	'checkuser-accounts' => '{{PLURAL:$1|tài khoản|tài khoản}} mới',
	'checkuser-too-many' => 'Có quá nhiều kết quả (theo ước lượng truy vấn). Xin hãy thu hẹp CIDR. Đây là các IP sử dụng (tối đa 5000, xếp theo địa chỉ):',
	'checkuser-user-nonexistent' => 'Thành viên chỉ định không tồn tại.',
	'checkuser-search-form' => 'Tìm thấy các mục nhật trình trong đó $1 là $2',
	'checkuser-search-submit' => 'Tìm kiếm',
	'checkuser-search-initiator' => 'người khởi đầu',
	'checkuser-search-target' => 'mục tiêu',
	'checkuser-ipeditcount' => '~$1 khỏi tất cả các thành viên',
	'checkuser-log-return' => 'Quay lại mẫu CheckUser chính',
	'checkuser-limited' => "'''Các kết quả đã được lược bớt để tăng hiệu suất hoạt động.'''",
	'checkuser-log-userips' => '$1 lấy địa chỉ IP của $2',
	'checkuser-log-ipedits' => '$1 lấy sửa đổi của $2',
	'checkuser-log-ipusers' => '$1 lấy tên thành viên của $2',
	'checkuser-log-ipedits-xff' => '$1 lấy sửa đổi của XFF $2',
	'checkuser-log-ipusers-xff' => '$1 lấy tên thành viên của XFF $2',
	'checkuser-log-useredits' => '$1 lấy các sửa đổi của $2',
	'checkuser-autocreate-action' => 'được tạo ra tự động',
	'checkuser-create-action' => 'được tạo ra',
	'checkuser-email-action' => 'gửi thư điện tử cho người dùng “$1”',
	'checkuser-reset-action' => 'tái tạo mật khẩu của người dùng “$1”',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'checkuser-summary' => 'Stum at vestigon votükamis brefabüik ad dagetön ladetis-IP fa geban semik pagebölis, ud ad jonön redakama- u gebananünis tefü ladet-IP semik.
Gebans e redakams se dona-IP kanons pagetön de tiäds: XFF medä läükoy eli „/xff“ ladete-IP. Els IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128) kanons pagebön.
Redakams no plu 5000 pejonons sekü kods kaenavik. Gebolös stumi at bai nomem.',
	'checkuser-desc' => 'Gevon gebanes labü däl zesüdik fägi ad vestigön ladeti(s)-IP gebana äsi nünis votik',
	'checkuser-logcase' => 'Pö suk in registar mayuds e minuds padifükons.',
	'checkuser' => 'Vestigön gebani',
	'checkuserlog' => 'Vestigön gebani: jenotalised',
	'group-checkuser' => 'Gebanavestigans',
	'group-checkuser-member' => 'Gebanavestigan',
	'right-checkuser' => 'Kontrolön ladetis-IP e nünis votik tefü geban',
	'right-checkuser-log' => 'Logön jenotalised gebanikontrolama',
	'grouppage-checkuser' => '{{ns:project}}:Gebanavestigan',
	'checkuser-reason' => 'Kod:',
	'checkuser-showlog' => 'Jonön jenotalisedi',
	'checkuser-query' => 'Vestigön votükamis brefabüik',
	'checkuser-target' => 'Ladet-IP u gebananem:',
	'checkuser-users' => 'Tuvön gebanis',
	'checkuser-edits' => 'Tuvön redakamis ladeta-IP',
	'checkuser-ips' => 'Tuvön ladetis-IP',
	'checkuser-search' => 'Sukolöd',
	'checkuser-period' => 'Dul:',
	'checkuser-week-1' => 'vig lätik',
	'checkuser-week-2' => 'vigs lätik tel',
	'checkuser-month' => 'dels lätik 30',
	'checkuser-all' => 'valiks',
	'checkuser-empty' => 'Lised vagon.',
	'checkuser-nomatch' => 'Suk no eplöpon.',
	'checkuser-nomatch-edits' => 'No petuvon.
Redakam lätik ejenon ün $1, tü $2.',
	'checkuser-check' => 'Vestigön',
	'checkuser-log-fail' => 'No eplöpos ad laükön jenotalisede',
	'checkuser-nolog' => 'Ragiv jenotaliseda no petuvon.',
	'checkuser-blocked' => 'Peblokon',
	'checkuser-gblocked' => 'Peblokon valöpo',
	'checkuser-locked' => 'Pelökofärmükon',
	'checkuser-wasblocked' => 'Büo päbloköl',
	'checkuser-localonly' => 'No pebalöl',
	'checkuser-massblock' => 'Blokön gebanis pevälöl',
	'checkuser-blocktag' => 'Plaädön gebanapadis me:',
	'checkuser-blocktag-talk' => 'Plaädön bespikapadis me:',
	'checkuser-massblock-commit' => 'Blokön gebanis pevälöl',
	'checkuser-block-success' => "'''{{PLURAL:$2|Geban|Gebans}}: $1 {{PLURAL:$2|peblokon|peblokons}}.'''",
	'checkuser-block-failure' => "'''Gebans nonik peblokons.'''",
	'checkuser-block-limit' => 'Gebans tumödik pevälons.',
	'checkuser-block-noreason' => 'Mutol nunön kodi blokamas.',
	'checkuser-accounts' => '{{PLURAL:$1|kal|kals}} nulik $1',
	'checkuser-too-many' => 'Sukaseks te mödiks, nedol gebön eli CIDR smalikum. Is palisedons ladets-IP pegeböl (jü 5000, peleodüköls ma ladet):',
	'checkuser-user-nonexistent' => 'Geban at no dabinon.',
	'checkuser-search-form' => 'Tuvön lienis jenotaliseda, kö $1 binon $2',
	'checkuser-search-submit' => 'Suk',
	'checkuser-search-initiator' => 'flagan',
	'checkuser-search-target' => 'zeil',
	'checkuser-ipeditcount' => '~$1 de gebans valik',
	'checkuser-log-return' => 'Geikön lü cifafomet',
	'checkuser-log-userips' => '$1 labon ladetis-IP ela $2',
	'checkuser-log-ipedits' => '$1 labon redakamis ela $2',
	'checkuser-log-ipusers' => '$1 labon gebanis ela $2',
	'checkuser-log-ipedits-xff' => '$1 labon redakamis ela XFF $2',
	'checkuser-log-ipusers-xff' => '$1 labon gebanis ela XFF $2',
	'checkuser-log-useredits' => '$1 labon redakamis pro $2',
	'checkuser-autocreate-action' => 'pejafon itjäfidiko',
	'checkuser-email-action' => 'äsedon penedi leäktronik gebane: „$1“',
	'checkuser-reset-action' => 'votükön letavödi gebana: „$1“',
);

/** Walloon (Walon)
 * @author Srtxg
 */
$messages['wa'] = array(
	'checkuser' => "Verifyî l' uzeu",
);

/** Waray (Winaray)
 * @author JinJian
 */
$messages['war'] = array(
	'group-checkuser' => 'Mga manginginsayod hin gumaramit',
	'group-checkuser-member' => '{{HENERO:$1|manginginsayod hin gumaramit}}',
	'checkuser-all' => 'ngatanan',
	'checkuser-check' => 'Panginsayori',
	'checkuser-massblock' => 'Pugngi an mga ginpili nga gumaramit',
	'checkuser-blocktag' => 'Igliwan an mga pakli-han-gumaramit hin:',
	'checkuser-blocktag-talk' => 'Igliwan an mga hiruhimanraw-nga-pakli hin:',
	'checkuser-search-submit' => 'Bilnga',
	'checkuser-search-initiator' => 'nagpatikang',
	'checkuser-autocreate-action' => 'in naglugaring kahimo',
	'checkuser-create-action' => 'in nahimo',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'checkuser-reason' => '理由：',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'checkuser' => 'בודק זײַן באניצער',
	'checkuserlog' => 'קאנטראל לאגבוך',
	'checkuser-contribs' => 'בודק זײַן באניצער IP אדרעסן',
	'group-checkuser' => 'בודקים',
	'group-checkuser-member' => '{{GENDER:$1|בודק}}',
	'right-checkuser' => 'בודק זײַן א באניצערס IP אדרעסן און  אנדער אינפארמאציע',
	'right-checkuser-log' => 'באקוקן דאס קאנטראל לאגבוך',
	'grouppage-checkuser' => '{{ns:project}}:בודק',
	'checkuser-reason' => 'אורזאַך:',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => 'ווײַזן לאגבוך',
	'checkuser-target' => 'IP אַדרעס אדער באַניצער נאָמען:',
	'checkuser-search' => 'זוכן',
	'checkuser-period' => 'דויער:',
	'checkuser-week-1' => 'פֿאריגע וואך',
	'checkuser-week-2' => 'פֿאריגע צוויי וואכן',
	'checkuser-month' => 'פֿאריגע 30 טעג',
	'checkuser-all' => 'אלע',
	'checkuser-empty' => 'דאס לאגבוך אנטהאלט נישט קיין איינסן.',
	'checkuser-nomatch' => 'נישט געטראפֿן קיין פאָר.',
	'checkuser-nomatch-edits' => 'נישט געטראפֿן קיין פאָרן.
לעצטע רעדאַקטירונג געווען אום $1 אין $2.',
	'checkuser-check' => 'בודק זײַן',
	'checkuser-log-fail' => 'נישט מעגלעך צולייגן בײַשרײַבונג אין לאג-בוך.',
	'checkuser-nolog' => 'נישט געפֿונען קיין לאג בוך.',
	'checkuser-blocked' => 'בלאקירט',
	'checkuser-gblocked' => 'בלאקירט גלאבאַליש',
	'checkuser-locked' => 'פֿאַרשלאסן',
	'checkuser-block-limit' => 'צופיל באניצער אויסגעקליבן',
	'checkuser-search-submit' => 'זוכן',
	'checkuser-search-initiator' => 'בודק',
	'checkuser-search-target' => 'ציל',
	'checkuser-ipeditcount' => '~$1 פון אלע באניצער',
	'checkuser-create-action' => 'איז געווארן געשאפן',
	'checkuser-email-action' => 'געשיקט א בליצבריוו צו באניצער "$1"',
	'checkuser-reset-action' => 'צוריקשטעלן פאסווארט פאר באניצער "$1"',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'checkuser-summary' => '呢個工具會響最近更改度掃瞄對一位用戶用過嘅IP地址，或者係睇一個IP嘅用戶資料同埋佢嘅編輯記錄。
	響用戶同埋用戶端IP嘅編輯係可幾經由XFF頭，加上 "/xff" 就可以拎到。呢個工具係支援 IPv4 (CIDR 16-32) 同埋 IPv6 (CIDR 64-128)。
	由於為咗效能方面嘅原因，將唔會顯示多過5000次嘅編輯。請跟源政策去用呢個工具。',
	'checkuser-desc' => '畀合適去查用戶IP或其它嘢嘅能力畀用戶',
	'checkuser-logcase' => '搵呢個日誌係有分大細楷嘅。',
	'checkuser' => '核對用戶',
	'checkuserlog' => '核對用戶日誌',
	'group-checkuser' => '稽查員',
	'group-checkuser-member' => '稽查員',
	'right-checkuser' => '核對用戶嘅IP地址同埋其它嘅資料',
	'grouppage-checkuser' => '{{ns:project}}:稽查員',
	'checkuser-reason' => '原因:',
	'checkuser-showlog' => '顯示日誌',
	'checkuser-query' => '查詢最近更改',
	'checkuser-target' => '用戶名或IP',
	'checkuser-users' => '拎用戶',
	'checkuser-edits' => '拎IP嘅編輯',
	'checkuser-ips' => '拎IP',
	'checkuser-search' => '搵',
	'checkuser-empty' => '呢個日誌無任何嘅項目。',
	'checkuser-nomatch' => '搵唔到符合嘅資訊。',
	'checkuser-check' => '查',
	'checkuser-log-fail' => '唔能夠加入日誌項目',
	'checkuser-nolog' => '搵唔到日誌檔。',
	'checkuser-blocked' => '已經封鎖',
	'checkuser-too-many' => '太多結果，請收窄個CIDR。
呢度係個用過嘅IP (最多5000個，按地址排):',
	'checkuser-user-nonexistent' => '指定嘅用戶唔存在。',
	'checkuser-search-form' => '搵當 $1 係 $2 嗰陣時嘅日誌',
	'checkuser-search-submit' => '搵',
	'checkuser-search-initiator' => '創始者',
	'checkuser-search-target' => '目標',
	'checkuser-ipeditcount' => '~響全部用戶度搵$1',
	'checkuser-log-return' => '返去核對用戶主要表格',
	'checkuser-log-userips' => '$1 拎到 $2 嘅 IP',
	'checkuser-log-ipedits' => '$1 拎到 $2 嘅編輯',
	'checkuser-log-ipusers' => '$1 拎到 $2 嘅用戶',
	'checkuser-log-ipedits-xff' => '$1 拎到 XFF $2 嘅編輯',
	'checkuser-log-ipusers-xff' => '$1 拎到 XFF $2 嘅用戶',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Gaoxuewei
 * @author Gzdavidwong
 * @author Hydra
 * @author Jimmy xu wrk
 * @author Liangent
 * @author PhiLiP
 * @author Wmr89502270
 * @author Xiaomingyan
 * @author 白布飘扬
 */
$messages['zh-hans'] = array(
	'checkuser-summary' => '本工具会从最近更改中获取用户使用过的IP地址，可使用XFF头信息来获取同一客户端IP地址下的用户和编辑，即在IP地址后方附加“/xff”。本工具支持IPv4（CIDR 16-32）和IPv6（CIDR 64-128）。由于效率原因，本工具只能查询最近5000笔编辑次数。请确保你的操作符合方针。',
	'checkuser-desc' => '令已授权用户可以核查用户的IP地址及其他信息',
	'checkuser-logcase' => '日志搜索是区分大小写的。',
	'checkuser' => '帐户核查',
	'checkuserlog' => '帐户核查日志',
	'checkuser-contribs' => '核查用户IP地址',
	'group-checkuser' => '账户核查',
	'group-checkuser-member' => '{{GENDER:$1|账户核查}}',
	'right-checkuser' => '核查用户的IP地址和其他信息',
	'right-checkuser-log' => '查看帐户核查日志',
	'action-checkuser' => '核查用户的IP地址和其他信息',
	'action-checkuser-log' => '查看帐户核查日志',
	'grouppage-checkuser' => '{{ns:project}}:账户核查',
	'checkuser-reason' => '原因：',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => '显示日志',
	'checkuser-query' => '查询最近更改',
	'checkuser-target' => 'IP地址或用户名：',
	'checkuser-users' => '获取用户',
	'checkuser-edits' => '获取编辑',
	'checkuser-ips' => '获取IP地址',
	'checkuser-search' => '搜索',
	'checkuser-period' => '期限：',
	'checkuser-week-1' => '上周',
	'checkuser-week-2' => '前两周',
	'checkuser-month' => '前30天',
	'checkuser-all' => '所有',
	'checkuser-cidr-label' => '检查指定IP列表的共同区段',
	'checkuser-cidr-res' => '通用CIDR：',
	'checkuser-empty' => '日志里没有项目。',
	'checkuser-nomatch' => '找不到匹配项目。',
	'checkuser-nomatch-edits' => '找不到匹配项目。最近一次编辑于$1$2。',
	'checkuser-check' => '查核',
	'checkuser-log-fail' => '无法更新日志。',
	'checkuser-nolog' => '找不到日志文件。',
	'checkuser-blocked' => '已封禁',
	'checkuser-gblocked' => '全局封禁',
	'checkuser-locked' => '已锁定',
	'checkuser-wasblocked' => '曾封禁',
	'checkuser-localonly' => '未整合',
	'checkuser-massblock' => '封禁选中用户',
	'checkuser-massblock-text' => '被选中的帐户将被施以无限期封禁，并启用自动封禁、禁止帐户创建。被选中的IP地址将被封禁一周，仅针对IP用户且禁止帐户创建。',
	'checkuser-blocktag' => '替换用户页内容：',
	'checkuser-blocktag-talk' => '替换讨论页内容：',
	'checkuser-massblock-commit' => '封禁选中用户',
	'checkuser-block-success' => "'''{{PLURAL:$2|用户|用户}} $1 {{PLURAL:$2|已被|已被}} 封禁。'''",
	'checkuser-block-failure' => "'''未有用户被封禁。'''",
	'checkuser-block-limit' => '选中用户数量过多。',
	'checkuser-block-noreason' => '你必须解释此次封禁的原因。',
	'checkuser-noreason' => '你必须解释此次查询的原因。',
	'checkuser-accounts' => '$1个新帐户',
	'checkuser-too-many' => '结果过多（根据查询估计），请缩小CIDR的范围。
下面列出了使用过的IP地址（最多5000个，按地址排列）：',
	'checkuser-user-nonexistent' => '指定的用户不存在。',
	'checkuser-search-form' => '查找当 $1 是 $2 时的日志记录',
	'checkuser-search-submit' => '搜索',
	'checkuser-search-initiator' => '操作者',
	'checkuser-search-target' => '目标',
	'checkuser-ipeditcount' => '~在全部用户中$1',
	'checkuser-log-return' => '回到查核主表单',
	'checkuser-limited' => "'''结果已因效率原因而被删减。'''",
	'checkuser-log-userips' => '$1取得$2的IP信息',
	'checkuser-log-ipedits' => '$1取得$2的编辑记录',
	'checkuser-log-ipusers' => '$1取得$2的用户信息',
	'checkuser-log-ipedits-xff' => '$1取得XFF $2的编辑记录',
	'checkuser-log-ipusers-xff' => '$1取得XFF $2的用户信息',
	'checkuser-log-useredits' => '$1取得$2的编辑记录',
	'checkuser-autocreate-action' => '已自动创建',
	'checkuser-create-action' => '已创建',
	'checkuser-email-action' => '向用户“$1”发送电邮',
	'checkuser-reset-action' => '为用户“$1”重置密码',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Anakmalaysia
 * @author Horacewai2
 * @author Liangent
 * @author Mark85296341
 * @author Waihorace
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'checkuser-summary' => '本工具會從{{int:recentchanges}}中查詢使用者使用過的IP位址，或是一個IP位址發送出來的任何編輯記錄。本工具支援IPv4及IPv6的位址。由於技術上的限制，本工具只能查詢最近5000筆的記錄。請確定您的行為符合守則。',
	'checkuser-desc' => '讓授權的使用者檢查使用者的IP位址及其他資訊',
	'checkuser-logcase' => '搜尋時請注意大小寫的區分',
	'checkuser' => '核對用戶',
	'checkuserlog' => '用戶查核記錄',
	'checkuser-contribs' => '核查用戶IP地址',
	'group-checkuser' => '用戶查核',
	'group-checkuser-member' => '{{GENDER:$1|賬戶核查}}',
	'right-checkuser' => '查核用戶的IP地址以及其它的資料',
	'right-checkuser-log' => '檢視帳戶核查日誌',
	'action-checkuser' => '核查用戶的IP地址和其他信息',
	'action-checkuser-log' => '查看帳戶核查日誌',
	'grouppage-checkuser' => '{{ns:project}}:用戶查核',
	'checkuser-reason' => '理由',
	'checkuser-reason-api' => 'API: $1',
	'checkuser-showlog' => '顯示記錄',
	'checkuser-query' => '查詢最近更改',
	'checkuser-target' => '目標用戶或IP地址：',
	'checkuser-users' => '查詢用戶名稱',
	'checkuser-edits' => '獲取編輯',
	'checkuser-ips' => '查詢IP位址',
	'checkuser-search' => '搜尋',
	'checkuser-period' => '期限：',
	'checkuser-week-1' => '一星期內',
	'checkuser-week-2' => '兩星期內',
	'checkuser-month' => '30天內',
	'checkuser-all' => '全部',
	'checkuser-cidr-label' => '檢查指定IP列表的共同區段',
	'checkuser-cidr-res' => '通用CIDR：',
	'checkuser-empty' => '記錄裡沒有資料。',
	'checkuser-nomatch' => '沒有符合的資訊',
	'checkuser-nomatch-edits' => '找不到匹配項目。最近一次編輯於$1$2。',
	'checkuser-check' => '查詢',
	'checkuser-log-fail' => '無法更新記錄。',
	'checkuser-nolog' => '找不到記錄檔',
	'checkuser-blocked' => '已經查封',
	'checkuser-gblocked' => '全域封禁',
	'checkuser-locked' => '已鎖定',
	'checkuser-wasblocked' => '曾封禁',
	'checkuser-localonly' => '未統一',
	'checkuser-massblock' => '封禁選中用戶',
	'checkuser-massblock-text' => '被選中的帳戶將被施以無限期封禁，並啟用自動封禁、禁止帳戶建立。被選中的IP地址將被封禁一周，僅針對IP用戶且禁止帳戶建立。',
	'checkuser-blocktag' => '替換用戶頁內容：',
	'checkuser-blocktag-talk' => '替換討論頁內容：',
	'checkuser-massblock-commit' => '封禁選中用戶',
	'checkuser-block-success' => "'''{{PLURAL:$2|用戶|用戶}} $1 {{PLURAL:$2|已被|已被}} 封禁。'''",
	'checkuser-block-failure' => "'''未有使用者被封禁。'''",
	'checkuser-block-limit' => '選中用戶數量過多。',
	'checkuser-block-noreason' => '您必須提供進行封禁的理由。',
	'checkuser-noreason' => '您必須提供進行查詢的理由。',
	'checkuser-accounts' => '$1個新帳戶',
	'checkuser-too-many' => '結果過多（根據查詢估計），請縮小CIDR的範圍。
下面列出了使用過的IP地址（最多5000個，按地址排列）：',
	'checkuser-user-nonexistent' => '指定的使用者不存在。',
	'checkuser-search-form' => '搜尋當 $1 是 $2 時之日誌',
	'checkuser-search-submit' => '{{int:Search}}',
	'checkuser-search-initiator' => '創始者',
	'checkuser-search-target' => '目標',
	'checkuser-ipeditcount' => '~在全部用戶中$1',
	'checkuser-log-return' => '回到主表單',
	'checkuser-limited' => "'''結果已因效率原因而被刪減。'''",
	'checkuser-log-userips' => '$1取得$2的IP訊息',
	'checkuser-log-ipedits' => '$1取得$2的編輯記錄',
	'checkuser-log-ipusers' => '$1取得$2的用戶訊息',
	'checkuser-log-ipedits-xff' => '$1取得 XFF $2的編輯記錄',
	'checkuser-log-ipusers-xff' => '$1取得 XFF $2的用戶訊息',
	'checkuser-log-useredits' => '$1取得$2的編輯記錄',
	'checkuser-autocreate-action' => '經已自動建立',
	'checkuser-create-action' => '已建立',
	'checkuser-email-action' => '向使用者「$1」發送電郵',
	'checkuser-reset-action' => '為使用者「$1」重設密碼',
);

