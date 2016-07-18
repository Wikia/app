<?php
/**
 * Internationalisation file for extension GlobalMessages.
 *
 * @file
 * @ingroup Extensions
 */
$messages = array();

$messages['en'] = array(
	'variants' => 'Variants',
	'view' => 'View',
	'viewdeleted_short' => 'View {{PLURAL:$1|one deleted edit|$1 deleted edits}}',
	'views' => 'Views',
	'viewcount' => 'This page has been accessed {{PLURAL:$1|once|$1 times}}.',
	'view-pool-error' => 'Sorry, the servers are overloaded at the moment.
Too many users are trying to view this page.
Please wait a while before you try to access this page again.

$1',
	'versionrequired' => 'Version $1 of MediaWiki required',
	'versionrequiredtext' => 'Version $1 of MediaWiki is required to use this page.
See [[Special:Version|version page]].',
	'viewsourceold' => 'view source',
	'viewsourcelink' => 'view source',
	'viewdeleted' => 'View $1?',
	'viewsource' => 'View source',
	'viewsource-title' => 'View source for $1',
	'viewsourcetext' => 'You can view and copy the source of this page:',
	'viewyourtext' => "You can view and copy the source of '''your edits''' to this page:",
	'virus-badscanner' => "Bad configuration: Unknown virus scanner: ''$1''",
	'virus-scanfailed' => 'scan failed (code $1)',
	'virus-unknownscanner' => 'unknown antivirus:',
	'viewpagelogs' => 'View logs for this page',
	'viewprevnext' => 'View ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'This file did not pass file verification.',
	'viewdeletedpage' => 'View deleted pages',
	'video-dims' => '$1, $2 × $3',
	'variantname-zh-hans' => 'hans',
	'variantname-zh-hant' => 'hant',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
	'variantname-zh-sg' => 'sg',
	'variantname-zh-my' => 'my',
	'variantname-zh' => 'zh',
	'variantname-gan-hans' => 'hans',
	'variantname-gan-hant' => 'hant',
	'variantname-gan' => 'gan',
	'variantname-sr-ec' => 'sr-ec',
	'variantname-sr-el' => 'sr-el',
	'variantname-sr' => 'sr',
	'variantname-kk-kz' => 'kk-kz',
	'variantname-kk-tr' => 'kk-tr',
	'variantname-kk-cn' => 'kk-cn',
	'variantname-kk-cyrl' => 'kk-cyrl',
	'variantname-kk-latn' => 'kk-latn',
	'variantname-kk-arab' => 'kk-arab',
	'variantname-kk' => 'kk',
	'variantname-ku-arab' => 'ku-Arab',
	'variantname-ku-latn' => 'ku-Latn',
	'variantname-ku' => 'ku',
	'variantname-tg-cyrl' => 'tg-Cyrl',
	'variantname-tg-latn' => 'tg-Latn',
	'variantname-tg' => 'tg',
	'variantname-ike-cans' => 'ike-Cans',
	'variantname-ike-latn' => 'ike-Latn',
	'variantname-iu' => 'iu',
	'variantname-shi-tfng' => 'shi-Tfng',
	'variantname-shi-latn' => 'shi-Latn',
	'variantname-shi' => 'shi',
	'version' => 'Version',
	'version-extensions' => 'Installed extensions',
	'version-specialpages' => 'Special pages',
	'version-parserhooks' => 'Parser hooks',
	'version-variables' => 'Variables',
	'version-antispam' => 'Spam prevention',
	'version-skins' => 'Skins',
	'version-api' => 'API',
	'version-other' => 'Other',
	'version-mediahandlers' => 'Media handlers',
	'version-hooks' => 'Hooks',
	'version-extension-functions' => 'Extension functions',
	'version-parser-extensiontags' => 'Parser extension tags',
	'version-parser-function-hooks' => 'Parser function hooks',
	'version-hook-name' => 'Hook name',
	'version-hook-subscribedby' => 'Subscribed by',
	'version-version' => '(Version $1)',
	'version-svn-revision' => '(r$2)',
	'version-license' => 'License',
	'version-poweredby-credits' => "This wiki is powered by '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'others',
	'version-license-info' => 'MediaWiki is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

MediaWiki is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received [{{SERVER}}{{SCRIPTPATH}}/COPYING a copy of the GNU General Public License] along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA or [//www.gnu.org/licenses/old-licenses/gpl-2.0.html read it online].',
	'version-software' => 'Installed software',
	'version-software-product' => 'Product',
	'version-software-version' => 'Version',
	'version-file-extensions-allowed' => 'File extensions allowed for upload',
	'var_set' => 'set the $2 to "$3"',
	'vertical-tv' => 'TV',
	'vertical-games' => 'Games',
	'vertical-books' => 'Books',
	'vertical-comics' => 'Comics',
	'vertical-lifestyle' => 'Lifestyle',
	'vertical-music' => 'Music',
	'vertical-movies' => 'Movies',
);

$messages['qqq'] = array(
	'views' => 'Subtitle for the list of available views, for the current page. In "monobook" skin the list of views are shown as tabs, so this sub-title is not shown.  To check when and where this message is displayed switch to "simple" skin.

\'\'\'Note:\'\'\' This is "views" as in "appearances"/"representations", \'\'\'not\'\'\' as in "visits"/"accesses".
{{Identical|View}}',
	'versionrequired' => 'This message is not used in the MediaWiki core, but was introduced with the reason that it could be useful for extensions. See also {{msg|versionrequiredtext}}.',
	'versionrequiredtext' => 'This message is not used in the MediaWiki core, but was introduced with the reason that it could be useful for extensions. See also {{msg|versionrequired}}.',
	'viewsourceold' => '{{Identical|View source}}',
	'viewsourcelink' => 'Text of the link shown next to every uneditable (protected) template in the list of used templates below the edit window. See also {{msg-mw|Editlink}}.

{{Identical|View source}}',
	'viewdeleted' => 'Message shown on a deleted page when the user does not have the undelete right (but has the deletedhistory right). $1 is a link to [[Special:Undelete]], with {{msg-mw|restorelink}} as the text. See also {{msg-mw|thisisdeleted}}.',
	'viewsource' => 'The text displayed in place of the "edit" tab when the user has no permission to edit the page.

{{Identical|View source}}',
	'viewsourcefor' => 'Subtitle shown when trying to edit a protected page.

{{Identical|For $1}}',
	'viewsourcetext' => 'The text shown when displaying the source of a page that the user has no permission to edit',
	'viewpagelogs' => 'Link displayed in history of pages',
	'viewprevnext' => 'This is part of the navigation message on the top and bottom of Special pages which are lists of things, e.g. the User\'s contributions page (in date order) or the list of all categories (in alphabetical order). ($1) and ($2) are either {{msg-mw|Pager-older-n}} and {{msg-mw|Pager-newer-n}} (for date order) or {{msg-mw|Prevn}} and {{msg-mw|Nextn}} (for alphabetical order).

It is also used by [[Special:WhatLinksHere|Whatlinkshere]] pages, where ($1) and ($2) are {{msg-mw|Whatlinkshere-prev}} and {{msg-mw|Whatlinkshere-next}}.
($3) is made up in all cases of the various proposed numbers of results per page, e.g. "(20 | 50 | 100 | 250 | 500)".
For Special pages, the navigation bar is prefixed by "({{msg-mw|Page_first}} | {{msg-mw|Page_last}})" (alphabetical order) or "({{msg-mw|Histfirst}} | {{msg-mw|Histlast}})" (date order).

Viewprevnext is sometimes preceded by the {{msg-mw|Showingresults}} or {{msg-mw|Showingresultsnum}} message (for Special pages) or by the {{msg-mw|Linkshere}} message (for Whatlinkshere pages).',
	'viewdeletedpage' => '{{Identical|View deleted pages}}',
	'video-dims' => '{{optional}}',
	'variantname-zh-hans' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-zh-hant' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-zh-cn' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-zh-tw' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-zh-hk' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-zh-mo' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-zh-sg' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-zh-my' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-zh' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-gan-hans' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-gan-hant' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-gan' => '{{Optional}}

Variant option for wikis with variants conversion enabled.',
	'variantname-sr-ec' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-sr-el' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-sr' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-kk-kz' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-kk-tr' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-kk-cn' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-kk-cyrl' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-kk-latn' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-kk-arab' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-kk' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-ku-arab' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-ku-latn' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-ku' => '{{optional}}
Varient Option for wikis with variants conversion enabled.',
	'variantname-tg-cyrl' => '{{optional}}',
	'variantname-tg-latn' => '{{optional}}',
	'variantname-tg' => '{{optional}}',
	'version' => 'Name of special page displayed in [[Special:SpecialPages]]

{{Identical|Version}}',
	'version-extensions' => 'Header on [[Special:Version]].',
	'version-specialpages' => 'Part of [[Special:Version]].

{{Identical|Special pages}}',
	'version-parserhooks' => 'This message is a heading at [[Special:Version]] for extensions that modifies the parser of wikitext.',
	'version-variables' => '{{Identical|Variable}}',
	'version-other' => '{{Identical|Other}}',
	'version-mediahandlers' => 'Used in [[Special:Version]]. It is the title of a section for media handler extensions (e.g. [[mw:Extension:OggHandler]]).
There are no such extensions here, so look at [[wikipedia:Special:Version]] for an example.',
	'version-hooks' => 'Shown in [[Special:Version]]',
	'version-extension-functions' => 'Shown in [[Special:Version]]',
	'version-parser-function-hooks' => 'Shown in [[Special:Version]]',
	'version-skin-extension-functions' => 'Shown in [[Special:Version]]',
	'version-hook-name' => 'Shown in [[Special:Version]]',
	'version-hook-subscribedby' => 'Shown in [[Special:Version]]',
	'version-version' => '{{Identical|Version}}',
	'version-svn-revision' => 'This is being used in [[Special:Version]], preceeding the subversion revision numbers of the extensions loaded inside brackets, like this: "({{int:version-revision}} r012345")

{{Identical|Revision}}',
	'version-license' => '{{Identical|License}}',
	'version-software-product' => 'Shown in [[Special:Version]]',
	'version-software-version' => '{{Identical|Version}}',
	'version-file-extensions-allowed' => 'This message is a heading at [[Special:Version]] for file extensions that are allowed to be uploaded',
	'vertical-tv' => 'TV vertical name',
	'vertical-games' => 'Games vertical name',
	'vertical-books' => 'Books vertical name',
	'vertical-comics' => 'Comics vertical name',
	'vertical-lifestyle' => 'Lifestyle vertical name',
	'vertical-music' => 'Music vertical name',
	'vertical-movies' => 'Movies vertical name',
);

$messages['ab'] = array(
	'viewsource' => 'Ахәаҧшра',
);

$messages['ace'] = array(
	'variants' => 'Ragam',
	'views' => 'Leumah',
	'viewsourceold' => 'Eu nè',
	'viewsourcelink' => 'eu nè',
	'viewsource' => 'Eu nè',
	'viewsourcetext' => 'Droëneuh  jeuët neu’eu',
	'viewpagelogs' => 'Eu log ôn nyoë',
	'viewprevnext' => 'Eu ($1 {{int:pipe-separator}} $2)($3)',
	'version' => 'Curak',
);

$messages['af'] = array(
	'variants' => 'Variante',
	'view' => 'Wys',
	'viewdeleted_short' => 'Wys {{PLURAL:$1|een geskrapte wysiging|$1 geskrapte wysigings}}',
	'views' => 'Weergawes',
	'viewcount' => 'Hierdie bladsy is al {{PLURAL:$1|keer|$1 kere}} aangevra.',
	'view-pool-error' => "Jammer, die bedieners is tans oorbelas.
Te veel gebruikers probeer om na hierdie bladsy te kyk.
Wag asseblief 'n rukkie voordat u weer probeer om die bladsy op te roep.

$1",
	'versionrequired' => 'Weergawe $1 van MediaWiki benodig',
	'versionrequiredtext' => 'Weergawe $1 van MediaWiki word benodig om hierdie bladsy te gebruik. Sien [[Special:Version|version page]].',
	'viewsourceold' => 'bekyk bronteks',
	'viewsourcelink' => 'wys bronkode',
	'viewdeleted' => 'Bekyk $1?',
	'viewsource' => 'Bekyk bronteks',
	'viewsource-title' => 'Wys bron van $1',
	'viewsourcetext' => 'U mag die bronteks van hierdie bladsy lees en kopieer:',
	'viewyourtext' => "U kan '''u wysigings''' aan die bronteks van hierdie bladsy bekyk en kopieer:",
	'virus-badscanner' => "Slegte konfigurasie: onbekende virusskandeerder: ''$1''",
	'virus-scanfailed' => 'skandering het misluk (kode $1)',
	'virus-unknownscanner' => 'onbekende antivirus:',
	'viewpagelogs' => 'Bekyk logboeke vir hierdie bladsy',
	'viewprevnext' => 'Kyk na ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Verifikasie van die lêer wat u probeer oplaai het gefaal.',
	'viewdeletedpage' => 'Bekyk geskrapte bladsye',
	'version' => 'Weergawe',
	'version-extensions' => 'Uitbreidings geïnstalleer',
	'version-specialpages' => 'Spesiale bladsye',
	'version-parserhooks' => 'Ontlederhoeke',
	'version-variables' => 'Veranderlikes',
	'version-antispam' => 'Spam-voorkoming',
	'version-skins' => 'Omslae',
	'version-other' => 'Ander',
	'version-mediahandlers' => 'Mediaverwerkers',
	'version-hooks' => 'Hoeke',
	'version-extension-functions' => 'Uitbreidingsfunksies',
	'version-parser-extensiontags' => 'Ontleder-uitbreidingsetikette',
	'version-parser-function-hooks' => 'Ontleder-funksiehoeke',
	'version-hook-name' => 'Hoek naam',
	'version-hook-subscribedby' => 'Gebruik deur',
	'version-version' => '(Weergawe $1)',
	'version-license' => 'Lisensie',
	'version-poweredby-credits' => "Hierdie wiki word aangedryf deur '''[//www.mediawiki.org/ MediaWiki]''', kopiereg © 2001-$1 $2.",
	'version-poweredby-others' => 'andere',
	'version-license-info' => 'MediaWiki is vrye sagteware, u kan MediaWiki versprei en/of wysig onder die voorwaardes van die "GNU Algemene Publieke Lisensie", soos deur die "Free Software Foundation" gepubliseer; óf weergawe 2 van die lisensie, of (as u wil) enige latere weergawe daarvan.

MediaWiki word versprei met die hoop dat dit nuttig sal wees, maar SONDER ENIGE WAARBORGE, selfs sonder geïmpliseerde waarborg van VERHANDELBAARHEID of GESKIKTHEID VIR \'N SPESIFIEKE DOEL. Verwys na die "GNU Algemene Publieke Lisensie" vir meer besonderhede.

Saam met die program moes u \'n [{{SERVER}}{{SCRIPTPATH}}/COPYING kopie van van die "GNU Algemene Publieke Lisensie"] ontvang het, indien nie, skryf aan die "Free Software Foundation, Inc", 51 Franklin-straat, Vyfde Vloer, Boston, MA 02110-1301, Verenigde State van Amerika of [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lees dit hier aanlyn].',
	'version-software' => 'Geïnstalleerde sagteware',
	'version-software-product' => 'Produk',
	'version-software-version' => 'Weergawe',
);

$messages['aln'] = array(
	'variants' => 'Variantet',
	'views' => 'Shikime',
	'viewcount' => 'Kjo faqe âsht pâ {{PLURAL:$1|nji|$1}} herë.',
	'view-pool-error' => 'Na vjen keq, serverat janë të stërngarkuem momentalisht.
Tepër shumë përdorues po tentojnë me pâ këtë faqe.
Ju lutem pritni pak para se me tentue me iu qasë faqes prap.

$1',
	'versionrequired' => 'Nevojitet verzioni $1 i MediaWikit',
	'versionrequiredtext' => 'Lypet verzioni $1 i MediaWikit për me përdorë këtë faqe.
Shih [[Special:Version|faqen e verzionit]].',
	'viewsourceold' => 'shih kodin',
	'viewsourcelink' => 'shih kodin',
	'viewdeleted' => 'Shiko $1?',
	'viewsource' => 'Shih kodin',
	'viewsourcetext' => 'Mundeni me pâ dhe kopjue kodin burimor të kësaj faqeje:',
	'virus-badscanner' => "Konfigurim i keq: scanner i panjoftun virusash: ''$1''",
	'virus-scanfailed' => 'scanimi dështoi (code $1)',
	'virus-unknownscanner' => 'antivirus i panjoftun:',
	'viewpagelogs' => 'Shih regjistrat për këtë faqe',
	'viewprevnext' => 'Shih ($1 {{int:pipe-separator}} $2) ($3).',
	'variantname-zh-hans' => 'hans',
	'variantname-zh-hant' => 'hant',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
);

$messages['als'] = array(
	'variants' => 'Variantet',
	'views' => 'Shikime',
	'viewcount' => 'Kjo faqe âsht pâ {{PLURAL:$1|nji|$1}} herë.',
	'view-pool-error' => 'Na vjen keq, serverat janë të stërngarkuem momentalisht.
Tepër shumë përdorues po tentojnë me pâ këtë faqe.
Ju lutem pritni pak para se me tentue me iu qasë faqes prap.

$1',
	'versionrequired' => 'Nevojitet verzioni $1 i MediaWikit',
	'versionrequiredtext' => 'Lypet verzioni $1 i MediaWikit për me përdorë këtë faqe.
Shih [[Special:Version|faqen e verzionit]].',
	'viewsourceold' => 'shih kodin',
	'viewsourcelink' => 'shih kodin',
	'viewdeleted' => 'Shiko $1?',
	'viewsource' => 'Shih kodin',
	'viewsourcetext' => 'Mundeni me pâ dhe kopjue kodin burimor të kësaj faqeje:',
	'virus-badscanner' => "Konfigurim i keq: scanner i panjoftun virusash: ''$1''",
	'virus-scanfailed' => 'scanimi dështoi (code $1)',
	'virus-unknownscanner' => 'antivirus i panjoftun:',
	'viewpagelogs' => 'Shih regjistrat për këtë faqe',
	'viewprevnext' => 'Shih ($1 {{int:pipe-separator}} $2) ($3).',
	'variantname-zh-hans' => 'hans',
	'variantname-zh-hant' => 'hant',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
);

$messages['am'] = array(
	'views' => 'ዕይታዎች',
	'viewcount' => 'ይህ ገጽ {{PLURAL:$1|አንዴ|$1 ጊዜ}} ታይቷል።',
	'view-pool-error' => 'ይቅቅርታ፣ በአሁኑ ወቅት ብዙ ተጠቃሚዎች ገፁን ለማየት እየሞከሩ ስለሆነ ሰርቨሩ ላይ መጨናነቅ ተፈጥሯል
ስለዚህ እባክዎን ትንሽ ቆይተው በድጋሚ ይዎክሩ።

$1',
	'versionrequired' => 'የMediaWiki ዝርያ $1 ያስፈልጋል።',
	'versionrequiredtext' => 'ይህንን ገጽ ለመጠቀም የMediaWiki ዝርያ $1 ያስፈልጋል። [[Special:Version|የዝርያውን ገጽ]] ይዩ።',
	'viewsourceold' => 'ምንጩን ለማየት',
	'viewsourcelink' => 'ምንጩን ለማየት',
	'viewdeleted' => '$1 ይታይ?',
	'viewsource' => 'ምንጩን ተመልከት',
	'viewsourcetext' => 'የዚህን ገጽ ምንጭ ማየትና መቅዳት ይችላሉ።',
	'virus-unknownscanner' => 'ያልታወቀ antivirus:',
	'viewpagelogs' => 'መዝገቦች ለዚሁ ገጽ',
	'viewprevnext' => 'በቁጥር ለማየት፡ ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'የተደለዙ ገጾች ለማየት',
	'version' => 'ዝርያ',
	'version-extensions' => 'የተሳኩ ቅጥያዎች',
	'version-specialpages' => 'ልዩ ገጾች',
	'version-parserhooks' => 'የዘርዛሪ ሜንጦዎች',
	'version-variables' => 'ተለዋጮች',
	'version-other' => 'ሌላ',
	'version-hooks' => 'ሜንጦዎች',
	'version-extension-functions' => 'የቅጥያ ሥራዎች',
	'version-parser-extensiontags' => 'የዝርዛሪ ቅጥያ ምልክቶች',
	'version-parser-function-hooks' => 'የዘርዛሪ ተግባር ሜጦዎች',
	'version-hook-name' => 'የሜንጦ ስም',
	'version-hook-subscribedby' => 'የተጨመረበት',
	'version-version' => '(ዝርያ $1)',
	'version-license' => 'ፈቃድ',
	'version-software' => 'የተሳካ ሶፍትዌር',
	'version-software-product' => 'ሶፍትዌር',
	'version-software-version' => 'ዝርያ',
);

$messages['an'] = array(
	'variants' => 'Variants',
	'view' => 'Veyer',
	'viewdeleted_short' => 'Veyer {{PLURAL:$1|una edición borrata|$1 edicions borratas}}',
	'views' => 'Visualizacions',
	'viewcount' => 'Ista pachina ha tenito {{PLURAL:$1|una vesita|$1 vesitas}}.',
	'view-pool-error' => "Desincuse, os servidors son agora sobrecargaus.
Masiaus usuarios son mirando d'acceder ta ista pachina.
Aguarde una mica antes de tornar a acceder ta ista pachina.

$1",
	'versionrequired' => 'Ye precisa a versión $1 de MediaWiki',
	'versionrequiredtext' => 'Ye precisa a versión $1 de MediaWiki ta fer servir ista pachina. Ta más información, consulte [[Special:Version]]',
	'viewsourceold' => 'veyer o codigo fuent',
	'viewsourcelink' => 'veyer o codigo fuent',
	'viewdeleted' => 'Quiere amostrar $1?',
	'viewsource' => 'Veyer o codigo fuent',
	'viewsource-title' => 'Veyer o codigo fuent de «$1»',
	'viewsourcetext' => "Puede veyer y copiar o codigo fuent d'ista pachina:",
	'viewyourtext' => "Puet veyer y copiar o codigo d''''as suyas edicions''' en ista pachina:",
	'virus-badscanner' => "Confeguración incorrecta: rastriador de virus esconoixito: ''$1''",
	'virus-scanfailed' => 'o rastreyo ha fallato (codigo $1)',
	'virus-unknownscanner' => 'antivirus esconoixito:',
	'viewpagelogs' => "Veyer os rechistros d'ista pachina",
	'viewprevnext' => 'Veyer ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Iste fichero no pasó a verificación de fichers.',
	'viewdeletedpage' => 'Veyer pachinas borratas',
	'version' => 'Versión',
	'version-extensions' => 'Estensions instalatas',
	'version-specialpages' => 'Pachinas especials',
	'version-parserhooks' => "Grifios d'o parser (parser hooks)",
	'version-variables' => 'Variables',
	'version-antispam' => 'Prevención de spam',
	'version-skins' => 'Aparencias',
	'version-other' => 'Atros',
	'version-mediahandlers' => 'Maneyador de fichers multimedia',
	'version-hooks' => 'Grifios (Hooks)',
	'version-extension-functions' => "Funcions d'a estensión",
	'version-parser-extensiontags' => "Etiquetas d'estensión d'o parseyador",
	'version-parser-function-hooks' => "Grifios d'as funcions d'o parseyador",
	'version-hook-name' => "Nombre d'o grifio",
	'version-hook-subscribedby' => 'Suscrito por',
	'version-version' => '(Versión $1)',
	'version-license' => 'Licencia',
	'version-poweredby-credits' => "Iste wiki funciona gracias a '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'atros',
	'version-license-info' => "MediaWiki ye software libre, puet redistribuyir-lo y/u modificar-lo baixo os terminos d'a Licencia Publica Cheneral GNU publicada por a Free Software Foundation, ya siga d'a suya versión 2 u (a la suya esleción) qualsiquier versión posterior.

MediaWiki se distribuye con l'asperanza d'estar d'utilidat, pero SIN GARRA GUARANCIA; nian a guarancia implicita de COMERCIALIZACIÓN u ADEQUACIÓN TA UNA FINALIDAT DETERMINADA. En trobará más detalles en a Licencia Publica General GNU.

Con iste programa ha d'haber recibiu [{{SERVER}}{{SCRIPTPATH}}/COPYING una copia d'a Licencia Publica Cheneral GNU]; si no ye asinas, endrece-se a la Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA u bien [//www.gnu.org/licenses/old-licenses/gpl-2.0.html la leiga en linia].",
	'version-software' => 'Software instalato',
	'version-software-product' => 'Producto',
	'version-software-version' => 'Versión',
);

$messages['ang'] = array(
	'variants' => 'Missenlicnessa',
	'views' => 'Ansīena',
	'viewcount' => 'Þēos sīde hæfþ ȝeƿorden ȝeseƿen {{PLURAL:$1|āne|$1 hwīlum}}.',
	'view-pool-error' => 'Ƿē sind sāriȝe for þǣm þe þās þeȝntōlas nū oferlīce ƿyrcaþ.
Tō mæniȝe brūcendas ȝesēcaþ to sēonne þās sīdan.
Ƿ̈ē biddaþ þæt þū abīde scortre tīde fore þū ȝesēce to sēonne þās sīdan eft.

$1',
	'versionrequired' => '$1 fadunȝ of MediaǷiki is ȝeþorften',
	'versionrequiredtext' => 'Fadung $1 MediaǷiki is ȝeþorften tō notiennde þisne tramet.
Sēoh þone [[Special:Version|fadunge tramet]].',
	'viewsourceold' => 'Sēon andweorc',
	'viewsourcelink' => 'Fruman sēon',
	'viewdeleted' => '$1 sēon?',
	'viewsource' => 'Fruman sēon',
	'viewpagelogs' => 'Ealdhordas sēon for þisse sīdan',
	'viewprevnext' => 'Sēon ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Fadung',
	'version-specialpages' => 'Syndriȝa sīdan',
	'version-other' => 'Ōðer',
	'version-hooks' => 'Anglas',
	'version-hook-name' => 'Angelnama',
	'version-version' => '(Fadung $1)',
);

$messages['anp'] = array(
	'views' => 'दर्शाव',
	'viewsourcelink' => 'स्रोत देखॊ.',
	'viewsource' => 'स्रोत देखॊ',
	'viewpagelogs' => 'इ पन्ना के लॉग देखॊ',
	'viewprevnext' => 'देख़ॊ ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'हटैलॊ पन्ना वापस लानॊ',
);

$messages['ar'] = array(
	'variants' => 'المتغيرات',
	'view' => 'عرض',
	'viewdeleted_short' => 'عرض {{PLURAL:$1|تعديل محذوف|$1 تعديلات محذوفة}}',
	'views' => 'معاينة',
	'viewcount' => '{{PLURAL:$1|لم تعرض هذه الصفحة أبدا|تم عرض هذه الصفحة مرة واحدة|تم عرض هذه الصفحة مرتين|تم عرض هذه الصفحة $1 مرات|تم عرض هذه الصفحة $1 مرة}}.',
	'view-pool-error' => 'عذرا، الخوادم منهكة حاليا.
يحاول مستخدمون كثر الوصول إلى هذه الصفحة.
من فضلك انتظر قليلا قبل أن تحاول الوصول إلى هذه الصفحة مجددا.

$1',
	'versionrequired' => 'تلزم نسخة $1 من ميدياويكي',
	'versionrequiredtext' => 'تلزم النسخة $1 من ميدياويكي لاستعمال هذه الصفحة. انظر [[Special:Version|صفحة النسخة]]',
	'viewsourceold' => 'اعرض المصدر',
	'viewsourcelink' => 'اعرض المصدر',
	'viewdeleted' => 'أأعرض $1؟',
	'viewsource' => 'اعرض المصدر',
	'viewsource-title' => 'إظهار مصدر $1',
	'viewsourcetext' => 'يمكنك رؤية ونسخ مصدر هذه الصفحة:',
	'viewyourtext' => "يمكنك رؤية ونسخ مصدر ''' تعديلاتك ''' في هذه الصفحة:",
	'virus-badscanner' => "ضبط سيء: ماسح فيروسات غير معروف: ''$1''",
	'virus-scanfailed' => 'فشل المسح (كود $1)',
	'virus-unknownscanner' => 'مضاد فيروسات غير معروف:',
	'viewpagelogs' => 'اعرض سجلات هذه الصفحة',
	'viewprevnext' => 'عرض ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'لم يجتز الملف تحقق صحة الملفات.',
	'viewdeletedpage' => 'عرض الصفحات المحذوفة',
	'video-dims' => '$1، $2×$3',
	'version' => 'نسخة',
	'version-extensions' => 'الامتدادات المثبتة',
	'version-specialpages' => 'صفحات خاصة',
	'version-parserhooks' => 'خطاطيف المحلل',
	'version-variables' => 'المتغيرات',
	'version-antispam' => 'منع البريد المزعج',
	'version-skins' => 'واجهات',
	'version-other' => 'أخرى',
	'version-mediahandlers' => 'متحكمات الميديا',
	'version-hooks' => 'الخطاطيف',
	'version-extension-functions' => 'وظائف الامتداد',
	'version-parser-extensiontags' => 'وسوم امتداد المحلل',
	'version-parser-function-hooks' => 'خطاطيف دالة المحلل',
	'version-hook-name' => 'اسم الخطاف',
	'version-hook-subscribedby' => 'يستخدم بواسطة',
	'version-version' => '(نسخة $1)',
	'version-svn-revision' => '(&رلم;r$2)',
	'version-license' => 'الرخصة',
	'version-poweredby-credits' => "تدار هذه الويكي ب'''[//www.mediawiki.org/ ميدياويكي]''', حقوق النشر © 2001-$1 $2.",
	'version-poweredby-others' => 'آخرون',
	'version-license-info' => "ميدياويكي برنامج حر، يحق لك توزيعه و/أو تعديله وفقاً لبنود رخصة غنو العمومية كما نشرتها مؤسسة البرمجيات الحرة، الإصدار الثاني أو (وفقا لاختيارك أنت) أي إصدار لاحق.

هذا البرنامج يوزع على أمل أن يكون مفيداً، ولكن '''دون أية ضمانات'''، بما في ذلك ضمانات '''التسويق''' أو '''الملاءمة لغرض معين'''. انظر رخصة غنو العمومية لمزيد من التفاصيل.

ينبغي أن تكون قد تلقيت نسخة من رخصة غنو العمومية إذا لم يتم ذلك، اكتب إلى: Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA أو [//www.gnu.org/licenses/old-licenses/gpl-2.0.html اقرأ على الإنترنت].",
	'version-software' => 'البرنامج المثبت',
	'version-software-product' => 'المنتج',
	'version-software-version' => 'النسخة',
);

$messages['arc'] = array(
	'variants' => 'ܡܫܬܚܠܦܢܘ̈ܬܐ',
	'view' => 'ܚܘܝ',
	'viewdeleted_short' => 'ܚܙܝ {{PLURAL:$1|ܚܕ ܫܘܚܠܦܐ ܫܝܦܐ|$1 ܫܘܚܠܦ̈ܐ ܫܝܦ̈ܐ}}',
	'views' => 'ܚܙܝܬ̈ܐ',
	'viewcount' => 'ܐܬܓܠܚܬ ܗܕܐ ܦܐܬܐ {{PLURAL:$1|ܙܒܢܬܐ ܚܕ|$1 ܙܒܢܝ̈ܢ}}.',
	'view-pool-error' => 'ܬܘܝܚܐ، ܚܕܡ̈ܐ ܗܘܐ ܓܗ̈ܝܐ ܗܫܐܝܬ
ܣܓܝ ܡܦܠܚܢ̈ܐ ܩܫܕܘܪܐ ܠܡܛܐ ܠܗܢܐ ܦܐܬܐ
ܦܝܣܐ ܡܢܟ ܣܟܝ ܩܠܝܠ ܡܢ ܩܕܡ ܕܓܪܒܬ ܠܡܛܝܐ ܠܐܗܐ ܦܐܬܐ ܬܢܝܢܘܬ.

$1',
	'viewsourceold' => 'ܚܙܝ ܡܒܘܥܐ',
	'viewsourcelink' => 'ܚܙܝ ܡܒܘܥܐ',
	'viewdeleted' => 'ܚܙܝ $1؟',
	'viewsource' => 'ܚܙܝ ܡܒܘܥܐ',
	'viewsourcetext' => 'ܡܨܐ ܐܢܬ ܠܚܙܝܐ ܘܢܣܚܐ ܠܡܒܘܥ̈ܐ ܕܐܗܐ ܦܐܬܐ:',
	'viewpagelogs' => 'ܚܙܝ ܣܓܠ̈ܐ ܕܦܐܬܐ ܗܕܐ',
	'viewprevnext' => 'ܚܘܝ ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'ܚܙܝ ܦܐܬܬ̈ܐ ܫܝܦܬ̈ܐ',
	'version' => 'ܨܚܚܐ',
	'version-specialpages' => 'ܦܐܬܬ̈ܐ ܕ̈ܝܠܢܝܬܐ',
	'version-other' => 'ܐܚܪܢܐ',
	'version-version' => '(ܨܚܚܐ $1)',
	'version-poweredby-others' => 'ܐܚܪ̈ܢܐ',
	'version-software-version' => 'ܨܚܚܐ',
);

$messages['arn'] = array(
	'variants' => 'Kaleyelu',
	'view' => 'Pen',
	'viewdeleted_short' => 'Pen {{PLURAL:$1|kiñe wirin ñamümgün|$1 wirin ñamümün}}',
	'views' => 'Adngelün',
	'viewsourceold' => 'Kimam chew küpan chi wirin',
	'viewsourcelink' => 'kimam chew küpan chi wirin',
	'viewdeleted' => 'Küpaadkintuymi $1 am?',
	'viewsource' => 'Kimam chew küpan chi wirin',
	'viewpagelogs' => 'Pen tüfachi wülngiñ ñi wirintukun',
	'viewprevnext' => 'Pen ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Pen pakina ñamümüngelu',
	'version-other' => 'Kakelu',
);

$messages['ary'] = array(
	'variants' => 'lhja:',
	'view' => 'ċof',
	'viewdeleted_short' => 'wrri {{PLURAL:$1|ṫĝdil mḫdof waḫd|$1 ṫĝdil(at) mḫdof(a)}}',
	'views' => 'Afiċaj',
	'viewcount' => 'had sfha tchaft {{PLURAL:$1|wa7d lmrra|$1 mrra}}.',
	'view-pool-error' => 'smh lina serveurat ayana
bzzaf dlmostakhdimin bghaw iwslo lhad sfha
aafak hawl mn ba3d wahd chwiya

$1',
	'versionrequired' => 'khassak version $1 dial mediawiki',
	'versionrequiredtext' => 'noskha $1 dyal mediawiki mtloba bach tstaaml had sfha
chof [[Special:Version|sfht lversion]]',
	'viewsourceold' => 'Ċof l-masdar',
	'viewsourcelink' => 'Ċof l-ĝin',
	'viewdeleted' => 'nchof $1?',
	'viewsource' => 'Ċof l-ĝin',
	'viewsourcetext' => 'imkn lik  tchof otcopie lmasdar dyak had sfha',
	'virus-badscanner' => "ḍabt ĥayb: scanneur de virus ma mĝrofċ: ''$1''.",
	'virus-scanfailed' => 's-skan fċel (kod $1)',
	'virus-unknownscanner' => 'antivirus mjhol :',
	'viewpagelogs' => 'Ċof l-ĝamaliyaṫ dyal had ṣ-ṣefḫa',
	'viewprevnext' => 'Ċof ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'had lfichier fih chi defout',
	'viewdeletedpage' => 'ċof ṣ-ṣfaḫi l-memḫiyya',
	'variantname-zh-hans' => 'Kṫaba',
	'variantname-zh-hant' => 'Kṫaba',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
	'variantname-zh-sg' => 'sg',
	'variantname-zh-my' => 'my',
	'variantname-zh' => 'zh',
	'variantname-gan-hans' => 'hans',
	'variantname-gan' => 'gan',
	'variantname-sr-ec' => 'sr-ec',
	'variantname-sr-el' => 'sr-el',
	'variantname-sr' => 'sr',
	'variantname-kk-kz' => 'kk-kz',
	'variantname-kk-tr' => 'kk-tr',
	'variantname-kk-cn' => 'kk-cn',
	'variantname-kk-cyrl' => 'kk-cyrl',
	'variantname-kk-latn' => 'kk-latn',
	'variantname-kk-arab' => 'kk-arab',
	'variantname-ku' => 'ku',
	'version' => 'Noskha',
	'version-extensions' => 'limtidadat lmotabbata',
	'version-specialpages' => 'Ṣefḫa ĥaṣa',
	'version-parserhooks' => 'khatatif lmohllil',
	'version-variables' => 'lmotaghayyirat',
	'version-antispam' => 'wiqaya mn ṣ-ṣpam',
	'version-skins' => 'skinat',
	'version-other' => 'okhra',
	'version-mediahandlers' => 'motahakkimat lmedia',
	'version-hooks' => 'lkhtatif',
	'version-extension-functions' => 'wadaif lmohallil',
	'version-parser-extensiontags' => 'wossom imtidad lmohallil',
	'version-parser-function-hooks' => 'khtatif dyal dalat lmohllil',
	'version-hook-name' => 'smiyt lkhttaf',
	'version-hook-subscribedby' => 'kaytstaml mn taraf',
	'version-version' => '(Noskha $1)',
	'version-license' => 'rokhssa',
	'version-poweredby-others' => 'khrin',
	'version-software' => "lbarnamaj li m'anstalli",
	'version-software-product' => 'lmntoj',
	'version-software-version' => 'noskha',
);

$messages['arz'] = array(
	'variants' => 'المتغيرات',
	'views' => 'مناظر',
	'viewcount' => 'الصفحة دى اتدخل عليها{{PLURAL:$1|مرة واحدة|مرتين|$1 مرات|$1 مرة}}.',
	'view-pool-error' => 'متأسفين, السيرفرات عليها حمل كبير دلوقتى.
فى يوزرات كتير قوى بيحاولو يشوفو الصفحه دى.
لو سمحت تستنا شويه قبل ما تحاول تستعرض الصفحه دى من تانى.

$1',
	'versionrequired' => 'لازم نسخة $1 من ميدياويكي',
	'versionrequiredtext' => 'النسخة $1 من ميدياويكى لازم علشان تستعمل الصفحة دى.
شوف [[Special:Version|صفحة النسخة]]',
	'viewsourceold' => 'عرض المصدر',
	'viewsourcelink' => 'عرض المصدر',
	'viewdeleted' => 'عرض $1؟',
	'viewsource' => 'عرض المصدر',
	'viewsourcetext' => 'ممكن تشوف وتنسخ مصدر  الصفحه دى:',
	'virus-badscanner' => "غلطه : ماسح فيروسات مش معروف: ''$1''",
	'virus-scanfailed' => 'المسح فشل(كود $1)',
	'virus-unknownscanner' => 'انتى فيروس مش معروف:',
	'viewpagelogs' => 'عرض السجلات للصفحه دى',
	'viewprevnext' => 'شوف ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'عرض الصفحات الممسوحة',
	'video-dims' => '$1، $2×$3',
	'version' => 'نسخه',
	'version-extensions' => 'الامتدادات المتثبتة',
	'version-specialpages' => 'صفحات مخصوصة',
	'version-parserhooks' => 'خطاطيف البريزر',
	'version-variables' => 'المتغيرات',
	'version-other' => 'تانية',
	'version-mediahandlers' => 'متحكمات الميديا',
	'version-hooks' => 'الخطاطيف',
	'version-extension-functions' => 'وظايف الامتداد',
	'version-parser-extensiontags' => 'التاجز بتوع امتداد البريزر',
	'version-parser-function-hooks' => 'خطاطيف دالة المحلل',
	'version-hook-name' => 'اسم الخطاف',
	'version-hook-subscribedby' => 'اشتراك باسم',
	'version-version' => '(نسخه $1)',
	'version-license' => 'الترخيص',
	'version-software' => 'السوفتوير المتستاب',
	'version-software-product' => 'المنتج',
	'version-software-version' => 'النسخه',
);

$messages['as'] = array(
	'variants' => 'বিকল্পসমূহ',
	'view' => 'দেখুৱাওক',
	'viewdeleted_short' => '{{PLURAL:$1| এটা বিলুপ্ত সম্পাদনা|$1 টা বিলুপ্ত সম্পাদনা}} দেখুৱাওক',
	'views' => 'দৰ্শন',
	'viewcount' => 'এই পৃষ্ঠাটো {{PLURAL:$1|এবাৰ|$1}} বাৰ চোৱা হৈছে',
	'view-pool-error' => 'দুঃখিত, এই মুহূৰ্তত চাৰ্ভাৰত অতিৰিক্ত চাপ পৰিছে ।
অজস্ৰ সদস্যই এই পৃষ্ঠা চাব বিচাৰিছে ।
অনুগ্ৰহ কৰি অলপ পাছত এই পৃষ্ঠা চাবলৈ প্ৰয়াস কৰক ।

$1',
	'versionrequired' => 'মিডিয়াৱিকিৰ $1 সংকলন থাকিব লাগিব ।',
	'versionrequiredtext' => 'এই পৃষ্ঠাটো ব্যৱহাৰ কৰিবলৈ মিডিয়াৱিকিৰ $1 সংস্কৰণ থাকিব লাগিব । [[Special:Version|সংস্কৰণ পৃষ্ঠা]] চাওক।',
	'viewsourceold' => 'উৎস চাওক',
	'viewsourcelink' => 'উৎস চাওক',
	'viewdeleted' => '$1 চাওক?',
	'viewsource' => 'উৎস চাওক',
	'viewsource-title' => '$1ৰ উৎস চাওক',
	'viewsourcetext' => 'আপুনি এই পৃষ্ঠাটোৰ উৎস চাব আৰু নকল কৰিব পাৰে',
	'viewyourtext' => "আপুনি '''আপোনাৰ সম্পাদনাসমূহ'''ৰ উৎস চাব আৰু এই পৃষ্ঠালৈ নকল কৰিব পাৰে:",
	'virus-badscanner' => "ভুল কনফিগাৰেচন: অজ্ঞাত ভাইৰাছ স্কেনাৰ: ''$1''",
	'virus-scanfailed' => 'স্কেন অসফল (কোড $1)',
	'virus-unknownscanner' => 'অজ্ঞাত এন্টিভাইৰাচ:',
	'viewpagelogs' => 'এই পৃষ্ঠাৰ অভিলেখ চাওক ।',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) চাওক।',
	'verification-error' => 'ফাইলৰ শুদ্ধতা বিচাৰত এই ফাইল ঊত্তীৰ্ণ নহ’ল ।',
	'viewdeletedpage' => 'বিলোপ কৰা পৃষ্ঠাসমূহ চাওক',
	'version' => 'সংস্কৰণ',
	'version-extensions' => 'ইন্‌ষ্টল কৰা এক্সটেনচনসমূহ',
	'version-specialpages' => 'বিশেষ পৃষ্ঠাসমূহ',
	'version-parserhooks' => 'পাৰ্চাৰ হুক',
	'version-variables' => 'চলকসমূহ',
	'version-antispam' => 'স্পাম প্ৰতিৰোধ',
	'version-skins' => 'আৱৰণ',
	'version-other' => 'অন্য',
	'version-mediahandlers' => 'মাধ্যম ব্যৱস্থাপকসমূহ',
	'version-hooks' => 'হুকসমূহ',
	'version-extension-functions' => 'সম্প্ৰসাৰন ফলনসমূহ',
	'version-parser-extensiontags' => 'পাৰ্চাৰ এক্সটেনচন টেগসমূহ',
	'version-parser-function-hooks' => 'পাৰ্চাৰ ফাংচন হুকসমূহ',
	'version-hook-name' => 'হুক নাম',
	'version-hook-subscribedby' => 'চাবস্ক্ৰাইব কৰিছে',
	'version-version' => '(সংস্কৰণ $1)',
	'version-license' => 'অনুজ্ঞাপত্ৰ',
	'version-poweredby-credits' => "এই ৱিকি '''[//www.mediawiki.org/ মিডিয়াৱিকিৰ]''' দ্বাৰা প্ৰচলিত , কপিৰাইট © ২০০১-$1 $2.",
	'version-poweredby-others' => 'অন্য',
	'version-license-info' => "মিডিয়াৱিকি এটা বিনামূলীয়া চফ্টৱেৰ; আপুনি Free Software Foundation -ৰ দ্বাৰা প্ৰকাশিত GNU General Public License -ৰ চুক্তিসমূহৰ অন্তৰ্গত ইয়াক পুনৰ বিলাব পাৰিব অথবা সলনি  কৰিব পাৰিব; হয়তো লাইচেঞ্চৰ সংস্কৰণ ২
অথবা (আপুনাৰ বিকল্পত) যিকোনো পৰৱৰ্তী সংস্কৰণ।

মিডিয়াৱিকি এইটো আশাত বিলোৱা হৈছে যে ই ব্যৱহাৰযোগ্য হ'ব, কিন্তু কোনো ৱাৰেন্টি নথকাকৈ; ব্যৱসায়ীক অথবা কোনো এটা বিশেষ কাৰণৰ যোগ্যতাৰ বাবে বুজোৱা ৱাৰেন্টি নথকাকৈ।
অধিক জানিবলৈ GNU General Public License চাওক।

আপুনি এই প্ৰগ্ৰামৰ সৈতে [{{SERVER}}{{SCRIPTPATH}}/COPYING GNU General Public License -ৰ এটা কপি] পাব লাগে; যদি নাই পোৱা, Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA অথবা [//www.gnu.org/licenses/old-licenses/gpl-2.0.html ইয়াক অনলাইন পঢ়ক] -লে লিখক।",
	'version-software' => 'ইনষ্টল কৰা ছফ্টৱেৰ',
	'version-software-product' => 'সামগ্ৰী',
	'version-software-version' => 'সংস্কৰণ',
);

$messages['ast'] = array(
	'variants' => 'Variantes',
	'view' => 'Ver',
	'viewdeleted_short' => 'Ver {{PLURAL:$1|una edición desaniciada|$1 ediciones desaniciaes}}',
	'views' => 'Vistes',
	'viewcount' => 'Esta páxina foi vista {{PLURAL:$1|una vegada|$1 vegaes}}.',
	'view-pool-error' => "Lo siento, los sirvidores tan sobrecargaos nesti intre.
Hai demasiaos usuarios intentando ver esta páxina.
Espera un momentu enantes d'intentar acceder a esta páxina.

$1",
	'versionrequired' => 'Necesítase la versión $1 de MediaWiki',
	'versionrequiredtext' => 'Necesítase la versión $1 de MediaWiki pa usar esta páxina. Ver la [[Special:Version|páxina de versión]].',
	'viewsourceold' => 'ver fonte',
	'viewsourcelink' => 'amosar la fonte',
	'viewdeleted' => '¿Ver $1?',
	'viewsource' => 'Ver códigu fonte',
	'viewsource-title' => 'Ver la fonte de "$1"',
	'viewsourcetext' => "Pues ver y copiar el códigu fonte d'esta páxina:",
	'viewyourtext' => "Pues ver y copiar el códigu fonte de '''les tos ediciones''' d'esta páxina:",
	'virus-badscanner' => "Error de configuración: escáner de virus desconocíu: ''$1''",
	'virus-scanfailed' => "fallu d'escanéu (códigu $1)",
	'virus-unknownscanner' => 'antivirus desconocíu:',
	'viewpagelogs' => "Ver rexistros d'esta páxina",
	'viewprevnext' => 'Ver ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Esti ficheru nun pasó la comprobación de ficheros.',
	'viewdeletedpage' => 'Ver páxines esborraes',
	'version' => 'Versión',
	'version-extensions' => 'Estensiones instalaes',
	'version-specialpages' => 'Páxines especiales',
	'version-parserhooks' => "Hooks d'análisis sintáuticu",
	'version-variables' => 'Variables',
	'version-antispam' => 'Prevención del corréu puxarra',
	'version-skins' => 'Apariencia',
	'version-other' => 'Otros',
	'version-mediahandlers' => "Remanadores d'archivos multimedia",
	'version-hooks' => 'Hooks',
	'version-extension-functions' => "Funciones d'estensiones",
	'version-parser-extensiontags' => "Etiquetes d'estensiones d'análisis",
	'version-parser-function-hooks' => "Hooks de les funciones d'análisis sintáuticu",
	'version-hook-name' => 'Nome del hook',
	'version-hook-subscribedby' => 'Suscritu por',
	'version-version' => '(Versión $1)',
	'version-license' => 'Llicencia',
	'version-poweredby-credits' => "Esta wiki funciona con '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'otros',
	'version-license-info' => "MediaWiki ye software llibre; pues redistribuilu y/o camudalu baxo los términos de la Llicencia Pública Xeneral GNU tal como ta asoleyada pola Free Software Foundation; o la versión 2 de la Llicencia, o (como prefieras) cualesquier versión posterior.

MediaWiki se distribúi col envís de que seya afayadiza, pero ENSIN GARANTÍA DALA; ensin siquiera garantía implícita de COMERCIALIDÁ o ADAUTACIÓN A UN DETERMINÁU PROPÓSITU. Llee la Llicencia Pública Xeneral GNU pa más detalles.

Tendríes d'haber recibío [{{SERVER}}{{SCRIPTPATH}}/COPYING una copia de la Llicencia Pública Xeneral GNU] xunto con esti programa; sinón, escribi a la Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA o [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lleela en llinia].",
	'version-software' => 'Software instaláu',
	'version-software-product' => 'Productu',
	'version-software-version' => 'Versión',
);

$messages['av'] = array(
	'viewsource' => 'Код бихьи',
);

$messages['avk'] = array(
	'views' => 'Wira',
	'viewcount' => 'Batu bu {{PLURAL:$1|1-on|$1 -on}} al zo ruper.',
	'versionrequired' => '$1 adraf siatos ke MediaWiki',
	'versionrequiredtext' => '$1 siatos ke MediaWiki tir adraf ta favera va batu bu. Voyez [[Special:Version]]',
	'viewsourceold' => 'Klitawira',
	'viewsourcelink' => 'Klitawira',
	'viewdeleted' => 'Va $1 djudisukel ?',
	'viewsource' => 'Wira va klitakrent',
	'viewsourcefor' => 'tori $1',
	'viewsourcetext' => 'Va buklita rowil nume roksudal :',
	'virus-scanfailed' => 'rodjeyena drunara ($1 beksa)',
	'virus-unknownscanner' => 'megrupena kevkioxeka :',
	'viewpagelogs' => 'Wira va "logs" ke batu bu',
	'viewprevnext' => 'Va ($1 {{int:pipe-separator}} $2) ik ($3) disukel.',
	'viewdeletedpage' => 'Disukera va sulayanu bu se',
	'version' => 'Siatos',
	'version-extensions' => 'Inkeyeni divatcesiki se',
	'version-specialpages' => 'Aptaf bueem',
	'version-parserhooks' => 'Exulerademi',
	'version-variables' => 'Remvodeem',
	'version-other' => 'Ar',
	'version-hooks' => 'Demi se',
	'version-extension-functions' => 'Divatces fliok se',
	'version-parser-extensiontags' => 'Exulerafa divatcenafa tcala',
	'version-parser-function-hooks' => 'Exuleraflidemi',
	'version-skin-extension-functions' => 'Wiatezaf divatces fliok se',
	'version-hook-name' => 'Demiyolt',
	'version-hook-subscribedby' => 'Wimpayan gan',
	'version-version' => '(Siatos $1)',
	'version-license' => 'Sorta',
	'version-software' => 'Inkeyen talpeyot',
	'version-software-product' => 'Warzeks',
	'version-software-version' => 'Siatos',
);

$messages['az'] = array(
	'variants' => 'Variantlar',
	'view' => 'Görünüş',
	'viewdeleted_short' => '{{PLURAL:$1|bir silinmiş redaktəyə|$1 silinmiş redaktəyə}}',
	'views' => 'Görünüş',
	'viewcount' => 'Bu səhifəyə $1 {{PLURAL:$1|dəfə}} müraciət olunub.',
	'view-pool-error' => 'Üzr istəyirik, hazırda serverlər artıq yüklənməyə məruz qalmışdır.
Bu səhifəyə baxmaq üçün həddən artıq müraciət daxil olmuşdur.
Zəhmət olmasa, bir müddət sonra yenidən cəhd edin.

$1',
	'versionrequired' => 'MediyaViki $1 versiyası lazımdır',
	'versionrequiredtext' => 'Bu səhifəni istifadə etmək üçün MediaWikinin $1 versiyası tələb olunur.
Bax: [[Special:Version|Versiyalar]].',
	'viewsourceold' => 'başlanğıc kodu nəzərdən keçir',
	'viewsourcelink' => 'başlanğıc kodu nəzərdən keçir',
	'viewdeleted' => '$1 göstərilsin?',
	'viewsource' => 'Mənbə göstər',
	'viewsource-title' => '$1 üçün mənbəyə bax',
	'viewsourcetext' => 'Siz bu səhifənin məzmununu görə və köçürə bilərsiniz:',
	'virus-badscanner' => "Düzgün olmayan konfiqurasiya: naməlum ''$1'' virus yoxlayanı",
	'virus-scanfailed' => 'Yoxlama başa çatmadı (kod $1)',
	'virus-unknownscanner' => 'naməlum antivirus',
	'viewpagelogs' => 'Bu səhifə ilə bağlı qeydlərə bax',
	'viewprevnext' => 'Göstər ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Fayl təsdiqi baş tutmadı.',
	'viewdeletedpage' => 'Silinmiş səhifələri göstər',
	'video-dims' => '$1, $2×$3',
	'variantname-zh-hans' => 'hans',
	'variantname-zh-hant' => 'hant',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
	'variantname-zh-sg' => 'sg',
	'variantname-zh' => 'zh',
	'variantname-gan-hans' => 'hans',
	'variantname-gan-hant' => 'hant',
	'variantname-gan' => 'gan',
	'variantname-kk-tr' => 'kk-tr',
	'variantname-kk-cn' => 'kk-cn',
	'variantname-ku-arab' => 'ku-Arab',
	'version' => 'Versiya',
	'version-extensions' => 'NIzamlanmış genişlənmələr',
	'version-specialpages' => 'Xüsusi səhifələr',
	'version-parserhooks' => 'Parser hooks',
	'version-variables' => 'Dəyişkənlər',
	'version-antispam' => 'Spam önləmə',
	'version-skins' => 'Üzlük',
	'version-other' => 'Digər',
	'version-hooks' => 'Çəngəllər',
	'version-extension-functions' => 'Əlavə fubksiyalar',
	'version-hook-name' => 'Çəngəlin adı',
	'version-hook-subscribedby' => 'Abunə olan',
	'version-version' => '(Versiya $1)',
	'version-license' => 'Lisenziya',
	'version-poweredby-credits' => "Bu wiki '''[//www.mediawiki.org/ MediaWiki]''' proqramı istifadə edilərək yaradılmışdır, müəlliflik © 2001-$1 $2.",
	'version-poweredby-others' => 'digərləri',
	'version-software-product' => 'Məhsul',
	'version-software-version' => 'Versiya',
);

$messages['ba'] = array(
	'variants' => 'Варианттар',
	'view' => 'Ҡарау',
	'viewdeleted_short' => '{{PLURAL:$1|1 юйылған үҙгәртеүҙе|$1 юйылған үҙгәртеүҙе}} ҡарау',
	'views' => 'Ҡарауҙар',
	'viewcount' => 'Был биткә $1 {{PLURAL:$1|тапҡыр}} мөрәжәғәт иттеләр.',
	'view-pool-error' => 'Ғәфү итегеҙ, хәҙерге ваҡытта серверҙар артыҡ тейәлгән.
Был битте ҡарарға теләүселәр бик күп.
Зинһар был биткә һуңырак кереп ҡарағыҙ.

$1',
	'versionrequired' => 'MediaWiki-ның $1 версияһы кәрәкле',
	'versionrequiredtext' => 'Был бит менән эшләү өсөн MediaWiki-ның $1 версияһы кәрәк. [[Special:Version|Ҡулланылған версия тураһында мәғлүмәт битен]] ҡара.',
	'viewsourceold' => 'сығанаҡ кодты ҡарарға',
	'viewsourcelink' => 'сығанаҡ кодты ҡарарға',
	'viewdeleted' => '$1 ҡарарғамы?',
	'viewsource' => 'Сығанаҡты ҡарау',
	'viewsource-title' => '$1 битенең сығанаҡ текстын ҡарарға',
	'viewsourcetext' => 'Һеҙ был биттең сығанаҡ текстын ҡарай һәм күсермәһен ала алаһығыҙ:',
	'viewyourtext' => "Был биттәге '''үҙгәртеүҙәрегеҙҙең''' сығанаҡ текстын ҡарай һәм күсермәһен ала алаһығыҙ:",
	'virus-badscanner' => "Көйләү хатаһы: Билдәһеҙ вирустар сканеры: ''$1''",
	'virus-scanfailed' => 'сканлау хатаһы ($1 коды)',
	'virus-unknownscanner' => 'беленмәгән антивирус:',
	'viewpagelogs' => 'Был биттең яҙмаларын ҡарарға',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) ҡарарға',
	'verification-error' => 'Был файл тикшереү үтмәгән.',
	'viewdeletedpage' => 'Юйылған биттәрҙе ҡарау',
	'version' => 'MediaWiki өлгөһө',
	'version-extensions' => 'Ҡуйылған киңәйтеүҙәр',
	'version-specialpages' => 'Махсус биттәр',
	'version-parserhooks' => 'Уҡыу ҡоралдары',
	'version-variables' => 'Үҙгәреүсән дәүмәлдәр',
	'version-antispam' => 'Спамға ҡаршы ҡорал',
	'version-skins' => 'Күренештәр',
	'version-other' => 'Башҡалар',
	'version-mediahandlers' => 'Медиа эшкәртеүсе ҡоралдар',
	'version-hooks' => 'Эләктереп алыусылар',
	'version-extension-functions' => 'Киңәйтеү функциялары',
	'version-parser-extensiontags' => 'Уҡыу ҡоралдары киңәйтеүҙәре тегтары',
	'version-parser-function-hooks' => 'Уҡыу ҡоралдары функцияларын эләктереп алыусылар',
	'version-hook-name' => 'Эләктереп алыусы исеме',
	'version-hook-subscribedby' => 'Яҙҙырылған',
	'version-version' => '($1 өлгөһө)',
	'version-license' => 'Рөхсәтнамә',
	'version-poweredby-credits' => "Был вики проект '''[//www.mediawiki.org/ MediaWiki]''' нигеҙендә эшләй, copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'башҡалар',
	'version-license-info' => 'MediaWiki — ирекле программа, һеҙ уны Ирекле программалар фонды тарафынан баҫтырылған GNU General Public License рөхсәтнамәһенә ярашлы тарата һәм/йәки үҙгәртә алаһығыҙ (рөхсәтнамәнең йә исенсе өлгөһө, йә унан һуңғы өлгөләре).

MediaWiki файҙалы булыр, тигән өмөттә, ләкин БЕР НИДӘЙ ҘӘ ЯУАПЛЫЛЫҠ ЙӨКЛӘМӘҺЕҘ, хатта фараз ителгән ҺАТЫУ ӨСӨН ЯРАҠЛЫЛЫҠ йәки БИЛДӘЛӘНГӘН МАҠСАТ ӨСӨН ЯРАҠЛЫТЫҠ тураһында яуаплылыҡ йөкләмәһеҙ таратыла. Ентекле мәғлүмәт алыр өсөн, GNU General Public License рөхсәтнамәһе тураһында уҡығыҙ.

Был программа менән ҡуша һеҙ [{{SERVER}}{{SCRIPTPATH}}/COPYING GNU General Public License рөхсәтнамәһенең күсермәһен] алырға тейеш инегеҙ, әгәр юҡ икән, Ирекле программалар фондына 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA адресы буйынса яҙығыҙ, йәки рөхсәтнамәнең [//www.gnu.org/licenses/old-licenses/gpl-2.0.html онлайн өлгөһөн] уҡығыҙ.',
	'version-software' => 'Ҡуйылған программалар',
	'version-software-product' => 'Продукт',
	'version-software-version' => 'Өлгөһө',
);

$messages['bar'] = array(
	'variants' => 'Varianten',
	'view' => 'Leesen',
	'viewdeleted_short' => '{{PLURAL:$1|Oah geléschde Versión|$1 geléschde Versiónen}} åschauh',
	'views' => 'Åsichten',
	'viewcount' => 'Dé Seiten do is bis iatz {{PLURAL:$1|oahmoi|$1-moi}} obgruaffm worn.',
	'view-pool-error' => "Tschuidige, dé Server san im Moment ywerlostt.
Zvü Leid vasuachen, dé Seiten do z' bsuachen.
Bittscheh wort a por Minuten, bevur du 's nohamoi vasuachst.

$1",
	'versionrequired' => 'Versión $1 voh MediaWiki werd braucht.',
	'versionrequiredtext' => "Versión $1 voh MediaWiki werd braucht, um dé Seiten nützen z' kenner.
Schaug auf [[Special:Version|Versiónsseiten]]",
	'viewsourceold' => 'Quötext åzoang',
	'viewsourcelink' => 'an Quötext åschauh',
	'viewdeleted' => '$1 åzoang?',
	'viewsource' => 'an Quötext åschauh',
	'viewsource-title' => 'Quöntext voh da Seiten $1 auhschauh',
	'viewsourcetext' => "Du kåst ower 'n Quötext åschaung und kópirn:",
	'viewyourtext' => "Du kåst 'n Quejtext vah '''deiner Beorwatung''' derer Seiten betrochten und kópiern:",
	'virus-badscanner' => "Feelerhofte Kónfigurazión: unbekaunnter Virnscanner: ''$1''",
	'virus-scanfailed' => 'Scan is föögschlong (code $1)',
	'virus-unknownscanner' => 'Néd bekaunnter Virnscanner:',
	'viewpagelogs' => 'Logbiacher fyr dé Seiten åzoang',
	'viewprevnext' => 'Zoag ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Versión',
	'version-extensions' => 'Installierde Daweiterrungen',
	'version-specialpages' => 'Speziaalseiten',
	'version-parserhooks' => 'Parser-Hooks',
	'version-variables' => 'Variaablen',
	'version-antispam' => 'Spamschutz',
	'version-skins' => 'Benutzerówerflächen',
	'version-other' => 'Ånders',
	'version-mediahandlers' => 'Meediennutzung',
	'version-hooks' => "Schnidstön ''(Hooks)''",
	'version-extension-functions' => 'Funkziónsaufruaffe',
	'version-parser-extensiontags' => "Parserdaweiterrungen ''(tags)''",
	'version-parser-function-hooks' => 'Parserfunkziónen',
	'version-hook-name' => 'Schnidstönnaum',
	'version-hook-subscribedby' => 'Aufruaff voh',
	'version-version' => '(Versión $1)',
	'version-license' => 'Lizenz',
	'version-poweredby-credits' => "Dé Nétzseiten braucht '''[//www.mediawiki.org/wiki/MediaWiki/de MediaWiki]''', Copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'åndre',
);

$messages['bat-smg'] = array(
	'variants' => 'Varianten',
	'view' => 'Leesen',
	'viewdeleted_short' => '{{PLURAL:$1|Oah geléschde Versión|$1 geléschde Versiónen}} åschauh',
	'views' => 'Åsichten',
	'viewcount' => 'Dé Seiten do is bis iatz {{PLURAL:$1|oahmoi|$1-moi}} obgruaffm worn.',
	'view-pool-error' => "Tschuidige, dé Server san im Moment ywerlostt.
Zvü Leid vasuachen, dé Seiten do z' bsuachen.
Bittscheh wort a por Minuten, bevur du 's nohamoi vasuachst.

$1",
	'versionrequired' => 'Versión $1 voh MediaWiki werd braucht.',
	'versionrequiredtext' => "Versión $1 voh MediaWiki werd braucht, um dé Seiten nützen z' kenner.
Schaug auf [[Special:Version|Versiónsseiten]]",
	'viewsourceold' => 'Quötext åzoang',
	'viewsourcelink' => 'an Quötext åschauh',
	'viewdeleted' => '$1 åzoang?',
	'viewsource' => 'an Quötext åschauh',
	'viewsource-title' => 'Quöntext voh da Seiten $1 auhschauh',
	'viewsourcetext' => "Du kåst ower 'n Quötext åschaung und kópirn:",
	'viewyourtext' => "Du kåst 'n Quejtext vah '''deiner Beorwatung''' derer Seiten betrochten und kópiern:",
	'virus-badscanner' => "Feelerhofte Kónfigurazión: unbekaunnter Virnscanner: ''$1''",
	'virus-scanfailed' => 'Scan is föögschlong (code $1)',
	'virus-unknownscanner' => 'Néd bekaunnter Virnscanner:',
	'viewpagelogs' => 'Logbiacher fyr dé Seiten åzoang',
	'viewprevnext' => 'Zoag ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Versión',
	'version-extensions' => 'Installierde Daweiterrungen',
	'version-specialpages' => 'Speziaalseiten',
	'version-parserhooks' => 'Parser-Hooks',
	'version-variables' => 'Variaablen',
	'version-antispam' => 'Spamschutz',
	'version-skins' => 'Benutzerówerflächen',
	'version-other' => 'Ånders',
	'version-mediahandlers' => 'Meediennutzung',
	'version-hooks' => "Schnidstön ''(Hooks)''",
	'version-extension-functions' => 'Funkziónsaufruaffe',
	'version-parser-extensiontags' => "Parserdaweiterrungen ''(tags)''",
	'version-parser-function-hooks' => 'Parserfunkziónen',
	'version-hook-name' => 'Schnidstönnaum',
	'version-hook-subscribedby' => 'Aufruaff voh',
	'version-version' => '(Versión $1)',
	'version-license' => 'Lizenz',
	'version-poweredby-credits' => "Dé Nétzseiten braucht '''[//www.mediawiki.org/wiki/MediaWiki/de MediaWiki]''', Copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'åndre',
);

$messages['bcc'] = array(
	'variants' => 'گوشگان',
	'views' => 'چارگان',
	'viewcount' => 'ای صفحه دسترسی بیتگ {{PLURAL:$1|بار|$1رند}}.',
	'view-pool-error' => 'متاسفانه، سرور هنون بازگین باری سر انت.
بازگین کاربری این تاک ءَ چارگنت.
لطفا کمی صبر کنیت پیش چه شی که دگه ای تاک بچاریت.

$1',
	'versionrequired' => 'نسخه $1. مدیا وی کی نیازنت',
	'versionrequiredtext' => 'نسخه $1 چه مدیا وی کی نیازنت په استفاده ای صفحه. بچار [[Special:Version|version page]].',
	'viewsourceold' => 'به گند منبع ا',
	'viewsourcelink' => 'چارگ منبع',
	'viewdeleted' => 'به گند $1?',
	'viewsource' => 'به گند منبع آ',
	'viewsourcetext' => 'شما تونیت به گند و کپی کنیت منبع ای صفحه آ',
	'virus-badscanner' => "تنظیم بد: ناشناسین اسکنر ویروس: ''$1''",
	'virus-scanfailed' => 'اسکن پروش وارت(کد $1)',
	'virus-unknownscanner' => 'ناشناسین آنتی ویروس:',
	'viewpagelogs' => 'آمار ای صفحه بچار',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) دیدگ',
	'viewdeletedpage' => 'به گند صفحات حذفیء',
	'variantname-zh-hans' => 'هانس',
	'variantname-zh-hant' => 'هانت',
	'variantname-zh-cn' => 'چن',
	'variantname-zh-tw' => 'تایوان',
	'variantname-zh-hk' => 'هک',
	'variantname-zh-sg' => 'چی=سج',
	'variantname-zh' => 'چین',
	'variantname-sr-ec' => 'سر-اک',
	'variantname-sr-el' => 'سر-ال',
	'variantname-sr' => 'سر',
	'variantname-kk-kz' => 'کک-کز',
	'variantname-kk-tr' => 'کک-تر',
	'variantname-kk-cn' => 'کک-سن',
	'variantname-kk-cyrl' => 'کک-سرل',
	'variantname-kk-latn' => 'کک-لت',
	'variantname-kk-arab' => 'کک-ارب',
	'variantname-kk' => 'کک',
	'variantname-ku-arab' => 'کو-ار',
	'variantname-ku-latn' => 'کو-لت',
	'variantname-ku' => 'کرد',
	'variantname-tg-cyrl' => 'سریل-تج',
	'variantname-tg-latn' => 'لاتین-ت.ج',
	'variantname-tg' => 'تج',
	'version' => 'نسخه',
	'version-extensions' => 'نصب بوتگیت الحاق آن',
	'version-specialpages' => 'حاصین صفحات',
	'version-parserhooks' => 'تجزیه کنوک گیر کت',
	'version-variables' => 'متغییران',
	'version-other' => 'دگر',
	'version-mediahandlers' => 'دست گروک مدیا',
	'version-hooks' => 'گیر کنت',
	'version-extension-functions' => 'عملگران الحاقی',
	'version-parser-extensiontags' => 'برچسپان الحاقی تجزیه گر',
	'version-parser-function-hooks' => 'عمل گر تجزیه کنوک گیر کت',
	'version-hook-name' => 'نام گیر',
	'version-hook-subscribedby' => 'اشتراک بیت گون',
	'version-version' => '(نسخه $1)',
	'version-license' => 'لیسانس',
	'version-software' => 'نصبین برنامه',
	'version-software-product' => 'محصول',
	'version-software-version' => 'نسخه',
);

$messages['bcl'] = array(
	'view' => 'Mga paghilíng',
	'views' => 'Mga hilíng',
	'viewcount' => 'Binukasán ining pahina nin {{PLURAL:$1|sarong beses|nin $1 beses}}.',
	'versionrequired' => 'Kaipuhan an bersyon $1 kan MediaWiki',
	'versionrequiredtext' => 'Kaipuhan an bersyon $1 kan MediaWiki sa paggamit kan pahinang ini. Hilíngón an [[Special:Version|Bersyon kan pahina]].',
	'viewsourceold' => 'hilingón an ginikánan',
	'viewsourcelink' => 'hilingón an toltólan',
	'viewdeleted' => 'Hilingón an $1?',
	'viewsource' => 'Hilingón an ginikanan',
	'viewsourcetext' => 'Pwede mong hilingón asin arógon an ginikanan kan pahinang ini:',
	'virus-badscanner' => "Saláng konfigurasyon: dai aram an virus scanner: ''$1''",
	'virus-unknownscanner' => 'dai aram an antivirus:',
	'viewpagelogs' => 'Hilingón an mga usip para sa pahinang ini',
	'viewprevnext' => 'Hilingón ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Hilingón an mga pinarang pahina',
	'version' => 'Bersyon',
);

$messages['be'] = array(
	'variants' => 'Варыянты',
	'view' => 'Паказ',
	'viewdeleted_short' => 'Паказаць {{PLURAL:$1|адну сцёртую праўку|$1 сцёртыя праўкі}}',
	'views' => 'Віды',
	'viewcount' => 'Гэту старонку адкрывалі {{PLURAL:$1|адзін раз|$1 разоў}}.',
	'view-pool-error' => 'На жаль, у гэты момант серверы перагружаны.
Занадта многія чытачы спрабуюць адкрыць гэтую старонку.
Калі ласка, трохі пачакайце, перш чым адкрываць гэтую старонку ізноў.

$1',
	'versionrequired' => 'Патрабуецца MediaWiki версіі $1',
	'versionrequiredtext' => 'Каб карыстацца гэтай старонкай, патрабуецца MediaWiki версіі $1. Гл. [[Special:Version]]',
	'viewsourceold' => 'гл. выток',
	'viewsourcelink' => 'паказ крыніцы',
	'viewdeleted' => 'Ці паказаць $1?',
	'viewsource' => 'Паказаць выточны тэкст',
	'viewsource-title' => 'Прагляд зыходнага тэксту старонкі $1',
	'viewsourcetext' => 'Можна бачыць і капіраваць крынічны тэкст гэтай старонкі:',
	'viewyourtext' => "Вы можаце праглядзець і скапіяваць зыходны тэкст '''вашых правак''' на гэтай старонцы:",
	'virus-badscanner' => "Некарэктная канфігурацыя: невядомы антывірусны сканер: ''$1''",
	'virus-scanfailed' => 'не ўдалося праверыць (код $1)',
	'virus-unknownscanner' => 'невядомы антывірус:',
	'viewpagelogs' => 'Паказаць журналы для гэтай старонкі',
	'viewprevnext' => 'Гл. ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Гэты файл не прайшоў файлавую праверку.',
	'viewdeletedpage' => 'Паказаць сцёртыя старонкі',
	'version' => 'Версія',
	'version-extensions' => 'Устаноўленыя прыстаўкі',
	'version-specialpages' => 'Адмысловыя старонкі',
	'version-parserhooks' => 'Хукі парсера',
	'version-variables' => 'Зменныя',
	'version-antispam' => 'Абарона ад спаму',
	'version-skins' => 'Вокладкі',
	'version-other' => 'Рознае',
	'version-mediahandlers' => 'Апрацоўнікі мультымедый',
	'version-hooks' => 'Хукі',
	'version-extension-functions' => 'Функцыі прыстаўкі',
	'version-parser-extensiontags' => 'Тагі прыстаўкі да парсера',
	'version-parser-function-hooks' => 'Хукі функцый парсера',
	'version-hook-name' => 'Назва хука',
	'version-hook-subscribedby' => 'Сюды падпісаныя',
	'version-version' => '(Версія $1)',
	'version-license' => 'Ліцэнзія',
	'version-poweredby-credits' => "Пляцоўка працуе на '''[//www.mediawiki.org/ MediaWiki]''', капірайт © 2001-$1 $2.",
	'version-poweredby-others' => 'іншыя',
	'version-license-info' => "MediaWiki з'яўляецца свабодным праграмным забеспячэннем. Такім чынам, вы можаце паўторна распаўсюджваць прадукт і(або) змяняць яго на ўмовах пагаднення GNU General Public License у тым выглядзе, у якім яно публікуецца фондам Free Software Foundation; сілу мае версія (выпуск) 2 гэтага пагаднення або, на ваш выбар, навейшая версія (выпуск) пагаднення.

MediaWiki распаўсюджваецца, спадзеючыся на прыдатнасць прадукта, але БЕЗ ЯКІХ-НЕБУДЗЬ ГАРАНТЫЙ, у тым ліку, без імплікаваных гарантый СПАЖЫВЕЦКАЙ ВАРТАСЦІ або ПРЫДАТНАСЦІ ДЛЯ ЯКОЙ-НЕБУДЗЬ МЭТЫ. Больш падрабязна гл. пагадненне GNU General Public License.

Разам з гэтым праграмным забеспячэннем вы павінны былі атрымаць [{{SERVER}}{{SCRIPTPATH}}/COPYING копію пагаднення GNU General Public License]. Калі гэта не так, паведамце аб гэтым у фонд Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA або [//www.gnu.org/licenses/old-licenses/gpl-2.0.html атрымайце яе з Інтэрнэту].",
	'version-software' => 'Устаноўленыя праграмныя прадукты',
	'version-software-product' => 'Прадукт',
	'version-software-version' => 'Версія',
);

$messages['be-tarask'] = array(
	'variants' => 'Варыянты',
	'view' => 'Прагляд',
	'viewdeleted_short' => 'Паказаць $1 {{PLURAL:$1|выдаленае рэдагаваньне|выдаленыя рэдагаваньні|выдаленых рэдагаваньняў}}',
	'views' => 'Прагляды',
	'viewcount' => 'Гэтую старонку праглядалі $1 {{PLURAL:$1|раз|разы|разоў}}.',
	'view-pool-error' => 'Прабачце, у цяперашні момант сэрвэры перагружаныя.
Занадта шмат удзельнікаў спрабуюць праглядзець гэтую старонку.
Калі ласка, пачакайце і паспрабуйце зайсьці пазьней.

$1',
	'versionrequired' => 'Патрабуецца MediaWiki вэрсіі $1',
	'versionrequiredtext' => 'Для карыстаньня гэтай старонкай патрабуецца MediaWiki вэрсіі $1. Глядзіце [[Special:Version|інфармацыю пра вэрсію]].',
	'viewsourceold' => 'паказаць крыніцу',
	'viewsourcelink' => 'паказаць крыніцу',
	'viewdeleted' => 'Паказаць $1?',
	'viewsource' => 'Паказаць крыніцу',
	'viewsource-title' => 'Прагляд крыніцы для $1',
	'viewsourcetext' => 'Вы можаце праглядаць і капіяваць крынічны тэкст гэтай старонкі:',
	'viewyourtext' => "Вы можаце праглядзець і скапіяваць крынічны тэкст '''вашых рэдагаваньняў''' на гэтую старонку:",
	'virus-badscanner' => "Няслушная канфігурацыя: невядомы антывірусны сканэр: ''$1''",
	'virus-scanfailed' => 'памылка сканаваньня (код $1)',
	'virus-unknownscanner' => 'невядомы антывірус:',
	'viewpagelogs' => 'Паказаць журналы падзеяў для гэтай старонкі',
	'viewprevnext' => 'Паказаць ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Гэты файл не прайшоў вэрыфікацыю.',
	'viewdeletedpage' => 'Паказаць выдаленыя старонкі',
	'version' => 'Вэрсія',
	'version-extensions' => 'Усталяваныя пашырэньні',
	'version-specialpages' => 'Спэцыяльныя старонкі',
	'version-parserhooks' => 'Працэдуры-перахопнікі парсэра',
	'version-variables' => 'Зьменныя',
	'version-antispam' => 'Абарона ад спаму',
	'version-skins' => 'Афармленьні',
	'version-api' => 'API',
	'version-other' => 'Іншыя',
	'version-mediahandlers' => 'Апрацоўшчыкі мэдыя',
	'version-hooks' => 'Працэдуры-перахопнікі',
	'version-extension-functions' => 'Функцыі пашырэньняў',
	'version-parser-extensiontags' => 'Тэгі пашырэньняў парсэра',
	'version-parser-function-hooks' => 'Перахопнікі функцыяў парсэра',
	'version-hook-name' => 'Назва працэдуры-перахопніка',
	'version-hook-subscribedby' => 'Падпісаны на',
	'version-version' => '(Вэрсія $1)',
	'version-svn-revision' => '(r$2)',
	'version-license' => 'Ліцэнзія',
	'version-poweredby-credits' => "{{SITENAME}} працуе на праграмным забесьпячэньні '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'іншыя',
	'version-license-info' => 'MediaWiki зьяўляецца вольным праграмным забесьпячэньнем, якое Вы можаце распаўсюджваць і/ці зьмяняць на ўмовах ліцэнзіі GNU General Public License вэрсіі 2 ці болей позьняй, апублікаванай Фундацыяй вольнага праграмнага забесьпячэньня (Free Software Foundation).

MediaWiki распаўсюджваецца з надзеяй, што будзе карысным, але БЕЗ АНІЯКІХ ГАРАНТЫЯЎ, нават без меркаваных гарантыяў КАМЭРЦЫЙНАЙ КАШТОЎНАСЬЦІ ці ПРЫДАТНАСЬЦІ ДА ПЭЎНАЙ МЭТЫ. Глядзіце ліцэнзію GNU General Public License для болей падрабязных зьвестак.

Вы мусілі атрымаць [{{SERVER}}{{SCRIPTPATH}}/COPYING копію GNU General Public License] разам з гэтым праграмным забесьпячэньнем. Калі не, напішыце Free Software Foundation, Inc. па адрасе 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA, альбо прачытайце [//www.gnu.org/licenses/old-licenses/gpl-2.0.html он-лайн копію ліцэнзіі].',
	'version-software' => 'Усталяванае праграмнае забесьпячэньне',
	'version-software-product' => 'Прадукт',
	'version-software-version' => 'Вэрсія',
);

$messages['be-x-old'] = array(
	'variants' => 'Варыянты',
	'view' => 'Прагляд',
	'viewdeleted_short' => 'Паказаць $1 {{PLURAL:$1|выдаленае рэдагаваньне|выдаленыя рэдагаваньні|выдаленых рэдагаваньняў}}',
	'views' => 'Прагляды',
	'viewcount' => 'Гэтую старонку праглядалі $1 {{PLURAL:$1|раз|разы|разоў}}.',
	'view-pool-error' => 'Прабачце, у цяперашні момант сэрвэры перагружаныя.
Занадта шмат удзельнікаў спрабуюць праглядзець гэтую старонку.
Калі ласка, пачакайце і паспрабуйце зайсьці пазьней.

$1',
	'versionrequired' => 'Патрабуецца MediaWiki вэрсіі $1',
	'versionrequiredtext' => 'Для карыстаньня гэтай старонкай патрабуецца MediaWiki вэрсіі $1. Глядзіце [[Special:Version|інфармацыю пра вэрсію]].',
	'viewsourceold' => 'паказаць крыніцу',
	'viewsourcelink' => 'паказаць крыніцу',
	'viewdeleted' => 'Паказаць $1?',
	'viewsource' => 'Паказаць крыніцу',
	'viewsource-title' => 'Прагляд крыніцы для $1',
	'viewsourcetext' => 'Вы можаце праглядаць і капіяваць крынічны тэкст гэтай старонкі:',
	'viewyourtext' => "Вы можаце праглядзець і скапіяваць крынічны тэкст '''вашых рэдагаваньняў''' на гэтую старонку:",
	'virus-badscanner' => "Няслушная канфігурацыя: невядомы антывірусны сканэр: ''$1''",
	'virus-scanfailed' => 'памылка сканаваньня (код $1)',
	'virus-unknownscanner' => 'невядомы антывірус:',
	'viewpagelogs' => 'Паказаць журналы падзеяў для гэтай старонкі',
	'viewprevnext' => 'Паказаць ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Гэты файл не прайшоў вэрыфікацыю.',
	'viewdeletedpage' => 'Паказаць выдаленыя старонкі',
	'version' => 'Вэрсія',
	'version-extensions' => 'Усталяваныя пашырэньні',
	'version-specialpages' => 'Спэцыяльныя старонкі',
	'version-parserhooks' => 'Працэдуры-перахопнікі парсэра',
	'version-variables' => 'Зьменныя',
	'version-antispam' => 'Абарона ад спаму',
	'version-skins' => 'Афармленьні',
	'version-api' => 'API',
	'version-other' => 'Іншыя',
	'version-mediahandlers' => 'Апрацоўшчыкі мэдыя',
	'version-hooks' => 'Працэдуры-перахопнікі',
	'version-extension-functions' => 'Функцыі пашырэньняў',
	'version-parser-extensiontags' => 'Тэгі пашырэньняў парсэра',
	'version-parser-function-hooks' => 'Перахопнікі функцыяў парсэра',
	'version-hook-name' => 'Назва працэдуры-перахопніка',
	'version-hook-subscribedby' => 'Падпісаны на',
	'version-version' => '(Вэрсія $1)',
	'version-svn-revision' => '(r$2)',
	'version-license' => 'Ліцэнзія',
	'version-poweredby-credits' => "{{SITENAME}} працуе на праграмным забесьпячэньні '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'іншыя',
	'version-license-info' => 'MediaWiki зьяўляецца вольным праграмным забесьпячэньнем, якое Вы можаце распаўсюджваць і/ці зьмяняць на ўмовах ліцэнзіі GNU General Public License вэрсіі 2 ці болей позьняй, апублікаванай Фундацыяй вольнага праграмнага забесьпячэньня (Free Software Foundation).

MediaWiki распаўсюджваецца з надзеяй, што будзе карысным, але БЕЗ АНІЯКІХ ГАРАНТЫЯЎ, нават без меркаваных гарантыяў КАМЭРЦЫЙНАЙ КАШТОЎНАСЬЦІ ці ПРЫДАТНАСЬЦІ ДА ПЭЎНАЙ МЭТЫ. Глядзіце ліцэнзію GNU General Public License для болей падрабязных зьвестак.

Вы мусілі атрымаць [{{SERVER}}{{SCRIPTPATH}}/COPYING копію GNU General Public License] разам з гэтым праграмным забесьпячэньнем. Калі не, напішыце Free Software Foundation, Inc. па адрасе 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA, альбо прачытайце [//www.gnu.org/licenses/old-licenses/gpl-2.0.html он-лайн копію ліцэнзіі].',
	'version-software' => 'Усталяванае праграмнае забесьпячэньне',
	'version-software-product' => 'Прадукт',
	'version-software-version' => 'Вэрсія',
);

$messages['bg'] = array(
	'variants' => 'Варианти',
	'view' => 'Преглед',
	'viewdeleted_short' => 'Преглед на {{PLURAL:$1|една изтрита редакция|$1 изтрити редакции}}',
	'views' => 'Прегледи',
	'viewcount' => 'Страницата е била преглеждана {{PLURAL:$1|един път|$1 пъти}}.',
	'view-pool-error' => 'Съжаляваме, но сървърите в момента са претоварени.
Твърде много потребители се опитват да отворят тази страница.
Моля, изчакайте малко преди отново да пробвате да отворите страницата.

$1',
	'versionrequired' => 'Изисква се версия $1 на МедияУики',
	'versionrequiredtext' => 'Използването на тази страница изисква версия $1 на софтуера МедияУики. Вижте [[Special:Version|текущата използвана версия]].',
	'viewsourceold' => 'преглед на кода',
	'viewsourcelink' => 'преглед на кода',
	'viewdeleted' => 'Преглед на $1?',
	'viewsource' => 'Преглед на кода',
	'viewsource-title' => 'Преглеждане на кода на $1',
	'viewsourcetext' => 'Можете да разгледате и да копирате кодa на страницата:',
	'viewyourtext' => "Можете да прегледате и копирате изходния код на '''вашите редакции''' на тази страница:",
	'virus-badscanner' => "Лоша конфигурация: непознат скенер за вируси: ''$1''",
	'virus-scanfailed' => 'сканирането не сполучи (код $1)',
	'virus-unknownscanner' => 'непознат антивирус:',
	'viewpagelogs' => 'Преглед на извършените административни действия по страницата',
	'viewprevnext' => 'Преглед ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Файлът не премина процедурата по верификация.',
	'viewdeletedpage' => 'Преглед на изтрити страници',
	'version' => 'Версия',
	'version-extensions' => 'Инсталирани разширения',
	'version-specialpages' => 'Специални страници',
	'version-parserhooks' => 'Куки в парсера',
	'version-variables' => 'Променливи',
	'version-antispam' => 'Предотвратяване на спам',
	'version-skins' => 'Облици',
	'version-other' => 'Други',
	'version-mediahandlers' => 'Обработчици на медия',
	'version-hooks' => 'Куки',
	'version-extension-functions' => 'Допълнителни функции',
	'version-parser-extensiontags' => 'Етикети от парсерни разширения',
	'version-parser-function-hooks' => 'Куки в парсерни функции',
	'version-hook-name' => 'Име на куката',
	'version-hook-subscribedby' => 'Ползвана от',
	'version-version' => '(Версия $1)',
	'version-license' => 'Лиценз',
	'version-poweredby-credits' => "Това уики се задвиждва от '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'други',
	'version-license-info' => 'MediaWiki е свободен софтуер, можете да го разпространявате и/или променяте съгласно условията на GNU General Public License, както е публикуван от Free Software Foundation, версия 2 на лиценза или (по ваше усмотрение) която и да е следваща версия.

MediaWiki се разпространява с надеждата, че ще бъде полезен, но БЕЗ НИКАКВИ ГАРАНЦИИ, без дори косвена гаранция за ПРОДАВАЕМОСТ или ПРИГОДНОСТ ЗА КОНКРЕТНА УПОТРЕБА. Вижте GNU General Public License за повече подробности.

Трябва да сте получили [{{SERVER}}{{SCRIPTPATH}}/COPYING копие на GNU General Public License] заедно с тази програма. Ако не сте, пишете на Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA или го [//www.gnu.org/licenses/old-licenses/gpl-2.0.html прочетете в мрежата].',
	'version-software' => 'Инсталиран софтуер',
	'version-software-product' => 'Продукт',
	'version-software-version' => 'Версия',
);

$messages['bh'] = array(
	'variants' => 'Варианти',
	'view' => 'Преглед',
	'viewdeleted_short' => 'Преглед на {{PLURAL:$1|една изтрита редакция|$1 изтрити редакции}}',
	'views' => 'Прегледи',
	'viewcount' => 'Страницата е била преглеждана {{PLURAL:$1|един път|$1 пъти}}.',
	'view-pool-error' => 'Съжаляваме, но сървърите в момента са претоварени.
Твърде много потребители се опитват да отворят тази страница.
Моля, изчакайте малко преди отново да пробвате да отворите страницата.

$1',
	'versionrequired' => 'Изисква се версия $1 на МедияУики',
	'versionrequiredtext' => 'Използването на тази страница изисква версия $1 на софтуера МедияУики. Вижте [[Special:Version|текущата използвана версия]].',
	'viewsourceold' => 'преглед на кода',
	'viewsourcelink' => 'преглед на кода',
	'viewdeleted' => 'Преглед на $1?',
	'viewsource' => 'Преглед на кода',
	'viewsource-title' => 'Преглеждане на кода на $1',
	'viewsourcetext' => 'Можете да разгледате и да копирате кодa на страницата:',
	'viewyourtext' => "Можете да прегледате и копирате изходния код на '''вашите редакции''' на тази страница:",
	'virus-badscanner' => "Лоша конфигурация: непознат скенер за вируси: ''$1''",
	'virus-scanfailed' => 'сканирането не сполучи (код $1)',
	'virus-unknownscanner' => 'непознат антивирус:',
	'viewpagelogs' => 'Преглед на извършените административни действия по страницата',
	'viewprevnext' => 'Преглед ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Файлът не премина процедурата по верификация.',
	'viewdeletedpage' => 'Преглед на изтрити страници',
	'version' => 'Версия',
	'version-extensions' => 'Инсталирани разширения',
	'version-specialpages' => 'Специални страници',
	'version-parserhooks' => 'Куки в парсера',
	'version-variables' => 'Променливи',
	'version-antispam' => 'Предотвратяване на спам',
	'version-skins' => 'Облици',
	'version-other' => 'Други',
	'version-mediahandlers' => 'Обработчици на медия',
	'version-hooks' => 'Куки',
	'version-extension-functions' => 'Допълнителни функции',
	'version-parser-extensiontags' => 'Етикети от парсерни разширения',
	'version-parser-function-hooks' => 'Куки в парсерни функции',
	'version-hook-name' => 'Име на куката',
	'version-hook-subscribedby' => 'Ползвана от',
	'version-version' => '(Версия $1)',
	'version-license' => 'Лиценз',
	'version-poweredby-credits' => "Това уики се задвиждва от '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'други',
	'version-license-info' => 'MediaWiki е свободен софтуер, можете да го разпространявате и/или променяте съгласно условията на GNU General Public License, както е публикуван от Free Software Foundation, версия 2 на лиценза или (по ваше усмотрение) която и да е следваща версия.

MediaWiki се разпространява с надеждата, че ще бъде полезен, но БЕЗ НИКАКВИ ГАРАНЦИИ, без дори косвена гаранция за ПРОДАВАЕМОСТ или ПРИГОДНОСТ ЗА КОНКРЕТНА УПОТРЕБА. Вижте GNU General Public License за повече подробности.

Трябва да сте получили [{{SERVER}}{{SCRIPTPATH}}/COPYING копие на GNU General Public License] заедно с тази програма. Ако не сте, пишете на Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA или го [//www.gnu.org/licenses/old-licenses/gpl-2.0.html прочетете в мрежата].',
	'version-software' => 'Инсталиран софтуер',
	'version-software-product' => 'Продукт',
	'version-software-version' => 'Версия',
);

$messages['bho'] = array(
	'views' => 'विचारसूची',
	'view-pool-error' => 'क्षमा करीं, ई समय सर्वर पर बहुत ज्यादा लोड बढ़ गईल बा।
ई पन्ना के बहुते प्रयोगकर्ता लोग देखे के कोशिश कर रहल बानी।
ई पन्ना के फिर से देखे से पहिले कृपया कुछ देर तक इन्तजार करीं।

$1',
	'viewsourceold' => 'स्त्रोत देखीं',
	'viewsourcelink' => 'स्त्रोत देखीं',
	'viewdeleted' => '$1 देखब?',
	'viewsource' => 'स्त्रोत देखीं',
	'viewprevnext' => 'देखीं ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['bjn'] = array(
	'variants' => 'Macam',
	'view' => 'Tiringi',
	'viewdeleted_short' => 'Tiringi {{PLURAL:$1|asa babakan tahapus|$1 bababakan tahapus}}',
	'views' => 'Titiringan',
	'viewcount' => 'Tungkaran ini sudah diungkai {{PLURAL:$1|kali|$1 kali}}.',
	'view-pool-error' => 'Ampuni, server lagi limpuar kabaratan wayah ini.
Kabanyakan pamuruk nang handak maniringi tungkaran ini.
Muhun hadangi ha sapandang sabalum Pian cubai pulang maungkai tungkaran ini.

$1',
	'versionrequired' => 'Parlu MediaWiki mudil $1',
	'versionrequiredtext' => 'MediaWiki mudil $1 diparluakan hagan mamuruk tungkaran ini.
Lihati [[Special:Version|Tungkaran mudil]]',
	'viewsourceold' => 'tiringi asal mulanya',
	'viewsourcelink' => 'tiringi asal mulanya',
	'viewdeleted' => 'Tiringi $1?',
	'viewsource' => 'Tiringi asal mulanya',
	'viewsource-title' => 'Tiringi asalmula matan $1',
	'viewsourcetext' => 'Pian kawa maniringi wan manyalin asal mula tungkaran ini:',
	'viewyourtext' => "Pian kawa maniringi wan salain asalmula matan '''babakan pian''' ka tungkaran ngini:",
	'virus-badscanner' => "Konpigurasi buruk: pamindai virus kada dipinandui: ''$1''",
	'virus-scanfailed' => 'Pamindaian kada bakulihan (kudi $1)',
	'virus-unknownscanner' => 'Antivirus kada dipinandui:',
	'viewpagelogs' => 'Tiringi log tungkaran ini',
	'viewprevnext' => 'Tiringi ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Barakas nangini kada lulus paitihan.',
	'viewdeletedpage' => 'Tiringi tutungkaran tahapus',
	'version' => 'Virsi',
	'version-extensions' => 'Ekstensi tapasang',
	'version-specialpages' => 'Tungkaran istimiwa',
	'version-parserhooks' => 'Kait parser',
	'version-variables' => 'Pariabal',
	'version-antispam' => 'Pancagahan spam',
	'version-skins' => 'Kukulimbit',
	'version-other' => 'Lain-lain',
	'version-mediahandlers' => 'Pananganan madia',
	'version-hooks' => 'Kait',
	'version-extension-functions' => 'Pungsi ekstensi',
	'version-parser-extensiontags' => 'Tag ekstensi parser',
	'version-parser-function-hooks' => 'Kait pungsi parser',
	'version-hook-name' => 'Ngaran kait',
	'version-hook-subscribedby' => 'Dilanggani ulih',
	'version-version' => '(Pirsi $1)',
	'version-license' => 'Lisansi',
	'version-poweredby-credits' => "Wiki ngini disukung ulih '''[//www.mediawiki.org/ MediaWiki]''', hak salin © 2001-$1 $2.",
	'version-poweredby-others' => 'lainnya',
	'version-license-info' => 'MediaWiki adalah parangkat lunak bibas; Pian kawa manyabarakan wan/atawa maubahi ngini di bawah syarat Lisansi Publik Umum sawagai tarbitan ulih Free Software Foundation; apakah Lisansi virsi 2, atawa (pilihan Pian) tahanyar.

MediaWiki disabarakan awan harapan akan baguna, tagal KADA BAJAMINAN; kada jaminan PANIAGAAN atawa KATAPATAN HAGAN TUJUAN TARTANTU. Janaki Lisansi Publik Umum GNU gasan panjalasan rinci.

Pian saharusnya [{{SERVER}}{{SCRIPTPATH}}/COPYING sabuah salinan Lisansi Publik Umum GNU] baimbai awan prugram ngini; amun kada, tulis ka Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA atawa [//www.gnu.org/licenses/old-licenses/gpl-2.0.html baca ngini daring].',
	'version-software' => 'Parangkat lunak tapasang',
	'version-software-product' => 'Produk',
	'version-software-version' => 'Virsi',
);

$messages['bn'] = array(
	'variants' => 'বিকল্পসমূহ',
	'view' => 'দেখাও',
	'viewdeleted_short' => '{{PLURAL:$1| টি অপসারিত সম্পাদনা|$1 টি অপসারিত সম্পাদনা}} দেখাও',
	'views' => 'দৃষ্টিকোণ',
	'viewcount' => 'এ পাতাটি {{PLURAL:$1|বার|$1 বার}} দেখা হয়েছে।',
	'view-pool-error' => 'দুঃখিত, সার্ভারে এ মূহুর্তে অতিরিক্ত চাপ রয়েছে।
অনেক বেশি সংখ্যক ব্যবহারকারী এই পাতাটি দেখার চেষ্টা করছেন।
নতুন করে এ পাতাটি দেখার চেষ্টা করার আগে কিছুক্ষণ অপেক্ষা করুন।

$1',
	'versionrequired' => 'মিডিয়াউইকির $1 সংস্করণ প্রয়োজন',
	'versionrequiredtext' => 'এই পাতাটি ব্যবহার করার জন্য মিডিয়াউইকির $1 নং সংস্করণ প্রয়োজন। [[Special:Version|সংস্করণ পাতা]] দেখুন।',
	'viewsourceold' => 'উৎস দেখাও',
	'viewsourcelink' => 'উৎস দেখুন',
	'viewdeleted' => '$1 দেখানো হোক?',
	'viewsource' => 'উৎস দেখুন',
	'viewsource-title' => '$1 এর উৎস দেখুন',
	'viewsourcetext' => 'এ পাতাটি আপনি দেখতে এবং উৎসের অনুলিপি নিতে পারবেন:',
	'viewyourtext' => "আপনি ' ' ' আপনার সম্পাদনা ' ' ' এই পাতায় দেখতে এবং কপি করতে পারেন:",
	'virus-badscanner' => "ভুল কনফিগারেশন: অজ্ঞাত ভাইরাস স্কেনার: ''$1''",
	'virus-scanfailed' => 'স্ক্যান করা যাচ্ছে না (কোড $1)',
	'virus-unknownscanner' => 'অজানা এন্টিভাইরাস:',
	'viewpagelogs' => 'এই পাতার জন্য লগগুলো দেখুন',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) দেখানো হোক।',
	'viewdeletedpage' => 'মুছে ফেলা হয়েছে, এমন পাতাগুলো দেখুন',
	'version' => 'সংস্করণ',
	'version-extensions' => 'ইন্সটলকৃত এক্সটেনশনসমূহ',
	'version-specialpages' => 'বিশেষ পাতাসমূহ',
	'version-parserhooks' => 'পার্সার হুক',
	'version-variables' => 'চলক',
	'version-antispam' => 'স্প্যাম প্রতিরোধ',
	'version-skins' => 'আবরণসমূহ (Skin)',
	'version-other' => 'অন্য',
	'version-hooks' => 'হুক',
	'version-extension-functions' => 'এক্সটেনশনের কাজ',
	'version-parser-extensiontags' => 'পার্সার এক্সটেনশন ট্যাগ',
	'version-parser-function-hooks' => 'পার্সার ফাংশন হুক',
	'version-hook-name' => 'হুকের নাম',
	'version-hook-subscribedby' => 'সাবস্ক্রাইব করেছেন',
	'version-version' => '(সংস্করণ $1)',
	'version-license' => 'লাইসেন্স',
	'version-poweredby-credits' => "এইক উইকিটি পরিচালিত হচ্ছে '''[//www.mediawiki.org/ মিডিয়াউইকি]'''-এর মাধ্যমে, কপিরাইট © ২০০১-$1 $2।",
	'version-poweredby-others' => 'অন্যান্য',
	'version-software' => 'ইনস্টলকৃত সফটওয়্যার',
	'version-software-product' => 'পণ্য',
	'version-software-version' => 'সংস্করণ',
);

$messages['bo'] = array(
	'view' => 'ལྟ་བ།',
	'viewdeleted_short' => '{{བསུབས་པའི་རྩོམ་སྒྲིག PLURAL:$1|བསུབས་པའི་རྩོམ་སྒྲིག $1}}ལ་ལྟ་བ།',
	'views' => 'མཐོང་རིས།',
	'viewsourceold' => 'ཁོངས་ལ་ལྟ་བ།',
	'viewsourcelink' => 'ཁོངས་ལ་ལྟ་བ།',
	'viewdeleted' => ' $1 ལ་ལྟའམ།',
	'viewsource' => 'ཁོངས་ལ་ལྟ་བ།',
	'virus-unknownscanner' => 'ངོས་མ་ཟིན་པའི་དྲ་འབུ།',
	'viewpagelogs' => 'ཤོག་ངོས་འདིའི་ཉིན་ཐོ་ལ་ལྟ་བ།',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3)ལ་ལྟ་བ།',
);

$messages['bpy'] = array(
	'variants' => 'ভেরিয়েন্টহানি',
	'view' => 'চা',
	'viewdeleted_short' => '{{PLURAL:$1|হান সম্পাদনা পুসিসি|$1হান সম্পাদনা পুসিসি}} দেখাদে',
	'views' => 'চা',
	'viewcount' => 'পাতা এহান {{PLURAL:$1|মাউ|$1 মাউ}} চানা ইল।',
	'view-pool-error' => 'ঙাক্করবাং, সার্ভারগ এপাগা ওভারলোড অসে।
আবকচা চাকুরাই আকপাকে চেইতারা।
ডান্ড আহান বাসা পাতা এহান মেলানির কা।

$1',
	'versionrequired' => 'মিডিয়াউইকির $1 সংস্করণহান দরকার',
	'versionrequiredtext' => 'এরে পাতা এহান ব্যবহারর কা মিডিয়াউইকির $1 নং সংস্করণহান দরকার। [[Special:Version|সংস্করণ পাতা]] চা।',
	'viewsourceold' => 'উৎস চা',
	'viewsourcelink' => 'উৎস চা',
	'viewdeleted' => '$1 দেহাদে?',
	'viewsource' => 'উৎসহান চা',
	'viewsourcetext' => 'পাতা এহানর উত্স চা বারো কপি করে পারর:',
	'virus-badscanner' => "হবানেই হাজানিহান: হারনাপাসি ভাইরাসর সাকুকুরাহান: ''$1''",
	'virus-scanfailed' => 'স্ক্যান করানি নাইল (কোড $1)',
	'virus-unknownscanner' => 'হারনাপাসি এন্টিভাইরাস:',
	'viewpagelogs' => 'পাতাহানর লগ চা',
	'viewprevnext' => 'চা ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'সংস্করন',
	'version-specialpages' => 'বিশেষ পাতাহানি',
	'version-other' => 'হের',
	'version-hooks' => 'কসিগি',
	'version-version' => '(সংস্করণ $1)',
	'version-license' => 'লাইসেন্স',
	'version-software' => 'ইনস্টলঅসে সফটওয়্যার',
	'version-software-product' => 'পণ্য',
	'version-software-version' => 'সংস্করণ',
);

$messages['bqi'] = array(
	'views' => 'مشاهدات',
	'viewcount' => 'این صفحه قابل دسترسی شده است {{PLURAL:$1|once|$1 times}}.',
	'versionrequired' => 'یه نسخه زه نیازمندیهای ویکی مدیا
$1',
	'versionrequiredtext' => 'یه نسخه زه ویکی مدیا($1) نیازمند ه به استفاده زه ای صفحه
بوین :[[Special:Version|version page]].',
	'viewsourceold' => 'دیدن منبع',
	'viewdeleted' => 'دیدن$1?',
	'viewsource' => 'مشاهده منبع',
	'viewsourcetext' => 'ایسا ترین بوینین وکپی کنین منبع ای صفحه را:',
	'viewpagelogs' => 'نشودادن نمایه ها سی ای صفحه',
	'viewprevnext' => 'مشاهده ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'ترجمه یا تفسیر',
);

$messages['br'] = array(
	'variants' => 'Adstummoù',
	'view' => 'Gwelet',
	'viewdeleted_short' => "Gwelet {{PLURAL:$1|ur c'hemm diverket|$1 kemm diverket}}",
	'views' => 'Gweladennoù',
	'viewcount' => 'Sellet ez eus bet {{PLURAL:$1|$1 wezh|$1 gwezh}} ouzh ar bajenn-mañ.',
	'view-pool-error' => 'Ho tigarez, soulgarget eo ar servijerioù evit poent.
Re a implijerien a glask mont war ar bajenn-mañ war un dro.
Gortozit ur pennadig a-raok klask mont war ar bjann-mañ en-dro.

$1',
	'versionrequired' => 'Rekis eo Stumm $1 MediaWiki',
	'versionrequiredtext' => 'Rekis eo stumm $1 MediaWiki evit implijout ar bajenn-mañ. Sellit ouzh [[Special:Version]]',
	'viewsourceold' => 'gwelet ar vammenn',
	'viewsourcelink' => 'gwelet an tarzh',
	'viewdeleted' => 'Gwelet $1?',
	'viewsource' => 'Sellet ouzh tarzh an destenn',
	'viewsource-title' => 'Gwelet an tarzh evit $1',
	'viewsourcetext' => 'Gallout a rit gwelet hag eilañ danvez ar bajenn-mañ',
	'viewyourtext' => "Gallout a rit gwelet hag eilañ mammenn ho '''kemmoù''' d'ar bajenn-mañ :",
	'virus-badscanner' => "Kefluniadur fall : skanner viruzoù dianav : ''$1''",
	'virus-scanfailed' => "Skannadenn c'hwitet (kod $1)",
	'virus-unknownscanner' => 'diviruzer dianav :',
	'viewpagelogs' => 'Gwelet ar marilhoù evit ar bajenn-mañ',
	'viewprevnext' => 'Gwelet ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Korbellet eo bet ar restr-mañ gant ar gwiriañ restroù.',
	'viewdeletedpage' => 'Gwelet ar pajennoù diverket',
	'version' => 'Stumm',
	'version-extensions' => 'Astennoù staliet',
	'version-specialpages' => 'Pajennoù dibar',
	'version-parserhooks' => 'Galvoù dielfennañ',
	'version-variables' => 'Argemmennoù',
	'version-antispam' => 'Mirout ouzh ar strob',
	'version-skins' => 'Gwiskadurioù',
	'version-other' => 'Diseurt',
	'version-mediahandlers' => 'Merer danvez liesvedia',
	'version-hooks' => 'Galvoù',
	'version-extension-functions' => "Arc'hwelioù an astennoù",
	'version-parser-extensiontags' => 'Balizenn dielfennañ o tont eus an astennoù',
	'version-parser-function-hooks' => "Galv an arc'hwelioù dielfennañ",
	'version-hook-name' => 'Anv ar galv',
	'version-hook-subscribedby' => 'Termenet gant',
	'version-version' => '(Stumm $1)',
	'version-license' => 'Aotre-implijout',
	'version-poweredby-credits' => "Mont a ra ar wiki-mañ en-dro a-drugarez da '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 're all',
	'version-license-info' => "Ur meziant frank eo MediaWiki; gallout a rit skignañ anezhañ ha/pe kemmañ anezhañ dindan termenoù ar GNU Aotre-implijout Foran Hollek evel m'emañ embannet gant Diazezadur ar Meziantoù Frank; pe diouzh stumm 2 an aotre-implijout, pe (evel mar karit) ne vern pe stumm nevesoc'h.

Ingalet eo MediaWiki gant ar spi e vo talvoudus met n'eus TAMM GWARANT EBET; hep zoken gwarant empleg ar VARC'HADUSTED pe an AZASTER OUZH UR PAL BENNAK. Gwelet ar GNU Aotre-Implijout Foran Hollek evit muioc'h a ditouroù.

Sañset oc'h bezañ resevet [{{SERVER}}{{SCRIPTPATH}}/COPYING un eilskrid eus ar GNU Aotre-implijout Foran Hollek] a-gevret gant ar programm-mañ; ma n'hoc'h eus ket, skrivit da Diazezadur ar Meziantoù Frank/Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, SUA pe [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lennit anezhañ enlinenn].",
	'version-software' => 'Meziant staliet',
	'version-software-product' => 'Produ',
	'version-software-version' => 'Stumm',
);

$messages['brh'] = array(
	'variants' => 'Badaldroşumk',
	'views' => 'Nadára',
	'viewsourceold' => 'bumpad e ur',
	'viewsourcelink' => 'bumpad e ur',
	'viewsource' => 'Bumpad e ur',
	'viewpagelogs' => 'Dá panna ná hisáb áte ur',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) e ur',
);

$messages['bs'] = array(
	'variants' => 'Varijante',
	'view' => 'Pogled',
	'viewdeleted_short' => 'Pogledaj {{PLURAL:$1|jednu obrisanu izmjenu|$1 obrisane izmjene|$1 obrisanih izmjena}}',
	'views' => 'Pregledi',
	'viewcount' => 'Ovoj stranici je pristupljeno {{PLURAL:$1|$1 put|$1 puta}}.',
	'view-pool-error' => 'Žao nam je, serveri su trenutno preopterećeni.
Previše korisnika pokušava da pregleda ovu stranicu.
Molimo pričekajte trenutak prije nego što ponovno pokušate pristupiti ovoj stranici.

$1',
	'versionrequired' => 'Potrebna je verzija $1 MediaWikija',
	'versionrequiredtext' => 'Potrebna je verzija $1 MediaWikija da bi se koristila ova strana. Pogledaj [[Special:Version|verziju]].',
	'viewsourceold' => 'pogledaj izvor',
	'viewsourcelink' => 'pogledaj izvor',
	'viewdeleted' => 'Pogledaj $1?',
	'viewsource' => 'pogledaj kod',
	'viewsource-title' => 'Prikaz izvora stranice $1',
	'viewsourcetext' => 'Možete vidjeti i kopirati izvorni tekst ove stranice:',
	'viewyourtext' => "Možete da pogledate i kopirate izvor '''vaših izmjena''' na ovoj stranici:",
	'virus-badscanner' => "Loša konfiguracija: nepoznati anti-virus program: ''$1''",
	'virus-scanfailed' => 'skeniranje nije uspjelo (code $1)',
	'virus-unknownscanner' => 'nepoznati anti-virus program:',
	'viewpagelogs' => 'Pogledaj protokol ove stranice',
	'viewprevnext' => 'Pogledaj ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Ova datoteka nije prošla provjeru.',
	'viewdeletedpage' => 'Pogledaj izbrisane stranice',
	'version' => 'Verzija',
	'version-extensions' => 'Instalirana proširenja (ekstenzije)',
	'version-specialpages' => 'Posebne stranice',
	'version-parserhooks' => 'Kuke parsera',
	'version-variables' => 'Promjenjive',
	'version-antispam' => 'Sprječavanje spama',
	'version-skins' => 'Kože',
	'version-other' => 'Ostalo',
	'version-mediahandlers' => 'Upravljači medije',
	'version-hooks' => 'Kuke',
	'version-extension-functions' => 'Funkcije proširenja (ekstenzije)',
	'version-parser-extensiontags' => "Parser proširenja (''tagovi'')",
	'version-parser-function-hooks' => 'Kuke parserske funkcije',
	'version-hook-name' => 'Naziv kuke',
	'version-hook-subscribedby' => 'Pretplaćeno od',
	'version-version' => '(Verzija $1)',
	'version-license' => 'Licenca',
	'version-poweredby-credits' => "Ova wiki je zasnovana na '''[//www.mediawiki.org/ MediaWiki]''', autorska prava zadržana © 2001-$1 $2.",
	'version-poweredby-others' => 'ostali',
	'version-license-info' => 'Mediawiki je slobodni softver, možete ga redistribuirati i/ili mijenjati pod uslovima GNU opće javne licence kao što je objavljeno od strane Fondacije Slobodnog Softvera, bilo u verziji 2 licence, ili (po vašoj volji) nekoj od kasniji verzija.

Mediawiki se distriburia u nadi da će biti korisna, ali BEZ IKAKVIH GARANCIJA, čak i bez ikakvih posrednih garancija o KOMERCIJALNOSTI ili DOSTUPNOSTI ZA ODREĐENU SVRHU. Pogledajte GNU opću javnu licencu za više detalja.

Trebali biste dobiti [{{SERVER}}{{SCRIPTPATH}}/KOPIJU GNU opće javne licence] zajedno s ovim programom, ako niste, pišite Fondaciji Slobodnog Softvera na adresu  Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA ili je pročitajte [//www.gnu.org/licenses/old-licenses/gpl-2.0.html online].',
	'version-software' => 'Instalirani softver',
	'version-software-product' => 'Proizvod',
	'version-software-version' => 'Verzija',
);

$messages['bug'] = array(
	'viewsourceold' => 'ita sumber',
	'viewsourcelink' => 'ita sumber',
	'viewsource' => 'Ita sumber',
	'virus-unknownscanner' => "Antivirus dé' riisseŋ:",
	'viewprevnext' => 'Ita ($1 {{int:pipe-separator}} $2) ($3)',
	'version-specialpages' => 'Leppa spésiala',
);

$messages['ca'] = array(
	'variants' => 'Variants',
	'view' => 'Mostra',
	'viewdeleted_short' => 'Mostra {{PLURAL:$1|una edició eliminada|$1 edicions eliminades}}',
	'views' => 'Vistes',
	'viewcount' => 'Aquesta pàgina ha estat visitada {{PLURAL:$1|una vegada|$1 vegades}}.',
	'view-pool-error' => "Disculpeu, els servidors es troben sobrecarregats.
Massa usuaris estan tractant d'accedir a aquesta pàgina.
Per favor, esperau una mica abans de tornar a accedir a aquesta pàgina.

$1",
	'versionrequired' => 'Cal la versió $1 del MediaWiki',
	'versionrequiredtext' => 'Cal la versió $1 del MediaWiki per a utilitzar aquesta pàgina. Vegeu [[Special:Version]]',
	'viewsourceold' => 'mostra codi font',
	'viewsourcelink' => 'mostra codi font',
	'viewdeleted' => 'Voleu mostrar $1?',
	'viewsource' => 'Mostra la font',
	'viewsource-title' => 'Mostra la font per a $1',
	'viewsourcetext' => "Podeu visualitzar i copiar la font d'aquesta pàgina:",
	'viewyourtext' => "Vostè pot veure i copiar la font de ' ' les modificacions ' ' d'aquesta pàgina:",
	'virus-badscanner' => "Mala configuració: antivirus desconegut: ''$1''",
	'virus-scanfailed' => 'escaneig fallit (codi $1)',
	'virus-unknownscanner' => 'antivirus desconegut:',
	'viewpagelogs' => "Visualitza els registres d'aquesta pàgina",
	'viewprevnext' => 'Vés a ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Aquest fitxer no ha passat la verificació de fitxers.',
	'viewdeletedpage' => 'Visualitza les pàgines eliminades',
	'version' => 'Versió',
	'version-extensions' => 'Extensions instaŀlades',
	'version-specialpages' => 'Pàgines especials',
	'version-parserhooks' => "Extensions de l'analitzador",
	'version-variables' => 'Variables',
	'version-antispam' => 'Prevenció spam',
	'version-skins' => 'Aparences',
	'version-other' => 'Altres',
	'version-mediahandlers' => 'Connectors multimèdia',
	'version-hooks' => 'Lligams',
	'version-extension-functions' => "Funcions d'extensió",
	'version-parser-extensiontags' => "Etiquetes d'extensió de l'analitzador",
	'version-parser-function-hooks' => "Lligams funcionals de l'analitzador",
	'version-hook-name' => 'Nom del lligam',
	'version-hook-subscribedby' => 'Subscrit per',
	'version-version' => '(Versió $1)',
	'version-license' => 'Llicència',
	'version-poweredby-credits' => "El wiki funciona gràcies a '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'altres',
	'version-license-info' => "MediaWiki és programari lliure, podeu redistribuir-lo i/o modificar-lo sota els termes de la Llicència Pública General GNU publicada per la Free Software Foundation, ja sigui de la seva versió 2 o (a elecció vostra) qualsevol versió posterior.

MediaWiki es distribueix en l'esperança de ser d'utilitat, però SENSE CAP GARANTIA; ni tan sols la garantia implícita de COMERCIALITZACIÓ o ADEQUACIÓ A UNA FINALITAT DETERMINADA. En trobareu més detalls a  la Llicència Pública General GNU.

Amb aquest programa heu d'haver rebut [{{SERVER}}{{SCRIPTPATH}}/COPYING una còpia de la Llicència Pública General GNU]; si no és així, adreceu-vos a la Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA o bé [//www.gnu.org/licenses/old-licenses/gpl-2.0.html llegiu-la en línia].",
	'version-software' => 'Programari instaŀlat',
	'version-software-product' => 'Producte',
	'version-software-version' => 'Versió',
);

$messages['cbk-zam'] = array(
	'views' => 'Maga vista',
);

$messages['cdo'] = array(
	'viewdeleted' => 'Káng $1?',
	'viewsource' => 'Káng nguòng-dâi-mā',
	'viewsourcetext' => 'Nṳ̄ â̤-sāi káng gâe̤ng hók-cié ciā hiĕk gì nguòng-dâi-mā:',
	'viewpagelogs' => 'Káng cī miêng hiĕk gì nĭk-cé',
	'viewprevnext' => 'Káng ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Káng chēng lâi gì hiĕk',
);

$messages['ce'] = array(
	'variants' => 'Кепараш',
	'view' => 'Хьажа',
	'viewdeleted_short' => 'Хьажар {{PLURAL:$1|$1 дlадаьккхина нийсдар|$1 дlадаьхна нийсдарш|$1 дlадаьхна нийсдарш}}',
	'views' => 'Хьажарш',
	'viewcount' => 'Хlокху агlонга хьойсина $1 {{PLURAL:$1|за|за|за}}.',
	'view-pool-error' => 'Бехк цабиллар доьха, хlинц гlулкхдириг йоьттина йу.
Каьчна дуккха дехарш хlокху агlонтlе хьажарца.
Дехар до, собардеш а йуха хьажа хlокху агlонтlе жим тlаьхьо.

$1',
	'versionrequired' => 'Оьшу MediaWiki тайпанара $1',
	'versionrequiredtext' => 'Болх бан хlоку агlонца оьшу MediaWiki тайпан $1. Хьажа. [[Special:Version|лелочу тайпанара башхонах лаьцна хаам]].',
	'viewsourceold' => 'хьажа йолш йолучу ишаре',
	'viewsourcelink' => 'хьажа йолш йолучу ишаре',
	'viewdeleted' => 'Хьалххьожи $1?',
	'viewsource' => 'Хьажар',
	'viewsourcetext' => 'Хьоьга далундерг хьажар а дезахь хlокху агlон чура йоза хьаэцар:',
	'viewpagelogs' => 'Гайта хlокху агlонан тептар',
	'viewprevnext' => 'Хьажа ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'ДIайайина йолу агIонашка хьажар',
	'version' => 'Варси MediaWiki',
);

$messages['ceb'] = array(
	'variants' => 'Mga baryant',
	'views' => 'Mga pagtan-aw',
	'viewcount' => 'Naablihan na sa {{PLURAL:$1|maka-usa|$1 ka higayon}} ang kining panid.',
	'view-pool-error' => 'Pasensya, overloaded ang mga serber sa kasamtangan.
Sobra ka daghang gumagamit ang misulay og tan-aw niining panid.
Palihog paghulat bag-o nimo sulayan pag-akses og usab ang kining panid.

$1',
	'versionrequired' => 'Gikinahanglan ang Bersyong $1 sa MediaWiki',
	'versionrequiredtext' => 'Gikinahanglan ang Bersyong $1 sa MediaWiki aron magamit kining panid. Tan-awa ang [[Special:Version|panid sa bersyon]].',
	'viewsourceold' => 'tan-awa ang ginikanan',
	'viewsourcelink' => 'tan-awa ang ginikanan',
	'viewdeleted' => 'Ipakita ang $1?',
	'viewsource' => 'Tan-awa ang ginikanan',
	'viewsourcetext' => 'Puyde nimo tan-awon ug kopyahon ang ginikanan ning panid:',
	'virus-badscanner' => "Daot nga kompigurasyon: wala mailhing virus scanner: ''$1''",
	'virus-scanfailed' => 'scan failed (code $1)',
	'virus-unknownscanner' => 'wala mailhing antivirus:',
	'viewpagelogs' => 'Tan-awa ang mga log niining panid',
	'viewprevnext' => 'Tan-awa sa ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['ch'] = array(
	'views' => "Mali'e'-ña",
	'viewcount' => "Ma'usa este na påhina {{PLURAL:$1|un biahi|$1 na biahi}}.",
	'versionrequired' => 'Manesita i rebision $1 MediaWiki',
	'versionrequiredtext' => 'Manesita i rebision $1 MediaWiki para un usa i påhina. Taitai [[Special:Version|i påhinan rebision]].',
	'viewsourceold' => 'atan i code',
	'viewdeleted' => 'Atan $1?',
	'viewsource' => 'Atan i code',
	'viewsourcetext' => "Siña un li'e' yan kopia i code ni påhina:",
	'viewpagelogs' => 'Atan i historian påhina',
	'viewprevnext' => 'Atan i ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Tinilaika',
	'version-specialpages' => 'Manespesiat na påhina',
);

$messages['chr'] = array(
	'viewsource' => 'DᎢᎧᏃᏗᎢ DᎢᏓᎴᎲᏍᎬ',
);

$messages['ckb'] = array(
	'variants' => 'شێوەزارەکان',
	'views' => 'بینینەکان',
	'viewcount' => 'ئەم پەڕەیە {{PLURAL:$1|یەکجار|$1 جار}} بینراوە.',
	'view-pool-error' => 'ببورە، لەم کاتەدا ڕاژەکارەکان زیاباریان لە سەرە.<br />
ژمارەیەکی زۆر لە بەکارهێنەران هاوکات هەوڵی دیتنی ئەم لاپەرەیان داوە.<br />
تکایە پێش هەوڵی دووبارە بۆ دیتنی ئەم لاپەڕە، نەختێک بوەستە.<br /><br />

$1',
	'versionrequired' => 'وەشانی $1ی‌ میدیاویکی پێویستە',
	'versionrequiredtext' => 'پێویستیت بە وەشانی $1ی ویکیمیدیا ھەیە بۆ بەکاربردنی ئەم پەڕەیە.
تەماشای [[Special:Version|پەڕەی وەشان]] بکە.',
	'viewsourceold' => 'سەرچاوەکەی ببینە',
	'viewsourcelink' => 'سەرچاوەکەی ببینە',
	'viewdeleted' => '$1 نیشان بده‌؟',
	'viewsource' => 'سەرچاوەکەی ببینە',
	'viewsourcefor' => 'بۆ $1',
	'viewsourcetext' => 'تۆ دەتوانی سەرچاوەی ئەم لاپەڕە ببینی و کۆپی بکەی:',
	'virus-badscanner' => "پێکەربەندیی نابەجێ: ڤایرس سکەنێری نەناسراو: ''$1''",
	'virus-scanfailed' => 'سکەن ئەنجام نەدرا(کۆد $1)',
	'virus-unknownscanner' => 'دژەڤایرس نەناسراوە:',
	'viewpagelogs' => 'لۆگەکانی ئەم پەڕەیە ببینە',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) ببینە',
	'viewdeletedpage' => 'دیتنی لاپەڕە سڕاوەکان',
	'variantname-ku-arab' => 'ئەلفوبێی عەرەبی',
	'variantname-ku-latn' => 'ئەلفوبێی لاتینی',
	'version' => 'وەشان',
	'version-extensions' => 'پێوەکراوە دامەزراوەکان',
	'version-specialpages' => 'پەڕە تایبەتەکان',
	'version-parserhooks' => 'قولاپە لێککەرەکان',
	'version-variables' => 'گۆڕاوەکان',
	'version-other' => 'ھی دیکە',
	'version-mediahandlers' => 'بایەخ‌دەرانی مێدیا',
	'version-hooks' => 'قولاپەکان',
	'version-extension-functions' => 'فەنکشێنەکانی درێژەکراو',
	'version-parser-extensiontags' => 'تاگەکانی درێژکراوی لێککەرەوە',
	'version-parser-function-hooks' => 'قولاپەکانی فەنکشێنی لێککەرەوە',
	'version-skin-extension-functions' => 'فەنکشێنەکانی درێژکراوی ڕووبەرگ',
	'version-hook-name' => 'ناوی قولاپ',
	'version-hook-subscribedby' => 'بەشداربوو لە لایەن',
	'version-version' => '(وەشانی $1)',
	'version-license' => 'مۆڵەت',
	'version-software' => 'نەرمەکاڵای دامەزراو',
	'version-software-product' => 'بەرهەم',
	'version-software-version' => 'وەشان',
);

$messages['co'] = array(
	'versionrequired' => 'A version $1 di MediaWiki hè necessaria',
	'viewdeletedpage' => 'Fighjulà e p agine supprimate',
	'version' => 'Versione',
);

$messages['cps'] = array(
	'variants' => 'Mga pililian',
	'view' => 'Llantawon',
	'viewdeleted_short' => 'Tan-awon ang {{PLURAL:$1|isa ka ginpanas nga pagbag-o|$1 ka mga ginpanas nga pagbag-o}}',
	'views' => 'Mga dagway',
	'viewcount' => 'Nasudlan ang mini nga pahina sang {{PLURAL:$1|isa|$1}} ka beses.',
	'view-pool-error' => 'Pasesnya, nasobrahan ka karga ang mga server yanda.
Sobra kadamo nga mga manug-usar ang gusto makita ang mini nga pahina.
Palihog maghulat sang madali gid lang antes mo tistingan nga sudlan liwat ang mini nga pahina.

$1',
	'versionrequired' => 'Kinanglan ang $1 nga bersyon sang MediaWiki',
	'versionrequiredtext' => 'Kinahanglan ang $1 nga bersyon sang MediaWiki para magamit ang mini nga pahina.
Tan-awon ang [[Special:Version|pahina sang bersyon]].',
	'viewsourceold' => 'lantawon ang ginhalinan',
	'viewsourcelink' => 'tan-awon ang ginhalinan',
	'viewdeleted' => 'Tan-awon ang $1?',
	'viewsource' => 'Tan-awon ang ginhalinan',
	'viewsource-title' => 'Tan-awon ang ginhalinan para sa $1',
	'viewsourcetext' => 'Pwede mo makita kag makopya ang ginhalinan sang mini nga pahina:',
	'virus-badscanner' => "Sala nga konpigurasyon: wala nakilal-an nga manugsala sang virus: ''$1''",
	'virus-scanfailed' => 'palpak ang pagscan (code $1)',
	'virus-unknownscanner' => 'wala makilal-an nga pangontra-bayrus:',
	'viewpagelogs' => 'Tan-awon ang mga paglista para sa mini nga pahina',
	'viewprevnext' => 'Tan-awon ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['crh'] = array(
	'variants' => 'Mga pililian',
	'view' => 'Llantawon',
	'viewdeleted_short' => 'Tan-awon ang {{PLURAL:$1|isa ka ginpanas nga pagbag-o|$1 ka mga ginpanas nga pagbag-o}}',
	'views' => 'Mga dagway',
	'viewcount' => 'Nasudlan ang mini nga pahina sang {{PLURAL:$1|isa|$1}} ka beses.',
	'view-pool-error' => 'Pasesnya, nasobrahan ka karga ang mga server yanda.
Sobra kadamo nga mga manug-usar ang gusto makita ang mini nga pahina.
Palihog maghulat sang madali gid lang antes mo tistingan nga sudlan liwat ang mini nga pahina.

$1',
	'versionrequired' => 'Kinanglan ang $1 nga bersyon sang MediaWiki',
	'versionrequiredtext' => 'Kinahanglan ang $1 nga bersyon sang MediaWiki para magamit ang mini nga pahina.
Tan-awon ang [[Special:Version|pahina sang bersyon]].',
	'viewsourceold' => 'lantawon ang ginhalinan',
	'viewsourcelink' => 'tan-awon ang ginhalinan',
	'viewdeleted' => 'Tan-awon ang $1?',
	'viewsource' => 'Tan-awon ang ginhalinan',
	'viewsource-title' => 'Tan-awon ang ginhalinan para sa $1',
	'viewsourcetext' => 'Pwede mo makita kag makopya ang ginhalinan sang mini nga pahina:',
	'virus-badscanner' => "Sala nga konpigurasyon: wala nakilal-an nga manugsala sang virus: ''$1''",
	'virus-scanfailed' => 'palpak ang pagscan (code $1)',
	'virus-unknownscanner' => 'wala makilal-an nga pangontra-bayrus:',
	'viewpagelogs' => 'Tan-awon ang mga paglista para sa mini nga pahina',
	'viewprevnext' => 'Tan-awon ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['crh-cyrl'] = array(
	'variants' => 'Вариантлар',
	'viewdeleted_short' => '{{PLURAL:$1|бир ёкъ этильген денъишмени|$1 ёкъ этильген денъишмени}} косьтер.',
	'views' => 'Корюнишлер',
	'viewcount' => 'Бу саифе {{PLURAL:$1|1|$1}} дефа иришильген.',
	'view-pool-error' => 'Афу этинъиз, сервер шимди адден-ашыр юкленди. Пек чокъ къулланыджы бу саифени ачмагъа тырыша. Лютфен, бу саифени бир даа ачмакътан эвель бираз бекленъиз.

$1',
	'versionrequired' => 'MediaWiki-нинъ $1 версиясы керек',
	'versionrequiredtext' => 'Бу саифени къулланмакъ ичюн MediaWiki-нинъ $1 версиясы керек. [[Special:Version|Версия]] саифесине бакъ.',
	'viewsourceold' => 'менба кодуны косьтер',
	'viewsourcelink' => 'менба кодуны косьтер',
	'viewdeleted' => '$1 корь?',
	'viewsource' => 'менба кодуны косьтер',
	'viewsource-title' => '$1 саифесининъ менба коду',
	'viewsourcetext' => 'Саифенинъ кодуны козьден кечирип копиялай билесинъиз:',
	'virus-badscanner' => "Янълыш сазлама. Билинмеген вирус сканери: ''$1''",
	'virus-scanfailed' => 'скан этюв мувафакъиетсиз (код $1)',
	'virus-unknownscanner' => 'билинмеген антивирус:',
	'viewpagelogs' => 'Бу саифенинъ журналларыны косьтер',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Ёкъ этильген саифелерге бакъ',
	'video-dims' => '$1, $2 × $3',
	'version' => 'Версия',
);

$messages['crh-latn'] = array(
	'variants' => 'Variantlar',
	'view' => 'Köster',
	'viewdeleted_short' => '{{PLURAL:$1|bir yoq etilgen deñişmeni|$1 yoq etilgen deñişmeni}} köster.',
	'views' => 'Körünişler',
	'viewcount' => 'Bu saife {{PLURAL:$1|1|$1}} defa irişilgen.',
	'view-pool-error' => 'Afu etiñiz, server şimdi adden-aşır yüklendi. Pek çoq qullanıcı bu saifeni açmağa tırışa. Lütfen, bu saifeni bir daa açmaqtan evel biraz bekleñiz.

$1',
	'versionrequired' => 'MediaWikiniñ $1 versiyası kerek',
	'versionrequiredtext' => 'Bu saifeni qullanmaq içün MediaWikiniñ $1 versiyası kerek. [[Special:Version|Versiya]] saifesine baq.',
	'viewsourceold' => 'menba kоdunı köster',
	'viewsourcelink' => 'menba kоdunı köster',
	'viewdeleted' => '$1 kör?',
	'viewsource' => 'menba kodunı köster',
	'viewsource-title' => '$1 saifesiniñ menba kodu',
	'viewsourcetext' => 'Saifeniñ kodunı közden keçirip kopiyalay bilesiñiz:',
	'virus-badscanner' => "Yañlış sazlama. Bilinmegen virus skaneri: ''$1''",
	'virus-scanfailed' => 'skan etüv muvafaqiyetsiz (kod $1)',
	'virus-unknownscanner' => 'bilinmegen antivirus:',
	'viewpagelogs' => 'Bu saifeniñ jurnallarını köster',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Yoq etilgen saifelerge baq',
	'video-dims' => '$1, $2 × $3',
	'version' => 'Versiya',
);

$messages['cs'] = array(
	'variants' => 'Varianty',
	'view' => 'Zobrazit',
	'viewdeleted_short' => 'Zobrazit {{PLURAL:$1|smazanou editaci|$1 smazané editace|$1 smazaných editací}}',
	'views' => 'Zobrazení',
	'viewcount' => 'Stránka byla zobrazena {{PLURAL:$1|jedenkrát|$1krát|$1krát}}.',
	'view-pool-error' => 'Promiňte, servery jsou momentálně přetíženy.
Tuto stránku si právě prohlíží příliš mnoho uživatelů.
Před tím, než ji zkusíte načíst znovu, chvíli počkejte.

$1',
	'versionrequired' => 'Vyžadováno MediaWiki verze $1',
	'versionrequiredtext' => 'Pro použití této stránky je vyžadováno MediaWiki verze $1. Vizte [[Special:Version|stránku verze]].',
	'viewsourceold' => 'zobrazit zdroj',
	'viewsourcelink' => 'ukázat zdroj',
	'viewdeleted' => 'Zobrazit $1?',
	'viewsource' => 'Zobrazit zdroj',
	'viewsource-title' => 'Zobrazení zdroje stránky $1',
	'viewsourcetext' => 'Můžete si prohlédnout a zkopírovat zdrojový kód této stránky:',
	'viewyourtext' => "Můžete si prohlédnout a zkopírovat zdrojový kód '''vašich změn''' této stránky:",
	'virus-badscanner' => "Špatná konfigurace: neznámý antivirový program: ''$1''",
	'virus-scanfailed' => 'prověřování selhalo (kód $1)',
	'virus-unknownscanner' => 'neznámý antivirus:',
	'viewpagelogs' => 'Zobrazit protokolovací záznamy k této stránce',
	'viewprevnext' => 'Ukázat ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Soubor nevyhověl při ověřování.',
	'viewdeletedpage' => 'Zobrazení smazané stránky',
	'version' => 'Verze',
	'version-extensions' => 'Nainstalovaná rozšíření',
	'version-specialpages' => 'Speciální stránky',
	'version-parserhooks' => 'Přípojné body parseru',
	'version-variables' => 'Proměnné',
	'version-antispam' => 'Ochrana proti spamu',
	'version-skins' => 'Vzhledy',
	'version-other' => 'Jiné',
	'version-mediahandlers' => 'Obsluha médií',
	'version-hooks' => 'Přípojné body',
	'version-extension-functions' => 'Rozšiřující funkce',
	'version-parser-extensiontags' => 'Přidané syntaktické značky',
	'version-parser-function-hooks' => 'Funkce parseru',
	'version-hook-name' => 'Název přípojného bodu',
	'version-hook-subscribedby' => 'Volán z',
	'version-version' => '(Verze $1)',
	'version-license' => 'Licence',
	'version-poweredby-credits' => "Tato wiki běží na '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'další',
	'version-license-info' => 'MediaWiki je svobodný software; můžete jej šířit nebo modifikovat podle podmínek GNU General Public License, vydávané Free Software Foundation; buď verze 2 této licence anebo (podle vašeho uvážení) kterékoli pozdější verze.

MediaWiki je distribuována v naději, že bude užitečná, avšak BEZ JAKÉKOLI ZÁRUKY; neposkytují se ani odvozené záruky PRODEJNOSTI anebo VHODNOSTI PRO URČITÝ ÚČEL. Podrobnosti se dočtete v textu GNU General Public License.

[{{SERVER}}{{SCRIPTPATH}}/COPYING Kopii GNU General Public License] jste měli obdržet spolu s tímto programem, pokud ne, napište na Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA nebo [//www.gnu.org/licenses/old-licenses/gpl-2.0.html si ji přečtěte online].',
	'version-software' => 'Nainstalovaný software',
	'version-software-product' => 'Název',
	'version-software-version' => 'Verze',
	'version-entrypoints' => 'URL vstupních bodů',
	'version-entrypoints-header-entrypoint' => 'Vstupní bod',
	'version-entrypoints-header-url' => 'URL',
);

$messages['csb'] = array(
	'variants' => 'Wariantë',
	'views' => 'Pòdzérków',
	'viewcount' => 'Na starna je òbzéranô ju {{PLURAL:$1|jeden rôz|$1 razy}}',
	'versionrequired' => 'Wëmôgónô wersëjô $1 MediaWiki',
	'versionrequiredtext' => 'Bë brëkòwac ną starnã wëmôgónô je wersëjô $1 MediaWiki. Òbaczë starnã [[Special:Version]]',
	'viewsourceold' => 'wëskrzëni zdrój',
	'viewsourcelink' => 'wëskrzëni zdrój',
	'viewdeleted' => 'Òbaczë $1',
	'viewsource' => 'Zdrojowi tekst',
	'viewpagelogs' => 'Òbôczë rejestrë dzéjanió dlô ti starnë',
	'viewprevnext' => 'Òbaczë ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Òbaczë rëmóne starnë',
	'version' => 'Wersëjô',
);

$messages['cu'] = array(
	'viewsourceold' => 'страницѧ источьнъ обраꙁъ',
	'viewsourcelink' => 'страницѧ источьнъ обраꙁъ',
	'viewdeleted' => '$1 видєти хощєши ;',
	'viewsource' => 'страницѧ источьнъ обраꙁъ',
	'viewpagelogs' => 'си страницѧ їсторїѩ',
	'viewprevnext' => 'виждь ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'MediaWiki обраꙁъ',
	'version-version' => '(обраꙁъ $1)',
	'version-license' => 'прощєниѥ',
	'version-software-version' => 'обраꙁъ',
);

$messages['cv'] = array(
	'views' => 'Пурĕ пăхнă',
	'viewcount' => 'Ку страницăна $1 хут пăхнă.',
	'versionrequired' => 'MediaWiki-н $1 версийĕ кирлĕ',
	'versionrequiredtext' => 'Ку страницăпа ĕслемешкĕн сире MediaWiki-н $1 версийĕ кирлĕ. [[Special:Version|Усă куракан программăсен версийĕсем çинчен пĕлтерекен информацине]] пăх.',
	'viewsourceold' => 'пуçламăш текста пăх',
	'viewdeleted' => '$1 пăхар-и?',
	'viewsource' => 'Курăм',
	'viewsourcetext' => 'Эсир ку страницăн малтанхи текстне пăхма тата копилеме пултаратăр:',
	'virus-badscanner' => "Ĕнерлев йăнăшĕ. Вирус сканерĕ паллă мар: ''$1''",
	'virus-scanfailed' => 'скенерланă чухнехи йăнăш (код $1)',
	'virus-unknownscanner' => 'паллă мар антивирус:',
	'viewpagelogs' => 'Ку страницăн журналĕсене пăхасси',
	'viewdeletedpage' => 'Кăларса пăрахнă страницăсене пăх',
	'version' => 'MediaWiki версийĕ',
);

$messages['cy'] = array(
	'variants' => 'Amrywiolion',
	'view' => 'Darllen',
	'viewdeleted_short' => "Edrych ar y {{PLURAL:$1|golygiad sydd wedi'i ddileu|golygiad sydd wedi'i ddileu|$1 olygiad sydd wedi'u dileu|$1 golygiad sydd wedi'u dileu|$1 golygiad sydd wedi'u dileu|$1 golygiad sydd wedi'u dileu}}",
	'views' => 'Golygon',
	'viewcount' => "{{PLURAL:$1|Ni chafwyd dim|Cafwyd $1|Cafwyd $1|Cafwyd $1|Cafwyd $1|Cafwyd $1}} ymweliad â'r dudalen hon.",
	'view-pool-error' => 'Ymddiheurwn, mae gormod o waith gan y gweinyddion ar hyn o bryd.
Mae gormod o ddefnyddwyr am weld y dudalen hon ar unwaith.
Arhoswch ychydig cyn ceisio mynd at y dudalen hon eto.

$1',
	'versionrequired' => 'Mae angen fersiwn $1 y meddalwedd MediaWiki',
	'versionrequiredtext' => "Mae angen fersiwn $1 y meddalwedd MediaWiki er mwyn gwneud defnydd o'r dudalen hon. Gweler y dudalen am y [[Special:Version|fersiwn]].",
	'viewsourceold' => 'dangos y tarddiad',
	'viewsourcelink' => 'dangos côd y dudalen',
	'viewdeleted' => 'Gweld $1?',
	'viewsource' => 'Dangos côd y dudalen',
	'viewsource-title' => 'Gweld cod y dudalen $1',
	'viewsourcetext' => 'Cewch weld a chopïo côd y dudalen:',
	'viewyourtext' => "Cewch weld a copïo ffynhonnell ''eich golygiadau'' i'r dudalen hon:",
	'virus-badscanner' => "Cyfluniad gwael: sganiwr firysau anhysbys: ''$1''",
	'virus-scanfailed' => 'methodd y sgan (côd $1)',
	'virus-unknownscanner' => 'gwrthfirysydd anhysbys:',
	'viewpagelogs' => "Dangos logiau'r dudalen hon",
	'viewprevnext' => 'Dangos ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => "Nid yw'r ffeil hon wedi ei derbyn wrth ei gwirio.",
	'viewdeletedpage' => 'Gweld tudalennau sydd dileedig',
	'version' => 'Fersiwn',
	'version-extensions' => 'Estyniadau gosodedig',
	'version-specialpages' => 'Tudalennau arbennig',
	'version-parserhooks' => 'Bachau dosrannydd',
	'version-variables' => 'Newidynnau',
	'version-antispam' => 'Atal sbam',
	'version-skins' => 'Gweddau',
	'version-other' => 'Arall',
	'version-mediahandlers' => 'Trinyddion cyfryngau',
	'version-hooks' => 'Bachau',
	'version-extension-functions' => 'Ffwythiannau estyn',
	'version-parser-extensiontags' => 'Tagiau estyn dosrannydd',
	'version-parser-function-hooks' => 'Bachau ffwythiant dosrannu',
	'version-hook-name' => "Enw'r bachyn",
	'version-hook-subscribedby' => 'Tanysgrifwyd gan',
	'version-version' => '(Fersiwn $1)',
	'version-license' => 'Trwydded',
	'version-poweredby-credits' => "Mae'r wici hwn wedi'i nerthu gan '''[//www.mediawiki.org/ MediaWiki]''', hawlfraint © 2001 - $1 $2.",
	'version-poweredby-others' => 'eraill',
	'version-license-info' => "Meddalwedd rhydd yw MediaWiki; gallwch ei ddefnyddio a'i addasu yn ôl termau'r GNU General Public License a gyhoeddir gan Free Software Foundation; naill ai fersiwn 2 o'r Drwydded, neu unrhyw fersiwn diweddarach o'ch dewis.

Cyhoeddir MediaWiki yn y gobaith y bydd o ddefnydd, ond HEB UNRHYW WARANT; heb hyd yn oed gwarant ymhlyg o FARCHNADWYEDD nag o FOD YN ADDAS AT RYW BWRPAS ARBENNIG. Gweler y GNU General Public License am fanylion pellach.

Dylech fod wedi derbyn [{{SERVER}}{{SCRIPTPATH}}/COPYING gopi o GNU General Public License] gyda'r rhaglen hon; os nad ydych, ysgrifennwch at Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA, neu [//www.gnu.org/licenses/old-licenses/gpl-2.0.html gallwch ei ddarllen ar y we].",
	'version-software' => 'Meddalwedd gosodedig',
	'version-software-product' => 'Cynnyrch',
	'version-software-version' => 'Fersiwn',
);

$messages['da'] = array(
	'variants' => 'Varianter',
	'view' => 'Vis',
	'viewdeleted_short' => 'Vis {{PLURAL:$1|en slettet redigering|$1 slettede redigeringer}}',
	'views' => 'Visninger',
	'viewcount' => 'Siden er vist i alt $1 {{PLURAL:$1|gang|gange}}.',
	'view-pool-error' => 'Beklager, men serverne er i øjeblikket overbelastede.
For mange brugere prøver at vise denne side.
Vent et øjeblik, før du prøver at vise denne side ige.

$1',
	'versionrequired' => 'Kræver version $1 af MediaWiki',
	'versionrequiredtext' => 'Version $1 af MediaWiki er påkrævet, for at bruge denne side. Se [[Special:Version|Versionssiden]]',
	'viewsourceold' => 'vis kildekode',
	'viewsourcelink' => 'vis kildetekst',
	'viewdeleted' => 'Vis $1?',
	'viewsource' => 'Vis kildetekst',
	'viewsource-title' => 'Se kildekoden til $1',
	'viewsourcetext' => 'Du kan se og kopiere kildekoden til siden:',
	'viewyourtext' => "Du kan se og kopiere kildekoden for '''dine redigeringer''' til denne side:",
	'virus-badscanner' => "Konfigurationsfejl: ukendt virus-scanner: ''$1''",
	'virus-scanfailed' => 'virus-scan fejlede med fejlkode $1',
	'virus-unknownscanner' => 'ukendt virus-scanner:',
	'viewpagelogs' => 'Vis loglister for denne side',
	'viewprevnext' => 'Vis ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Denne fil bestod ikke fil verifikationen.',
	'viewdeletedpage' => 'Vis slettede sider',
	'version' => 'Version',
	'version-extensions' => 'Installerede udvidelser',
	'version-specialpages' => 'Specialsider',
	'version-parserhooks' => 'Oversætter-funktioner',
	'version-variables' => 'Variabler',
	'version-antispam' => 'Spamforebyggelse',
	'version-skins' => 'Udseender',
	'version-other' => 'Andet',
	'version-mediahandlers' => 'Specialhåndtering af mediefiler',
	'version-hooks' => 'Funktionstilføjelser',
	'version-extension-functions' => 'Udvidelsesfunktioner',
	'version-parser-extensiontags' => 'Tilføjede tags',
	'version-parser-function-hooks' => 'Oversætter-funktioner',
	'version-hook-name' => 'Navn',
	'version-hook-subscribedby' => 'Brugt af',
	'version-version' => '(Version $1)',
	'version-license' => 'Licens',
	'version-poweredby-credits' => "Denne wiki er drevet af '''[//www.mediawiki.org/ MediaWiki ]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'andre',
	'version-license-info' => 'MediaWiki er gratis software; du kan redistribuere det og/eller ændre det under betingelserne i GNU General Public License som offentliggjort af Free Software Foundation; enten version 2 af licensen eller (efter eget valg) enhver senere version.

MediaWiki distribueres i håb om at det vil være nyttigt, men UDEN NOGEN GARANTI; uden selv de underforståede garantier SALGBARHED eller EGNETHED TIL ET BESTEMT FORMÅL. Se GNU General Public License for yderligere detaljer.

Du skulle have modtaget [{{SERVER}}{{SCRIPTPATH}}/COPYING en kopi af GNU General Public License] sammen med dette program; og hvis ikke, så skriv til Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA or [//www.gnu.org/licenses/old-licenses/gpl-2.0.html læs den online].',
	'version-software' => 'Installeret software',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Version',
);

$messages['de'] = array(
	'variants' => 'Varianten',
	'view' => 'Lesen',
	'viewdeleted_short' => '{{PLURAL:$1|Eine gelöschte Version|$1 gelöschte Versionen}} ansehen',
	'views' => 'Ansichten',
	'viewcount' => 'Diese Seite wurde bisher {{PLURAL:$1|einmal|$1-mal}} abgerufen.',
	'view-pool-error' => 'Entschuldigung, die Server sind im Moment überlastet.
Zu viele Benutzer versuchen, diese Seite zu besuchen.
Bitte warte einige Minuten, bevor du es noch einmal versuchst.

$1',
	'versionrequired' => 'Version $1 von MediaWiki ist erforderlich.',
	'versionrequiredtext' => 'Version $1 von MediaWiki ist erforderlich, um diese Seite zu nutzen.
Siehe die [[Special:Version|Versionsseite]]',
	'viewsourceold' => 'Quelltext anzeigen',
	'viewsourcelink' => 'Quelltext anzeigen',
	'viewdeleted' => '$1 anzeigen?',
	'viewsource' => 'Quelltext anzeigen',
	'viewsource-title' => 'Quelltext von Seite $1 ansehen',
	'viewsourcetext' => 'Du kannst den Quelltext dieser Seite betrachten und kopieren:',
	'viewyourtext' => "Du kannst den Quelltext '''deiner Bearbeitung''' dieser Seite betrachten und kopieren:",
	'virus-badscanner' => "Fehlerhafte Konfiguration: unbekannter Virenscanner: ''$1''",
	'virus-scanfailed' => 'Scan fehlgeschlagen (code $1)',
	'virus-unknownscanner' => 'Unbekannter Virenscanner:',
	'viewpagelogs' => 'Logbücher dieser Seite anzeigen',
	'viewprevnext' => 'Zeige ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Diese Datei hat die Dateiprüfung nicht bestanden.',
	'viewdeletedpage' => 'Gelöschte Seiten anzeigen',
	'version' => 'Version',
	'version-extensions' => 'Installierte Erweiterungen',
	'version-specialpages' => 'Erweiterungen mit Spezialseiten',
	'version-parserhooks' => 'Parsererweiterungen',
	'version-variables' => 'Erweiterungen mit Variablen',
	'version-antispam' => 'Spamschutzerweiterungen',
	'version-skins' => 'Benutzeroberflächen',
	'version-other' => 'Andere Erweiterungen',
	'version-mediahandlers' => 'Mediennutzungserweiterungen',
	'version-hooks' => "Schnittstellen ''(Hooks)''",
	'version-extension-functions' => 'Funktionsaufrufe',
	'version-parser-extensiontags' => "Parsererweiterungen ''(Tags)''",
	'version-parser-function-hooks' => "Parsererweiterungen ''(Funktionen)''",
	'version-hook-name' => 'Schnittstellenname',
	'version-hook-subscribedby' => 'Aufruf von',
	'version-version' => '(Version $1)',
	'version-svn-revision' => '(Version $2)',
	'version-license' => 'Lizenz',
	'version-poweredby-credits' => "Diese Website nutzt '''[//www.mediawiki.org/wiki/MediaWiki/de MediaWiki]''', Copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'andere',
	'version-license-info' => "MediaWiki ist eine Freie Software, d. h. sie kann, gemäß den Bedingungen der von der Free Software Foundation veröffentlichten ''GNU General Public License'', weiterverteilt und/ oder modifiziert werden. Dabei kann die Version 2, oder nach eigenem Ermessen, jede neuere Version der Lizenz verwendet werden.

Die Software MediaWiki wird in der Hoffnung verteilt, dass sie nützlich sein wird, allerdings OHNE JEGLICHE GARANTIE und sogar ohne die implizierte Garantie einer MARKTGÄNGIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK. Hierzu sind weitere Hinweise in der ''GNU General Public License'' enthalten.

Eine [{{SERVER}}{{SCRIPTPATH}}/COPYING Kopie der ''GNU General Public License''] sollte zusammen mit diesem Programm verteilt worden sein. Sofern dies nicht der Fall war, kann eine Kopie bei der Free Software Foundation Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA, schriftlich angefordert oder auf deren Website [//www.gnu.org/licenses/old-licenses/gpl-2.0.html online gelesen] werden.",
	'version-software' => 'Installierte Software',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Version',
	'vertical-tv' => 'TV',
	'vertical-games' => 'Videospiele',
	'vertical-books' => 'Literatur',
	'vertical-comics' => 'Comics',
	'vertical-lifestyle' => 'Lifestyle',
	'vertical-movies' => 'Filme',
);

$messages['de-ch'] = array(
	'version-license-info' => "MediaWiki ist freie Software, d. h. sie kann, gemäss den Bedingungen der von der Free Software Foundation veröffentlichten ''GNU General Public License'', weiterverteilt und/ oder modifiziert werden. Dabei kann die Version 2, oder nach eigenem Ermessen, jede neuere Version der Lizenz verwendet werden.

MediaWiki wird in der Hoffnung verteilt, dass es nützlich sein wird, allerdings OHNE JEGLICHE GARANTIE und sogar ohne die implizierte Garantie einer MARKTGÄNGIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK. Hierzu sind weitere Hinweise in der ''GNU General Public License'' enthalten.

Eine [{{SERVER}}{{SCRIPTPATH}}/COPYING Kopie der ''GNU General Public License''] sollte zusammen mit diesem Programm verteilt worden sein. Sofern dies nicht der Fall war, kann eine Kopie bei der Free Software Foundation Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA, schriftlich angefordert oder auf deren Website [//www.gnu.org/licenses/old-licenses/gpl-2.0.html online gelesen] werden.",
);

$messages['de-formal'] = array(
	'view-pool-error' => 'Entschuldigung, die Server sind im Moment überlastet.
Zu viele Benutzer versuchen diese Seite zu besuchen.
Bitte warten Sie einige Minuten, bevor Sie es noch einmal versuchen.

$1',
	'viewsourcetext' => 'Sie können den Quelltext dieser Seite betrachten und kopieren:',
);

$messages['de-weigsbrag'] = array(
	'views' => 'Ansigdes',
	'viewcount' => 'Dose Seid haddar bis jedsd {{PLURAL:$1|einesmal|$1-mal}} abruw.',
	'versionrequired' => 'Braugdar Wersion $1 won dose MediaWigi',
	'versionrequiredtext' => 'Braugdar Wersion $1 won dose MediaWigi das gön nuds dose Seid. Seddar dose [[{{#special:version}}|Wersionsseid]]',
	'viewsourceold' => 'Gueldegsd seig',
	'viewdeleted' => '$1 anseig?',
	'viewsource' => 'Gueldegsd anschauddar',
	'viewsourcefor' => 'wür $1',
	'viewsourcetext' => 'Gueldegsd won dose Seid:',
	'virus-badscanner' => 'Wehlhawdes Gonwigurär: noggsbegandes Wirussgän: <i>$1</i>',
	'virus-scanfailed' => 'Sgän daneb geddar (god $1)',
	'virus-unknownscanner' => 'Noggsbegandes Wirussgän:',
	'viewpagelogs' => 'Logbüges wür dose Seid anseig',
	'viewprevnext' => 'Seig ($1) ($2) ($3)',
	'viewdeletedpage' => 'Gelöschdes Seides anseig',
	'version' => 'Wersion',
	'version-extensions' => 'Insdalärdes Erweides',
	'version-specialpages' => 'Schbesialseides',
	'version-parserhooks' => 'Barser-Huugs',
	'version-variables' => 'Wariables',
	'version-other' => 'Anderes',
	'version-mediahandlers' => 'Medies-Händ',
	'version-hooks' => "Schnidschdeles ''(Huugs)''",
	'version-extension-functions' => 'Wungsionsauwruwes',
	'version-parser-extensiontags' => "Barser-Erweides ''(dägs)''",
	'version-parser-function-hooks' => 'Barser-Wungsiones',
	'version-skin-extension-functions' => 'Sgin-Erweid-Wungsiones',
	'version-hook-name' => 'Schnidschdelesnam',
	'version-hook-subscribedby' => 'Auwruw won',
	'version-version' => 'Wersion',
	'version-license' => 'Lisens',
	'version-software' => 'Insdalärdes Sowdwär',
	'version-software-product' => 'Brodugd',
	'version-software-version' => 'Wersion',
);

$messages['diq'] = array(
	'variants' => 'Varyanti',
	'view' => 'Bıvêne',
	'viewdeleted_short' => '{{PLURAL:$1|Yew vurnayışo esterıte|$1 Vurnayışanê esterıtan}} bımocne',
	'views' => 'Asayışi',
	'viewcount' => 'Ena pele {{PLURAL:$1|rae|$1 rey}} vêniya.',
	'view-pool-error' => 'Qaytê qısuri mekerên, serverê ma enıka zêde bar gırewto xo ser.
Hedê xo ra zêde karberi kenê ke seyrê na pele bıkerê.
Şıma rê zehmet, tenê vınderên, heta ke reyna kenê ke ena pele kewê.

$1',
	'versionrequired' => 'No $1 MediaWiki lazımo',
	'versionrequiredtext' => 'Seba gurenayışê na pele versiyonê MediaWiki $1 lazımo.
[[Special:Version|Versiyonê pele]] bıvêne.',
	'viewsourceold' => 'çımey bıvêne',
	'viewsourcelink' => 'çımey bıvêne',
	'viewdeleted' => '$1 bıvêne?',
	'viewsource' => 'Çımey bıvêne',
	'viewsourcetext' => 'To şikinay çımey na pele bıvêne u kopya kerê:',
	'virus-badscanner' => "Eyaro şaş: no virus-cıgerayox nêzanyeno: ''$1''",
	'virus-scanfailed' => 'cıgerayiş tamam nêbı (kod $1)',
	'virus-unknownscanner' => 'antiviruso ke nêzanyeno:',
	'viewpagelogs' => 'Qe ena pele logan bevinin',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) bıvênên',
	'verification-error' => 'Ena dosya taramayê dosyayi temam nikena.',
	'viewdeletedpage' => 'bıewn pelê hewn a şiyayeyani',
	'version' => 'Versiyon',
	'version-extensions' => 'Ekstensiyonî ke ronaye',
	'version-specialpages' => 'Pelanê xasiyan',
	'version-parserhooks' => 'Çengelê Parserî',
	'version-variables' => 'Vurnayeyî',
	'version-skins' => 'Cıldi',
	'version-other' => 'Bin',
	'version-mediahandlers' => 'Kulbê medyayî',
	'version-hooks' => 'Çengelî',
	'version-extension-functions' => 'Funksiyonê ekstensiyonî',
	'version-parser-extensiontags' => 'Etiketê ekstensiyon ê parserî',
	'version-parser-function-hooks' => 'Çengelê ekstensiyon ê parserî',
	'version-hook-name' => 'Nameyê çengelî',
	'version-hook-subscribedby' => 'Eza biyayoğ',
	'version-version' => '(Versiyon $1)',
	'version-license' => 'Lisans',
	'version-software' => 'Softwareyê ronayi',
	'version-software-product' => 'Mal',
	'version-software-version' => 'Versiyon',
);

$messages['dsb'] = array(
	'variants' => 'Warianty',
	'view' => 'Woglědaś se',
	'viewdeleted_short' => '{{PLURAL:$1|jadnu wulašowanu změnu|$1 wulašowanej změnje|$1 wulašowane změny|$1 wulašowanych změnow}} se woglědaś',
	'views' => 'Naglědy',
	'viewcount' => 'Toś ten bok jo był woglědany {{PLURAL:$1|jaden raz|$1 raza|$1 raze}}.',
	'view-pool-error' => 'Wódaj, serwery su we wokognuśu pśeśěžone.
Pśewjele wužywarjow wopytujo se toś ten bok woglědaś.
Pšosym pócakaj chylu, nježli až wopytujoš znowego na toś ten bok pśistup měś.

$1',
	'versionrequired' => 'Wersija $1 softwary MediaWiki trěbna',
	'versionrequiredtext' => 'Wersija $1 softwary MediaWiki jo trěbna, aby toś ten bok se mógał wužywaś. Glědaj [[Special:Version|Wersijowy bok]]',
	'viewsourceold' => 'glědaś žrědło',
	'viewsourcelink' => 'Žrědło zwobrazniś',
	'viewdeleted' => '$1 pokazaś?',
	'viewsource' => 'Žrědło se wobglědaś',
	'viewsource-title' => 'Žrědłowy tekst za $1 se woglědaś',
	'viewsourcetext' => 'Žrědłowy tekst togo boka móžoš se woglědaś a kopěrowaś:',
	'viewyourtext' => "Móžoš se žrědłowy tekst '''swójich změnow''' woglědaś a do toś togo bok kopěrowaś:",
	'virus-badscanner' => "Špatna konfiguracija: njeznaty wirusowy scanner: ''$1''",
	'virus-scanfailed' => 'Scannowanje jo se njeraźiło (kod $1)',
	'virus-unknownscanner' => 'njeznaty antiwirus:',
	'viewpagelogs' => 'Protokole boka pokazaś',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) pokazaś',
	'verification-error' => 'Toś ta dataja njejo pśejšeła datajowe pśeglědanje.',
	'viewdeletedpage' => 'Wulašowane boki pokazaś',
	'version' => 'Wersija',
	'version-extensions' => 'Instalowane rozšyrjenja',
	'version-specialpages' => 'Specialne boki',
	'version-parserhooks' => 'Parserowe kokule',
	'version-variables' => 'Wariable',
	'version-antispam' => 'Šćit pśeśiwo spamoju',
	'version-skins' => 'Suknje',
	'version-other' => 'Druge',
	'version-mediahandlers' => 'Pśeźěłaki medijow',
	'version-hooks' => 'Kokule',
	'version-extension-functions' => 'Funkcije rozšyrjenjow',
	'version-parser-extensiontags' => 'Tagi parserowych rozšyrjenjow',
	'version-parser-function-hooks' => 'Parserowe funkcije',
	'version-hook-name' => 'Mě kokule',
	'version-hook-subscribedby' => 'Aboněrowany wót',
	'version-version' => '(Wersija $1)',
	'version-license' => 'Licenca',
	'version-poweredby-credits' => "Toś ten wiki spěchujo se wót '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'druge',
	'version-license-info' => 'MediaWiki jo licha softwara: móžoš ju pód wuměnjenjami licence GNU General Public License, wózjawjeneje wót załožby Free Software Foundation, rozdźěliś a/abo změniś: pak pód wersiju 2 licence pak pód někakeju pózdźejšeju wersiju.

MediaWiki rozdźěla se w naźeji, až buźo wužitny, ale BŹEZ GARANTIJE: samo bźez wopśimjoneje garantije PŚEDAWAJOBNOSĆI abo PŚIGÓDNOSĆI ZA WĚSTY ZAMĚR. Glědaj GNU general Public License za dalšne drobnostki.

Ty by dejał [{{SERVER}}{{SCRIPTPATH}}/COPYING kopiju licence GNU General Public License] gromaźe z toś tym programom dostanu měś: jolic nic, napiš do załožby Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA abo [//www.gnu.org/licenses/old-licenses/gpl-2.0.html pśecytaj ju online].',
	'version-software' => 'Instalěrowana software',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Wersija',
	'version-entrypoints' => 'URL zastupneho dypka',
	'version-entrypoints-header-entrypoint' => 'Zastupny dypk',
	'version-entrypoints-header-url' => 'URL',
);

$messages['dtp'] = array(
	'variants' => 'Kopogisuaian',
	'view' => 'Intaai',
	'viewdeleted_short' => 'Intaai {{PLURAL:$1|iso niditan pinugas|$1 niniditan pinugas}}',
	'views' => 'Pongintangan',
	'viewcount' => 'Nawayaan bolikan diti do {{PLURAL:$1|insan|in-$1}}.',
	'view-pool-error' => 'Siou tu nakalabai tomod ilo kompiuto mamamalayan.
Adalaan togumu momomoguno do mingumbal mongintong diti bolikon.
Andadon po do toruhai pogulu do mangapil sumuang id bolikon diti.

$1',
	'versionrequired' => 'Momoguno do borsi $1 ModiaWiki',
	'versionrequiredtext' => 'Dinolinan $1 do ModiaWiki pokionuon do mongoguno diti bolikon.
Intaai [[Special:Version|bolikon dinolinan]].',
	'viewsourceold' => 'intaai wowonod',
	'viewsourcelink' => 'intaai wowonod',
	'viewdeleted' => 'Intaai $1?',
	'viewsource' => 'Intaai wowonod',
	'viewsourcetext' => 'Pasagaon ko do mongintong om mangadalin wowonod diti bolikon:',
	'virus-badscanner' => "Araat kinooturon: Awu otutunan pongkowili giuk: ''$1''",
	'virus-scanfailed' => 'nolibai pongkowili (code $1)',
	'virus-unknownscanner' => 'tantobgiuk awu otutunan:',
	'viewpagelogs' => 'Intaai tongolog do bolikon diti',
	'viewprevnext' => 'Intaai ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['dv'] = array(
	'views' => 'ހިޔާލުފުޅުތައް',
	'viewsource' => 'މަސްދަރު ބައްލަވާ',
	'viewprevnext' => 'ބައްލަވާ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'ފޮހެލެވިފައިވާ ޞަފްޙާތައް ބައްލަވާ',
	'version' => 'ނުސްހާ ނަމްބަރު',
);

$messages['dz'] = array(
	'views' => 'མཐོང་སྣང་།',
	'viewsource' => 'འབྱུང་ས་སྟོན།',
	'viewsourcetext' => 'ཁྱོད་ཀྱིས་ ཤོག་ལེབ་འདི་གི་འབྱུང་ས་བལྟ་བཏུབ་པའི་ཁར་ འདྲ་བཤུས་ཡང་རྐྱབ་བཏུབ་ཨིན་:',
	'viewpagelogs' => 'ཤོག་ལེབ་འདི་གི་ལོགསི་སྟོན།',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) སྟོན།',
	'version' => 'ཐོན་རིམ།',
);

$messages['ee'] = array(
	'viewcount' => 'Wokpɔ axa sia zi {{PLURAL:$1|ɖeka|$1 sɔ̃}}.',
	'viewsourceold' => 'kpɔ alesi wó ŋlɔe',
	'viewsourcelink' => 'kpɔ alesi woŋlɔe',
	'viewdeleted' => 'Wòa kpɔ $1 a?',
	'viewsource' => 'Kpɔ alesi wowɔe',
	'viewprevnext' => 'Kpɔ ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Kpɔ axawo si wotutu',
	'version' => 'Tata',
);

$messages['el'] = array(
	'variants' => 'Παραλλαγές',
	'view' => 'Προβολή',
	'viewdeleted_short' => 'Δείτε {{PLURAL:$1|μια διαγεγραμμένη επεξεργασίαt|$1 διαγεγραμμένων επεξεργασιών}}',
	'views' => 'Εμφανίσεις',
	'viewcount' => 'Αυτή η σελίδα έχει προσπελαστεί {{PLURAL:$1|μια φορά|$1 φορές}}.',
	'view-pool-error' => 'Λυπούμαστε, οι εξυπηρετητές είναι υπερφορτωμένοι αυτή τη στιγμή.
Πάρα πολλοί χρήστες προσπαθούν να εμφανίσουν αυτή τη σελίδα.
Παρακαλούμε περιμένετε λίγο πριν ξαναπροσπαθήσετε να μπείτε σε αυτή τη σελίδα.

$1',
	'versionrequired' => 'Απαιτείται η έκδοση $1 του MediaWiki.',
	'versionrequiredtext' => 'Για να χρησιμοποιήσετε αυτή τη σελίδα απαιτείται η έκδοση $1 του MediaWiki . Βλ. [[Special:Έκδοση]]',
	'viewsourceold' => 'εμφάνιση κώδικα',
	'viewsourcelink' => 'εμφάνιση κώδικα',
	'viewdeleted' => 'Δείτε το $1;',
	'viewsource' => 'Εμφάνιση κώδικα',
	'viewsource-title' => 'Προβολή πηγής για $1',
	'viewsourcetext' => 'Μπορείτε να δείτε και να αντιγράψετε τον κώδικα αυτής της σελίδας:',
	'viewyourtext' => "Μπορείτε να προβάλετε και να αντιγράψετε τον κώδικα των '''επεξεργασιών σας''' σε αυτήν τη σελίδα:",
	'virus-badscanner' => "Λάθος ρύθμιση: άγνωστος ανιχνευτής ιών: ''$1''",
	'virus-scanfailed' => 'Η σάρωση απέτυχε (κώδικας $1)',
	'virus-unknownscanner' => 'άγνωστο αντιικό:',
	'viewpagelogs' => 'Δείτε τα αρχεία καταγραφών για αυτή τη σελίδα',
	'viewprevnext' => 'Εμφάνιση ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Αυτό το αρχείο δεν πέρασε τον έλεγχο επαλήθευσης.',
	'viewdeletedpage' => 'Εμφάνιση διεγραμμένων σελίδων',
	'version' => 'Έκδοση',
	'version-extensions' => 'Εγκαταστημένες επεκτάσεις',
	'version-specialpages' => 'Ειδικές σελίδες',
	'version-parserhooks' => 'Άγκιστρα του συντακτικού αναλυτή',
	'version-variables' => 'Παράμετροι',
	'version-antispam' => 'Πρόληψη spam',
	'version-skins' => 'Προσόψεις',
	'version-other' => 'Άλλα',
	'version-mediahandlers' => 'Χειριστές των μέσων',
	'version-hooks' => 'Άγκιστρα',
	'version-extension-functions' => 'Συναρτήσεις επεκτάσεων',
	'version-parser-extensiontags' => 'Ετικέτες επεκτάσεων του συντακτικού αναλυτή',
	'version-parser-function-hooks' => 'Άγκιστρα συναρτήσεων του συντακτικού αναλυτή',
	'version-hook-name' => 'Όνομα άγκιστρου',
	'version-hook-subscribedby' => 'Υπογεγραμμένο από',
	'version-version' => '(Έκδοση $1)',
	'version-license' => 'Άδεια χρήσης',
	'version-poweredby-credits' => "Αυτό το βίκι τροφοδοτείται από '''[//www.mediawiki.org/ MediaWiki]''', πνευματική ιδιοκτησία © 2001-$1 $2.",
	'version-poweredby-others' => 'άλλοι',
	'version-license-info' => "To Το MediaWiki είναι ελεύθερο λογισμικό. Μπορείτε να το αναδιανέμετε ή / και να το τροποποιήσετε υπό τους όρους της GNU General Public License όπως αυτή εκδόθηκε από το Free Software Foundation.Είτε η δεύτερη έκδοση της άδειας, είτε (κατ' επιλογή σας) οποιδήποτε επόμενη έκδοση.
Ο
Το MediaWiki διανέμεται με την ελπίδα ότι θα είναι χρήσιμο, αλλά ΧΩΡΙΣ ΚΑΜΙΑ ΕΓΓΥΗΣΗ.Ούτε καν την σιωπηρή εγγύση της  ΕΜΠΟΡΕΥΣΙΜΟΤΗΤΑΣ ή της ΚΑΤΑΛΛΗΛΟΤΗΤΑΣ ΓΙΑ ΕΝΑ PARTICULAR ΣΚΟΠΟ.Όπως δείτε την GNU General Public License για περισσότερες λεπτομέρειες.

 Θα πρέπει να έχετε λάβει [((SERVER)) ((SCRIPTPATH)) / COPYING ένα αντίγραφο της GNU General Public License] μαζί με αυτό το πρόγραμμα.Αν όχι, γράψτε προς το Free Software Foundation, Inc, 51 Franklin Street, πέμπτο όροφο , Boston, MA 02110-1301, USA ή [//www.gnu.org/licenses/old-licenses/gpl-2.0.html διαβάστε το online].",
	'version-software' => 'Εγκατεστημένο λογισμικό',
	'version-software-product' => 'Προϊόν',
	'version-software-version' => 'Έκδοση',
);

$messages['en-ca'] = array(
	'version-license' => 'Licence',
	'version-license-info' => 'MediaWiki is free software; you can redistribute it and/or modify it under the terms of the GNU General Public Licence as published by the Free Software Foundation; either version 2 of the Licence, or (at your option) any later version.

MediaWiki is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public Licence for more details.

You should have received [{{SERVER}}{{SCRIPTPATH}}/COPYING a copy of the GNU General Public Licence] along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA or [http://www.gnu.org/licenses/old-licenses/gpl-2.0.html read it online].',
);

$messages['en-gb'] = array(
	'version-license-info' => 'MediaWiki is free software; you can redistribute it and/or modify it under the terms of the GNU General Public Licence as published by the Free Software Foundation; either version 2 of the Licence, or (at your option) any later version.

MediaWiki is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public Licence for more details.

You should have received [{{SERVER}}{{SCRIPTPATH}}/COPYING a copy of the GNU General Public Licence] along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA or [//www.gnu.org/licenses/old-licenses/gpl-2.0.html read it online].',
);

$messages['en-rtl'] = array(
	'version-license-info' => 'MediaWiki is free software; you can redistribute it and/or modify it under the terms of the GNU General Public Licence as published by the Free Software Foundation; either version 2 of the Licence, or (at your option) any later version.

MediaWiki is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public Licence for more details.

You should have received [{{SERVER}}{{SCRIPTPATH}}/COPYING a copy of the GNU General Public Licence] along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA or [//www.gnu.org/licenses/old-licenses/gpl-2.0.html read it online].',
);

$messages['eo'] = array(
	'variants' => 'Variantoj',
	'view' => 'Vidi',
	'viewdeleted_short' => 'Vidi {{PLURAL:$1|unu forigitan redakton|$1 forigitajn redaktojn}}',
	'views' => 'Vidoj',
	'viewcount' => 'Montrita {{PLURAL:$1|unufoje|$1 fojojn}}.',
	'view-pool-error' => 'Bedaŭrinde la serviloj estas tro uzata ĉi-momente.
Tro da uzantoj provas vidi ĉi tiun paĝon.
Bonvolu atendi iom antaŭ vi provas atingi ĝin denove.

$1',
	'versionrequired' => 'Versio $1 de MediaWiki nepras',
	'versionrequiredtext' => 'La versio $1 de MediaWiki estas necesa por uzi ĉi tiun paĝon. Vidu [[Special:Version|paĝon pri versio]].',
	'viewsourceold' => 'vidi fonttekston',
	'viewsourcelink' => 'vidi fontkodon',
	'viewdeleted' => 'Ĉu rigardi $1?',
	'viewsource' => 'Rigardi vikitekston',
	'viewsource-title' => 'Vidi fonton por $1',
	'viewsourcetext' => 'Vi povas rigardi kaj kopii la fonton de la paĝo:',
	'viewyourtext' => "Vi povas vidi kaj kopii la fonton de '''viaj redaktoj''' al ĉi tiu paĝo:",
	'virus-badscanner' => "Malbona konfiguro: nekonata virusa skanilo: ''$1''",
	'virus-scanfailed' => 'skano malsukcesis (kun kodo $1)',
	'virus-unknownscanner' => 'nekonata kontraŭviruso:',
	'viewpagelogs' => 'Rigardi la protokolojn por tiu ĉi paĝo',
	'viewprevnext' => 'Montri ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Ĉi tiu dosiero ne pasis dosieran konfirmon.',
	'viewdeletedpage' => 'Rigardi forigitajn paĝojn',
	'version' => 'Versio',
	'version-extensions' => 'Instalitaj kromprogramoj',
	'version-specialpages' => 'Specialaj paĝoj',
	'version-parserhooks' => 'Sintaksaj hokoj',
	'version-variables' => 'Variabloj',
	'version-antispam' => 'Kontraŭspamilo',
	'version-skins' => 'Etosoj',
	'version-other' => 'Alia',
	'version-mediahandlers' => 'Mediaj traktiloj',
	'version-hooks' => 'Hokoj',
	'version-extension-functions' => 'Kromprogramaj funkcioj',
	'version-parser-extensiontags' => 'Sintaksaj etend-etikedoj',
	'version-parser-function-hooks' => 'Hokoj de sintaksaj funkcioj',
	'version-hook-name' => 'Nomo de hoko',
	'version-hook-subscribedby' => 'Abonita de',
	'version-version' => '(Versio $1)',
	'version-license' => 'Permesilo',
	'version-poweredby-credits' => "Ĉi tiu vikio funkcias per '''[//www.mediawiki.org/ MediaWiki]''', aŭtorrajto ©&thinsp;2001–$1 $2.",
	'version-poweredby-others' => 'aliaj',
	'version-license-info' => 'MediaWiki estas libera programaro. Vi povas redistribui ĝin kaj/aŭ modifi ĝin sub la kondiĉoj de la GNU General Public Licens (GNU Ĝenerala Publika Permesilo) en ties eldono de la Free Software Foundation (Libera Softvara Fondaĵo) - aŭ versio 2 de la Permesilo, aŭ (laŭ via elekto) iu ajn posta versio.

Tiun ĉi verkon ni distribuas esperante, ke ĝi utilos, sed SEN IA AJN GARANTIO; eĉ sen la implica garantio de SURMERKATIGEBLECO aŭ TAŬGECO POR IA DIFINITA CELO. Vidu GNU General Public License por pliaj detaloj.

Oni devis doni al vi [{{SERVER}}{{SCRIPTPATH}}/COPYING ekzempleron de la GNU General Public License] kune kun tiu ĉi programo; se ne, skribu al Free Software Foundation, Inc., 59 Temple Place, Suite 350, Boston, MA 02111-1307 USA aŭ [//www.gnu.org/licenses/old-licenses/gpl-2.0.html legu ĝin interrete].',
	'version-software' => 'Instalita programaro',
	'version-software-product' => 'Produkto',
	'version-software-version' => 'Versio',
);

$messages['es'] = array(
	'variants' => 'Variantes',
	'view' => 'Ver',
	'viewdeleted_short' => 'Ver {{PLURAL:$1|una edición borrada|$1 ediciones borradas}}',
	'views' => 'Vistas',
	'viewcount' => 'Esta página ha sido visitada {{PLURAL:$1|una vez|$1 veces}}.',
	'view-pool-error' => 'Lo sentimos, los servidores están sobrecargados en este momento.
Hay demasiados usuarios que están tratando de ver esta página.
Espera un momento antes de tratar de acceder nuevamente a esta página.

$1',
	'versionrequired' => 'La versión $1 de MediaWiki es necesaria para utilizar esta página',
	'versionrequiredtext' => 'Se necesita la versión $1 de MediaWiki para utilizar esta página. Para más información, consultar [[Special:Version|la página de versión]]',
	'viewsourceold' => 'ver código fuente',
	'viewsourcelink' => 'ver fuente',
	'viewdeleted' => '¿Deseas ver $1?',
	'viewsource' => 'Ver fuente',
	'viewsource-title' => 'Ver el código fuente de «$1»',
	'viewsourcetext' => 'Puedes ver y copiar el código fuente de esta página:',
	'viewyourtext' => "Puedes ver y copiar el código de '''tus ediciones''' a esta página:",
	'virus-badscanner' => "Error de configuración: Antivirus desconocido: ''$1''",
	'virus-scanfailed' => 'Escaneo fallido (código $1)',
	'virus-unknownscanner' => 'antivirus desconocido:',
	'viewpagelogs' => 'Ver los registros de esta página',
	'viewprevnext' => 'Ver ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Este archivo no pasó la verificación de archivos.',
	'viewdeletedpage' => 'Ver páginas borradas',
	'version' => 'Versión',
	'version-extensions' => 'Extensiones instaladas',
	'version-specialpages' => 'Páginas especiales',
	'version-parserhooks' => 'Extensiones del analizador sintáctico',
	'version-variables' => 'Variables',
	'version-antispam' => 'Prevención de spam',
	'version-skins' => 'Pieles',
	'version-other' => 'Otro',
	'version-mediahandlers' => 'Manejadores multimedia',
	'version-hooks' => 'Extensiones',
	'version-extension-functions' => 'Funciones de extensiones',
	'version-parser-extensiontags' => 'Etiquetas de extensiones sintácticas',
	'version-parser-function-hooks' => 'Extensiones de funciones sintácticas',
	'version-hook-name' => 'Nombre de la extensión',
	'version-hook-subscribedby' => 'Suscrito por',
	'version-version' => '(Versión $1)',
	'version-license' => 'Licencia',
	'version-poweredby-credits' => "Este wiki funciona gracias a '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'otros',
	'version-license-info' => 'MediaWiki es software libre; puedes redistribuírlo y/o modificarlo bajo los términos de la Licencia General Pública GNU publicada por la Fundación del Software Libre; ya sea la versión 2 de la licencia, o (a tu elección) cualquier versión posterior.

MediaWiki es distribuído con la esperanza de que será útil, pero SIN NINGUNA GARANTÍA; ni siquiera con la garantía implícita de COMERCIALIZACIÓN ó ADAPTACIÓN A UN PROPÓSITO PARTICULAR. Véase la Licencia Pública General GNU para mayores detalles.

Has recibido [{{SERVER}}{{SCRIPTPATH}}/COPYING una copia de la Licencia Pública General GNU] junto a este programa; si no es así, escríbale a la Fundación del Software Libre, Inc., Calle Franklin 51, Quinto Piso, Boston, MA 02110-1301, EE.UU. ó [//www.gnu.org/licenses/old-licenses/gpl-2.0.html léela en línea].',
	'version-software' => 'Software instalado',
	'version-software-product' => 'Producto',
	'version-software-version' => 'Versión',
	'vertical-tv' => 'TV',
	'vertical-games' => 'Juegos',
	'vertical-books' => 'Libros',
	'vertical-comics' => 'Cómics',
	'vertical-lifestyle' => 'Estilo de vida',
	'vertical-music' => 'Música',
	'vertical-movies' => 'Películas',
);

$messages['et'] = array(
	'variants' => 'Variandid',
	'view' => 'Vaata',
	'viewdeleted_short' => 'Vaata {{PLURAL:$1|üht|$1}} kustutatud redaktsiooni',
	'views' => 'vaatamisi',
	'viewcount' => 'Seda lehekülge on külastatud {{PLURAL:$1|üks kord|$1 korda}}.',
	'view-pool-error' => 'Serverid on hetkel üle koormatud.
Liiga palju kasutajaid üritab seda lehte vaadata.
Palun oota hetk, enne kui uuesti proovid.

$1',
	'versionrequired' => 'Nõutav MediaWiki versioon $1',
	'versionrequiredtext' => 'Selle lehe kasutamiseks on nõutav MediaWiki versioon $1.
Vaata [[Special:Version|versiooni lehekülge]].',
	'viewsourceold' => 'vaata lähteteksti',
	'viewsourcelink' => 'vaata lähteteksti',
	'viewdeleted' => 'Vaata $1?',
	'viewsource' => 'Vaata lähteteksti',
	'viewsource-title' => 'Lehekülje $1 lähteteksti vaatamine',
	'viewsourcetext' => 'Saad vaadata ja kopeerida lehekülje lähteteksti:',
	'viewyourtext' => "Saad vaadata ja kopeerida sellel leheküljel tehtud '''enda muudatuste '''lähteteksti:",
	'virus-badscanner' => "Viga konfiguratsioonis: tundmatu viirusetõrje: ''$1''",
	'virus-scanfailed' => 'skaneerimine ebaõnnestus (veakood $1)',
	'virus-unknownscanner' => 'tundmatu viirusetõrje:',
	'viewpagelogs' => 'Vaata selle lehe logisid',
	'viewprevnext' => 'Näita ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'See fail ei läbinud failikontrolli.',
	'viewdeletedpage' => 'Kustutatud lehekülgede vaatamine',
	'version' => 'Versioon',
	'version-extensions' => 'Paigaldatud lisad',
	'version-specialpages' => 'Erileheküljed',
	'version-parserhooks' => 'Süntaksianalüsaatori lisad (Parser hooks)',
	'version-variables' => 'Muutujad',
	'version-antispam' => 'Rämpsposti tõkestus',
	'version-skins' => 'Kujundused',
	'version-other' => 'Muu',
	'version-mediahandlers' => 'Meediatöötlejad',
	'version-hooks' => 'Redaktsioon',
	'version-extension-functions' => 'Lisafunktsioonid',
	'version-parser-extensiontags' => 'Parseri lisamärgendid',
	'version-parser-function-hooks' => 'Parserifunktsioonid',
	'version-hook-name' => 'Redaktsiooni nimi',
	'version-hook-subscribedby' => 'Tellijad',
	'version-version' => '(Versioon $1)',
	'version-license' => 'Litsents',
	'version-poweredby-credits' => "See viki kasutab '''[//www.mediawiki.org/ MediaWiki]''' tarkvara. Autoriõigus © 2001–$1 $2.",
	'version-poweredby-others' => 'teised',
	'version-license-info' => "MediaWiki on vaba tarkvara; tohid seda taaslevitada ja/või selle põhjal teisendeid luua vastavalt Vaba Tarkvara Fondi avaldatud GNU Üldise Avaliku Litsentsi versioonis 2 või hilisemas seatud tingimustele.

MediaWiki tarkvara levitatakse lootuses, et see on kasulik, aga '''igasuguse tagatiseta''', ka kaudse tagatiseta teose '''turustatavuse''' või '''müügikõlblikkuse''' kohta. Üksikasjad leiad GNU Üldisest Avalikust Litsentsist.

GNU Üldise Avaliku Litsentsi [{{SERVER}}{{SCRIPTPATH}}/COPYING eksemplar] peaks selle programmiga kaasas olema; kui pole, kirjuta aadressil Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA või [//www.gnu.org/licenses/old-licenses/gpl-2.0.html loe seda võrgust].",
	'version-software' => 'Paigaldatud tarkvara',
	'version-software-product' => 'Toode',
	'version-software-version' => 'Versioon',
	'version-entrypoints' => 'Sisendpunktide internetiaadressid',
	'version-entrypoints-header-entrypoint' => 'Sisendpunkt',
	'version-entrypoints-header-url' => 'URL',
);

$messages['eu'] = array(
	'variants' => 'Aldaerak',
	'view' => 'Ikusi',
	'viewdeleted_short' => 'Ikusi ezabatutako {{PLURAL:$1|bidalketa bat|$1 bidalketa}}',
	'views' => 'Ikustaldiak',
	'viewcount' => 'Orrialde hau {{PLURAL:$1|behin|$1 aldiz}} bisitatu da.',
	'view-pool-error' => 'Barkatu, zerbitzariak gainezka daude uneotan.
Erabiltzaile gehiegi ari da orrialde hau ikusi nahiean.
Mesedez itxaron ezazu unetxo bat orrialde honetara berriz sartzen saiatu baino lehen.

$1',
	'versionrequired' => 'MediaWikiren $1 bertsioa beharrezkoa da',
	'versionrequiredtext' => 'MediaWikiren $1 bertsioa beharrezkoa da orrialde hau erabiltzeko. Ikus [[Special:Version]]',
	'viewsourceold' => 'kodea ikusi',
	'viewsourcelink' => 'jatorria ikusi',
	'viewdeleted' => '$1 ikusi?',
	'viewsource' => 'Kodea ikusi',
	'viewsourcetext' => 'Orrialde honen testua ikusi eta kopiatu dezakezu:',
	'virus-badscanner' => "Ezarpen txarrak: antibirus ezezaguna: ''$1''",
	'virus-scanfailed' => 'eskaneatze txarra ($1 kodea)',
	'virus-unknownscanner' => 'antibirus ezezaguna:',
	'viewpagelogs' => 'Orrialde honen erregistroak ikusi',
	'viewprevnext' => 'Ikusi ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Fitxategiak ez du egiaztapena gainditu.',
	'viewdeletedpage' => 'Ezabatutako orrialdeak ikusi',
	'video-dims' => '$1, $2×$3',
	'version' => 'Bertsioa',
	'version-extensions' => 'Instalatutako luzapenak',
	'version-specialpages' => 'Aparteko orrialdeak',
	'version-parserhooks' => 'Parser estentsioak',
	'version-variables' => 'Aldagaiak',
	'version-other' => 'Bestelakoak',
	'version-mediahandlers' => 'Media gordailuak',
	'version-hooks' => 'Estentsioak',
	'version-extension-functions' => 'Luzapen funtzioak',
	'version-parser-extensiontags' => 'Parser luzapen etiketak',
	'version-parser-function-hooks' => 'Parser funtzio estentsioak',
	'version-hook-name' => 'Estentsioaren izena',
	'version-hook-subscribedby' => 'Hauen harpidetzarekin',
	'version-version' => '(Bertsioa $1)',
	'version-license' => 'Lizentzia',
	'version-poweredby-credits' => "Wiki hau '''[//www.mediawiki.org/ MediaWiki]'''k sustatzen du (copyright © 2001-$1 $2).",
	'version-poweredby-others' => 'beste batzuk',
	'version-software' => 'Instalatutako softwarea',
	'version-software-product' => 'Produktua',
	'version-software-version' => 'Bertsioa',
);

$messages['ext'] = array(
	'variants' => 'Variantis',
	'views' => 'Guipás',
	'viewcount' => 'Esta páhina á siu visoreá {{PLURAL:$1|una vezi|$1 vezis}}.',
	'versionrequired' => 'Es mestel tenel la velsión $1 de MeyaGüiqui',
	'versionrequiredtext' => 'Es mestel tenel la velsión $1 de MeyaGüiqui pa usal esta páhina. Vai a la  [[Special:Version|páhina e velsión]].',
	'viewsourceold' => 'Visoreal coigu huenti',
	'viewsourcelink' => 'vel coigu',
	'viewdeleted' => 'Visoreal $1?',
	'viewsource' => 'Vel coigu huenti',
	'viewsourcetext' => 'Pueis vel i copial el cóigu huenti desta páhina:',
	'virus-badscanner' => "Mala confeguración: escrucaol de virus andarríu: ''$1''",
	'virus-scanfailed' => 'marru al escrucal virus (cóigu $1)',
	'virus-unknownscanner' => 'Antivirus andarriu:',
	'viewpagelogs' => 'Vel los rustrihus d´esta páhina',
	'viewprevnext' => 'Vel ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Vel páhinas esborrás',
	'version' => 'Velsión',
	'version-extensions' => 'Estensionis istalás',
	'version-specialpages' => 'Páhinas especialis',
	'version-variables' => 'Variabris',
	'version-other' => 'Otru',
	'version-extension-functions' => "Huncionis d'estensionis",
	'version-hook-name' => 'Nombri el Hook',
	'version-hook-subscribedby' => 'Suscritu pol',
	'version-version' => '(Velsión $1)',
	'version-license' => 'Licéncia',
	'version-software' => 'Software istalau',
	'version-software-product' => 'Proutu',
	'version-software-version' => 'Velsión',
);

$messages['fa'] = array(
	'variants' => 'گویش‌ها',
	'view' => 'نمایش',
	'viewdeleted_short' => 'نمایش {{PLURAL:$1|یک ویرایش حذف شده|$1 ویرایش حذف شده}}',
	'views' => 'بازدیدها',
	'viewcount' => 'از این صفحه {{PLURAL:$1|یک|$1}} بار بازدید شده است.',
	'view-pool-error' => 'متاسفانه سرورها در حال حاضر دچار بار اضافی هستند.
تعداد زیادی از کاربران تلاش می‌کنند که این صفحه را ببینند.
لطفاً قبل از تلاش دوباره برای دیدن این صفحه مدتی صبر کنید.

$1',
	'versionrequired' => 'نسخهٔ $1 از نرم‌افزار مدیاویکی لازم است',
	'versionrequiredtext' => 'برای دیدن این صفحه به نسخهٔ $1 از نرم‌افزار مدیاویکی نیاز دارید.
به [[Special:Version|این صفحه]] مراجعه کنید.',
	'viewsourceold' => 'نمایش مبدأ',
	'viewsourcelink' => 'نمایش مبدأ',
	'viewdeleted' => 'نمایش $1؟',
	'viewsource' => 'نمایش مبدأ',
	'viewsource-title' => 'مشاهدهٔ منبع برای $1',
	'viewsourcetext' => 'می‌توانید متن مبدأ این صفحه را مشاهده کنید یا از آن نسخه بردارید:',
	'viewyourtext' => "شما می‌توانید کد مبدأ '''ویرایشهایتان''' در این صفحه را ببینید و کپی کنید:",
	'virus-badscanner' => "پیکربندی بد: پویشگر ویروس ناشناخته: ''$1''",
	'virus-scanfailed' => 'پویش ناموفق (کد $1)',
	'virus-unknownscanner' => 'ضدویروس ناشناخته:',
	'viewpagelogs' => 'نمایش سیاهه‌های این صفحه',
	'viewprevnext' => 'نمایش ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'پرونده از آزمون تأیید پرونده گذر نکرد.',
	'viewdeletedpage' => 'نمایش صفحه‌های حذف‌شده',
	'version' => 'نسخه',
	'version-extensions' => 'افزونه‌های نصب‌شده',
	'version-specialpages' => 'صفحه‌های ویژه',
	'version-parserhooks' => 'قلاب‌های تجزیه‌گر',
	'version-variables' => 'متغیرها',
	'version-antispam' => 'جلوگیری از هرزنامه',
	'version-skins' => 'پوسته‌ها',
	'version-other' => 'غیره',
	'version-mediahandlers' => 'به‌دست‌گیرنده‌های رسانه‌ها',
	'version-hooks' => 'قلاب‌ها',
	'version-extension-functions' => 'عملگرهای افزونه',
	'version-parser-extensiontags' => 'برچسب‌های افزونه تجزیه‌گر',
	'version-parser-function-hooks' => 'قلاب‌های عملگر تجزیه‌گر',
	'version-hook-name' => 'نام قلاب',
	'version-hook-subscribedby' => 'وارد شده توسط',
	'version-version' => '(نسخه $1)',
	'version-svn-revision' => '(&رلم;r$2)',
	'version-license' => 'اجازه‌نامه',
	'version-poweredby-credits' => "این ویکی توسط '''[//www.mediawiki.org/ مدیاویکی]''' پشتیبانی می‌شود، کلیهٔ حقوق محفوظ است © 2001-$1 $2.",
	'version-poweredby-others' => 'دیگران',
	'version-license-info' => 'مدیاویکی نرم‌افزاری رایگان است؛ می‌توانید آن را تحت شرایط مجوز عمومی همگانی گنو که توسط بنیاد نرم‌افزار رایگان منتشر شده‌است، بازنشر کنید؛ یا نسخهٔ ۲ از این مجوز، یا (بنا به اختیار) نسخه‌های بعدی.

مدیاویکی به این امید که مفید واقع شود منتشر شده‌است، ولی بدون هیچ‌گونه ضمانتی؛ بدون ضمانت ضمنی که تجاری یا برای کار خاصی مناسب باشد. برای اطلاعات بیشتر مجوز گنو جی‌پی‌ال را مشاهده کنید.

شما باید [{{SERVER}}{{SCRIPTPATH}}/COPYING یک نسخه از مجوز عمومی همگانی گنو] را همراه این برنامه دریافت کرده باشید؛ در غیر این صورت بنویسید برای Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA یا آن را [//www.gnu.org/licenses/old-licenses/gpl-2.0.html به صورت برخط بخوانید].',
	'version-software' => 'نسخهٔ نصب‌شده',
	'version-software-product' => 'محصول',
	'version-software-version' => 'نسخه',
);

$messages['fi'] = array(
	'variants' => 'Muuttujat',
	'view' => 'Näytä',
	'viewdeleted_short' => 'Näytä {{PLURAL:$1|poistettu muokkaus|$1 poistettua muokkausta}}',
	'views' => 'Näkymät',
	'viewcount' => 'Tämä sivu on näytetty {{PLURAL:$1|yhden kerran|$1 kertaa}}.',
	'view-pool-error' => 'Valitettavasti palvelimet ovat ylikuormittuneet tällä hetkellä.
Liian monta käyttäjää yrittää tarkastella tätä sivua.
Odota hetki ennen kuin yrität uudelleen.

$1',
	'versionrequired' => 'MediaWikistä tarvitaan vähintään versio $1',
	'versionrequiredtext' => 'MediaWikistä tarvitaan vähintään versio $1 tämän sivun käyttämiseen. Katso [[Special:Version|versio]].',
	'viewsourceold' => 'näytä lähdekoodi',
	'viewsourcelink' => 'näytä lähdekoodi',
	'viewdeleted' => 'Näytä $1?',
	'viewsource' => 'Lähdekoodi',
	'viewsource-title' => 'Lähdekoodi sivulle $1',
	'viewsourcetext' => 'Voit tarkastella ja kopioida tämän sivun lähdekoodia:',
	'viewyourtext' => "Voit tarkastella ja kopioida lähdekoodin '''tekemistäsi muutoksista''' tähän sivuun:",
	'virus-badscanner' => "Virheellinen asetus: Tuntematon virustutka: ''$1''",
	'virus-scanfailed' => 'virustarkistus epäonnistui virhekoodilla $1',
	'virus-unknownscanner' => 'tuntematon virustutka:',
	'viewpagelogs' => 'Näytä tämän sivun lokit',
	'viewprevnext' => 'Näytä [$3] kerralla.

$1 {{int:pipe-separator}} $2',
	'verification-error' => 'Tämä tiedosto ei läpäissyt tiedoston tarkistusta.',
	'viewdeletedpage' => 'Poistettujen sivujen selaus',
	'version' => 'Versio',
	'version-extensions' => 'Asennetut laajennukset',
	'version-specialpages' => 'Toimintosivut',
	'version-parserhooks' => 'Jäsenninkytkökset',
	'version-variables' => 'Muuttujat',
	'version-antispam' => 'Roskapostin ja mainoslinkkien estäminen',
	'version-skins' => 'Ulkoasut',
	'version-other' => 'Muut',
	'version-mediahandlers' => 'Median käsittelijät',
	'version-hooks' => 'Kytköspisteet',
	'version-extension-functions' => 'Laajennusfunktiot',
	'version-parser-extensiontags' => 'Jäsentimen laajennustagit',
	'version-parser-function-hooks' => 'Jäsentimen laajennusfunktiot',
	'version-hook-name' => 'Kytköspisteen nimi',
	'version-hook-subscribedby' => 'Kytkökset',
	'version-version' => '(Versio $1)',
	'version-license' => 'Lisenssi',
	'version-poweredby-credits' => "Tämä wiki käyttää '''[//www.mediawiki.org/ MediaWikiä]'''. Copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'muut',
	'version-license-info' => 'MediaWiki on vapaa ohjelmisto – voit levittää sitä ja/tai muokata sitä Free Software Foundationin GNU General Public Licensen ehdoilla, joko version 2 tai halutessasi mikä tahansa myöhemmän version mukaisesti.

MediaWikiä levitetään siinä toivossa, että se olisi hyödyllinen, mutta ilman mitään takuuta; ilman edes hiljaista takuuta kaupallisesti hyväksyttävästä laadusta tai soveltuvuudesta tiettyyn tarkoitukseen. Katso GPL-lisenssistä lisää yksityiskohtia.

Sinun olisi pitänyt saada [{{SERVER}}{{SCRIPTPATH}}/COPYING kopio GNU General Public Licensestä] tämän ohjelman mukana. Jos et saanut kopiota, kirjoita siitä osoitteeseen Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA tai [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lue se Internetissä].',
	'version-software' => 'Asennettu ohjelmisto',
	'version-software-product' => 'Tuote',
	'version-software-version' => 'Versio',
);

$messages['fiu-vro'] = array(
	'variants' => 'Muuttujat',
	'view' => 'Näytä',
	'viewdeleted_short' => 'Näytä {{PLURAL:$1|poistettu muokkaus|$1 poistettua muokkausta}}',
	'views' => 'Näkymät',
	'viewcount' => 'Tämä sivu on näytetty {{PLURAL:$1|yhden kerran|$1 kertaa}}.',
	'view-pool-error' => 'Valitettavasti palvelimet ovat ylikuormittuneet tällä hetkellä.
Liian monta käyttäjää yrittää tarkastella tätä sivua.
Odota hetki ennen kuin yrität uudelleen.

$1',
	'versionrequired' => 'MediaWikistä tarvitaan vähintään versio $1',
	'versionrequiredtext' => 'MediaWikistä tarvitaan vähintään versio $1 tämän sivun käyttämiseen. Katso [[Special:Version|versio]].',
	'viewsourceold' => 'näytä lähdekoodi',
	'viewsourcelink' => 'näytä lähdekoodi',
	'viewdeleted' => 'Näytä $1?',
	'viewsource' => 'Lähdekoodi',
	'viewsource-title' => 'Lähdekoodi sivulle $1',
	'viewsourcetext' => 'Voit tarkastella ja kopioida tämän sivun lähdekoodia:',
	'viewyourtext' => "Voit tarkastella ja kopioida lähdekoodin '''tekemistäsi muutoksista''' tähän sivuun:",
	'virus-badscanner' => "Virheellinen asetus: Tuntematon virustutka: ''$1''",
	'virus-scanfailed' => 'virustarkistus epäonnistui virhekoodilla $1',
	'virus-unknownscanner' => 'tuntematon virustutka:',
	'viewpagelogs' => 'Näytä tämän sivun lokit',
	'viewprevnext' => 'Näytä [$3] kerralla.

$1 {{int:pipe-separator}} $2',
	'verification-error' => 'Tämä tiedosto ei läpäissyt tiedoston tarkistusta.',
	'viewdeletedpage' => 'Poistettujen sivujen selaus',
	'version' => 'Versio',
	'version-extensions' => 'Asennetut laajennukset',
	'version-specialpages' => 'Toimintosivut',
	'version-parserhooks' => 'Jäsenninkytkökset',
	'version-variables' => 'Muuttujat',
	'version-antispam' => 'Roskapostin ja mainoslinkkien estäminen',
	'version-skins' => 'Ulkoasut',
	'version-other' => 'Muut',
	'version-mediahandlers' => 'Median käsittelijät',
	'version-hooks' => 'Kytköspisteet',
	'version-extension-functions' => 'Laajennusfunktiot',
	'version-parser-extensiontags' => 'Jäsentimen laajennustagit',
	'version-parser-function-hooks' => 'Jäsentimen laajennusfunktiot',
	'version-hook-name' => 'Kytköspisteen nimi',
	'version-hook-subscribedby' => 'Kytkökset',
	'version-version' => '(Versio $1)',
	'version-license' => 'Lisenssi',
	'version-poweredby-credits' => "Tämä wiki käyttää '''[//www.mediawiki.org/ MediaWikiä]'''. Copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'muut',
	'version-license-info' => 'MediaWiki on vapaa ohjelmisto – voit levittää sitä ja/tai muokata sitä Free Software Foundationin GNU General Public Licensen ehdoilla, joko version 2 tai halutessasi mikä tahansa myöhemmän version mukaisesti.

MediaWikiä levitetään siinä toivossa, että se olisi hyödyllinen, mutta ilman mitään takuuta; ilman edes hiljaista takuuta kaupallisesti hyväksyttävästä laadusta tai soveltuvuudesta tiettyyn tarkoitukseen. Katso GPL-lisenssistä lisää yksityiskohtia.

Sinun olisi pitänyt saada [{{SERVER}}{{SCRIPTPATH}}/COPYING kopio GNU General Public Licensestä] tämän ohjelman mukana. Jos et saanut kopiota, kirjoita siitä osoitteeseen Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA tai [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lue se Internetissä].',
	'version-software' => 'Asennettu ohjelmisto',
	'version-software-product' => 'Tuote',
	'version-software-version' => 'Versio',
);

$messages['fo'] = array(
	'variants' => 'Ymisk sløg',
	'view' => 'Les',
	'viewdeleted_short' => 'Vís {{PLURAL:$1|eina strikaða broyting|$1 strikaðar broytingar}}',
	'views' => 'Skoðanir',
	'viewcount' => 'Onkur hevur verið á hesi síðu {{PLURAL:$1|eina ferð|$1 ferðir}}.',
	'view-pool-error' => 'Haldið okkum til góðar, servarnir hava ov nógv at gera í løtuni.
Ov nógvir brúkarir royna at síggja hesa síðuna.
Vinarliga bíða eina løtu, áðrenn tú roynir enn einaferð at fáa atgongd til hesa síðuna.

$1',
	'versionrequired' => 'Versjón $1 frá MediaWiki er kravd',
	'versionrequiredtext' => 'Versjón $1 av MediaWiki er kravd fyri at brúka hesa síðuna.
Sí [[Special:Version|versjón síða]].',
	'viewsourceold' => 'vís keldu',
	'viewsourcelink' => 'vís keldu',
	'viewdeleted' => 'Vís $1?',
	'viewsource' => 'Vís keldu',
	'viewsource-title' => 'Sí keldu fyri $1',
	'viewsourcetext' => 'Tú kanst síggja og avrita kelduna til hesa grein:',
	'viewyourtext' => "Tú kanst síggja og avrita kelduna fyri '''tínar rættingar''' til hesa síðuna:",
	'virus-badscanner' => "Konfiguratións villa: Ókendur virus skannari: ''$1''",
	'virus-scanfailed' => '↓  skanning virkaði ikki (kota $1)',
	'virus-unknownscanner' => 'ókent antivirus:',
	'viewpagelogs' => 'Sí logg fyri hesa grein',
	'viewprevnext' => 'Vís ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'Útgáva',
	'version-hooks' => 'Krókur',
	'version-hook-name' => 'Krókurnavn',
	'version-version' => '(Útgáva $1)',
	'version-software-version' => 'Útgáva',
);

$messages['fr'] = array(
	'variants' => 'Variantes',
	'view' => 'Lire',
	'viewdeleted_short' => 'Voir {{PLURAL:$1|une modification supprimée|$1 modifications supprimées}}',
	'views' => 'Affichages',
	'viewcount' => 'Cette page a été consultée $1 fois.',
	'view-pool-error' => 'Désolé, les serveurs sont surchargés en ce moment.
Trop d’utilisateurs cherchent à consulter cette page.
Veuillez attendre un moment avant de retenter l’accès à cette page.

$1',
	'versionrequired' => 'Version $1 de MediaWiki nécessaire',
	'versionrequiredtext' => 'La version $1 de MediaWiki est nécessaire pour utiliser cette page. Consultez [[Special:Version|la page des versions]]',
	'viewsourceold' => 'voir la source',
	'viewsourcelink' => 'voir la source',
	'viewdeleted' => 'Voir $1 ?',
	'viewsource' => 'Voir le texte source',
	'viewsource-title' => 'Voir la source de $1',
	'viewsourcetext' => 'Vous pouvez voir et copier le contenu de la page :',
	'viewyourtext' => "Vous pouvez voir et copier le contenu de '''vos modifications''' à cette page :",
	'virus-badscanner' => "Mauvaise configuration : scanneur de virus inconnu : ''$1''",
	'virus-scanfailed' => 'Échec de la recherche (code $1)',
	'virus-unknownscanner' => 'antivirus inconnu :',
	'viewpagelogs' => 'Voir les opérations sur cette page',
	'viewprevnext' => 'Voir ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Ce fichier ne passe pas la vérification des fichiers.',
	'viewdeletedpage' => 'Voir les pages supprimées',
	'version' => 'Version',
	'version-extensions' => 'Extensions installées',
	'version-specialpages' => 'Pages spéciales',
	'version-parserhooks' => 'Greffons de l’analyseur syntaxique',
	'version-variables' => 'Variables',
	'version-antispam' => 'Prévention du pourriel',
	'version-skins' => 'Habillages',
	'version-other' => 'Divers',
	'version-mediahandlers' => 'Manipulateurs de médias',
	'version-hooks' => 'Greffons',
	'version-extension-functions' => 'Fonctions d’extension internes',
	'version-parser-extensiontags' => 'Balises étendues de l’analyseur syntaxique',
	'version-parser-function-hooks' => 'Fonctions étendues de l’analyseur syntaxique',
	'version-hook-name' => 'Nom du greffon',
	'version-hook-subscribedby' => 'Abonnés :',
	'version-version' => '(Version $1)',
	'version-license' => 'Licence',
	'version-poweredby-credits' => "Ce wiki fonctionne grâce à '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'autres',
	'version-license-info' => "MediaWiki est un logiciel libre, vous pouvez le redistribuer et / ou le modifier selon les termes de la Licence Publique Générale GNU telle que publiée par la Free Software Foundation ; soit la version 2 de la Licence, ou (à votre choix) toute version ultérieure.

MediaWiki est distribué dans l'espoir qu'il sera utile, mais SANS AUCUNE GARANTIE, sans même la garantie implicite de COMMERCIALISATION ou D'ADAPTATION A UN USAGE PARTICULIER. Voir la Licence Publique Générale GNU pour plus de détails.

Vous devriez avoir reçu [{{SERVER}}{{SCRIPTPATH}}/COPYING une copie de la Licence Publique Générale GNU] avec ce programme, sinon, écrivez à la Free Software Foundation, Inc, 51, rue Franklin, cinquième étage, Boston, MA 02110-1301, États-Unis ou [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lisez-la en ligne].",
	'version-software' => 'Logiciels installés',
	'version-software-product' => 'Produit',
	'version-software-version' => 'Version',
	'vertical-tv' => 'Télévision',
	'vertical-games' => 'Jeux vidéo',
	'vertical-books' => 'Littérature',
	'vertical-lifestyle' => 'Mode de vie',
	'vertical-movies' => 'Films',
);

$messages['frc'] = array(
	'views' => 'Vues',
	'viewcount' => 'Cette page a été visitée {{PLURAL:$1|$1 fois|$1 fois}}.',
	'versionrequired' => 'Vous avez besoin de la version $1 de MediaWiki.',
	'versionrequiredtext' => 'Vous avez besoin de la version $1 de MediaWiki pour utiliser cette page. Voir [[Special:Version]].',
	'viewsourcelink' => 'Voir la source',
	'viewdeleted' => 'Voir $1?',
	'viewsource' => 'Voir la source',
	'viewsourcetext' => 'Vous pouvez voir et copier la source de cette page:',
	'viewpagelogs' => 'Voir les notes pour cette page',
);

$messages['frp'] = array(
	'variants' => 'Variantes',
	'view' => 'Liére',
	'viewdeleted_short' => 'Vêre {{PLURAL:$1|yon changement suprimâ|$1 changements suprimâs}}',
	'views' => 'Visualisacions',
	'viewcount' => 'Ceta pâge at étâ vua {{PLURAL:$1|yon côp|$1 côps}}.',
	'view-pool-error' => 'Dèsolâ, los sèrvors sont surchargiês por lo moment.
Trop d’usanciérs chèrchont a arrevar a ceta pâge.
Volyéd atendre un moment devant que vos tâchiéd de tornar arrevar a ceta pâge.

$1',
	'versionrequired' => 'Vèrsion $1 de MediaWiki nècèssèra',
	'versionrequiredtext' => 'La vèrsion $1 de MediaWiki est nècèssèra por utilisar ceta pâge.
Vêde la [[Special:Version|pâge de les vèrsions]].',
	'viewsourceold' => 'vêre lo tèxto sôrsa',
	'viewsourcelink' => 'vêre lo tèxto sôrsa',
	'viewdeleted' => 'Fâre vêre $1 ?',
	'viewsource' => 'Vêre lo tèxto sôrsa',
	'viewsource-title' => 'Vêre la sôrsa de $1',
	'viewsourcetext' => 'Vos pouede vêre et copiyér lo tèxto sôrsa de la pâge :',
	'viewyourtext' => "Vos pouede vêre et copiyér lo contegnu de '''voutros changements''' a ceta pâge :",
	'virus-badscanner' => "Crouye configuracion : scanor de virus encognu : ''$1''",
	'virus-scanfailed' => 'Falyita de la rechèrche (code $1)',
	'virus-unknownscanner' => 'antivirus encognu :',
	'viewpagelogs' => 'Vêde los jornals de ceta pâge',
	'viewprevnext' => 'Vêre ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Cél fichiér pâsse pas lo contrôlo des fichiérs.',
	'viewdeletedpage' => 'Vêre les pâges suprimâs',
	'version' => 'Vèrsion',
	'version-extensions' => 'Èxtensions enstalâs',
	'version-specialpages' => 'Pâges spèciâles',
	'version-parserhooks' => 'Grèfons du parsor',
	'version-variables' => 'Variâbles',
	'version-antispam' => 'Prèvencion du spame',
	'version-skins' => 'Habelyâjos',
	'version-other' => 'De totes sôrtes',
	'version-mediahandlers' => 'Maneyors de mèdia',
	'version-hooks' => 'Grèfons',
	'version-extension-functions' => 'Fonccions d’èxtension de dedens',
	'version-parser-extensiontags' => 'Balises d’èxtension du parsor',
	'version-parser-function-hooks' => 'Grèfons de les fonccions du parsor',
	'version-hook-name' => 'Nom du grèfon',
	'version-hook-subscribedby' => 'Soscrit per',
	'version-version' => '(Vèrsion $1)',
	'version-svn-revision' => '(v$2)',
	'version-license' => 'Licence',
	'version-poweredby-credits' => "Ceti vouiqui fonccione grâce a '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'ôtros',
	'version-license-info' => 'MediaWiki est una programeria libra ; vos la pouede tornar distribuar et / ou changiér d’aprés los tèrmos de la Licence publica g·ènèrala GNU coment publeyê per la Free Software Foundation ; seye la vèrsion 2 de la Licence, ou ben (a voutron chouèx) tota novèla vèrsion.

MediaWiki est distribuâ dens l’èsperance que serat utila, mas SEN GINS DE GARANTIA ; sen mémo la garantia emplicita de COMÈRCIALISACION ou ben d’ADAPTACION A UN USÂJO PARTICULIÉR. Vêde la Licence publica g·ènèrala GNU por més de dètalys.

Vos devriâd avêr reçu un [{{SERVER}}{{SCRIPTPATH}}/COPYING ègzemplèro de la Licence publica g·ènèrala GNU] avouéc ceti programo ; ôtrament, ècrîde a la « Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA » ou ben [//www.gnu.org/licenses/old-licenses/gpl-2.0.html liéséd-la en legne].',
	'version-software' => 'Programeries enstalâs',
	'version-software-product' => 'Marchandie',
	'version-software-version' => 'Vèrsion',
	'version-entrypoints' => 'URL de pouent d’entrâ',
	'version-entrypoints-header-entrypoint' => 'Pouent d’entrâ',
	'version-entrypoints-header-url' => 'URL',
);

$messages['frr'] = array(
	'variants' => 'Fariante',
	'view' => 'Lees',
	'viewdeleted_short' => '$1 {{PLURAL:$1|iinj sträägen färsjoon|$1 sträägene färsjoone}} önjkiike',
	'views' => 'Önjsichte',
	'viewcount' => 'Aw jüdeer sid as  {{PLURAL:$1|iinjsen|$1 tunge}} tugram wörden.',
	'view-pool-error' => 'Önjschüliing, da särwere san nütutids ouerlååsted.
Tufoole brükere fersäke, jüdeer sid tu besäken.
Wees sü gödj än täiw hu minuute, iir dü dåt nuch iinjsen ferseechst.

$1',
	'versionrequired' => 'Färsjoon $1 foon MediaWiki as nüsi.',
	'versionrequiredtext' => 'Färsjoon $1 foon MediaWiki as nüsi, am jüdeer sid tu brüken.
Sii jü [[Special:Version|Färsjoonssid]]',
	'viewsourceold' => 'kwältakst wise',
	'viewsourcelink' => 'kwältakst wise',
	'viewdeleted' => '$1 wise?',
	'viewsource' => 'Kwältäkst önjkiike',
	'viewsourcetext' => 'Dü koost jü kwäle foon jüdeer sid bekiike än kopiire.',
	'virus-badscanner' => "Hiinje konfigurasjoon: ünbekånde fiirusscanner: ''$1''",
	'virus-scanfailed' => 'scan fäägelsloin (code $1)',
	'virus-unknownscanner' => 'Ünbekånde fiirusscanner:',
	'viewpagelogs' => 'Logböke for jüdeer sid wise',
	'viewprevnext' => 'Wis ($1 {{int:pipe-separator}} $2) ($3)',
	'version-software' => 'Instaliird software',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Färsjoon',
);

$messages['fur'] = array(
	'variants' => 'Variants',
	'view' => 'Viodi',
	'viewdeleted_short' => 'Viôt {{PLURAL:$1|une modifiche eliminade|$1 modifichis eliminadis}}',
	'views' => 'Visitis',
	'viewcount' => 'Cheste pagjine e je stade lete {{PLURAL:$1|une volte|$1 voltis}}.',
	'versionrequired' => 'E covente la version $1 di MediaWiki',
	'viewsourceold' => 'cjale risultive',
	'viewsourcelink' => 'cjale risultive',
	'viewdeleted' => 'Vuelistu viodi $1?',
	'viewsource' => 'Cjale risultive',
	'viewsourcetext' => 'Tu puedis viodi e copiâ la risultive di cheste pagjine:',
	'viewpagelogs' => 'Cjale i regjistris relatîfs a cheste pagjine.',
	'viewprevnext' => 'Cjale ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Viôt lis pagjinis eliminadis',
	'version' => 'Version',
	'version-variables' => 'Variabilis',
	'version-version' => '(Version $1)',
	'version-license' => 'Licence',
	'version-software-version' => 'Version',
);

$messages['fy'] = array(
	'variants' => 'Farianten',
	'views' => 'Aspekten/aksjes',
	'viewcount' => 'Disse side is {{PLURAL:$1|ienris|$1 kear}} iepenslein.',
	'view-pool-error' => "Ekskuseare, de tsjinners hawwe it op it stuit te drok.
Tefolle meidoggers probearje dizze side te besjen.
Wachtsje efkes foardatsto op 'e nij tagong ta dizze side probearrest te krijen.

$1",
	'versionrequired' => 'Ferzje $1 fan MediaWiki is eask',
	'versionrequiredtext' => "Ferzje $1 fan MediaWiki is eask om dizze side te brûken. Mear ynfo is beskikber op 'e side [[Special:Version|softwareferzje]].",
	'viewsourceold' => 'boarnetekst besjen',
	'viewsourcelink' => 'boarnetekst besjen',
	'viewdeleted' => '$1 sjen litte?',
	'viewsource' => 'Besjoch de boarne',
	'viewsourcetext' => 'Jo kinne de boarnetekst fan dizze side besjen en kopiearje:',
	'virus-badscanner' => "Minne konfiguraasje: ûnbekende virusscanner: ''$1''",
	'virus-scanfailed' => 'scannen is mislearre (koade $1)',
	'virus-unknownscanner' => 'ûnbekend antivirus:',
	'viewpagelogs' => 'Lochboek foar dizze side sjen litte',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) besjen.',
	'viewdeletedpage' => 'Wiske siden besjen',
	'version' => 'Ferzje',
	'version-extensions' => 'Ynstallearre útwreidings',
	'version-specialpages' => 'Bysûndere siden',
	'version-variables' => 'Fariabels',
	'version-other' => 'Oare',
	'version-version' => '(Ferzje $1)',
	'version-license' => 'Lisinsje',
	'version-software' => 'Ynsteld software',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Ferzje',
);

$messages['ga'] = array(
	'variants' => 'Leaganacha Malartacha',
	'view' => 'Amharc',
	'viewdeleted_short' => 'Féach ar {{PLURAL:$1|athrú scriosta amháin|$1 athrú scriosta}}',
	'views' => 'Radhairc',
	'viewcount' => 'Rochtainíodh an leathanach seo {{PLURAL:$1|uair amháin|$1 uaire}}.',
	'versionrequired' => 'Tá leagan $1 de MediaWiki de dhíth',
	'versionrequiredtext' => 'Tá an leagan $1 de MediaWiki riachtanach chun an leathanach seo a úsáid. Féach ar [[Special:Version]]',
	'viewsourceold' => 'féach ar foinse',
	'viewsourcelink' => 'féach ar an foinse',
	'viewdeleted' => 'Féach ar $1?',
	'viewsource' => 'Féach ar fhoinse',
	'viewsourcetext' => 'Is féidir foinse an leathanach seo a fheiceáil ná a cóipeáil:',
	'virus-scanfailed' => 'theip an scan (cód $1)',
	'virus-unknownscanner' => 'frithvíreas anaithnid:',
	'viewpagelogs' => 'Féach ar logaí faoin leathanach seo',
	'viewprevnext' => 'Taispeáin ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Féach ar leathanaigh scriosta',
	'version' => 'Leagan',
	'version-other' => 'Eile',
	'version-version' => '(Leagan $1)',
	'version-license' => 'Ceadúnas',
	'version-software' => 'Bogearraí suiteáilte',
	'version-software-version' => 'Leagan',
);

$messages['gag'] = array(
	'views' => 'Görünüşler',
	'viewcount' => 'Bu sayfaya {{PLURAL:$1|bir|$1 }} kerä girildi.',
	'versionrequired' => 'MediaWiki-nin $1 versiyası läazım',
	'versionrequiredtext' => 'MediaWiki-nin $1 versiyası läazım bu sayfayı kullanmaa deyni. Bak [[Special:Version|versiya sayfası]].',
	'viewsourcelink' => 'Geliniri gör',
	'viewdeleted' => '$1 gör?',
	'viewsource' => 'Geliniri gör',
	'viewsourcetext' => 'Var nicä görmää hem kopiya etmää bu yapraa gelinirini:',
	'viewpagelogs' => 'Bu yaprak için jurnalları göster',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'Versiya',
);

$messages['gan'] = array(
	'variantname-gan-hans' => '简体',
	'variantname-gan-hant' => '繁體',
	'variantname-gan' => '贛語原文',
);

$messages['gan-hans'] = array(
	'variants' => '变换',
	'view' => '眵',
	'viewdeleted_short' => '眵$1只拕删吥𠮶版本',
	'views' => '眵',
	'viewcount' => '个页拖人眵嘞$1回。',
	'view-pool-error' => '不过意，个只伺服器到个时间超吥最大负荷。
多伤哩𠮶用户较得去望个页。
想望过个页𠮶话请等多一下。

$1',
	'versionrequired' => '需要$1版𠮶mediawiki',
	'versionrequiredtext' => '$1版𠮶mediawiki才用得正个页。参看[[Special:Version|版本页]]。',
	'viewsourceold' => '眵吖源代码',
	'viewsourcelink' => '望吖原码',
	'viewdeleted' => '眵吖$1?',
	'viewsource' => '源代码',
	'viewsourcetext' => '倷可以眵吖或复制个页𠮶源代码：',
	'virus-unknownscanner' => '不晓得𠮶防病毒:',
	'viewpagelogs' => '眵吖个页𠮶日志',
	'viewprevnext' => '眵吖（$1 {{int:pipe-separator}} $2） （$3）',
	'viewdeletedpage' => '望吖删卟𠮶页面',
	'version' => '版本',
	'version-extensions' => '装正𠮶插件',
	'version-specialpages' => '特别𠮶页面',
	'version-parserhooks' => '解析器钩子',
	'version-variables' => '变量',
	'version-other' => '别𠮶',
	'version-mediahandlers' => '媒体处理程序',
	'version-extension-functions' => '扩展功能',
	'version-parser-extensiontags' => '解析器扩展标签',
	'version-hook-name' => '钩子名',
	'version-hook-subscribedby' => '订阅人',
	'version-version' => '（版本 $1）',
	'version-license' => '许可证',
	'version-software' => '装正𠮶软件',
	'version-software-version' => '版本',
);

$messages['gan-hant'] = array(
	'variants' => '變換',
	'view' => '眵',
	'viewdeleted_short' => '眵$1隻拕刪吥嗰版本',
	'views' => '望吖',
	'viewcount' => '箇頁拕人眵嘞$1回。',
	'view-pool-error' => '不過意，箇隻伺服器到箇時間超吥最大負荷。
多傷哩嗰用戶較得去望箇頁。
想望過箇頁嗰話請等多一下。

$1',
	'versionrequired' => '需要$1版嗰mediawiki',
	'versionrequiredtext' => '$1版嗰mediawiki才用得正箇頁。參看[[Special:Version|版本頁]]。',
	'viewsourceold' => '望吖原碼',
	'viewsourcelink' => '望吖原碼',
	'viewdeleted' => '眵吖$1?',
	'viewsource' => '原始碼',
	'viewsourcetext' => '倷可以眵吖或複製箇頁嗰原始碼：',
	'virus-unknownscanner' => '不曉得嗰防病毒:',
	'viewpagelogs' => '眵吖箇頁嗰日誌',
	'viewprevnext' => '望吖（$1 {{int:pipe-separator}} $2） （$3）',
	'viewdeletedpage' => '望吖刪卟嗰頁面',
	'version' => '版本',
	'version-extensions' => '裝正嗰插件',
	'version-specialpages' => '特別嗰頁面',
	'version-parserhooks' => '解析器鉤子',
	'version-variables' => '變量',
	'version-other' => '別嗰',
	'version-mediahandlers' => '媒體處理程序',
	'version-extension-functions' => '擴展功能',
	'version-parser-extensiontags' => '解析器擴展標籤',
	'version-hook-name' => '鉤子名',
	'version-hook-subscribedby' => '訂閱人',
	'version-version' => '（版本 $1）',
	'version-license' => '許可證',
	'version-poweredby-credits' => "箇隻 Wiki 由 '''[//www.mediawiki.org/ MediaWiki]''' 驅動，版權所有 © 2001-$1 $2。",
	'version-software' => '裝正嗰軟件',
	'version-software-version' => '版本',
);

$messages['gd'] = array(
	'variants' => 'Tionndaidhean',
	'view' => 'Seall',
	'viewdeleted_short' => 'Seall {{PLURAL:$1|aon deasachadh|$1 dheasachadh|$1 deasachadh|$1 dheasachadh|$1 deasachaidhean|$1 deasachadh}} a chaidh a sguabadh às',
	'views' => 'Tadhalan',
	'viewcount' => 'Chaidh inntrigeadh a dhèanam dhan duilleag seo {{PLURAL:$1|aon turas|$1 thuras|$1 turas|$1 turais|$1 turas}}.',
	'view-pool-error' => "Duilich, tha na frithealaichean ro thrang an-dràsta.
Tha cus chleachdaichean a' feuchainn ris an duilleag seo fhaicinn.
Fuirich ort greis mus feuch thu ris an duilleag seo fhaicinn a-rithist.

$1",
	'versionrequired' => 'Feum air tionndadh $1 de MhediaWiki',
	'versionrequiredtext' => 'Tha feum air tionndadh $1 de MhediaWiki mus faicear an duilleag seo.
Seall air [[Special:Version|duilleag an tionndaidh]].',
	'viewsourceold' => 'seall an tùs',
	'viewsourcelink' => 'seall an tùs',
	'viewdeleted' => 'Seall $1?',
	'viewsource' => 'Seall an tùs',
	'viewsource-title' => 'Seall an tùs aig $1',
	'viewsourcetext' => "'S urrainn dhut coimhead air tùs na duilleige seo 's lethbhreac a dhèanamh dheth:",
	'viewyourtext' => "'S urrainn dhut coimhead air '''na mhùthaich thu''' 's lethbhreac a dhèanamh dheth air an duilleag seo:",
	'virus-badscanner' => "Droch cho-dhealbhachd: sganair bhìorasan neo-aithnichte: ''$1''",
	'virus-scanfailed' => "dh'fhàillig an sganadh (còd $1)",
	'virus-unknownscanner' => 'sganair bhìorasan neo-aithnichte:',
	'viewpagelogs' => 'Seall logaichean na duilleige seo',
	'viewprevnext' => 'Seall ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'Tionndadh',
);

$messages['gl'] = array(
	'variants' => 'Variantes',
	'view' => 'Ver',
	'viewdeleted_short' => 'Ver {{PLURAL:$1|unha edición borrada|$1 edicións borradas}}',
	'views' => 'Vistas',
	'viewcount' => 'Esta páxina foi visitada {{PLURAL:$1|unha vez|$1 veces}}.',
	'view-pool-error' => 'Sentímolo, os servidores están sobrecargados nestes intres.
Hai moitos usuarios intentando ver esta páxina.
Por favor, agarde un anaco antes de intentar acceder á páxina de novo.

$1',
	'versionrequired' => 'Necesítase a versión $1 de MediaWiki',
	'versionrequiredtext' => 'Necesítase a versión $1 de MediaWiki para utilizar esta páxina. Vexa [[Special:Version|a páxina da versión]].',
	'viewsourceold' => 'ver o código fonte',
	'viewsourcelink' => 'ver o código fonte',
	'viewdeleted' => 'Quere ver $1?',
	'viewsource' => 'Ver o código fonte',
	'viewsource-title' => 'Ver o código fonte de "$1"',
	'viewsourcetext' => 'Pode ver e copiar o código fonte desta páxina:',
	'viewyourtext' => "Pode ver e copiar o código fonte '''das súas edicións''' nesta páxina:",
	'virus-badscanner' => "Configuración errónea: escáner de virus descoñecido: ''$1''",
	'virus-scanfailed' => 'fallou o escaneado (código $1)',
	'virus-unknownscanner' => 'antivirus descoñecido:',
	'viewpagelogs' => 'Ver os rexistros desta páxina',
	'viewprevnext' => 'Ver as ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'O ficheiro non pasou a comprobación de ficheiros.',
	'viewdeletedpage' => 'Ver as páxinas borradas',
	'version' => 'Versión',
	'version-extensions' => 'Extensións instaladas',
	'version-specialpages' => 'Páxinas especiais',
	'version-parserhooks' => 'Asociadores analíticos',
	'version-variables' => 'Variables',
	'version-antispam' => 'Prevención contra spam',
	'version-skins' => 'Aparencias',
	'version-other' => 'Outros',
	'version-mediahandlers' => 'Executadores de multimedia',
	'version-hooks' => 'Asociadores',
	'version-extension-functions' => 'Funcións das extensións',
	'version-parser-extensiontags' => 'Etiquetas das extensións do analizador',
	'version-parser-function-hooks' => 'Asociadores da función do analizador',
	'version-hook-name' => 'Nome do asociador',
	'version-hook-subscribedby' => 'Subscrito por',
	'version-version' => '(Versión $1)',
	'version-license' => 'Licenza',
	'version-poweredby-credits' => "Este wiki está desenvolvido por '''[//www.mediawiki.org/wiki/MediaWiki/gl MediaWiki]''', dereitos de autor © 2001-$1 $2.",
	'version-poweredby-others' => 'outros',
	'version-license-info' => 'MediaWiki é software libre; pode redistribuílo e/ou modificalo segundo os termos da licenza pública xeral GNU publicada pola Free Software Foundation; versión 2 ou (na súa escolla) calquera outra posterior.

MediaWiki distribúese coa esperanza de que poida ser útil, pero SEN GARANTÍA NINGUNHA; nin sequera a garantía implícita de COMERCIALIZACIÓN ou ADECUACIÓN A UNHA FINALIDADE ESPECÍFICA. Olle a licenza pública xeral GNU para obter máis detalles.

Debería recibir [{{SERVER}}{{SCRIPTPATH}}/COPYING unha copia da licenza pública xeral GNU] xunto ao programa; se non é así, escriba á Free Software Foundation, Inc., rúa Franklin, número 51, quinto andar, Boston, Massachusetts, 02110-1301, Estados Unidos de América ou [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lea a licenza en liña].',
	'version-software' => 'Software instalado',
	'version-software-product' => 'Produto',
	'version-software-version' => 'Versión',
);

$messages['gn'] = array(
	'views' => 'Techakuéra',
	'viewcount' => 'Esta página ha sido visitada $1 veces.',
	'viewprevnext' => 'Hecha ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => "Mba'ereko",
);

$messages['got'] = array(
	'view' => 'Saíhvan',
	'views' => '𐍃𐌹𐌿𐌽𐌴𐌹𐍃',
	'viewsource' => '𐍃𐌰𐌹𐍈𐌰 𐌹𐌽𐌽𐌰𐌽𐌰',
	'viewprevnext' => '𐍃𐌹𐌿𐌽𐌴𐌹𐍃 ($1 {{int:pipe-separator}} $2) ($3)',
	'version-other' => 'Anþar',
);

$messages['grc'] = array(
	'variants' => 'Παραλλαγαί',
	'views' => 'Ποσάκις ἔσκεπται',
	'viewcount' => 'Ἥδε ἡ δέλτος προσεπελάσθη {{PLURAL:$1|ἅπαξ|$1-(άκ)ις}}.',
	'view-pool-error' => 'Αἱ ἐξυπηρετητικαὶ μηχαναὶ νῦν ὑπερπεφορτισμέναι εἰσίν.
Πέρα τοῦ δέοντος πολλοὶ χρώμενοι πειρῶνται προσπελάσειν τῇδε δέλτῳ.
Ἀνάμεινον πρὸ τοῦ πεπειρακέναι προσπελάσειν πάλιν τῇδε δέλτῳ.

$1',
	'versionrequired' => 'Ἔκδοσις $1 τῆς MediaWiki ἀπαιτεῖται',
	'versionrequiredtext' => 'Ἡ ἔκδοσις $1 τῆς MediaWiki ἀναγκαία ἐστὶ τῷ χρῆσθαι τῇδε τῇ δέλτῳ.
Ἴδε [[Special:Version|τὴν δέλτον ἐκδόσεως]].',
	'viewsourceold' => 'ὁρᾶν πηγήν',
	'viewsourcelink' => 'ὁρᾶν τὴν πηγήν',
	'viewdeleted' => 'Ὁρᾶν $1;',
	'viewsource' => 'Πηγὴν ἐπισκοπεῖν',
	'viewsourcefor' => 'διὰ τὸ $1',
	'viewsourcetext' => 'Ἔξεστί σοι ὁρᾶν τε καὶ ἀντιγράφειν τὴν τῆς δέλτου πηγήν:',
	'virus-badscanner' => "Κακὸς σχηματισμός: ἄγνωτος σαρωτὴς ἰῶν: ''$1''",
	'virus-scanfailed' => 'Σάρωσις πταιστή (κῶδιξ $1)',
	'virus-unknownscanner' => 'ἄγνωτος ἀντιιός:',
	'viewpagelogs' => 'Ὁρᾶν καταλόγους διὰ ταύτην τὴν δέλτον',
	'viewprevnext' => 'Ἐπισκοπεῖν ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Δεικνύναι διαγραφείσας δέλτους',
	'version' => 'Ἐπανόρθωμα',
	'version-extensions' => 'Ἐγκατεστημέναι ἐπεκτάσεις',
	'version-specialpages' => 'Εἰδικαὶ δέλτοι',
	'version-parserhooks' => 'Ἀγγύλαι λεξιαναλυτικοῦ προγράμματος',
	'version-variables' => 'Μεταβληταί',
	'version-other' => 'Ἄλλα',
	'version-mediahandlers' => 'Χειρισταὶ μέσων',
	'version-hooks' => 'Ἀγγύλαι',
	'version-extension-functions' => 'Ἐνέργειαι ἐπεκτάσεων',
	'version-parser-extensiontags' => 'Σἠμαντρα ἐπεκτάσεων λεξιαναλυτικοῦ προγράμματος',
	'version-parser-function-hooks' => 'Ἀγγύλαι ἐνεργειῶν λεξιαναλυτικοῦ προγράμματος',
	'version-skin-extension-functions' => 'Ἐνέργειαι ἐπεκτάσεων ἐπικαλύψεων',
	'version-hook-name' => 'Ὄνομα ἀγκύλης',
	'version-hook-subscribedby' => 'Ὑπογεγραφυῖα ὑπὸ',
	'version-version' => '(Ἔκδοσις $1)',
	'version-license' => 'Ἄδεια',
	'version-software' => 'Ἐγκατεστημένον λογισμικόν',
	'version-software-product' => 'Προϊόν',
	'version-software-version' => 'Ἔκδοσις',
);

$messages['gsw'] = array(
	'variants' => 'Variante',
	'view' => 'Aaluege',
	'viewdeleted_short' => '{{PLURAL:$1|ei gleschti Änderig|$1 gleschti Ändrige}} aaluege',
	'views' => 'Wievylmol agluegt',
	'viewcount' => 'Die Syte isch {{PLURAL:$1|eimol|$1 Mol}} bsuecht wore.',
	'view-pool-error' => 'Excusez, d Server sin zur Zyt iberlaschtet.
S versueche grad zvyl Benutzer die Syte aazluege.
Bitte wart e paar Minute, voreb Du s nomol versuechsch.

$1',
	'versionrequired' => 'Version $1 vun MediaWiki wird brucht',
	'versionrequiredtext' => 'Version $1 vu MediaWiki wird brucht zum die Syte nutze. Lueg [[Special:Version]]',
	'viewsourceold' => 'Quelltext azeige',
	'viewsourcelink' => 'Quälltäxt aaluege',
	'viewdeleted' => '$1 aaluege?',
	'viewsource' => 'Quelltext aaluege',
	'viewsourcetext' => 'Quelltext vo dere Syte:',
	'virus-badscanner' => "Fählerhafti Konfiguration: Virescanner, wu nid bekannt isch: ''$1''",
	'virus-scanfailed' => 'Scan het nid funktioniert (code $1)',
	'virus-unknownscanner' => 'Virescanner, wu nid bekannt isch:',
	'viewpagelogs' => 'Logbüecher für die Syten azeige',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) aazeige; ($3) uf ds Mal',
	'verification-error' => 'Die Datei het d Dateipriefig nit bstande.',
	'viewdeletedpage' => 'Gleschti Syte aazeige',
	'version' => 'Version',
	'version-extensions' => 'Installierti Erwyterige',
	'version-specialpages' => 'Spezialsyte',
	'version-parserhooks' => 'Parser-Schnittstelle',
	'version-variables' => 'Variable',
	'version-antispam' => 'Spamschutz',
	'version-skins' => 'Benutzeroberflechine',
	'version-other' => 'Anders',
	'version-mediahandlers' => 'Medie-Handler',
	'version-hooks' => "Schnittstelle ''(Hook)''",
	'version-extension-functions' => 'Funktionsufruef',
	'version-parser-extensiontags' => "Parser-Erwyterige ''(tags)''",
	'version-parser-function-hooks' => 'Parser-Funktione',
	'version-hook-name' => 'Schnittstellename',
	'version-hook-subscribedby' => 'Ufruef vu',
	'version-version' => '(Version $1)',
	'version-license' => 'Lizänz',
	'version-poweredby-credits' => "Die Websyte nutzt '''[//www.mediawiki.org/wiki/MediaWiki/de MediaWiki]''', Copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'anderi',
	'version-license-info' => 'MediaWiki isch e freji Software, d. h. s cha, no dr Bedingige vu dr GNU General Public-Lizänz, wu vu dr Free Software Foundation vereffentligt woren isch, wyterverteilt un/oder modifiziert wäre. Doderbyy cha d Version 2, oder no eigenem Ermässe, jedi nejeri Version vu dr Lizänz brucht wäre.

Des Programm wird in dr Hoffnig verteilt, ass es nitzli isch, aber OHNI JEDI GARANTI un sogar ohni di impliziert Garanti vun ere MÄRTGÄNGIGKEIT oder EIGNIG FIR E BSTIMMTE ZWÄCK. Doderzue git meh Hiiwys in dr GNU General Public-Lizänz.

E [{{SERVER}}{{SCRIPTPATH}}/COPYING Kopi vu dr GNU General Public-Lizänz] sott zämme mit däm Programm verteilt wore syy. Wänn des nit eso isch, cha ne Kopi bi dr Free Software Foundation Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA, schriftli aagforderet oder [//www.gnu.org/licenses/old-licenses/gpl-2.0.html online gläse] wäre.',
	'version-software' => 'Installierti Software',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Version',
);

$messages['gu'] = array(
	'variants' => 'ભિન્ન રૂપો',
	'view' => 'જુઓ',
	'viewdeleted_short' => '{{PLURAL:$1|ભૂંસી નાખેલો એક|ભૂંસી નાખેલા $1}} ફેરફાર જુઓ',
	'views' => 'દેખાવ',
	'viewcount' => 'આ પાનું {{PLURAL:$1|એક|$1}} વખત જોવામાં આવ્યું છે.',
	'view-pool-error' => 'માફ કરશો, આ સમયે સર્વર અતિબોજા હેઠળ છે.

ઘણા બધા વપરાશકર્તાઓ આ પાનું જોવાની કોશિશ કરી રહ્યા છે.

આ પાનું ફરી જોતા પહેલાં કૃપયા થોડો સમય પ્રતિક્ષા કરો.

$1',
	'versionrequired' => 'મીડીયાવિકિનું $1 સંસ્કરણ જરૂરી',
	'versionrequiredtext' => 'આ પાનાના વપરાશ માટે મીડિયાવિકિનું $1 સંસ્કરણ જરૂરી.

જુઓ [[Special:Version|સંસ્કરણ પાનું]].',
	'viewsourceold' => 'સ્રોત જુઓ',
	'viewsourcelink' => 'સ્રોત જુઓ.',
	'viewdeleted' => '$1 જોવું છે?',
	'viewsource' => 'સ્ત્રોત જુઓ',
	'viewsource-title' => '$1 માટે સ્ત્રોત જુવઑ',
	'viewsourcetext' => 'આપ આ પાનાનો મૂળ સ્ત્રોત નિહાળી શકો છો અને તેની નકલ (copy) પણ કરી શકો છો:',
	'viewyourtext' => "તમે જોવા અને''સ્ત્રોત નકલ કરી શકો છો  પર તમારા સંપાદનો'''આ પાનાં નઆ",
	'virus-badscanner' => "ખરાબ રૂપરેખા: અજાણ્યું વાઇરસ સ્કેનર: ''$1''",
	'virus-scanfailed' => 'સ્કેન અસફળ (code $1)',
	'virus-unknownscanner' => 'અજાણ્યું એન્ટીવાઇરસ:',
	'viewpagelogs' => 'આ પાનાનાં લૉગ જુઓ',
	'viewprevnext' => 'જુઓ: ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'આ ફાઇલ એ ચકાસણી કસોટી પાર ન કરી',
	'viewdeletedpage' => 'ભૂંસેલા પાના બતાવો',
	'version' => 'આવૃત્તિ',
	'version-extensions' => 'પ્રસ્થાપિત વિસ્તારકો',
	'version-specialpages' => 'ખાસ પાનાં',
	'version-parserhooks' => 'પદચ્છેદ ખૂંટો',
	'version-variables' => 'સહગુણકો',
	'version-antispam' => 'સ્પેમ સંરક્ષણ',
	'version-skins' => 'ફલક',
	'version-other' => 'અન્ય',
	'version-mediahandlers' => 'દ્રશ્યશ્રાવ્ય માધ્યમના ધારક',
	'version-hooks' => 'ખૂંટા',
	'version-extension-functions' => 'વિસ્તારક કાર્ય',
	'version-parser-extensiontags' => 'પદચ્ચેદ વિસ્તારક નાકા',
	'version-parser-function-hooks' => 'પદચ્છેદ કાર્ય ખૂંટા',
	'version-hook-name' => 'ખૂંટાનું નામ્',
	'version-hook-subscribedby' => 'દ્વ્રારા લાભાન્વીત',
	'version-version' => '(આવૃત્તિ $1)',
	'version-license' => 'પરવાનો',
	'version-poweredby-credits' => "આ વિકિ  '''[//www.mediawiki.org/ MediaWiki]''' દ્વારા ચાલે છે, પ્રકાશનાધિકાર © 2001-$1 $2.",
	'version-poweredby-others' => 'અન્યો',
	'version-license-info' => 'મિડિયાવિકિ એક મુક્ત સોફ્ટવેર છે. તમે તેનું પુનઃવિતરણ કરી શકો છો અને/અથવા તેને the Free Software Foundation દ્વારા પ્રકાશિત  GNU General Public License હેઠળ તેના સંસ્કરણ 2 ને કે તે પછીના સંસ્કરણ   મઠારી શકો છો .

મિડિયા વિકિ ને તે આશાથી વિતરીત કરાયું છે કે તે લોકોને ઉપયોગિ થશે કોઇ વોરેંટી વિના અથવા કોઇ કાર્ય સંબધી વેચાણકે તેની યોગ્યતા બદ્દલ ખાત્રી સિવાય. વધારે  માહિતે માટે GNU General Public Licens જુઓ.

આ પ્રોગ્રામ સાથે તમને  [{{SERVER}}{{SCRIPTPATH}}/COPYING a copy of the GNU General Public License]ની કૉપી મળી હશે. જો ન મલી હોય તો અહીં લખશો the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA કે  [//www.gnu.org/licenses/old-licenses/gpl-2.0.html ઓનલાઇન વાંચો ].',
	'version-software' => 'બેસાડેલા સોફ્ટવેર',
	'version-software-product' => 'ઉત્પાદ',
	'version-software-version' => 'આવૃત્તિ',
);

$messages['gv'] = array(
	'views' => 'Reayrtyn',
	'viewsourceold' => 'jeeagh er bun',
	'viewsourcelink' => 'jeeagh er bun',
	'viewdeleted' => 'Jeeagh er $1?',
	'viewsource' => 'Jeeagh er bun',
	'viewsourcefor' => 'dy $1',
	'viewsourcetext' => 'Foddee oo jeeagh as jean aascreeuyn er bun ny duillag shoh:',
	'viewpagelogs' => 'Jeeagh er lioaryn cooishyn ny duillag shoh',
	'viewprevnext' => 'Jeeagh er ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Jeeagh er duillagyn scrysst',
	'version' => 'Lhieggan',
	'version-specialpages' => 'Duillagyn er lheh',
	'version-other' => 'Elley',
	'version-version' => '(Lhieggan $1)',
	'version-license' => 'Kiedoonys',
	'version-software-version' => 'Lhieggan',
);

$messages['ha'] = array(
	'views' => 'Hange',
	'viewsourcelink' => 'duba tushe',
	'viewsource' => 'Duba tushe',
	'viewpagelogs' => 'Duba rajistan ayyukan wannan shafi',
	'viewprevnext' => 'Duba ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['hak'] = array(
	'views' => 'Kiám-sṳ',
	'viewcount' => 'Pún-chông yí-kîn pûn-ngìn khon-kien $1-chhṳ.',
	'versionrequired' => 'Sî-yeu MediaWiki $1-pán',
	'versionrequiredtext' => 'Sî-yeu pán-pún $1-ke MediaWiki chhòi-nèn sṳ́-yung chhṳ́-chông. Chhâm-cheu [[Special:Version|Pán-pún]].',
	'viewsourceold' => 'Tshà-khon Kîn-ngièn',
	'viewsourcelink' => 'tshà-khon kîn-ngièn',
	'viewdeleted' => 'Kiám-sṳ $1?',
	'viewsource' => 'Ngièn-sṳ́-tóng',
	'viewsourcetext' => 'Ngì khó-yî chhà-khon pin fuk-chṳ pún vùn-chông ke kîn-ngièn.',
	'virus-unknownscanner' => 'vù-tî ke fòng phiang-thu̍k:',
	'viewpagelogs' => 'Chhà-khon liá-ke vùn-chông ke ngit-ki.',
	'viewprevnext' => 'Kiám-sṳ ($1)  ($2)  ($3).',
	'viewdeletedpage' => 'Kiám-sṳ pûn chhù-thet ke vùn-chông',
	'version' => 'Pán-pún',
);

$messages['haw'] = array(
	'view' => 'Nānā',
	'views' => 'Nā nānaina',
	'viewsourceold' => 'nānā i ke kumu kanawai',
	'viewsourcelink' => 'nānā i ka molekumu',
	'viewdeleted' => 'Nānā i $1?',
	'viewsource' => 'E nānā i ka molekumu',
	'viewprevnext' => 'Nānā i nā ($1 {{int:pipe-separator}} $2) ($3)',
	'version-specialpages' => 'Nā ‘ao‘ao kūikawā',
);

$messages['he'] = array(
	'variants' => 'גרסאות שפה',
	'view' => 'צפייה',
	'viewdeleted_short' => 'צפייה ב{{PLURAL:$1|עריכה מחוקה אחת|־$1 עריכות מחוקות}}',
	'views' => 'צפיות',
	'viewcount' => 'דף זה נצפה {{PLURAL:$1|פעם אחת|$1 פעמים|פעמיים}}.',
	'view-pool-error' => 'מצטערים, השרתים עמוסים כרגע.
יותר מדי משתמשים מנסים לצפות בדף זה.
אנא המתינו זמן מה לפני שתנסו שוב לצפות בדף.

$1',
	'versionrequired' => 'נדרשת גרסה $1 של מדיה־ויקי',
	'versionrequiredtext' => 'גרסה $1 של מדיה־ויקי נדרשת לשימוש בדף זה. למידע נוסף, ראו את [[Special:Version|דף הגרסה]].',
	'viewsourceold' => 'הצגת מקור',
	'viewsourcelink' => 'הצגת מקור',
	'viewdeleted' => 'להציג $1?',
	'viewsource' => 'הצגת מקור',
	'viewsource-title' => 'הצגת המקור של $1',
	'viewsourcetext' => 'באפשרותכם לצפות בטקסט המקור של הדף ולהעתיקו:',
	'viewyourtext' => "באפשרותכם לצפות בטקסט המקור של '''העריכות שלכם''' של הדף ולהעתיקו:",
	'virus-badscanner' => "הגדרות שגויות: סורק הווירוסים אינו ידוע: ''$1''",
	'virus-scanfailed' => 'הסריקה נכשלה (קוד: $1)',
	'virus-unknownscanner' => 'אנטי־וירוס בלתי ידוע:',
	'viewpagelogs' => 'הצגת יומנים עבור דף זה',
	'viewprevnext' => 'צפייה ב: ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'קובץ זה לא עבר את תהליך אימות הקבצים',
	'viewdeletedpage' => 'הצגה של דפים מחוקים',
	'version' => 'גרסת התוכנה',
	'version-extensions' => 'הרחבות מותקנות',
	'version-specialpages' => 'דפים מיוחדים',
	'version-parserhooks' => 'הרחבות מפענח',
	'version-variables' => 'משתנים',
	'version-antispam' => 'מניעת ספאם',
	'version-skins' => 'עיצובים',
	'version-other' => 'אחר',
	'version-mediahandlers' => 'מציגי מדיה',
	'version-hooks' => 'מבני Hook',
	'version-extension-functions' => 'פונקציות של הרחבות',
	'version-parser-extensiontags' => 'תגיות של הרחבות מפענח',
	'version-parser-function-hooks' => 'משתנים',
	'version-hook-name' => 'שם ה־Hook',
	'version-hook-subscribedby' => 'הפונקציה הרושמת',
	'version-version' => '(גרסה $1)',
	'version-license' => 'רישיון',
	'version-poweredby-credits' => "אתר הוויקי הזה מופעל על ידי '''[//www.mediawiki.org/ מדיה־ויקי]''', © 2001–$1 $2.",
	'version-poweredby-others' => '[{{SERVER}}{{SCRIPTPATH}}/CREDITS אחרים]',
	'version-license-info' => "מדיה־ויקי היא תוכנה חופשית; באפשרותכם להפיץ אותה מחדש ו/או לשנות אותה לפי תנאי הרישיון הציבורי הכללי של גנו המפורסם על ידי המוסד לתוכנה חופשית: גרסה 2 של רישיון זה, או (לפי בחירתכם) כל גרסה מאוחרת יותר.

מדיה־ויקי מופצת בתקווה שהיא תהיה שימושית, אך '''ללא כל הבטחה לאחריות'''; אפילו לא אחריות משתמעת של '''יכולת להיסחר''' או '''התאמה למטרה מסוימת'''. ראו את הרישיון הציבורי הכללי של גנו לפרטים נוספים.

הייתם אמורים לקבל [{{SERVER}}{{SCRIPTPATH}}/COPYING העתק של הרישיון הציבורי הכללי של גנו] יחד עם תוכנה זו; אם לא, כִתבו למוסד לתוכנה חופשית: Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA או [//www.gnu.org/licenses/old-licenses/gpl-2.0.html קִראו אותו ברשת].",
	'version-software' => 'תוכנות מותקנות',
	'version-software-product' => 'תוכנה',
	'version-software-version' => 'גרסה',
	'version-entrypoints' => 'כתובות של נקודות כניסה',
	'version-entrypoints-header-entrypoint' => 'נקודת כניסה',
	'version-entrypoints-header-url' => 'כתובת',
);

$messages['hi'] = array(
	'variants' => 'संस्करण',
	'views' => 'दर्शाव',
	'viewcount' => 'यह पृष्ठ {{PLURAL:$1|एक|$1}} बार देखा गया है',
	'view-pool-error' => 'मुआफ़ करें, इस समय सेवकों पर बहुत भार चढ़ा हुआ है।
बहुत सारे लोग इस पन्ने को देखने की कोशिश कर रहे हैं।
कुछ समय इंतज़ार कर के फिर से इस पन्ने तक जाने की कोशिश करें।

$1',
	'versionrequired' => 'मीडीयाविकिका $1 अवतरण ज़रूरी हैं ।',
	'versionrequiredtext' => 'यह पन्ना इस्तेमाल करने के लिये मीडियाविकीका $1 अवतरण ज़रूरी हैं । देखें [[Special:Version|अवतरण सूची]] ।',
	'viewsourceold' => 'स्रोत देखें',
	'viewsourcelink' => 'स्रोत देखें',
	'viewdeleted' => '$1 दिखायें?',
	'viewsource' => 'स्रोत देखें',
	'viewsourcefor' => '$1 के लिये',
	'viewsourcetext' => 'आप इस पन्ने का स्रोत देख सकते हैं और उसकी नकल उतार सकतें हैं:',
	'virus-badscanner' => "गलत जमाव: अज्ञात विषाणु जाँचक: ''$1''",
	'virus-scanfailed' => 'जाँच विफल (कूट $1)',
	'virus-unknownscanner' => 'अज्ञात विषाणुनाशक:',
	'viewpagelogs' => 'इस पन्नेका लॉग देखियें',
	'viewprevnext' => 'देख़ें ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'हटायें गयें लेख देखें',
	'version' => 'रूपान्तर',
	'version-extensions' => 'इन्स्टॉल की हुई एक्स्टेंशन',
	'version-specialpages' => 'विशेष पन्ने',
	'version-parserhooks' => 'पार्सर हूक',
	'version-variables' => 'वेरिएबल',
	'version-other' => 'अन्य',
	'version-mediahandlers' => 'मीडिया हॅंडलर',
	'version-hooks' => 'हूक',
	'version-extension-functions' => 'एक्सटेंशन कार्य',
	'version-parser-extensiontags' => 'पार्सर एक्स्टेंशन टैग',
	'version-parser-function-hooks' => 'पार्सर कार्य हूक',
	'version-skin-extension-functions' => 'त्वचा एक्स्टेंशन क्रिया',
	'version-hook-name' => 'हूक नाम',
	'version-hook-subscribedby' => 'ने सदस्यत्व लिया',
	'version-version' => '(अवतरण $1)',
	'version-license' => 'लाइसेन्स',
	'version-software' => 'इन्स्टॉल की हुई प्रणाली',
	'version-software-product' => 'प्रोडक्ट',
	'version-software-version' => 'अवतरण',
);

$messages['hif'] = array(
	'variants' => 'संस्करण',
	'views' => 'दर्शाव',
	'viewcount' => 'यह पृष्ठ {{PLURAL:$1|एक|$1}} बार देखा गया है',
	'view-pool-error' => 'मुआफ़ करें, इस समय सेवकों पर बहुत भार चढ़ा हुआ है।
बहुत सारे लोग इस पन्ने को देखने की कोशिश कर रहे हैं।
कुछ समय इंतज़ार कर के फिर से इस पन्ने तक जाने की कोशिश करें।

$1',
	'versionrequired' => 'मीडीयाविकिका $1 अवतरण ज़रूरी हैं ।',
	'versionrequiredtext' => 'यह पन्ना इस्तेमाल करने के लिये मीडियाविकीका $1 अवतरण ज़रूरी हैं । देखें [[Special:Version|अवतरण सूची]] ।',
	'viewsourceold' => 'स्रोत देखें',
	'viewsourcelink' => 'स्रोत देखें',
	'viewdeleted' => '$1 दिखायें?',
	'viewsource' => 'स्रोत देखें',
	'viewsourcefor' => '$1 के लिये',
	'viewsourcetext' => 'आप इस पन्ने का स्रोत देख सकते हैं और उसकी नकल उतार सकतें हैं:',
	'virus-badscanner' => "गलत जमाव: अज्ञात विषाणु जाँचक: ''$1''",
	'virus-scanfailed' => 'जाँच विफल (कूट $1)',
	'virus-unknownscanner' => 'अज्ञात विषाणुनाशक:',
	'viewpagelogs' => 'इस पन्नेका लॉग देखियें',
	'viewprevnext' => 'देख़ें ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'हटायें गयें लेख देखें',
	'version' => 'रूपान्तर',
	'version-extensions' => 'इन्स्टॉल की हुई एक्स्टेंशन',
	'version-specialpages' => 'विशेष पन्ने',
	'version-parserhooks' => 'पार्सर हूक',
	'version-variables' => 'वेरिएबल',
	'version-other' => 'अन्य',
	'version-mediahandlers' => 'मीडिया हॅंडलर',
	'version-hooks' => 'हूक',
	'version-extension-functions' => 'एक्सटेंशन कार्य',
	'version-parser-extensiontags' => 'पार्सर एक्स्टेंशन टैग',
	'version-parser-function-hooks' => 'पार्सर कार्य हूक',
	'version-skin-extension-functions' => 'त्वचा एक्स्टेंशन क्रिया',
	'version-hook-name' => 'हूक नाम',
	'version-hook-subscribedby' => 'ने सदस्यत्व लिया',
	'version-version' => '(अवतरण $1)',
	'version-license' => 'लाइसेन्स',
	'version-software' => 'इन्स्टॉल की हुई प्रणाली',
	'version-software-product' => 'प्रोडक्ट',
	'version-software-version' => 'अवतरण',
);

$messages['hif-latn'] = array(
	'variants' => 'Antar',
	'views' => 'Bichar',
	'viewcount' => 'Ii panna ke {{PLURAL:$1|ek dafe|$1 dafe}} dekha gais hai.',
	'view-pool-error' => 'Maaf karna, abhi sab server busy hae.
Bahut dher sadasya ii panna ke dekhe maange hae.
Meharbani kar ke, thora deri sabur kar ke ii panna ke fir se kholo.

$1',
	'versionrequired' => 'MediaWiki ke $1 version ke jaruri hai',
	'versionrequiredtext' => 'Ii panna use kare ke khatir MediaWiki ke Version $1 ke jaruri hai. [[Special:Version|version page]] ke dekho.',
	'viewsourceold' => 'source dekho',
	'viewsourcelink' => 'source dekho',
	'viewdeleted' => '$1 ke dekho?',
	'viewsource' => 'Source dekho',
	'viewsourcefor' => '$1 khatir',
	'viewsourcetext' => 'Aap ii panna ke source ke dekhe aur nakal utare kare sakta hai:',
	'virus-badscanner' => "Kharaab ruup dewa gais hae: virus khoje waala software nawaa hae: ''$1''",
	'virus-scanfailed' => 'scan fail hoe gais (code $1)',
	'virus-unknownscanner' => 'jaana waala antivirus nai hai:',
	'viewpagelogs' => 'Ii panna ke suchi dekho',
	'viewprevnext' => 'Dekho ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Mitawa gais panna ke dekho',
	'version' => 'Badlao',
	'version-specialpages' => 'Khaas panna',
	'version-other' => 'Duusra',
);

$messages['hil'] = array(
	'variants' => 'Mga nagkalain-lain',
	'view' => 'Lantawon',
	'viewdeleted_short' => 'Lantawon ang {{PLURAL:$1|isa ka ginpanas nga pag-ilis|$1 ka ginpanas nga pag-ilis}}',
	'views' => 'Mga talanawon',
	'viewcount' => 'Ang ini nga panid ginsudlan sang {{PLURAL:$1|maka-isa|ika-$1 nga beses}}.',
	'view-pool-error' => 'Nagapangayo kami sang pasaylo kay ang mga server tuman ka loaded sa sini nga tion.
Tuman ka damo nga manuggamit ang luyag makakita sang sini nga panid.
Palihog maghulat sang malip-ot nga tini-on bag-o magsulod sa sini nga pahina liwat.

$1',
	'versionrequired' => 'Ang ika-$1 nga bersiyon sang MediaWiki ang kinahanglan',
	'versionrequiredtext' => 'Ang ika-$1 nga bersiyon sang MediaWiki ang kinahanglan agod makita ang ini nga panid.
Lantawa ang [[Special:Version|panid sang mga bersiyon]].',
	'viewsourceold' => 'lantawon ang ginhalinan',
	'viewsourcelink' => 'tan-awon ang ginhalinan',
	'viewdeleted' => 'Tan-awon $1?',
	'viewsource' => 'Lantawon ang ginhalinan',
	'viewsourcetext' => 'Mahimo mo nga makita kag makopya ang ginhalinan sang sini nga panid:',
	'virus-badscanner' => "Malain nga konpigurasyon: wala makilal-an nga manuglantaw sang virus: ''$1''",
	'virus-scanfailed' => 'ang pagpangita indi madinalag-on (koda $1)',
	'virus-unknownscanner' => 'wala makilal-an nga kontra-virus:',
	'viewpagelogs' => 'Tan-awon ang mga log para sa sini nga pahina',
	'viewprevnext' => 'Tan-awon ($1 {{int:pipe-separator}} $2) ($3)',
	'version-specialpages' => 'Pinasahi nga mga panid',
);

$messages['hr'] = array(
	'variants' => 'Inačice',
	'view' => 'Vidi',
	'viewdeleted_short' => 'Prikaži $1 {{plural: $1|izbrisano uređivanje|izbrisana uređivanja|izbrisanih uređivanja}}',
	'views' => 'Pogledi',
	'viewcount' => 'Ova stranica je pogledana {{PLURAL:$1|$1 put|$1 puta}}.',
	'view-pool-error' => 'Ispričavamo se, poslužitelji su trenutačno preopterećeni.
Previše suradnika pokušava vidjeti ovu stranicu.
Molimo malo pričekajte  prije nego što opet pokušate pristupiti ovoj stranici.

$1',
	'versionrequired' => 'Potrebna inačica $1 MediaWikija',
	'versionrequiredtext' => 'Za korištenje ove stranice potrebna je inačica $1 MediaWiki softvera. Pogledaj [[Special:Version|inačice]]',
	'viewsourceold' => 'vidi izvor',
	'viewsourcelink' => 'vidi izvornik',
	'viewdeleted' => 'Vidi $1?',
	'viewsource' => 'Vidi izvornik',
	'viewsource-title' => 'Vidi kôd stranice $1',
	'viewsourcetext' => 'Možete pogledati i kopirati izvorni sadržaj ove stranice:',
	'viewyourtext' => "Možete vidjeti i kopirati tekst '''vaših uređivanja''' na ovoj stranici:",
	'virus-badscanner' => "Loša konfiguracija: nepoznati skener za viruse: ''$1''",
	'virus-scanfailed' => 'skeniranje neuspješno (kod $1)',
	'virus-unknownscanner' => 'nepoznati antivirus:',
	'viewpagelogs' => 'Vidi evidencije za ovu stranicu',
	'viewprevnext' => 'Vidi ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Ova datoteka nije prošla provjeru datoteke.',
	'viewdeletedpage' => 'Pogledaj izbrisanu stranicu',
	'variantname-sr-ec' => 'ћирилица',
	'variantname-sr-el' => 'latinica',
	'version' => 'Inačica softvera',
	'version-extensions' => 'Instalirana proširenja',
	'version-specialpages' => 'Posebne stranice',
	'version-parserhooks' => 'Kuke parsera',
	'version-variables' => 'Varijable',
	'version-antispam' => 'Sprječavanje spama',
	'version-skins' => 'Izgledi',
	'version-other' => 'Ostalo',
	'version-mediahandlers' => 'Rukovatelji medijima',
	'version-hooks' => 'Kuke',
	'version-extension-functions' => 'Funkcije proširenja',
	'version-parser-extensiontags' => 'Oznake proširenja parsera',
	'version-parser-function-hooks' => 'Kuke funkcija parsera',
	'version-hook-name' => 'Ime kuke',
	'version-hook-subscribedby' => 'Pretplaćeno od',
	'version-version' => '(Inačica $1)',
	'version-license' => 'Licencija',
	'version-poweredby-credits' => "Ovaj wiki pogoni '''[//www.mediawiki.org/ MediaWiki]''', autorska prava © 2001-$1 $2.",
	'version-poweredby-others' => 'ostali',
	'version-license-info' => 'MediaWiki je slobodni softver; možete ga distribuirati i/ili mijenjati pod uvjetima GNU opće javne licencije u obliku u kojem ju je objavila Free Software Foundation; bilo verzije 2 licencije, ili (Vama na izbor) bilo koje kasnije verzije.

MediaWiki je distribuiran u nadi da će biti koristan, no BEZ IKAKVOG JAMSTVA; čak i bez impliciranog jamstva MOGUĆNOSTI PRODAJE ili PRIKLADNOSTI ZA ODREĐENU NAMJENU. Pogledajte GNU opću javnu licenciju za više detalja.

Trebali ste primiti [{{SERVER}}{{SCRIPTPATH}}/COPYING kopiju GNU opće javne licencije] uz ovaj program; ako ne, pišite na Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA, ili je [//www.gnu.org/licenses/old-licenses/gpl-2.0.html pročitajte online].',
	'version-software' => 'Instalirani softver',
	'version-software-product' => 'Proizvod',
	'version-software-version' => 'Verzija',
);

$messages['hsb'] = array(
	'variants' => 'Warianty',
	'view' => 'Wobhladać',
	'viewdeleted_short' => '{{PLURAL:$1|jednu wušmórnjenu změnu|$1 wušmórnjenej změnje|$1 wušmórnjene změny|$1 wušmórnjenych změnow}} sej wobhladać',
	'views' => 'Zwobraznjenja',
	'viewcount' => 'Strona bu {{PLURAL:$1|jónu|dwójce|$1 razy|$1 razow}} wopytana.',
	'view-pool-error' => 'Wodaj, serwery su we wokomiku přećežene.
Přewjele wužiwarjow pospytuje sej tutu stronu wobhladać.
Prošu wočakń chwilku, prjedy hač pospytuješ sej tutu stronu hišće raz wobhladać.

$1',
	'versionrequired' => 'Wersija $1 softwary MediaWiki trěbna',
	'versionrequiredtext' => 'Wersija $1 MediaWiki je trěbna, zo by so tuta strona wužiwać móhła. Hlej [[Special:Version|wersijowu stronu]]',
	'viewsourceold' => 'žórło wobhladać',
	'viewsourcelink' => 'žórło wobhladać',
	'viewdeleted' => '$1 pokazać?',
	'viewsource' => 'žórło wobhladać',
	'viewsource-title' => 'Žórłowy tekst za $1 sej wobhladać',
	'viewsourcetext' => 'Móžeš sej žórłowy tekst tuteje strony wobhladać a jón kopěrować:',
	'viewyourtext' => "Móžeš sej žórłowy tekst '''swojich změnow''' wobhladać a do slědowaceje strony kopěrować:",
	'virus-badscanner' => "Špatna konfiguracija: Njeznaty wirusowy skener: ''$1''",
	'virus-scanfailed' => 'Skenowanje njeporadźiło (kode $1)',
	'virus-unknownscanner' => 'njeznaty antiwirus:',
	'viewpagelogs' => 'protokole tuteje strony pokazać',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) pokazać',
	'verification-error' => 'Tuta dataja žane datajowe přepruwowanje njepřeběhny.',
	'viewdeletedpage' => 'Wušmórnjene strony wobhladać',
	'version' => 'Wersija',
	'version-extensions' => 'Instalowane rozšěrjenja',
	'version-specialpages' => 'Specialne strony',
	'version-parserhooks' => 'Parserowe hoki',
	'version-variables' => 'Wariable',
	'version-antispam' => 'Škit přećiwo spamej',
	'version-skins' => 'Šaty',
	'version-other' => 'Druhe',
	'version-mediahandlers' => 'Předźěłaki medijow',
	'version-hooks' => 'Hoki',
	'version-extension-functions' => 'Funkcije rozšěrjenjow',
	'version-parser-extensiontags' => "Parserowe rozšěrjenja ''(taflički)''",
	'version-parser-function-hooks' => 'Parserowe funkcije',
	'version-hook-name' => 'Mjeno hoki',
	'version-hook-subscribedby' => 'Abonowany wot',
	'version-version' => '(Wersija $1)',
	'version-license' => 'Licenca',
	'version-poweredby-credits' => "Tutón wiki so wot  '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2 podpěruje.",
	'version-poweredby-others' => 'druzy',
	'version-license-info' => 'MediaWiki je swobodna softwara: móžeš ju pod wuměnjenjemi licency GNU General Public License, wozjewjeneje wot załožby Free Software Foundation, rozdźělić a/abo změnić: pak pod wersiju 2 licency pak pod někajkej pozdźišej wersiju.

MediaWiki so w nadźiji rozdźěla, zo budźe wužitny, ale BJEZ GARANTIJU: samo bjez wobsahowaneje garantije PŘEDAWAJOMNOSĆE abo PŘIHÓDNOSĆE ZA WĚSTY ZAMĚR. Hlej GNU general Public License za dalše podrobnosće.

Ty měł [{{SERVER}}{{SCRIPTPATH}}/COPYING kopiju licency GNU General Public License] hromadźe z tutym programom dóstanu měć: jeli nic, napisaj do załožby Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA abo [//www.gnu.org/licenses/old-licenses/gpl-2.0.html přečitaj ju online].',
	'version-software' => 'Instalowana software',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Wersija',
);

$messages['ht'] = array(
	'variants' => 'Varyant yo',
	'view' => 'Gade',
	'viewdeleted_short' => 'Gade {{PLURAL:$1|yon modifikasyon ki te efase|$1 modifikasyon yo ki te efase}}',
	'views' => 'Afichay yo',
	'viewcount' => 'Paj sa te konsilte {{PLURAL:$1|yon fwa|$1 fwa}}.',
	'view-pool-error' => 'Padone nou, men sèvè yo genyen trop travay kounye a.
Genyen trop itilizatè k ap eseye gade paj sa.
Tanpri tann yon tikras tan anvan ou eseye gade paj sa ankò.

$1',
	'versionrequired' => 'Vèsion $1 de MediaWiki nesesè',
	'versionrequiredtext' => 'Vèzion $1 de MediaWiki nesesè pou itilize paj sa. Wè [[Special:Version|version page]].',
	'viewsourceold' => 'Wè kòd paj la',
	'viewsourcelink' => 'wè kòd paj la',
	'viewdeleted' => 'Wè $1 ?',
	'viewsource' => 'Wè kòd paj la',
	'viewsourcetext' => 'Ou kapab gade epitou modifye kontni atik sa a pou ou travay anlè li :',
	'virus-badscanner' => "Move konfigirasyon : eskanè viris sa, nou pa konenn l : ''$1''",
	'virus-scanfailed' => 'Rechèch an pa ritounen pyès rezilta (kòd $1)',
	'virus-unknownscanner' => 'antiviris nou pa konnen :',
	'viewpagelogs' => 'gade jounal paj sa a',
	'viewprevnext' => 'Wè ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'Vèsyon',
);

$messages['hu'] = array(
	'variants' => 'Változók',
	'view' => 'Olvasás',
	'viewdeleted_short' => '{{PLURAL:$1|Egy|$1}} törölt szerkesztés megtekintése',
	'views' => 'Nézetek',
	'viewcount' => 'Ezt a lapot {{PLURAL:$1|egy|$1}} alkalommal keresték fel.',
	'view-pool-error' => 'Sajnos a szerverek jelen pillanatban túl vannak terhelve, mert
túl sok felhasználó próbálta megtekinteni ezt az oldalt.
Kérjük, várj egy kicsit, mielőtt újrapróbálkoznál a lap megtekintésével!

$1',
	'versionrequired' => 'A MediaWiki $1-s verziója szükséges',
	'versionrequiredtext' => 'A lap használatához a MediaWiki $1-s verziójára van szükség.
További információkat a [[Special:Version|verzióinformációs lapon]] találhatsz.',
	'viewsourceold' => 'lapforrás',
	'viewsourcelink' => 'forráskód megtekintése',
	'viewdeleted' => '$1 megtekintése',
	'viewsource' => 'Lapforrás',
	'viewsource-title' => '$1 forrásának megtekintése',
	'viewsourcetext' => 'Megtekintheted és másolhatod a lap forrását:',
	'viewyourtext' => "Megtekintheted és kimásolhatod a '''saját szerkesztéseidet''' az alábbi lapra:",
	'virus-badscanner' => "Hibás beállítás: ismeretlen víruskereső: ''$1''",
	'virus-scanfailed' => 'az ellenőrzés nem sikerült (hibakód: $1)',
	'virus-unknownscanner' => 'ismeretlen antivírus:',
	'viewpagelogs' => 'A lap a rendszernaplókban',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Ez a fájl nem felelt meg az ellenőrzésen (hibás, rossz kiterjesztés, stb.).',
	'viewdeletedpage' => 'Törölt lapok megtekintése',
	'version' => 'Névjegy',
	'version-extensions' => 'Telepített kiterjesztések',
	'version-specialpages' => 'Speciális lapok',
	'version-parserhooks' => 'Értelmező hookok',
	'version-variables' => 'Változók',
	'version-antispam' => 'Spammegelőzés',
	'version-skins' => 'Felületek',
	'version-other' => 'Egyéb',
	'version-mediahandlers' => 'Médiafájl-kezelők',
	'version-hooks' => 'Hookok',
	'version-extension-functions' => 'A kiterjesztések függvényei',
	'version-parser-extensiontags' => 'Az értelmező kiterjesztéseinek tagjei',
	'version-parser-function-hooks' => 'Az értelmező függvényeinek hookjai',
	'version-hook-name' => 'Hook neve',
	'version-hook-subscribedby' => 'Használja',
	'version-version' => '(verzió: $1)',
	'version-license' => 'Licenc',
	'version-poweredby-credits' => "Ez a wiki '''[//www.mediawiki.org/ MediaWiki]''' szoftverrel működik, copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'mások',
	'version-license-info' => 'A MediaWiki szabad szoftver, terjeszthető és / vagy módosítható a GNU General Public License alatt, amit a Free Software Foundation közzétett; vagy a 2-es verziójú licenc, vagy (az Ön választása alapján) bármely későbbi verzió szerint.

A MediaWikit abban a reményben terjesztjük, hogy hasznos lesz, de GARANCIA NÉLKÜL, anélkül, hogy PIACKÉPES vagy HASZNÁLHATÓ LENNE EGY ADOTT CÉLRA. Lásd a GNU General Public License-t a további részletekért.

Önnek kapnia kellett [{{SERVER}}{{SCRIPTPATH}}/COPYING egy példányt a GNU General Public License-ből] ezzel a programmal együtt, ha nem, írjon a Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA címre vagy [//www.gnu.org/licenses/old-licenses/gpl-2.0.html olvassa el online].',
	'version-software' => 'Telepített szoftverek',
	'version-software-product' => 'Termék',
	'version-software-version' => 'Verzió',
);

$messages['hy'] = array(
	'variants' => 'Տարբերակներ',
	'view' => 'Դիտել',
	'viewdeleted_short' => 'Դիտել {{PLURAL:$1|ջնջված խմբագրում}}',
	'views' => 'Դիտումները',
	'viewcount' => 'Այս էջին դիմել են {{PLURAL:$1|մեկ անգամ|$1 անգամ}}։',
	'view-pool-error' => 'Ներեցեք՝ սերվերները գերբեռնված են այս պահին։
Չափից շատ օգտվողներ փորձում են դիտել այս էջը։
Խնդրում ենք սպասել որոշ ժամանակ էջը դիտելու կրկին հայցում անելուց առաջ։

$1',
	'versionrequired' => 'Պահանջվում է MediaWiki ծրագրի $1 տարբերակը',
	'versionrequiredtext' => 'Այս էջի օգտագործման համար պահանջվում է MediaWiki ծրագրի $1 տարբերակը։ Տես [[Special:Version|տարբերակի էջը]]։',
	'viewsourceold' => 'դիտել ելատեքստը',
	'viewsourcelink' => 'դիտել ելատեքստը',
	'viewdeleted' => 'Դիտե՞լ $1։',
	'viewsource' => 'Դիտել ելատեքստը',
	'viewsourcetext' => 'Դուք կարող եք դիտել և պատճենել այս էջի ելատեքստը.',
	'virus-badscanner' => "Սխալ կարգավորւմ։ Անծանոթ վիրուսների զննիչ. ''$1''",
	'virus-scanfailed' => 'զննման սխալ (կոդ $1)',
	'virus-unknownscanner' => 'անծանոթ հակավիրուս.',
	'viewpagelogs' => 'Դիտել այս էջի տեղեկամատյանները',
	'viewprevnext' => 'Դիտել ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Դիտել ջնջված էջերը',
	'video-dims' => '$1, $2 × $3',
	'version' => 'MediaWiki տարբերակը',
);

$messages['ia'] = array(
	'variants' => 'Variantes',
	'view' => 'Leger',
	'viewdeleted_short' => 'Vider {{PLURAL:$1|un modification|$1 modificationes}} delite',
	'views' => 'Representationes',
	'viewcount' => 'Iste pagina ha essite visitate {{PLURAL:$1|un vice|$1 vices}}.',
	'view-pool-error' => 'Pardono, le servitores es supercargate in iste momento.
Troppo de usatores tenta vider iste pagina.
Per favor attende un momento ante que tu essaya acceder novemente a iste pagina.

$1',
	'versionrequired' => 'Version $1 de MediaWiki requirite',
	'versionrequiredtext' => 'Le version $1 de MediaWiki es requirite pro usar iste pagina. Vide [[Special:Version|le pagina de version]].',
	'viewsourceold' => 'vider codice-fonte',
	'viewsourcelink' => 'vider codice-fonte',
	'viewdeleted' => 'Vider $1?',
	'viewsource' => 'Vider codice-fonte',
	'viewsource-title' => 'Le texto fonte de $1',
	'viewsourcetext' => 'Tu pote vider e copiar le codice-fonte de iste pagina:',
	'viewyourtext' => "Tu pote vider e copiar le fonte de '''tu modificationes''' de iste pagina:",
	'virus-badscanner' => "Configuration incorrecte: programma antivirus non cognoscite: ''$1''",
	'virus-scanfailed' => 'scannamento fallite (codice $1)',
	'virus-unknownscanner' => 'antivirus non cognoscite:',
	'viewpagelogs' => 'Vider le entratas del registro pro iste pagina',
	'viewprevnext' => 'Vider ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Iste file non passava le verification de files',
	'viewdeletedpage' => 'Vider paginas delite',
	'version' => 'Version',
	'version-extensions' => 'Extensiones installate',
	'version-specialpages' => 'Paginas special',
	'version-parserhooks' => 'Uncinos del analysator syntactic',
	'version-variables' => 'Variabiles',
	'version-antispam' => 'Prevention de spam',
	'version-skins' => 'Apparentias',
	'version-other' => 'Altere',
	'version-mediahandlers' => 'Executores de media',
	'version-hooks' => 'Uncinos',
	'version-extension-functions' => 'Functiones de extensiones',
	'version-parser-extensiontags' => 'Etiquettas de extension del analysator syntactic',
	'version-parser-function-hooks' => 'Uncinos de functiones del analysator syntactic',
	'version-hook-name' => 'Nomine del uncino',
	'version-hook-subscribedby' => 'Subscribite per',
	'version-version' => '(Version $1)',
	'version-license' => 'Licentia',
	'version-poweredby-credits' => "Iste wiki es actionate per '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'alteres',
	'version-license-info' => 'MediaWiki es software libere; vos pote redistribuer lo e/o modificar lo sub le conditiones del Licentia Public General de GNU publicate per le Free Software Foundation; version 2 del Licentia, o (a vostre option) qualcunque version posterior.

Iste programma es distribuite in le sperantia que illo sia utile, ma SIN GARANTIA; sin mesmo le implicite garantia de COMMERCIALISATION o APTITUDE PRO UN PROPOSITO PARTICULAR. Vide le Licentia Public General de GNU pro plus detalios.

Vos deberea haber recipite [{{SERVER}}{{SCRIPTPATH}}/COPYING un exemplar del Licentia Public General de GNU] con iste programma; si non, scribe al Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA, o [//www.gnu.org/copyleft/gpl.html lege lo in linea].',
	'version-software' => 'Software installate',
	'version-software-product' => 'Producto',
	'version-software-version' => 'Version',
);

$messages['id'] = array(
	'variants' => 'Varian',
	'view' => 'Baca',
	'viewdeleted_short' => 'Lihat {{PLURAL:$1|satu suntingan|$1 suntingan}} yang dihapus',
	'views' => 'Tampilan',
	'viewcount' => 'Halaman ini telah diakses sebanyak {{PLURAL:$1|satu kali|$1 kali}}.<br />',
	'view-pool-error' => 'Maaf, peladen sedang sibuk pada saat ini.
Terlalu banyak pengguna berusaha melihat halaman ini.
Tunggu sebentar sebelum Anda mencoba lagi mengakses halaman ini.

$1',
	'versionrequired' => 'Dibutuhkan MediaWiki versi $1',
	'versionrequiredtext' => 'MediaWiki versi $1 dibutuhkan untuk menggunakan halaman ini. Lihat [[Special:Version|halaman versi]]',
	'viewsourceold' => 'lihat sumber',
	'viewsourcelink' => 'lihat sumber',
	'viewdeleted' => 'Lihat $1?',
	'viewsource' => 'Lihat sumber',
	'viewsource-title' => 'Lihat sumber $1',
	'viewsourcetext' => 'Anda dapat melihat atau menyalin sumber halaman ini:',
	'viewyourtext' => "Anda dapat melihat atau menyalin sumber dari '''suntingan Anda''' ke halaman ini:",
	'virus-badscanner' => "Kesalahan konfigurasi: pemindai virus tidak dikenal: ''$1''",
	'virus-scanfailed' => 'Pemindaian gagal (kode $1)',
	'virus-unknownscanner' => 'Antivirus tidak dikenal:',
	'viewpagelogs' => 'Lihat log halaman ini',
	'viewprevnext' => 'Lihat ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Berkas ini tidak lulus verifikasi.',
	'viewdeletedpage' => 'Lihat halaman yang telah dihapus',
	'version' => 'Versi',
	'version-extensions' => 'Ekstensi terinstal',
	'version-specialpages' => 'Halaman istimewa',
	'version-parserhooks' => 'Kait parser',
	'version-variables' => 'Variabel',
	'version-antispam' => 'Pencegahan spam',
	'version-skins' => 'Kulit',
	'version-other' => 'Lain-lain',
	'version-mediahandlers' => 'Penanganan media',
	'version-hooks' => 'Kait',
	'version-extension-functions' => 'Fungsi ekstensi',
	'version-parser-extensiontags' => 'Tag ekstensi parser',
	'version-parser-function-hooks' => 'Kait fungsi parser',
	'version-hook-name' => 'Nama kait',
	'version-hook-subscribedby' => 'Dilanggani oleh',
	'version-version' => '(Versi $1)',
	'version-license' => 'Lisensi',
	'version-poweredby-credits' => "Wiki ini didukung oleh '''[//www.mediawiki.org/ MediaWiki]''', hak cipta © 2001-$1 $2.",
	'version-poweredby-others' => 'lainnya',
	'version-license-info' => 'MediaWiki adalah perangkat lunak bebas; Anda diperbolehkan untuk mendistribusikan dan/atau memodfikasinya dengan persyaratan Lisensi Publik Umum GNU yang diterbitkan oleh Free Software Foundation; versi 2 atau terbaru.

MediaWiki didistribusikan dengan harapan dapat digunakan, tetapi TANPA JAMINAN APA PUN; tanpa jaminan PERDAGANGAN atau KECOCOKAN UNTUK TUJUAN TERTENTU. Lihat Lisensi Publik Umum GNU untuk informasi lebih lanjut.

Anda seharusnya telah menerima [{{SERVER}}{{SCRIPTPATH}}/COPYING salinan Lisensi Publik Umum GNU] bersama dengan program ini; jika tidak, kirim surat ke Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA atau [//www.gnu.org/licenses/old-licenses/gpl-2.0.html baca daring].',
	'version-software' => 'Perangkat lunak terinstal',
	'version-software-product' => 'Produk',
	'version-software-version' => 'Versi',
);

$messages['ie'] = array(
	'variants' => 'Variantes',
	'views' => 'Vistas',
	'viewcount' => 'Ti págine ha esset accesset {{PLURAL:$1|un vez|$1 vezes}}.',
	'view-pool-error' => 'It me dole que li servitores es totalmen cargat in li moment.
Anc mult usatores es provant vider ti págine.
Pleser atende un témpor quelc ante que vu prova accesser ti págine denov.

$1',
	'versionrequired' => 'Version $1 de MediaWiki exiget',
	'versionrequiredtext' => 'Version $1 de MediaWiki es exiget por usar ti págine.
Vider [[Special:Version|págine de version]].',
	'viewsourceold' => 'vider fonte',
	'viewsourcelink' => 'vider fonte',
	'viewdeleted' => 'Vider $1?',
	'viewsource' => 'Vider fonte',
	'viewsourcetext' => 'Vu posse vider e copiar li contenete de ti págine:',
	'virus-badscanner' => "Configuration maliciosi: virus desconosset examinat: ''$1''",
	'virus-scanfailed' => 'scandesion fallit (code $1)',
	'virus-unknownscanner' => 'antivírus desconosset:',
	'viewpagelogs' => 'Vider diariumes por ti págine',
	'viewprevnext' => 'Vider ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Ti file ne passat per li verification de file.',
	'viewdeletedpage' => 'Vider págines deletet',
	'video-dims' => '$1, $2×$3',
	'version' => 'Version',
	'version-extensions' => 'Extensiones installat',
	'version-specialpages' => 'Págines special',
	'version-parserhooks' => 'Croces analisatores',
	'version-variables' => 'Variabiles',
	'version-other' => 'Altri',
	'version-mediahandlers' => 'Manuettes de media',
	'version-hooks' => 'Croces',
	'version-extension-functions' => 'Functiones de extension',
	'version-parser-extensiontags' => 'Puntales de extension analisatores',
	'version-parser-function-hooks' => 'Croces de functiones analisatores',
	'version-hook-name' => 'Nómine de croc',
	'version-hook-subscribedby' => 'Subscrit per',
	'version-version' => '(Version $1)',
	'version-svn-revision' => '(r$2)',
	'version-license' => 'Licentie',
	'version-software' => 'Software installat',
	'version-software-product' => 'Producte',
	'version-software-version' => 'Version',
);

$messages['ig'] = array(
	'variants' => 'Nke ichè ichè',
	'view' => 'Zi',
	'viewdeleted_short' => 'Zi {{PLURAL:$1|orü otụ bakashịrị|orü $1 bakashịrị}}',
	'views' => 'Há hụrụ ya olé',
	'viewcount' => 'Ha banyere ihü nka na {{PLURAL:$1|otu|$1 mgbe ole}}.',
	'view-pool-error' => 'Ndó, ihe na enye juchàrà ejucha oge nka.
Madu kachạrạ ndi choro ihu ihü nka.
Biko chetukwa oge kà oruo mgbe I choro I banyé ihü nka ozor.

$1',
	'versionrequired' => 'MediaWiki nke $1 gi nọkwạ',
	'versionrequiredtext' => 'Ụdì $1 nke MediaWiki gi dị ma Í chȯrí ji ihüá.
Lé [[Special:Version|ụdì ihü]].',
	'viewsourceold' => 'zi mkpurụ',
	'viewsourcelink' => 'zi mkpurụ',
	'viewdeleted' => 'Lé $1?',
	'viewsource' => 'Zi mkpurụ',
	'viewsourcetext' => 'Í nwèríkí lé na Í jé mkpurụ ihüá:',
	'virus-badscanner' => "Ndose ojọ: amaghị ólélé obubu onyá: ''$1''",
	'virus-scanfailed' => 'ojëjë orunotụ dàrà (edemede $1)',
	'virus-unknownscanner' => 'amaghị obubu onyá:',
	'viewpagelogs' => 'Zi ndetu ncheta màkà ihü a',
	'viewprevnext' => 'Lé ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Ùdị',
	'version-specialpages' => 'Ihü mkpà',
	'version-other' => 'Nke ozor',
	'version-hooks' => 'Nyazo',
	'version-hook-name' => 'Áhà nyazo',
	'version-hook-subscribedby' => 'Dọkpụrụ shì',
	'version-version' => '(Ùdị $1)',
	'version-license' => 'Ákwúkwó íwú nke nkwé',
	'version-software-product' => 'Nfófụtá',
	'version-software-version' => 'Ùdị',
);

$messages['ike-cans'] = array(
	'variantname-ike-cans' => 'ᑎᑎᕋᐅᓯᖅ ᓄᑖᖅ',
	'variantname-ike-latn' => 'ilisautik',
	'variantname-iu' => 'disable',
);

$messages['ike-latn'] = array(
	'variantname-ike-cans' => 'ᑎᑎᕋᐅᓯᖅ ᓄᑖᖅ',
	'variantname-ike-latn' => 'ilisautik',
	'variantname-iu' => 'disable',
);

$messages['ilo'] = array(
	'variants' => 'Sab-sabali a pagsasao',
	'view' => 'Kitaen',
	'viewdeleted_short' => 'Kitaen {{PLURAL:$1|ti maysa a naikkat a naurnos|$1 digiti naikkat a naurnos}}',
	'views' => 'Dagiti pangkitaan',
	'viewcount' => 'Naserrekan daytoy a panid iti {{PLURAL:$1|naminsan|$1 a daras}}.',
	'view-pool-error' => 'Pasensian a, dagiti servers ket nadagsenan unay tattan.
Adu unay nga agar-aramat ti mangkitkita daytoy a panid.
Pangaasim nga aguray ka met sakbay a padasem ti mangkita daytoy a panid.

$1',
	'versionrequired' => 'Masapul ti bersion $1 ti MediaWiki',
	'versionrequiredtext' => 'Masapul ti bersion $1 ti MediaWiki tapno maaramat daytoy a panid. Kitaen ti [[Special:Version|panid ti bersion]].',
	'viewsourceold' => 'kitaen ti taudan',
	'viewsourcelink' => 'kitaen ti taudan',
	'viewdeleted' => 'Kitaen ti $1?',
	'viewsource' => 'Kitaen ti taudan',
	'viewsource-title' => 'Kitaen ti taudan iti $1',
	'viewsourcetext' => 'Mabalinmo a kitaen ken tuladen ti taudan daytoy a panid:',
	'viewyourtext' => "Mabalin mo a makita ken tuladen ti taudan dagiti '''inurnosmo''' ditoy a panid:",
	'virus-badscanner' => 'Madi di pianaka-aramidna: Di am-ammo a birus a panagscan: "$1"',
	'virus-scanfailed' => 'napaay ti panagscan (kodigo $1)',
	'virus-unknownscanner' => 'di am-ammo a pagpaksiat iti "birus":',
	'viewpagelogs' => 'Kitaen dagiti listaan para iti daytoy a panid',
	'viewprevnext' => 'Kitaen ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Daytoy a papeles ket saan a nakapasa ti pagsingkedan.',
	'viewdeletedpage' => 'Kitaen dagiti naikkat a pampanid',
	'version' => 'Bersion',
	'version-extensions' => 'Dagiti naikabil a pagpaatiddog',
	'version-specialpages' => 'Espesial a pampanid',
	'version-parserhooks' => 'Parser a kawit',
	'version-variables' => 'Sabsabali',
	'version-antispam' => 'Pawilan ti spam',
	'version-skins' => 'Dagiti Kudil',
	'version-other' => 'Sabali',
	'version-mediahandlers' => 'Agiggem kadagiti media',
	'version-hooks' => 'Dagiti kawit',
	'version-extension-functions' => 'Pagpaatiddog nga opisio',
	'version-parser-extensiontags' => 'Dagiti pagpaatiddog nga etiketa a parser',
	'version-parser-function-hooks' => 'Parser nga opisio a kawit',
	'version-hook-name' => 'Nagan ti kawit',
	'version-hook-subscribedby' => 'Umanamong ni',
	'version-version' => '(Bersion $1)',
	'version-license' => 'Lisensia',
	'version-poweredby-credits' => "Daytoy a wiki ket pinaandar ti '''[//www.mediawiki.org/ MediaWiki]''', karbengan a kopia © 2001-$1 $2.",
	'version-poweredby-others' => 'dadduma pay',
	'version-license-info' => 'Ti MediaWiki ket nawaya a software; maiwaras mo ken/wenno mabaliwam babaen ti banag iti GNU General Public License a naipablaak babaen ti Free Software Foundation; nupay iti bersion 2 iti Lisensia, wenno (ti panagpilim) ti  ania man a bersion.

Ti MediaWiki ket naiwarwaras nga addaan ti namnama a makatulong, ngem AWAN TI ANIA MAN A GARANTIA; nga awan pay ti naibagbaga a PANAKAILAKO wenno KALAINGAN NA ITI DAYTOY A PANGGEP. Kitaen ti GNU General Public License para kadagiti adu pay a salaysay.

Naka-awat ka kuman ti [{{SERVER}}{{SCRIPTPATH}}/COPYING kopia iti GNU General Public License] a nairaman iti daytoy a programa; no saan, agsurat ka idiay Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA wenno [//www.gnu.org/licenses/old-licenses/gpl-2.0.html basaem idiay online].',
	'version-software' => 'Naikabil a software',
	'version-software-product' => 'Produkto',
	'version-software-version' => 'Bersion',
);

$messages['inh'] = array(
	'variants' => 'Дошаламаш',
	'view' => 'БӀаргтассар',
	'viewdeleted_short' => 'БӀаргтасса {{PLURAL:$1|дӀадаьккха хувцам тӀа|$1 дӀадаьккха хувцамаш тӀа}}',
	'views' => 'БӀаргтассараш',
	'viewcount' => 'Укх оагӀув тӀа бӀаргтасса хиннад {{PLURAL:$1|цкъа|$1 шозза}}.',
	'versionrequired' => '$1 MediaWiki доржам эша',
	'versionrequiredtext' => 'Укх оагӀув бeлха MediaWiki доржамаш эша $1. Хьажа [[Special:Version|version page]].',
	'viewsourceold' => 'xьадоагӀа къайладоагӀа тӀа бӀаргтасса',
	'viewsourcelink' => 'xьадоагӀа къайладоагӀа тӀа бӀаргтасса',
	'viewdeleted' => '$1 бӀаргтасса?',
	'viewsource' => 'Тахкам',
	'viewpagelogs' => 'Укх оагӀува тептараш хокха',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) хьажа',
	'version' => 'Доржам',
	'version-specialpages' => 'ГIулакхий оагIувнаш',
	'version-version' => '(Доржам $1)',
	'version-software-version' => 'Доржам',
);

$messages['io'] = array(
	'variants' => 'Varianti',
	'views' => 'Apari',
	'viewcount' => 'Ica pagino acesesis {{PLURAL:$1|1 foyo|$1 foyi}}.',
	'versionrequired' => 'Versiono $1 di MediaWiki bezonata',
	'versionrequiredtext' => 'Versiono $1 di MediaWiki bezonesas por uzar ca pagino.
Videz [[Special:Version|versiono-pagino]].',
	'viewsourceold' => 'vidar fonto',
	'viewsourcelink' => 'vidar fonto',
	'viewdeleted' => 'Vidar $1?',
	'viewsource' => 'Vidar font-kodo',
	'viewsourcetext' => 'Vu povas vidar ed kopiar la fonto-kodexo di ta pagino:',
	'viewpagelogs' => 'Videz registrari por ca pagino',
	'viewprevnext' => 'Vidar ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'Versiono',
	'version-specialpages' => 'Specala pagini',
	'version-other' => 'Altra',
	'version-version' => '(Versiono $1)',
	'version-license' => 'Licenco',
	'version-software-product' => 'Produkturo',
	'version-software-version' => 'Versiono',
);

$messages['is'] = array(
	'variants' => 'Útgáfur',
	'view' => 'Skoða',
	'viewdeleted_short' => 'Skoða {{PLURAL:$1|eina eydda breytingu|$1 eyddar breytingar}}',
	'views' => 'Sýn',
	'viewcount' => 'Þessi síða hefur verið skoðuð {{PLURAL:$1|einu sinni|$1 sinnum}}.',
	'view-pool-error' => 'Því miður eru vefþjónarnir yfirhlaðnir í augnablikinu.
Of margir notendur eru að reyna að skoða þessa síðu.
Vinsamlegast bíddu í smástund áður en þú reynir að sækja þessa síðu aftur.

$1',
	'versionrequired' => 'Þarfnast úgáfu $1 af MediaWiki',
	'versionrequiredtext' => 'Útgáfa $1 af MediaWiki er þörf til að geta skoðað þessa síðu.
Sjá [[Special:Version|útgáfusíðuna]].',
	'viewsourceold' => 'skoða efni',
	'viewsourcelink' => 'skoða efni',
	'viewdeleted' => 'Skoða $1?',
	'viewsource' => 'Skoða efni',
	'viewsource-title' => 'Skoða efni $1',
	'viewsourcetext' => 'Þú getur skoðað og afritað kóða þessarar síðu:',
	'viewyourtext' => "Þú getur skoðað og afritað kóða '''breytinganna þinna''' yfir á þessa síðu:",
	'virus-badscanner' => "Slæm stilling: óþekktur veiruskannari: ''$1''",
	'virus-scanfailed' => 'skönnun mistókst (kóði $1)',
	'virus-unknownscanner' => 'óþekkt mótveira:',
	'viewpagelogs' => 'Sýna aðgerðir varðandi þessa síðu',
	'viewprevnext' => 'Skoða ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Þessi skrá stóðst ekki sannprófun.',
	'viewdeletedpage' => 'Skoða eyddar síður',
	'version' => 'Útgáfa',
	'version-extensions' => 'Uppsettar viðbætur',
	'version-specialpages' => 'Kerfissíður',
	'version-variables' => 'Breytur',
	'version-antispam' => 'Amapósts sía',
	'version-skins' => 'Þemu',
	'version-other' => 'Aðrar',
	'version-mediahandlers' => 'Rekill margmiðlunarskráa',
	'version-extension-functions' => 'Aðgerðir smáforrita',
	'version-parser-extensiontags' => 'Þáttuð smáforrita tög',
	'version-hook-subscribedby' => 'Í áskrift af',
	'version-version' => '(Útgáfa $1)',
	'version-license' => 'Leyfi',
	'version-poweredby-credits' => "Þessi wiki er knúin af '''[//www.mediawiki.org/ MediaWiki]''', höfundaréttur © 2001-$1 $2.",
	'version-poweredby-others' => 'aðrir',
	'version-license-info' => 'MediaWiki er frjáls hugbúnaður; þú mátt endurútgefa hann og/eða breyta honum undir GNU General Public leyfi eins og það er gefið út af Free Software stofnuninni, annaðhvort útgáfu 2 eða (að þínu mati) hvaða nýrri útgáfa sem er.

MediaWiki er útgefin í þeirri von að hann sé gagnlegur, en ÁN ALLRAR ÁBYRGÐAR; þar meðtalið er undanskilin ábyrgð við MARKAÐSETNINGU og að hugbúnaðurinn VIRKI Í ÁKVEÐNUM TILGANGI. Sjá GNU General Public leyfið fyrir frekari upplýsingar.

Þú ættir að hafa fengið [{{SERVER}}{{SCRIPTPATH}}/COPYING afrit af  GNU General Public leyfinu] með þessum hugbúnaði, en ef ekki, skrifaðu til Free Software stofnunarinnar, 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, Bandaríkjunum eða [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lestu það á netinu]',
	'version-software' => 'Uppsettur hugbúnaður',
	'version-software-product' => 'Vara',
	'version-software-version' => 'Útgáfa',
);

$messages['it'] = array(
	'variants' => 'Varianti',
	'view' => 'Visualizzare',
	'viewdeleted_short' => 'Vedi {{PLURAL:$1|una modifica cancellata|$1 modifiche cancellate}}',
	'views' => 'Visite',
	'viewcount' => 'Questa pagina è stata letta {{PLURAL:$1|una volta|$1 volte}}.',
	'view-pool-error' => 'In questo momento i server sono sovraccarichi.
Troppi utenti stanno tentando di visualizzare questa pagina.
Attendere qualche minuto prima di riprovare a caricare la pagina.

$1',
	'versionrequired' => 'Versione $1 di MediaWiki richiesta',
	'versionrequiredtext' => "Per usare questa pagina è necessario disporre della versione $1 del software MediaWiki. Vedi [[Special:Version|l'apposita pagina]].",
	'viewsourceold' => 'visualizza sorgente',
	'viewsourcelink' => 'visualizza sorgente',
	'viewdeleted' => 'Vedi $1?',
	'viewsource' => 'Visualizza sorgente',
	'viewsource-title' => 'Visualizza sorgente di $1',
	'viewsourcetext' => 'È possibile visualizzare e copiare il codice sorgente di questa pagina:',
	'viewyourtext' => "È possibile visualizzare e copiare il codice sorgente delle '''tue modifiche''' a questa pagina:",
	'virus-badscanner' => "Errore di configurazione: antivirus sconosciuto: ''$1''",
	'virus-scanfailed' => 'scansione fallita (codice $1)',
	'virus-unknownscanner' => 'antivirus sconosciuto:',
	'viewpagelogs' => 'Visualizza i log relativi a questa pagina.',
	'viewprevnext' => 'Vedi ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Questo file non ha superato la verifica.',
	'viewdeletedpage' => 'Visualizza le pagine cancellate',
	'version' => 'Versione',
	'version-extensions' => 'Estensioni installate',
	'version-specialpages' => 'Pagine speciali',
	'version-parserhooks' => 'Hook del parser',
	'version-variables' => 'Variabili',
	'version-antispam' => 'Prevenzione dello spam',
	'version-skins' => 'Skin',
	'version-other' => 'Altro',
	'version-mediahandlers' => 'Gestori di contenuti multimediali',
	'version-hooks' => 'Hook',
	'version-extension-functions' => 'Funzioni introdotte da estensioni',
	'version-parser-extensiontags' => 'Tag riconosciuti dal parser introdotti da estensioni',
	'version-parser-function-hooks' => 'Hook per funzioni del parser',
	'version-hook-name' => "Nome dell'hook",
	'version-hook-subscribedby' => 'Sottoscrizioni',
	'version-version' => '(Versione $1)',
	'version-license' => 'Licenza',
	'version-poweredby-credits' => "Questo wiki è realizzato con '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'altri',
	'version-license-info' => 'MediaWiki è un software libero; puoi redistribuirlo e/o modificarlo secondo i termini della GNU General Public License, come pubblicata dalla Free Software Foundation; o la versione 2 della Licenza o (a propria scelta) qualunque versione successiva.

MediaWiki è distribuito nella speranza che sia utile, ma SENZA ALCUNA GARANZIA; senza neppure la garanzia implicita di NEGOZIABILITÀ o di APPLICABILITÀ PER UN PARTICOLARE SCOPO. Si veda la GNU General Public License per maggiori dettagli.

Questo programma deve essere distribuito assieme ad [{{SERVER}}{{SCRIPTPATH}}/COPYING una copia della GNU General Public License]; in caso contrario, se ne può ottenere una scrivendo alla Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA oppure [//www.softwarelibero.it/gnudoc/gpl.it.txt leggerla in rete].',
	'version-software' => 'Software installato',
	'version-software-product' => 'Prodotto',
	'version-software-version' => 'Versione',
);

$messages['iu'] = array(
	'variants' => 'Varianti',
	'view' => 'Visualizzare',
	'viewdeleted_short' => 'Vedi {{PLURAL:$1|una modifica cancellata|$1 modifiche cancellate}}',
	'views' => 'Visite',
	'viewcount' => 'Questa pagina è stata letta {{PLURAL:$1|una volta|$1 volte}}.',
	'view-pool-error' => 'In questo momento i server sono sovraccarichi.
Troppi utenti stanno tentando di visualizzare questa pagina.
Attendere qualche minuto prima di riprovare a caricare la pagina.

$1',
	'versionrequired' => 'Versione $1 di MediaWiki richiesta',
	'versionrequiredtext' => "Per usare questa pagina è necessario disporre della versione $1 del software MediaWiki. Vedi [[Special:Version|l'apposita pagina]].",
	'viewsourceold' => 'visualizza sorgente',
	'viewsourcelink' => 'visualizza sorgente',
	'viewdeleted' => 'Vedi $1?',
	'viewsource' => 'Visualizza sorgente',
	'viewsource-title' => 'Visualizza sorgente di $1',
	'viewsourcetext' => 'È possibile visualizzare e copiare il codice sorgente di questa pagina:',
	'viewyourtext' => "È possibile visualizzare e copiare il codice sorgente delle '''tue modifiche''' a questa pagina:",
	'virus-badscanner' => "Errore di configurazione: antivirus sconosciuto: ''$1''",
	'virus-scanfailed' => 'scansione fallita (codice $1)',
	'virus-unknownscanner' => 'antivirus sconosciuto:',
	'viewpagelogs' => 'Visualizza i log relativi a questa pagina.',
	'viewprevnext' => 'Vedi ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Questo file non ha superato la verifica.',
	'viewdeletedpage' => 'Visualizza le pagine cancellate',
	'version' => 'Versione',
	'version-extensions' => 'Estensioni installate',
	'version-specialpages' => 'Pagine speciali',
	'version-parserhooks' => 'Hook del parser',
	'version-variables' => 'Variabili',
	'version-antispam' => 'Prevenzione dello spam',
	'version-skins' => 'Skin',
	'version-other' => 'Altro',
	'version-mediahandlers' => 'Gestori di contenuti multimediali',
	'version-hooks' => 'Hook',
	'version-extension-functions' => 'Funzioni introdotte da estensioni',
	'version-parser-extensiontags' => 'Tag riconosciuti dal parser introdotti da estensioni',
	'version-parser-function-hooks' => 'Hook per funzioni del parser',
	'version-hook-name' => "Nome dell'hook",
	'version-hook-subscribedby' => 'Sottoscrizioni',
	'version-version' => '(Versione $1)',
	'version-license' => 'Licenza',
	'version-poweredby-credits' => "Questo wiki è realizzato con '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'altri',
	'version-license-info' => 'MediaWiki è un software libero; puoi redistribuirlo e/o modificarlo secondo i termini della GNU General Public License, come pubblicata dalla Free Software Foundation; o la versione 2 della Licenza o (a propria scelta) qualunque versione successiva.

MediaWiki è distribuito nella speranza che sia utile, ma SENZA ALCUNA GARANZIA; senza neppure la garanzia implicita di NEGOZIABILITÀ o di APPLICABILITÀ PER UN PARTICOLARE SCOPO. Si veda la GNU General Public License per maggiori dettagli.

Questo programma deve essere distribuito assieme ad [{{SERVER}}{{SCRIPTPATH}}/COPYING una copia della GNU General Public License]; in caso contrario, se ne può ottenere una scrivendo alla Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA oppure [//www.softwarelibero.it/gnudoc/gpl.it.txt leggerla in rete].',
	'version-software' => 'Software installato',
	'version-software-product' => 'Prodotto',
	'version-software-version' => 'Versione',
);

$messages['ja'] = array(
	'variants' => '変種',
	'view' => '閲覧',
	'viewdeleted_short' => '削除された$1件の編集を閲覧',
	'views' => '表示',
	'viewcount' => 'このページは{{PLURAL:$1|$1回}}アクセスされました。',
	'view-pool-error' => '申し訳ありません、現在サーバーに過大な負荷がかかっています。
このページを閲覧しようとする利用者が多すぎます。
しばらく時間を置いてから、もう一度このページにアクセスしてみてください。

$1',
	'versionrequired' => 'MediaWikiのバージョン$1が必要',
	'versionrequiredtext' => 'このページの利用にはMediaWikiのバージョン$1が必要です。[[Special:Version|バージョン情報]]を確認してください。',
	'viewsourceold' => 'ソースを表示',
	'viewsourcelink' => 'ソースを表示',
	'viewdeleted' => '$1を表示しますか？',
	'viewsource' => 'ソースを表示',
	'viewsource-title' => '$1のソースを表示',
	'viewsourcetext' => 'このページのソースを閲覧し、コピーすることができます：',
	'viewyourtext' => "このページに対する'''あなたの編集'''のソースを閲覧し、コピーすることができます：",
	'virus-badscanner' => "環境設定が不適合です：不明なウイルス検知ソフトウェア：''$1''",
	'virus-scanfailed' => 'スキャンに失敗しました（コード $1）',
	'virus-unknownscanner' => '不明なウイルス対策：',
	'viewpagelogs' => 'このページに関する記録を表示',
	'viewprevnext' => '（$1{{int:pipe-separator}}$2）（$3）を表示',
	'verification-error' => 'このファイルは、ファイルの検証システムに合格しませんでした。',
	'viewdeletedpage' => '削除されたページを表示',
	'video-dims' => '$1、 $2 × $3',
	'variantname-zh-hans' => '簡体',
	'variantname-zh-hant' => '繁体',
	'variantname-zh-cn' => '中国簡体',
	'variantname-zh-tw' => '台湾正体',
	'variantname-zh-hk' => '香港正体',
	'variantname-zh-mo' => 'マカオ',
	'variantname-zh-sg' => 'シンガポール簡体',
	'variantname-zh-my' => 'マレーシア',
	'variantname-zh' => '中文',
	'variantname-gan-hans' => 'hans',
	'variantname-gan-hant' => 'hant',
	'variantname-gan' => 'ガガウズ語',
	'variantname-sr-ec' => 'セルビア語 (キリル文字)',
	'variantname-sr-el' => 'セルビア語 (ラテン文字)',
	'variantname-sr' => 'セルビア語',
	'variantname-kk-kz' => 'カザフ語 (カザフスタン)',
	'variantname-kk-tr' => 'カザフ語 (トルコ)',
	'variantname-kk-cn' => 'カザフ語 (中国)',
	'variantname-kk-cyrl' => 'カザフ語 (キリル文字)',
	'variantname-kk-latn' => 'カザフ語 (ラテン文字)',
	'variantname-kk-arab' => 'カザフ語 (アラビア文字)',
	'variantname-kk' => 'カザフ語',
	'variantname-ku-arab' => 'クルド語 (アラビア文字)',
	'variantname-ku-latn' => 'クルド語 (ラテン文字)',
	'variantname-ku' => 'クルド語',
	'variantname-tg-cyrl' => 'タジク語 (キリル文字)',
	'variantname-tg-latn' => 'タジク語 (ラテン文字)',
	'variantname-tg' => 'タジク語',
	'variantname-ike-cans' => 'イヌクティトゥット語 (カナダ先住民文字)',
	'variantname-ike-latn' => 'イヌクティトゥット語 (ラテン文字)',
	'variantname-iu' => 'イヌクティトゥット語',
	'version' => 'バージョン情報',
	'version-extensions' => 'インストール済み拡張機能',
	'version-specialpages' => '特別ページ',
	'version-parserhooks' => '構文解析フック',
	'version-variables' => '変数',
	'version-antispam' => 'スパム対策',
	'version-skins' => 'スキン',
	'version-other' => 'その他',
	'version-mediahandlers' => 'メディアハンドラー',
	'version-hooks' => 'フック',
	'version-extension-functions' => '拡張機能関数',
	'version-parser-extensiontags' => '構文解析拡張機能タグ',
	'version-parser-function-hooks' => 'パーサー関数フック',
	'version-hook-name' => 'フック名',
	'version-hook-subscribedby' => '使用個所',
	'version-version' => '（バージョン$1）',
	'version-license' => 'ライセンス',
	'version-poweredby-credits' => "このウィキは、'''[//www.mediawiki.org/ MediaWiki]'''(copyright © 2001-$1 $2)で動作しています。",
	'version-poweredby-others' => 'その他',
	'version-license-info' => 'MediaWikiはフリーソフトウェアです。あなたは、フリーソフトウェア財団の発行するGNU一般公衆利用許諾書 (GNU General Public License)（バージョン2、またはそれ以降のライセンス）の規約にもとづき、このライブラリの再配布や改変をすることができます。

MediaWikiは、有用であることを期待して配布されていますが、商用あるいは特定の目的に適するかどうかも含めて、暗黙的にも、一切保証されません。詳しくは、GNU一般公衆利用許諾書をご覧下さい。

あなたはこのプログラムと共に、[{{SERVER}}{{SCRIPTPATH}}/COPYING GNU一般公衆利用許諾契約書の複製]を受け取ったはずです。もし受け取っていなければ、フリーソフトウェア財団(the Free Software Foundation, Inc., 59Temple Place, Suite 330, Boston, MA 02111-1307 USA)まで請求するか、[//www.gnu.org/licenses/old-licenses/gpl-2.0.html オンラインで閲覧]してください。',
	'version-software' => 'インストール済みソフトウェア',
	'version-software-product' => '製品',
	'version-software-version' => 'バージョン',
	'vertical-tv' => 'テレビ番組',
	'vertical-games' => 'ゲーム',
	'vertical-books' => '性格診断テスト',
	'vertical-comics' => '漫画',
	'vertical-lifestyle' => 'ライフスタイル',
	'vertical-movies' => '映画',
);

$messages['jam'] = array(
	'variants' => 'Vieriant',
	'view' => 'Riid',
	'viewdeleted_short' => 'Riid {{PLURAL:$1|wan diliitid hedit|$1 diliitid hedit dem}}',
	'views' => 'Vyuu',
	'viewcount' => 'Dis piej akses {{PLURAL:$1|wans|$1 taim}}.',
	'view-pool-error' => 'Sari, di soervadem uobaluod a di muoment.
Tomoch yuuza a chrai fi vyuu dis piej.
Begyu wiet likl bifuo yu chrai fi akses dis piej agen.

$1',
	'versionrequired' => 'Voerjan $1 a MediaWiki rikwaya',
	'versionrequiredtext' => 'Voerjan $1 a MediaWiki rikwaya fi yuuz dis piej.
Si [[Special:Version|voerjan piej]].',
	'viewsourceold' => 'vyuu suos',
	'viewsourcelink' => 'vyuu suos',
	'viewdeleted' => 'Vyuu $1?',
	'viewsource' => 'Vyuu Suos',
	'viewsourcetext' => 'Yu kiahn vyuu ahn kapi di suos a dis piej:',
	'virus-badscanner' => "Bad kanfigarieshan: anuon vairos skiana: ''$1''",
	'virus-scanfailed' => 'skian fiel (kuod $1)',
	'virus-unknownscanner' => 'anuon antivairos:',
	'viewpagelogs' => 'Vyuu lagdem fi dis piej',
	'viewprevnext' => 'Vyuu ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['jbo'] = array(
	'views' => 'Catlu',
	'viewsourceold' => 'catlu le mifra',
	'viewsourcelink' => 'casnu le mifra',
	'viewdeleted' => 'View $1?',
	'viewsource' => 'catlu le mifra',
);

$messages['jut'] = array(
	'views' => 'Vesnenger',
	'viewcount' => 'Æ side er vest i alt $1 {{PLURAL:$1|geng|genger}}.',
	'versionrequired' => 'Kræver versje $1 åf MediaWiki',
	'versionrequiredtext' => "Versje $1 åf MediaWiki er påkrævet, før at bruge denne side. Se'n [[Special:Version|versjeside]]",
	'viewsourceold' => 'ves æ kelde',
	'viewdeleted' => 'Ves $1?',
	'viewsource' => 'Ves æ kelde',
	'viewsourcetext' => "Du ken dog se og åfskreve'n keldekode til æ side:",
	'viewpagelogs' => 'Ves loglister før denne side',
	'viewprevnext' => 'Ves ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => "Informasje MediaWiki'm",
);

$messages['jv'] = array(
	'variants' => 'Varian',
	'views' => 'Tampilan',
	'viewcount' => 'Kaca iki wis tau diaksès cacahé ping {{PLURAL:$1|siji|$1}}.',
	'view-pool-error' => 'Nyuwun ngapuro, peladèn lagi sibuk wektu iki.
Kakèhan panganggo sing nyoba mbukak kaca iki.
Entèni sedhéla sadurungé nyoba ngaksès kaca iki manèh .

$1',
	'versionrequired' => 'Dibutuhaké MediaWiki vèrsi $1',
	'versionrequiredtext' => 'MediaWiki vèrsi $1 dibutuhaké kanggo nggunakaké kaca iki. Mangga mirsani [[Special:Version|kaca iki]]',
	'viewsourceold' => 'deleng sumber',
	'viewsourcelink' => 'deleng sumber',
	'viewdeleted' => 'Mirsani $1?',
	'viewsource' => 'Tuduhna sumber',
	'viewsourcefor' => 'saka $1',
	'viewsourcetext' => 'Panjenengan bisa mirsani utawa nulad sumber kaca iki:',
	'virus-badscanner' => "Kasalahan konfigurasi: pamindai virus ora dikenal: ''$1''",
	'virus-scanfailed' => "''Pemindaian'' utawa ''scan'' gagal (kode $1)",
	'virus-unknownscanner' => 'Antivirus ora ditepungi:',
	'viewpagelogs' => 'Mirsani log kaca iki',
	'viewprevnext' => 'Deleng ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Deleng kaca sing wis dibusak',
	'version' => 'Versi',
	'version-extensions' => 'Èkstènsi sing wis diinstalasi',
	'version-specialpages' => 'Kaca astaméwa (kaca kusus)',
	'version-parserhooks' => 'Canthèlan parser',
	'version-variables' => 'Variabel',
	'version-other' => 'Liyané',
	'version-mediahandlers' => 'Pananganan média',
	'version-hooks' => 'Canthèlan-canthèlan',
	'version-extension-functions' => 'Fungsi-fungsi èkstènsi',
	'version-parser-extensiontags' => 'Rambu èkstènsi parser',
	'version-parser-function-hooks' => 'Canthèlan fungsi parser',
	'version-skin-extension-functions' => 'Fungsi èkstènsi kulit',
	'version-hook-name' => 'Jeneng canthèlan',
	'version-hook-subscribedby' => 'Dilanggani déning',
	'version-version' => '(Vèrsi $1)',
	'version-license' => 'Lisènsi',
	'version-software' => "''Software'' wis diinstalasi",
	'version-software-product' => 'Prodhuk',
	'version-software-version' => 'Vèrsi',
);

$messages['ka'] = array(
	'variants' => 'ვარიანტები',
	'views' => 'გადახედვა',
	'viewcount' => 'ეს გვერდი შემოწმდა {{PLURAL:$1|ერთხელ|$1-ჯერ}}.',
	'view-pool-error' => 'უკაცრავად, მაგრამ სერვერები გადატვირთულია.
შემოსულია ამ გვერდის სანახავად ძალიან ბევრი მოთხოვნა.
გთხოვთ დაელოდოთ და გაიმეროთ მოთხოვნა ცოტა მოგვიანებით.

$1',
	'versionrequired' => 'საჭიროა მედიავიკის ვერსია $1',
	'versionrequiredtext' => 'მოცემული გვერდის გამოსაყენებლად საჭიროა მედიავიკის ვერსია $1. იხილეთ [[Special:Version|სპეციალური:ვერსია]]',
	'viewsourceold' => 'წყაროს ჩვენება',
	'viewsourcelink' => 'იხილე წყარო',
	'viewdeleted' => 'იხილე $1?',
	'viewsource' => 'იხილე წყარო',
	'viewsourcefor' => '$1-ის',
	'viewsourcetext' => 'თქვენ შეგიძლიათ ნახოთ ამ გვერდის საწყისი ფაილი და მისი ასლი შექმნათ:',
	'virus-badscanner' => "შეცდომა. ვირუსთა უცნობი სკანერი: ''$1''",
	'virus-scanfailed' => 'სკანირების შეცდომა  (კოდი $1)',
	'virus-unknownscanner' => 'უცნობი ანტივირუსი:',
	'viewpagelogs' => 'ამ გვერდისთვის სარეგისტრაციო ჟურნალების ჩვენება',
	'viewprevnext' => 'იხილე  ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'იხილეთ წაშლილი გვერდები',
	'version' => 'ვერსია',
	'version-extensions' => 'დაყენებული გაფართოებები',
	'version-specialpages' => 'სპეციალური გვერდები',
	'version-parserhooks' => 'სინტაქსური ანალიზატორის ჰუკები',
	'version-variables' => 'смфдуифвуиш',
	'version-other' => 'სხვა',
	'version-mediahandlers' => 'მედია დამუშავება',
	'version-hooks' => 'ჰუკებш',
	'version-extension-functions' => 'გაფართოებათა ფუნქციები',
	'version-parser-extensiontags' => 'სინტაქსური ანალიზატორის თეგი',
	'version-parser-function-hooks' => 'სინტაქსური ანალიზატორის ჰუკი',
	'version-skin-extension-functions' => 'გაფართოებათა თემების  ფუნქციები',
	'version-hook-name' => 'ჰუკის სახელი',
	'version-hook-subscribedby' => 'ჩაწერილია',
	'version-version' => '(ვერსია $1)',
	'version-license' => 'ლიცენზია',
	'version-software' => 'დაინსტალირებული პროგრამული უზრუნველყოფა',
	'version-software-product' => 'პროდუქტი',
	'version-software-version' => 'ვერსია',
);

$messages['kaa'] = array(
	'variants' => 'Variantlar',
	'views' => "Ko'rinis",
	'viewcount' => "Bul bet {{PLURAL:$1|bir ma'rte|$1 ma'rte}} ko'rip shıg'ılg'an.",
	'versionrequired' => "MediaWikidin' $1 nusqası kerek",
	'versionrequiredtext' => "Bul betti paydalanıw ushın MediaWikidin' $1 nusqası kerek. [[Special:Version|Nusqa beti]]n qaran'.",
	'viewsourceold' => "deregin ko'riw",
	'viewsourcelink' => "kodın ko'riw",
	'viewdeleted' => "$1 ko'riw?",
	'viewsource' => "Deregin ko'riw",
	'viewsourcetext' => "Bul bettin' deregin qarawın'ızg'a ha'mde ko'shirip alıwın'ızg'a boladı:",
	'virus-unknownscanner' => 'belgisiz antivirus:',
	'viewpagelogs' => "Usı bettin' jurnalın ko'riw",
	'viewprevnext' => "Ko'riw: ($1 {{int:pipe-separator}} $2) ($3)",
	'viewdeletedpage' => "O'shirilgen betlerdi ko'riw",
	'video-dims' => '$1, $2 × $3',
	'version' => "MediaWikidin' nusqası",
);

$messages['kab'] = array(
	'views' => 'Tuẓrin',
	'viewcount' => 'Asebter-agi yettwakcem {{PLURAL:$1|yiwet tikelt|$1 tikwal}}.',
	'versionrequired' => 'Yessefk ad tesɛiḍ tasiwelt $1 n MediaWiki',
	'versionrequiredtext' => 'Yessefk ad tesɛiḍ tasiwelt $1 n MediaWiki iwakken ad tesseqdceḍ asebter-agi. Ẓer [[Special:Version|tasiwelt n usebter]].',
	'viewdeleted' => 'Ẓer $1?',
	'viewsource' => 'Ẓer aɣbalu',
	'viewsourcetext' => 'Tzemreḍ ad twaliḍ u txedmeḍ alsaru n uɣbalu n usebter-agi:',
	'viewpagelogs' => 'Ẓer aɣmis n usebter-agi',
	'viewprevnext' => 'Ẓer ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Ẓer isebtar yettumḥan',
	'version' => 'Tasiwelt',
);

$messages['kbd'] = array(
	'views' => 'Tuẓrin',
	'viewcount' => 'Asebter-agi yettwakcem {{PLURAL:$1|yiwet tikelt|$1 tikwal}}.',
	'versionrequired' => 'Yessefk ad tesɛiḍ tasiwelt $1 n MediaWiki',
	'versionrequiredtext' => 'Yessefk ad tesɛiḍ tasiwelt $1 n MediaWiki iwakken ad tesseqdceḍ asebter-agi. Ẓer [[Special:Version|tasiwelt n usebter]].',
	'viewdeleted' => 'Ẓer $1?',
	'viewsource' => 'Ẓer aɣbalu',
	'viewsourcetext' => 'Tzemreḍ ad twaliḍ u txedmeḍ alsaru n uɣbalu n usebter-agi:',
	'viewpagelogs' => 'Ẓer aɣmis n usebter-agi',
	'viewprevnext' => 'Ẓer ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Ẓer isebtar yettumḥan',
	'version' => 'Tasiwelt',
);

$messages['kbd-cyrl'] = array(
	'variants' => 'Вариантхэр',
	'view' => 'Еплъын',
	'viewdeleted_short' => 'Еплъын {{PLURAL:$1|$1 гъэтэрэзыгъуэ ихам|$1 гъэтэрэзыгъуэ ихахэм|$1 гъэтэрэзыгъуэ ихыжахэм}}',
	'views' => 'Зыхэплъахэр',
	'viewcount' => 'Мы напэкӀуэцӀым Ӏухьа {{PLURAL:$1|-рэ}}.',
	'view-pool-error' => 'Джыпсту серверхэм гугъу ятелъ
Мы напэкӀуэцӀым еплъын кӀэлъэӀуэгъу куэд къэкӀуа.
ТӀэкӀу ежи, яужым иджыри зэ техьэж.

$1',
	'versionrequired' => 'MediaWiki и версиэ $1 хуэныкъуэщ',
	'versionrequiredtext' => 'Мы напэкӀуэцӀым елэжьын щхьэкӀэ MediaWiki версиэ $1 хуэныкъуэ. Еплъ [[Special:Version|къагъэсэбэп ПО-хэм я къэӀохугъуэ]].',
	'viewsourceold' => 'къызыхэкӀа кодым еплъын',
	'viewsourcelink' => 'къызыхэкӀа кодым еплъын',
	'viewdeleted' => 'Еплъын $1?',
	'viewsource' => 'Хэплъэн',
	'viewsourcetext' => 'Мы напэкӀуэцӀым и нэхъыщхьэ тхылъыр мыбдежьым уэплъыфыну, и копиэри ипхыфыну:',
	'virus-badscanner' => "Зэгъэзэхуэгъуэм и щэуэгъуэ: вирусхэм яуэ, хэщӀыкӀыгъэ зимыӀэ сканэр: ''$1''",
	'virus-scanfailed' => 'Сканэр щӀыным и щэуэгъуэ (кодыр $1)',
	'virus-unknownscanner' => 'хэщӀыкӀыгъэ зимыӀэ антивирус:',
	'viewpagelogs' => 'Мы напэкӀуэцIым щхьэкӀэ тхылъыр гъэлъэгъуэн',
	'viewprevnext' => 'Еплъын ($1 {{int:pipe-separator}} $2) ($3)',
	'version-specialpages' => 'Лэжыгъэ напэкӀуэцӀ',
);

$messages['kg'] = array(
	'view' => 'Tala',
	'views' => 'Bantadilu',
	'viewprevnext' => 'Mona ($1 {{int:pipe-separator}} $2) ($3).',
);

$messages['khw'] = array(
	'variants' => 'الگ',
	'view' => 'لوڑے',
	'views' => 'خیالات',
	'viewcount' => 'ھیہ صفحہ گیونو ھوی {{PLURAL:$1|ای‌بار|$1 مرتبہ}}',
	'versionrequired' => 'میڈیا ویکیو $1 نسخہو لازمی ضرورت شیر',
	'versionrequiredtext' => 'ھیہ صفحہو استعمال کوریکو بچے میڈیاویکیو $1 نسخہو ضرورت شیر.

[[Special:Version|version page]]',
	'viewsourceold' => 'مآخذو لوڑے',
	'viewsourcelink' => 'مآخذو لوڑے',
	'viewdeleted' => 'لوڑے $1؟',
	'viewsource' => 'مسودو لوڑے',
	'viewsourcetext' => 'تو صرف مضمونو لوڑیکو بوس وا ھو نقل کوریکو بوس:',
	'virus-badscanner' => "\"خراب وضعیت: نوژان وائرسی مفراس: ''\$1''\",",
	'virus-scanfailed' => 'تفریس ناکام (رمز $1)',
	'virus-unknownscanner' => 'نوژان ضد وائرس:',
	'viewpagelogs' => 'ھیہ صفحہو بچے نوشتہ جاتن لوڑے',
	'viewprevnext' => 'لوڑے($1 {{int:pipe-separator}} $2) ($3)۔',
);

$messages['kiu'] = array(
	'variants' => 'Varyanti',
	'view' => 'Bıvêne',
	'viewdeleted_short' => '{{PLURAL:$1|Jü vurnaiso esterıte|$1 Vurnaisunê esterıtu}} basne',
	'views' => 'Asaeni',
	'viewcount' => 'Na pele hata nıka {{PLURAL:$1|jü rae|$1 rey}} vêniye.',
	'view-pool-error' => 'Qaytê qusıri mekerê, serverê ma nıka jêde bar gureto ho ser.
Hedê ho ra jêde karberi kenê ke şêrê na pele bıkerê.
Sıma rê zamet, tenê vınderê, hata ke reyna kenê ke na pele kuyê.

$1',
	'versionrequired' => 'MediaWiki ra vurnaisê $1i lazımo',
	'versionrequiredtext' => 'MediaWiki ra vurnaisê $1i lazımo ke na pele bıgurenê. Qaytê [[Special:Version|vurnaisê pele]] ke.',
	'viewsourceold' => 'çımey bıvêne',
	'viewsourcelink' => 'çıme bıvêne',
	'viewdeleted' => '$1 basne?',
	'viewsource' => 'Çımey bıvêne',
	'viewsourcetext' => 'Sıma şikinê çımê na pele bıvênê u kopya kerê:',
	'virus-badscanner' => "Sıkılo xırabın: ''scanner''ê ''virus''ê nêzanıtey: ''$1''",
	'virus-scanfailed' => "''scan'' nêbi (code $1)",
	'virus-unknownscanner' => "''antivirus''o nêzanıte:",
	'viewpagelogs' => 'Qeydê ke na pele ra alaqedarê, inu bıasne',
	'viewprevnext' => 'Bıvêne ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Pelunê esteriyau bıvine',
	'variantname-zh-hans' => 'hans',
	'variantname-zh-hant' => 'hant',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
	'variantname-zh-sg' => 'sg',
	'variantname-zh-my' => 'mın',
	'variantname-zh' => 'zh',
	'variantname-sr-ec' => 'sr-ek',
	'variantname-sr-el' => 'sr-el',
	'variantname-sr' => 'sr',
	'variantname-kk-kz' => 'kk-kz',
	'variantname-kk-tr' => 'kk-tr',
	'variantname-kk-cn' => 'kk-kn',
	'variantname-kk-cyrl' => 'kk-kırl',
	'variantname-kk-latn' => 'kk-latn',
	'variantname-kk-arab' => 'kk-areb',
	'variantname-kk' => 'kk',
	'variantname-ku-arab' => 'ku-Areb',
	'variantname-ku-latn' => 'ku-Latn',
	'variantname-ku' => 'ku',
	'variantname-tg-cyrl' => 'tg-Kırl',
	'variantname-tg-latn' => 'tg-Latn',
	'variantname-tg' => 'tg',
);

$messages['kk'] = array(
	'variantname-kk-kz' => 'disable',
	'variantname-kk-tr' => 'disable',
	'variantname-kk-cn' => 'disable',
	'variantname-kk-cyrl' => 'Кирил',
	'variantname-kk-latn' => 'Latın',
	'variantname-kk-arab' => 'توتە',
	'variantname-kk' => 'disable',
);

$messages['kk-arab'] = array(
	'views' => 'كورىنىس',
	'viewcount' => 'بۇل بەت $1 رەت قاتىنالعان.',
	'versionrequired' => 'MediaWiki $1 نۇسقاسى كەرەك',
	'versionrequiredtext' => 'بۇل بەتتى قولدانۋ ٴۇشىن MediaWiki $1 نۇسقاسى كەرەك. [[{{ns:special}}:Version|جۇيە نۇسقاسى بەتىن]] قاراڭىز.',
	'viewsourceold' => 'قاينار كوزىن قاراۋ',
	'viewdeleted' => '$1 قارايسىز با?',
	'viewsource' => 'قاينار كوزىن قاراۋ',
	'viewsourcetext' => 'بۇل بەتتىڭ قاينار كوزىن قاراۋىڭىزعا جانە كوشىرىپ الۋڭىزعا بولادى:',
	'viewpagelogs' => 'بۇل بەت ٴۇشىن جۋرنال وقىيعالارىن قاراۋ',
	'viewprevnext' => 'كورسەتىلۋى: ($1 {{int:pipe-separator}} $2) ($3) جازبا',
	'viewdeletedpage' => 'جويىلعان بەتتەردى قاراۋ',
	'video-dims' => '$1, $2 × $3',
	'version' => 'جۇيە نۇسقاسى',
	'version-extensions' => 'ورناتىلعان كەڭەيتىمدەر',
	'version-specialpages' => 'ارنايى بەتتەر',
	'version-parserhooks' => 'قۇرىلىمدىق تالداتقىشتىڭ تۇزاقتارى',
	'version-variables' => 'اينىمالىلار',
	'version-other' => 'تاعى باسقالار',
	'version-mediahandlers' => 'تاسپا وڭدەتكىشتەرى',
	'version-hooks' => 'جەتە تۇزاقتارى',
	'version-extension-functions' => 'كەڭەيتىمدەر جەتەلەرى',
	'version-parser-extensiontags' => 'قۇرىلىمدىق تالداتقىش كەڭەيتىمدەرىنىڭ بەلگىلەمەرى',
	'version-parser-function-hooks' => 'قۇرىلىمدىق تالداتقىش جەتەلەرىنىڭ تۇزاقتارى',
	'version-hook-name' => 'تۇزاق اتاۋى',
	'version-hook-subscribedby' => 'تۇزاق تارتقىشتارى',
	'version-version' => '(نۇسقاسى: $1)',
	'version-license' => 'لىيتسەنزىيياسى',
	'version-software' => 'ورناتىلعان باعدارلامالىق جاساقتاما',
	'version-software-product' => 'ٴونىم',
	'version-software-version' => 'نۇسقاسى',
);

$messages['kk-cn'] = array(
	'views' => 'كورىنىس',
	'viewcount' => 'بۇل بەت $1 رەت قاتىنالعان.',
	'versionrequired' => 'MediaWiki $1 نۇسقاسى كەرەك',
	'versionrequiredtext' => 'بۇل بەتتى قولدانۋ ٴۇشىن MediaWiki $1 نۇسقاسى كەرەك. [[{{ns:special}}:Version|جۇيە نۇسقاسى بەتىن]] قاراڭىز.',
	'viewsourceold' => 'قاينار كوزىن قاراۋ',
	'viewdeleted' => '$1 قارايسىز با?',
	'viewsource' => 'قاينار كوزىن قاراۋ',
	'viewsourcetext' => 'بۇل بەتتىڭ قاينار كوزىن قاراۋىڭىزعا جانە كوشىرىپ الۋڭىزعا بولادى:',
	'viewpagelogs' => 'بۇل بەت ٴۇشىن جۋرنال وقىيعالارىن قاراۋ',
	'viewprevnext' => 'كورسەتىلۋى: ($1 {{int:pipe-separator}} $2) ($3) جازبا',
	'viewdeletedpage' => 'جويىلعان بەتتەردى قاراۋ',
	'video-dims' => '$1, $2 × $3',
	'version' => 'جۇيە نۇسقاسى',
	'version-extensions' => 'ورناتىلعان كەڭەيتىمدەر',
	'version-specialpages' => 'ارنايى بەتتەر',
	'version-parserhooks' => 'قۇرىلىمدىق تالداتقىشتىڭ تۇزاقتارى',
	'version-variables' => 'اينىمالىلار',
	'version-other' => 'تاعى باسقالار',
	'version-mediahandlers' => 'تاسپا وڭدەتكىشتەرى',
	'version-hooks' => 'جەتە تۇزاقتارى',
	'version-extension-functions' => 'كەڭەيتىمدەر جەتەلەرى',
	'version-parser-extensiontags' => 'قۇرىلىمدىق تالداتقىش كەڭەيتىمدەرىنىڭ بەلگىلەمەرى',
	'version-parser-function-hooks' => 'قۇرىلىمدىق تالداتقىش جەتەلەرىنىڭ تۇزاقتارى',
	'version-hook-name' => 'تۇزاق اتاۋى',
	'version-hook-subscribedby' => 'تۇزاق تارتقىشتارى',
	'version-version' => '(نۇسقاسى: $1)',
	'version-license' => 'لىيتسەنزىيياسى',
	'version-software' => 'ورناتىلعان باعدارلامالىق جاساقتاما',
	'version-software-product' => 'ٴونىم',
	'version-software-version' => 'نۇسقاسى',
);

$messages['kk-cyrl'] = array(
	'variants' => 'Нұсқалар',
	'view' => 'Қарау',
	'viewdeleted_short' => 'Көру {{PLURAL:$1|жойылған өңдеуді $1|жойылған өңдеулерді $1| жойылған өңдеулерді $1}}',
	'views' => 'Көрініс',
	'viewcount' => 'Бұл бет $1 рет қатыналған.',
	'view-pool-error' => 'Кешіріңіз, қазір серверлер шектен тыс жүктеулі.
Осы бетті қарауға өте көп сұраныс жасалды.
Өтініш,  күте тұрыңыз және осы бетке кіруге қайта әрекет жасаңыз.

$1',
	'versionrequired' => 'MediaWiki $1 нұсқасы керек',
	'versionrequiredtext' => 'Бұл бетті қолдану үшін MediaWiki $1 нұсқасы керек. [[Special:Version|Жүйе нұсқасы бетін]] қараңыз.',
	'viewsourceold' => 'қайнар көзін қарау',
	'viewsourcelink' => 'қайнар көзін қарау',
	'viewdeleted' => '$1 қарайсыз ба?',
	'viewsource' => 'Қайнар көзін қарау',
	'viewsource-title' => '$1 бетінің бастапқы мәтінін қарау',
	'viewsourcetext' => 'Бұл беттің қайнар көзін қарауыңызға және көшіріп алуыңызға болады:',
	'viewyourtext' => 'Осы бет арқылы "өзіңіз жасаған өңдеулердің" бастапқы мәтінін көруге және көшіруге мүмкіндігіңіз болады.',
	'virus-badscanner' => 'Баптау қателігі. Белгісіз вирус сканері: $1',
	'virus-scanfailed' => 'сканерлеу қатесі (код $1)',
	'virus-unknownscanner' => 'белгісіз антивирус:',
	'viewpagelogs' => 'Бұл бет үшін журнал оқиғаларын қарау',
	'viewprevnext' => 'Көрсетілуі: ($1 {{int:pipe-separator}} $2) ($3) жазба',
	'viewdeletedpage' => 'Жойылған беттерді қарау',
	'video-dims' => '$1, $2 × $3',
	'version' => 'Жүйе нұсқасы',
	'version-extensions' => 'Орнатылған кеңейтімдер',
	'version-specialpages' => 'Арнайы беттер',
	'version-parserhooks' => 'Құрылымдық талдатқыштың тұзақтары',
	'version-variables' => 'Айнымалылар',
	'version-other' => 'Тағы басқалар',
	'version-mediahandlers' => 'Таспа өңдеткіштері',
	'version-hooks' => 'Жете тұзақтары',
	'version-extension-functions' => 'Кеңейтімдер жетелері',
	'version-parser-extensiontags' => 'Құрылымдық талдатқыш кеңейтімдерінің белгілемері',
	'version-parser-function-hooks' => 'Құрылымдық талдатқыш жетелерінің тұзақтары',
	'version-hook-name' => 'Тұзақ атауы',
	'version-hook-subscribedby' => 'Тұзақ тартқыштары',
	'version-version' => '(Нұсқасы: $1)',
	'version-license' => 'Лицензиясы',
	'version-software' => 'Орнатылған бағдарламалық жасақтама',
	'version-software-product' => 'Өнім',
	'version-software-version' => 'Нұсқасы',
);

$messages['kk-kz'] = array(
	'variants' => 'Нұсқалар',
	'view' => 'Қарау',
	'viewdeleted_short' => 'Көру {{PLURAL:$1|жойылған өңдеуді $1|жойылған өңдеулерді $1| жойылған өңдеулерді $1}}',
	'views' => 'Көрініс',
	'viewcount' => 'Бұл бет $1 рет қатыналған.',
	'view-pool-error' => 'Кешіріңіз, қазір серверлер шектен тыс жүктеулі.
Осы бетті қарауға өте көп сұраныс жасалды.
Өтініш,  күте тұрыңыз және осы бетке кіруге қайта әрекет жасаңыз.

$1',
	'versionrequired' => 'MediaWiki $1 нұсқасы керек',
	'versionrequiredtext' => 'Бұл бетті қолдану үшін MediaWiki $1 нұсқасы керек. [[Special:Version|Жүйе нұсқасы бетін]] қараңыз.',
	'viewsourceold' => 'қайнар көзін қарау',
	'viewsourcelink' => 'қайнар көзін қарау',
	'viewdeleted' => '$1 қарайсыз ба?',
	'viewsource' => 'Қайнар көзін қарау',
	'viewsource-title' => '$1 бетінің бастапқы мәтінін қарау',
	'viewsourcetext' => 'Бұл беттің қайнар көзін қарауыңызға және көшіріп алуыңызға болады:',
	'viewyourtext' => 'Осы бет арқылы "өзіңіз жасаған өңдеулердің" бастапқы мәтінін көруге және көшіруге мүмкіндігіңіз болады.',
	'virus-badscanner' => 'Баптау қателігі. Белгісіз вирус сканері: $1',
	'virus-scanfailed' => 'сканерлеу қатесі (код $1)',
	'virus-unknownscanner' => 'белгісіз антивирус:',
	'viewpagelogs' => 'Бұл бет үшін журнал оқиғаларын қарау',
	'viewprevnext' => 'Көрсетілуі: ($1 {{int:pipe-separator}} $2) ($3) жазба',
	'viewdeletedpage' => 'Жойылған беттерді қарау',
	'video-dims' => '$1, $2 × $3',
	'version' => 'Жүйе нұсқасы',
	'version-extensions' => 'Орнатылған кеңейтімдер',
	'version-specialpages' => 'Арнайы беттер',
	'version-parserhooks' => 'Құрылымдық талдатқыштың тұзақтары',
	'version-variables' => 'Айнымалылар',
	'version-other' => 'Тағы басқалар',
	'version-mediahandlers' => 'Таспа өңдеткіштері',
	'version-hooks' => 'Жете тұзақтары',
	'version-extension-functions' => 'Кеңейтімдер жетелері',
	'version-parser-extensiontags' => 'Құрылымдық талдатқыш кеңейтімдерінің белгілемері',
	'version-parser-function-hooks' => 'Құрылымдық талдатқыш жетелерінің тұзақтары',
	'version-hook-name' => 'Тұзақ атауы',
	'version-hook-subscribedby' => 'Тұзақ тартқыштары',
	'version-version' => '(Нұсқасы: $1)',
	'version-license' => 'Лицензиясы',
	'version-software' => 'Орнатылған бағдарламалық жасақтама',
	'version-software-product' => 'Өнім',
	'version-software-version' => 'Нұсқасы',
);

$messages['kk-latn'] = array(
	'views' => 'Körinis',
	'viewcount' => 'Bul bet $1 ret qatınalğan.',
	'versionrequired' => 'MediaWiki $1 nusqası kerek',
	'versionrequiredtext' => 'Bul betti qoldanw üşin MediaWiki $1 nusqası kerek. [[{{ns:special}}:Version|Jüýe nusqası betin]] qarañız.',
	'viewsourceold' => 'qaýnar közin qaraw',
	'viewdeleted' => '$1 qaraýsız ba?',
	'viewsource' => 'Qaýnar közin qaraw',
	'viewsourcetext' => 'Bul bettiñ qaýnar közin qarawıñızğa jäne köşirip alwñızğa boladı:',
	'viewpagelogs' => 'Bul bet üşin jwrnal oqïğaların qaraw',
	'viewprevnext' => 'Körsetilwi: ($1 {{int:pipe-separator}} $2) ($3) jazba',
	'viewdeletedpage' => 'Joýılğan betterdi qaraw',
	'video-dims' => '$1, $2 × $3',
	'version' => 'Jüýe nusqası',
	'version-extensions' => 'Ornatılğan keñeýtimder',
	'version-specialpages' => 'Arnaýı better',
	'version-parserhooks' => 'Qurılımdıq taldatqıştıñ tuzaqtarı',
	'version-variables' => 'Aýnımalılar',
	'version-other' => 'Tağı basqalar',
	'version-mediahandlers' => 'Taspa öñdetkişteri',
	'version-hooks' => 'Jete tuzaqtarı',
	'version-extension-functions' => 'Keñeýtimder jeteleri',
	'version-parser-extensiontags' => 'Qurılımdıq taldatqış keñeýtimderiniñ belgilemeri',
	'version-parser-function-hooks' => 'Qurılımdıq taldatqış jeteleriniñ tuzaqtarı',
	'version-hook-name' => 'Tuzaq atawı',
	'version-hook-subscribedby' => 'Tuzaq tartqıştarı',
	'version-version' => '(Nusqası: $1)',
	'version-license' => 'Lïcenzïyası',
	'version-software' => 'Ornatılğan bağdarlamalıq jasaqtama',
	'version-software-product' => 'Önim',
	'version-software-version' => 'Nusqası',
);

$messages['kk-tr'] = array(
	'views' => 'Körinis',
	'viewcount' => 'Bul bet $1 ret qatınalğan.',
	'versionrequired' => 'MediaWiki $1 nusqası kerek',
	'versionrequiredtext' => 'Bul betti qoldanw üşin MediaWiki $1 nusqası kerek. [[{{ns:special}}:Version|Jüýe nusqası betin]] qarañız.',
	'viewsourceold' => 'qaýnar közin qaraw',
	'viewdeleted' => '$1 qaraýsız ba?',
	'viewsource' => 'Qaýnar közin qaraw',
	'viewsourcetext' => 'Bul bettiñ qaýnar közin qarawıñızğa jäne köşirip alwñızğa boladı:',
	'viewpagelogs' => 'Bul bet üşin jwrnal oqïğaların qaraw',
	'viewprevnext' => 'Körsetilwi: ($1 {{int:pipe-separator}} $2) ($3) jazba',
	'viewdeletedpage' => 'Joýılğan betterdi qaraw',
	'video-dims' => '$1, $2 × $3',
	'version' => 'Jüýe nusqası',
	'version-extensions' => 'Ornatılğan keñeýtimder',
	'version-specialpages' => 'Arnaýı better',
	'version-parserhooks' => 'Qurılımdıq taldatqıştıñ tuzaqtarı',
	'version-variables' => 'Aýnımalılar',
	'version-other' => 'Tağı basqalar',
	'version-mediahandlers' => 'Taspa öñdetkişteri',
	'version-hooks' => 'Jete tuzaqtarı',
	'version-extension-functions' => 'Keñeýtimder jeteleri',
	'version-parser-extensiontags' => 'Qurılımdıq taldatqış keñeýtimderiniñ belgilemeri',
	'version-parser-function-hooks' => 'Qurılımdıq taldatqış jeteleriniñ tuzaqtarı',
	'version-hook-name' => 'Tuzaq atawı',
	'version-hook-subscribedby' => 'Tuzaq tartqıştarı',
	'version-version' => '(Nusqası: $1)',
	'version-license' => 'Lïcenzïyası',
	'version-software' => 'Ornatılğan bağdarlamalıq jasaqtama',
	'version-software-product' => 'Önim',
	'version-software-version' => 'Nusqası',
);

$messages['kl'] = array(
	'views' => 'Takutitat',
	'viewsourceold' => 'toqqavia takuuk',
	'viewsource' => 'Toqqavia takuuk',
	'viewsourcetext' => 'Qupperneq takusinnaavat aamma sanarfia kopeersinnaavat:',
	'viewprevnext' => 'Takuuk ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['km'] = array(
	'variants' => 'អថេរ',
	'view' => 'មើល',
	'viewdeleted_short' => 'មើល{{PLURAL:$1|កំណែប្រែមួយដែលត្រូវបានលុបចោល|កំណែប្រែចំនួន $1 ដែលត្រូវបានលុបចោល}}',
	'views' => 'គំហើញ',
	'viewcount' => "ទំព័រនេះ​ត្រូវបានចូលមើល​ចំនួន'''{{PLURAL:$1|ម្ដង|$1ដង}}'''",
	'view-pool-error' => 'សូមអភ័យទោស។ ប្រព័ន្ធបំរើការមានការមមាញឹកខ្លាំងពេកនៅពេលនេះ។

មានអ្នកប្រើប្រាស់ជាច្រើនកំពុងព្យាយាមចូលមើលទំព័រនេះ។

សូមរង់ចាំមួយភ្លែតសិនរួចសាកល្បងចូលមកកាន់ទំព័រនេះឡើងវិញ។

$1',
	'versionrequired' => 'តម្រូវអោយមាន​កំណែ $1 នៃមេឌាវិគី',
	'versionrequiredtext' => 'តម្រូវអោយមានកំណែ $1 នៃមេឌាវិគី ដើម្បីអាចប្រើប្រាស់ទំព័រនេះ។

សូមមើល [[Special:Version|ទំព័រកំណែ]]។',
	'viewsourceold' => 'មើលកូដ',
	'viewsourcelink' => 'មើលកូដ',
	'viewdeleted' => 'មើល $1?',
	'viewsource' => 'មើល​កូដ',
	'viewsource-title' => 'មើលកូដរបស់ $1',
	'viewsourcetext' => 'អ្នកអាចមើលនិងចម្លងកូដរបស់ទំព័រនេះ៖',
	'viewyourtext' => "អ្នកអាចមើលនិងចម្លងកូដរបស់'''ការកែប្រែរបស់អ្នក'''ទៅកាន់ទំព័រនេះ៖",
	'virus-badscanner' => "ការ​កំណត់​រចនា​សម្ព័ន្ធ​មិន​ល្អ​៖ កម្មវិធី​ស្កេន​មេរោគមិន​ស្គាល់​៖ ''$1''",
	'virus-scanfailed' => 'ស្កេនមិនបានសំរេច (កូដ $1)',
	'virus-unknownscanner' => 'កម្មវិធីប្រឆាំងមេរោគមិនស្គាល់៖',
	'viewpagelogs' => 'មើលកំណត់ហេតុសម្រាប់ទំព័រនេះ',
	'viewprevnext' => 'មើល ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'ឯកសារឆ្លងមិនរួចពីការត្រួតពិនិត្យ។',
	'viewdeletedpage' => 'មើលទំព័រដែលត្រូវបានលុបចេញ',
	'version' => 'កំណែ',
	'version-extensions' => 'ផ្នែកបន្ថែមដែលបានដំឡើង',
	'version-specialpages' => 'ទំព័រពិសេសៗ',
	'version-variables' => 'អថេរ',
	'version-antispam' => 'ការបង្ការស្ប៉ាម',
	'version-skins' => 'សំបក',
	'version-other' => 'ផ្សេង',
	'version-mediahandlers' => 'កម្មវិធី​បើក​មេឌា​ (Media handlers)',
	'version-extension-functions' => 'មុខងារផ្នែកបន្ថែម',
	'version-hook-name' => 'ឈ្មោះ​ Hook',
	'version-hook-subscribedby' => 'បានជាវ ជាប្រចាំ ដោយ',
	'version-version' => '(កំណែ $1)',
	'version-license' => 'អាជ្ញាប័ណ្ណ',
	'version-poweredby-credits' => "វិគីនេះឧបត្ថម្ភដោយ '''[//www.mediawiki.org/ មេឌាវិគី]''', រក្សាសិទ្ធ © ២០០១-$1 $2។",
	'version-poweredby-others' => 'អ្នកដទៃទៀត',
	'version-software' => 'ផ្នែកទន់​ដែល​បានដំឡើង',
	'version-software-product' => 'ផលិតផល',
	'version-software-version' => 'កំណែ',
);

$messages['kn'] = array(
	'variants' => 'ಹಲವು',
	'view' => 'ನೋಟ',
	'viewdeleted_short' => 'ನೋಟ {{PLURAL:$1|೧ ಅಳಿಸಲ್ಪಟ್ಟ ಸಂಪಾದನೆ|$1 ಅಳಿಸಲ್ಪಟ್ಟ ಸಂಪಾದನೆಗಳು}}',
	'views' => 'ನೋಟಗಳು',
	'viewcount' => 'ಈ ಪುಟವನ್ನು {{PLURAL:$1|೧ ಬಾರಿ|$1 ಬಾರಿ}} ವೀಕ್ಷಿಸಲಾಗಿದೆ.',
	'view-pool-error' => '$1',
	'versionrequired' => 'ಮೀಡಿಯವಿಕಿಯ $1 ನೇ ಅವೃತ್ತಿ ಬೇಕಾಗುತ್ತದೆ',
	'versionrequiredtext' => 'ಈ ಪುಟವನ್ನು ವೀಕ್ಷಿಸಲು ಮೀಡಿಯವಿಕಿಯ $1 ನೇ ಆವೃತ್ತಿ ಬೇಕಾಗಿದೆ. [[Special:Version|ಆವೃತ್ತಿ]] ಪುಟವನ್ನು ನೋಡಿ.',
	'viewsourceold' => 'ಮೂಲವನ್ನು ನೋಡು',
	'viewsourcelink' => 'ಮೂಲವನ್ನು ವೀಕ್ಷಿಸಿ',
	'viewdeleted' => '$1 ಅನ್ನು ನೋಡಬೇಕೆ?',
	'viewsource' => 'ಆಕರ ವೀಕ್ಷಿಸು',
	'viewsourcetext' => 'ಈ ಪುಟದ ಮೂಲವನ್ನು ನೀವು ವೀಕ್ಷಿಸಬಹುದು ಮತ್ತು ನಕಲು ಮಾಡಬಹುದು:',
	'virus-unknownscanner' => 'ಅಪರಿಚಿತ ವೈರಾಣುನಾಶಕ:',
	'viewpagelogs' => 'ಈ ಪುಟಗಳ ದಾಖಲೆಗಳನ್ನು ವೀಕ್ಷಿಸಿ',
	'viewprevnext' => 'ವೀಕ್ಷಿಸು ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'ಅಳಿಸಲ್ಪಟ್ಟ ಪುಟಗಳನ್ನು ವೀಕ್ಷಿಸು',
	'version' => 'ಆವೃತ್ತಿ',
	'version-specialpages' => 'ವಿಶೇಷ ಪುಟಗಳು',
	'version-other' => 'ಇತರ',
	'version-version' => '(ಆವೃತ್ತಿ $1)',
	'version-software' => 'ಸಂಸ್ಥಾಪಿಸಲಾಗಿರುವ ತಂತ್ರಾಂಶ',
	'version-software-product' => 'ಉತ್ಪನ್ನ',
	'version-software-version' => 'ಆವೃತ್ತಿ',
);

$messages['ko'] = array(
	'variants' => '변수',
	'view' => '보기',
	'viewdeleted_short' => '삭제된 편집 $1개 보기',
	'views' => '보기',
	'viewcount' => '이 문서는 $1번 읽혔습니다.',
	'view-pool-error' => '서버가 과부하에 걸렸습니다.
너무 많은 사용자가 이 문서를 보려고 하고 있습니다.
이 문서를 다시 열기 전에 잠시만 기다려주세요.

$1',
	'versionrequired' => '미디어위키 $1 버전 필요',
	'versionrequiredtext' => '이 문서를 사용하려면 $1 버전 미디어위키가 필요합니다. [[Special:Version|설치된 미디어위키 버전]]을 확인해주세요.',
	'viewsourceold' => '내용 보기',
	'viewsourcelink' => '내용 보기',
	'viewdeleted' => '$1을 보겠습니까?',
	'viewsource' => '내용 보기',
	'viewsource-title' => '$1 문서 내용 보기',
	'viewsourcetext' => '문서의 원본을 보거나 복사할 수 있습니다:',
	'viewyourtext' => "당신은 이 문서에 남긴 '''당신의 편집''' 내용을 보거나 복사할 수 있습니다:",
	'virus-badscanner' => "잘못된 설정: 알 수 없는 바이러스 검사기: ''$1''",
	'virus-scanfailed' => '검사 실패 (코드 $1)',
	'virus-unknownscanner' => '알려지지 않은 백신:',
	'viewpagelogs' => '이 문서의 기록 보기',
	'viewprevnext' => '보기: ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => '이 파일은 파일 확인 절차를 통과하지 않았습니다.',
	'viewdeletedpage' => '삭제된 문서 보기',
	'variantname-zh-hans' => '간체',
	'variantname-zh-hant' => '번체',
	'version' => '버전',
	'version-extensions' => '설치된 확장 기능',
	'version-specialpages' => '특수 문서',
	'version-parserhooks' => '파서 훅',
	'version-variables' => '변수',
	'version-antispam' => '스팸 방지',
	'version-skins' => '스킨',
	'version-other' => '기타',
	'version-mediahandlers' => '미디어 핸들러',
	'version-hooks' => '훅',
	'version-extension-functions' => '확장 함수',
	'version-parser-extensiontags' => '파서 확장 태그',
	'version-parser-function-hooks' => '파서 기능 훅',
	'version-hook-name' => '훅 이름',
	'version-hook-subscribedby' => '훅이 사용된 위치',
	'version-version' => '(버전 $1)',
	'version-license' => '라이센스',
	'version-poweredby-credits' => "이 위키는 '''[//www.mediawiki.org/ MediaWiki]'''를 기반으로 작동합니다. Copyright © 2001-$1 $2.",
	'version-poweredby-others' => '그 외 다른 개발자',
	'version-license-info' => '미디어위키는 자유 소프트웨어입니다. 당신은 자유 소프트웨어 재단이 발표한 GNU 일반 공중 사용 허가서 버전 2나 그 이후 버전에 따라 이 파일을 재배포하거나 수정할 수 있습니다.

미디어위키가 유용하게 사용될 수 있기를 바라지만 상용으로 사용되거나 특정 목적에 맞을 것이라는 것을 보증하지 않습니다. 자세한 내용은 GNU 일반 공중 사용 허가서 전문을 참고하십시오.

당신은 이 프로그램을 통해 [{{SERVER}}{{SCRIPTPATH}}/COPYING GNU 일반 공중 사용 허가서 전문]을 받았습니다; 그렇지 않다면, Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA로 편지를 보내주시거나 [//www.gnu.org/licenses/old-licenses/gpl-2.0.html 온라인]으로 읽어보시기 바랍니다.',
	'version-software' => '설치된 프로그램',
	'version-software-product' => '제품',
	'version-software-version' => '버전',
);

$messages['ko-kp'] = array(
	'variants' => '변수',
	'view' => '보기',
	'viewdeleted_short' => '삭제된 편집 $1개 보기',
	'views' => '보기',
	'viewcount' => '이 문서는 $1번 읽혔습니다.',
	'view-pool-error' => '서버가 과부하에 걸렸습니다.
너무 많은 사용자가 이 문서를 보려고 하고 있습니다.
이 문서를 다시 열기 전에 잠시만 기다려주세요.

$1',
	'versionrequired' => '미디어위키 $1 버전 필요',
	'versionrequiredtext' => '이 문서를 사용하려면 $1 버전 미디어위키가 필요합니다. [[Special:Version|설치된 미디어위키 버전]]을 확인해주세요.',
	'viewsourceold' => '내용 보기',
	'viewsourcelink' => '내용 보기',
	'viewdeleted' => '$1을 보겠습니까?',
	'viewsource' => '내용 보기',
	'viewsource-title' => '$1 문서 내용 보기',
	'viewsourcetext' => '문서의 원본을 보거나 복사할 수 있습니다:',
	'viewyourtext' => "당신은 이 문서에 남긴 '''당신의 편집''' 내용을 보거나 복사할 수 있습니다:",
	'virus-badscanner' => "잘못된 설정: 알 수 없는 바이러스 검사기: ''$1''",
	'virus-scanfailed' => '검사 실패 (코드 $1)',
	'virus-unknownscanner' => '알려지지 않은 백신:',
	'viewpagelogs' => '이 문서의 기록 보기',
	'viewprevnext' => '보기: ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => '이 파일은 파일 확인 절차를 통과하지 않았습니다.',
	'viewdeletedpage' => '삭제된 문서 보기',
	'variantname-zh-hans' => '간체',
	'variantname-zh-hant' => '번체',
	'version' => '버전',
	'version-extensions' => '설치된 확장 기능',
	'version-specialpages' => '특수 문서',
	'version-parserhooks' => '파서 훅',
	'version-variables' => '변수',
	'version-antispam' => '스팸 방지',
	'version-skins' => '스킨',
	'version-other' => '기타',
	'version-mediahandlers' => '미디어 핸들러',
	'version-hooks' => '훅',
	'version-extension-functions' => '확장 함수',
	'version-parser-extensiontags' => '파서 확장 태그',
	'version-parser-function-hooks' => '파서 기능 훅',
	'version-hook-name' => '훅 이름',
	'version-hook-subscribedby' => '훅이 사용된 위치',
	'version-version' => '(버전 $1)',
	'version-license' => '라이센스',
	'version-poweredby-credits' => "이 위키는 '''[//www.mediawiki.org/ MediaWiki]'''를 기반으로 작동합니다. Copyright © 2001-$1 $2.",
	'version-poweredby-others' => '그 외 다른 개발자',
	'version-license-info' => '미디어위키는 자유 소프트웨어입니다. 당신은 자유 소프트웨어 재단이 발표한 GNU 일반 공중 사용 허가서 버전 2나 그 이후 버전에 따라 이 파일을 재배포하거나 수정할 수 있습니다.

미디어위키가 유용하게 사용될 수 있기를 바라지만 상용으로 사용되거나 특정 목적에 맞을 것이라는 것을 보증하지 않습니다. 자세한 내용은 GNU 일반 공중 사용 허가서 전문을 참고하십시오.

당신은 이 프로그램을 통해 [{{SERVER}}{{SCRIPTPATH}}/COPYING GNU 일반 공중 사용 허가서 전문]을 받았습니다; 그렇지 않다면, Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA로 편지를 보내주시거나 [//www.gnu.org/licenses/old-licenses/gpl-2.0.html 온라인]으로 읽어보시기 바랍니다.',
	'version-software' => '설치된 프로그램',
	'version-software-product' => '제품',
	'version-software-version' => '버전',
);

$messages['koi'] = array(
	'variants' => 'Варианттэз',
	'views' => 'Видзöтöммез',
	'viewsourceold' => 'Видзöтны öшмöс',
	'viewsourcelink' => 'видзöтны öшмöс',
	'viewsource' => 'Öшмöс мыччалан',
	'virus-unknownscanner' => 'тöдтöм антивирус:',
	'viewpagelogs' => 'Мыччавны журналлэз этiя листбок понда',
	'viewprevnext' => 'Видзöтны ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['krc'] = array(
	'variants' => 'Вариантла',
	'view' => 'Къарау',
	'viewdeleted_short' => '{{PLURAL:$1|1|$1}} кетерилген тюрлендириуге къарау',
	'views' => 'Къараула',
	'viewcount' => 'Бу бетге {{PLURAL:$1|1|$1}} кере киргендиле.',
	'view-pool-error' => 'Кечгинлик, бусагъатда серверле бош тюйюлдюле.
Бу бетге къараргъа излегенле асыры кёбдюле.
Кечирек кириб кёрюгюз.

$1',
	'versionrequired' => 'MediaWiki-ни $1 версиясы керекди',
	'versionrequiredtext' => 'Бу бетде ишлер ючюн MediaWiki-ни $1 версиясы керекди.  [[Special:Version|Хайырладырылгъан программаны версияларыны юсюнден информациягъа]] къара.',
	'viewsourceold' => 'Башланнган кодха къара',
	'viewsourcelink' => 'башланнган кодха къара',
	'viewdeleted' => '$1къараймыса?',
	'viewsource' => 'Къарау',
	'viewsourcetext' => 'Сиз бу бетни башланнган текстине къараргъа эм аны копия этерге боллукъсуз:',
	'virus-badscanner' => "Джарашдырыуну хатасы. Белгисиз вирус сканер: ''$1''",
	'virus-scanfailed' => 'скан этиуню хатасы (код $1)',
	'virus-unknownscanner' => 'белгисиз антивирус:',
	'viewpagelogs' => 'Бу бетни журналларына къара',
	'viewprevnext' => 'Къара: ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Бу файл тинтилиу процедураны ётмегенди.',
	'viewdeletedpage' => 'Кетерилген бетлеге къара',
	'version' => 'Версия',
	'version-extensions' => 'Салыннган кенгертиуле',
	'version-specialpages' => 'Къуллукъчу бетле',
	'version-parserhooks' => 'Синтаксис анализаторну тутуучула',
	'version-variables' => 'Тюрленнгенле',
	'version-antispam' => 'Антиспам',
	'version-skins' => 'Джасауну темалары',
	'version-other' => 'Башха',
	'version-mediahandlers' => 'Медияны джарашдырыучула',
	'version-hooks' => 'Тутуучула',
	'version-extension-functions' => 'Кенгертиулени функциялары',
	'version-parser-extensiontags' => 'Синтиаксис анализаторну кенгертиулерин теглери',
	'version-parser-function-hooks' => 'Синтаксис анализаторну функцияларын тутуучула',
	'version-hook-name' => 'Тутуучуну аты',
	'version-hook-subscribedby' => 'Абонент болгъан',
	'version-version' => '(Версия $1)',
	'version-license' => 'Лицензия',
	'version-poweredby-credits' => "Бу вики '''[//www.mediawiki.org/ MediaWiki]''' программа бла ишлейди, copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'башхала',
	'version-license-info' => 'MediaWiki эркин программа джазыуду, сиз аны GNU General Public License лицензияны (эркин программа джазыуланы фонду чыгъаргъан; экинчи версиясы неда андан кеч къайсысы да) шартларына кёре джаяргъа эмда/неда тюрлендирирге боллукъсуз.

MediaWiki хайырлы боллукъду деген умут бла джайылады, алай а БИР ТЮРЛЮ БИР ГАРАНТИЯСЫЗДЫ, КОММЕРЦИЯЛЫКЪ неда ЭНЧИ БИР НЮЗЮРГЕ ДЖАРАРЫКЪ гаратияласыз огъунады. Толуракъ билгиле кёрюр ючюн GNU General Public License лицензиягъа къарагъыз.

Бу программа бла бирге  [{{SERVER}}{{SCRIPTPATH}}/COPYING GNU General Public License лицензияны копиясы] болургъа керекди, джокъ эсе Free Software Foundation, Inc. комапиягъа джазыгъыз (адреси: 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA) неда [//www.gnu.org/licenses/old-licenses/gpl-2.0.html лицензияны онлайн окъугъуз].',
	'version-software' => 'Салыннган программа баджарыу',
	'version-software-product' => 'Продукт',
	'version-software-version' => 'Версия',
);

$messages['kri'] = array(
	'views' => 'Vyu-dem',
	'versionrequired' => 'Yu nid MediaWiki Vazhon $1',
	'versionrequiredtext' => 'Yu nid MediaWiki Vazhon $1 foh yuz dis pej-ya.
Luk [[Special:Version|version page]].',
	'viewsourceold' => 'Luk di sos',
	'viewsourcelink' => 'luk di sos',
	'viewdeleted' => 'Luk am $1?',
	'viewsource' => 'Luk di sos',
);

$messages['krj'] = array(
	'views' => 'Manga paglantaw',
	'versionrequired' => 'Version $1 kang MediaWiki kinahanglan',
	'versionrequiredtext' => 'Version $1 of MediaWiki kinahanglan para magamit ang page nga ja.
Lantawa sa [[Special:Version|version kang page]].',
	'viewsource' => 'Turukun ang ginhalinan',
	'version-specialpages' => 'Manga espesyal nga pahina',
);

$messages['ksh'] = array(
	'variants' => 'Variante',
	'view' => 'Beloore',
	'viewdeleted_short' => '{{PLURAL:$1|eijn fottjeschmesse Änderung|$1 fottjeschmesse Änderunge|keij fottjeschmesse Änderunge}} beloore',
	'views' => 'Aansichte',
	'viewcount' => 'De Sigg es bes jetz {{PLURAL:$1|eimol|$1 Mol|keijmol}} avjerofe woode.',
	'view-pool-error' => 'Deiht uns leid, de ßöörvere han em Momang ze vill ze donn.
Zoh vill Metmaacher versöhke di Sigg heh aanzelohre.
Bes esu joot un waat e Weilsche, ih dat de versöhks, di Sigg noch ens opzeroofe.

$1',
	'versionrequired' => 'De Version $1 vun MediaWiki Soffwär es nüdich',
	'versionrequiredtext' => 'De Version $1 vun MediaWiki Soffwär es nüdich, öm die Sigg heh bruche ze künne. Süch op [[Special:Version|de Versionssigg]], wat mer heh för ene Soffwärstand han.',
	'viewsourceold' => 'Wikitex zeije',
	'viewsourcelink' => 'aanloore',
	'viewdeleted' => '$1 aanzeije?',
	'viewsource' => 'Wikitex aanluure',
	'viewsource-title' => 'Der Wikitäx vun dä Sigg „$1“ belooere.',
	'viewsourcetext' => 'Heh es dä Sigg ier Wikitex zom Belooere un Koppeere:',
	'viewyourtext' => 'Do kanns Ding Änderonge aan heh dä Sigg beloore un kopeere:',
	'virus-badscanner' => "Fääler en de Enstellunge: Dat Projramm ''$1'' fö noh Kompjuterwiere ze söke, dat kenne mer nit.",
	'virus-scanfailed' => 'Dat Söhke eß donevve jejange, dä Kood för dä Fähler es „$1“.',
	'virus-unknownscanner' => 'Dat Projamm fö noh Komjuterviere ze sööke kenne mer nit:',
	'viewpagelogs' => 'De Logböcher för heh di Sigg beloore',
	'viewprevnext' => 'Bläddere: ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Heh di Dattei es dorsch de Pröövung jefalle.',
	'viewdeletedpage' => 'Fottjeschmesse Sigge aanzeije',
	'version' => 'Version vun de Wiki Soffwär zeije',
	'version-extensions' => 'Installeete Erjänzunge un Zohsätz',
	'version-specialpages' => '{{int:nstab-special}}e',
	'version-parserhooks' => 'De Parser-Hooke',
	'version-variables' => 'Variable',
	'version-antispam' => 'SPAM verhendere',
	'version-skins' => 'Ovverflääsche',
	'version-api' => '<i lang="en">API</i>',
	'version-other' => 'Söns',
	'version-mediahandlers' => 'Medije-Handler',
	'version-hooks' => 'Schnettstelle oder Hooke',
	'version-extension-functions' => 'Funktione för Zosätz',
	'version-parser-extensiontags' => 'Erjänzunge zom Parser',
	'version-parser-function-hooks' => 'Parserfunktione',
	'version-hook-name' => 'De Schnettstelle ier Name',
	'version-hook-subscribedby' => 'Opjeroofe vun',
	'version-version' => '(Version $1)',
	'version-license' => 'Lizänz',
	'version-poweredby-credits' => "Dat Wiki heh löp met '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'sönß wää',
	'version-license-info' => 'MediaWiki es e frei Projramm. Mer kann et unmolesteet wigger verdeile, un mer kann et verändere, wi mer löstich es, wam_mer sesch dobei aan de <i lang="en">GNU General Public License</i> (jenerälle öffentlesche Lizänz noh GNU) hallde deiht, wi se vun der <i lang="en">Free Software Foundation</i> (Steftung för frei Soffwäer) veröffentlesch woode es. Dobei kam_mer sesch ußsöhke of mer sesch aan de Version 2 dovun hallde deiht, udder öhnz en späädere Fassung.

MediaWiki weed verdeilt met dä Hoffnung, dat et för jet jood es, ävver <span style="text-transform:uppercase">der ohne jeede Jarantie</span>, un esujaa ohne ene unjesaate Jedangke, et künnt <span style="text-transform:uppercase">ze verkoufe</span> sin udder <span style="text-transform:uppercase;">för öhndsene bestemmpte Zweck ze jebruche</span>. Loor Der de jenannte Lizänz aan, wann De mieh Einzelheite weße wells.

Do sullts en [{{SERVER}}{{SCRIPTPATH}}/COPYING Kopie vun dä <i lang="en">GNU General Public License</i>] zosamme met däm Projramm krääje han, un wann nit, schrief aan de: <i lang="en">Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA </i> udder [//www.gnu.org/licenses/old-licenses/gpl-2.0.html liß se em Internet noh].',
	'version-software' => 'Installeete Soffwäer',
	'version-software-product' => 'Produk',
	'version-software-version' => 'Version',
);

$messages['ku'] = array(
	'variants' => 'Variante',
	'view' => 'Beloore',
	'viewdeleted_short' => '{{PLURAL:$1|eijn fottjeschmesse Änderung|$1 fottjeschmesse Änderunge|keij fottjeschmesse Änderunge}} beloore',
	'views' => 'Aansichte',
	'viewcount' => 'De Sigg es bes jetz {{PLURAL:$1|eimol|$1 Mol|keijmol}} avjerofe woode.',
	'view-pool-error' => 'Deiht uns leid, de ßöörvere han em Momang ze vill ze donn.
Zoh vill Metmaacher versöhke di Sigg heh aanzelohre.
Bes esu joot un waat e Weilsche, ih dat de versöhks, di Sigg noch ens opzeroofe.

$1',
	'versionrequired' => 'De Version $1 vun MediaWiki Soffwär es nüdich',
	'versionrequiredtext' => 'De Version $1 vun MediaWiki Soffwär es nüdich, öm die Sigg heh bruche ze künne. Süch op [[Special:Version|de Versionssigg]], wat mer heh för ene Soffwärstand han.',
	'viewsourceold' => 'Wikitex zeije',
	'viewsourcelink' => 'aanloore',
	'viewdeleted' => '$1 aanzeije?',
	'viewsource' => 'Wikitex aanluure',
	'viewsource-title' => 'Der Wikitäx vun dä Sigg „$1“ belooere.',
	'viewsourcetext' => 'Heh es dä Sigg ier Wikitex zom Belooere un Koppeere:',
	'viewyourtext' => 'Do kanns Ding Änderonge aan heh dä Sigg beloore un kopeere:',
	'virus-badscanner' => "Fääler en de Enstellunge: Dat Projramm ''$1'' fö noh Kompjuterwiere ze söke, dat kenne mer nit.",
	'virus-scanfailed' => 'Dat Söhke eß donevve jejange, dä Kood för dä Fähler es „$1“.',
	'virus-unknownscanner' => 'Dat Projamm fö noh Komjuterviere ze sööke kenne mer nit:',
	'viewpagelogs' => 'De Logböcher för heh di Sigg beloore',
	'viewprevnext' => 'Bläddere: ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Heh di Dattei es dorsch de Pröövung jefalle.',
	'viewdeletedpage' => 'Fottjeschmesse Sigge aanzeije',
	'version' => 'Version vun de Wiki Soffwär zeije',
	'version-extensions' => 'Installeete Erjänzunge un Zohsätz',
	'version-specialpages' => '{{int:nstab-special}}e',
	'version-parserhooks' => 'De Parser-Hooke',
	'version-variables' => 'Variable',
	'version-antispam' => 'SPAM verhendere',
	'version-skins' => 'Ovverflääsche',
	'version-api' => '<i lang="en">API</i>',
	'version-other' => 'Söns',
	'version-mediahandlers' => 'Medije-Handler',
	'version-hooks' => 'Schnettstelle oder Hooke',
	'version-extension-functions' => 'Funktione för Zosätz',
	'version-parser-extensiontags' => 'Erjänzunge zom Parser',
	'version-parser-function-hooks' => 'Parserfunktione',
	'version-hook-name' => 'De Schnettstelle ier Name',
	'version-hook-subscribedby' => 'Opjeroofe vun',
	'version-version' => '(Version $1)',
	'version-license' => 'Lizänz',
	'version-poweredby-credits' => "Dat Wiki heh löp met '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'sönß wää',
	'version-license-info' => 'MediaWiki es e frei Projramm. Mer kann et unmolesteet wigger verdeile, un mer kann et verändere, wi mer löstich es, wam_mer sesch dobei aan de <i lang="en">GNU General Public License</i> (jenerälle öffentlesche Lizänz noh GNU) hallde deiht, wi se vun der <i lang="en">Free Software Foundation</i> (Steftung för frei Soffwäer) veröffentlesch woode es. Dobei kam_mer sesch ußsöhke of mer sesch aan de Version 2 dovun hallde deiht, udder öhnz en späädere Fassung.

MediaWiki weed verdeilt met dä Hoffnung, dat et för jet jood es, ävver <span style="text-transform:uppercase">der ohne jeede Jarantie</span>, un esujaa ohne ene unjesaate Jedangke, et künnt <span style="text-transform:uppercase">ze verkoufe</span> sin udder <span style="text-transform:uppercase;">för öhndsene bestemmpte Zweck ze jebruche</span>. Loor Der de jenannte Lizänz aan, wann De mieh Einzelheite weße wells.

Do sullts en [{{SERVER}}{{SCRIPTPATH}}/COPYING Kopie vun dä <i lang="en">GNU General Public License</i>] zosamme met däm Projramm krääje han, un wann nit, schrief aan de: <i lang="en">Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA </i> udder [//www.gnu.org/licenses/old-licenses/gpl-2.0.html liß se em Internet noh].',
	'version-software' => 'Installeete Soffwäer',
	'version-software-product' => 'Produk',
	'version-software-version' => 'Version',
);

$messages['ku-latn'] = array(
	'variants' => 'Variyant',
	'view' => 'Bibîne',
	'views' => 'Dîtin',
	'viewcount' => 'Ev rûpel {{PLURAL:$1|carekê|caran}} tê xwestin.',
	'view-pool-error' => 'Bibore, server niha zêde barkirî ne. Gelek bikarhêner niha hewl didin ku vê rûpelê bibînin. Ji kerema xwe kêlîkekê bisekine, berî ku tu dîsa hewl bidî rûpelê bibînî.',
	'versionrequired' => 'Versiyona $1 a MediaWiki pêwîst e',
	'versionrequiredtext' => 'Versiyona $1 a MediaWiki ji bo bikaranîna vê rûpelê pêwîst e. Li [[Special:Versiyon|rûpela versiyonê]] binêre.',
	'viewsourceold' => 'çavkaniyan bibîne',
	'viewsourcelink' => 'çavkaniyan bibîne',
	'viewdeleted' => 'Li $1 binêre?',
	'viewsource' => 'Çavkaniyê bibîne',
	'viewsourcetext' => 'Tu dikarî li çavkaniya vê rûpelê binêrî û wê kopî bikî:',
	'virus-unknownscanner' => 'Antîvîrusa nenas:',
	'viewpagelogs' => 'Guhertinên vê rûpelê bibîne',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Rûpelên vemirandî seke',
	'variantname-ku-arab' => 'tîpên erebî',
	'variantname-ku-latn' => 'tîpên latînî',
	'variantname-ku' => 'disable',
	'version' => 'Versiyon',
	'version-specialpages' => 'Rûpelên taybet',
	'version-other' => 'yên din',
	'version-version' => ' (Verzîyon $1)',
	'version-license' => 'Destûr',
	'version-software-product' => 'Berhem',
	'version-software-version' => 'Versiyon',
);

$messages['kw'] = array(
	'view' => 'Gweles',
	'viewdeleted_short' => 'Gweles {{PLURAL:$1|udn janj dileys|$1 chanj dileys}}',
	'views' => 'Gwelyow',
	'viewsourceold' => 'gweles an bednfenten',
	'viewsourcelink' => 'gweles an fenten',
	'viewdeleted' => 'Gweles $1?',
	'viewsource' => 'Gweles an bednfenten',
	'viewpagelogs' => 'Gweles covnotednow an folen-ma',
	'viewprevnext' => 'Gweles ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Versyon',
	'version-other' => 'Aral',
	'version-version' => '(Versyon $1)',
);

$messages['ky'] = array(
	'variants' => 'Варианттар',
	'views' => 'Көрсөтүүлөр',
	'viewsourceold' => 'байкоо',
	'viewsourcelink' => 'Байкоо',
	'viewsource' => 'Байкоо',
	'viewpagelogs' => 'Бул барак үчүн тизмелерди кара',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) кара',
	'version' => 'Версия',
);

$messages['la'] = array(
	'variants' => 'Variantes',
	'view' => 'Legere',
	'viewdeleted_short' => 'Inspicere {{PLURAL:$1|unam emendationem deletam|$1 emendationes deletas}}',
	'views' => 'Visae',
	'viewcount' => 'Haec pagina iam vista est {{PLURAL:$1|semel|$1 vices}}.',
	'versionrequired' => 'MediaWiki versio $1 necesse',
	'versionrequiredtext' => 'MediaWiki versio $1 necesse est ad hanc paginam videndum.
Vide [[Special:Version|paginam versionis]].',
	'viewsourceold' => 'fontem inspicere',
	'viewsourcelink' => 'fontem inspicere',
	'viewdeleted' => 'Visne conspicere $1?',
	'viewsource' => 'Fontem inspicere',
	'viewsourcetext' => 'Fontem videas et exscribeas:',
	'virus-badscanner' => "Configuratio mala: scrutator virorum ignotus: ''$1''",
	'virus-scanfailed' => 'scrutinium fefellit (codex $1)',
	'virus-unknownscanner' => 'antivirus incognitus:',
	'viewpagelogs' => 'Vide acta huius paginae',
	'viewprevnext' => 'Videre ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Paginas deletas inspicere',
	'version' => 'Versio',
	'version-specialpages' => 'Paginae speciales',
	'version-parserhooks' => 'Extensiones programmatis analysis lexicalis',
	'version-variables' => 'Variabilia',
	'version-other' => 'Alia',
	'version-hooks' => 'Extensiones',
	'version-extension-functions' => 'Functiones extensionum',
	'version-parser-function-hooks' => 'Extensiones functionum programmatis analysis lexicalis',
	'version-hook-name' => 'Nomen extensionis',
	'version-hook-subscribedby' => 'Subscriptum ab',
	'version-version' => '(Versio $1)',
	'version-license' => 'Permissio',
	'version-software-product' => 'Productum',
	'version-software-version' => 'Versio',
);

$messages['lad'] = array(
	'variants' => 'Varyantes',
	'view' => 'Ver',
	'viewdeleted_short' => 'Ver {{PLURAL:$1|un trocamiento efassado|$1 trocamientos efassados}}',
	'views' => 'Vistas',
	'viewsourceold' => 'Ver su manadero',
	'viewsourcelink' => 'ver su manadero',
	'viewdeleted' => 'Desea ver $1?',
	'viewsource' => 'Ver su manadero',
	'viewpagelogs' => 'Ver los registros de esta hoja',
	'viewprevnext' => 'Ver ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'Versión',
	'version-specialpages' => 'Pajinas espesiales',
	'version-other' => 'Otros',
	'version-version' => '(Versión $1)',
	'version-poweredby-others' => 'otros',
	'version-software-version' => 'Versión',
);

$messages['lb'] = array(
	'variants' => 'Varianten',
	'view' => 'Weisen',
	'viewdeleted_short' => '{{PLURAL:$1|Eng geläschte Versioun|$1 geläschte Versioune}} weisen',
	'views' => 'Affichagen',
	'viewcount' => 'Dës Säit gouf bis elo {{PLURAL:$1|emol|$1-mol}} ofgefrot.',
	'view-pool-error' => "Pardon, d'Servere si fir de Moment iwwerlaascht.
Zevill Benotzer versichen dës Säit ze gesinn.
Waart w.e.g. e bëssen ier Dir versicht dës Säit nach emol opzeruffen.

$1",
	'versionrequired' => 'Versioun $1 vu MediaWiki gëtt gebraucht',
	'versionrequiredtext' => "D'Versioun $1 vu MediaWiki ass néideg, fir dës Säit ze benotzen. Kuckt d'[[Special:Version|Versiounssäit]]",
	'viewsourceold' => 'Quellcode kucken',
	'viewsourcelink' => 'Quelltext weisen',
	'viewdeleted' => 'Weis $1?',
	'viewsource' => 'Quelltext kucken',
	'viewsource-title' => 'Quelltext vun der Säit $1 weisen',
	'viewsourcetext' => 'Dir kënnt de Quelltext vun dëser Säit kucken a kopéieren:',
	'viewyourtext' => "Dir kënnt de Quelltext vun '''Ären Ännerungen''' op dëser Säit kucken a kopéieren:",
	'virus-badscanner' => "Schlecht Configuratioun: onbekannte  Virescanner: ''$1''",
	'virus-scanfailed' => 'De Scan huet net fonctionnéiert (Code $1)',
	'virus-unknownscanner' => 'onbekannten Antivirus:',
	'viewpagelogs' => 'Logbicher fir dës Säit weisen',
	'viewprevnext' => 'Weis ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => "Dëse Fichier huet d'Fichiers-Iwwerpréifung net passéiert.",
	'viewdeletedpage' => 'Geläschte Säite weisen',
	'version' => 'Versioun',
	'version-extensions' => 'Installéiert Erweiderungen',
	'version-specialpages' => 'Spezialsäiten',
	'version-parserhooks' => 'Parser-Erweiderungen',
	'version-variables' => 'Variabelen',
	'version-antispam' => 'Spam-Preventioun',
	'version-skins' => 'Skins/Layout',
	'version-other' => 'Aner',
	'version-mediahandlers' => 'Medien-Ënnerstëtzung',
	'version-hooks' => 'Klameren',
	'version-extension-functions' => 'Funktioune vun den Erweiderungen',
	'version-parser-extensiontags' => "Parser-Erweiderungen ''(Taggen)''",
	'version-parser-function-hooks' => 'Parser-Funktiounen',
	'version-hook-name' => 'Numm vun der Klamer',
	'version-hook-subscribedby' => 'Opruff vum',
	'version-version' => '(Versioun $1)',
	'version-license' => 'Lizenz',
	'version-poweredby-credits' => "Dës Wiki fonctionnéiert mat '''[//www.mediawiki.org/ MediaWiki]''', Copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'anerer',
	'version-license-info' => "MediaWiki ass fräi Software; Dir kënnt se weiderginn an/oder s'änneren ënnert de Bedingungen vun der GNU-General Public License esou wéi se vun der Free Softare Foundation publizéiert ass; entweder ënner der Versioun 2 vun der Lizenz, oder (no Ärem Choix) enger spéiderer Versioun.

MediaWiki gëtt verdeelt an der Hoffnung datt se nëtzlech ass, awer OUNI IERGENDENG GARANTIE; ouni eng implizit Garantie vu Commercialisatioun oder Eegnung fir e bestëmmte Gebrauch. Kuckt d'GPU Geral Public License fir méi Informatiounen.

Dir misst eng [{{SERVER}}{{SCRIPTPATH}}/COPYING Kopie vun der GNU General Public License] mat dësem Programm kritt hunn; wann net da schreift der Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA oder [//www.gnu.org/licenses/old-licenses/gpl-2.0.html liest se online].",
	'version-software' => 'Installéiert Software',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Versioun',
);

$messages['lez'] = array(
	'variants' => 'Жуьреяр',
	'view' => 'Килигун',
	'views' => 'Килигунар',
	'viewsourceold' => 'сифте кьилин коддиз килига',
	'viewsourcelink' => 'Сифте кьилин коддиз килига',
	'viewdeleted' => '$1 килигун?',
	'viewsource' => 'Килигун',
	'virus-unknownscanner' => 'Малумтушир антивирус',
	'viewpagelogs' => 'И ччиниз талукь тир журналар къалура',
	'viewprevnext' => 'Килигун ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['lfn'] = array(
	'views' => 'Vides',
	'viewcount' => 'Esta paje es asesada a $1 {{PLURAL:$1|ves|veses}}.',
	'viewsourceold' => 'vide orijin',
	'viewsourcelink' => 'vide orijin',
	'viewdeleted' => 'Vide $1?',
	'viewsource' => 'Vide la orijin',
	'viewsourcetext' => 'Tu pote vide e copia la orijin de esta paje:',
	'viewpagelogs' => 'Vide la arcivo de esta paje',
	'viewprevnext' => 'Vide ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Varia',
	'version-version' => '(Varia $1)',
);

$messages['lg'] = array(
	'view' => 'Lukebere',
	'viewdeleted_short' => 'Kebera {{PLURAL:$1|oluwandika olwagyibwawo olumu|empandika ezagyibwawo $1}}',
	'views' => "Kyusa endabika ya by'olaba wano",
	'viewcount' => 'Luno olupapula lwakasomebwa {{PLURAL:$1|omurundi gumu|emirundi $1}}.',
	'view-pool-error' => "Tukwetondera olw'obutasabola okukuwereza olupapula lw'oyagala okulaba ku saawa eno.
Olw'obungi bw'abakebera olupapula olwo, kompyuta zaffe tezisobola kwongerako mulala.
Lindako akaseera oddemu ogezeeko okulukebera.

$1",
	'versionrequired' => "Kyetaagisa MediaWiki ey'oluwandika $1",
	'versionrequiredtext' => "Olupapula luno lwetaagisa MediaWiki ey'oluwandika $1.<br />
Kebera ku [[Special:Version|lukalala lw'empandika za MediaWiki]].",
	'viewsourceold' => "kebera obulambike obw'ennono obw'olupapula luno",
	'viewsourcelink' => "kebera obulambike obw'ennono obw'olupapula luno",
	'viewdeleted' => 'Oyagala okulaba $1?',
	'viewsource' => "Kebera obulambike obw'ennono obw'olupapula luno",
	'viewsourcetext' => "Obulambe obw'ekiwandike eky'ennono eky'olupapula luno osobola okubukebera n'okubugyamu koppi:",
	'virus-badscanner' => "Kiremya mu nteekateeka: ekinoonya vayirasi kino tekimanyidwa: ''$1''",
	'virus-scanfailed' => 'okunoonya vayirasi kulemye (obubaka buli $1)',
	'virus-unknownscanner' => 'ekinoonya vayirasi ekitamanyidwa:',
	'viewpagelogs' => "Kebera likooda ez'olupapula luno",
	'viewprevnext' => 'Laga ($1 {{int:pipe-separator}} $2) ($3).',
	'version-specialpages' => 'Empapula enjawule',
);

$messages['li'] = array(
	'variants' => 'Anger vorme',
	'view' => 'Bekieke',
	'viewdeleted_short' => '{{PLURAL:$1|ein eweggesjafde versie|$1 eweggesjafde versies}} bekieke',
	'views' => 'Weergave',
	'viewcount' => 'Dees pazjena is {{PLURAL:$1|1 kier|$1 kier}} bekeke.',
	'view-pool-error' => "Ós excuses, de servers zeen noe euverbelas.
Te väöl gebroekers perberen óm dees pazjena te bekieke.
Wach estebleef nag efkes veudet g'r óppernuuj toegank verzeuk te kriege toet dees pazjena.

$1",
	'versionrequired' => 'Versie $1 van MediaWiki is vereis',
	'versionrequiredtext' => 'Versie $1 van MediaWiki is vereis om dees pagina te gebroeke. Bekiek [[Special:Version|Softwareversie]]',
	'viewsourceold' => 'brónteks tuine',
	'viewsourcelink' => 'brónteks tuine',
	'viewdeleted' => '$1 tuine?',
	'viewsource' => 'Bekiek brónteks',
	'viewsource-title' => 'Bekiek brón van $1',
	'viewsourcetext' => 'De kèns de brónteks van dees pagina bekieke en kopiëre:',
	'viewyourtext' => 'Doe kans "dien bewèrkinge" ane brónteks van dees pagina bekieke en euverkopiëre:',
	'virus-badscanner' => "Slechte configuratie: onbekenge virusscanner: ''$1''",
	'virus-scanfailed' => 'scanne is mislukt (code $1)',
	'virus-unknownscanner' => 'onbekeng antivirus:',
	'viewpagelogs' => 'Logbeuk veur dees pazjena tuine',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) bekieke.',
	'verification-error' => 'De verificatie van t bestandj det se probeers te uploade is misluk.',
	'viewdeletedpage' => "Betrach eweggesjafde pagina's",
	'version' => 'Versie',
	'version-extensions' => 'Geïnstalleerde oetbreijinge',
	'version-specialpages' => "Speciaal pazjena's",
	'version-parserhooks' => 'Parserheuk',
	'version-variables' => 'Variabele',
	'version-antispam' => 'Spampreventie',
	'version-skins' => 'Vörmgevinge',
	'version-other' => 'Euverige',
	'version-mediahandlers' => 'Mediaverwerkers',
	'version-hooks' => 'Heuk',
	'version-extension-functions' => 'Oetbreijingsfuncties',
	'version-parser-extensiontags' => 'Parseroetbreijingstags',
	'version-parser-function-hooks' => 'Parserfunctieheuk',
	'version-hook-name' => 'Hooknaam',
	'version-hook-subscribedby' => 'Geabonneerd door',
	'version-version' => '(Versie $1)',
	'version-license' => 'Licentie',
	'version-poweredby-credits' => "Deze wiki weurt aangedreve door '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'anger',
	'version-license-info' => "MediaWiki is vrieje sofware; de kins MediaWiki verspreien en/of aanpassen onger de veurwaerde van de GNU General Public License wie gepubliceerd door de Free Software Foundation; ofwaal versie 2 van de Licentie, of - nao diene wönsj - innig later versie.

MediaWiki weurd verspreid in de haop det 't nuttig is, mer ZONGER INNIG GARANTIE; zonger zelfs de implicitiete garantie van VERKOUPBAARHEID of GESJIKHEID VEUR INNIG DOEL IN 'T BIEZÖNJER. Zuuch de GNU General Public License veur mier informatie.

Same mit dit programma heurs se 'n [{{SERVER}}{{SCRIPTPATH}}/COPYING kopie van de GNU General Public License] te höbben ontvange; zo neet, sjrief den nao de Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA of [//www.gnu.org/licenses/old-licenses/gpl-2.0.html laes de licentie online].",
	'version-software' => 'Geïnstallieërde sofwaer',
	'version-software-product' => 'Perduk',
	'version-software-version' => 'Versie',
);

$messages['lij'] = array(
	'variants' => 'Diferense',
	'views' => 'Vìxite',
	'viewcount' => "'Sta paggina a l'è stæta vista {{PLURAL:$1|solo 'na vòtta|$1 vòtte}}.",
	'viewsourceold' => 'veddi a sorgénte',
	'viewsourcelink' => 'Veddi a sorgénte',
	'viewdeleted' => 'Vedde $1?',
	'viewsource' => 'Veddi a fonte',
	'viewsourcetext' => "O l'è poscibbile vedde e copiâ o còddice sorgente de 'sta paggina:",
	'viewpagelogs' => "Veddi i log relativi a 'sta paggina.",
	'viewprevnext' => 'Veddi ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'Verscion',
);

$messages['liv'] = array(
	'variants' => 'Varianţõd',
	'views' => 'vaņtlimiži',
	'viewsourceold' => 'vaņ ovāt-tekstõ',
	'viewsourcelink' => 'vaņ ovāt-tekstõ',
	'viewsource' => 'Vaņ ovāt tekstõ',
	'viewpagelogs' => 'Vaņ sīe līed logīdi',
	'viewprevnext' => 'Nägţõgid ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['lmo'] = array(
	'variants' => 'Variant',
	'views' => 'Visid',
	'viewcount' => "Quela pagina chì a l'è stada legiüda {{PLURAL:$1|una völta|$1 völta}}.",
	'view-pool-error' => "Ne rincress, ma i server a hinn bej caregaa al mument.
Trop drovat a hinn 'dree pruvà a vardà quela pagina chì.
Per piasè, specia un mument prima de pruà a vardà anmò quela pagina chì.

$1",
	'versionrequired' => 'Al ghe va per forza la versión $1 de MediaWiki',
	'versionrequiredtext' => 'Per duprà quela pagina chì la ghe va la versión $1 del prugrama MediaWiki. Varda [[Special:Version]]',
	'viewsourceold' => 'fà vidè el codes surgent',
	'viewsourcelink' => 'fà vidè el codes surgent',
	'viewdeleted' => 'Te vöret vidè $1?',
	'viewsource' => 'Còdas surgent',
	'viewsourcetext' => "L'è pussibil vèd e cupià el codes surgent de cula pagina chí:",
	'viewpagelogs' => 'Varda i register de quela pagina chì',
	'viewprevnext' => 'Vidé ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'Versiun',
);

$messages['ln'] = array(
	'view' => 'Komɔ́nisa',
	'views' => 'Bomɔ́nisi',
	'viewsourceold' => 'Komɔ́nisa mosólo',
	'viewsourcelink' => 'komɔ́nisa mosólo',
	'viewsource' => 'Komɔ́nisa mosólo',
	'viewpagelogs' => 'Komɔ́nisa zuluná ya lonkásá loye',
	'viewprevnext' => 'Komɔ́na ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['lo'] = array(
	'views' => 'ເທື່ອເບິ່ງ',
	'viewcount' => 'ໜ້ານີ້ຖືກເຂົ້າເບິ່ງ {{PLURAL:$1|ເທື່ອໜຶ່ງ|$1 ເທື່ອ}}.',
	'versionrequired' => 'ຕ້ອງການເວີຣ໌ຊັ່ນ $1 ຂອງມີເດຍວິກິ',
	'viewsourceold' => 'ເບິ່ງ ຊອສ',
	'viewdeleted' => 'ເບິ່ງ $1 ບໍ?',
	'viewsource' => 'ເບິ່ງຊອສ໌',
	'viewpagelogs' => 'ເບິ່ງບັນທຶກ ຂອງ ໜ້ານີ້',
	'viewprevnext' => 'ເບິ່ງ ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'ເບິ່ງໜ້າທີ່ຖືກລຶບ',
	'version' => 'ສະບັບ',
);

$messages['loz'] = array(
	'views' => 'Kamukile',
	'viewcount' => 'Bye petulo sa akusi {{PLURAL:$1|1×|$1×}}.',
	'versionrequired' => 'Pane $1 di MediaWiki sa nidyisize',
	'versionrequiredtext' => 'Pane $1 di MediaWiki sa nidyisize di sebesize bye petulo. Kamukile [[Special:Version|pane]].',
	'viewdeleted' => 'Kamukile $1?',
	'viewsource' => "Kamukile ng'i",
	'viewsourcetext' => 'A sa kamukile wiki-selt di bye petulo:',
	'viewpagelogs' => 'Kamukile desu di petulo',
	'viewprevnext' => 'Kamukile ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Kamukile afi kulobala petulo',
	'version' => 'Pane',
);

$messages['lt'] = array(
	'variants' => 'Variantai',
	'view' => 'Žiūrėti',
	'viewdeleted_short' => 'Peržiūrėti $1 {{PLURAL:$1|ištrintą keitimą|ištrintus keitimus|ištrintų keitimų}}',
	'views' => 'Žiūrėti',
	'viewcount' => 'Šis puslapis buvo atvertas $1 {{PLURAL:$1|kartą|kartus|kartų}}.',
	'view-pool-error' => 'Atsiprašome, šiuo metu serveriai yra perkrauti.
Pernelyg daug naudotojų skaito šį puslapį.
Prašome palaukti ir bandyti į šį puslapį patekti dar kartą.

$1',
	'versionrequired' => 'Reikalinga $1 MediaWiki versija',
	'versionrequiredtext' => 'Reikalinga $1 MediaWiki versija, kad pamatytumėte šį puslapį. Žiūrėkite [[Special:Version|versijos puslapį]].',
	'viewsourceold' => 'žiūrėti šaltinį',
	'viewsourcelink' => 'žiūrėti kodą',
	'viewdeleted' => 'Rodyti $1?',
	'viewsource' => 'Žiūrėti kodą',
	'viewsource-title' => 'Peržiūrėti šaltinį $1',
	'viewsourcetext' => 'Jūs galite žiūrėti ir kopijuoti puslapio kodą:',
	'viewyourtext' => "Jūs galite matyti ir kopijuoti '''savo redagavimų''' tekstą į šį puslapį:",
	'virus-badscanner' => "Neleistina konfigūracija: nežinomas virusų skeneris: ''$1''",
	'virus-scanfailed' => 'skanavimas nepavyko (kodas $1)',
	'virus-unknownscanner' => 'nežinomas antivirusas:',
	'viewpagelogs' => 'Rodyti šio puslapio specialiuosius veiksmus',
	'viewprevnext' => 'Žiūrėti ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Šis failas nepraėjo patikrinimo.',
	'viewdeletedpage' => 'Rodyti ištrintus puslapius',
	'version' => 'Versija',
	'version-extensions' => 'Įdiegti priedai',
	'version-specialpages' => 'Specialieji puslapiai',
	'version-parserhooks' => 'Analizatoriaus gaudliai',
	'version-variables' => 'Kintamieji',
	'version-antispam' => 'Apsauga nuo šlamšto',
	'version-skins' => 'Išvaizda',
	'version-other' => 'Kita',
	'version-mediahandlers' => 'Daugialypės terpės grotuvai',
	'version-hooks' => 'Gaudliai',
	'version-extension-functions' => 'Papildomos funkcijos',
	'version-parser-extensiontags' => 'Analizatoriaus papildomosios gairės',
	'version-parser-function-hooks' => 'Analizatoriaus funkciniai gaudliai',
	'version-hook-name' => 'Gaudlio pavadinimas',
	'version-hook-subscribedby' => 'Užsakyta',
	'version-version' => '(Versija $1)',
	'version-license' => 'Licencija',
	'version-poweredby-credits' => "Šis projektas naudoja '''[//www.mediawiki.org/ MediaWiki]''', autorystės teisės © 2001-$1 $2.",
	'version-poweredby-others' => 'kiti',
	'version-license-info' => 'MediaWiki yra nemokama programinė įranga; galite ją platinti ir/arba modifikuoti pagal GNU General Public License, kurią publikuoja Free Software Foundation; taikoma 2-oji licenzijos versija arba (Jūsų pasirinkimu) bet kuri vėlesnė versija.

MediaWiki yra platinama su viltimi, kad ji bus naudinga, bet BE JOKIOS GARANTIJOS; be jokios numanomos PARDAVIMO arba TINKAMUMO TAM TIKRAM TIKSLUI garantijos. Daugiau informacijos galite sužinoti GNU General Public License.

Jūs turėjote gauti [{{SERVER}}{{SCRIPTPATH}}/COPYING GNU General Public License kopiją] kartu su šia programa, jei ne, rašykite Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, JAV arba [//www.gnu.org/licenses/old-licenses/gpl-2.0.html perskaitykite ją internete].',
	'version-software' => 'Įdiegta programinė įranga',
	'version-software-product' => 'Produktas',
	'version-software-version' => 'Versija',
);

$messages['ltg'] = array(
	'variants' => 'Varianti',
	'view' => 'Vērtīs',
	'views' => 'Vierīņi',
	'viewsourcelink' => 'Apsavērt suokūtnejū kodu',
	'viewsource' => 'Apsavērt kodu',
	'viewpagelogs' => 'Apsavērt ar itū lopu saisteitūs registru īrokstus',
	'viewprevnext' => 'Apsavērt ($1 {{int:pipe-separator}} $2) ($3 vīnā lopā).',
	'version' => 'Verseja',
	'version-specialpages' => 'Specialuos puslopys',
	'version-license' => 'Liceņceja',
	'version-poweredby-others' => 'cyti',
	'version-software-product' => 'Produkts',
	'version-software-version' => 'Verseja',
);

$messages['lv'] = array(
	'variants' => 'Varianti',
	'view' => 'Skatīt',
	'viewdeleted_short' => 'Apskatīt {{PLURAL:$1|vienu dzēstu labojumu|$1 dzēstus labojumus}}',
	'views' => 'Apskates',
	'viewcount' => 'Šī lapa ir tikusi apskatīta $1 {{PLURAL:$1|reizi|reizes}}.',
	'view-pool-error' => 'Atvainojiet, šobrīd serveri ir pārslogoti.
Pārāk daudz lietotāju mēģina apskatīt šo lapu.
Lūdzu, brīdi uzgaidiet un mēģiniet šo lapu apskatīties vēlreiz.

$1',
	'versionrequired' => "Nepieciešamā ''MediaWiki'' versija: $1.",
	'versionrequiredtext' => "Lai lietotu šo lapu, nepieciešama ''MediaWiki'' versija $1. Sk. [[Special:Version|versija]].",
	'viewsourceold' => 'aplūkot kodu',
	'viewsourcelink' => 'Skatīt pirmkodu',
	'viewdeleted' => 'Skatīt $1?',
	'viewsource' => 'Aplūkot kodu',
	'viewsourcetext' => 'Tu vari apskatīties un nokopēt šīs lapas vikitekstu:',
	'virus-badscanner' => "Nekorekta konfigurācija: nezināms vīrusu skeneris: ''$1''",
	'virus-scanfailed' => 'skenēšana neizdevās (kods $1)',
	'virus-unknownscanner' => 'nezināms antivīruss:',
	'viewpagelogs' => 'Apskatīt ar šo lapu saistītos reģistru ierakstus',
	'viewprevnext' => 'Skatīt ($1 {{int:pipe-separator}} $2) ($3 vienā lapā).',
	'verification-error' => 'Šis fails neizturēja failu pārbaudi.',
	'viewdeletedpage' => 'Skatīt izdzēstās lapas',
	'version' => 'Versija',
	'version-extensions' => 'Ieinstalētie paplašinājumi',
	'version-specialpages' => 'Īpašās lapas',
	'version-variables' => 'Mainīgie',
	'version-antispam' => 'Spama aizsardzība',
	'version-skins' => 'Apdares',
	'version-other' => 'Cita',
	'version-hooks' => 'Aizķeres',
	'version-hook-name' => 'Aizķeres nosaukums',
	'version-version' => '(Versija $1)',
	'version-license' => 'Licence',
	'version-poweredby-credits' => "Šis viki darbojas ar '''[//www.mediawiki.org/ MediaWiki]''' programmatūru, autortiesības © 2001-$1 $2.",
	'version-poweredby-others' => 'citi',
	'version-software' => 'Instalētā programmatūra',
	'version-software-product' => 'Produkts',
	'version-software-version' => 'Versija',
);

$messages['lzh'] = array(
	'variants' => '變字',
	'view' => '察',
	'viewdeleted_short' => '察$1已刪',
	'views' => '覽',
	'viewcount' => '此頁$1閱矣',
	'view-pool-error' => '歉也，伺服器超負矣。
多簿查頁。
欲試候之。

$1',
	'versionrequired' => '惠置$1媒維基',
	'versionrequiredtext' => '惠置$1媒維基，見[[Special:Version|版]]。',
	'viewsourceold' => '察源碼',
	'viewsourcelink' => '察源碼',
	'viewdeleted' => '閱$1之？',
	'viewsource' => '覽源',
	'viewsourcetext' => '爾可視及複之本頁之原始碼。',
	'virus-badscanner' => "壞設：不明之病掃：''$1''",
	'virus-scanfailed' => '敗掃（碼$1）',
	'virus-unknownscanner' => '不明之反毒：',
	'viewpagelogs' => '覽誌',
	'viewprevnext' => '見（$1 {{int:pipe-separator}} $2）（$3）',
	'verification-error' => '檔未証也。',
	'viewdeletedpage' => '覽刪',
	'video-dims' => '$1，$2矩$3',
	'version' => '版',
	'version-extensions' => '裝展',
	'version-specialpages' => '奇頁',
	'version-parserhooks' => '語鈎',
	'version-variables' => '變數',
	'version-antispam' => '垃圾之防',
	'version-skins' => '皮',
	'version-other' => '他',
	'version-mediahandlers' => '媒處',
	'version-hooks' => '鈎',
	'version-extension-functions' => '展函',
	'version-parser-extensiontags' => '語展標',
	'version-parser-function-hooks' => '語函鈎',
	'version-hook-name' => '鈎名',
	'version-hook-subscribedby' => '用於',
	'version-version' => '（版 $1）',
	'version-license' => '牌',
	'version-poweredby-credits' => "此 Wiki 以 '''[//www.mediawiki.org/ MediaWiki]''' 之驅，權 © 2001-$1 $2。",
	'version-poweredby-others' => '其他',
	'version-license-info' => 'MediaWiki乃自由軟件；爾依自由軟件基金會之GNU通用公共授權之款，就此本程序再發佈及／或修；依之二版（自選之）或後之。

MediaWiki乃為用之發，無擔之責也；亦無售目之默擔也。參GNU通用公共授權之詳。

爾乃收附本程序之[{{SERVER}}{{SCRIPTPATH}}/COPYING GNU通用公共授權副本]；如無者，致函至自由軟件基金會：51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA，或[//www.gnu.org/licenses/old-licenses/gpl-2.0.html 閱之]。',
	'version-software' => '裝件',
	'version-software-product' => '品',
	'version-software-version' => '版',
);

$messages['lzz'] = array(
	'views' => 'Oz*iramepe',
	'viewsourcelink' => 'odude koz*iri',
	'viewsource' => 'Odudes o3ʼkʼedi',
	'viewpagelogs' => 'Am butʼkʼa şeni kʼayitʼepe ko3ʼiri',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['mai'] = array(
	'variants' => 'प्रकार सभ',
	'view' => 'देखू',
	'viewdeleted_short' => 'देखू {{PLURAL:$1|एकटा मेटाएल सम्पादन|$1 मेटाएल सम्पादन सभ}}',
	'views' => 'दृष्टि',
	'viewcount' => 'ई पन्ना देखल गेल {{PLURAL:$1|एक बेर|$1 एतेक बेर}}',
	'view-pool-error' => 'दुखी छी, वितरक सभ एखन व्यस्त अछि।
बड्ड बेशी लोक ऐ पन्नाकेँ देखबामे लागल छथि।
ऐ पन्नाकेँ फेरसँ देखबा लेल कनी बिलमू।
$1',
	'versionrequired' => 'मीडियाविकीक संस्करण $1 चाही',
	'versionrequiredtext' => 'ऐ पन्नाक प्रयोग लेल मीडियाविकीक संस्करण $1 चाही।
देखू ee [[Special:Version|version page]]',
	'viewsourceold' => 'जड़ि देखू',
	'viewsourcelink' => 'जड़ि देखू',
	'viewdeleted' => 'देखू $1?',
	'viewsource' => 'जड़ि देखू',
	'viewsource-title' => '"$1" लेल जड़ि देखू',
	'viewsourcetext' => 'अहाँ ऐ पन्नाक जड़िकेँ देख आ अनुकृत कऽ सकै छी:',
	'viewyourtext' => "अहाँ '''अहाँक सम्पादन''' केँ देख आ एतए उतारि सकै छी:",
	'virus-badscanner' => "खराप विन्यास: अज्ञात विषविधि बिम्बक: ''$1''",
	'virus-scanfailed' => 'बिम्ब विफल (विध्यादेश $1)',
	'virus-unknownscanner' => 'अज्ञात विषविधि निरोधक',
	'viewpagelogs' => 'ऐ पन्नाक वृत्तलेख सभ देखू',
	'viewprevnext' => 'देखू  ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'ई संचिका संचिका-सत्यापन नै दऽ सकल।',
	'viewdeletedpage' => 'मेटाएल पन्ना देखू',
	'video-dims' => '$1, $2 × $3',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
	'variantname-zh-sg' => 'sg',
	'variantname-zh-my' => 'my',
	'variantname-zh' => 'zh',
	'version' => 'संस्करण',
	'version-extensions' => 'संस्करणक आगाँ',
	'version-specialpages' => 'खास पन्ना',
	'version-parserhooks' => 'पार्सर हूक',
	'version-variables' => 'विकारी',
	'version-antispam' => 'अनिष्ट संदेश प्रतिबन्ध',
	'version-skins' => 'रूप',
	'version-other' => 'आन',
	'version-mediahandlers' => 'मीडिया संचालक',
	'version-hooks' => 'हूक',
	'version-extension-functions' => 'प्रकार्य बढ़ाउ',
	'version-parser-extensiontags' => 'विभाजन बढल चेन्ह',
	'version-parser-function-hooks' => 'विभाजक प्रकार्य खुट्टी',
	'version-hook-name' => 'खुट्टीक नाम',
	'version-hook-subscribedby' => 'ई सदस्यता लेलनि',
	'version-version' => '(संस्करण $1)',
	'version-license' => 'अधिकार',
	'version-poweredby-credits' => "ई विकी चालित अछि '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2",
	'version-poweredby-others' => 'आन',
	'version-license-info' => 'मीडियाविकी एकटा मंगनीक तंत्रांश अछि; अहाँ एकरा बाँटि सकै छी आ/ वा संशोधित कऽ सकै छीगी.एन.यू. सामान्य जन लाइसेन्सक अन्तर्गत जेना फ्री सॉफ्टवेयर फाउन्डेशन एकरा प्रकाशित केने अछि; चाहे तँ लाइसेन्सक संस्करण २, वा (अहाँक विकल्पपर) कोनो बादक दोसर संस्करणक अन्तर्गत।

मीडियाविकी ऐ आशामेँ बाँटल जा रहल अछि कि ई उपयोगी हएत, मुदा बिना कोनो गारन्टीक; बिना कोनो व्यापारिक अन्तर्निहित वारन्टीक वा कोनो विशेष काजक लेल उपयोगी हेबाले। देखू गी.एन.यू. सामान्य जन लाइसेन्स विशेष वर्णन लेल।

अहाँ प्राप्त केने हएब [{{SERVER}}{{SCRIPTPATH}}/ अनुकरण गी.एन.यू. सामान्य जन लाइसेन्सक प्रति] ऐ तंत्रांशक संग; जँ नै, लिखू फ्री सॉफ्टवेयर फाउन्डेशन, आइ.एन.सी., ५१, फ्रैंकलिन स्ट्रीट, पाँचम तल, बोस्टन, एम.ए. ०२११०-१३०१, यू.एस.ए. वा [//www.gnu.org/licenses/old-licenses/gpl-2.0.html अन्तर्भूत पढ़बा लेल]।',
	'version-software' => 'प्रतिष्ठापित तंत्रांश',
	'version-software-product' => 'उत्पाद',
	'version-software-version' => 'संस्करण',
);

$messages['map-bms'] = array(
	'variants' => 'Varian',
	'view' => 'Deleng',
	'viewdeleted_short' => 'Deleng {{PLURAL:$1|siji suntingan|$1 suntingan}} sing wis dibusak',
	'views' => 'Tampilan',
	'viewcount' => 'Kaca kiye uwis diakses ping {{PLURAL:$1|sepisan|$1}}',
	'view-pool-error' => 'Nyuwun ngapuro, peladèn lagi sibuk wektu sekiye.
Kakèhan panganggo sing njajal mbukak kaca kiye.
Entèni sedhéla sadurungé njajal ngaksès kaca kiye maning .

$1',
	'versionrequired' => 'Dibutuhna MediaWiki versi $1',
	'versionrequiredtext' => 'MediaWiki versi $1 dibutuhna nggo nggunakna kaca kiye.
Deleng [[Special:Version|kaca versi]].',
	'viewsourceold' => 'deleng sumbere',
	'viewsourcelink' => 'deleng sumbere',
	'viewdeleted' => 'Ndeleng $1?',
	'viewsource' => 'Deleng sumbere',
	'viewsource-title' => 'Deleng sumbere nggo $1',
	'viewsourcetext' => 'Rika teyeng ndeleng lan nyalin sumbere kaca kiye:',
	'viewyourtext' => "Rika teyeng ndeleng lan nyalin sumbere '''suntingane Rika''' nang kaca kiye:",
	'virus-badscanner' => "Kasalahan konfigurasi: pamindai virus ora dikenal: ''$1''",
	'virus-scanfailed' => 'Pemindaian gagal (kode $1)',
	'virus-unknownscanner' => 'Antivirus ora ditepungi:',
	'viewpagelogs' => 'Deleng log-e kaca kiye',
	'viewprevnext' => 'Deleng ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['mdf'] = array(
	'variants' => 'Вариатт',
	'views' => 'Ванфт',
	'viewcount' => 'Тя лопас сувасть {{PLURAL:$1|весть|$1-ксть}}.',
	'versionrequired' => 'Эряви МедиаВикить верзиенц $1',
	'versionrequiredtext' => 'Тя лопать панжеманцты эрявксты МедиаВикить верзие $1. Ванк [[Special:Version|верзиень лопась]].',
	'viewsourceold' => 'лисьма ваномс',
	'viewsourcelink' => 'ваномс лисьмоть',
	'viewdeleted' => 'Ваномс $1?',
	'viewsource' => 'Ваномс лисьмоть',
	'viewsourcetext' => 'Тейть ули кода ваномс эди копиямс тя лопать лисьмоц:',
	'virus-badscanner' => "Аф кондясти конфигурациесь: аф содаф вирусонь вешендема програмсь: ''$1''",
	'virus-scanfailed' => 'програмонь вешендемась изь лисе (code $1)',
	'virus-unknownscanner' => 'аф содаф антивирус:',
	'viewpagelogs' => 'Няфтемс тя лопать историянц',
	'viewprevnext' => 'Ваномс ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Няфтетемс нардаф лопатне',
	'version' => 'MediaWiki-ть верзиец',
	'version-extensions' => 'Нолдаф тевс келепнематне',
	'version-specialpages' => 'Башка тевонь лопат',
	'version-parserhooks' => 'Синтакс анализаторонь кярьмодихне',
	'version-variables' => 'Пингоннет',
	'version-other' => 'Иля',
	'version-mediahandlers' => 'Медиа файлхнень ладямат',
	'version-hooks' => 'Кярьмодихне',
	'version-extension-functions' => 'Келептема функциенза',
	'version-parser-extensiontags' => 'Анализаторонь келептема кодонза',
	'version-parser-function-hooks' => 'Синтаксонь анализаторть функциензон кярьмодихне',
	'version-hook-name' => 'Кярьмодинь лемоц',
	'version-hook-subscribedby' => 'Сёрматфтсь',
	'version-version' => '(Верзие $1)',
	'version-license' => 'Лицензие',
	'version-software' => 'Нолдаф програпне',
	'version-software-product' => 'Нолдафкс',
	'version-software-version' => 'Верзие',
);

$messages['mg'] = array(
	'variants' => "Ny ''skin'' Voasintona",
	'view' => 'Hamaky',
	'viewdeleted_short' => 'Hijery fanovana voafafa {{PLURAL:$1|tokana|$1}}',
	'views' => 'Fijerena',
	'viewcount' => 'voastsidika in-$1 ity pejy ity.{{PLURAL:}}',
	'view-pool-error' => 'Azafady, be asa ny lohamilina ankehitriny.
Betsaka loatra ny mpikambana mitady hijery ity pejy ity.
Miandrasa kely, dia avereno.

$1',
	'versionrequired' => "
Mitaky version $1-n'i MediaWiki",
	'versionrequiredtext' => "Mitaky version $1-n'i MediaWiki ny fampiasana ity pejy ity. Jereo [[Special:Version]].",
	'viewsourceold' => 'hijery fango',
	'viewsourcelink' => 'hijery ny fango',
	'viewdeleted' => "Hijery an'i $1?",
	'viewsource' => 'Hijery fango',
	'viewsourcetext' => "Azonao atao no mijery sy mandrika ny votoatin'ity pejy ity :",
	'virus-badscanner' => "Diso : Tsy fantatray ny mpitady virus ''$1''",
	'virus-scanfailed' => 'Tsy mety alefa ny fitadiavana (kaody $1)',
	'virus-unknownscanner' => 'Tsy fantatra io Antivirus io :',
	'viewpagelogs' => "Hijery ny fanovan'ity pejy ity",
	'viewprevnext' => 'Hijery ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => "Tsy afaka amin'ny fanamarinana rakitra ity rakitra ity.",
	'viewdeletedpage' => 'Hijery ny pejy efa nofafana',
	'version' => 'Santiôna',
	'version-extensions' => 'Fanitarana nampidirina',
	'version-specialpages' => 'Pejy manokana',
	'version-variables' => 'Miova',
	'version-other' => 'Samihafa',
	'version-hook-subscribedby' => "Nalefan'i",
	'version-version' => '(Santiôna $1)',
	'version-license' => 'Lisansy',
	'version-software' => 'Rindrankahy voapetraka',
	'version-software-product' => 'Vokatra',
	'version-software-version' => 'Santiôna',
);

$messages['mhr'] = array(
	'views' => 'Ончалаш',
	'viewsourceold' => 'тӱҥалтыш текстым ончалаш',
	'viewsourcelink' => 'тӱҥалтыш текстым ончалаш',
	'viewdeleted' => 'Ончалаш $1?',
	'viewsource' => 'Тӱҥалтыш текст',
	'virus-badscanner' => "Келыштарымаш йоҥылыш: палыдыме вирус сканер: ''$1''",
	'virus-unknownscanner' => 'палыдыме антивирус:',
	'viewpagelogs' => 'Тиде лаштыклан журнал-влакым ончыкташ',
	'viewprevnext' => 'Ончал ($1 {{int:pipe-separator}} $2) ($3)',
	'version-specialpages' => 'Лӱмын ыштыме лаштык-влак',
);

$messages['min'] = array(
	'variants' => 'Variasi:',
	'view' => 'Tampilkan',
	'viewdeleted_short' => 'Liek {{PLURAL:$1|ciek suntiangan|$1 suntiangan}} nan dihapuih',
	'views' => 'Tampilan',
	'viewcount' => 'Laman iko alah diakses sabanyak {{PLURAL:$1|ciek kali|$1 kali}}.<br />',
	'view-pool-error' => 'Maaf, server sadang sibuak pado kini ko.
Talalu banyak pangguno barusaho mancaliak laman iko.
Tunggu sabanta sabalum Sanak mancubo baliak mangakses laman iko.

$1',
	'versionrequired' => 'Dibutuahkan MediaWiki versi $1',
	'versionrequiredtext' => 'MediaWiki versi $1 dibutuahkan untuak manggunokan laman ijo. Caliak [[Special:Version|laman versi]]',
	'viewsourceold' => 'Caliak sumber',
	'viewsourcelink' => 'Lihek sumber',
	'viewdeleted' => 'Caliak $1?',
	'viewsource' => 'Lihek sumber',
	'viewsourcetext' => 'Sanak dapek malihek atau manyalin sumber laman iko:',
	'virus-badscanner' => "Kasalahan konfigurasi: pamindai virus indak dikenal: ''$1''",
	'virus-scanfailed' => 'Pamindaian gagal (kode $1)',
	'virus-unknownscanner' => 'Antivirus indak dikenal:',
	'viewpagelogs' => 'Lihek log untuak laman ko',
	'viewprevnext' => 'Tampilkan ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['mk'] = array(
	'variants' => 'Варијанти',
	'view' => 'Преглед',
	'viewdeleted_short' => 'Преглед на {{PLURAL:$1|едно избришано уредување|$1 избришани уредувања}}',
	'views' => 'Посети',
	'viewcount' => 'Оваа страница била посетена {{PLURAL:$1|еднаш|$1 пати}}.',
	'view-pool-error' => 'За жал во моментов опслужувачите се преоптоварени.
Премногу корисници се обидуваат да ја прегледаат оваа страница.
Ве молиме почекајте некое време пред повторно да се обидете да пристапите до оваа страница.

$1',
	'versionrequired' => 'Верзијата $1 од МедијаВики е задолжителна',
	'versionrequiredtext' => 'Мора да имате верзија $1 на МедијаВики за да ја користите оваа страница.
Видете [[Special:Version|страница за верзија]].',
	'viewsourceold' => 'преглед на кодот',
	'viewsourcelink' => 'преглед на кодот',
	'viewdeleted' => 'Да погледате $1?',
	'viewsource' => 'Преглед',
	'viewsource-title' => 'Преглед на кодот на $1',
	'viewsourcetext' => 'Можете да го погледнете и копирате кодот на оваа страница:',
	'viewyourtext' => "Можете да го погледнете и копирате кодот на '''вашите уредувања''' на оваа страница:",
	'virus-badscanner' => "Лоша поставка: непознат проверувач на вируси: ''$1''",
	'virus-scanfailed' => 'неуспешно скенирање (код $1)',
	'virus-unknownscanner' => 'непознат антивирус:',
	'viewpagelogs' => 'Преглед на дневници за оваа страница',
	'viewprevnext' => 'Погледајте ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Оваа податотека не ја помина потврдата успешно.',
	'viewdeletedpage' => 'Прегледај ги избришаните страници',
	'video-dims' => '$1, $2 × $3',
	'variantname-zh-hans' => 'hans',
	'variantname-zh-hant' => 'hant',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
	'variantname-zh-sg' => 'sg',
	'variantname-zh-my' => 'my',
	'variantname-zh' => 'zh',
	'variantname-gan-hans' => 'hans',
	'variantname-gan-hant' => 'hant',
	'variantname-gan' => 'gan',
	'variantname-sr-ec' => 'sr-ec',
	'variantname-sr-el' => 'sr-el',
	'variantname-sr' => 'sr',
	'variantname-kk-kz' => 'kk-kz',
	'variantname-kk-tr' => 'kk-tr',
	'variantname-kk-cn' => 'kk-cn',
	'variantname-kk-cyrl' => 'kk-cyrl',
	'variantname-kk-latn' => 'kk-latn',
	'variantname-kk-arab' => 'kk-arab',
	'variantname-kk' => 'kk',
	'variantname-ku-arab' => 'ku-Arab',
	'variantname-ku-latn' => 'ku-Latn',
	'variantname-ku' => 'ku',
	'variantname-tg-cyrl' => 'tg-Cyrl',
	'variantname-tg-latn' => 'tg-Latn',
	'variantname-tg' => 'tg',
	'version' => 'Верзија',
	'version-extensions' => 'Инсталирани додатоци',
	'version-specialpages' => 'Специјални страници',
	'version-parserhooks' => 'Парсерски куки',
	'version-variables' => 'Променливи',
	'version-antispam' => 'Спречување на спам',
	'version-skins' => 'Рува',
	'version-other' => 'Друго',
	'version-mediahandlers' => 'Ракувачи со мултимедијални содржини',
	'version-hooks' => 'Куки',
	'version-extension-functions' => 'Функции на додатоците',
	'version-parser-extensiontags' => 'Ознаки за парсерски додатоци',
	'version-parser-function-hooks' => 'Куки на парсерските функции',
	'version-hook-name' => 'Име на кука',
	'version-hook-subscribedby' => 'Претплатено од',
	'version-version' => '(Верзија $1)',
	'version-svn-revision' => '(рев. $2)',
	'version-license' => 'Лиценца',
	'version-poweredby-credits' => "Ова вики работи на '''[//www.mediawiki.org/ МедијаВики]''', авторски права © 2001-$1 $2.",
	'version-poweredby-others' => 'други',
	'version-license-info' => 'МедијаВики е слободна програмска опрема; можете да ја редистрибуирате и/или менувате под условите на ГНУ-овата општа јавна лиценца на Фондацијата за слободна програмска опрема; или верзија 2 на Лиценцата, или некоја понова верзија (по ваш избор).

МедијаВики се нуди со надеж дека ќе биде од корист, но БЕЗ БИЛО КАКВА ГАРАНЦИЈА; дури и без подразбраната гаранција за ПРОДАЖНА ВРЕДНОСТ или ПОГОДНОСТ ЗА ДАДЕНА ЦЕЛ. За повеќе информации, погледајте ја ГНУ-овата општа јавна лиценца.

Заедно со програмов треба да имате добиено [{{SERVER}}{{SCRIPTPATH}}/COPYING примерок од ГНУ-овата општа јавна лиценца]; ако немате добиено примерок, пишете на Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA или [//www.gnu.org/licenses/old-licenses/gpl-2.0.html прочитајте ја тука].',
	'version-software' => 'Инсталирана програмска опрема',
	'version-software-product' => 'Производ',
	'version-software-version' => 'Верзија',
);

$messages['ml'] = array(
	'variants' => 'ചരങ്ങൾ',
	'view' => 'കാണുക',
	'viewdeleted_short' => '{{PLURAL:$1|മായ്ക്കപ്പെട്ട ഒരു തിരുത്തൽ|മായ്ക്കപ്പെട്ട $1 തിരുത്തലുകൾ}} കാണുക',
	'views' => 'ദർശനീയത',
	'viewcount' => 'ഈ താൾ {{PLURAL:$1|ഒരു തവണ|$1 തവണ}} സന്ദർശിക്കപ്പെട്ടിട്ടുണ്ട്.',
	'view-pool-error' => 'ക്ഷമിക്കണം, ഈ നിമിഷം സെർവറുകൾ അമിതഭാരം കൈകാര്യം ചെയ്യുകയാണ്.
ധാരാളം ഉപയോക്താക്കൾ ഈ താൾ കാണുവാൻ ശ്രമിച്ചുകൊണ്ടിരിക്കുകയാണ്.
ഇനിയും താൾ ലഭ്യമാക്കുവാൻ താങ്കൾ ശ്രമിക്കുന്നതിന് മുൻപ് ദയവായി അല്പസമയം കാത്തിരിക്കുക.

$1',
	'versionrequired' => 'മീഡിയാവിക്കിയുടെ പതിപ്പ് $1 ആവശ്യമാണ്',
	'versionrequiredtext' => 'ഈ താൾ ഉപയോഗിക്കാൻ മീഡിയവിക്കി പതിപ്പ് $1 ആവശ്യമാണ്. കൂടുതൽ വിവരങ്ങൾക്ക് [[Special:Version|മീഡിയാവിക്കി പതിപ്പ് താൾ]] കാണുക.',
	'viewsourceold' => 'മൂലരൂപം കാണുക',
	'viewsourcelink' => 'മൂലരൂപം കാണുക',
	'viewdeleted' => '$1 കാണണോ?',
	'viewsource' => 'മൂലരൂപം കാണുക',
	'viewsource-title' => '$1 എന്ന താളിന്റെ മൂലരൂപം കാണുക',
	'viewsourcetext' => 'താങ്കൾക്ക് ഈ താളിന്റെ മൂലരൂപം കാണാനും പകർത്താനും സാധിക്കും:',
	'viewyourtext' => "താങ്കൾക്ക് ഈ താളിലെ '''താങ്കളുടെ തിരുത്തലുകളുടെ''' മൂലരൂപം കാണാനും പകർത്താനും സാധിക്കും:",
	'virus-badscanner' => "തെറ്റായ ക്രമീകരണങ്ങൾ: അപരിചിതമായ വൈറസ് തിരച്ചിൽ ഉപാധി :  ''$1''",
	'virus-scanfailed' => 'വൈറസ് സ്കാനിങ് പരാജയപ്പെട്ടു (code $1)',
	'virus-unknownscanner' => 'തിരിച്ചറിയാനാകാത്ത ആന്റിവൈറസ്:',
	'viewpagelogs' => 'ഈ താളുമായി ബന്ധപ്പെട്ട രേഖകൾ കാണുക',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2 {{int:pipe-separator}} $3 മാറ്റങ്ങൾ കാണുക)',
	'verification-error' => 'ഈ പ്രമാണം പ്രമാണ പരിശോധന വിജയിച്ചിട്ടില്ല.',
	'viewdeletedpage' => 'നീക്കം ചെയ്ത താളുകൾ കാണുക',
	'version' => 'പതിപ്പ്',
	'version-extensions' => 'ഇൻസ്റ്റോൾ ചെയ്തിട്ടുള്ള അനുബന്ധങ്ങൾ',
	'version-specialpages' => 'പ്രത്യേക താളുകൾ',
	'version-parserhooks' => 'പാഴ്‌സർ കൊളുത്തുകൾ',
	'version-variables' => 'ചരങ്ങൾ',
	'version-antispam' => 'പാഴെഴുത്ത് തടയൽ',
	'version-skins' => 'ദൃശ്യരൂപങ്ങൾ',
	'version-other' => 'മറ്റുള്ളവ',
	'version-mediahandlers' => 'മീഡിയ കൈകാര്യോപകരണങ്ങൾ',
	'version-hooks' => 'കൊളുത്തുകൾ',
	'version-extension-functions' => 'അനുബന്ധങ്ങളുടെ കർത്തവ്യങ്ങൾ',
	'version-parser-extensiontags' => 'പാഴ്‌സർ അനുബന്ധ റ്റാഗുകൾ',
	'version-parser-function-hooks' => 'പാഴ്‌സർ ഫങ്ഷൻ കൊളുത്തുകൾ',
	'version-hook-name' => 'കൊളുത്തിന്റെ പേര്',
	'version-hook-subscribedby' => 'വരിക്കാരനായത്',
	'version-version' => '(പതിപ്പ് $1)',
	'version-license' => 'അനുമതി',
	'version-poweredby-credits' => "ഈ വിക്കി പ്രവർത്തിക്കാൻ '''[//www.mediawiki.org/ മീഡിയവിക്കി]''' ഉപയോഗിക്കുന്നു. പകർപ്പവകാശം © 2001-$1 $2.",
	'version-poweredby-others' => 'മറ്റുള്ളവർ',
	'version-license-info' => 'മീഡിയവിക്കി ഒരു സ്വതന്ത്ര സോഫ്റ്റ്‌വേറാണ്; സ്വതന്ത്ര സോഫ്റ്റ്‌വേർ ഫൗണ്ടേഷൻ പ്രസിദ്ധീകരിച്ചിട്ടുള്ള ഗ്നു സാർവ്വജനിക അനുവാദപത്രത്തിന്റെ പതിപ്പ് 2 പ്രകാരമോ, അല്ലെങ്കിൽ (താങ്കളുടെ ഇച്ഛാനുസരണം) പിന്നീട് പ്രസിദ്ധീകരിച്ച ഏതെങ്കിലും പതിപ്പ് പ്രകാരമോ താങ്കൾക്കിത് പുനർവിതരണം ചെയ്യാനും ഒപ്പം/അല്ലെങ്കിൽ മാറ്റങ്ങൾ വരുത്താനും സാധിക്കുന്നതാണ്.

മീഡിയവിക്കി താങ്കൾക്കുപകരിക്കുമെന്ന പ്രതീക്ഷയോടെയാണ് വിതരണം ചെയ്യുന്നത്, പക്ഷേ യാതൊരു ഗുണമേന്മോത്തരവാദിത്തവും വഹിക്കുന്നില്ല; വ്യാപാരയോഗ്യമെന്നോ പ്രത്യേക ഉപയോഗത്തിന് അനുയോജ്യമെന്നോ ഉള്ള യാതൊരു ഗുണമേന്മോത്തരവാദിത്തവും ഇത് ഉൾക്കൊള്ളുന്നില്ല. കൂടുതൽ വിവരങ്ങൾക്ക് ഗ്നു സാർവ്വജനിക അനുവാദപത്രം കാണുക.

ഈ പ്രോഗ്രാമിനൊപ്പം [{{SERVER}}{{SCRIPTPATH}}/COPYING ഗ്നു സാർവ്വജനിക അനുവാദപത്രത്തിന്റെ ഒരു പകർപ്പ്] താങ്കൾക്ക് ലഭിച്ചിരിക്കും; ഇല്ലെങ്കിൽ Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA എന്ന വിലാസത്തിലെഴുതുക അല്ലെങ്കിൽ [//www.gnu.org/licenses/old-licenses/gpl-2.0.html അനുവാദപത്രം ഓൺലൈനായി വായിക്കുക].',
	'version-software' => 'ഇൻസ്റ്റോൾ ചെയ്ത സോഫ്റ്റ്‌വെയർ',
	'version-software-product' => 'സോഫ്റ്റ്‌വെയർ ഉല്പ്പന്നം',
	'version-software-version' => 'വിവരണം',
);

$messages['mn'] = array(
	'variants' => 'Хувилбарууд',
	'view' => 'Харагдац',
	'viewdeleted_short' => '{{PLURAL:$1|арилгасан засварыг|арилгасан $1 засваруудыг}} харах',
	'views' => 'Харагдацууд',
	'viewcount' => 'Энэ хуудсанд {{PLURAL:$1|ганцхан удаа|$1 удаа}} хандсан байна.',
	'view-pool-error' => 'Уучлаарай, серверүүд хэт их ачааллагдсан байна.
Энэ хуудсыг хэт олон хэрэглэгч харах гэж оролдож байна.
Дахин энэ хуудаст хандахынхаа өмнө түр хугацаагаар хүлээнэ үү.

$1',
	'versionrequired' => 'МедиаВикигийн $1 хувилбар шаардлагатай',
	'versionrequiredtext' => 'Энэ хуудсыг ашиглахын тулд МедиаВикигйин $1 хувилбар шаардлагатай. [[Special:Version|Энэ хувилбарын тухай]] үзнэ үү.',
	'viewsourceold' => 'кодыг харах',
	'viewsourcelink' => 'кодыг харах',
	'viewdeleted' => '$1-г харах уу?',
	'viewsource' => 'Кодыг харах',
	'viewsource-title' => '$1 хуудсын эх сурвалжийг харах',
	'viewsourcetext' => 'Та энэ хуудасны кодыг харах болон хуулж авах үйлдлийг хийх боломжтой:',
	'viewyourtext' => "Та энэ хуудсан дахь '''өөрийн өөрчлөлтөө''' хуулбарлаж, харж болно",
	'virus-badscanner' => "Буруу тохиргоо: үл мэдэгдэх вирус илрүүлэгч программ: ''$1''",
	'virus-scanfailed' => 'гүйлгэж чадсангүй （код $1）',
	'virus-unknownscanner' => 'үл мэдэгдэх антивирус:',
	'viewpagelogs' => 'Энэ хуудасны логийг үзэх',
	'viewprevnext' => 'Үзэх: ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Энэхүү файл нь файлын баталгаажуулалтад тэнцсэнгүй.',
	'viewdeletedpage' => 'Устгагдсан хуудсуудыг харах',
	'version' => 'Хувилбар',
	'version-extensions' => 'Суулгасан өргөтгөлүүд',
	'version-specialpages' => 'Тусгай хуудсууд',
	'version-parserhooks' => 'Парсер хүүкүүд',
	'version-variables' => 'Хувьсагчууд',
	'version-antispam' => 'Спамаас сэргийлэх',
	'version-other' => 'Бусад',
	'version-mediahandlers' => 'Медиа боловсруулагч',
	'version-hooks' => 'Гогцоо',
	'version-extension-functions' => 'Өргөтгөлүүдийн функцууд',
	'version-parser-extensiontags' => 'Парсер нэмэлт тагууд',
	'version-parser-function-hooks' => 'Парсер функцийн тагууд',
	'version-hook-name' => 'Хүүкийн нэр',
	'version-hook-subscribedby' => 'Захиалсан:',
	'version-version' => '(Хувилбар $1)',
	'version-license' => 'Лиценз',
	'version-poweredby-credits' => "Энэхүү викиг '''[//www.mediawiki.org/ MediaWiki]''' програмаар ажиллуулдаг, зохиогчийн эрх © 2001-$1 $2.",
	'version-poweredby-others' => 'бусад',
	'version-software' => 'Суулгасан программ',
	'version-software-product' => 'Бүтээгдэхүүн',
	'version-software-version' => 'Хувилбар',
);

$messages['mo'] = array(
	'views' => 'Визуализэрь',
	'viewsourcelink' => 'везь сурса',
	'viewsource' => 'Везь сурса',
	'viewpagelogs' => 'Везь журналеле пентру ачастэ паӂинэ',
	'viewprevnext' => 'Везь ($1 {{int:pipe-separator}} $2) ($3).',
);

$messages['mr'] = array(
	'variants' => 'अस्थिर',
	'view' => 'दाखवा',
	'viewdeleted_short' => '{{PLURAL:$1|एक वगळलेले संपादन|$1 वगळलेली संपादने}} पहा.',
	'views' => 'दृष्ये',
	'viewcount' => 'हे पान {{PLURAL:$1|एकदा|$1 वेळा}} बघितले गेलेले आहे.',
	'view-pool-error' => 'माफ करा. यावेळेस सर्व्हरवर ताण आहे. अनेक सदस्य हे पान बघण्याचा प्रयत्न करीत आहेत. पुन्हा या पानावर पोचण्यासाठी थोडा वेळ थांबून परत प्रयत्‍न करा.
$1',
	'versionrequired' => 'मीडियाविकीच्या $1 आवृत्तीची गरज आहे.',
	'versionrequiredtext' => 'हे पान वापरण्यासाठी मीडियाविकीच्या $1 आवृत्तीची गरज आहे. पहा [[Special:Version|आवृत्ती यादी]].',
	'viewsourceold' => 'स्रोत पहा',
	'viewsourcelink' => 'स्रोत पहा',
	'viewdeleted' => 'आवलोकन $1?',
	'viewsource' => 'स्रोत पहा',
	'viewsource-title' => '$1 चा उगम बघा',
	'viewsourcetext' => 'तुम्ही या पानाचा स्रोत पाहू शकता व प्रत करू शकता:',
	'viewyourtext' => 'तुम्ही या पानाचे स्त्रोत पाहू शकता व प्रत करू शकता',
	'virus-badscanner' => "चुकीचे कॉन्फिगरेशन: व्हायरस स्कॅनर अनोळखी: ''$1''",
	'virus-scanfailed' => 'स्कॅन पूर्ण झाले नाही (कोड $1)',
	'virus-unknownscanner' => 'अनोळखी ऍन्टीव्हायरस:',
	'viewpagelogs' => 'या पानाच्या नोंदी पहा',
	'viewprevnext' => 'पहा ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'संचिका पडताळणीत ही संचिका अनुत्तीर्ण झाली.',
	'viewdeletedpage' => 'काढून टाकलेले लेख पहा',
	'version' => 'आवृत्ती',
	'version-extensions' => 'स्थापित विस्तार',
	'version-specialpages' => 'विशेष पाने',
	'version-parserhooks' => 'पृथकक अंकुश',
	'version-variables' => 'चल',
	'version-antispam' => 'उत्पात प्रतिबंधन',
	'version-skins' => 'त्वचा',
	'version-other' => 'इतर',
	'version-mediahandlers' => 'मिडिया हॅंडलर',
	'version-hooks' => 'अंकुश',
	'version-extension-functions' => 'अतिविस्तार(एक्स्टेंशन) कार्ये',
	'version-parser-extensiontags' => 'पृथकक विस्तारीत खूणा',
	'version-parser-function-hooks' => 'पृथकक कार्य अंकुश',
	'version-hook-name' => 'अंकुश नाव',
	'version-hook-subscribedby' => 'वर्गणीदार',
	'version-version' => '(आवृत्ती $1)',
	'version-license' => 'परवाना',
	'version-poweredby-credits' => "हा विकी '''[//www.mediawiki.org/ मीडियाविकी]'''द्वारे संचालित आहे, प्रताधिकारित © २००१-$1 $2.",
	'version-poweredby-others' => 'इतर',
	'version-license-info' => 'मिडियाविकि हे  मुक्त संगणक प्रणाली विकि पॅकेज आहे.Free Software Foundation प्रकाशित  GNU General Public परवान्याच्या अटीस अनुसरून तुम्ही त्यात बदल आणि/अथवा त्याचे  पुर्नवितरण  करू शकता.

मिडियाविकि  संगणक प्रणाली उपयूक्त ठरेल या आशेने वितरीत केली जात असली तरी;कोणत्याही वितरणास अथवा विशीष्ट उद्देशाकरिता योग्यतेची अगदी कोणतीही अप्रत्यक्ष अथवा उपलक्षित   अथवा  निहित अशा अथवा कोणत्याही प्रकारच्या केवळ  कोणत्याही प्राश्वासनाशिवायच (WITHOUT ANY WARRANTY) उपलब्ध आहे.अधिक माहिती करिता   GNU General Public License पहावे.

तुम्हाला या प्रणाली सोबत [{{SERVER}}{{SCRIPTPATH}}/COPYING  GNU General Public License परवान्याची प्रत] मिळालेली असावयास हवी, तसे नसेल तर,[//www.gnu.org/licenses/old-licenses/gpl-2.0.html  येथे ऑनलाईन वाचा] किंवा the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA ला लिहा.',
	'version-software' => 'स्थापित संगणक प्रणाली (Installed software)',
	'version-software-product' => 'उत्पादन',
	'version-software-version' => 'आवृत्ती',
	'version-entrypoints' => 'आत येणारी यू॰आर॰एल',
	'version-entrypoints-header-entrypoint' => 'आत येण्याचा मार्ग',
	'version-entrypoints-header-url' => 'यू॰आर॰एल',
);

$messages['mrj'] = array(
	'views' => 'Анжымашвлӓ',
	'viewsourcelink' => 'сек пӹтӓриш кодым анжалаш',
	'viewsource' => 'Анжен лӓктӓш',
	'viewpagelogs' => 'Ти ӹлӹштӓшлӓн журналвлӓм анжыкташ',
	'viewprevnext' => 'Анжен лӓктӓш ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['ms'] = array(
	'variants' => 'Kelainan',
	'view' => 'Paparkan',
	'viewdeleted_short' => 'Papar {{PLURAL:$1|satu|$1}} suntingan dihapuskan',
	'views' => 'Rupa',
	'viewcount' => 'Laman ini telah dilihat {{PLURAL:$1|sekali|sebanyak $1 kali}}.',
	'view-pool-error' => 'Maaf, pelayan terlebih bebanan pada masa ini.
Terlalu ramai pengguna cuba melihat laman ini.
Sila tunggu sebentar sebelum cuba mencapai laman ini lagi.

$1',
	'versionrequired' => 'MediaWiki versi $1 diperlukan',
	'versionrequiredtext' => 'MediaWiki versi $1 diperlukan untuk menggunakan laman ini. Sila lihat [[Special:Version|laman versi]].',
	'viewsourceold' => 'lihat sumber',
	'viewsourcelink' => 'lihat sumber',
	'viewdeleted' => 'Lihat $1?',
	'viewsource' => 'Lihat sumber',
	'viewsource-title' => 'Lihat sumber bagi $1',
	'viewsourcetext' => 'Anda boleh melihat dan menyalin sumber bagi laman ini:',
	'viewyourtext' => "Anda boleh melihat dan menyalin sumber '''suntingan anda''' kepada laman ini:",
	'virus-badscanner' => "Konfigurasi rosak: pengimbas virus yang tidak diketahui: ''$1''",
	'virus-scanfailed' => 'pengimbasan gagal (kod $1)',
	'virus-unknownscanner' => 'antivirus tidak dikenali:',
	'viewpagelogs' => 'Lihat log bagi laman ini',
	'viewprevnext' => 'Lihat ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Fail ini tidak lulus pengesahan fail.',
	'viewdeletedpage' => 'Lihat laman yang dihapuskan',
	'video-dims' => '$1, $2 × $3',
	'version' => 'Versi',
	'version-extensions' => 'Penyambung yang dipasang',
	'version-specialpages' => 'Laman khas',
	'version-parserhooks' => 'Penyangkuk penghurai',
	'version-variables' => 'Pemboleh ubah',
	'version-antispam' => 'Pencegahan spam',
	'version-skins' => 'Rupa',
	'version-other' => 'Lain-lain',
	'version-mediahandlers' => 'Pengelola media',
	'version-hooks' => 'Penyangkuk',
	'version-extension-functions' => 'Fungsi penyambung',
	'version-parser-extensiontags' => 'Tag penyambung penghurai',
	'version-parser-function-hooks' => 'Penyangkuk fungsi penghurai',
	'version-hook-name' => 'Nama penyangkuk',
	'version-hook-subscribedby' => 'Dilanggan oleh',
	'version-version' => '(Versi $1)',
	'version-license' => 'Lesen',
	'version-poweredby-credits' => "Wiki ini dikuasakan oleh '''[//www.mediawiki.org/ MediaWiki]''', hak cipta © 2001-$1 $2.",
	'version-poweredby-others' => 'penyumbang-penyumbang lain',
	'version-license-info' => 'MediaWiki adalah perisian bebas; anda boleh mengedarkannya semula dan/atau mengubah suainya di bawah terma-terma Lesen Awam GNU sebagai mana yang telah diterbitkan oleh Yayasan Perisian Bebas, sama ada versi 2 bagi Lesen tersebut, atau (berdasarkan pilihan anda) mana-mana versi selepasnya.

MediaWiki diedarkan dengan harapan bahawa ia berguna, tetapi TANPA SEBARANG WARANTI; hatta waranti yang tersirat bagi KEBOLEHDAGANGAN mahupun KESESUAIAN UNTUK TUJUAN TERTENTU. Sila lihat Lesen Awam GNU untuk butiran lanjut.

Anda patut telah menerima [{{SERVER}}{{SCRIPTPATH}}/COPYING sebuah salinan bagi Lesen Awam GNU] bersama-sama dengan atur cara ini; jika tidak, tulis ke Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA atau [//www.gnu.org/licenses/old-licenses/gpl-2.0.html baca dalam talian].',
	'version-software' => 'Perisian yang dipasang',
	'version-software-product' => 'Produk',
	'version-software-version' => 'Versi',
);

$messages['mt'] = array(
	'variants' => 'Varjanti',
	'view' => 'Dehra',
	'viewdeleted_short' => 'Ara {{PLURAL:$1|modifika mħassra|$1 modifiki mħassra}}',
	'views' => 'Veduti',
	'viewcount' => 'Din il-paġna ġiet aċċessata {{PLURAL:$1|darba|$1 darba}}.',
	'view-pool-error' => "Jiddispjaċina, imma fil-mument is-servers jinsabu mgħobbija ż-żejjed.
Ħafna utenti qegħdin jippruvaw jaraw din il-paġna.
Jekk jogħġbok stenna ftit qabel ma terġa' tipprova tuża' din il-paġna.

$1",
	'versionrequired' => "Hija meħtieġa l-verżjoni $1 ta' MedjaWiki",
	'versionrequiredtext' => "Hija meħtieġa l-verżjoni $1 ta' MedjaWiki biex tuża din il-paġna. Ara [[Special:Version|paġna tal-verżjoni]].",
	'viewsourceold' => 'ara s-sors',
	'viewsourcelink' => 'ara s-sors',
	'viewdeleted' => 'Ara $1?',
	'viewsource' => 'Ara s-sors',
	'viewsource-title' => "Ara s-sors ta' $1",
	'viewsourcetext' => "Tista' tara u tikkopja s-sors ta' din il-paġna:",
	'viewyourtext' => "Tista' tara u tikkopja s-sors tal-'''modifiki tiegħek''' fuq din il-paġna:",
	'virus-badscanner' => "Problema fil-konfigurazzjoni: antivirus mhux magħruf: ''$1''",
	'virus-scanfailed' => 'Tfittxija falliet (kodiċi $1)',
	'virus-unknownscanner' => 'antivirus mhux magħruf:',
	'viewpagelogs' => "Ara r-reġistri ta' din il-paġna",
	'viewprevnext' => 'Ara ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => "Dan il-fajl m'għaddiex il-verifika.",
	'viewdeletedpage' => 'Ara l-paġni mħassra',
	'version' => 'Verżjoni',
	'version-extensions' => 'Estensjonijiet installati',
	'version-specialpages' => 'Paġni speċjali',
	'version-parserhooks' => 'Hook tal-parser',
	'version-variables' => 'Varjabili',
	'version-antispam' => 'Prevenzjoni tal-ispam',
	'version-skins' => 'Aspetti',
	'version-other' => 'Oħrajn',
	'version-mediahandlers' => 'Imradd tal-medja',
	'version-hooks' => 'Hook',
	'version-extension-functions' => 'Funzjonijiet tal-estensjoni',
	'version-parser-extensiontags' => "Tikketti magħrufa mill-''parser'' introdotti minn estensjonijiet",
	'version-parser-function-hooks' => "''Hooks'' għal funzjonijiet tal-''parser''",
	'version-hook-name' => 'Isem tal-hook',
	'version-hook-subscribedby' => 'Reġistrat minn',
	'version-version' => '(Verżjoni $1)',
	'version-license' => 'Liċenzja',
	'version-poweredby-credits' => "Din il-wiki hija operata minn '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'oħrajn',
	'version-license-info' => "MediaWiki huwa softwer b'xejn; inti tista' tqassmu mill-ġdid u/jew timmodifikah taħt it-termini tal-GNU General Public License, kif ippubblikata mill-Free Software Foundation; jew it-2 verżjoni tal-Liċenzja, jew (skont l-għażla tiegħek) kwalunkwe verżjoni suċċessiva.

MediaWiki hi distribwita bl-iskop li din tkun utli, imma MINGĦAJR EBDA GARANZIJA; mingħajr lanqas il-garanzija impliċita ta' NEGOZJABILITÀ jew ta' ADEGWATEZZA GĦAL SKOP PARTIKULARI. Ara l-GNU General Public License għal aktar dettalji.

Flimkien ma' dan il-programm suppost kellek tirċievi [{{SERVER}}{{SCRIPTPATH}}/COPYING kopja tal-GNU General Public License]; jekk le, ikteb lil Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA jew [//www.gnu.org/licenses/old-licenses/gpl-2.0.html aqraha fuq l-internet].",
	'version-software' => 'Softwer installat',
	'version-software-product' => 'Prodott',
	'version-software-version' => 'Verżjoni',
);

$messages['mwl'] = array(
	'views' => 'Besitas',
	'versionrequired' => 'Ye percisa la beson $1 de l MediaWiki',
	'viewsourceold' => 'ber código',
	'viewsourcelink' => 'ber código',
	'viewdeleted' => 'Ber $1?',
	'viewsource' => 'Ber código',
	'viewsourcetext' => 'Tu puodes ber i copiar l código desta páigina:',
	'virus-scanfailed' => 'la berificaçon falhou (código $1)',
	'virus-unknownscanner' => 'antibírus çcoincido:',
	'viewpagelogs' => 'Ber registros pa esta páigina',
	'viewprevnext' => 'Ber ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Berson',
	'version-specialpages' => 'Páiginas Speciales',
	'version-variables' => 'Bariables',
	'version-other' => 'Outro',
	'version-license' => 'Licença',
	'version-software-product' => 'Perduto',
	'version-software-version' => 'Berson',
);

$messages['my'] = array(
	'variants' => 'အမျိုးမျိုးအပြားပြား',
	'view' => 'ကြည့်ရန်',
	'viewdeleted_short' => '{{PLURAL:$1|ဖျက်လိုက်သည့်တည်းဖြတ်မှုတစ်ခု|ဖျက်လိုက်သည့် တည်းဖြတ်မှု $1 ခု}}ကို ကြည့်ရန်',
	'views' => 'ပုံပန်းသွင်ပြင်',
	'viewcount' => 'ဤစာမျက်နှာကို {{PLURAL:$1|တစ်ကြိမ်|$1 ကြိမ်}} ဝင်ထားသည်။',
	'view-pool-error' => 'ဆာဗာသည် ယခုအချိန်တွင် မမျှသောဝန်ကို ထမ်းနေရသည်။
အသုံးပြုသူ အမြောက်အများက ဤစာမျက်နှာကို ကြည့်ရှုရန် ကြိုးပမ်းနေကြသည်။
ဤစာမျက်နှာကို နောက်တစ်ကြိမ် ပြန်မကြည့်မီ ခဏတာမျှ စောင့်ပါ။

$1',
	'versionrequired' => 'မီဒီယာဝီကီဗာရှင်း $1 လိုအပ်သည်',
	'versionrequiredtext' => 'ဤစာမျက်နှာကို ကြည့်ရန် မီဒီယာဝီကီဗာရှင်း $1 လိုအပ်သည်။
[[Special:Version|ဗားရှင်းစာမျက်နှာ]]ကို ကြည့်ပါ။',
	'viewsourceold' => 'ရင်းမြစ်ကို ကြည့်ရန်',
	'viewsourcelink' => 'ရင်းမြစ်ကို ကြည့်ရန်',
	'viewdeleted' => '$1 ကို ကြည့်မည်လော။',
	'viewsource' => 'ရင်းမြစ်ကို ကြည့်ရန်',
	'virus-unknownscanner' => 'အမည်မသိအန်တီဗိုင်းရပ်စ် -',
	'viewpagelogs' => 'ဤစာမျက်နှာအတွက် မှတ်တမ်းများကို ကြည့်ရန်',
	'viewprevnext' => '($1 {{int:မှ}} $2) အထိကြား ရလဒ် ($3) ခုကို ကြည့်ရန်',
	'verification-error' => 'ဤဖိုင်သည် ဖိုင်အတည်ပြုရန်စစ်ဆေးချက် မအောင်မြင်ပါ။',
	'viewdeletedpage' => 'ဖျက်လိုက်သော စာမျက်နှာများကိုကြည့်ရန်',
	'version' => 'ဗားရှင်း',
	'version-specialpages' => 'အ​ထူး ​စာ​မျက်​နှာ​များ',
	'version-other' => 'အခြား',
	'version-license' => 'လိုင်စင်',
	'version-software' => 'သွင်းထားသော ဆော့ဝဲ',
	'version-software-product' => 'ထုတ်ကုန်',
	'version-software-version' => 'ဗားရှင်း',
);

$messages['myv'] = array(
	'variants' => 'Вариантт',
	'view' => 'Ванома потмо',
	'views' => 'Ваномкат',
	'viewcount' => 'Те лопантень совасть {{PLURAL:$1|весть|$1-ксть}}.',
	'versionrequired' => 'МедияВикинь $1 версиясь эряви',
	'versionrequiredtext' => 'МедияВикинь $1 версиясь эряви те лопанть тевс нолдамга.
Вант [[Special:Version|версиянь лопанть]].',
	'viewsourceold' => 'ваномс лисьмапрянть',
	'viewsourcelink' => 'ваномс лисьмапрянзо',
	'viewdeleted' => 'Ванномс $1?',
	'viewsource' => 'Ванномс лисьмапрянть',
	'viewsourcetext' => 'Те лопанть лисьмапрясь маштови ваномскак, лангстонзо саемс копияяк:',
	'virus-scanfailed' => 'сканнось эзь лисе (код $1)',
	'virus-unknownscanner' => 'апак содань антивирус:',
	'viewpagelogs' => 'Ванномс те лопас совамодо-лисемадо тевть',
	'viewprevnext' => 'Ванномс ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Ваномс нардазь лопатнень',
	'version' => 'Версия',
	'version-specialpages' => 'Башка тевень лопат',
	'version-variables' => 'Полавтневикс тевть',
	'version-skins' => 'Лангт',
	'version-other' => 'Лия',
	'version-hooks' => 'Кечказт',
	'version-hook-name' => 'Кечказонть лемезэ',
	'version-hook-subscribedby' => 'Сёрмадстызе',
	'version-version' => '(Версия $1)',
	'version-license' => 'Лицензия',
	'version-software' => 'Нолдань программат',
	'version-software-product' => 'Шкавкс-нолдавкс',
	'version-software-version' => 'Верзия',
);

$messages['mzn'] = array(
	'variants' => 'گویش‌ئون',
	'view' => 'نمایش',
	'viewdeleted_short' => 'نمایش {{PLURAL:$1|اتا دچی‌یه حذف بَیی|$1 دچی‌یه حذف بَیی}}',
	'views' => 'هارشی‌ئون',
	'viewcount' => 'این صفحه {{PLURAL:$1|ات|$1}} بار بدی‌یه بیّه',
	'versionrequired' => 'نوسخهٔ $1 نرم‌افزار مدیاویکی جه لازم هسّه',
	'versionrequiredtext' => 'این صفحه‌ی بدی‌ین وسّه به نسخهٔ $1 نرم‌افزار مدیاویکی جه نیاز دارنی.
به [[Special:Version|این صفحه]] بورین.',
	'viewsourceold' => 'منبع ره هارشائن',
	'viewsourcelink' => 'منبع بدی‌ین',
	'viewdeleted' => 'نمایش $1؟',
	'viewsource' => 'منبع ره بدی‌ین',
	'viewsourcetext' => 'بتونّی متن مبدأ این صفحه ره هارشین یا ونجه نسخه بَیرین:',
	'viewprevnext' => 'هارشائن ($1 {{int:pipe-separator}} $2) ($3)',
	'video-dims' => '$1, $2×$3',
	'version-specialpages' => 'شا صفحه‌ئون',
);

$messages['nah'] = array(
	'view' => 'Mà mỏta',
	'viewdeleted_short' => 'Mà mỏta {{PLURAL:$1|se tlatlaìxpôpolòlli tlayèktlàlilistli|$1 tlatlaìxpôpolòltin tlayèktlàlilistin}}',
	'views' => 'Tlachiyaliztli',
	'viewcount' => 'Inīn zāzanilli quintlapōhua {{PLURAL:$1|cē tlahpololiztli|$1 tlahpololiztli}}.',
	'viewsourceold' => 'xiquitta tlahtōlcaquiliztilōni',
	'viewsourcelink' => 'tiquittāz tlahtōlcaquiliztilōni',
	'viewdeleted' => '¿Tiquiēlēhuia tiquitta $1?',
	'viewsource' => 'Tiquittāz tlahtōlcaquiliztilōni',
	'viewsourcetext' => 'Tihuelīti tiquitta auh ticcopīna inīn zāzanilli ītlahtōlcaquiliztilōni:',
	'virus-unknownscanner' => 'ahmatic antivirus:',
	'viewpagelogs' => 'Tiquinttāz tlahcuilōlloh inīn zāzaniltechcopa',
	'viewprevnext' => 'Xiquintta ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Tiquinttāz zāzaniltin ōmopolōzqueh',
	'version' => 'Machiyōtzin',
	'version-specialpages' => 'Nònkuâkìskàtlaìxtlapaltìn',
	'version-other' => 'Occē',
	'version-version' => '(Machiyōtzin $1)',
	'version-software-version' => 'Machiyōtzin',
);

$messages['nan'] = array(
	'variants' => 'piàn-thé',
	'view' => 'Khoàⁿ',
	'viewdeleted_short' => 'Khoàⁿ {{PLURAL:$1|chi̍t-ê thâi tiàu--ê pian-chi̍p|$1 ê thâi tiàu--ê pian-chi̍p}}',
	'views' => 'Khoàⁿ',
	'viewcount' => 'Pún-ia̍h kàu taⁿ ū {{PLURAL:$1| pái|$1 pái}}  ê sú-iōng.',
	'view-pool-error' => 'Pháiⁿ-sè, chit-má chú-ki siuⁿ koè bô-êng.
Siuⁿ koè chē lâng beh khoàⁿ chit ia̍h.
Chhiáⁿ sio-tán chi̍t-ē,  chiah koh lâi khoàⁿ chit ia̍h.

$1',
	'versionrequired' => 'Ài MediaWiki $1 ê pán-pún',
	'versionrequiredtext' => 'Beh iōng chit ia̍h ài MediaWiki $1 ê pán-pún.
Chhiáⁿ khoàⁿ [[Special:Version|pán-pún ia̍h]].',
	'viewsourceold' => 'Khoàⁿ goân-sú lōe-iông',
	'viewsourcelink' => 'Khoàⁿ goân-sú lōe-iông',
	'viewdeleted' => 'Beh khoàⁿ $1？',
	'viewsource' => 'Khoàⁿ goân-sú lōe-iông',
	'viewsource-title' => '看$1的內容',
	'viewsourcetext' => 'Lí ē-sái khoàⁿ ia̍h khó͘-pih chit ia̍h ê goân-sú loē-iông:',
	'viewyourtext' => "你會使共'''你的編輯'''的內容拷備來這頁：",
	'virus-badscanner' => "毋著的設定: 毋知影的病毒掃瞄器：''$1''",
	'virus-scanfailed' => '掃描失敗（號碼 $1）',
	'virus-unknownscanner' => 'M̄-chai siáⁿ pēⁿ-to̍k:',
	'viewpagelogs' => 'Khoàⁿ chit ia̍h ê logs',
	'viewprevnext' => 'Khoàⁿ ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => '這个檔案無通過驗證',
	'viewdeletedpage' => '看刣掉的頁',
	'version' => 'Pán-pún',
	'version-specialpages' => '特殊頁',
	'version-skins' => '皮',
	'version-license' => '授權',
	'version-software-version' => '版本',
);

$messages['nap'] = array(
	'viewcount' => 'Chesta paggena è stata lètta {{PLURAL:$1|una vòta|$1 vòte}}.',
	'viewdeleted' => 'Vire $1?',
	'viewdeletedpage' => "Vìre 'e ppàggine scancellate",
);

$messages['nb'] = array(
	'variants' => 'Varianter',
	'view' => 'Vis',
	'viewdeleted_short' => 'Vis {{PLURAL:$1|én slettet redigering|$1 slettede redigeringer}}',
	'views' => 'Visninger',
	'viewcount' => 'Denne siden er vist {{PLURAL:$1|én gang|$1 ganger}}.',
	'view-pool-error' => 'Beklager, serverne er overbelastet for øyeblikket.
For mange brukere forsøker å se denne siden.
Vennligst vent en stund før du prøver å besøke denne siden på nytt.

$1',
	'versionrequired' => 'Versjon $1 av MediaWiki er påkrevd',
	'versionrequiredtext' => 'Versjon $1 av MediaWiki er nødvendig for å bruke denne siden. Se [[Special:Version|versjonsiden]]',
	'viewsourceold' => 'vis kilde',
	'viewsourcelink' => 'vis kilde',
	'viewdeleted' => 'Vis $1?',
	'viewsource' => 'Vis kilde',
	'viewsource-title' => 'Vis kilden til $1',
	'viewsourcetext' => 'Du kan se og kopiere kilden til denne siden:',
	'viewyourtext' => "Du kan se og kopiere kilden til '''dine endringer''' på denne siden:",
	'virus-badscanner' => "Dårlig konfigurasjon: Ukjent virusskanner: ''$1''",
	'virus-scanfailed' => 'skanning mislyktes (kode $1)',
	'virus-unknownscanner' => 'ukjent antivirusprogram:',
	'viewpagelogs' => 'Vis logger for denne siden',
	'viewprevnext' => 'Vis ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Denne filen bestod ikke filbekreftelsen.',
	'viewdeletedpage' => 'Vis slettede sider',
	'version' => 'Versjon',
	'version-extensions' => 'Installerte utvidelser',
	'version-specialpages' => 'Spesialsider',
	'version-parserhooks' => 'Parsertillegg',
	'version-variables' => 'Variabler',
	'version-antispam' => 'Søppelpostforebygging',
	'version-skins' => 'Drakter',
	'version-other' => 'Annet',
	'version-mediahandlers' => 'Mediahåndterere',
	'version-hooks' => 'Haker',
	'version-extension-functions' => 'Tilleggsfunksjoner',
	'version-parser-extensiontags' => 'Tilleggstagger',
	'version-parser-function-hooks' => 'Parserfunksjoner',
	'version-hook-name' => 'Navn',
	'version-hook-subscribedby' => 'Brukes av',
	'version-version' => '(versjon $1)',
	'version-license' => 'Lisens',
	'version-poweredby-credits' => "Denne wikien er drevet av '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'andre',
	'version-license-info' => 'MediaWiki er fri programvare; du kan redistribuere det og/eller modifisere det under betingelsene i GNU General Public License som publisert av Free Software Foundation; enten versjon 2 av lisensen, eller (etter eget valg) enhver senere versjon.

MediaWiki er distribuert i håp om at det vil være nyttig, men UTEN NOEN GARANTI; ikke engang implisitt garanti av SALGBARHET eller EGNETHET FOR ET BESTEMT FORMÅL. Se GNU General Public License for flere detaljer.

Du skal ha mottatt [{{SERVER}}{{SCRIPTPATH}}/COPYING en kopi av GNU General Public License] sammen med dette programmet; hvis ikke, skriv til Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA eller [//www.gnu.org/licenses/old-licenses/gpl-2.0.html les det på nettet].',
	'version-software' => 'Installert programvare',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Versjon',
);

$messages['nds'] = array(
	'variants' => 'Varianten',
	'view' => 'Lesen',
	'viewdeleted_short' => '{{PLURAL:$1|Een wegdaan Version|$1 wegdaan Versionen}} ankieken',
	'views' => 'Ansichten',
	'viewcount' => 'Disse Siet is {{PLURAL:$1|een|$1}} Maal opropen worrn.',
	'view-pool-error' => "Dat deit uns leed, man de Servers sünd in'n Momang överladen.
To vele Brukers versöökt, düsse Siet to besöken.
Bitte tööv en poor Minuten, ehrder du dat nochmal versöchst.


$1",
	'versionrequired' => 'Version $1 vun MediaWiki nödig',
	'versionrequiredtext' => 'Version $1 vun MediaWiki is nödig, disse Siet to bruken. Kiek op de Siet [[Special:Version|Version]].',
	'viewsourceold' => 'Borntext wiesen',
	'viewsourcelink' => 'Borntext ankieken',
	'viewdeleted' => '$1 ankieken?',
	'viewsource' => 'Dokmentborn ankieken',
	'viewsource-title' => 'De Born vun $1 wiesen.',
	'viewsourcetext' => 'Kannst den Borntext vun disse Siet ankieken un koperen:',
	'viewyourtext' => "Du kannst '''dien Ännern''' an de Born vun düsse Sied ankieken un koperen:",
	'virus-badscanner' => "Slechte Konfiguratschoon: unbekannten Virenscanner: ''$1''",
	'virus-scanfailed' => 'Scan hett nich klappt (Code $1)',
	'virus-unknownscanner' => 'Unbekannten Virenscanner:',
	'viewpagelogs' => 'Logbook för disse Siet',
	'viewprevnext' => 'Wies ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Wegsmetene Sieden ankieken',
	'version' => 'Version',
	'version-extensions' => 'Installeerte Extensions',
	'version-specialpages' => 'Spezialsieden',
	'version-parserhooks' => 'Parser-Hooks',
	'version-variables' => 'Variablen',
	'version-other' => 'Annern Kraam',
	'version-mediahandlers' => 'Medien-Handlers',
	'version-hooks' => 'Hooks',
	'version-extension-functions' => 'Extension-Funkschonen',
	'version-parser-extensiontags' => "Parser-Extensions ''(Tags)''",
	'version-parser-function-hooks' => 'Parser-Funkschonen',
	'version-hook-name' => 'Hook-Naam',
	'version-hook-subscribedby' => 'Opropen vun',
	'version-version' => '(Version $1)',
	'version-license' => 'Lizenz',
	'version-poweredby-credits' => "Dit Wiki bruukt '''[//www.mediawiki.org/ MediaWiki]''', Copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'annere',
	'version-software' => 'Installeerte Software',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Version',
);

$messages['nds-nl'] = array(
	'variants' => 'Variaanten',
	'view' => 'Lezen',
	'viewdeleted_short' => '{{PLURAL:$1|Eén versie die vortedaon is|$1 versies die vortedaon bin}} bekieken',
	'views' => 'Aspekten/aksies',
	'viewcount' => 'Disse pagina is $1 {{PLURAL:$1|keer|keer}} bekeken.',
	'view-pool-error' => "De servers bin noen overbelast.
Te veule meensen proberen disse pagina te bekieken.
Wacht even veurda'j opniej toegang proberen te kriegen tot disse pagina.

$1",
	'versionrequired' => 'Versie $1 van MediaWiki is neudig',
	'versionrequiredtext' => 'Versie $1 van MediaWiki is neudig um disse pagina te gebruken. Zie [[Special:Version|Versie]].',
	'viewsourceold' => 'brontekste bekieken',
	'viewsourcelink' => 'brontekste bekieken',
	'viewdeleted' => 'Bekiek $1?',
	'viewsource' => 'Brontekste bekieken',
	'viewsource-title' => 'Bron bekieken van $1',
	'viewsourcetext' => 'Je kunnen de brontekste van disse pagina bewarken en bekieken:',
	'viewyourtext' => "Je kunnen '''joew bewarkingen''' an de brontekste van disse pagina bekieken en kopiëren:",
	'virus-badscanner' => "Slichte konfigurasie: onbekend antivirusprogramma: ''$1''",
	'virus-scanfailed' => 'inlezen is mislokt (kode $1)',
	'virus-unknownscanner' => 'onbekend antivirusprogramma:',
	'viewpagelogs' => 'Bekiek logboeken veur disse pagina',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Dit bestaand is t bestaandsonderzeuk niet deurekeumen.',
	'viewdeletedpage' => "Bekiek vortedaone pagina's",
	'version' => 'Versie',
	'version-extensions' => 'Uutbreidingen die installeerd bin',
	'version-specialpages' => "Spesiale pagina's",
	'version-parserhooks' => 'Parserhoeken',
	'version-variables' => 'Variabels',
	'version-antispam' => 'Veurkoemen van ongewunste bewarkingen',
	'version-skins' => 'Vormgevingen',
	'version-api' => 'Api',
	'version-other' => 'Overige',
	'version-mediahandlers' => 'Mediaverwarkers',
	'version-hooks' => 'Hoeken',
	'version-extension-functions' => 'Uutbreidingsfunksies',
	'version-parser-extensiontags' => 'Parseruutbreidingsplaotjes',
	'version-parser-function-hooks' => 'Parserfunksiehoeken',
	'version-hook-name' => 'Hooknaam',
	'version-hook-subscribedby' => 'In-eschreven deur',
	'version-version' => '(Versie $1)',
	'version-license' => 'Lisensie',
	'version-poweredby-credits' => "Disse wiki wörden an-estuurd deur '''[//www.mediawiki.org/ MediaWiki]''', auteursrecht © 2001-$1 $2.",
	'version-poweredby-others' => 'aanderen',
	'version-license-info' => 'MediaWiki is vrieje programmatuur; je kunnen MediaWiki verspreien en/of anpassen onder de veurweerden van de GNU General Public License zo as epubliceerd deur de Free Software Foundation; of versie 2 van de Lisensie, of - naor eigen wuns - n laotere versie.

MediaWiki wörden verspreid in de hoop dat t nuttig is, mer ZONDER ENIGE GARANSIE; zonder zelfs de daoronder begrepen garansie van VERKOOPBAORHEID of GESCHIKTHEID VEUR ENIG DOEL IN T BIEZUNDER. Zie de GNU General Public License veur meer informasie.

Samen mit dit programma heur je n [{{SERVER}}{{SCRIPTPATH}}/COPYING kopie van de GNU General Public License] te hebben ekregen; as dat niet zo is, schrief dan naor de Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA of [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lees de lisensie op t internet].',
	'version-software' => 'Programmatuur die installeerd is',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Versie',
);

$messages['ne'] = array(
	'variants' => 'बहुरुपहरु',
	'views' => 'अवलोकनहरू',
	'viewcount' => 'यो पृष्ठ हेरिएको थियो {{PLURAL:$1|एकपटक|$1 पटक}}',
	'view-pool-error' => 'माफ गर्नुहोस् , यस समयमा सर्भरहरुमा कार्यभार उच्च रहेको छ।
अति धेरै प्रयोगकर्ताहरु यो पृष्ट हेर्ने प्रयास गरी रहनु भएको छ।
कृपया यो पृष्ठ पुन: हेर्नु अगाडि केही समय पर्खिदिनुहोस् ।

$1',
	'versionrequired' => 'MediaWiki संस्करण $1 चाहिने',
	'versionrequiredtext' => 'यो पृष्ठ प्रयोग गर्नको लागि MediaWiki $1 संस्करण चाहिन्छ ।
हेर्नुहोस्  [[Special:Version|version page]]',
	'viewsourceold' => 'स्रोत हेर्नुहोस्',
	'viewsourcelink' => 'स्रोत हेर्नुहोस्',
	'viewdeleted' => '$1 हेर्ने ?',
	'viewsource' => 'स्रोत हेर्नुहोस',
	'viewsourcefor' => '$1 को लागि',
	'viewsourcetext' => 'तपाईँले यस पृष्ठको स्रोत हेर्न र प्रतिलिपी गर्न सक्नुहुन्छ ।',
	'virus-badscanner' => "खराव मिलान: अज्ञात भाइरस स्क्यानर :''$1''",
	'virus-scanfailed' => 'पढाइ असफल(कोड $1)',
	'virus-unknownscanner' => 'नखुलेको एन्टीभाइरस:',
	'viewpagelogs' => 'यस पृष्ठका लगहरू हेर्नुहोस्',
	'viewprevnext' => 'हेर्नुहोस् ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'मेटिएका पृष्ठहरू हेर्नुहोस्',
	'version' => 'संस्करण',
	'version-extensions' => 'स्थापना गरिएका एक्सटेन्सनहरु',
	'version-specialpages' => 'विशेष पृष्ठहरू',
	'version-parserhooks' => 'पार्सर हुकहरु',
	'version-variables' => 'चल राशी(variables)',
	'version-other' => 'अन्य',
	'version-mediahandlers' => 'मिडिया  ह्यान्डलरहरू',
	'version-extension-functions' => 'अतिरिक्त प्रकार्य',
	'version-parser-extensiontags' => 'पार्सर विस्तार ट्यागहरु',
	'version-parser-function-hooks' => 'पार्सर फङ्सन हुक',
	'version-skin-extension-functions' => 'काचुली विस्तार फङ्सनहरु(functions)',
	'version-hook-name' => 'हुक नाम',
	'version-hook-subscribedby' => 'ग्राह्यता गर्ने',
	'version-version' => '(संस्करण $1)',
	'version-license' => 'इजाजतपत्र',
	'version-software' => 'स्थापना गरिएको सफ्टवेयर',
	'version-software-version' => 'संस्करण',
);

$messages['new'] = array(
	'versionrequired' => 'मिडियाविकिया $1 संस्करण माःगु',
	'versionrequiredtext' => 'थ्व पौ छ्यले यात मिडियाविकिया $1 संस्करण माः।
स्वयादिसँ [[विशेष:संस्करण|संस्करण पौ]]।',
	'viewsource' => 'स्रोत स्वयादिसँ',
);

$messages['niu'] = array(
	'viewsource' => 'Kitekite ke mouaga',
	'version-specialpages' => 'Tau Lau Mahuiga',
);

$messages['nl'] = array(
	'variants' => 'Varianten',
	'view' => 'Lezen',
	'viewdeleted_short' => '{{PLURAL: $1|Eén geschrapte bewerking |$1 geschrapte bewerkingen}} bekijken',
	'views' => 'Weergaven',
	'viewcount' => 'Deze pagina is {{PLURAL:$1|één keer|$1 keer}} bekeken.',
	'view-pool-error' => 'Sorry, de servers zijn op het moment overbelast.
Te veel gebruikers proberen deze pagina te bekijken.
Wacht alstublieft even voordat u opnieuw toegang probeert te krijgen tot deze pagina.

$1',
	'versionrequired' => 'Versie $1 van MediaWiki is vereist',
	'versionrequiredtext' => 'Versie $1 van MediaWiki is vereist om deze pagina te gebruiken.
Meer informatie is beschikbaar op de pagina [[Special:Version|softwareversie]].',
	'viewsourceold' => 'brontekst bekijken',
	'viewsourcelink' => 'brontekst bekijken',
	'viewdeleted' => '$1 bekijken?',
	'viewsource' => 'Brontekst bekijken',
	'viewsource-title' => 'Brontekst bekijken van $1',
	'viewsourcetext' => 'U kunt de brontekst van deze pagina bekijken en kopiëren:',
	'viewyourtext' => "U kunt '''uw bewerkingen''' aan de brontekst van deze pagina bekijken en kopiëren:",
	'virus-badscanner' => "Onjuiste configuratie: onbekende virusscanner: ''$1''.",
	'virus-scanfailed' => 'scannen is mislukt (code $1)',
	'virus-unknownscanner' => 'onbekend antivirusprogramma:',
	'viewpagelogs' => 'Logboek voor deze pagina bekijken',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) bekijken.',
	'verification-error' => 'De verificatie van het bestand dat u probeerde te uploaden is mislukt.',
	'viewdeletedpage' => "Verwijderde pagina's bekijken",
	'version' => 'Versie',
	'version-extensions' => 'Geïnstalleerde uitbreidingen',
	'version-specialpages' => "Speciale pagina's",
	'version-parserhooks' => 'Parserhooks',
	'version-variables' => 'Variabelen',
	'version-antispam' => 'Spampreventie',
	'version-skins' => 'Vormgevingen',
	'version-other' => 'Overige',
	'version-mediahandlers' => 'Mediaverwerkers',
	'version-hooks' => 'Hooks',
	'version-extension-functions' => 'Uitbreidingsfuncties',
	'version-parser-extensiontags' => 'Parseruitbreidingstags',
	'version-parser-function-hooks' => 'Parserfunctiehooks',
	'version-hook-name' => 'Hooknaam',
	'version-hook-subscribedby' => 'Geabonneerd door',
	'version-version' => '(Versie $1)',
	'version-license' => 'Licentie',
	'version-poweredby-credits' => "Deze wiki wordt aangedreven door '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'anderen',
	'version-license-info' => 'MediaWiki is vrije software; u kunt MediaWiki verspreiden en/of aanpassen onder de voorwaarden van de GNU General Public License zoals gepubliceerd door de Free Software Foundation; ofwel versie 2 van de Licentie, of - naar uw wens - enige latere versie.

MediaWiki wordt verspreid in de hoop dat het nuttig is, maar ZONDER ENIGE GARANTIE; zonder zelfs de impliciete garantie van VERKOOPBAARHEID of GESCHIKTHEID VOOR ENIG DOEL IN HET BIJZONDER. Zie de GNU General Public License voor meer informatie.

Samen met dit programma hoort u een [{{SERVER}}{{SCRIPTPATH}}/COPYING kopie van de GNU General Public License] te hebben ontvangen; zo niet, schrijf dan naar de Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA of [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lees de licentie online].',
	'version-software' => 'Geïnstalleerde software',
	'version-software-product' => 'Product',
	'version-software-version' => 'Versie',
);

$messages['nl-informal'] = array(
	'view-pool-error' => 'Sorry, de servers zijn op het moment overbelast.
Te veel gebruikers proberen deze pagina te bekijken.
Wacht alstublieft even voordat je opnieuw toegang probeert te krijgen tot deze pagina.

$1',
	'viewsourcetext' => 'Je kunt de brontekst van deze pagina bekijken en kopiëren:',
	'version-license-info' => 'MediaWiki is vrije software; je kunt MediaWiki verspreiden en/of aanpassen onder de voorwaarden van de GNU General Public License zoals gepubliceerd door de Free Software Foundation; ofwel versie 2 van de Licentie, of - zo je wilt - enige latere versie.

MediaWiki wordt verspreid in de hoop dat het nuttig is, maar ZONDER ENIGE GARANTIE; zonder zelfs de implicitiete garantie van VERKOOPBAARHEID of GESCHIKHEID VOOR ENIG DOEL IN HET BIJZONDER. Zie de GNU General Public License voor meer informatie.

Samen met dit programma hoor je een [{{SERVER}}{{SCRIPTPATH}}/COPYING kopie van de GNU General Public License] te hebben ontvangen; zo niet, schrijf dan naar de Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA of [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lees de licentie online].',
);

$messages['nn'] = array(
	'variants' => 'Variantar',
	'view' => 'Sjå',
	'viewdeleted_short' => 'Vis {{PLURAL:$1|éin sletta versjon|$1 sletta versjonar}}',
	'views' => 'Visningar',
	'viewcount' => 'Sida er vist {{PLURAL:$1|éin gong|$1 gonger}}.',
	'view-pool-error' => 'Diverre er filtenarane nett no opptekne.
For mange brukarar prøver å sjå denne sida.
Vent ei lita stund, før du prøver å sjå på sida.

$1',
	'versionrequired' => 'Versjon $1 av MediaWiki er påkravd',
	'versionrequiredtext' => 'Ein må ha versjon $1 av MediaWiki for å bruke denne sida. Sjå [[Special:Version|versjonssida]].',
	'viewsourceold' => 'sjå kjelda',
	'viewsourcelink' => 'vis kjelde',
	'viewdeleted' => 'Sjå historikk for $1?',
	'viewsource' => 'Sjå kjelda',
	'viewsource-title' => 'Sjå kjelda til $1',
	'viewsourcetext' => 'Du kan sjå og kopiere kjeldekoden til denne sida:',
	'virus-badscanner' => "Dårleg konfigurasjon: ukjend virusskanner: ''$1''",
	'virus-scanfailed' => 'skanning mislukkast (kode $1)',
	'virus-unknownscanner' => 'ukjend antivirusprogram:',
	'viewpagelogs' => 'Vis loggane for sida',
	'viewprevnext' => 'Vis ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Denne fila klarde ikkje verifiseringsprossesen.',
	'viewdeletedpage' => 'Sjå sletta sider',
	'version' => 'Versjon',
	'version-extensions' => 'Installerte utvidingar',
	'version-specialpages' => 'Spesialsider',
	'version-parserhooks' => 'Parsertillegg',
	'version-variables' => 'Variablar',
	'version-skins' => 'Draktar',
	'version-other' => 'Anna',
	'version-mediahandlers' => 'Mediahandsamarar',
	'version-hooks' => 'Tilleggsuttrykk',
	'version-extension-functions' => 'Utvidingsfunksjonar',
	'version-parser-extensiontags' => 'Parserutvidingsmerke',
	'version-parser-function-hooks' => 'Parserfunksjonstillegg',
	'version-hook-name' => 'Namn på tillegg',
	'version-hook-subscribedby' => 'Brukt av',
	'version-version' => '(versjon $1)',
	'version-license' => 'Lisens',
	'version-poweredby-credits' => "Denne wikien er dreven av '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'andre',
	'version-software' => 'Installert programvare',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Versjon',
);

$messages['no'] = array(
	'variants' => 'Variantar',
	'view' => 'Sjå',
	'viewdeleted_short' => 'Vis {{PLURAL:$1|éin sletta versjon|$1 sletta versjonar}}',
	'views' => 'Visningar',
	'viewcount' => 'Sida er vist {{PLURAL:$1|éin gong|$1 gonger}}.',
	'view-pool-error' => 'Diverre er filtenarane nett no opptekne.
For mange brukarar prøver å sjå denne sida.
Vent ei lita stund, før du prøver å sjå på sida.

$1',
	'versionrequired' => 'Versjon $1 av MediaWiki er påkravd',
	'versionrequiredtext' => 'Ein må ha versjon $1 av MediaWiki for å bruke denne sida. Sjå [[Special:Version|versjonssida]].',
	'viewsourceold' => 'sjå kjelda',
	'viewsourcelink' => 'vis kjelde',
	'viewdeleted' => 'Sjå historikk for $1?',
	'viewsource' => 'Sjå kjelda',
	'viewsource-title' => 'Sjå kjelda til $1',
	'viewsourcetext' => 'Du kan sjå og kopiere kjeldekoden til denne sida:',
	'virus-badscanner' => "Dårleg konfigurasjon: ukjend virusskanner: ''$1''",
	'virus-scanfailed' => 'skanning mislukkast (kode $1)',
	'virus-unknownscanner' => 'ukjend antivirusprogram:',
	'viewpagelogs' => 'Vis loggane for sida',
	'viewprevnext' => 'Vis ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Denne fila klarde ikkje verifiseringsprossesen.',
	'viewdeletedpage' => 'Sjå sletta sider',
	'version' => 'Versjon',
	'version-extensions' => 'Installerte utvidingar',
	'version-specialpages' => 'Spesialsider',
	'version-parserhooks' => 'Parsertillegg',
	'version-variables' => 'Variablar',
	'version-skins' => 'Draktar',
	'version-other' => 'Anna',
	'version-mediahandlers' => 'Mediahandsamarar',
	'version-hooks' => 'Tilleggsuttrykk',
	'version-extension-functions' => 'Utvidingsfunksjonar',
	'version-parser-extensiontags' => 'Parserutvidingsmerke',
	'version-parser-function-hooks' => 'Parserfunksjonstillegg',
	'version-hook-name' => 'Namn på tillegg',
	'version-hook-subscribedby' => 'Brukt av',
	'version-version' => '(versjon $1)',
	'version-license' => 'Lisens',
	'version-poweredby-credits' => "Denne wikien er dreven av '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'andre',
	'version-software' => 'Installert programvare',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Versjon',
);

$messages['nov'] = array(
	'viewprevnext' => 'Vida ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'Versione',
	'version-specialpages' => 'Spesial pagines',
	'version-software-version' => 'Versione',
);

$messages['nso'] = array(
	'views' => 'Dinyakorêtšo',
	'viewcount' => 'Letlakala le le butšwe ga {{PLURAL:$1|tee|$1}}.',
	'versionrequired' => 'Version $1 ya MediaWiki ea hlokega',
	'versionrequiredtext' => 'Version $1 ya MediaWiki ea hlokega go šomiša letlakala le. Lebelela [[Special:Version|letlakala la version]].',
	'viewsourcelink' => 'nyakorela mothopo',
	'viewdeleted' => 'Nyakorela $1?',
	'viewsource' => 'Lebelela mothopo',
	'viewsourcefor' => 'ya $1',
	'viewsourcetext' => 'O ka lebelela goba wa kôpiša mothapo wa letlakala le:',
	'viewpagelogs' => "Nyakoretša di-''log'' tša letlakala le",
	'viewprevnext' => 'Lebelela ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Nyakorela matlakala ago phumulwa',
	'version' => "''Version''",
);

$messages['nv'] = array(
	'views' => 'naaltsoosígíí',
	'viewsourcelink' => 'XML yishʼį́ nisin',
	'viewsource' => 'XML yishʼį́ nisin',
	'viewpagelogs' => 'logsígíí yishʼį́ nisin',
	'viewprevnext' => '($1) ($2) ($3) shinááł',
);

$messages['oc'] = array(
	'variants' => 'Variantas',
	'view' => 'Veire',
	'viewdeleted_short' => 'Veire {{PLURAL:$1|una edicion escafada|$1 edicions escafadas}}',
	'views' => 'Afichatges',
	'viewcount' => 'Aquesta pagina es estada consultada {{PLURAL:$1|un còp|$1 còps}}.',
	'view-pool-error' => "O planhèm, los servidors son subrecargats pel moment.
Tròp d’utilizaires cercan a accedir a aquesta pagina.
Esperatz un moment abans d'ensajar d’accedir a aquesta pagina.

$1",
	'versionrequired' => 'Version $1 de MediaWiki necessària',
	'versionrequiredtext' => 'La version $1 de MediaWiki es necessària per utilizar aquesta pagina. Consultatz [[Special:Version|la pagina de las versions]]',
	'viewsourceold' => 'veire la font',
	'viewsourcelink' => 'veire la font',
	'viewdeleted' => 'Veire $1?',
	'viewsource' => 'Vejatz lo tèxte font',
	'viewsourcetext' => 'Podètz veire e copiar lo contengut de l’article per poder trabalhar dessús :',
	'virus-badscanner' => "Marrida configuracion : escaner de virús desconegut : ''$1''",
	'virus-scanfailed' => 'Fracàs de la recèrca (còde $1)',
	'virus-unknownscanner' => 'antivirús desconegut :',
	'viewpagelogs' => 'Vejatz las operacions per aquesta pagina',
	'viewprevnext' => 'Veire ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Aqueste fichièr passa pas la verificacion dels fichièrs.',
	'viewdeletedpage' => 'Istoric de la pagina suprimida',
	'variantname-kk-arab' => 'kk-arabi',
	'variantname-ku-arab' => 'ku-Arabi',
	'version' => 'Version',
	'version-extensions' => 'Extensions installadas',
	'version-specialpages' => 'Paginas especialas',
	'version-parserhooks' => 'Extensions del parser',
	'version-variables' => 'Variablas',
	'version-skins' => 'Abilhatges',
	'version-other' => 'Divèrs',
	'version-mediahandlers' => 'Supòrts mèdia',
	'version-hooks' => 'Croquets',
	'version-extension-functions' => 'Foncions de las extensions',
	'version-parser-extensiontags' => 'Balisas suplementàrias del parser',
	'version-parser-function-hooks' => 'Croquets de las foncions del parser',
	'version-hook-name' => 'Nom del croquet',
	'version-hook-subscribedby' => 'Definit per',
	'version-version' => '(Version $1)',
	'version-license' => 'Licéncia',
	'version-poweredby-others' => 'autres',
	'version-software' => 'Logicial installat',
	'version-software-product' => 'Produch',
	'version-software-version' => 'Version',
);

$messages['or'] = array(
	'variants' => 'ନିଆରା',
	'view' => 'ଦେଖଣା',
	'viewdeleted_short' => '{{PLURAL:$1|ଗୋଟିଏ ଲିଭାଯାଇଥିବା ବଦଳ|$1ଟି ଲିଭାଯାଇଥିବା ବଦଳ}} ଦେଖାଇବେ',
	'views' => 'ଦେଖା',
	'viewcount' => 'ଏହି ପୃଷ୍ଠାଟି {{PLURAL:$1|ଥରେ|$1 ଥର}} ଖୋଲାଯାଇଛି ।',
	'view-pool-error' => 'କ୍ଷମା କରିବେ, ସର୍ଭରସବୁ ଏବେ ମନ୍ଦ ହୋଇଯାଇଅଛନ୍ତି ।
ଅନେକ ସଭ୍ୟ ଏହି ଏକା ପୃଷ୍ଠାଟି ଦେଖିବାକୁ ଚେଷ୍ଟାକରୁଅଛନ୍ତି ।
ଏହି ପୃଷ୍ଠାକୁ ଆଉଥରେ ଖୋଲିବା ଆଗରୁ ଦୟାକରି କିଛି କ୍ଷଣ ଅପେକ୍ଷା କରନ୍ତୁ ।
$1',
	'versionrequired' => 'ମିଡ଼ିଆଉଇକି ର $1 ତମ ସଙ୍କଳନଟି ଲୋଡ଼ା',
	'versionrequiredtext' => 'ଏହି ପୃଷ୍ଠାଟି ବ୍ୟବହାର କରିବା ନିମନ୍ତେ ମିଡ଼ିଆଉଇକିର $1 ତମ ସଙ୍କଳନ ଲୋଡ଼ା ।
[[Special:Version|ସଙ୍କଳନ ପୃଷ୍ଠାଟି]] ଦେଖନ୍ତୁ ।',
	'viewsourceold' => 'ଉତ୍ସ ଦେଖିବେ',
	'viewsourcelink' => 'ଉତ୍ସ ଦେଖିବେ',
	'viewdeleted' => 'ଦେଖିବା $1?',
	'viewsource' => 'ଉତ୍ସ ଦେଖିବେ',
	'viewsource-title' => '$1 ନିମନ୍ତେ ଆଧାର ଦେଖିବେ',
	'viewsourcetext' => 'ଆପଣ ଏହି ପୃଷ୍ଠାର ଲେଖା ଦେଖିପାରିବେ ଓ ନକଲ କରିପାରିବେ:',
	'viewyourtext' => "ଆପଣ '''ଆପଣଙ୍କ ସମ୍ପାଦିତ ''' ଅଧରଟିକୁ ଦେଖିପାରିବେ ଓ ଏହି ପୃଷ୍ଠାକୁ ନକଲ କରି ପାରିବେ",
	'virus-badscanner' => "ମନ୍ଦ ସଂରଚନା: ଅଜଣା ଭାଇରସ ସ୍କାନର: ''$1''",
	'virus-scanfailed' => 'ସ୍କାନ କରିବା ବିଫଳ ହେଲା (କୋଡ଼ $1)',
	'virus-unknownscanner' => 'ଅଜଣା ଆଣ୍ଟିଭାଇରସ:',
	'viewpagelogs' => 'ଏହି ପୃଷ୍ଠା ପାଇଁ ଲଗଗୁଡ଼ିକୁ ଦେଖନ୍ତୁ ।',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) ଟି ଦେଖିବେ',
	'verification-error' => 'ଏହି ଫାଇଲଟି ଫାଇଲ ପରୀକ୍ଷଣରେ ଅସଫଳ ହେଲା ।',
	'viewdeletedpage' => 'ଲିଭାଯାଇଥିବା ପୃଷ୍ଠାସମୂହ',
	'version' => 'ସଂସ୍କରଣ',
	'version-extensions' => 'ଇନଷ୍ଟଲ କରାହୋଇଥିବା ଏକ୍ସଟେନସନସବୁ',
	'version-specialpages' => 'ନିଆରା ପୃଷ୍ଠା',
	'version-parserhooks' => 'ପାର୍ସର ହୁକ',
	'version-variables' => 'ଚଳ',
	'version-antispam' => 'ଅଦରକାରୀ ମେଲ ଅଟକ',
	'version-skins' => 'ବହିରାବରଣ',
	'version-other' => 'ବାକି',
	'version-mediahandlers' => 'ମିଡ଼ିଆ ହ୍ୟାଣ୍ଡଲର',
	'version-hooks' => 'ହୁକ',
	'version-extension-functions' => 'ଏକ୍ସଟେନସନ କାମସବୁ',
	'version-parser-extensiontags' => 'ପାର୍ସର ଏକ୍ସଟେନସନ ଚିହ୍ନ',
	'version-parser-function-hooks' => 'ପାର୍ସର କାମ ହୁକ',
	'version-hook-name' => 'ହୁକ ନାମ',
	'version-hook-subscribedby' => 'କାହା ଦେଇ ମଗାଯାଇଛି',
	'version-version' => '(ଭାଗ $1)',
	'version-license' => 'ଲାଇସେନ୍ସ',
	'version-poweredby-credits' => "ଏହି ଉଇକିଟି '''[//www.mediawiki.org/ ମିଡ଼ିଆଉଇକି]''' ଦେଇ ପରିଚାଳିତ, ସତ୍ଵାଧିକାର © ୨୦୦୧-$1 $2 ।",
	'version-poweredby-others' => 'ବାକିସବୁ',
	'version-license-info' => 'MediaWiki ଏକ ମାଗଣା ସଫ୍ଟୱାର; ଆପଣ ଏହାକୁ ପୁନବଣ୍ଟନ କରିପାରିବେ ବା GNU ଜେନେରାଲ ପବ୍ଲିକ ଲାଇସେନ୍ସ ଅଧିନରେ ବଦଳାଇପାରିବେ ଯାହା ଫ୍ରି ସଫ୍ଟୱାର ଫାଉଣ୍ଡେସନ ଦେଇ ପ୍ରକାଶିତ ହୋଇଥିବ।

MediaWiki ଉପଯୋଗୀ ହେବା ଲକ୍ଷରେ ବଣ୍ଟାଯାଇଥାଏ, କିନ୍ତୁ ଏହା କୌଣସି ଲିଖିତ ପଟା ସହ ଆସିନଥାଏ; ଏହା ବିକ୍ରୟଯୋଗ୍ୟତା ବା ଏକ ନିର୍ଦିଷ୍ଟ କାମପାଇଁ ବାଧ୍ୟତାମୂଳକ ପଟା ସହ ଆସିନଥାଏ । ଅଧିକ ଜାଣିବା ନିମନ୍ତେ ଦୟାକରି GNU ଜେନେରାଲ ପବ୍ଲିକ ଲାଇସେନ୍ସ ଦେଖନ୍ତୁ ।

ଆପଣ [{{SERVER}}{{SCRIPTPATH}}/COPYING GNU ଜେନେରାଲ ପବ୍ଲିକ ଲାଇସେନ୍ସର ନକଲଟିଏ] ଏହି ସଫ୍ଟୱାର ସହିତ ପାଇଥିବା ଜରୁରି; ଯଦି ପାଇନଥିବେ, ଫ୍ରି ସଫ୍ଟୱାର ଫାଉଣ୍ଡେସନ, Inc., ୫୧ ଫ୍ରାଙ୍କଲୀନ ଷ୍ଟ୍ରିଟ, ୫ମ ମହଲା, ବଷ୍ଟନ, ମାସାଚୁସେଟସ ୦୨୧୧୦-୧୩୦୧, ଯୁକ୍ତରାଷ୍ଟ୍ର ଆମେରିକା କିମ୍ବା [//www.gnu.org/licenses/old-licenses/gpl-2.0.html ଅନଲାଇନ] ପଢ଼ିନିଅନ୍ତୁ ।',
	'version-software' => 'ଇନଷ୍ଟଲ ହୋଇଥିବା ସଫ୍ଟୱାର',
	'version-software-product' => 'ଉତ୍ପାଦ',
	'version-software-version' => 'ସଂସ୍କରଣ',
);

$messages['os'] = array(
	'variants' => 'Варианттæ',
	'view' => 'Æркæст',
	'views' => 'Æркæстытæ',
	'versionrequired' => 'Хъæуы MediaWiki-йы версии $1',
	'viewsourceold' => 'Код кæсын',
	'viewsourcelink' => 'Код кæсын',
	'viewdeleted' => '$1 фенын дæ фæнды?',
	'viewsource' => 'Код кæсын',
	'viewsourcetext' => 'Ацы фарсы код фенæн æмæ халдих кæнæн ис:',
	'virus-unknownscanner' => 'æнæзонгæ антивирус:',
	'viewpagelogs' => 'Ацы фарсæн йæ логтæ равдисын',
	'viewprevnext' => 'Кæсын ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Фæлтæр',
	'version-version' => '(Фæлтæр $1)',
	'version-software-version' => 'Верси',
);

$messages['pa'] = array(
	'variants' => 'ਬਦਲ',
	'view' => 'ਵੇਖੋ',
	'views' => 'ਵੇਖੋ',
	'viewcount' => 'ਇਹ ਪੇਜ ਅਸੈੱਸ ਕੀਤਾ ਗਿਆ {{PLURAL:$1|ਇੱਕਵਾਰ|$1 ਵਾਰ}}.',
	'viewsourceold' => 'ਸਰੋਤ ਵੇਖੋ',
	'viewsourcelink' => 'ਸਰੋਤ ਵੇਖੋ',
	'viewdeleted' => '$1 ਵੇਖਣਾ?',
	'viewsource' => 'ਸਰੋਤ ਵੇਖੋ',
	'viewsourcetext' => 'ਤੁਸੀਂ ਇਸ ਪੰਨੇ ਦਾ ਸੋਮਾ ਦੇਖ ਸਕਦੇ ਹੋ ਤੇ ਉਸ ਦਾ ਉਤਾਰਾ ਵੀ ਲੈ ਸਕਦੇ ਹੋ।',
	'viewyourtext' => 'ਤੁਸੀਂ ਇਸ ਪੰਨੇ ਬਾਰੇ " ਆਪਣੇ ਸੰਪਾਦਨਾਂ " ਨੂੰ ਦੇਖ ਸਕਦੇ ਹੋ ਤੇ ਉਨ੍ਹਾਂ ਦਾ ਉਤਾਰਾ ਵਿ ਲੈ ਸਕਦੇ ਹੋ।',
	'viewpagelogs' => 'ਇਸ ਪੇਜ ਦੇ ਲਈ ਲਾਗ ਵੇਖੋ',
	'viewprevnext' => 'ਵੇਖੋ ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'ਵਰਜਨ',
);

$messages['pag'] = array(
	'viewdeleted' => 'Nengnengen so $1?',
	'viewsource' => 'Nengnengen so pinanlapuan',
	'viewsourcetext' => 'Sarag mon nengnengen san kopyaen so pinanlapuan na ayan bolong:',
	'viewdeletedpage' => 'Nengnengen so inekal ran bolong',
);

$messages['pam'] = array(
	'views' => 'Pamaglawe',
	'viewcount' => 'Ining bulung linawe da neng {{PLURAL:$1|misan|$1 besis/ukdu}}.',
	'versionrequired' => 'Ing bersion $1 ning MediaWiki ing kailangan',
	'versionrequiredtext' => 'Ing bersion $1 ning MediaWiki ing kailangan ba yang magamit ing bulung a ini. Lon ya ing [[Special:Version|bulung da reng bersion]].',
	'viewsourceold' => 'lawen ya ing penibatan',
	'viewsourcelink' => 'lon ya ing pikuanan',
	'viewdeleted' => 'Lon ya ing $1?',
	'viewsource' => 'Lon ya ing pikuanan',
	'viewsourcetext' => 'Malyari meng lon at kopian ing pikuanan (source) ning bulung a ini:',
	'viewpagelogs' => 'Lon la reng log para king bulung a ini',
	'viewprevnext' => 'Lon ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Lawen la reng meburang bulung',
	'version' => 'Bersion',
	'version-specialpages' => 'Bulung a makabukud',
	'version-other' => 'Aliwa',
	'version-version' => '(Bersion $1)',
	'version-license' => 'Lisensia',
	'version-software-product' => 'Produktu',
	'version-software-version' => 'Bersion',
);

$messages['pap'] = array(
	'views' => 'Kantidat di biaha mirá',
	'viewcount' => 'E paginá aki a wòrdu mirá {{PLURAL:$1|biaha|$1 biaha}}.',
	'viewsource' => 'Wak fuente',
);

$messages['pcd'] = array(
	'variants' => 'Ércanjantes',
	'view' => 'Vir',
	'viewdeleted_short' => '{{PLURAL:$1|eune édition défacée|$1  éditions défacées}}',
	'views' => 'Vues',
	'viewcount' => "L' page-lo ale o té vue {{PLURAL:$1|1 foués|$1 foués}}.",
	'viewsourceold' => "vir l'source",
	'viewsourcelink' => 'vir el source',
	'viewdeleted' => 'Vir $1?',
	'viewsource' => "Vir l'source",
	'viewsource-title' => "Vir l'source éd $1",
	'virus-unknownscanner' => 'intivirus poin connu:',
	'viewpagelogs' => 'Vir chés gasètes del pache-lo',
	'viewprevnext' => 'Vir ($1 {{int:pipe-separator}} $2) ($3)',
	'version-specialpages' => 'Paches éspéchiales',
);

$messages['pdc'] = array(
	'views' => 'Aasichte',
	'versionrequired' => 'Muss Version $1 vun MediaWiki sei',
	'versionrequiredtext' => 'Muss Version $1 vun MediaWiki sei, fer es Blatt zu yuuse.
Guck aa [[Special:Version|Versionsblatt]]',
	'viewdeleted' => '$1 zeige?',
	'viewsourcefor' => 'fer $1',
	'virus-unknownscanner' => 'Unbekannter Virus-Uffgucker:',
	'viewprevnext' => 'Zeige ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Version',
	'version-specialpages' => 'Besunnere Bledder',
	'version-other' => 'Anneres',
	'version-mediahandlers' => 'Media-Haendlers',
	'version-version' => '(Version $1)',
	'version-software-version' => 'Version',
);

$messages['pdt'] = array(
	'views' => 'Aunsechte',
	'versionrequired' => 'Versioon $1 von MediaWiki es needich',
	'viewdeleted' => '$1 wiese?',
	'viewprevnext' => 'Tjitj ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['pfl'] = array(
	'views' => 'Wievielmol aageguckt',
	'viewcount' => 'Die Seid isch bis jetzerd {{PLURAL:$1|$1|$1}} mol uffgerufe worre.',
	'viewsourcelink' => 'Quell aagucke',
	'viewsource' => 'Quelltekschd betrachde',
	'viewpagelogs' => 'D Lochbiecher fer die Said aagucke',
	'viewprevnext' => 'Gugg ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['pl'] = array(
	'variants' => 'Warianty',
	'view' => 'Podgląd',
	'viewdeleted_short' => 'Podgląd {{PLURAL:$1|usuniętej|$1 usuniętych}} wersji',
	'views' => 'Widok',
	'viewcount' => 'Tę stronę obejrzano {{PLURAL:$1|tylko raz|$1 razy}}.',
	'view-pool-error' => 'Niestety w chwili obecnej serwery są przeciążone.
Zbyt wielu użytkowników próbuje wyświetlić tę stronę.
Poczekaj chwilę przed ponowną próbą dostępu do tej strony.

$1',
	'versionrequired' => 'Wymagane MediaWiki w wersji $1',
	'versionrequiredtext' => 'Użycie tej strony wymaga oprogramowania MediaWiki w wersji $1. Zobacz stronę [[Special:Version|wersja oprogramowania]].',
	'viewsourceold' => 'pokaż źródło',
	'viewsourcelink' => 'tekst źródłowy',
	'viewdeleted' => 'Zobacz $1',
	'viewsource' => 'Tekst źródłowy',
	'viewsource-title' => 'Tekst źródłowy strony $1',
	'viewsourcetext' => 'Tekst źródłowy strony można podejrzeć i skopiować.',
	'viewyourtext' => "Tekst źródłowy '''zmodyfikowanej''' przez Ciebie strony możesz podejrzeć i skopiować",
	'virus-badscanner' => "Zła konfiguracja – nieznany skaner antywirusowy ''$1''",
	'virus-scanfailed' => 'skanowanie nieudane (błąd $1)',
	'virus-unknownscanner' => 'nieznany program antywirusowy',
	'viewpagelogs' => 'Zobacz rejestry operacji dla tej strony',
	'viewprevnext' => 'Zobacz ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Plik nie przeszedł pozytywnie weryfikacji.',
	'viewdeletedpage' => 'Zobacz usunięte wersje',
	'version' => 'Wersja oprogramowania',
	'version-extensions' => 'Zainstalowane rozszerzenia',
	'version-specialpages' => 'Strony specjalne',
	'version-parserhooks' => 'Haki analizatora składni (ang. parser hooks)',
	'version-variables' => 'Zmienne',
	'version-antispam' => 'Ochrona przed spamem',
	'version-skins' => 'Skórki',
	'version-other' => 'Pozostałe',
	'version-mediahandlers' => 'Wtyczki obsługi mediów',
	'version-hooks' => 'Haki (ang. hooks)',
	'version-extension-functions' => 'Funkcje rozszerzeń',
	'version-parser-extensiontags' => 'Znaczniki rozszerzeń dla analizatora składni',
	'version-parser-function-hooks' => 'Funkcje haków analizatora składni (ang. parser function hooks)',
	'version-hook-name' => 'Nazwa haka (ang. hook name)',
	'version-hook-subscribedby' => 'Zapotrzebowany przez',
	'version-version' => '(Wersja $1)',
	'version-license' => 'Licencja',
	'version-poweredby-credits' => "To wiki korzysta z oprogramowania '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001‐$1 $2.",
	'version-poweredby-others' => 'inni',
	'version-license-info' => 'MediaWiki jest wolnym oprogramowaniem – możesz je dystrybuować i modyfikować zgodnie z warunkami licencji GNU General Public License opublikowanej przez Free Software Foundation w wersji 2 tej licencji lub (jeśli wolisz) dowolnej późniejszej.

MediaWiki jest dystrybuowane w nadziei, że okaże się użyteczne ale BEZ JAKIEJKOLWIEK GWARANCJI – nawet bez domyślnej gwarancji PRZYDATNOŚCI HANDLOWEJ lub PRZYDATNOŚCI DO OKREŚLONYCH ZASTOSOWAŃ. Więcej szczegółów znajdziesz w treści licencji GNU General Public License.

Powinieneś otrzymać [{{SERVER}}{{SCRIPTPATH}}/COPYING kopię licencji GNU General Public License] wraz z niniejszym oprogramowaniem. Jeśli tak się nie stało, napisz do Free Software Foundation, Inc, 51 Franklin Street, Fifth Floor , Boston, MA 02110-1301, USA lub [//www.gnu.org/licenses/old-licenses/gpl-2.0.html przeczytaj licencję w Internecie].',
	'version-software' => 'Zainstalowane oprogramowanie',
	'version-software-product' => 'Nazwa',
	'version-software-version' => 'Wersja',
	'vertical-tv' => 'TV',
	'vertical-games' => 'Gry',
	'vertical-books' => 'Książki',
	'vertical-comics' => 'Komiksy',
	'vertical-lifestyle' => 'Lifestyle',
	'vertical-music' => 'Muzyka',
	'vertical-movies' => 'Filmy',
);

$messages['pms'] = array(
	'variants' => 'Variant',
	'view' => 'Vardé',
	'viewdeleted_short' => 'Vardé {{PLURAL:$1|na modìfica scancelà|$1 modìfiche scancelà}}',
	'views' => 'vìsite',
	'viewcount' => "St'artìcol-sì a l'é stàit lesù {{PLURAL:$1|na vira|$1 vire}}.",
	'view-pool-error' => "An dëspias, ij servent a son motobin carià al moment.
Tròpi utent a son an camin ch'a preuvo a lese sta pàgina-sì.
Për piasì, speta un pòch prima ëd prové torna a vardé sta pàgina-sì.

$1",
	'versionrequired' => 'A-i va për fòrsa la version $1 ëd MediaWiki',
	'versionrequiredtext' => 'Për dovré sta pàgina-sì a-i va la version $1 dël programa MediaWiki. Che a varda [[Special:Version]]',
	'viewsourceold' => 'fa vëdde ël còdes sorgiss',
	'viewsourcelink' => 'fà vëdde ël còdes sorgiss',
	'viewdeleted' => 'Veul-lo vardé $1?',
	'viewsource' => 'Vardé la sorgiss',
	'viewsource-title' => 'Vëdde la sorgiss ëd $1',
	'viewsourcetext' => 'A peul vardé e copié la sorgiss dë sta pàgina:',
	'viewyourtext' => "A peule vëdde e copié la sorziss ëd '''soe modìfiche''' a costa pàgina-sì:",
	'virus-badscanner' => "Configurassion falà: antivìrus nen conossù: ''$1''",
	'virus-scanfailed' => 'scansion falìa (còdes $1)',
	'virus-unknownscanner' => 'antivìrus nen conossù:',
	'viewpagelogs' => 'Smon ij registr dë sta pàgina-sì',
	'viewprevnext' => 'Che a varda ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => "Cost archivi a l'ha pa passà la verìfica dj'archivi.",
	'viewdeletedpage' => 'Smon-e le pàgine scancelà',
	'version' => 'Version',
	'version-extensions' => 'Estension anstalà',
	'version-specialpages' => 'Pàgine speciaj',
	'version-parserhooks' => 'Gancio dlë scompositor',
	'version-variables' => 'Variàbij',
	'version-antispam' => 'Prevension dla rumenta',
	'version-skins' => 'Pej',
	'version-other' => 'Àutr',
	'version-mediahandlers' => 'Gestor multimojen',
	'version-hooks' => 'Gancio',
	'version-extension-functions' => "Fonsion dj'estension",
	'version-parser-extensiontags' => "Tacolèt dj'estension conossùe da lë scompositor",
	'version-parser-function-hooks' => 'Gancio për le fonsion dlë scompositor',
	'version-hook-name' => 'Nòm dël gancio',
	'version-hook-subscribedby' => 'A son scrivusse',
	'version-version' => '(Version $1)',
	'version-license' => 'Licensa',
	'version-poweredby-credits' => "Sta wiki-sì a l'é basà su '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'àutri',
	'version-license-info' => "MediaWiki a l'é un programa lìber; a peul passelo an gir e/o modifichelo sota le condission dla Licensa Pùblica General GNU coma publicà da la Free Software Foundation; o la version 2 dla licensa o (a soa decision) qualsëssìa version apress.

MediaWiki a l'é distribuì ant la speransa che a sia ùtil, ma SENSA GNUN-A GARANSÌA; sensa gnanca la garansìa implìcita ëd COMERSIABILITA' o d'ADATAMENT A UN BUT PARTICOLAR. Ch'a lesa la Licensa General Pùblica GNU per pi 'd detaj.

A dovrìa avèj arseivù [{{SERVER}}{{SCRIPTPATH}}/COPYING na còpia dla Licensa Pùblica General GNU] ansema a sto programa-sì; dësnò, ch'a scriva a la Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA o [//www.gnu.org/licenses/old-licenses/gpl-2.0.html ch'a la lesa an linia].",
	'version-software' => 'Programa anstalà',
	'version-software-product' => 'Prodot',
	'version-software-version' => 'Version',
);

$messages['pnb'] = array(
	'variants' => 'قسماں',
	'view' => 'وکھالہ',
	'viewdeleted_short' => 'ویکھو {{PLURAL:$1|اک مٹائی گئی تبدیلی|$1 مٹائیاں گئیاں تبدیلیاں}}',
	'views' => 'منظر',
	'viewcount' => 'اس صفحے نوں {{PLURAL:$1|اک واری|$1 واری}} کھولیا گیا اے۔',
	'view-pool-error' => '$1',
	'versionrequired' => 'میڈیا وکی دا $1 ورژن چائیدا اے۔',
	'versionrequiredtext' => 'میڈیا وکی دا $1 ورژن اس صفحے نوں ویکھن واسطے چائیدا اے۔
[[Special:Version|ورژن آلا صفحہ]] وکیھو',
	'viewsourceold' => 'لکھیا ویکھو',
	'viewsourcelink' => 'لکھائی وکھاؤ',
	'viewdeleted' => 'ویکھو $1 ؟',
	'viewsource' => 'ویکھو',
	'viewsource-title' => '$1 لئی سورس ویکھو',
	'viewsourcetext' => 'تسی اس صفحے دی لکھائی نوں ویکھ تے نقل کر سکدے او:',
	'viewyourtext' => 'تسیں آپنی تبدیلیاں دا ذریعہ ایس صفے تے ویکھ تے کاپی کرسکدے او۔',
	'virus-badscanner' => "غلط تریقہ کار: انجان وائرس کھوجی: ''$1''",
	'virus-scanfailed' => 'کھوج نا ہوسکی (کوڈ $1)',
	'virus-unknownscanner' => 'اندیکھا اینٹیوائرس:',
	'viewpagelogs' => 'صفحے دے لاگ ویکھو',
	'viewprevnext' => 'ویکھو ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'ایس فائل نے فائل ویریفیکیشن پاس نئیں کیتی۔',
	'viewdeletedpage' => 'مٹاۓ گۓ صفحے ویکھو',
	'version' => 'ورژن',
	'version-extensions' => 'انسٹالڈ کیتیاں گیاں ایکسٹنشن',
	'version-specialpages' => 'خاص صفحے',
	'version-parserhooks' => 'پارسر ہکز',
	'version-variables' => 'ویریایبلز',
	'version-antispam' => 'سپام بچاؤ',
	'version-skins' => 'کھل',
	'version-other' => 'دوجے',
	'version-mediahandlers' => 'میڈیا ہینڈلرز',
	'version-hooks' => 'ہکز',
	'version-extension-functions' => 'ایکسٹنشن فنکشن',
	'version-parser-extensiontags' => 'پاسر ایکسٹنشن ٹیگز',
	'version-parser-function-hooks' => 'پاسر فنکشن ہکز',
	'version-hook-name' => 'ہک ناں',
	'version-hook-subscribedby' => 'جینے لئی',
	'version-version' => '(ورین $1)',
	'version-license' => 'لائیسنس',
	'version-poweredby-credits' => "ایس وکی نوں '''[//www.mediawiki.org/ میڈیاوکی]''', copyright © 2001-$1 $2. چلاندا اے۔",
	'version-poweredby-others' => 'دوجے',
	'version-license-info' => 'میڈیاوکی اک مفت سوفٹویر اے؛ تسیں اینوں ونڈ سکدے اوہ تے گنو جنرل پبلک لسنس دیاں شرطاں تے جیہڑیاں فری سوفٹویر فاؤنڈیشن نے چھاپیاں نیں ایدے چ تبدیلی کرسکدے اوہ لسنس دے ورین 2 نال، یا اپنی مرضی نال کسے وی ہور ورین فیر بنن والے ورین نوں۔

میڈیاوکی ایس آس نال ونڈیا گیا اے جے ایہ فیدا دیوے گا پر ایدی کوئی وارنٹی نئیں ؛ کسے خاص کم لئی ٹھیک ہون دی وارنٹی توں وی بنا۔ گنو جنرل پبلک لسنس ویکھو ہور گلاں لئی۔

تسیں ایس پروکرام نال لے چکے اوہ [{{سرور}}{{سکرپٹراہ}}/جنرل پبلک لسنس دی کاپی] ایس کم نال ؛ اگر نئیں تے  چٹھی لکھو 
the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA or [//www.gnu.org/licenses/old-licenses/gpl-2.0.html read it online]',
	'version-software' => 'سافٹوئر چڑھ گیا۔',
	'version-software-product' => 'پراڈکٹ',
	'version-software-version' => 'ورژن',
);

$messages['pnt'] = array(
	'variants' => 'Παραλλαγάς',
	'views' => 'Τερέματα',
	'versionrequiredtext' => 'Για να κουλεύετε αβούτεν τη σελίδαν χρειάσκεται η έκδοση $1 τη MediaWiki.
Τερέστεν τη [[Special:Version|version page]].',
	'viewsourceold' => 'τερέστεν κωδικόν',
	'viewsourcelink' => 'τερέστεν κωδικόν',
	'viewdeleted' => 'Τερέστεν το $1;',
	'viewsource' => 'Τερέστεν κωδικόν',
	'viewsourcetext' => "Επορείτε να τερείτε και ν' αντιγράφετε το κείμενον τ' ατεινές τη σελίδας:",
	'virus-unknownscanner' => 'αναγνώριμον αντιικόν:',
	'viewpagelogs' => "Τέρεν αρχεία γι' αβούτεν τη σελίδαν",
	'viewprevnext' => 'Τέρεν ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Έκδοση',
	'version-extensions' => "Επεκτάσεις ντ'εθέκαν",
	'version-specialpages' => 'Ειδικά σελίδας',
	'version-variables' => 'Μεταβλητάς',
	'version-other' => 'Αλλέτερα',
	'version-hooks' => 'Αγκιστρία',
	'version-license' => 'Ἀδεια',
	'version-software' => "Λογισμικόν ντ'εθέκεν",
	'version-software-version' => 'Έκδοση',
);

$messages['prg'] = array(
	'variants' => 'Warjāntai',
	'views' => 'Pawīda',
	'viewcount' => 'Šin pāusan bēi dirītan {{PLURAL:$1|tēr ainawārst|$1 wārst}}',
	'versionrequired' => 'Izkīninta Mediawikis $1 wersiōni: $1.',
	'versionrequiredtext' => 'Mediawīkis $1 wersiōni ast izkīnintan, kāi tērpaulai šin pāusan. Wīdais [[Special:Version|wersiōni]]',
	'viewsourceold' => 'Waidinnais appun',
	'viewsourcelink' => 'appus kōdan',
	'viewdeleted' => 'Wīdais $1',
	'viewsource' => 'Wīdais appun',
	'viewsourcetext' => 'Mazīngi widātun be kōpitun šisse pāusan appun:',
	'virus-badscanner' => 'Wārga kōnfiguraciōni: niwaīsts antiwīrusas skanītajs: "$1"',
	'virus-scanfailed' => 'skanisnā niizpaltan (blānda $1)',
	'virus-unknownscanner' => 'niwaīsts antiwīruss:',
	'viewpagelogs' => 'Wīdais šisse pāusas regīsterins',
	'viewprevnext' => 'Wīdais ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Wīdais āupausintans wersiōnins',
	'version' => 'Wersiōni',
	'version-extensions' => 'Instalītai plattinsenei',
	'version-specialpages' => 'Speciālai pāusai',
	'version-parserhooks' => 'Parseras ānsai',
	'version-variables' => 'Wariāblis',
	'version-other' => 'Kitāi',
	'version-hooks' => 'Ānsai',
	'version-extension-functions' => 'Plattinsenes funkciōnis',
	'version-parser-extensiontags' => 'Parseras plattinsenes zentlitajai',
	'version-parser-function-hooks' => 'Parseras funkciōnis ānsai',
	'version-hook-name' => 'Ānsas pabilisnā',
	'version-version' => '(Wersiōni $1)',
	'version-license' => 'Licēnci',
	'version-software' => 'Instalītas prōgraminis',
	'version-software-version' => 'Wersiōni',
);

$messages['ps'] = array(
	'view' => 'کتل',
	'viewdeleted_short' => '{{PLURAL:$1|يو ړنګ شوی سمون|$1 ړنګ شوي سمونونه}} کتل',
	'views' => 'کتنې',
	'viewcount' => 'همدا مخ {{PLURAL:$1|يو وار|$1 واره}} کتل شوی.',
	'view-pool-error' => 'اوبخښۍ، دم ګړۍ پالنګران د ډېر بارېدو ستونزې سره مخامخ شوي.
ډېر زيات کارنان د همدې مخ د کتلو په هڅه کې دي.
لطفاً د دې مخ د کتلو د بيا هڅې نه دمخه يو څو شېبې صبر وکړۍ.

$1',
	'versionrequired' => 'د ميډياويکي $1 بڼې ته اړتيا ده',
	'versionrequiredtext' => 'د دې مخ په ليدلو کې د مېډياويکي $1 بڼې ته اړتيا ده.
[[Special:Version|د بڼې مخ وګورۍ]].',
	'viewsourceold' => 'سرچينې کتل',
	'viewsourcelink' => 'سرچينه کتل',
	'viewdeleted' => '$1 کتل؟',
	'viewsource' => 'سرچينه کتل',
	'viewsource-title' => 'د $1 سرچينه کتل',
	'viewsourcetext' => 'تاسې د دې مخ سرچينه کتلی او لمېسلی شی:',
	'virus-badscanner' => "بده سازېدنه: د ويروس ناڅرګنده ځيرڅار: ''$1''",
	'virus-unknownscanner' => 'ناڅرګند ضدويروس:',
	'viewpagelogs' => 'د دې مخ يادښتونه کتل',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) کتل',
	'viewdeletedpage' => 'ړنګ شوي مخونه کتل',
	'version' => 'بڼه',
	'version-extensions' => 'لګېدلي شاتاړي',
	'version-specialpages' => 'ځانګړي مخونه',
	'version-skins' => 'پوښۍ',
	'version-other' => 'بل',
	'version-version' => '(بڼه $1)',
	'version-license' => 'منښتليک',
	'version-poweredby-credits' => "دا ويکي د '''[//www.mediawiki.org/ مېډياويکي]''' په سېک چلېږي، ټولې رښتې خوندي دي © 2001-$1 $2.",
	'version-poweredby-others' => 'نور',
	'version-license-info' => 'مېډياويکي يو وړيا ساوتری دی؛ تاسې يې په ډاډه زړه د GNU د ټولګړو کارېدنو د منښتليک چې د وړيا ساوتريو د بنسټ له مخې خپور شوی، خپرولی او/يا بدلولی شی؛ د منښتليک ۲ بڼه او يا (ستاسې د خوښې) هر يوه وروستۍ بڼه.

مېډياويکي د ښه کارېدنې په نيت خپور شوی، خو د ضمني سوداګريز او يا د کوم ځانګړي کار د ضمانت نه پرته. د نورو مالوماتو لپاره د GNU د ټولګړو کارېدنو منښتليک وګورۍ.

تاسې بايد د دې پروګرام سره يو [{{SERVER}}{{SCRIPTPATH}}/COPYING a copy of the GNU General Public License] ترلاسه کړی وي؛ که داسې نه وي، نو د وړيا ساوتريو بنسټ، Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA ته يو ليک وليکۍ، او يا يې [//www.gnu.org/licenses/old-licenses/gpl-2.0.html پرليکه ولولۍ].',
	'version-software' => 'نصب شوی ساوتری',
	'version-software-product' => 'اېبره',
	'version-software-version' => 'بڼه',
);

$messages['pt'] = array(
	'variants' => 'Variantes',
	'view' => 'Ver',
	'viewdeleted_short' => 'Ver {{PLURAL:$1|uma edição eliminada|$1 edições eliminadas}}',
	'views' => 'Vistas',
	'viewcount' => 'Esta página foi acedida {{PLURAL:$1|uma vez|$1 vezes}}.',
	'view-pool-error' => 'Desculpe, mas de momento os servidores estão sobrecarregados.
Há demasiados utilizadores a tentar visionar esta página.
Espere um pouco antes de tentar aceder à página novamente, por favor.

$1',
	'versionrequired' => 'É necessária a versão $1 do MediaWiki',
	'versionrequiredtext' => 'É necessária a versão $1 do MediaWiki para usar esta página.
Consulte a página da [[Special:Version|versão do sistema]].',
	'viewsourceold' => 'ver código',
	'viewsourcelink' => 'ver fonte',
	'viewdeleted' => 'Ver $1?',
	'viewsource' => 'Ver conteúdo',
	'viewsource-title' => 'Mostrar código-fonte de $1',
	'viewsourcetext' => 'Pode ver e copiar o conteúdo desta página:',
	'viewyourtext' => "Você pode ver e copiar o código-fonte das '''suas edições''' a esta página:",
	'virus-badscanner' => "Má configuração: antivírus desconhecido: ''$1''",
	'virus-scanfailed' => 'a verificação falhou (código $1)',
	'virus-unknownscanner' => 'antivírus desconhecido:',
	'viewpagelogs' => 'Ver registos para esta página',
	'viewprevnext' => 'Ver ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'O ficheiro não passou a verificação de ficheiros.',
	'viewdeletedpage' => 'Ver páginas eliminadas',
	'version' => 'Versão',
	'version-extensions' => 'Extensões instaladas',
	'version-specialpages' => 'Páginas especiais',
	'version-parserhooks' => "''Hooks'' do analisador sintáctico",
	'version-variables' => 'Variáveis',
	'version-antispam' => 'Prevenção contra spam',
	'version-skins' => 'Temas',
	'version-other' => 'Diversos',
	'version-mediahandlers' => 'Leitura e tratamento de multimédia',
	'version-hooks' => 'Hooks',
	'version-extension-functions' => 'Funções de extensão',
	'version-parser-extensiontags' => 'Extensões do analisador sintáctico',
	'version-parser-function-hooks' => "''Hooks'' das funções do analisador sintáctico",
	'version-hook-name' => 'Nome do hook',
	'version-hook-subscribedby' => 'Subscrito por',
	'version-version' => '(Versão $1)',
	'version-license' => 'Licença',
	'version-poweredby-credits' => "Esta é uma wiki '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'outros',
	'version-license-info' => 'O MediaWiki é software livre; pode redistribuí-lo e/ou modificá-lo nos termos da licença GNU General Public License, tal como publicada pela Free Software Foundation; tanto a versão 2 da Licença, como (por opção sua) qualquer versão posterior.

O MediaWiki é distribuído na esperança de que seja útil, mas SEM QUALQUER GARANTIA; inclusive, sem a garantia implícita da POSSIBILIDADE DE SER COMERCIALIZADO ou de ADEQUAÇÂO PARA QUALQUER FINALIDADE ESPECÍFICA. Consulte a licença GNU General Public License para mais detalhes.

Em conjunto com este programa deve ter recebido [{{SERVER}}{{SCRIPTPATH}}/COPYING uma cópia da licença GNU General Public License]; se não a recebeu, peça-a por escrito para Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA ou [//www.gnu.org/licenses/old-licenses/gpl-2.0.html leia-a na internet].',
	'version-software' => 'Software instalado',
	'version-software-product' => 'Produto',
	'version-software-version' => 'Versão',
);

$messages['pt-br'] = array(
	'variants' => 'Variantes',
	'view' => 'Ver',
	'viewdeleted_short' => 'Ver {{PLURAL:$1|uma edição eliminada|$1 edições eliminadas}}',
	'views' => 'Visualizações',
	'viewcount' => 'Esta página foi acessada {{PLURAL:$1|uma vez|$1 vezes}}.',
	'view-pool-error' => 'Desculpe-nos, os servidores estão sobrecarregados neste momento.
Muitos usuários estão tentando ver esta página.
Aguarde um instante antes de tentar acessar esta página novamente.

$1',
	'versionrequired' => 'É necessária a versão $1 do MediaWiki',
	'versionrequiredtext' => 'Esta página requer a versão $1 do MediaWiki para ser utilizada.
Veja a [[Special:Version|página sobre a versão do sistema]].',
	'viewsourceold' => 'ver código-fonte',
	'viewsourcelink' => 'ver código-fonte',
	'viewdeleted' => 'Ver $1?',
	'viewsource' => 'Ver código-fonte',
	'viewsource-title' => 'Exibir código-fonte para $1',
	'viewsourcetext' => 'Você pode ver e copiar o código desta página:',
	'viewyourtext' => "Pode ver e copiar o código fonte '''das suas edições''' nesta página:",
	'virus-badscanner' => "Má configuração: antivírus desconhecido: ''$1''",
	'virus-scanfailed' => 'a verificação falhou (código $1)',
	'virus-unknownscanner' => 'antivírus desconhecido:',
	'viewpagelogs' => 'Ver registros para esta página',
	'viewprevnext' => 'Ver ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Este arquivo não passou pela verificação de arquivos.',
	'viewdeletedpage' => 'Ver páginas eliminadas',
	'version' => 'Versão',
	'version-extensions' => 'Extensões instaladas',
	'version-specialpages' => 'Páginas especiais',
	'version-parserhooks' => 'Hooks do analisador (parser)',
	'version-variables' => 'Variáveis',
	'version-antispam' => 'Prevenção contra spam',
	'version-skins' => 'Temas',
	'version-other' => 'Diversos',
	'version-mediahandlers' => 'Executores de média',
	'version-hooks' => 'Hooks',
	'version-extension-functions' => 'Funções de extensão',
	'version-parser-extensiontags' => 'Etiquetas de extensões de tipo "parser"',
	'version-parser-function-hooks' => 'Funções "hooks" de "parser"',
	'version-hook-name' => 'Nome do hook',
	'version-hook-subscribedby' => 'Subscrito por',
	'version-version' => '(Versão $1)',
	'version-license' => 'Licença',
	'version-poweredby-credits' => "Este é um wiki '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'outros',
	'version-license-info' => 'O MediaWiki é software livre; pode redistribuí-lo e/ou modificá-lo nos termos da licença GNU General Public License, tal como publicada pela Free Software Foundation; tanto a versão 2 da Licença, como (por opção sua) qualquer versão posterior.

O MediaWiki é distribuído na esperança de que seja útil, mas SEM QUALQUER GARANTIA; inclusive, sem a garantia implícita da POSSIBILIDADE DE SER COMERCIALIZADO ou de ADEQUAÇÂO PARA QUALQUER FINALIDADE ESPECÍFICA. Consulte a licença GNU General Public License para mais detalhes.

Em conjunto com este programa deve ter recebido [{{SERVER}}{{SCRIPTPATH}}/COPYING uma cópia da licença GNU General Public License]; se não a recebeu, peça-a por escrito para Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA ou [//www.gnu.org/licenses/old-licenses/gpl-2.0.html leia-a na internet].',
	'version-software' => 'Software instalado',
	'version-software-product' => 'Produto',
	'version-software-version' => 'Versão',
	'version-entrypoints' => 'URLs dos pontos de entrada',
	'version-entrypoints-header-entrypoint' => 'Ponto de entrada',
	'version-entrypoints-header-url' => 'URL',
	'vertical-games' => 'Jogos',
	'vertical-lifestyle' => 'Estilo de Vida',
	'vertical-movies' => 'Entretenimento',
);

$messages['qu'] = array(
	'variants' => "Ñawra rikch'akuykuna",
	'view' => 'Qhaway',
	'viewdeleted_short' => '{{PLURAL:$1|qullusqa hukchasqa|$1 qullusqa hukchasqa}} qhaway',
	'views' => 'Rikunakuna',
	'viewcount' => "Kay p'anqaqa {{PLURAL:$1|huk kuti|$1 kuti}} watukusqañam.",
	'view-pool-error' => "Achachaw, sirwiqkunaqa nisyu sasachakuyniyuqmi kachkan.
Nisyu ruraqkunam kay p'anqataqa qhawayta munachkan.
Ama hina kaspa, ratullata suyay kay p'anqata manaraq musuqmanta qhawaykachaspa.

$1",
	'versionrequired' => "$1 nisqa MediaWiki llamk'apusqatam muchunki kay p'anqata llamk'achinaykipaq",
	'versionrequiredtext' => "$1 nisqa MediaWiki llamk'apusqatam muchunki kay p'anqata llamk'achinaykipaq. Astawan willasunaykipaqqa, [[Special:Version]] nisqapi qhaway",
	'viewsourceold' => 'pukyu qillqata qhaway',
	'viewsourcelink' => 'pukyu qillqata qhaway',
	'viewdeleted' => "$1 p'anqata rikuyta munankichu?",
	'viewsource' => 'Pukyu qillqata qhaway',
	'viewsource-title' => "$1 sutiyuq p'anqap pukyu qillqanta qhaway",
	'viewsourcetext' => "Kay p'anqap pukyu qillqantam qhawayta iskaychaytapas atinki:",
	'viewyourtext' => "'''Qampa llamk'apusqayki'''p pukyu qillqantam qhawayta iskaychaytapas atinki:",
	'virus-badscanner' => "Manam allintachu churapusqa: mana riqsisqa añaw maskaq: ''$1''",
	'virus-scanfailed' => 'manam atinchu añaw maskayta (tuyru: $1)',
	'virus-unknownscanner' => 'mana riqsisqa añaw qulluna (antivirus):',
	'viewpagelogs' => "Kay p'anqamanta hallch'akunata qhaway",
	'viewprevnext' => 'Qhaway ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Kay willañiqiqa willañiqi chaninchaypi manam yallirqanchu.',
	'viewdeletedpage' => "Qullusqa p'anqakunata qhaway",
	'version' => 'Musuqchasqa',
	'version-extensions' => "Tiyachisqa mast'arinakuna",
	'version-specialpages' => "Sapaq p'anqakuna",
	'version-parserhooks' => "T'ikrana ch'iwinakuna",
	'version-variables' => 'Hukchakuqkuna',
	'version-antispam' => "Spam hark'ay",
	'version-skins' => 'Qarakuna',
	'version-other' => 'Wakin',
	'version-mediahandlers' => "Midya llamk'apuq",
	'version-hooks' => "Ch'iwinakuna",
	'version-extension-functions' => "Mast'arina ruranakuna",
	'version-parser-extensiontags' => "T'ikrana mast'arina ruranakuna",
	'version-parser-function-hooks' => "T'ikrana rurana ch'iwinakuna",
	'version-hook-name' => "Ch'iwinap sutin",
	'version-hook-subscribedby' => 'Kay runap mañaykusqan:',
	'version-version' => '(Musuqchasqa $1)',
	'version-license' => 'Saqillay',
	'version-poweredby-credits' => "Kay wikitaqa '''[//www.mediawiki.org/ MediaWiki-m]''' atichin, copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'hukkuna',
	'version-license-info' => "MediaWiki llamp'u kaqqa qispim; mast'ariytam icha wakinchaytam atinki GNU General Public License nisqa saqillaypa kamachisqankama, Free Software Foundation nisqap uyaychasqan; saqillaypa iskay ñiqin musuqchasqan, munaspaykiqa aswan musuq musuqchasqan.

MediaWikitaqa mast'ariyku runakunata yanapanapaqmi, ichataq MANAM FIYAKUYTA ATIYKUCHU; manapas ch'aqtasqa RURANALLA FIYAKUYTACHU manapas ima SAPAQ TUKUYNINPAQCHU. GNU General Public License nisqa saqillayta qhaway aswan yuyaykunapaq.

[{{SERVER}}{{SCRIPTPATH}}/COPYING GNU General Public License nisqa saqillaymanta iskaychasqata] chaskiykiman kay wakichinawan; manaqa, kayman qillqamuwayku: Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA icha [//www.gnu.org/licenses/old-licenses/gpl-2.0.html internet llikapi ñawiriy].",
	'version-software' => "Tiyachisqa llamp'u kaq",
	'version-software-product' => 'Ruruchisqa',
	'version-software-version' => 'Musuqchasqa',
	'version-entrypoints' => "Yaykuna t'uksi URL",
	'version-entrypoints-header-entrypoint' => "Yaykuna t'uksi",
	'version-entrypoints-header-url' => 'URL tiyay',
);

$messages['qug'] = array(
	'variants' => 'Shuk rikuchiy shinakuna',
	'view' => 'Rikuna',
	'viewdeleted_short' => '{{PLURAL:$1|shuk pichashka killkayta|$1 pichashka killkaykunata}} rikuna',
	'views' => 'Rikunakuna',
	'viewcount' => 'Kay pankaka ñami  {{PLURAL:$1|una vezta|$1 vecesta}} rikushkami karka',
	'view-pool-error' => 'Atatay, kunan ratupi pankayuk antawakuna yapa trabajuta charinmi. 
Yapa runakuna kay pankata rikukunmi.
Ama shinachu kapay, ashakuta shuyapay, kipalla kutin pankata rikunkapak shamupay.

$1',
	'versionrequired' => 'Kayta Mediawiki $1 nishkawanlla ruranata ushapanki.',
	'versionrequiredtext' => 'Kayta Mediawiki $1 nishkawanlla ruranata ushapanki. Ashtawan yachakunkapak, [[Special:Version|version page]] pankata rikukripay.',
	'viewsourceold' => 'Pukyu killkata rikuna',
	'viewsourcelink' => 'Pukyu killkata rikuna',
	'viewdeleted' => '$1 pankata rikunata munapanki ?',
	'viewsource' => 'Pukyu killkata rikuna',
	'viewsourcetext' => 'Kay pankapak wiki killkayta rikunata, ishkachinatapash ushapankimi.',
	'viewpagelogs' => 'Kay pankapa kamukunata rikuna',
	'viewprevnext' => 'Rikuna ($1 {{int:pipe-separator}} $2) ($3).',
);

$messages['rgn'] = array(
	'views' => 'Chi èl pasé da que',
	'viewsourcelink' => "guèrda e' codiz surgént",
	'viewsource' => "Guèrda e' codiz surgént",
	'viewpagelogs' => "Guèrda i regestar d'sta pàgina",
	'viewprevnext' => 'Guèrda ($1 {{int:pipe-separator}} $2) ($3).',
);

$messages['rif'] = array(
	'views' => 'Timmeẓṛa',
	'viewsourcelink' => 'ẓṛ aghbalu',
	'viewsource' => 'Ẓṛ aghbalu',
	'viewsourcetext' => 'Tzemred a tẓerd u atsneɣled aɣbal n Tasna ya :',
	'viewpagelogs' => 'Ẓar aɣmis n Tasna ya',
	'viewprevnext' => 'Ẓeṛ ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Tunɣilt',
	'version-specialpages' => 'Tudmawin Special',
);

$messages['rm'] = array(
	'variants' => 'Variantas',
	'view' => 'Leger',
	'viewdeleted_short' => 'Guardar {{PLURAL:$1|ina modificaziun stizzada|$1 modificaziuns stizzadas}}',
	'views' => 'Questa pagina',
	'viewcount' => 'Questa pagina è vegnida contemplada {{PLURAL:$1|ina giada|$1 giadas}}.',
	'view-pool-error' => 'Stgisa, ils servers èn actualmain surchargiads.
Memia blers utilisaders emprovan da chargiar questa pagina.
Spetga per plaschair in mument avant che ti eprovas da puspè contemplar questa pagina.

$1',
	'versionrequired' => 'Versiun $1 da MediaWiki è necessaria',
	'versionrequiredtext' => 'Ti dovras versiun $1 da MediaWiki per duvrar questa pagina. Guarda [[Special:Version| qua!]]',
	'viewsourceold' => 'mussar il code da funtauna',
	'viewsourcelink' => 'mussar il code da funtauna',
	'viewdeleted' => 'Mussa $1?',
	'viewsource' => 'Mussar il code da fontauna',
	'viewsourcetext' => 'Ti pos guardar e copiar il code-fundamental da questa pagina:',
	'virus-badscanner' => "Configuraziun fauss: antivirus nunenconuschent: ''$1''",
	'virus-scanfailed' => 'Scan betg reussì (code $1)',
	'virus-unknownscanner' => 'antivirus nunenconuschent:',
	'viewpagelogs' => 'Guardar ils logs da questa pagina',
	'viewprevnext' => 'Mussar ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => "Questa datoteca n'è betg passà cun success la verificaziun da datotecas.",
	'viewdeletedpage' => 'Mussar las paginas stizzadas',
	'version' => 'Versiun',
	'version-extensions' => 'Extensiuns installadas',
	'version-specialpages' => 'Paginas spezialas',
	'version-parserhooks' => 'Hooks dal parser',
	'version-variables' => 'Variablas',
	'version-antispam' => 'Prevenziun da spam',
	'version-skins' => 'Skins',
	'version-other' => 'Auter',
	'version-mediahandlers' => 'Manipulaturs da meds',
	'version-hooks' => 'Hooks',
	'version-extension-functions' => 'Funcziuns dad extensiuns',
	'version-parser-extensiontags' => 'Tags che extendan il parser',
	'version-parser-function-hooks' => 'Hooks per funcziuns dal parser',
	'version-hook-name' => 'Num dal hook',
	'version-hook-subscribedby' => 'Abonnà da',
	'version-version' => '(Versiun $1)',
	'version-license' => 'Licenza',
	'version-poweredby-credits' => "Questa wiki utilisescha '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'auters',
	'version-license-info' => "MediaWiki è software liba; ti la pos redistribuir e/u la modifitgar tenor ils terms da la GNU General Public License sco ch'ella vegn publitgada da la Free Software Foundation; ti pos utilisar la versiun 2 da la licenza u (sche ti vul) mintga versiun che succeda.

MediaWiki vegn distribuì en la speranza che questa software saja utila, dentant SENZA MINTGA GARANZIA; era senza garanzia implizita da NEGOZIABILITAD u ADDATAZIUN PER IN INTENT SPECIAL. Guarda la GNU General Public License per ulteriurs detagls.

Ti duessas avair retschavì [{{SERVER}}{{SCRIPTPATH}}/COPYING ina copia da la GNU General Public License] cun quest program; sche na betg, scriva a la Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA u [//www.gnu.org/licenses/old-licenses/gpl-2.0.html la legia online].",
	'version-software' => 'Software installada',
	'version-software-product' => 'Product',
	'version-software-version' => 'Versiun',
);

$messages['rmy'] = array(
	'viewcount' => 'Kadaya patrin dikhlilyas {{PLURAL:$1|one time|$1var}}.',
	'viewsource' => 'Dikh i sursa',
	'viewprevnext' => 'Dikh ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'Versiya',
);

$messages['ro'] = array(
	'variants' => 'Variante',
	'view' => 'Lectură',
	'viewdeleted_short' => 'Vedeți {{PLURAL:$1|o modificare ștearsă|$1 (de) modificări șterse}}',
	'views' => 'Vizualizări',
	'viewcount' => 'Pagina a fost vizitată {{PLURAL:$1|o dată|de $1 ori|de $1 de ori}}.',
	'view-pool-error' => 'Ne pare rău, dar serverele sunt supraîncărcare în acest moment.
Prea mulți utilizatori încearcă să vizualizeze această pagină.
Vă rugăm să așteptați un moment înainte de a reîncerca accesarea paginii.

$1',
	'versionrequired' => 'Este necesară versiunea $1 MediaWiki',
	'versionrequiredtext' => 'Versiunea $1 MediaWiki este necesară pentru a folosi această pagină. Vezi [[Special:Version|versiunea actuală]].',
	'viewsourceold' => 'vizualizați sursa',
	'viewsourcelink' => 'sursă pagină',
	'viewdeleted' => 'Vizualizați $1?',
	'viewsource' => 'Sursă pagină',
	'viewsource-title' => 'Vizualizare sursă pentru $1',
	'viewsourcetext' => 'Se poate vizualiza și copia conținutul acestei pagini:',
	'viewyourtext' => "Se poate vizualiza și copia conținutul '''modificărilor dumneavoastră''' efectuate asupra acestei pagini:",
	'virus-badscanner' => "Configurație greșită: scaner de virus necunoscut: ''$1''",
	'virus-scanfailed' => 'scanare eșuată (cod $1)',
	'virus-unknownscanner' => 'antivirus necunoscut:',
	'viewpagelogs' => 'Vezi jurnalele pentru această pagină',
	'viewprevnext' => 'Vezi ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Fișierul nu a trecut testele.',
	'viewdeletedpage' => 'Vezi paginile șterse',
	'version' => 'Versiune',
	'version-extensions' => 'Extensii instalate',
	'version-specialpages' => 'Pagini speciale',
	'version-parserhooks' => 'Hook-uri parser',
	'version-variables' => 'Variabile',
	'version-antispam' => 'Prevenirea spamului',
	'version-skins' => 'Aspect',
	'version-other' => 'Altele',
	'version-mediahandlers' => 'Suport media',
	'version-hooks' => 'Hook-uri',
	'version-extension-functions' => 'Funcțiile extensiilor',
	'version-parser-extensiontags' => 'Taguri extensie parser',
	'version-parser-function-hooks' => 'Hook-uri funcții parser',
	'version-hook-name' => 'Nume hook',
	'version-hook-subscribedby' => 'Subscris de',
	'version-version' => '(Versiune $1)',
	'version-license' => 'Licență',
	'version-poweredby-credits' => "Acest wiki este dezvoltat de '''[//www.mediawiki.org/ MediaWiki]''', drepturi de autor © 2001-$1 $2.",
	'version-poweredby-others' => 'alții',
	'version-license-info' => 'MediaWiki este un software liber pe care îl puteți redistribui și/sau modifica sub termenii Licenței Publice Generale GNU publicată de Free Software Foundation – fie a doua versiune a acesteia, fie, la alegerea dumneavoastră, orice altă versiune ulterioară.

MediaWiki este distribuit în speranța că va fi folositor, dar FĂRĂ VREO GARANȚIE, nici măcar cea implicită de COMERCIALIZARE sau de ADAPTARE PENTRU UN UN SCOP ANUME. Vedeți Licența Publică Generală GNU pentru mai multe detalii.

În cazul în care nu ați primit [{{SERVER}}{{SCRIPTPATH}}/COPYING o copie a  Licenței Publice Generale GNU] împreună cu acest program, scrieți la Free Software Foundation, Inc, 51, Strada Franklin, etajul cinci, Boston, MA 02110-1301, Statele Unite ale Americii sau [//www.gnu.org/licenses/old-licenses/gpl-2.0.html citiți-o online].',
	'version-software' => 'Software instalat',
	'version-software-product' => 'Produs',
	'version-software-version' => 'Versiune',
);

$messages['roa-rup'] = array(
	'viewsource' => 'Videts-u fãntãnã',
);

$messages['roa-tara'] = array(
	'variants' => 'Variande',
	'view' => 'Vide',
	'viewdeleted_short' => "Vide {{PLURAL:$1|'nu cangiamende scangellate|$1 cangiaminde scangellate}}",
	'views' => 'Visite',
	'viewcount' => "Sta pàggene ha state viste {{PLURAL:$1|'na vote|$1 vote}}.",
	'view-pool-error' => "Ne dispiace, le server stonne sovraccarecate jndr'à stu mumende.
Troppe utinde stonne a provene a vedè sta pàgene.
Pe piacere aspitte 'nu picche e pò pruève 'n'otra vote a trasè jndr'à sta pàgene.

$1",
	'versionrequired' => "Jè richieste 'a versione $1 de MediaUicchi",
	'versionrequiredtext' => "Ha ausà 'a versione $1 de MediaUicchi pe ausà sta pàgene.
Vide [[Special:Version|Versione d'a pàgene]].",
	'viewsourceold' => 'vide sorgende',
	'viewsourcelink' => "vide 'u sorgende",
	'viewdeleted' => 'Vue ccu vide $1?',
	'viewsource' => "Vide 'u sorgende",
	'viewsource-title' => "Vide 'a sorgende pe $1",
	'viewsourcetext' => "Tu puè vedè e cupià 'a sorgente de sta pàgene:",
	'viewyourtext' => "Tu puè vedè e copià 'a sorgende de '''le cangiaminde tune''' a sta pàgene:",
	'virus-badscanner' => "Configurazione ca fece schife: Virus scanner scanusciute: ''$1''",
	'virus-scanfailed' => 'condrolle fallite (codece $1)',
	'virus-unknownscanner' => 'antivirus scanusciute:',
	'viewpagelogs' => "Vide l'archivie pe sta pàgene",
	'viewprevnext' => 'Vide ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => "Stu file non g'à passate 'a verifeche de le file.",
	'viewdeletedpage' => 'Vide le pàggene scangellete',
	'video-dims' => '$1, $2 × $3',
	'variantname-zh-hans' => 'hans',
	'variantname-zh-hant' => 'hant',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
	'variantname-zh-sg' => 'sg',
	'variantname-zh-my' => 'my',
	'variantname-zh' => 'zh',
	'variantname-gan-hans' => 'hans',
	'variantname-gan-hant' => 'hant',
	'variantname-gan' => 'gan',
	'variantname-sr-ec' => 'sr-ec',
	'variantname-sr-el' => 'sr-el',
	'variantname-sr' => 'sr',
	'variantname-kk-kz' => 'kk-kz',
	'variantname-kk-tr' => 'kk-tr',
	'variantname-kk-cn' => 'kk-cn',
	'variantname-kk-cyrl' => 'kk-cyrl',
	'variantname-kk-latn' => 'kk-latn',
	'variantname-kk-arab' => 'kk-arab',
	'variantname-kk' => 'kk',
	'variantname-ku-arab' => 'ku-Arab',
	'variantname-ku-latn' => 'ku-Latn',
	'variantname-ku' => 'ku',
	'variantname-tg-cyrl' => 'tg-Cyrl',
	'variantname-tg-latn' => 'tg-Latn',
	'variantname-tg' => 'tg',
	'variantname-ike-cans' => 'ike-Cans',
	'variantname-ike-latn' => 'ike-Latn',
	'variantname-iu' => 'iu',
	'variantname-shi-tfng' => 'shi-Tfng',
	'variantname-shi-latn' => 'shi-Latn',
	'variantname-shi' => 'shi',
	'version' => 'Versione',
	'version-extensions' => 'Estenziune installete',
	'version-specialpages' => 'Pàggene speciele',
	'version-parserhooks' => 'Hook analizzature',
	'version-variables' => 'Variabbele',
	'version-antispam' => "Previzione d'u spam",
	'version-skins' => 'Skin',
	'version-api' => 'API',
	'version-other' => 'Otre',
	'version-mediahandlers' => 'Gestore de le Media',
	'version-hooks' => 'Hook',
	'version-extension-functions' => 'Funziune estese',
	'version-parser-extensiontags' => "Tag pe l'estenziune de l'analizzatore",
	'version-parser-function-hooks' => "Funziune hook de l'analizzatore",
	'version-hook-name' => "Nome de l'hook",
	'version-hook-subscribedby' => 'Sottoscritte da',
	'version-version' => '(Versione $1)',
	'version-svn-revision' => '(r$2)',
	'version-license' => 'Licenze',
	'version-poweredby-credits' => "Sta Uicchi jè fatte da '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'otre',
	'version-license-info' => "MediaUicchi jè 'nu softuare libbere, tu 'u puè redestribbuì  e/o cangiarle sotte le termine d'a GNU (Licenze Pubbleche Generale) cumme pubblecate da 'a Free Software Foundation; endrambe le versiune 2 d'a Licenze, o (a scelta toje) 'le versiune cchiù nnove.

Mediauicchi jè destribbuite cu 'a speranze ca jè utile, ma SENZE NISCIUNA GARANZIE; senze nemmanghe 'a garanzie imblicite de COMMERCIABBELETÀ o IDONIETÀ PE 'NU SCOPE PARTICOLARE. Vatte a vide 'a GNU (Licenze Pubbleche Generale) pe cchiù 'mbormaziune.

Avisse avè ricevute [{{SERVER}}{{SCRIPTPATH}}/COPYING 'na copie d'a GNU (Licenze Pubbleche Generale)] 'nzieme a stu programme, ce none, scrive a 'a Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor , Boston, MA 02110-1301, USA o [//www.gnu.org/licenses/old-licenses/gpl-2.0.html liggele sus a Indernette].",
	'version-software' => 'Softuer installete',
	'version-software-product' => 'Prodotte',
	'version-software-version' => 'Versione',
);

$messages['ru'] = array(
	'variants' => 'Варианты',
	'view' => 'Просмотр',
	'viewdeleted_short' => 'Просмотр $1 {{PLURAL:$1|удалённой правки|удалённых правок|удалённых правок}}',
	'views' => 'Просмотры',
	'viewcount' => 'К этой странице обращались $1 {{PLURAL:$1|раз|раза|раз}}.',
	'view-pool-error' => 'Извините, сейчас серверы перегружены.
Поступило слишком много запросов на просмотр этой страницы.
Пожалуйста, подождите и повторите попытку обращения к странице позже.

$1',
	'versionrequired' => 'Требуется MediaWiki версии $1',
	'versionrequiredtext' => 'Для работы с этой страницей требуется MediaWiki версии $1. См. [[Special:Version|информацию об программном обеспечении]].',
	'viewsourceold' => 'просмотреть исходный код',
	'viewsourcelink' => 'просмотреть исходный код',
	'viewdeleted' => 'Просмотреть $1?',
	'viewsource' => 'Просмотр',
	'viewsource-title' => 'Просмотр исходного текста страницы $1',
	'viewsourcetext' => 'Вы можете просмотреть и скопировать исходный текст этой страницы:',
	'viewyourtext' => "Вы можете просмотреть и скопировать исходный текст '''ваших правок''' на этой странице:",
	'virus-badscanner' => "Ошибка настройки. Неизвестный сканер вирусов: ''$1''",
	'virus-scanfailed' => 'ошибка сканирования (код $1)',
	'virus-unknownscanner' => 'неизвестный антивирус:',
	'viewpagelogs' => 'Показать журналы для этой страницы',
	'viewprevnext' => 'Просмотреть ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Этот файл не прошёл процедуру проверки.',
	'viewdeletedpage' => 'Просмотр удалённых страниц',
	'video-dims' => '$1, $2 × $3',
	'version' => 'Версия MediaWiki',
	'version-extensions' => 'Установленные расширения',
	'version-specialpages' => 'Служебные страницы',
	'version-parserhooks' => 'Перехватчики синтаксического анализатора',
	'version-variables' => 'Переменные',
	'version-antispam' => 'Антиспам',
	'version-skins' => 'Темы оформления',
	'version-other' => 'Иное',
	'version-mediahandlers' => 'Обработчики медиа',
	'version-hooks' => 'Перехватчики',
	'version-extension-functions' => 'Функции расширений',
	'version-parser-extensiontags' => 'Теги расширений синтаксического анализатора',
	'version-parser-function-hooks' => 'Перехватчики функций синтаксического анализатора',
	'version-hook-name' => 'Имя перехватчика',
	'version-hook-subscribedby' => 'Подписан на',
	'version-version' => '(Версия $1)',
	'version-license' => 'Лицензия',
	'version-poweredby-credits' => "Эта вики работает на движке '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'другие',
	'version-license-info' => 'MediaWiki является свободным программным обеспечением, которое вы можете распространять и/или изменять в соответствии с условиями лицензии GNU General Public License, опубликованной фондом свободного программного обеспечения; второй версии, либо любой более поздней версии.

MediaWiki распространяется в надежде, что она будет полезной, но БЕЗ КАКИХ-ЛИБО ГАРАНТИЙ, даже без подразумеваемых гарантий КОММЕРЧЕСКОЙ ЦЕННОСТИ или ПРИГОДНОСТИ ДЛЯ ОПРЕДЕЛЕННОЙ ЦЕЛИ. См. лицензию GNU General Public License для более подробной информации.

Вы должны были получить [{{SERVER}}{{SCRIPTPATH}}/COPYING копию GNU General Public License] вместе с этой программой, если нет, то напишите Free Software Foundation, Inc., по адресу: 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA или [//www.gnu.org/licenses/old-licenses/gpl-2.0.html прочтите её онлайн].',
	'version-software' => 'Установленное программное обеспечение',
	'version-software-product' => 'Продукт',
	'version-software-version' => 'Версия',
);

$messages['rue'] = array(
	'variants' => 'Варіанты',
	'view' => 'Видїти',
	'viewdeleted_short' => 'Видїти {{PLURAL:$1|змазанов едітаціёв|$1 змазаны едітації|$1 змазаных едітацій}}',
	'views' => 'Перегляды',
	'viewcount' => 'Сторінка была зображена  {{PLURAL:$1|раз|$1разы|$1раз}}.',
	'view-pool-error' => 'Перебачте, серверы суть теперь перетяжены.
Тоту сторінку сі теперь перезерать много хоснователїв.
Просиме Вас, почекайте і спробуйте доступность пізнїше.

$1',
	'versionrequired' => 'Потрібна MediaWiki верзії $1',
	'versionrequiredtext' => 'Про роботу з тов сторінков потрібна MediaWiki верзії $1. Відь [[Special:Version|сторінку верзії]].',
	'viewsourceold' => 'видїти код',
	'viewsourcelink' => 'видїти код',
	'viewdeleted' => 'Зобразити $1?',
	'viewsource' => 'Видїти код',
	'viewsource-title' => 'Відїти жрідло сторінкы $1',
	'viewsourcetext' => 'Можете видїти і копіровати код той сторінкы:',
	'viewyourtext' => "Можете собі посмотрити і скопіровати жрідловый текст '''вашых змін''' той сторінкы:",
	'virus-badscanner' => "Зла конфіґурація: незнамый антивіровый проґрам: ''$1''",
	'virus-scanfailed' => 'скенованя ся не подарило (код $1)',
	'virus-unknownscanner' => 'незнамый антівірус',
	'viewpagelogs' => 'Вказати лоґы про тоту сторінку',
	'viewprevnext' => 'Перегляднути ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Тот файл не перешов овіринём файлів.',
	'viewdeletedpage' => 'Зобразити змазаны сторінкы',
	'version' => 'Верзія',
	'version-extensions' => 'Наіншталованы росшырїня',
	'version-specialpages' => 'Шпеціалны сторінкы',
	'version-parserhooks' => 'Припойны пункты парсера',
	'version-variables' => 'Перемінны',
	'version-antispam' => 'Охрана перед спамом',
	'version-skins' => 'Взгляды',
	'version-other' => 'Інше',
	'version-mediahandlers' => 'Обслуга медії',
	'version-hooks' => 'Припойны пункты',
	'version-extension-functions' => 'Функції розшыриня',
	'version-parser-extensiontags' => 'Приданы сінтактічны значкы',
	'version-parser-function-hooks' => 'Функціа парсера',
	'version-hook-name' => 'Назва припойного пункту',
	'version-hook-subscribedby' => 'Підписаный на',
	'version-version' => '(Верзія $1)',
	'version-license' => 'Ліценція',
	'version-poweredby-credits' => "Тота вікі біжыть на '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'іншы',
	'version-license-info' => 'MediaWiki є слободный софтвер; можете го шырити або управляти подля условій GNU General Public License, выдаваной Free Software Foundation; будь верзія 2 той ліценції або (подля вашого уважіня) будьяка пізнїша верзія.

MediaWiki є дістрібуована в надїї, же буде хосновна, але БЕЗ БУДЬЯКОЙ ЗАРУКЫ; не давають ся ани зарукы ПРОДАЙНОСТИ або ВАЛУШНОСТИ ПРО СТАНОВЛЕНЫЙ ЦІЛЬ. Детайлы ся дочітате в текстї  GNU General Public License.

[{{SERVER}}{{SCRIPTPATH}}/COPYING Kopii GNU General Public License] сьте мали обтримати вєдно з тым проґрамом, кідь нїт, напиште на  Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA або [//www.gnu.org/licenses/old-licenses/gpl-2.0.html сі єй прочітайте онлайн].',
	'version-software' => 'Іншталованый софтвер',
	'version-software-product' => 'Продукт',
	'version-software-version' => 'Верзія',
);

$messages['rup'] = array(
	'viewsource' => 'Videts-u fãntãnã',
);

$messages['ruq'] = array(
	'viewsource' => 'Videts-u fãntãnã',
);

$messages['ruq-cyrl'] = array(
	'views' => 'Ви',
	'viewsource' => 'баганаере',
	'viewprevnext' => 'Ву ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['ruq-latn'] = array(
	'views' => 'Vi',
	'viewsource' => 'Baganaere',
	'viewprevnext' => 'Vu ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['sa'] = array(
	'variants' => 'भिन्नरूपाणि',
	'view' => 'दृश्यताम्',
	'viewdeleted_short' => 'दर्श्यताम् {{PLURAL:$1|एको विलुप्तं सम्पादनम्|$1 विलुप्तानि सम्पादनानि}}',
	'views' => 'दृश्यानि',
	'viewcount' => 'एतत्पृष्ठं {{PLURAL:$1|एक वारं|$1 वारं}} दृष्टम् अस्ति',
	'view-pool-error' => 'क्षम्यताम्, परिवेषणयन्त्राणि अतिभारितानि अस्मिन् समये।
बहवः प्रयोक्तारः एतत् पृष्ठं द्रष्टुं प्रयतमानाः सन्ति।
कृपया किंचित्कालं प्रतीक्षताम् भवान्, तदा क्रियताम् प्रयासः।
$1',
	'versionrequired' => 'मीडीयाविके: $1 संस्करणम् आवश्यकम् ।',
	'versionrequiredtext' => 'एतत्पृष्ठं प्रयोक्तुं मीडियाविकि इत्येतस्य $1तमा आवृत्तिः आवश्यकी। पश्यतु [[Special:Version|आवृत्ति-सूचिका]]',
	'viewsourceold' => 'स्रोतः दृश्यताम्',
	'viewsourcelink' => 'स्रोतः दृश्यताम्',
	'viewdeleted' => '$1 दृश्यताम् ?',
	'viewsource' => 'स्रोतः दृश्यताम्',
	'viewsource-title' => '$1 इत्येतस्य स्रोतः दृश्यताम् ।',
	'viewsourcetext' => 'भवान् एतस्य पृष्ठस्य स्रोतः द्रष्टुं तस्य प्रतिलिपिं कर्तुम् अर्हति।',
	'viewyourtext' => "भवान् अस्य पृष्ठस्य स्रोतसि '''भवतः सम्पादनानि''' द्रष्टुं प्रतिलिपिं कर्तुं च अर्हति ।",
	'virus-badscanner' => "असुष्ठु अभिविन्यासः : अज्ञातं विषाणु-निरीक्षित्रम्: ''$1''",
	'virus-scanfailed' => 'परीक्षणं विफलीभूतम् (कूटम् $1)',
	'virus-unknownscanner' => 'अज्ञातं विषाणुप्रतिकारकम्:',
	'viewpagelogs' => 'अस्य पृष्ठस्य लॉंग् इत्येतद् दर्शयतु',
	'viewprevnext' => 'दर्श्यताम् ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'आवृत्तिः',
	'version-skins' => 'छादन',
	'version-other' => 'अन्यत्',
	'version-poweredby-others' => 'अन्य',
	'version-software-product' => 'उत्पाद',
	'version-software-version' => 'आवृत्ति',
);

$messages['sah'] = array(
	'variants' => 'Барыллар',
	'view' => 'Көрүү',
	'viewdeleted_short' => '{{PLURAL:$1|Соҕотох сотторуллубут көннөрүүнү|$1 сотторуллубут көннөрүүнү}} көрүү',
	'views' => 'Көрүүлэр',
	'viewcount' => 'Бу сирэй {{PLURAL:$1|биирдэ|$1 төгүл}} көрүллүбүт.',
	'view-pool-error' => 'Балаама, билигин бары сиэрбэрдэр туолан тураллар.
Бу сирэйи наһаа элбэх киһи көрүөн баҕарбыт.
Бука диэн, кэтэһэ түһэн баран өссө боруобалаар.

$1',
	'versionrequired' => 'MediaWiki $1 -с биэрсийэтэ наада',
	'versionrequiredtext' => 'Бу сирэйи туттарга MediaWiki $1 -с барыла наада. [[Special:Version|Барыллар тустарынан сирэйи]] көр.',
	'viewsourceold' => 'исходнигын көрүү',
	'viewsourcelink' => 'исходнигын көрүү',
	'viewdeleted' => '$1 көрдөрөбүн?',
	'viewsource' => 'Көрүү',
	'viewsource-title' => 'Бу сирэй $1 исходнигын көрүү',
	'viewsourcetext' => 'Эн бу сирэй төрдүн көрүөххүн уонна төгүллүөххүн сөп:',
	'viewyourtext' => "'''Бэйэҥ көннөрүүлэриҥ''' исходнигын бу сирэйгэ көрүөххүн уонна хатылаан ылыаххын сөп:",
	'virus-badscanner' => "Сатаммата. Вирус сканера биллибэтэ: ''$1''",
	'virus-scanfailed' => 'скан сыыһата (куода $1)',
	'virus-unknownscanner' => 'биллибэт антивирус:',
	'viewpagelogs' => 'Бу сирэй историятын көрдөр',
	'viewprevnext' => 'Көр ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Бу билэ тургутуллубатах.',
	'viewdeletedpage' => 'Сотуллубут сирэйдэри көрүү',
	'version' => 'MediaWiki барыла (биэрсийэтэ)',
	'version-extensions' => 'Туруоруллубут расширениялар',
	'version-specialpages' => 'Аналлаах сирэйдэр',
	'version-parserhooks' => 'синтаксическай анализатор перехватчиктара',
	'version-variables' => 'Уларыйар дааннайдар (переменнайдар)',
	'version-antispam' => 'Спаамтан көмүскэнии',
	'version-skins' => 'Тас көстүү барыллара',
	'version-other' => 'Атын',
	'version-mediahandlers' => 'Медиа уларытааччылар',
	'version-hooks' => 'Перехватчиктар',
	'version-extension-functions' => 'Расширениялар функциялара',
	'version-parser-extensiontags' => 'Синтаксииһы анаалыстыыр тэрил расширениятын тиэктэрэ',
	'version-parser-function-hooks' => 'Синтаксииһы анаалыстыыр тэрил функциятын перехватчиктара',
	'version-hook-name' => 'Перехватчик аата',
	'version-hook-subscribedby' => 'Суруттарыыта:',
	'version-version' => '(Торум $1)',
	'version-license' => 'Лиссиэнзийэ',
	'version-poweredby-credits' => "Бу биики бу движокка олоҕурар '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'атыттар',
	'version-license-info' => 'MediaWiki көҥүл тарҕанар бырагырааммаларга киирэр, кинини көмпүүтэр аһаҕас бырагырааммаларын пуондатын GNU General Public License усулуобуйатынан көҥүл тарҕатаргыт уонна/эбэтэр уларытаргыт көҥүллэнэр; иккис эбэтэр онтон хойукку ханнык баҕарар барылыттан саҕалаан.

MediaWiki туһалаах буоллун диэн тарҕатыллар, ол эрээри АТЫЫЛАНАР СЫАННАҺА эбэтэр ХАННЫК ЭРЭ ЧОПЧУ СОРУККА СӨП ТҮБЭҺИИТЭ бигэргэтиллибэт (гарантията суох). Сиһилии GNU General Public License усулуобуйатын көрүҥ.

[{{SERVER}}{{SCRIPTPATH}}/COPYING  GNU General Public License копиятын] бу бырагыраамманы кытта ылыахтаах этигит, ол сатамматах буоллаҕына Free Software Foundation, Inc. тэрилтэҕэ сурукта суруйуҥ, бу аадырыска: 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA эбэтэр [//www.gnu.org/licenses/old-licenses/gpl-2.0.html саайка киирэн ааҕыҥ].',
	'version-software' => 'Туруоруллубут бырагырааммалар',
	'version-software-product' => 'Бородуукта',
	'version-software-version' => 'Барыл (торум)',
);

$messages['sc'] = array(
	'variants' => 'Variantes',
	'views' => 'Bisuras',
	'viewcount' => 'Custu artìculu est stadu lìgiu {{PLURAL:$1|borta|$1 bortas}}.',
	'viewsourceold' => 'càstia mitza',
	'viewsourcelink' => 'càstia mitza',
	'viewdeleted' => 'Bisi $1?',
	'viewsource' => 'Càstia mitza',
	'virus-scanfailed' => 'scansione faddida (còdixe $1)',
	'virus-unknownscanner' => 'antivirus disconnotu:',
	'viewpagelogs' => 'Càstia sos registros de custa pàgina',
	'viewprevnext' => 'Càstia ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Càstia pàginas fuliadas',
	'video-dims' => '$1, $2×$3',
	'version' => 'Versione',
	'version-specialpages' => 'Pàginas ispetziales',
	'version-other' => 'Àteru',
	'version-version' => '(Versione $1)',
	'version-license' => 'Licèntzia',
	'version-software-version' => 'Versione',
);

$messages['scn'] = array(
	'variants' => 'Varianti',
	'view' => 'Talìa',
	'views' => 'Vìsiti',
	'viewcount' => 'Sta pàggina hà statu liggiuta {{PLURAL:$1|una vota|$1 voti}}.',
	'view-pool-error' => "Ci spiaci, li server ni stu mumentu sunu troppu carichi. Troppi utenti stannu circannu di taliari sta pàggina. Aspetta n'anticchia prima di pruvari a ritaliari sta pàggina.

$1",
	'versionrequired' => 'È nicissaria la virsioni $1 dû software MediaWiki',
	'versionrequiredtext' => "P'usari sta pàggina ci voli la virsioni $1 dû software MediaWiki. Talìa [[Special:Version|sta pàggina]]",
	'viewsourceold' => 'talìa la fonti',
	'viewsourcelink' => 'Talìa la funti',
	'viewdeleted' => 'Vidi $1?',
	'viewsource' => 'Talìa la fonti',
	'viewsource-title' => 'Visualizza la surgenti di $1',
	'viewsourcetext' => 'È pussìbbili visualizzari e cupiari lu còdici surgenti di sta pàggina:',
	'virus-badscanner' => "Sbagghiu di cunfigurazzioni: antivirus scanusciutu: ''$1''",
	'virus-scanfailed' => 'scanzioni nun arrinisciuta (còdici $1)',
	'virus-unknownscanner' => 'antivirus scanusciutu:',
	'viewpagelogs' => 'Vidi li log rilativi a sta pàggina',
	'viewprevnext' => 'Talìa ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Talìa li pàggini cancillati',
	'version' => 'virsioni',
	'version-extensions' => 'Estenzioni nstallati',
	'version-specialpages' => 'Pàggini spiciali',
	'version-parserhooks' => 'Hook dû parser',
	'version-variables' => 'Variabili',
	'version-other' => 'Àutru',
	'version-mediahandlers' => 'Gistori di cuntinuti multimediali',
	'version-hooks' => 'Hook',
	'version-extension-functions' => 'Funzioni ntrudotti di estenzioni',
	'version-parser-extensiontags' => 'Tag canusciuti dô parser ntrudotti di estenzioni',
	'version-parser-function-hooks' => 'Hook pi funzioni dû parser',
	'version-hook-name' => "Nomu di l'hook",
	'version-hook-subscribedby' => 'Suttascrizzioni',
	'version-version' => '(Virsioni $1)',
	'version-license' => 'Licenza',
	'version-software' => 'Software nstallatu',
	'version-software-product' => 'Prodottu',
	'version-software-version' => 'Virsioni',
);

$messages['sco'] = array(
	'variants' => 'Variants',
	'views' => 'Views',
	'viewcount' => 'This page haes been accesst $1 {{PLURAL:$1|once|$1 times}}.',
	'versionrequired' => 'Version $1 of MediaWiki requirit',
	'versionrequiredtext' => 'Version $1 o MediaWiki is requirit tae uise this page. Tak a keek at the [[Special:Version|version page]].',
	'viewsourceold' => 'ken soorce',
	'viewsourcelink' => 'Scance ower the source',
	'viewdeleted' => 'View $1?',
	'viewsource' => 'View soorce',
	'viewsourcetext' => 'Ye can leuk at an copy the soorce o this page:',
	'viewpagelogs' => 'Leuk at logs for this page',
	'viewprevnext' => 'View ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'View delete pages',
);

$messages['sd'] = array(
	'views' => 'ڏيٺون',
	'viewcount' => 'هيءُ صفحو {{PLURAL:$1|دفعو|$1 دفعا}} ڏسجي چڪو آهي.',
	'viewsourceold' => 'ڪوڊ ڏسو',
	'viewsourcelink' => 'ڪوڊ ڏسو',
	'viewdeleted' => '$1 ڏسندا؟',
	'viewsource' => 'ڪوڊ ڏسو',
	'viewsourcetext' => 'توهان هن صفحي جو ڪوڊ ڏسي ۽ نقل ڪري سگھو ٿا:',
	'viewpagelogs' => 'هن صفحي جا لاگ ڏسو',
	'viewprevnext' => 'ڏسو ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'ورزن',
);

$messages['sdc'] = array(
	'views' => 'Vìsiti',
	'viewcount' => 'Chistha pàgina è isthadda liggidda {{PLURAL:$1|una voltha|$1 volthi}}.',
	'versionrequired' => 'Versioni $1 di MediaWiki dumandadda',
	'versionrequiredtext' => "Pa usà chistha pàgina è nezzessàriu dipunì di la versioni $1 di lu software MediaWiki. Vedi [[Special:Version|l'appósidda pàgina]].",
	'viewsourceold' => "visuarizza l'orìgini",
	'viewsourcelink' => "visuarizza l'orìgini",
	'viewdeleted' => 'Vedi $1?',
	'viewsource' => 'Vèdi còdizi',
	'viewsourcetext' => 'È pussìbiri visuarizzà e cupià lu còdizi di chistha pàgina:',
	'viewpagelogs' => 'Visuarizza li rigisthri reratibi a chistha pàgina.',
	'viewprevnext' => 'Vèdi ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Musthra li pàgini canzilladdi',
	'version' => 'Versioni',
	'version-other' => 'Althru',
	'version-software-version' => 'Versioni',
);

$messages['se'] = array(
	'views' => 'Čájáhusat',
	'viewcount' => 'Dát siidu lea čájehuvvon {{PLURAL:$1|oktii|$1 geardde}}.',
	'versionrequired' => 'MediaWikis gáibiduvvo unnimustá veršuvdna $1',
	'versionrequiredtext' => 'MediaWikis gáibiduvvo unnimustá veršuvdna $1 dán siiddu geavaheapmái. Geahča [[Special:Version|veršuvdna]]',
	'viewdeleted' => 'Čájet $1?',
	'viewsource' => 'Geahča gáldu',
	'viewsourcetext' => 'Sáhtát geahčat ja kopieret dán siiddu gáldokoda:',
	'viewpagelogs' => 'Čájet dán siiddu loggaid',
	'viewprevnext' => 'Čájet [$3] oktanaga.

$1 {{int:pipe-separator}} $2',
	'viewdeletedpage' => 'Sihkojuvvon siidduid bláđen',
	'version' => 'Veršuvdna',
);

$messages['sei'] = array(
	'views' => 'Cohuatlöxám',
	'viewcount' => '{{PLURAL:$1|1 ctam|$1 ctám}} coccebj cohuatlöx jan páhina.',
	'versionrequired' => 'Vercion $1 MediaWiki pal',
	'versionrequiredtext' => 'Vercion $1 MediaWiki pal húpáhinal. cho [[Special:Version]].',
	'viewdeleted' => 'Cohuatlöx $1?',
	'viewsource' => 'Cohuatlöx sourcenam',
	'viewsourcetext' => 'Mecohuatlöx ö copynom sourcenam zode jan páhina:',
	'viewpagelogs' => 'Cohuatlöx logámde jan páhina',
	'viewprevnext' => 'Cohuatlöx ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Vercion',
);

$messages['sg'] = array(
	'variants' => 'Âmbênî marä nî',
	'view' => 'Tändä',
	'viewdeleted_short' => 'Bâa {{PLURAL:$1|sepsesû| âsepesû $1}} sô awoza nî awe sô.',
	'views' => 'Tändä',
);

$messages['sgs'] = array(
	'variants' => 'Variantā',
	'views' => 'Parveizėtė',
	'viewcount' => 'Tas poslapis bova atverts $1 {{PLURAL:$1|čiesa|čiesus|čiesu}}.',
	'viewsourceold' => 'veizietė šaltėni',
	'viewsourcelink' => 'veizietė kuoda',
	'viewdeleted' => 'Ruodītė $1?',
	'viewsource' => 'Veizėtė kuoda',
	'viewsourcetext' => 'Tomsta galėt veizietė ėr kopėjoutė poslapė kuoda:',
	'viewpagelogs' => 'Ruodītė šėtuo poslapė specēliōsios vaiksmos',
	'viewprevnext' => 'Veizėtė ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Ruodītė ėštrintos poslapios',
	'version' => 'Versėjė',
	'version-license' => 'Licenzėjė',
);

$messages['sh'] = array(
	'variants' => 'Varijante',
	'view' => 'Vidi',
	'viewdeleted_short' => 'Pogledaj {{PLURAL:$1|jednu obrisanu izmjenu|$1 obrisane izmjene|$1 obrisanih izmjena}}',
	'views' => 'Pregledi',
	'viewcount' => 'Ovoj stranici je pristupljeno {{PLURAL:$1|$1 put|$1 puta}}.',
	'view-pool-error' => 'Žao nam je, serveri su trenutno preopterećeni.
Previše korisnika pokušava da pregleda ovu stranicu.
Molimo pričekajte trenutak prije nego što ponovno pokušate pristupiti ovoj stranici.

$1',
	'versionrequired' => 'Potrebna je verzija $1 MediaWikija',
	'versionrequiredtext' => 'Potrebna je verzija $1 MediaWikija da bi se koristila ova stranica. Pogledaj [[Special:Version|verziju]].',
	'viewsourceold' => 'pogledaj izvor',
	'viewsourcelink' => 'pogledaj kod',
	'viewdeleted' => 'Pogledaj $1?',
	'viewsource' => 'Pogledaj kod',
	'viewsource-title' => 'Prikaz izvora stranice $1',
	'viewsourcetext' => 'Možete vidjeti i kopirati izvorni tekst ove stranice:',
	'viewyourtext' => "Možete da pogledate i kopirate izvor '''vaših izmjena''' na ovoj stranici:",
	'virus-badscanner' => "Loša konfiguracija: nepoznati anti-virus program: ''$1''",
	'virus-scanfailed' => 'skeniranje nije uspjelo (code $1)',
	'virus-unknownscanner' => 'nepoznati anti-virus program:',
	'viewpagelogs' => 'Pogledaj protokole ove stranice',
	'viewprevnext' => 'Pogledaj ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Ova datoteka nije prošla provjeru.',
	'viewdeletedpage' => 'Pregledaj izbrisane stranice',
	'version' => 'Verzija',
	'version-extensions' => 'Instalirana proširenja (ekstenzije)',
	'version-specialpages' => 'Posebne stranice',
	'version-parserhooks' => 'Kuke parsera',
	'version-variables' => 'Promjenjive',
	'version-antispam' => 'Sprečavanje spama',
	'version-skins' => 'Izgledi (skinovi)',
	'version-other' => 'Ostalo',
	'version-mediahandlers' => 'Upravljači medije',
	'version-hooks' => 'Kuke',
	'version-extension-functions' => 'Funkcije proširenja (ekstenzije)',
	'version-parser-extensiontags' => "Parser proširenja (''tagovi'')",
	'version-parser-function-hooks' => 'Kuke parserske funkcije',
	'version-hook-name' => 'Naziv kuke',
	'version-hook-subscribedby' => 'Pretplaćeno od',
	'version-version' => '(Verzija $1)',
	'version-license' => 'Licenca',
	'version-poweredby-credits' => "Ova wiki je zasnovana na '''[//www.mediawiki.org/ MediaWiki]''', autorska prava zadržana © 2001-$1 $2.",
	'version-poweredby-others' => 'ostali',
	'version-license-info' => 'Mediawiki je slobodni softver, možete ga redistribuirati i/ili mijenjati pod uslovima GNU opće javne licence kao što je objavljeno od strane Fondacije Slobodnog Softvera, bilo u verziji 2 licence, ili (po vašoj volji) nekoj od kasniji verzija.

Mediawiki se distriburia u nadi da će biti korisna, ali BEZ IKAKVIH GARANCIJA, čak i bez ikakvih posrednih garancija o KOMERCIJALNOSTI ili DOSTUPNOSTI ZA ODREĐENU SVRHU. Pogledajte GNU opću javnu licencu za više detalja.

Trebali biste dobiti [{{SERVER}}{{SCRIPTPATH}}/KOPIJU GNU opće javne licence] zajedno s ovim programom, ako niste, pišite Fondaciji Slobodnog Softvera na adresu  Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA ili je pročitajte [//www.gnu.org/licenses/old-licenses/gpl-2.0.html online].',
	'version-software' => 'Instalirani softver',
	'version-software-product' => 'Proizvod',
	'version-software-version' => 'Verzija',
);

$messages['shi'] = array(
	'variants' => 'lmotaghayirat',
	'views' => 'Ẓr.. (Mel)',
	'viewcount' => 'Tmmurzm tasna yad {{PLURAL:$1|yat twalt|$1 mnnawt twal}}.',
	'view-pool-error' => 'Surf, iqddacn žayn ɣilad. mnnaw midn yaḍnin ay siggiln tasna yad. Qqel imik fad addaɣ talst at tarmt at lkmt tasna yad

$1',
	'versionrequired' => 'Txxṣṣa $1 n MediaWiki',
	'versionrequiredtext' => 'Ixxṣṣa w-ayyaw $1 n MediaWiki bac at tskrert tasna yad.
Ẓr [[Special:Version|ayyaw tasna]].',
	'viewsourceold' => 'Mel aɣbalu',
	'viewsourcelink' => 'Mel aɣbalu',
	'viewdeleted' => 'Mel $1?',
	'viewsource' => 'Mel iɣbula',
	'viewsourcefor' => 'l $1',
	'virus-unknownscanner' => 'antivirus oritwsan',
	'viewpagelogs' => '↓ Ẓr timhlin lli ittuskarn ɣ tasna yad',
	'viewprevnext' => 'Mel ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'noskha',
	'version-specialpages' => 'Tisnatin timzlay',
	'version-parserhooks' => 'khatatif lmohallil',
	'version-variables' => 'lmotaghayirat',
	'version-other' => 'wayya',
	'version-mediahandlers' => 'motahakkimat lmedia',
	'version-hooks' => 'lkhtatif',
	'version-extension-functions' => 'lkhdaym n limtidad',
	'version-parser-extensiontags' => 'imarkiwn n limtidad n lmohalil',
	'version-parser-function-hooks' => 'lkhtatif ndala',
	'version-software-product' => 'lmntoj',
	'version-software-version' => 'noskha',
);

$messages['si'] = array(
	'variants' => 'ප්‍රභේද',
	'view' => 'දසුන',
	'viewdeleted_short' => 'මකා දමනු ලැබූ {{PLURAL:$1|එක් සංස්කරණයක්|සංස්කරණ $1  ක්}} බලන්න',
	'views' => 'දසුන්',
	'viewcount' => 'මෙම පිටුවට {{PLURAL:$1|එක් වරක්|$1 වරක්}} පිවිස ඇත.',
	'view-pool-error' => "සමාවන්න, ස'වරයන් මෙම අවස්ථාවෙහිදී අධිපූරණය වී ඇත.
පමණට වඩා පරිශීලක පිරිසක් මෙම පිටුව නැරඹීමට උත්සහ දරති.
මද වේලාවක් පමාවී නැවත උත්සාහ කරන්න.

$1",
	'versionrequired' => 'මාධ්‍යවිකි $1 අනුවාදය අවශ්‍ය වේ',
	'versionrequiredtext' => 'මෙම පිටුව භාවිතා කිරීමට, මාධ්‍යවිකි හි $1 අනුවාදය අවශ්‍ය වේ.
[[Special:Version|අනුවාද පිටුව]] බලන්න.',
	'viewsourceold' => 'මූලාශ්‍රය නරඹන්න',
	'viewsourcelink' => 'මූලාශ්‍රය නරඹන්න',
	'viewdeleted' => '$1 නැරඹීම අවශ්‍යයද?',
	'viewsource' => 'මූලාශ්‍රය නරඹන්න',
	'viewsource-title' => '$1 සඳහා මුලාශ්‍රය නරඹන්න',
	'viewsourcetext' => 'මෙම පිටුවෙහි මූලාශ්‍රය නැරඹීමට හා පිටපත් කිරීමට ඔබ හට හැකිය:',
	'viewyourtext' => "'''ඔබගේ සංස්කරණ''' නැරඹීම සහ මූලාශ්‍රය පිටපත් කිරීම ඔබට කල හැක:",
	'virus-badscanner' => "අයෝග්‍ය වික්‍යාසයකි: අඥාත වයිරස සුපිරික්සකයකි: ''$1''",
	'virus-scanfailed' => 'පරිලෝකනය අසාර්ථක විය (කේතය $1)',
	'virus-unknownscanner' => 'නොහඳුනන ප්‍රතිවයිරසයක්:',
	'viewpagelogs' => 'මෙම පිටුව පිලිබඳ සටහන් නරඹන්න',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) නරඹන්න',
	'verification-error' => 'මෙම ගොනුව සත්‍යායනය කිරීමෙන් සමත් වූ බවට පිළිගත නොහැක.',
	'viewdeletedpage' => 'මකා දැමූ පිටු නරඹන්න',
	'video-dims' => '$1, $2×$3',
	'variantname-zh-hans' => 'hans',
	'variantname-zh-hant' => 'hant',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
	'variantname-zh-sg' => 'sg',
	'variantname-zh-my' => 'my',
	'variantname-zh' => 'zh',
	'variantname-sr-ec' => 'sr-ec',
	'variantname-sr-el' => 'sr-el',
	'variantname-sr' => 'sr',
	'variantname-kk-kz' => 'kk-kz',
	'variantname-kk-tr' => 'kk-tr',
	'variantname-kk-cn' => 'kk-cn',
	'variantname-kk-cyrl' => 'kk-cyrl',
	'variantname-kk-latn' => 'kk-latn',
	'variantname-kk-arab' => 'kk-arab',
	'variantname-kk' => 'kk',
	'variantname-ku-arab' => 'ku-Arab',
	'variantname-ku-latn' => 'ku-Latn',
	'variantname-ku' => 'ku',
	'variantname-tg-cyrl' => 'tg-Cyrl',
	'variantname-tg-latn' => 'tg-Latn',
	'variantname-tg' => 'tg',
	'version' => 'අනුවාදය',
	'version-extensions' => 'ස්ථාපිත ප්‍රසර්ජනයන්',
	'version-specialpages' => 'විශේෂ පිටු',
	'version-parserhooks' => 'ව්‍යාකරණ විග්‍රහක හසුරු',
	'version-variables' => 'විචල්‍යයන්',
	'version-antispam' => 'ස්පෑම වැලැක්වුම',
	'version-skins' => 'ඡවිය',
	'version-other' => 'වෙනත්',
	'version-mediahandlers' => 'මාධ්‍ය හසුරුවනය',
	'version-hooks' => 'හසුරු',
	'version-extension-functions' => 'ප්‍රසර්ජිත කාර්යයන්',
	'version-parser-extensiontags' => 'ව්‍යාකරණ  විග්‍රහක ප්‍රසර්ජන ටැගයන්',
	'version-parser-function-hooks' => 'වයාකරණ විග්‍රහක ශ්‍රිත හසුරු',
	'version-hook-name' => 'හසුරු නම',
	'version-hook-subscribedby' => 'දායකවී ඇත්තේ',
	'version-version' => '(අනුවාදය $1)',
	'version-license' => 'බලපත්‍රය',
	'version-poweredby-credits' => "මෙම විකිය '''[//www.mediawiki.org/ MediaWiki]''' මගින් බලගන්වා ඇත, copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'අනෙකුත්',
	'version-license-info' => 'MediaWiki යනු නිදහස් මෘදුකාංගයකි; නිදහස් මෘදුකාංග පදනමේ (Free Software Foundation) හි GNU General Public License නම් බලපත්‍රයේ වගන්තිවලට අනුව ඔබට එය නැවත බෙදාහැරීම සහ/හෝ සංස්කරණය කළ හැක; ඒ, එම බලපත්‍රයේ 2වන හෝ (ඔබට කැමති නම්) ඉන්පසු එන සංස්කරණයකට අනුවය.

MediaWiki බෙදාහැර ඇත්තේ එය ප්‍රයෝජනවත්වේය යන බලාපොරොත්තුව ඇතිවය, නමුත් *කිසිදු වගකීමක් රහිතව*ය; අඩු තරමේ *විකිණිය හැකිබව* හෝ *කිසියම් කාර්යයකට ප්‍රයෝජනයට ගත හැකිබව* යන්න පිළිබඳ වගකීමක් හෝ රහිතවය. වැඩි විස්තර සඳහා GNU General Public License බලන්න.

ඔබට මෙම මෘදුකාංගය සමග [{{SERVER}}{{SCRIPTPATH}}/COPYING GNU General Public License හි පිටපතක්] ලැබී තිබිය යුතුය; නැතිනම්, Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA වෙත ලියන්න හෝ [//www.gnu.org/licenses/old-licenses/gpl-2.0.html එය මාර්ගගතව කියවන්න].',
	'version-software' => 'ස්ථාපිත මෘදුකාංග',
	'version-software-product' => 'නිෂ්පාදනය',
	'version-software-version' => 'අනුවාදය',
);

$messages['sk'] = array(
	'variants' => 'Varianty',
	'view' => 'Zobraziť',
	'viewdeleted_short' => 'Zobraziť {{PLURAL:$1|jednu zmazanú úpravu|$1 zmazané úpravy|$1 zmazaných úprav}}',
	'views' => 'Zobrazení',
	'viewcount' => 'Táto stránka bola navštívená {{PLURAL:$1|raz|$1-krát|$1-krát}}.',
	'view-pool-error' => 'Ľutujeme, servery sú momentálne preťažené.
Príliš veľa používateľov sa pokúša zobraziť túto stránku.
Prosím, počkajte chvíľu predtým, než sa pokúsite na túto stránku dostať znova.

$1',
	'versionrequired' => 'Požadovaná verzia MediaWiki $1',
	'versionrequiredtext' => 'Aby ste mohli používať túto stránku, požaduje sa verzia MediaWiki $1. Pozri [[Special:Version]].',
	'viewsourceold' => 'zobraziť zdroj',
	'viewsourcelink' => 'zobraziť zdroj',
	'viewdeleted' => 'Zobraziť $1?',
	'viewsource' => 'Zobraziť zdroj',
	'viewsource-title' => 'Zobrazenie zdroja stránky $1',
	'viewsourcetext' => 'Môžete si zobraziť a kopírovať zdroj tejto stránky:',
	'viewyourtext' => "Môžete si prehliadnuť a skopírovať zdrojový kód '''vašich zmien''' tejto stránky:",
	'virus-badscanner' => "Chybná konfigurácia: neznámy antivírus: ''$1''",
	'virus-scanfailed' => 'kontrola zlyhala (kód $1)',
	'virus-unknownscanner' => 'neznámy antivírus:',
	'viewpagelogs' => 'Zobraziť záznamy pre túto stránku',
	'viewprevnext' => 'Zobraziť ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Tento súbor neprešiel overením súboru.',
	'viewdeletedpage' => 'Zobraziť zmazané stránky',
	'version' => 'Verzia',
	'version-extensions' => 'Nainštalované rozšírenia',
	'version-specialpages' => 'Špeciálne stránky',
	'version-parserhooks' => 'Prípojné body syntaktického analyzátora',
	'version-variables' => 'Premenné',
	'version-antispam' => 'Ochranu proti spamu',
	'version-skins' => 'Témy vzhľadu',
	'version-other' => 'Iné',
	'version-mediahandlers' => 'Obsluha multimédií',
	'version-hooks' => 'Prípojné body',
	'version-extension-functions' => 'Rozširujúce funkcie',
	'version-parser-extensiontags' => 'Rozširujúce značky syntaxe',
	'version-parser-function-hooks' => 'Prípojné body funkcií syntaktického analyzátora',
	'version-hook-name' => 'Názov prípojného bodu',
	'version-hook-subscribedby' => 'Pripojené',
	'version-version' => '(Verzia $1)',
	'version-license' => 'Licencia',
	'version-poweredby-credits' => "Táto wiki beží na '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'ďalší',
	'version-license-info' => 'MediaWiki je slobodný softvér; môžete ho šíriť a / alebo modifikovať podľa podmienok GNU General Public License, ktorú vydala Free Software Foundation; a to buď verzie 2 tejto licencie alebo (podľa vášho uváženia) ktorejkoľvek neskoršej verzie.

MediaWiki je šírený v nádeji, že bude užitočný, avšak BEZ AKEJKOĽVEK ZÁRUKY; neposkytujú sa ani implicitné záruky PREDAJNOSTI alebo VHODNOSTI NA URČITÝ ÚČEL. Ďalšie informácie nájdete v GNU General Public License.

Spolu s týmto programom by ste obdržať [{{SERVER}}{{SCRIPTPATH}}/COPYING kópiu GNU General Public License]. Ak nie, napíšte na adresu Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA alebo [//www.gnu.org/licenses/old-licenses/gpl-2.0.html si ju prečítajte online].',
	'version-software' => 'Nainštalovaný softvér',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Verzia',
	'version-entrypoints' => 'URL vstupných bodov',
	'version-entrypoints-header-entrypoint' => 'Vstupný bod',
	'version-entrypoints-header-url' => 'URL',
);

$messages['sl'] = array(
	'variants' => 'Različice',
	'view' => 'Ogled',
	'viewdeleted_short' => 'Ogled {{PLURAL:$1|enega izbrisanega urejanja|$1 izbrisanih urejanj}}',
	'views' => 'Pogled',
	'viewcount' => 'Stran je bila naložena {{PLURAL:$1|$1-krat}}.',
	'view-pool-error' => 'Žal so strežniki trenutno preobremenjeni.
Preveč uporabnikov skuša obiskati to stran.
Prosimo za potrpežljivost, obiščite nas spet kmalu.

$1',
	'versionrequired' => 'Potrebna je različica MediaWiki $1',
	'versionrequiredtext' => 'Za uporabo strani je potrebna različica MediaWiki $1. Glejte [[Special:Version]].',
	'viewsourceold' => 'izvorno besedilo',
	'viewsourcelink' => 'izvorna koda',
	'viewdeleted' => 'Prikažem $1?',
	'viewsource' => 'Izvorno besedilo',
	'viewsource-title' => 'Ogled vira $1',
	'viewsourcetext' => 'Lahko si ogledate in kopirate vsebino te strani:',
	'viewyourtext' => "Lahko si ogledate in kopirate vsebino '''vaših urejanj''' te strani:",
	'virus-badscanner' => "Slaba konfiguracija: neznani virus skener: ''$1''",
	'virus-scanfailed' => 'pregled ni uspel (koda $1)',
	'virus-unknownscanner' => 'neznan antivirusni program:',
	'viewpagelogs' => 'Poglej dnevniške zapise o strani',
	'viewprevnext' => 'Prikazujem ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Ta datoteka ni opravila preverjanja datoteke',
	'viewdeletedpage' => 'Pregled izbrisanih strani',
	'video-dims' => '$1, $2&nbsp;×&nbsp;$3',
	'version' => 'Različica',
	'version-extensions' => 'Nameščene razširitve',
	'version-specialpages' => 'Posebne strani',
	'version-parserhooks' => 'Razširitve razčlenjevalnika',
	'version-variables' => 'Spremenljivke',
	'version-antispam' => 'Preprečevanje smetja',
	'version-skins' => 'Kože',
	'version-other' => 'Ostalo',
	'version-mediahandlers' => 'Upravljavci predstavnostnih vsebin',
	'version-hooks' => 'Razširitve',
	'version-extension-functions' => 'Funkcije razširitev',
	'version-parser-extensiontags' => 'Etikete razširitev razčlenjevalnika',
	'version-parser-function-hooks' => 'Funkcije razširitev razčlenjevalnika',
	'version-hook-name' => 'Ime razširitve',
	'version-hook-subscribedby' => 'Naročen s strani',
	'version-version' => '(Različica $1)',
	'version-license' => 'Dovoljenje',
	'version-poweredby-credits' => "Ta wiki poganja '''[//www.mediawiki.org/ MediaWiki]''', vse pravice pridržave © 2001-$1 $2.",
	'version-poweredby-others' => 'drugi',
	'version-license-info' => 'MediaWiki je prosto programje; lahko ga razširjate in / ali spreminjate pod pogoji GNU General Public License, kot ga je objavila Free Software Foundation; bodisi License različice 2 ali (po vaši izbiri) katere koli poznejše različice.

MediaWiki je razširjan v upanju, da bo uporaben, vendar BREZ KAKRŠNEGA KOLI ZAGOTOVILA; tudi brez posrednega jamstva PRODAJNE VREDNOSTI ali PRIMERNOSTI ZA DOLOČEN NAMEN. Oglejte si GNU General Public License za več podrobnosti.

Skupaj s programom bi morali bi prejeti [{{SERVER}}{{SCRIPTPATH}}/COPYING kopijo GNU General Public License]; če je niste, pišite Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA ali jo [//www.gnu.org/licenses/old-licenses/gpl-2.0.html preberite na spletu].',
	'version-software' => 'Nameščena programska oprema',
	'version-software-product' => 'Izdelek',
	'version-software-version' => 'Različica',
);

$messages['sli'] = array(
	'variants' => 'Varianta',
	'views' => 'Oansichta',
	'viewcount' => 'Diese Seite wurde bisher {{PLURAL:$1|eemool|$1-mool}} obgeruffa.',
	'view-pool-error' => "Entschuldigung, de Server sein eim Moment ieberlastet.
Zu viele Benutzer versucha, diese Seite zu besucha.
Bitte warte eenige Minuta, bevur du 's noo eemool versuchst.

$1",
	'versionrequired' => 'Version $1 vo MediaWiki ies erforderlich',
	'versionrequiredtext' => 'Version $1 vu MediaWiki ies erforderlich, im diese Seite zu nutza. Siehe de [[Special:Version|Versionsseite]]',
	'viewsourceold' => 'Quelltext oanzeiga',
	'viewsourcelink' => 'Quelltext oanschaua',
	'viewdeleted' => '$1 oanzeega?',
	'viewsource' => 'Quelltext oasahn',
	'viewsourcetext' => 'Quelltext voo dar della Seite:',
	'virus-badscanner' => "Fahlerhofte Konfiguration: unbekoannter Virenskänner: ''$1''",
	'virus-scanfailed' => 'Skän fahlgeschloan (Kode $1)',
	'virus-unknownscanner' => 'Unbekoannter Virenskänner:',
	'viewpagelogs' => 'Logbicher fier diese Seite oazeega',
	'viewprevnext' => 'Zeige ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Geläschte Seyta oazeiga',
	'version-specialpages' => 'Spezialseyta',
	'version-other' => 'Oanderes',
	'version-hooks' => "Schnittstalla ''(Hooks)''",
	'version-extension-functions' => 'Funksjonnsuffruffe',
	'version-parser-extensiontags' => "Parser-Erweiterunga ''(tags)''",
	'version-parser-function-hooks' => 'Parser-Funksjonna',
	'version-hook-name' => 'Schnittstallanoame',
	'version-hook-subscribedby' => 'Uffruff vu',
);

$messages['sma'] = array(
	'views' => 'Vuesehth',
	'viewdeleted' => 'Vuesehte $1?',
	'viewsource' => 'Vuesehte tjaalege',
	'viewsourcetext' => 'Dov dorje vuesehte jih kåpieerae gaaltjie dejstie dïhte bielie:',
	'viewpagelogs' => 'Vuesehte loggeh ihke dïhte bielie',
	'viewprevnext' => 'Vuesehth ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Låhkoe',
);

$messages['sn'] = array(
	'viewsource' => 'Wona mabviro',
);

$messages['so'] = array(
	'views' => 'Muuqaalka',
	'viewcount' => 'This page has been accessed {{PLURAL:$1|one time|$1 times}}.',
	'viewdeleted' => 'Fiiri $1?',
	'viewprevnext' => 'Fiiri ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => "Fiiri boggaga la'tirtiray",
);

$messages['sq'] = array(
	'variants' => 'Variante',
	'view' => 'Shiko',
	'viewdeleted_short' => 'Shiko {{PLURAL:$1|një redaktim të fshirë|$1 redaktime të fshira}}',
	'views' => 'Shikime',
	'viewcount' => 'Kjo faqe është shikuar {{PLURAL:$1|një|$1 herë}} .',
	'view-pool-error' => "Ju kërkojmë ndjesë, serverët janë të mbingarkuar për momentin.
Këtë faqe po përpiqen t'i shikojnë më shumë njerëz nga ç'është e mundur.
Ju lutemi prisni pak para se ta hapni sërish këtë faqe.

$1",
	'versionrequired' => 'Nevojitet versioni $1 i MediaWiki-it',
	'versionrequiredtext' => 'Nevojitet versioni $1 i MediaWiki-it për përdorimin e kësaj faqeje. Shikoni [[Special:Version|versionin]] tuaj.',
	'viewsourceold' => 'Shiko tekstin',
	'viewsourcelink' => 'Shiko tekstin',
	'viewdeleted' => 'Do ta shikosh $1?',
	'viewsource' => 'Shiko tekstin',
	'viewsource-title' => 'Shiko tekstin për $1',
	'viewsourcetext' => 'Ju mund të shikoni dhe kopjoni tekstin e kësaj faqeje:',
	'viewyourtext' => "Ju mund të shikoni dhe të kopjoni tekstin e '''ndryshimeve tuaja''' tek kjo faqe:",
	'virus-badscanner' => "Konfiguracion i parregullt: Skaner i panjohur virusesh: ''$1''",
	'virus-scanfailed' => 'skani dështoi (code $1)',
	'virus-unknownscanner' => 'antivirus i pa njohur:',
	'viewpagelogs' => 'Shiko regjistrat për këtë faqe',
	'viewprevnext' => 'Shikoni ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Kjo skedë nuk e kaloi verifikimin e skedave.',
	'viewdeletedpage' => 'Shikoni faqet e grisura',
	'version' => 'Versioni',
	'version-extensions' => 'Zgjerime të instaluara',
	'version-specialpages' => 'Faqe speciale',
	'version-parserhooks' => 'Parser goditje',
	'version-variables' => 'Variabël',
	'version-antispam' => 'Spam',
	'version-skins' => 'Pamjet',
	'version-other' => 'Të tjera',
	'version-mediahandlers' => 'Mbajtesit e Media-s',
	'version-hooks' => 'Goditjet',
	'version-extension-functions' => 'Funksionet shtese',
	'version-parser-extensiontags' => 'Parser etiketat shtese',
	'version-parser-function-hooks' => 'Parser goditjet e funksionit',
	'version-hook-name' => 'Emri i goditjes',
	'version-hook-subscribedby' => 'Abonuar nga',
	'version-version' => '(Versioni $1)',
	'version-license' => 'Licensa',
	'version-poweredby-credits' => "Ky wiki është mundësuar nga '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'të tjerë',
	'version-license-info' => 'MediaWiki është një softuer i lirë; ju mund ta shpërndani dhe redakatoni atë nën kushtet GNU General Public License si e publikuar nga fondacioni Free Software; ose versioni 2 i licensës, ose çdo version më i vonshëm.

MediaWiki është shpërndarë me shpresën se do të jetë i dobishëm, por PA ASNJË GARANCI; as garancinë e shprehur të SHITJES apo PËRDORIMIT PËR NJË QËLLIM TË CAKTUAR. Shikoni GNU General Public License  për më shumë detaje.

Ju duhet të keni marrë [{{SERVER}}{{SCRIPTPATH}}/COPYING një kopje të GNU General Public License] së bashku me këtë program; nëse jo, shkruani tek Free Software Foundation, Inc., 51 Rruga Franklin, Kati i pestë, Boston, MA 02110-1301, ShBA ose [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lexojeni atë online].',
	'version-software' => 'Softuerët e instaluar',
	'version-software-product' => 'Produkti',
	'version-software-version' => 'Versioni',
);

$messages['sr'] = array(
	'variants' => 'Variante',
	'view' => 'Shiko',
	'viewdeleted_short' => 'Shiko {{PLURAL:$1|një redaktim të fshirë|$1 redaktime të fshira}}',
	'views' => 'Shikime',
	'viewcount' => 'Kjo faqe është shikuar {{PLURAL:$1|një|$1 herë}} .',
	'view-pool-error' => "Ju kërkojmë ndjesë, serverët janë të mbingarkuar për momentin.
Këtë faqe po përpiqen t'i shikojnë më shumë njerëz nga ç'është e mundur.
Ju lutemi prisni pak para se ta hapni sërish këtë faqe.

$1",
	'versionrequired' => 'Nevojitet versioni $1 i MediaWiki-it',
	'versionrequiredtext' => 'Nevojitet versioni $1 i MediaWiki-it për përdorimin e kësaj faqeje. Shikoni [[Special:Version|versionin]] tuaj.',
	'viewsourceold' => 'Shiko tekstin',
	'viewsourcelink' => 'Shiko tekstin',
	'viewdeleted' => 'Do ta shikosh $1?',
	'viewsource' => 'Shiko tekstin',
	'viewsource-title' => 'Shiko tekstin për $1',
	'viewsourcetext' => 'Ju mund të shikoni dhe kopjoni tekstin e kësaj faqeje:',
	'viewyourtext' => "Ju mund të shikoni dhe të kopjoni tekstin e '''ndryshimeve tuaja''' tek kjo faqe:",
	'virus-badscanner' => "Konfiguracion i parregullt: Skaner i panjohur virusesh: ''$1''",
	'virus-scanfailed' => 'skani dështoi (code $1)',
	'virus-unknownscanner' => 'antivirus i pa njohur:',
	'viewpagelogs' => 'Shiko regjistrat për këtë faqe',
	'viewprevnext' => 'Shikoni ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Kjo skedë nuk e kaloi verifikimin e skedave.',
	'viewdeletedpage' => 'Shikoni faqet e grisura',
	'version' => 'Versioni',
	'version-extensions' => 'Zgjerime të instaluara',
	'version-specialpages' => 'Faqe speciale',
	'version-parserhooks' => 'Parser goditje',
	'version-variables' => 'Variabël',
	'version-antispam' => 'Spam',
	'version-skins' => 'Pamjet',
	'version-other' => 'Të tjera',
	'version-mediahandlers' => 'Mbajtesit e Media-s',
	'version-hooks' => 'Goditjet',
	'version-extension-functions' => 'Funksionet shtese',
	'version-parser-extensiontags' => 'Parser etiketat shtese',
	'version-parser-function-hooks' => 'Parser goditjet e funksionit',
	'version-hook-name' => 'Emri i goditjes',
	'version-hook-subscribedby' => 'Abonuar nga',
	'version-version' => '(Versioni $1)',
	'version-license' => 'Licensa',
	'version-poweredby-credits' => "Ky wiki është mundësuar nga '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'të tjerë',
	'version-license-info' => 'MediaWiki është një softuer i lirë; ju mund ta shpërndani dhe redakatoni atë nën kushtet GNU General Public License si e publikuar nga fondacioni Free Software; ose versioni 2 i licensës, ose çdo version më i vonshëm.

MediaWiki është shpërndarë me shpresën se do të jetë i dobishëm, por PA ASNJË GARANCI; as garancinë e shprehur të SHITJES apo PËRDORIMIT PËR NJË QËLLIM TË CAKTUAR. Shikoni GNU General Public License  për më shumë detaje.

Ju duhet të keni marrë [{{SERVER}}{{SCRIPTPATH}}/COPYING një kopje të GNU General Public License] së bashku me këtë program; nëse jo, shkruani tek Free Software Foundation, Inc., 51 Rruga Franklin, Kati i pestë, Boston, MA 02110-1301, ShBA ose [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lexojeni atë online].',
	'version-software' => 'Softuerët e instaluar',
	'version-software-product' => 'Produkti',
	'version-software-version' => 'Versioni',
);

$messages['sr-ec'] = array(
	'variants' => 'Варијанте',
	'view' => 'Погледај',
	'viewdeleted_short' => 'Погледај {{PLURAL:$1|обрисану измену|$1 обрисане измене|$1 обрисаних измена}}',
	'views' => 'Прегледи',
	'viewcount' => 'Ова страница је прегледана {{PLURAL:$1|једанпут|$1 пута|$1 пута}}.',
	'view-pool-error' => 'Нажалост, сервери су тренутно преоптерећени.
Превише корисника покушава да прегледа ову страницу.
Сачекајте неко време пре него што поново покушате да јој приступите.

$1',
	'versionrequired' => 'Потребно је издање $1 Медијавикија',
	'versionrequiredtext' => 'Потребно је издање $1 Медијавикија да бисте користили ову страницу.
Погледајте страницу за [[Special:Version|издање]].',
	'viewsourceold' => 'изворник',
	'viewsourcelink' => 'Извор',
	'viewdeleted' => 'Погледати $1?',
	'viewsource' => 'Изворник',
	'viewsource-title' => 'Приказ извора странице $1',
	'viewsourcetext' => 'Можете да погледате и умножите изворни текст ове странице:',
	'viewyourtext' => "Можете да погледате и умножите извор '''ваших измена''' на овој страници:",
	'virus-badscanner' => "Неисправна поставка: непознати скенер за вирусе: ''$1''",
	'virus-scanfailed' => 'неуспешно скенирање (код $1)',
	'virus-unknownscanner' => 'непознати антивирус:',
	'viewpagelogs' => 'Погледај дневнике ове странице',
	'viewprevnext' => 'Погледај ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Ова датотека није прошла проверу.',
	'viewdeletedpage' => 'Приказ обрисаних страница',
	'video-dims' => '$1, $2×$3',
	'variantname-zh-hans' => 'hans',
	'variantname-zh-hant' => 'hant',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
	'variantname-zh-sg' => 'sg',
	'variantname-zh-my' => 'my',
	'variantname-zh' => 'zh',
	'variantname-gan-hans' => 'hans',
	'variantname-gan-hant' => 'hant',
	'variantname-gan' => 'gan',
	'variantname-sr-ec' => 'Ћирилица',
	'variantname-sr-el' => 'Latinica',
	'variantname-sr' => 'sr',
	'variantname-kk-kz' => 'kk-kz',
	'variantname-kk-tr' => 'kk-tr',
	'variantname-kk-cn' => 'kk-cn',
	'variantname-kk-cyrl' => 'kk-cyrl',
	'variantname-kk-latn' => 'kk-latn',
	'variantname-kk-arab' => 'kk-arab',
	'variantname-kk' => 'kk',
	'variantname-ku-arab' => 'ku-Arab',
	'variantname-ku-latn' => 'ku-Latn',
	'variantname-ku' => 'ku',
	'variantname-tg-cyrl' => 'tg-Cyrl',
	'variantname-tg-latn' => 'tg-Latn',
	'variantname-tg' => 'tg',
	'variantname-ike-cans' => 'ike-Cans',
	'variantname-ike-latn' => 'ike-Latn',
	'variantname-iu' => 'iu',
	'variantname-shi-tfng' => 'shi-Tfng',
	'variantname-shi-latn' => 'shi-Latn',
	'variantname-shi' => 'shi',
	'version' => 'Верзија',
	'version-extensions' => 'Инсталирана проширења',
	'version-specialpages' => 'Посебне странице',
	'version-parserhooks' => 'Куке рашчлањивача',
	'version-variables' => 'Променљиве',
	'version-antispam' => 'Спречавање непожељних порука',
	'version-skins' => 'Теме',
	'version-api' => 'АПИ',
	'version-other' => 'Друго',
	'version-mediahandlers' => 'Руководиоци медијима',
	'version-hooks' => 'Куке',
	'version-extension-functions' => 'Функције',
	'version-parser-extensiontags' => 'Ознаке',
	'version-parser-function-hooks' => 'Куке',
	'version-hook-name' => 'Назив куке',
	'version-hook-subscribedby' => 'Пријављено од',
	'version-version' => '(издање $1)',
	'version-svn-revision' => '(изм. $2)',
	'version-license' => 'Лиценца',
	'version-poweredby-credits' => "Овај вики покреће '''[//www.mediawiki.org/ Медијавики]''', ауторска права © 2001-$1 $2.",
	'version-poweredby-others' => 'остали',
	'version-license-info' => 'Медијавики је слободан софтвер; можете га расподељивати и мењати под условима ГНУ-ове опште јавне лиценце (ОЈЛ) коју је објавила Задужбина за слободан софтвер, било да је у питању друго или новије издање лиценце.

Медијавики се нуди у нади да ће бити од користи, али БЕЗ ИКАКВЕ ГАРАНЦИЈЕ; чак и без подразумеване гаранције о ПРОДАЈНОЈ ВРЕДНОСТИ или ПОГОДНОСТИ ЗА ОДРЕЂЕНЕ НАМЕНЕ. Погледајте ГНУ-ову општу јавну лиценцу за више информација.

Требало би да сте примили [{{SERVER}}{{SCRIPTPATH}}/COPYING примерак ГНУ-ове опште јавне лиценце] заједно с овим програмом. Ако нисте, пишите на Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA или [//www.gnu.org/licenses/old-licenses/gpl-2.0.html прочитајте овде].',
	'version-software' => 'Инсталирани софтвер',
	'version-software-product' => 'Производ',
	'version-software-version' => 'Верзија',
);

$messages['sr-el'] = array(
	'variants' => 'Varijante',
	'views' => 'Pregledi',
	'viewcount' => 'Ovoj stranici je pristupljeno {{PLURAL:$1|jednom|$1 puta|$1 puta}}.',
	'view-pool-error' => 'Žao nam je, serveri su trenutno prezauzeti.
Previše korisnika pokušava da pristupi ovoj stranici.
Molimo vas da sačekate neko vrijeme prije nego pokušate opet da joj pristupite.

$1',
	'versionrequired' => 'Verzija $1 MedijaVikija je potrebna',
	'versionrequiredtext' => 'Verzija $1 MedijaVikija je potrebna da bi se koristila ova stranica. Pogledajte [[Special:Version|verziju]].',
	'viewsourceold' => 'izvornik',
	'viewsourcelink' => 'Izvornik',
	'viewdeleted' => 'Pogledaj $1?',
	'viewsource' => 'pogledaj kod',
	'viewsourcefor' => 'za $1',
	'viewsourcetext' => 'Možete da pregledate i kopirate sadržaj ove stranice:',
	'virus-badscanner' => "Loša konfiguracija zbog neodgovarajućeg skenera za virus: ''$1''",
	'virus-scanfailed' => 'skeniranje propalo (kod $1)',
	'virus-unknownscanner' => 'nepoznati antivirus:',
	'viewpagelogs' => 'Istorijat ove stranice',
	'viewprevnext' => 'Pogledaj ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Pogledaj obrisane strane',
	'variantname-sr-ec' => 'Ћирилица',
	'variantname-sr-el' => 'Latinica',
	'variantname-sr' => 'disable',
	'version' => 'Verzija',
	'version-extensions' => 'Instalisane ekstenzije',
	'version-specialpages' => 'Posebne stranice',
	'version-parserhooks' => 'zakačke parsera',
	'version-variables' => 'Varijable',
	'version-other' => 'Ostalo',
	'version-mediahandlers' => 'rukovaoci medijima',
	'version-hooks' => 'zakačke',
	'version-extension-functions' => 'Funkcije dodatka',
	'version-parser-extensiontags' => 'tagovi ekstenzije Parser',
	'version-parser-function-hooks' => 'zakačke parserove funkcije',
	'version-skin-extension-functions' => 'ekstenzije funkcije kože',
	'version-hook-name' => 'ime zakačke',
	'version-hook-subscribedby' => 'prijavljeni',
	'version-version' => '(Verzija $1)',
	'version-license' => 'Licenca',
	'version-software' => 'Instaliran softver',
	'version-software-product' => 'Proizvod',
	'version-software-version' => 'Verzija',
);

$messages['srn'] = array(
	'views' => 'Views',
	'viewcount' => 'A papira disi opo {{PLURAL:$1|wan leisi|$1 leisi}}.',
	'versionrequired' => 'Versie $1 fu MediaWiki de fanowdu',
	'versionrequiredtext' => 'Versie $1 fu MediaWiki de fanowdu fu man kebroiki a papira disi. Luku ini a papira [[Special:Version|softwareversie]].',
	'viewsourceold' => 'Luku a source',
	'viewdeleted' => 'Luku $1?',
	'viewsource' => 'Luku a source',
	'viewsourcetext' => 'Yu kan luku nanga kopi a source fu a papira disi:',
	'viewpagelogs' => 'Luku a log buku fu a papira disi',
	'viewprevnext' => 'Luku ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'Versi',
);

$messages['ss'] = array(
	'views' => 'Kubukeka',
	'viewcount' => 'Lelikhasi selibonwe {{PLURAL:$1|kanye|kayi $1}}.',
	'view-pool-error' => 'Siyacolisa, maseva etfu agwele kakhulu ngalesikhatsi.
Kunebantfu labanyenti labatama kubona lelikhasi.
Sicela ume kancane ngaphambi lwekuphindze ubone lelikhasi.

$1',
	'viewsourceold' => 'Bona kwakheka',
	'viewsourcelink' => 'Bona kwakheka',
	'viewdeleted' => 'Bona $1?',
	'version-specialpages' => 'Emakhasi labalulekile',
);

$messages['stq'] = array(
	'variants' => 'Variante',
	'view' => 'Leese',
	'viewdeleted_short' => '{{PLURAL:$1|1 läskeden Beoarbaidengsfoargang|$1 läskede Beoarbaidengsfoargange}} bekiekje',
	'views' => 'Anwiesengen',
	'viewcount' => 'Disse Siede wuude bit nu {{PLURAL:$1|eenmoal|$1 moal}} ouruupen.',
	'view-pool-error' => 'Äntskeeldigenge, do Servere sunt apstuuns uutlasted.
Tou fuul Benutsere fersäike, disse Siede tou besäiken.
Täif n poor Minuten, eer du et noch n Moal fersäkst.

$1',
	'versionrequired' => 'Version $1 fon MediaWiki is nöödich',
	'versionrequiredtext' => 'Version $1 fon MediaWiki is nöödich uum disse Siede tou nutsjen. Sjuch ju [[Special:Version|Versionssiede]]',
	'viewsourceold' => 'Wältext wiese',
	'viewsourcelink' => 'Wältext bekiekje',
	'viewdeleted' => '$1 anwiese?',
	'viewsource' => 'Wältext betrachtje',
	'viewsourcetext' => 'Wältext fon disse Siede:',
	'virus-badscanner' => "Failerhafte Konfiguration: uunbekoanden Virenscanner: ''$1''",
	'virus-scanfailed' => 'Scan failsloain (code $1)',
	'virus-unknownscanner' => 'Uunbekoanden Virenscanner:',
	'viewpagelogs' => 'Logbouke foar disse Siede anwiese',
	'viewprevnext' => 'Wies ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Disse Doatäi häd ju Doatäiwröige nit truchsteen.',
	'viewdeletedpage' => 'Läskede Versione anwiese',
	'version' => 'Version',
	'version-extensions' => 'Installierde Ärwiederengen',
	'version-specialpages' => 'Spezioalsieden',
	'version-parserhooks' => 'Parser-Hooks',
	'version-variables' => 'Variablen',
	'version-antispam' => 'Spamskuts',
	'version-skins' => 'Benutseruurflächen',
	'version-other' => 'Uurswät',
	'version-mediahandlers' => 'Medien-Handlere',
	'version-hooks' => "Snitsteeden ''(Hooks)''",
	'version-extension-functions' => 'Funktionsaproupe',
	'version-parser-extensiontags' => "Parser-Ärwiederengen ''(tags)''",
	'version-parser-function-hooks' => 'Parser-Funktione',
	'version-hook-name' => 'Snitsteedennoome',
	'version-hook-subscribedby' => 'Aproup fon',
	'version-version' => '(Version $1)',
	'version-license' => 'Lizenz',
	'version-poweredby-credits' => "Disse Website nutset '''[//www.mediawiki.org/wiki/MediaWiki/de MediaWiki]''', Copyright © 2001–$1 $2.",
	'version-poweredby-others' => 'uur',
	'version-license-info' => "MediaWiki is fräie Software, dät hat dät ju ätter do Bedingengen fon ju truch de Free Software Foundation fereepenlikede ''GNU General Public License'', fääreferdeeld un/ of modifizierd wäide kon. Deerbie kon ju version 2, of ätter oainen Uurdeel, älke näiere Version fon ju Lizenz ferwoand wäide.

MediaWiki wäd ferdeeld in ju Hoopenge, dät et nutselk weese skäl, man SUNNER EENIGE GARANTIE un sogoar sunner ju implizierde Garantie fon ne MÄÄRKEDGÄNGEGAID of OAINENGE FOAR N BESTIMDEN TSWÄK. Hiertou sunt wiedere Waiwiesengen in ju ''GNU General Public License'' äntheelden.

Ne [{{SERVER}}{{SCRIPTPATH}}/COPYING Kopie fon ju ''GNU General Public License''] skuul touhoope mäd dissen Program ferdeeld wuuden weese. Insofier dät nit dän Fal waas, kon ne Kopie bie ju Free Software Foundation Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA, skriftlek anfoarderd of ap do hiere Website [//www.gnu.org/licenses/old-licenses/gpl-2.0.html online leesen] wäide.",
	'version-software' => 'Installierde Software',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Version',
);

$messages['su'] = array(
	'variants' => 'Varian',
	'view' => 'Tempo',
	'viewdeleted_short' => 'Témbongkeun {{PLURAL:$1|hiji éditan nu dihapus|$1 éditan nu dihapus}}',
	'views' => 'Témbongan',
	'viewcount' => 'Kaca ieu geus dibuka {{PLURAL:$1|sakali|$1 kali}}.<br />',
	'view-pool-error' => 'Punten, serverna keur pinuh.
Loba teuing nu nyoba muka ieu kaca.
Mangga cobian sanés waktos.

$1',
	'versionrequired' => 'Butuh MediaWiki vérsi $1',
	'versionrequiredtext' => 'Butuh MediaWiki vérsi $1 pikeun migunakeun ieu kaca. Mangga tingal [[Special:Version|kaca vérsi]]',
	'viewsourceold' => 'tempo sumber',
	'viewsourcelink' => 'témbongkeun sumber',
	'viewdeleted' => 'Témbongkeun $1?',
	'viewsource' => 'Témbongkeun sumber',
	'viewsource-title' => 'Témbongkeun sumber pikeun $1',
	'viewsourcetext' => 'Anjeun bisa némbongkeun sarta nyalin sumber ieu kaca:',
	'viewyourtext' => "Anjeun bisa némbongkeun sarta nyalin sumber '''éditan anjeun''' ka ieu kaca:",
	'virus-badscanner' => "Kasalahan konfigurasi: panyekén virus teu dipikawanoh: ''$1''",
	'virus-scanfailed' => 'nyekén gagal (kode $1)',
	'virus-unknownscanner' => 'antivirus teu dipikawanoh:',
	'viewpagelogs' => 'Tempo log kaca ieu',
	'viewprevnext' => 'Témbongkeun ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Ieu berkas teu lulus vérifikasi.',
	'viewdeletedpage' => 'Témbongkeun kaca nu dihapus',
	'version' => 'Vérsi',
	'version-extensions' => 'Éksténsi nu diinstal',
	'version-specialpages' => 'Kaca husus',
	'version-parserhooks' => 'Kait parser',
	'version-variables' => 'Variabel',
	'version-other' => 'Séjén',
	'version-hooks' => 'Kait',
	'version-extension-functions' => 'Fungsi éksténsi',
	'version-parser-extensiontags' => 'Tag éksténsi parser',
	'version-hook-name' => 'Ngaran kait',
	'version-hook-subscribedby' => 'Didaptarkeun ku',
	'version-version' => '(Vérsi $1)',
	'version-license' => 'Lisénsi',
	'version-software' => 'Sopwér nu geus diinstal',
	'version-software-product' => 'Produk',
	'version-software-version' => 'Vérsi',
);

$messages['sv'] = array(
	'variants' => 'Varianter',
	'view' => 'Visa',
	'viewdeleted_short' => 'Visa {{PLURAL:$1|en raderad redigering|$1 raderade redigeringar}}',
	'views' => 'Visningar',
	'viewcount' => 'Den här sidan har visats {{PLURAL:$1|en gång|$1 gånger}}.',
	'view-pool-error' => 'Tyvärr är servrarna överbelastade för tillfället.
För många användare försöker visa denna sida.
Vänta en liten stund och försök igen lite senare.

$1',
	'versionrequired' => 'Version $1 av MediaWiki krävs',
	'versionrequiredtext' => 'Version $1 av MediaWiki är nödvändig för att använda denna sida. Se [[Special:Version|versionssidan]].',
	'viewsourceold' => 'visa wikitext',
	'viewsourcelink' => 'visa wikitext',
	'viewdeleted' => 'Visa $1?',
	'viewsource' => 'Visa wikitext',
	'viewsource-title' => 'Visa källkod för $1',
	'viewsourcetext' => 'Du kan se och kopiera denna sidas källtext:',
	'viewyourtext' => "Du kan se och kopiera källan för '''dina redigeringar''' på denna sida:",
	'virus-badscanner' => "Dålig konfigurering: okänd virusskanner: ''$1''",
	'virus-scanfailed' => 'skanning misslyckades (kod $1)',
	'virus-unknownscanner' => 'okänt antivirusprogram:',
	'viewpagelogs' => 'Visa loggar för denna sida',
	'viewprevnext' => 'Visa ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Denna fil klarade inte verifieringen.',
	'viewdeletedpage' => 'Visa raderade sidor',
	'version' => 'Version',
	'version-extensions' => 'Installerade programtillägg',
	'version-specialpages' => 'Specialsidor',
	'version-parserhooks' => 'Parsertillägg',
	'version-variables' => 'Variabler',
	'version-antispam' => 'Förhindring av skräppost',
	'version-skins' => 'Utseenden',
	'version-other' => 'Annat',
	'version-mediahandlers' => 'Mediahanterare',
	'version-hooks' => 'Hakar',
	'version-extension-functions' => 'Tilläggsfunktioner',
	'version-parser-extensiontags' => 'Tilläggstaggar',
	'version-parser-function-hooks' => 'Parserfunktioner',
	'version-hook-name' => 'Namn',
	'version-hook-subscribedby' => 'Används av',
	'version-version' => '(Version $1)',
	'version-license' => 'Licens',
	'version-poweredby-credits' => "Den här wikin drivs av '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'andra',
	'version-license-info' => 'MediaWiki är fri programvara; du kan distribuera det och/eller modifiera det under villkoren i GNU General Public License, publicerad av Free Software Foundation; antingen version 2 av licensen, eller (om du önskar) någon senare version.

MediaWiki distribueras i hopp om att det ska vara användbart, men UTAN NÅGON GARANTI, även utan underförstådd garanti om SÄLJBARHET eller LÄMPLIGHET FÖR ETT VISST SYFTE. Se GNU General Public License för fler detaljer.

Du bör ha fått [{{SERVER}}{{SCRIPTPATH}}/COPYING en kopia av GNU General Public License] tillsammans med detta program; om inte, skriv till Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA eller [//www.gnu.org/licenses/old-licenses/gpl-2.0.html läs den online].',
	'version-software' => 'Installerad programvara',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Version',
);

$messages['sw'] = array(
	'variants' => 'Vibadala',
	'view' => 'Tazama',
	'viewdeleted_short' => 'Tazama {{PLURAL:$1|sahihisho lililofutwa moja|masahihisho yaliyofutwa $1}}',
	'views' => 'Mitazamo',
	'viewcount' => 'Ukurasa huu umetembelewa mara {{PLURAL:$1|moja tu|$1}}.',
	'view-pool-error' => 'Samahani, seva zimezidiwa kwa wakati huu.
Watumiaji wengi mno wanajaribu kutazama ukurasa huu.
Tafadhali subiri kwa muda kadhaa kabla ya kujaribu kufungua tena.

$1',
	'versionrequired' => 'Toleo $1 la MediaWiki linahitajika',
	'versionrequiredtext' => 'Toleo $1 la MediaWiki linahitajika ili kutumia ukurasa huu.
Tazama [[Special:Version|ukurasa wa toleo]].',
	'viewsourceold' => 'view source',
	'viewsourcelink' => 'onyesha kodi za ukurasa',
	'viewdeleted' => 'Tazama $1?',
	'viewsource' => 'Onyesha kodi za ukurasa',
	'viewsource-title' => 'Tazama chanzo cha $1',
	'viewsourcetext' => 'Unaweza kutazama na kuiga chanzo cha ukurasa huu:',
	'viewyourtext' => "Unaweza kutazama na kunakili chanzo cha ''maharirio yako'' katika ukurasa huu:",
	'virus-badscanner' => "Usanidi mbaya: kiskani virusi hakijulikani: ''$1''",
	'virus-scanfailed' => 'skani imeshindwa (kodi $1)',
	'virus-unknownscanner' => 'kipambana na virusi haijulikani:',
	'viewpagelogs' => 'Tazama kumbukumbu kwa ukurasa huu',
	'viewprevnext' => 'Tazama ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Faili hili halikupitishwa katika ukaguzi wa faili.',
	'viewdeletedpage' => 'Tazama kurasa zilizofutwa',
	'version' => 'Toleo',
	'version-specialpages' => 'Kurasa maalum',
	'version-skins' => 'Maumbo',
	'version-other' => 'Zingine',
	'version-version' => '(Toleo $1)',
	'version-license' => 'Ruhusa',
	'version-poweredby-credits' => "Wiki hii inaendeshwa na bidhaa pepe ya '''[//www.mediawiki.org/ MediaWiki]''', hakimiliki © 2001-$1 $2.",
	'version-poweredby-others' => 'wengine',
	'version-license-info' => 'MediaWiki ni bidhaa pepe huru; unaweza kuisambaza pamoja na kuitumia na kuibadilisha kutokana na masharti ya leseni ya GNU General Public License inayotolewa na Free Software Foundation (Shirika la Bidhaa Pepe Huru); ama toleo 2 la hakimiliki, ama (ukitaka) toleo lolote linalofuata.

MediaWiki inatolewa kwa matumaini ya kwamba ni ya manufaa, lakini BILA JUKUMU; hata bila jukumu linalojitokeza la KUWA TAYARI KUUZIKA KIBIASHARA au KUFAA KWA KUSUDIO FULANI. Tazama leseni ya GNU General Public License kuona maelezo mengine.

Huwa unapokea [{{SERVER}}{{SCRIPTPATH}}/COPYING nakala ya GNU General Public License] pamoja na programu hii; la sivyo, andika kuomba nakala kwa Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA au [//www.gnu.org/licenses/old-licenses/gpl-2.0.html uisome mkondoni].',
	'version-software' => 'Bidhaa pepe iliyosakinishwa',
	'version-software-product' => 'Bidhaa',
	'version-software-version' => 'Toleo',
);

$messages['szl'] = array(
	'variants' => 'Warjanty',
	'view' => 'Podglůnd',
	'viewdeleted_short' => '{{PLURAL:$1|jedna wyćepano wersyjo|$1 wyćepane wersyje|$1 wyćepanych wersyjůw}}',
	'views' => 'Widok',
	'viewcount' => 'W ta zajta filowano {{PLURAL:$1|tylko roz|$1 rozůw}}.',
	'view-pool-error' => 'Felerńe, syrwyry sům przecionżone.

$1',
	'versionrequired' => 'Wymagano MediaWiki we wersyji $1',
	'versionrequiredtext' => 'Wymagano jest MediaWiki we wersji $1 coby skořistać s tyj zajty. Uoboč [[Special:Version]]',
	'viewsourceold' => 'pokoż zdrzůdło',
	'viewsourcelink' => 'zdrzůdłowy tekst',
	'viewdeleted' => 'Uobejřij $1',
	'viewsource' => 'Zdrzůdłowy tekst',
	'viewsourcetext' => 'We tekst zdřůduowy tyj zajty možno dali filować, idźe go tyž kopjować.',
	'virus-badscanner' => "Felerno konfiguracyjo – ńyznany skaner antywirusowy ''$1''",
	'virus-scanfailed' => 'skanowańy ńyudone (feler $1)',
	'virus-unknownscanner' => 'ńyznajůmy průgram antywirusowy',
	'viewpagelogs' => 'Uoboč rejery uoperacyji lo tyj zajty',
	'viewprevnext' => 'Uobźyrej ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Pokož wyćepńjynte zajty',
	'version' => 'Wersjo',
	'version-extensions' => 'Zainstalowane rozšeřyńa',
	'version-specialpages' => 'Szpecjalne zajty',
	'version-parserhooks' => 'Haki analizatora skuadńi (ang. parser hooks)',
	'version-variables' => 'Zmjynne',
	'version-other' => 'Inkše',
	'version-mediahandlers' => 'Wtyčki uobsůgi medjůw',
	'version-hooks' => 'Haki (ang. hooks)',
	'version-extension-functions' => 'Fůnkcyje rozšyřyń',
	'version-parser-extensiontags' => 'Značńiki rozšeřyń do analizatora skuadńi',
	'version-parser-function-hooks' => 'Fůnkcyje hokůw analizatora skuadńi (ang. parser function hooks)',
	'version-hook-name' => 'Mjano haka (ang. hook name)',
	'version-hook-subscribedby' => 'Zapotřebowany bez',
	'version-version' => '(Wersjo $1)',
	'version-license' => 'Licencjo',
	'version-software' => 'Zainstalowane uoprůgramowańy',
	'version-software-product' => 'Mjano',
	'version-software-version' => 'Wersjo',
);

$messages['ta'] = array(
	'variants' => 'மாற்றுக்கள்

மாற்றுருவங்கள்',
	'view' => 'பார்வையிடு',
	'viewdeleted_short' => '{{PLURAL:$1|ஒரு நீக்கப்பட்ட தொகுப்பை|$1 நீக்கப்பட்ட தொகுப்புகளை}}  பார்.',
	'views' => 'பார்வைகள்',
	'viewcount' => 'இப்பக்கம் {{PLURAL:$1|ஒரு முறை|$1 முறைகள்}} அணுகப்பட்டது.',
	'view-pool-error' => 'பொறுத்தருள்க, அனைத்து வழங்கிகளும் தற்போது மிகுபயன்பாட்டில் உள்ளன.
பல பயனர்கள் இப்பக்கத்தைப் பார்க்க விழைகின்றனர்.
நீங்கள் மறுபடியும் இப்பக்கத்தை அணுக முயலும் முன் சற்றே பொறுக்கவும்.

$1',
	'versionrequired' => 'மீடியாவிக்கியின் $1 பதிப்பு தேவை',
	'versionrequiredtext' => 'இப்பக்கத்தைப் பயன்படுத்த மீடியாவிக்கியின் $1 பதிப்பு தேவை. [[Special:Version|பதிப்புப் பக்கத்தைப்]] பார்க்க.',
	'viewsourceold' => 'மூலத்தை காட்டுக',
	'viewsourcelink' => 'மூலத்தைக் காண்க',
	'viewdeleted' => '$1 பார்?',
	'viewsource' => 'மூலத்தைப் பார்',
	'viewsource-title' => 'மூலம் காண்$1',
	'viewsourcetext' => 'நீங்கள் இதன் மூலத்தை பார்க்கவும் அதனை நகலெடுக்கவும் முடியும்:',
	'viewyourtext' => "நீங்கள் இந்த பக்கத்திற்கான ''' உங்கள் திருத்தங்களுக்கான ''' மூலத்தைக் காணவும்  நகலெடுக்கவும் முடியும்.",
	'virus-badscanner' => "சரியற்ற உள்ளமைவு: அறியப்படாத வைரஸ் வருடி: '' $1 ''",
	'virus-scanfailed' => 'வருடல் நடைபெறவில்லை (குறியீடு $1)',
	'virus-unknownscanner' => 'அறியப்படாத வைரசெதிர்ப்பு:',
	'viewpagelogs' => 'இப்பக்கத்துக்கான பதிகைகளைப் பார்',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) பக்கங்களைப் பார்.',
	'verification-error' => 'இந்த கோப்பு, கோப்பின் சரிபார்ப்பிற்கான சோதனையில் வெற்றியடையவில்லை.',
	'viewdeletedpage' => 'நீக்க்கப்பட்ட பக்கங்களைப் பார்',
	'version' => 'பதிப்பு',
	'version-extensions' => 'நிறுவப்பட்ட நீட்சிகள்',
	'version-specialpages' => 'சிறப்புப் பக்கங்கள்',
	'version-parserhooks' => 'இலக்கணப் பாகுபடுத்தி கொக்கிகள்',
	'version-variables' => 'மாறிகள்',
	'version-antispam' => ' குப்பை (spam) தடுப்பு',
	'version-skins' => 'தோல்கள்',
	'version-other' => 'மற்றவை',
	'version-mediahandlers' => 'ஊடக கையாளிகள்',
	'version-hooks' => 'கொக்கிகள்',
	'version-extension-functions' => 'நீட்சி செயற்பாடுகள்',
	'version-parser-extensiontags' => 'இலக்கணப் பாகுபடுத்தி நீட்சி குறிச்சொற்கள்',
	'version-parser-function-hooks' => 'இலக்கணப் பாகுபடுத்தி செயற்பாட்டு கொக்கிகள்',
	'version-hook-name' => 'கொக்கியின் பெயர்',
	'version-hook-subscribedby' => 'பயன்பாடு',
	'version-version' => '(பதிப்பு $1)',
	'version-license' => 'அனுமதி',
	'version-poweredby-credits' => "இந்த் விக்கி '''[//www.mediawiki.org/ MediaWiki]''' இதன் மூலம் வழங்கப்படுகிறது, காப்புரிமை © 2001-$1 $2.",
	'version-poweredby-others' => 'மற்றவைகள்',
	'version-license-info' => 'மீடியாவிக்கியானது இலவச மென்பொருள்.இதை நீங்கள் மற்றவர்களுக்கு கொடுப்பது அல்லது திருத்தம் செய்வது இலவச மென்பொருள் அறக்கட்டளை வழங்கிய   GNUவின் பொது உரிம விதிகளுக்குட்பட்டது;உரிமத்தின் இரண்டாவது பதிப்பு அல்லது அதற்கு மேற்பட்ட பதிப்பு (உங்கள் விருப்பத்திற்க்கேற்றவாறு).
மீடியா உபயோகப்படக்கூடியது என்ற நம்பிக்கையில் வெளியிடப்பட்டுள்ளது, ஆனால் இதற்க்கு உத்தரவாதம் கிடையாது.மேலும் வணிகத்தன்மைக்கான அல்லது ஒரு குறிப்பிட்ட செயலுக்காகவும் உத்தரவாதம் கிடையாது.மேலும் விவரங்களுக்கு GNU பொது உரிமத்தை பார்க்கவும்.
நீங்கள் இந்த  மென்பொருளுடன் [{{SERVER}}{{SCRIPTPATH}}/COPYING a copy of the GNU General Public License] பெற்றீருப்பிர்கள்;இல்லையெனில் , Free Software Foundation, Inc.,51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA க்கு எழுதவும்.அல்லது [//www.gnu.org/licenses/old-licenses/gpl-2.0.html read it online].',
	'version-software' => 'நிறுவப்பட்ட மென்பொருள்',
	'version-software-product' => 'உற்பத்திப்பொருள்',
	'version-software-version' => 'பதிப்பு',
);

$messages['tcy'] = array(
	'variants' => 'ರೂಪಾಂತರ ಹೊಂದ್‘ನ',
	'view' => 'ತೂಲೆ',
	'viewdeleted_short' => 'ನೋಟ{{PLURAL:$1|1 ಡಿಲೀಟ್ ಆತಿನ ಸಂಪಾದನೆ|$1 ಡಿಲೀಟ್ ಆತಿನ ಸಂಪಾದನೆಲು}}',
	'views' => 'ನೋಟಲು',
	'viewcount' => 'ಈ ಪುಟೊನು {{PLURAL:$1|1 ಸರಿ|$1 ಸರಿ}} ತೂತೆರ್.',
	'versionrequired' => 'ಮೀಡಿಯವಿಕಿಯದ $1 ನೇ ಅವೃತ್ತಿ ಬೋಡು',
	'versionrequiredtext' => 'ಈ ಪುಟೊನು ತೂಯೆರೆ ಮೀಡಿಯವಿಕಿಯದ $1 ನೇ ಆವೃತ್ತಿ ಬೋಡು.
[[Special:Version|ಆವೃತ್ತಿ]] ಪುಟನು ತೂಲೆ.',
	'viewsourceold' => 'ಮೂಲೊನು ತೂಲೆ',
	'viewsourcelink' => 'ಮೂಲೊನು ತೂಲೆ',
	'viewdeleted' => '$1 ನ್ ತೂವೊಡೆ?',
	'viewsource' => 'ಮೂಲ ಬರಹೊನು ತೂಲೆ',
	'viewsource-title' => ' $1 ಮೂಲ ಬರಹ ತೂಲೆ',
	'viewsourcetext' => 'ಈರ್ ಈ ಪುಟದ ಮೂಲನ್ ತೂವೊಲಿ ಬೊಕ್ಕ ನಕಲ್ ಮಲ್ಪೊಲಿ',
	'viewyourtext' => 'ಈರ್ ಈ ಪುಟದ ಮೂಲನ್ ತೂವೊಲಿ ಬೊಕ್ಕ ನಕಲ್ ಮಲ್ಪೊಲಿ',
	'viewpagelogs' => 'ಈ ಪುಟೊತ ದಾಖಲೆಲೆನ್ ತೂಲೆ',
	'viewprevnext' => 'ತೂಲೆ ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['te'] = array(
	'variants' => 'వైవిధ్యాలు',
	'view' => 'చూచుట',
	'viewdeleted_short' => '{{PLURAL:$1|తొలగించిన ఒక మార్పు|$1 తొలగించిన మార్పుల}}ను చూడండి',
	'views' => 'పేజీ లింకులు',
	'viewcount' => 'ఈ పేజీ {{PLURAL:$1|ఒక్క సారి|$1 సార్లు}} దర్శించబడింది.',
	'view-pool-error' => 'క్షమించండి, ప్రస్తుతం సర్వర్లన్నీ ఓవర్‌లోడ్ అయిఉన్నాయి.
చాలామంది వాడుకరులు ఈ పేజీని చూస్తున్నారు.
ఈ పేజీని వీక్షించడానికి కొద్దిసేపు నిరీక్షించండి.

$1',
	'versionrequired' => 'మీడియావికీ సాఫ్టువేరు వెర్షను $1 కావాలి',
	'versionrequiredtext' => 'ఈ పేజీని వాడటానికి మీకు మీడియావికీ సాఫ్టువేరు వెర్షను $1 కావాలి. [[Special:Version|వెర్షను పేజీ]]ని చూడండి.',
	'viewsourceold' => 'మూలాన్ని చూడండి',
	'viewsourcelink' => 'మూలాన్ని చూడండి',
	'viewdeleted' => '$1 చూస్తారా?',
	'viewsource' => 'మూలాన్ని చూపించు',
	'viewsource-title' => '$1 యొక్క సోర్సు చూడండి',
	'viewsourcetext' => 'మీరీ పేజీ సోర్సును చూడవచ్చు, కాపీ చేసుకోవచ్చు:',
	'virus-badscanner' => "తప్పుడు స్వరూపణం: తెలియని వైరస్ స్కానర్: ''$1''",
	'virus-scanfailed' => 'స్కాన్ విఫలమైంది (సంకేతం $1)',
	'virus-unknownscanner' => 'అజ్ఞాత యాంటీవైరస్:',
	'viewpagelogs' => 'ఈ పేజీకి సంబంధించిన లాగ్‌లను చూడండి',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) చూపించు.',
	'verification-error' => 'దస్త్రపు తనిఖీలో ఈ దస్త్రం ఉత్తీర్ణమవలేదు.',
	'viewdeletedpage' => 'తొలగించిన పేజీలను చూడండి',
	'version' => 'సంచిక',
	'version-extensions' => 'స్థాపించిన పొడగింతలు',
	'version-specialpages' => 'ప్రత్యేక పేజీలు',
	'version-parserhooks' => 'పార్సరు కొక్కాలు',
	'version-variables' => 'చరరాశులు',
	'version-antispam' => 'స్పాము నివారణ',
	'version-skins' => 'అలంకారాలు',
	'version-other' => 'ఇతర',
	'version-mediahandlers' => 'మీడియాను ఫైళ్లను నడిపించే పొడిగింపులు',
	'version-hooks' => 'కొక్కాలు',
	'version-extension-functions' => 'పొడిగింపు ఫంక్షనులు',
	'version-parser-extensiontags' => 'పార్సరు పొడిగింపు ట్యాగులు',
	'version-parser-function-hooks' => 'పార్సరుకు కొక్కాలు',
	'version-hook-name' => 'కొక్కెం పేరు',
	'version-hook-subscribedby' => 'ఉపయోగిస్తున్నవి',
	'version-version' => '(సంచిక $1)',
	'version-license' => 'లైసెన్సు',
	'version-poweredby-credits' => "ఈ వికీ  '''[//www.mediawiki.org/ మీడియావికీ]'''చే శక్తిమంతం, కాపీహక్కులు  © 2001-$1 $2.",
	'version-poweredby-others' => 'ఇతరులు',
	'version-license-info' => 'మీడియావికీ అన్నది స్వేచ్ఛా మృదూపకరణం; మీరు దీన్ని పునఃపంపిణీ చేయవచ్చు మరియు/లేదా ఫ్రీ సాఫ్ట్&zwnj;వేర్ ఫౌండేషన్ ప్రచురించిన గ్నూ జనరల్ పబ్లిక్ లైసెస్సు వెర్షను 2 లేదా (మీ ఎంపిక ప్రకారం) అంతకంటే కొత్త వెర్షను యొక్క నియమాలకు లోబడి మార్చుకోవచ్చు.

మీడియావికీ ప్రజోపయోగ ఆకాంక్షతో పంపిణీ చేయబడుతుంది, కానీ ఎటువంటి వారంటీ లేకుండా; కనీసం ఏదైనా ప్రత్యేక ఉద్దేశానికి సరిపడుతుందని గానీ లేదా వస్తుత్వం యొక్క అంతర్నిహిత వారంటీ లేకుండా. మరిన్ని వివరాలకు గ్నూ జనరల్ పబ్లిక్ లైసెన్సుని చూడండి.

ఈ ఉపకరణంతో పాటు మీకు [{{SERVER}}{{SCRIPTPATH}}/COPYING గ్నూ జనరల్ పబ్లిక్ లైసెన్సు  యొక్క ఒక కాపీ] అందివుండాలి; లేకపోతే, Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA అన్న చిరునామాకి వ్రాయండి లేదా [//www.gnu.org/licenses/old-licenses/gpl-2.0.html జాలం లోనే చదవండి].',
	'version-software' => 'స్థాపిత మృదూపకరణాలు',
	'version-software-product' => 'ప్రోడక్టు',
	'version-software-version' => 'వెర్షను',
);

$messages['tet'] = array(
	'versionrequired' => 'Presiza MediaWiki versaun $1',
	'versionrequiredtext' => "Presiza MediaWiki versaun $1 ba uza pájina ne'e. Haree [[Special:Version|pájina versaun]].",
	'viewsourceold' => 'lee testu',
	'viewsourcelink' => 'lee testu',
	'viewdeleted' => 'Haree $1?',
	'viewsource' => 'Lee testu',
	'viewsourcetext' => 'Ó bele lee no kopia testu pájina nian:',
	'viewprevnext' => 'Haree ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Versaun',
	'version-specialpages' => 'Pájina espesiál',
	'version-other' => 'Seluk',
	'version-version' => '(Versaun $1)',
	'version-license' => 'Lisensa',
	'version-software-product' => 'Produtu',
	'version-software-version' => 'Versaun',
);

$messages['tg'] = array(
	'versionrequired' => 'Presiza MediaWiki versaun $1',
	'versionrequiredtext' => "Presiza MediaWiki versaun $1 ba uza pájina ne'e. Haree [[Special:Version|pájina versaun]].",
	'viewsourceold' => 'lee testu',
	'viewsourcelink' => 'lee testu',
	'viewdeleted' => 'Haree $1?',
	'viewsource' => 'Lee testu',
	'viewsourcetext' => 'Ó bele lee no kopia testu pájina nian:',
	'viewprevnext' => 'Haree ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Versaun',
	'version-specialpages' => 'Pájina espesiál',
	'version-other' => 'Seluk',
	'version-version' => '(Versaun $1)',
	'version-license' => 'Lisensa',
	'version-software-product' => 'Produtu',
	'version-software-version' => 'Versaun',
);

$messages['tg-cyrl'] = array(
	'variants' => 'Вариантҳо',
	'views' => 'Назарот',
	'viewcount' => 'Ин саҳифа {{PLURAL:$1|бор|$1 бор}} дида шудааст.',
	'view-pool-error' => 'Мутаасифона, корсозҳои дар ҳоли ҳозир дучори бори изофӣ ҳастанд.
Теъдоди зиёди аз корбарон талош мекунанд, ки ин саҳифаро бубинанд.
Лутфан қабл аз талош дубора барои дидани ин саҳифа муддате сабр кунед.

$1',
	'versionrequired' => 'Нусхаи $1 аз нармафзори МедиаВики лозим аст',
	'versionrequiredtext' => 'Барои истифодаи ин саҳифа ба нусхаи $1 аз нармафзори МедиаВики ниёз доред. Барои иттилооъ аз нусхаи нармафзори насбшуда дар ин вики ба [[Special:Version|ин саҳифа]] нигаред.',
	'viewsourceold' => 'намоиши манбаъ',
	'viewsourcelink' => 'дидани манбаъ',
	'viewdeleted' => 'Намоиши $1?',
	'viewsource' => 'Намоиши матни вики',
	'viewsourcetext' => 'Шумо метавонед матни викии ин саҳифаро назар кунед ё нусха бардоред:',
	'virus-badscanner' => "Танзимоти бад: пуишгари вируси ношинохта: ''$1''",
	'virus-scanfailed' => 'пуиш номуваффақ (рамзи $1)',
	'virus-unknownscanner' => 'антивируси ношинос:',
	'viewpagelogs' => 'Намоиши гузоришҳои марбута ба ин саҳифа',
	'viewprevnext' => 'Намоиш ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Намоиши саҳифаҳои ҳазфшуда',
	'variantname-tg-latn' => 'lotinī',
	'variantname-tg' => 'кирилликӣ',
	'version' => 'Нусхаи Медиавики',
	'version-extensions' => 'Афзунаҳои насбшуда',
	'version-specialpages' => 'Саҳифаҳои вижа',
	'version-parserhooks' => 'Қолабҳои таҷзеҳгар',
	'version-variables' => 'Мутағйирҳо',
	'version-other' => 'Дигар',
	'version-mediahandlers' => 'Бадастгирандаҳои расонаҳо',
	'version-hooks' => 'Қолабҳо',
	'version-extension-functions' => 'Амалгарҳои афзуна',
	'version-parser-extensiontags' => 'Барчасбҳои афзунаҳои таҷзеҳгар',
	'version-parser-function-hooks' => 'Қолабҳои амалгарҳои таҷзеҳгар',
	'version-hook-name' => 'Номи қолаб',
	'version-hook-subscribedby' => 'Воридшуда тавассути',
	'version-version' => '(Нусха $1)',
	'version-license' => 'Иҷозатнома',
	'version-software' => 'Нусхаи насбшуда',
	'version-software-product' => 'Маҳсул',
	'version-software-version' => 'Нусха',
);

$messages['tg-latn'] = array(
	'variants' => 'Variantho',
	'views' => 'Nazarot',
	'viewcount' => 'In sahifa {{PLURAL:$1|bor|$1 bor}} dida şudaast.',
	'view-pool-error' => "Mutaasifona, korsozhoi dar holi hozir ducori bori izofī hastand.
Te'dodi zijodi az korbaron taloş mekunand, ki in sahifaro bubinand.
Lutfan qabl az taloş dubora baroi didani in sahifa muddate sabr kuned.

$1",
	'versionrequired' => 'Nusxai $1 az narmafzori MediaViki lozim ast',
	'versionrequiredtext' => "Baroi istifodai in sahifa ba nusxai $1 az narmafzori MediaViki nijoz dored. Baroi ittiloo' az nusxai narmafzori nasbşuda dar in viki ba [[Special:Version|in sahifa]] nigared.",
	'viewsourceold' => "namoişi manba'",
	'viewsourcelink' => "didani manba'",
	'viewdeleted' => 'Namoişi $1?',
	'viewsource' => 'Namoişi matni viki',
	'viewsourcetext' => 'Şumo metavoned matni vikiji in sahifaro nazar kuned jo nusxa bardored:',
	'virus-badscanner' => "Tanzimoti bad: puişgari virusi noşinoxta: ''$1''",
	'virus-scanfailed' => 'puiş nomuvaffaq (ramzi $1)',
	'virus-unknownscanner' => 'antivirusi noşinos:',
	'viewpagelogs' => 'Namoişi guzorişhoi marbuta ba in sahifa',
	'viewprevnext' => 'Namoiş ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Namoişi sahifahoi hazfşuda',
	'variantname-tg-latn' => 'lotinī',
	'variantname-tg' => 'kirillikī',
	'version' => 'Nusxai Mediaviki',
	'version-extensions' => 'Afzunahoi nasbşuda',
	'version-specialpages' => 'Sahifahoi viƶa',
	'version-parserhooks' => 'Qolabhoi taçzehgar',
	'version-variables' => 'Mutaƣjirho',
	'version-other' => 'Digar',
	'version-mediahandlers' => 'Badastgirandahoi rasonaho',
	'version-hooks' => 'Qolabho',
	'version-extension-functions' => 'Amalgarhoi afzuna',
	'version-parser-extensiontags' => 'Barcasbhoi afzunahoi taçzehgar',
	'version-parser-function-hooks' => 'Qolabhoi amalgarhoi taçzehgar',
	'version-hook-name' => 'Nomi qolab',
	'version-hook-subscribedby' => 'Voridşuda tavassuti',
	'version-version' => '(Nusxa $1)',
	'version-license' => 'Içozatnoma',
	'version-software' => 'Nusxai nasbşuda',
	'version-software-product' => 'Mahsul',
	'version-software-version' => 'Nusxa',
);

$messages['th'] = array(
	'variants' => 'สิ่งที่แตกต่าง',
	'view' => 'ดู',
	'viewdeleted_short' => 'ดู{{PLURAL:$1|1 การแก้ไขที่ถูกลบ|$1 การแก้ไขที่ถูกลบ}}',
	'views' => 'ดู',
	'viewcount' => 'หน้านี้มีการเข้าชม {{PLURAL:$1|1 ครั้ง|$1 ครั้ง}}',
	'view-pool-error' => 'ขออภัย ขณะนี้มีผู้ใช้งานเซิร์ฟเวอร์มากเกินที่จะรับได้
ผู้ที่พยายามเข้าดูหน้านี้มีจำนวนมากจนเกินไป
กรุณารอสักครู่ก่อนที่จะเข้าดูหน้านี้อีกครั้งหนึ่ง

$1',
	'versionrequired' => 'ต้องการมีเดียวิกิรุ่น $1',
	'versionrequiredtext' => 'ต้องการมีเดียวิกิรุ่น $1 สำหรับใช้งานหน้านี้ ดูเพิ่ม [[Special:Version|รุ่นซอฟต์แวร์]]',
	'viewsourceold' => 'ดูโค้ด',
	'viewsourcelink' => 'ดูโค้ด',
	'viewdeleted' => 'ดู $1',
	'viewsource' => 'ดูโค้ด',
	'viewsource-title' => 'ดูโค้ดสำหรับ $1',
	'viewsourcetext' => 'คุณสามารถดูและคัดลอกโค้ดหน้านี้ได้:',
	'viewyourtext' => "คุณสามารถเปิดดูและคัดลอกต้นฉบับของ '''การแก้ไขของคุณ''' ของหน้านี้ได้",
	'virus-badscanner' => "การตั้งค่าผิดพลาด: ไม่รู้จักตัวสแกนไวรัส: ''$1''",
	'virus-scanfailed' => 'การสแกนล้มเหลว (โค้ด $1)',
	'virus-unknownscanner' => 'ไม่รู้จักโปรแกรมป้องกันไวรัสตัวนี้:',
	'viewpagelogs' => 'ดูบันทึกของหน้านี้',
	'viewprevnext' => 'ดู ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'ไฟล์นี้ไม่ผ่านการพิสูจน์ยืนยันไฟล์',
	'viewdeletedpage' => 'หน้าที่ถูกลบ',
	'version' => 'รุ่นซอฟต์แวร์',
	'version-extensions' => 'ส่วนขยายเพิ่ม (extension) ที่ติดตั้ง',
	'version-specialpages' => 'หน้าพิเศษ',
	'version-parserhooks' => 'ฮุกที่มีการพาร์สค่า',
	'version-variables' => 'ตัวแปร',
	'version-antispam' => 'การป้องกันสแปม',
	'version-skins' => 'รูปลักษณ์',
	'version-other' => 'อื่นๆ',
	'version-mediahandlers' => 'ตัวจัดการเกี่ยวกับสื่อ (media handler)',
	'version-hooks' => 'ฮุก',
	'version-extension-functions' => 'ฟังก์ชันจากส่วนขยายเพิ่ม (extension function)',
	'version-parser-extensiontags' => 'แท็กที่มีการใช้งานของพาร์สเซอร์',
	'version-parser-function-hooks' => 'ฮุกที่มีฟังก์ชันพาร์สเซอร์',
	'version-hook-name' => 'ชื่อฮุก',
	'version-hook-subscribedby' => 'สนับสนุนโดย',
	'version-version' => '(รุ่น $1)',
	'version-license' => 'สัญญาอนุญาต',
	'version-poweredby-credits' => "วิกินี้จัดทำโดย '''[//www.mediawiki.org/ MediaWiki]''', สงวนลิขสิทธิ์ © 2001-$1 โดย $2.",
	'version-poweredby-others' => 'ผู้อื่น',
	'version-license-info' => 'มีเดียวิกิเป็นซอฟต์แวร์เสรี คุณสามารถแจกจ่ายต่อ และ/หรือ แก้ไขโปรแกรมได้ภายใต้เงื่อนไขของ GNU General Public License ที่เผยแพร่โดยมูลนิธิซอฟต์แวร์เสรี ในรุ่นที่ 2 ของใบอนุญาตหรือรุ่นอื่นใด (ตามที่คุณเลือก)

มีเดียวิกิมีการแจกจ่ายโดยหวังว่าจะเป็นประโยชน์ แต่ไม่มีการรับประกันใดๆ ทั้งสิ้น ไม่มีแม้การรับประกันโดยนัยเพื่อการค้า หรือความเหมาะสมสำหรับวัตถุประสงค์เฉพาะ ดู GNU General Public License เพื่อดูรายละเอียดเพิ่มเติม

คุณควรจะได้รับ [{{SERVER}}{{SCRIPTPATH}}/COPYING a copy of the GNU General Public License] พร้อมกับโปรแกรมนี้ หากไม่พบ กรุณาเขียนจดหมายถึง Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA หรือ [//www.gnu.org/licenses/old-licenses/gpl-2.0.html อ่านออนไลน์]',
	'version-software' => 'ซอฟต์แวร์ที่ติดตั้ง',
	'version-software-product' => 'ชื่อ',
	'version-software-version' => 'รุ่น',
);

$messages['tk'] = array(
	'variants' => 'Wariantlar',
	'view' => 'Görkez',
	'views' => 'Keşpler',
	'viewcount' => 'Bu sahypa {{PLURAL:$1|bir|$1 }} gezek görülipdir.',
	'view-pool-error' => 'Gynansak-da, şu wagt serwerler hetdenaşa işli.
Biçak köp ulanyjy şu sahypany görmäge synanyşýar.
Bir sellem garaşyp, soňra synanyşmagyňyzy towakga edýäris.

$1',
	'versionrequired' => 'MediaWikiniň $1 wersiýasy gerek',
	'versionrequiredtext' => 'Version $1 of MediaWiki is required to use this page.
See [[Special:Version|version page]].
Bu sahypany ulanmak üçin MediaWikiniň $1 wersiýasy talap edilýär. [[Special:Version|Wersiýa sahypasyna]] serediň.',
	'viewsourceold' => 'çeşmäni gör',
	'viewsourcelink' => 'çeşmesini gör',
	'viewdeleted' => '$1 gör?',
	'viewsource' => 'Çeşmäni gör',
	'viewsourcetext' => 'Bu sahypanyň çeşmesini görüp hem-de göçürip bilersiňiz:',
	'virus-badscanner' => "Nädogry konfigurasiýa: näbelli wirus skaneri: ''$1''",
	'virus-scanfailed' => 'skanirleme başa barmady (kod $1)',
	'virus-unknownscanner' => 'nätanyş antiwirus:',
	'viewpagelogs' => 'Bu sahypanyň gündeliklerini görkez',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Bu faýl barlag prosedurasyndan geçmedi.',
	'viewdeletedpage' => 'Öçürilen sahypalary görkez',
	'version' => 'Wersiýa',
	'version-extensions' => 'Gurulgy giňeltmeler',
	'version-specialpages' => 'Ýörite sahypalar',
	'version-parserhooks' => 'Analizator ilgençekleri',
	'version-variables' => 'Üýtgeýänler',
	'version-other' => 'Başga',
	'version-mediahandlers' => 'Media işleýjiler',
	'version-hooks' => 'Ilgençekler',
	'version-extension-functions' => 'Giňeltme funksiýalary',
	'version-parser-extensiontags' => 'Analizator giňeltme bellikleri',
	'version-parser-function-hooks' => 'Analizator funsiýasynyň ilgençekleri',
	'version-hook-name' => 'Ilgençegiň ady',
	'version-hook-subscribedby' => 'Abuna ýazylan',
	'version-version' => '(Wersiýa $1)',
	'version-license' => 'Ygtyýarnama',
	'version-poweredby-credits' => "Bu wiki '''[//www.mediawiki.org/ MediaWiki]''' arkaly üpjün edilýär, awtorlyk hukugy © 2001-$1 $2.",
	'version-poweredby-others' => 'beýlekiler',
	'version-license-info' => 'MediaWiki erkin programmadyr; MediaWiki-ni Erkin programma fondy tarapyndan çazp edilen GNU General Public License lisenziýasynyň ikini wersiýasynyň ýa-da (islegiňize görä) has täzeki bir wersiýasynyň şertlerine laýyklykda täzeden paýlap we/ýa-da üýtgedip bilersiňiz.

MediaWiki programmasy peýdaly bolar diýen umyt bilen paýlanylýar, emma onuň üçin hatda TÄJIRÇILIK GYMMATY ýa-da KESGITLENILEN MAKSADA ÝARAMLYLYK boýunça hem hiç hili KEPILLIK BERILMEÝÄR. Has giňişleýin maglumat üçin GNU General Public License lisenziýasyna serediň.

Bu programmanyň ýany bilen siz [{{SERVER}}{{SCRIPTPATH}}/COPYING GNU General Public License lisenziýasynyň bir nusgasyny] hem edinen bolmaly. Eger edinmedik bolsaňyz, onda Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA adresine ýazyň ýa-da  [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lisenziýasyny onlaýn okaň].',
	'version-software' => 'Gurlan programma üpjünçiligi',
	'version-software-product' => 'Önüm',
	'version-software-version' => 'Wersiýa',
);

$messages['tl'] = array(
	'variants' => 'Naiiba pa',
	'view' => 'Tingnan',
	'viewdeleted_short' => 'Tingnan ang {{PLURAL:$1|isang binurang pagbabagp|$1 binurang pagbabago}}',
	'views' => 'Mga anyo',
	'viewcount' => 'Namataan na pahinang ito nang {{PLURAL:$1|isang|$1}} beses.',
	'view-pool-error' => 'Paumanhin, ngunit masyado pong abala ang mga serbidor sa sandaling ito.
Masyadong maraming tagagamit ay sinusubukang tingnan ang pahinang ito.
Mangyari lamang na maghintay po nang sandali bago niyo pong subukang mataanin muli ang pahinang ito.

$1',
	'versionrequired' => 'Kinakailangan ang bersyong $1 ng MediaWiki',
	'versionrequiredtext' => 'Kinakailangan ang bersyong $1 ng MediaWiki upang magamit ang pahinang ito.
Tingnan ang [[Special:Version|pahina ng bersyon]].',
	'viewsourceold' => 'tingnan ang pinagmulan',
	'viewsourcelink' => 'tingnan ang pinagmulan',
	'viewdeleted' => 'Tingnan ang $1?',
	'viewsource' => 'Tingnan ang pinagmulan',
	'viewsource-title' => 'Tingnan ang pinagmulan para sa $1',
	'viewsourcetext' => 'Maaari mong tingnan at kopyahin ang pinagmulan ng pahinang ito:',
	'virus-badscanner' => "Masamang kompigurasyon: hindi kilalang tagahagilap (iskaner) ng birus: ''$1''",
	'virus-scanfailed' => 'nabigo ang paghagilap (kodigong $1)',
	'virus-unknownscanner' => 'hindi kilalang panlaban sa birus:',
	'viewpagelogs' => 'Tingnan ang mga pagtatala para sa pahinang ito',
	'viewprevnext' => 'Tingnan ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Hindi pumasa sa pagpapatunay na pangtalaksan ang ganitong talaksan.',
	'viewdeletedpage' => 'Tingnan ang binurang mga pahina',
	'version' => 'Bersyon',
	'version-extensions' => 'Nakaluklok/Nakainstalang mga karugtong',
	'version-specialpages' => 'Natatanging mga pahina',
	'version-parserhooks' => "Mga pangkawit ng banghay (''parser'')",
	'version-variables' => 'Mga bagay na nababago/nagbabago',
	'version-antispam' => 'Pag-iwas sa masasamang mga e-liham',
	'version-skins' => 'Mga pabalat',
	'version-other' => 'Iba pa',
	'version-mediahandlers' => 'Mga tagahawak/tagapamahala ng midya',
	'version-hooks' => 'Mga pangkawit',
	'version-extension-functions' => 'Mga tungkuling pangkarugtong',
	'version-parser-extensiontags' => "Mga tatak ng banghay (''parser'')",
	'version-parser-function-hooks' => "Mga pangkawit ng/sa tungkuling pambanghay (''parser'')",
	'version-hook-name' => 'Pangalan ng pangkawit',
	'version-hook-subscribedby' => 'Sinuskribi ng/ni/nina',
	'version-version' => '(Bersyon $1)',
	'version-license' => 'Lisensiya',
	'version-poweredby-credits' => "Ang wiking ito ay pinapatakbo ng '''[//www.mediawiki.org/ MediaWiki]''', karapatang-ari © 2001-$1 $2.",
	'version-poweredby-others' => 'iba pa',
	'version-license-info' => 'Ang MediaWiki ay isang malayang sopwer; maaari mo itong ipamahagi at/o baguhin ito sa ilalim ng mga patakaran ng Pangkalahatang Pangmadlang Lisensiyang GNU ayon sa pagkakalathala ng Pundasyon ng Malayang Sopwer; na maaaring bersyong 2 ng Lisensiya, o (kung nais mo) anumang susunod na bersyon.
Ang MediaWiki ay ipinamamahagi na umaasang magiging gamitin, subaliut WALANG ANUMANG KATIYAKAN; ni walang pahiwatig ng PAGIGING MABENTA o KAANGKUPAN PARA ISANG TIYAK NA LAYUNIN.  Tingnan ang Pangkalahatang Pangmadlang Lisensiyang GNU para sa mas marami pang mga detalye.
Dapat na nakatanggap ka ng [{{SERVER}}{{SCRIPTPATH}}/COPYING isang sipi ng Pangkalahatang Pangmadlang Lisensiyang GNU] kasama ang programang ito; kung hindi, sumulat sa Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA o [//www.gnu.org/licenses/old-licenses/gpl-2.0.html basahin ito habang nasa Internet].',
	'version-software' => 'Inistalang software',
	'version-software-product' => 'Produkto',
	'version-software-version' => 'Bersyon',
);

$messages['tn'] = array(
	'viewsource' => 'Lebelela motswedi',
);

$messages['to'] = array(
	'views' => 'Ngaahi vakai',
	'viewcount' => 'Naʻe laua he pēsí ni tuʻo $1.',
	'versionrequired' => "ʻOku pau ko e paaki $1 ʻo e ''MediaWiki''",
	'versionrequiredtext' => "ʻOku pau ʻoku ʻi ai e paaki $1 'o e ''Mediwiki'' ʻi he ngāueʻaki ʻo e pēsí ni. Vakai ki he [[Special:Version]].",
	'viewsourcelink' => 'vakai ki he tupunga',
	'viewdeleted' => 'Vakai ke he $1?',
	'viewsource' => 'Vakai ki he tupunga',
	'viewpagelogs' => 'Vakai ki he ngaahi tohinoa ʻo e pēsí ni',
	'viewprevnext' => 'Vakai ki he ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Vakai ki he ngaahi peesi kuo tāmateʻi',
	'version' => 'Paaki',
);

$messages['tokipona'] = array(
	'viewprevnext' => 'o lukin e ($1 {{int:pipe-separator}} $2) ($3).',
);

$messages['tpi'] = array(
	'views' => 'Ol lukluk',
	'viewsourceold' => 'lukim as tok',
	'viewsourcelink' => 'lukim as tok',
	'viewdeleted' => 'Lukim $1?',
	'viewsource' => 'Lukim as tok',
	'viewpagelogs' => 'Lukim ol ripot bilong dispela pes',
	'viewprevnext' => 'Lukim ($1 {{int:pipe-separator}} $2) ($3)',
	'version-other' => 'Narapela',
	'version-license' => 'Laisens',
	'version-poweredby-others' => 'ol narapela',
);

$messages['tr'] = array(
	'variants' => 'Türevler',
	'view' => 'Görüntüle',
	'viewdeleted_short' => '{{PLURAL:$1|bir silinmiş değişiklik|$1 silinmiş değişiklikleri}} görüntüle.',
	'views' => 'Görünümler',
	'viewcount' => 'Bu sayfaya {{PLURAL:$1|bir|$1 }} defa erişilmiş.',
	'view-pool-error' => 'Üzgünüz, sunucular şu anda aşırı yüklendi.
Birçok kullanıcı bu sayfayı görüntülemeye çalışıyor.
Lütfen bu sayfaya  tekrar erişmeyi denemeden önce biraz bekleyin.

$1',
	'versionrequired' => "MediaWiki'nin $1 sürümü gerekiyor",
	'versionrequiredtext' => "Bu sayfayı kullanmak için MediaWiki'nin $1 versiyonu gerekmektedir. [[Special:Version|Versiyon sayfasına]] bakınız.",
	'viewsourceold' => 'kaynağı gör',
	'viewsourcelink' => 'kaynağı gör',
	'viewdeleted' => '$1 gör?',
	'viewsource' => 'Kaynağı gör',
	'viewsource-title' => '$1 sayfasının kaynağını görüntüle',
	'viewsourcetext' => 'Bu sayfanın kaynağını görebilir ve kopyalayabilirsiniz:',
	'viewyourtext' => "Bu sayfaya '''yaptığınız değişikliklerin''' kaynağını görünteleyip kopyalayabilirsiniz:",
	'virus-badscanner' => "Yanlış ayarlama: bilinmeyen virüs tarayıcı: ''$1''",
	'virus-scanfailed' => 'tarama başarısız (kod $1)',
	'virus-unknownscanner' => 'bilinmeyen antivürüs:',
	'viewpagelogs' => 'Bu sayfa ile ilgili kayıtları göster',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Bu dosya, dosya doğrulamasını geçemedi.',
	'viewdeletedpage' => 'Silinen sayfalara bak',
	'video-dims' => '$1, $2×$3',
	'variantname-tg' => 'tg',
	'version' => 'Sürüm',
	'version-extensions' => 'Yüklü ekler',
	'version-specialpages' => 'Özel sayfalar',
	'version-parserhooks' => 'Derleyici çengelleri',
	'version-variables' => 'Değişkenler',
	'version-antispam' => 'Yığın mesaj (spam) önleme',
	'version-skins' => 'Görünümler',
	'version-other' => 'Diğer',
	'version-mediahandlers' => 'Ortam işleyiciler',
	'version-hooks' => 'Çengeller',
	'version-extension-functions' => 'Ek fonksiyonları',
	'version-parser-extensiontags' => 'Derleyici eklenti etiketleri',
	'version-parser-function-hooks' => 'Derleyici fonksiyon çengelleri',
	'version-hook-name' => 'Çengel adı',
	'version-hook-subscribedby' => 'Abone olan',
	'version-version' => '(Sürüm $1)',
	'version-license' => 'Lisans',
	'version-poweredby-credits' => "Bu wiki '''[//www.mediawiki.org/ MediaWiki]''' programı kullanılarak oluşturulmuştur, telif © 2001-$1 $2.",
	'version-poweredby-others' => 'diğerleri',
	'version-license-info' => "MediaWiki özgür bir yazılımdır; MediaWiki'yi, Özgür Yazılım Vakfı tarafından yayımlanmış olan GNU Genel Kamu Lisansının 2. veya (seçeceğiniz) daha sonraki bir sürümünün koşulları altında yeniden dağıtabilir ve/veya değiştirebilirsiniz.

MediaWiki yazılımı faydalı olacağı ümidiyle dağıtılmaktadır; ancak kastedilen SATILABİLİRLİK veya BELİRLİ BİR AMACA UYGUNLUK garantisi hariç HİÇBİR GARANTİSİ YOKTUR. Daha fazla ayrıntı için GNU Genel Kamu Lisansı'na bakınız.

Bu programla birlikte [{{SERVER}}{{SCRIPTPATH}}/COPYING GNU Genel Kamu Lisansının bir kopyasını] da edinmiş olmalısınız; eğer edinmediyseniz, Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA adresine yazın veya [//www.gnu.org/licenses/old-licenses/gpl-2.0.html lisansı çevrim içi olarak okuyun].",
	'version-software' => 'Yüklü yazılım',
	'version-software-product' => 'Ürün',
	'version-software-version' => 'Versiyon',
);

$messages['ts'] = array(
	'viewsourceold' => 'Languta vutsari-ntumbuluko',
	'viewdeleted' => 'Langutisa $1?',
	'viewsource' => 'Vona tsalwa-tumbuluxa',
);

$messages['tt-cyrl'] = array(
	'variants' => 'Төрләр',
	'view' => 'Карау',
	'viewdeleted_short' => '{{PLURAL:$1|1 бетерелгән үзгәртүне|$1 бетерелгән үзгәртүне}} карау',
	'views' => 'Караулар',
	'viewcount' => 'Бу биткә $1 {{PLURAL:$1|тапкыр}} мөрәҗәгать иттеләр.',
	'view-pool-error' => 'Гафу итегез, хәзерге вакытта серверлар буш түгел.
Бу битне карарга теләүчеләр артык күп.
Бу биткә соңрак керүегез сорала.

$1',
	'versionrequired' => 'MediaWikiның $1 версиясе таләп ителә',
	'versionrequiredtext' => 'Бу бит белән эшләү өчен MediaWikiның $1 версиясе кирәк. [[Special:Version|Кулланылучы программа версиясе турында мәгълүмат битен]] кара.',
	'viewsourceold' => 'башлангыч кодны карау',
	'viewsourcelink' => 'башлангыч кодны карау',
	'viewdeleted' => '$1 карарга телисезме?',
	'viewsource' => 'Карау',
	'viewsource-title' => '$1 битенең яхма текстын карау',
	'viewsourcetext' => 'Сез бу битнең башлангыч текстын карый һәм күчерә аласыз:',
	'virus-badscanner' => "Көйләү хатасы. Билгесез вируслар сканеры: ''$1''",
	'virus-scanfailed' => 'сканерлау хатасы ($1 коды)',
	'virus-unknownscanner' => 'билгесез антивирус:',
	'viewpagelogs' => 'Бу битнең көндәлекләрен карау',
	'viewprevnext' => 'Күрсәтелүе: ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Бу файл әлегә тикшерү узмаган.',
	'viewdeletedpage' => 'Бетерелгән битләрне карау',
	'version' => 'Юрама',
	'version-extensions' => 'Куелган киңәйтүләр',
	'version-specialpages' => 'Махсус битләр',
	'version-other' => 'Башка',
	'version-hook-subscribedby' => 'Түбәндәгеләргә язылган:',
	'version-license' => 'Лицензия',
	'version-software' => 'Урнаштырылган программа белән тәэмин ителешне',
	'version-software-product' => 'Продукт',
	'version-software-version' => 'Версия',
);

$messages['tt-latn'] = array(
	'variants' => 'Törlär',
	'views' => 'Qarawlar',
	'viewcount' => 'Bu bitkä $1 {{PLURAL:$1|tapqır}} möräcäğät ittelär.',
	'view-pool-error' => 'Ğafu itegez, xäzerge waqıtta serverlar buş tügel.
Bu bitne qararğa teläwçelär artıq küp.
Bu bitkä soñaraq kerüegez sorala.

$1',
	'versionrequired' => 'MediaWikinıñ $1 versiäse taläp itelä',
	'versionrequiredtext' => 'Bu bit belän eşläw öçen MediaWikinıñ $1 versiäse kiräk. [[Special:Version|Qullanıluçı programma versiäse turında mäğlümat biten]] qara.',
	'viewsourceold' => 'başlanğıç kodnı qaraw',
	'viewsourcelink' => 'başlanğıç kodnı qaraw',
	'viewdeleted' => '$1 qararğa telisezme?',
	'viewsource' => 'Qaraw',
	'viewsourcetext' => 'Sez bu bitneñ başlanğıç tekstın qarıy häm küçerä alasız:',
	'virus-badscanner' => "Köyläw xatası. Bilgesez viruslar skanerı: ''$1''",
	'virus-scanfailed' => 'skanerlaw xatası ($1 kodı)',
	'virus-unknownscanner' => 'bilgesez antivirus:',
	'viewpagelogs' => 'Bu bitneñ köndäleklären qaraw',
	'viewprevnext' => 'Kürsätelüe: ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Bu fayl älegä tikşerü uzmağan.',
	'viewdeletedpage' => 'Beterelgän bitlärne qaraw',
	'version' => 'Yurama',
	'version-other' => 'Başqa',
	'version-license' => 'Litsenziä',
	'version-software' => "Urnaştırılğan programma belän tä'min iteleşne",
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Versiä',
);

$messages['tyv'] = array(
	'views' => 'Көрүштер',
	'viewdeleted' => '{{grammar:accusative|$1}} көөр?',
	'viewsource' => 'Бажы көөрү',
	'viewprevnext' => '($1 {{int:pipe-separator}} $2) ($3) көөрү',
	'version' => 'Үндүрери',
);

$messages['udm'] = array(
	'viewsource' => 'Кодзэ учкыны',
);

$messages['ug'] = array(
	'viewsource' => 'Кодзэ учкыны',
);

$messages['ug-arab'] = array(
	'variants' => 'ۋارىيانتلار',
	'view' => 'كۆرۈنۈش',
	'viewdeleted_short' => '{{PLURAL:$1|بىر ئۆچۈرۈلگەن تەھرىر|$1 ئۆچۈرۈلگەن تەھرىر}}نى كۆرسەت',
	'views' => 'كۆرۈنۈش',
	'viewcount' => 'بۇ بەت {{PLURAL:$1|بىر قېتىم|$1 قېتىم}}  زىيارەت قىلىندى.',
	'view-pool-error' => 'كەچۈرۈڭ، نۆۋەتتە مۇلازىمىتىرنىڭ يۈكى ئېشىپ كەتتى.
بۇ بەتنى بەك كۆپ ئىشلەتكۈچى كۆرۈشنى سىنىغانلىقتىن بولغان.
بۇ بەتنى قايتا زىيارەت قىلىشتىن ئىلگىرى سەل كۈتۈڭ.

$1',
	'versionrequired' => 'MediaWiki نىڭ $1 نەشرى زۆرۈر',
	'versionrequiredtext' => '$1 نەشرىدىكى MediaWiki بولغاندىلا ئاندىن بۇ بەتنى ئىشلىتەلەيدۇ.

[[Special:Version|نەشر بېتى]] نى كۆرۈڭ.',
	'viewsourceold' => 'مەنبەنى كۆرسەت',
	'viewsourcelink' => 'مەنبەنى كۆرسەت',
	'viewdeleted' => '$1 كۆرسەت؟',
	'viewsource' => 'مەنبەنى كۆرسەت',
	'viewsourcetext' => 'سىز بۇ بەتنى ئەسلى كودىنى كۆرەلەيسىز ۋە كۆچۈرەلەيسىز:',
	'virus-badscanner' => "بۇزۇلغان سەپلىمە: نامەلۇم ۋىرۇسخور: ''$1''",
	'virus-scanfailed' => 'تەكشۈرۈش مەغلۇپ بولدى (كودى $1)',
	'virus-unknownscanner' => 'نامەلۇم ۋىرۇسخور',
	'viewpagelogs' => 'بۇ بەتنىڭ خاتىرىسىنى كۆرسەت',
	'viewprevnext' => 'كۆرسەت ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'ھۆججەت دەلىللەشتىن ئۆتەلمىدى.',
	'viewdeletedpage' => 'ئۆچۈرۈلگەن بەتنى كۆرسەت',
	'version' => 'نەشرى',
	'version-extensions' => 'قاچىلانغان كېڭەيتىلمە',
	'version-specialpages' => 'ئالاھىدە بەتلەر',
	'version-parserhooks' => 'تەھلىلچى ئىلمىكى',
	'version-variables' => 'ئۆزگەرگۈچى مىقدار',
	'version-antispam' => 'ئەخلەتتىن ساقلىنىش',
	'version-skins' => 'تېرەلەر',
	'version-other' => 'باشقا',
	'version-mediahandlers' => 'ۋاسىتە بىر تەرەپ قىلغۇچ',
	'version-hooks' => 'ئىلمەك',
	'version-extension-functions' => 'تەھلىلچى فونكسىيە',
	'version-parser-extensiontags' => 'تەھلىلچى كېڭەيتىلمە خەتكۈچ',
	'version-parser-function-hooks' => 'تەھلىلچى فونكسىيە ئىلمىكى',
	'version-hook-name' => 'ئىلمەك ئاتى',
	'version-hook-subscribedby' => 'ئىمزا قويغۇچى',
	'version-version' => '(نەشرى $1)',
	'version-license' => 'ئىجازەتنامە',
	'version-poweredby-credits' => "بۇ ۋىكىنى '''[//www.mediawiki.org/ MediaWiki]''' تېخنىكىلىق قوللايدۇ، نەشر ھوقۇقى © 2001-$1 $2",
	'version-poweredby-others' => 'باشقا',
	'version-license-info' => 'MediaWiki ئەركىن يۇمشاق دېتال؛ سىز ئەركىن يۇمشاق دېتال ۋەخپىسىنىڭ ئېلان قىلغان GNU ئاممىباپ ئاممىۋى ئىجازەت ماددىلىرىدىكى بەلگىمىلەرگە ئاساسەن، بۇ پىروگراممىنى قايتا تارقىتىپ ياكى ئۆزگەرتەلەيسىز؛ مەيلى سىز مەزكۇر ئىجازەتنامىنىڭ ئىككىنچى نەشرى ياكى (ئۆزىڭىز تاللىغان) خالىغان كۈندە تارقىتىلغان نەشرىنى ئاساس قىلسىڭىز بولۇۋېرىدۇ.

MediaWiki ئىشلىتىش مەقسىتىنى ئاساس قىلىپ ئېلان قىلىنغان، ئەمما ھېچقانداق كاپالەت مەسئۇلىيىتىنى ئۈستىگە ئالمايدۇ؛  سېتىشچانلىق ياكى مۇئەييەن مەقسەت بويىچە ئىشلىتىشچانلىققا كاپالەتلىك قىلمايدۇ. تەپسىلاتىنىGNU ئاممىباپ ئاممىۋى ئىجازەتنامىدىن پايدىلىنىڭ.

سىز مەزكۇر پىروگرامما بىلەن قوشۇپ [{{SERVER}}{{SCRIPTPATH}}/COPYING GNU ئاممىباپ ئاممىۋى ئىجازەتنامە كۆپەيتىلمىسى] نى تاپشۇرۇۋالىسىز؛ ئەگەر بولمىسا، ئەركىن يۇمشاق دېتال ۋەخپىسىگە خەت يېزىڭ: 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA，ياكى[//www.gnu.org/licenses/old-licenses/gpl-2.0.html توردا ئوقۇڭ]',
	'version-software' => 'قاچىلانغان يۇمشاق دېتال',
	'version-software-product' => 'مەھسۇلات',
	'version-software-version' => 'نەشرى',
);

$messages['uk'] = array(
	'variants' => 'Варіанти',
	'view' => 'Перегляд',
	'viewdeleted_short' => 'Переглянути {{PLURAL:$1|одне вилучене редагування|$1 вилучених редагування|$1 вилучених редагувань}}',
	'views' => 'Перегляди',
	'viewcount' => 'Цю сторінку переглядали $1 {{PLURAL:$1|раз|рази|разів}}.',
	'view-pool-error' => 'Вибачте, сервери зараз перевантажені.
Надійшло дуже багато запитів на перегляд цієї сторінки.
Будь ласка, почекайте і повторіть спробу отримати доступ пізніше.

$1',
	'versionrequired' => 'Потрібна MediaWiki версії $1',
	'versionrequiredtext' => 'Для роботи з цією сторінкою потрібна MediaWiki версії $1. Див. [[Special:Version|інформацію про версії програмного забезпечення, яке використовується]].',
	'viewsourceold' => 'переглянути вихідний код',
	'viewsourcelink' => 'переглянути вихідний код',
	'viewdeleted' => 'Переглянути $1?',
	'viewsource' => 'Перегляд',
	'viewsource-title' => 'Перегляд вихідного коду сторінки $1',
	'viewsourcetext' => 'Ви можете переглянути та скопіювати початковий текст цієї сторінки:',
	'viewyourtext' => "Ви можете переглянути або скопіювати вихідний текст '''ваших редагувань''' на цю сторінку:",
	'virus-badscanner' => "Помилка налаштування: невідомий сканер вірусів: ''$1''",
	'virus-scanfailed' => 'помилка сканування (код $1)',
	'virus-unknownscanner' => 'невідомий антивірус:',
	'viewpagelogs' => 'Показати журнали для цієї сторінки',
	'viewprevnext' => 'Переглянути ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Файлу не вдалося пройти процедуру перевірки.',
	'viewdeletedpage' => 'Переглянути видалені сторінки',
	'video-dims' => '$1, $2×$3',
	'variantname-zh-hans' => 'hans',
	'variantname-zh-hant' => 'hant',
	'variantname-zh-cn' => 'cn',
	'variantname-zh-tw' => 'tw',
	'variantname-zh-hk' => 'hk',
	'variantname-zh-mo' => 'mo',
	'variantname-zh-sg' => 'sg',
	'variantname-zh-my' => 'my',
	'variantname-zh' => 'zh',
	'variantname-gan-hans' => 'hans',
	'variantname-gan-hant' => 'hant',
	'variantname-gan' => 'gan',
	'variantname-sr-ec' => 'sr-ec',
	'variantname-sr-el' => 'sr-el',
	'variantname-sr' => 'sr',
	'variantname-kk-kz' => 'kk-kz',
	'variantname-kk-tr' => 'kk-tr',
	'variantname-kk-cn' => 'kk-cn',
	'variantname-kk-cyrl' => 'kk-cyrl',
	'variantname-kk-latn' => 'kk-latn',
	'variantname-kk-arab' => 'kk-arab',
	'variantname-kk' => 'kk',
	'variantname-ku-arab' => 'ku-Arab',
	'variantname-ku-latn' => 'ku-Latn',
	'variantname-ku' => 'ku',
	'variantname-tg-cyrl' => 'tg-Cyrl',
	'variantname-tg-latn' => 'tg-Latn',
	'variantname-tg' => 'tg',
	'variantname-ike-cans' => 'ike-Cans',
	'variantname-ike-latn' => 'ike-Latn',
	'variantname-iu' => 'iu',
	'version' => 'Версія MediaWiki',
	'version-extensions' => 'Установлені розширення',
	'version-specialpages' => 'Спеціальні сторінки',
	'version-parserhooks' => 'Перехоплювачі синтаксичного аналізатора',
	'version-variables' => 'Змінні',
	'version-antispam' => 'Захист від спаму',
	'version-skins' => 'Оформлення',
	'version-api' => 'API',
	'version-other' => 'Інше',
	'version-mediahandlers' => 'Обробники медіа',
	'version-hooks' => 'Перехоплювачі',
	'version-extension-functions' => 'Функції розширень',
	'version-parser-extensiontags' => 'Теги розширень синтаксичного аналізатора',
	'version-parser-function-hooks' => 'Перехоплювачі функцій синтаксичного аналізатора',
	'version-hook-name' => "Ім'я перехоплювача",
	'version-hook-subscribedby' => 'Підписаний на',
	'version-version' => '(Версія $1)',
	'version-svn-revision' => '(r$2)',
	'version-license' => 'Ліцензія',
	'version-poweredby-credits' => "Ця Вікі працює на системі управління вмістом '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'інші',
	'version-license-info' => 'MediaWiki є вільним програмним забезпеченням, ви можете розповсюджувати та/або модифікувати його відповідно до умов GNU General Public License, яка опублікованя фондом вільного програмного забезпечення; або версії 2 Ліцензії, або (на Ваш розсуд) будь-якої наступної версії.

MediaWiki поширюється в надії, що вона буде корисною, але БЕЗ БУДЬ-ЯКИХ ГАРАНТІЙ, навіть без неявної гарантії КОМЕРЦІЙНОЇ ПРИДАТНОСТІ чи ПРИДАТНОСТІ ДЛЯ ПЕВНОЇ МЕТИ. Дивіться GNU General Public License для більш докладної інформації.

Ви повинні були отримати [{{SERVER}}{{SCRIPTPATH}}/COPYING копію GNU General Public License] разом з цією програмою, якщо немає, напишіть у Free Software Foundation, Inc 51 Franklin Street, Fifth Floor , Boston, MA 02110-1301, США або [//www.gnu.org/licenses/old-licenses/gpl-2.0.html прочитайте її онлайн].',
	'version-software' => 'Установлене програмне забезпечення',
	'version-software-product' => 'Продукт',
	'version-software-version' => 'Версія',
);

$messages['ur'] = array(
	'variants' => 'متغیرات',
	'view' => 'منظر',
	'views' => 'خیالات',
	'viewcount' => 'اِس صفحہ تک {{PLURAL:$1|ایک‌بار|$1 مرتبہ}} رسائی کی گئی',
	'view-pool-error' => 'معذرت کے ساتھ، تمام معیلات پر اِس وقت اِضافی بوجھ ہے.
بہت زیادہ صارفین اِس وقت یہ صفحہ ملاحظہ کرنے کی کوشش کررہے ہیں.
برائے مہربانی! صفحہ دیکھنے کیلئے دوبارہ کوشش کرنے سے پہلے ذرا انتظار فرمالیجئے.

$1',
	'versionrequired' => 'میڈیا ویکی کا $1 نسخہ لازمی چاہئیے.',
	'versionrequiredtext' => 'اِس صفحہ کو استعمال کرنے کیلئے میڈیاویکی کا $1 نسخہ چاہئیے.


دیکھئے [[خاص:نسخہ|صفحۂ نسخہ]]',
	'viewsourceold' => 'مآخذ دیکھئے',
	'viewsourcelink' => 'مآخذ دیکھئے',
	'viewdeleted' => 'دیکھیں $1؟',
	'viewsource' => 'مسودہ',
	'viewsourcetext' => 'آپ صرف مسودہ دیکھ سکتے ہیں اور اسکی نقل اتار سکتے ہیں:',
	'virus-badscanner' => "خراب وضعیت: انجان وائرسی مفراس: ''$1''",
	'virus-scanfailed' => 'تفریس ناکام (رمز $1)',
	'virus-unknownscanner' => 'انجان ضدوائرس:',
	'viewpagelogs' => 'اس صفحہ کیلیے نوشتہ جات دیکھیے',
	'viewprevnext' => 'دیکھیں($1 {{int:pipe-separator}} $2) ($3)۔',
	'viewdeletedpage' => 'حذف شدہ صفحات دیکھیے',
	'version' => 'ورژن',
);

$messages['uz'] = array(
	'view' => 'Koʻrish',
	'views' => "Ko'rinishlar",
	'viewcount' => 'Bu sahifaga {{PLURAL:$1|bir marta|$1 marta}} murojaat qilingan.',
	'viewsourcelink' => 'manbasini koʻr',
	'viewsource' => "Ko'rib chiqish",
	'viewsourcetext' => "Siz bu sahifaning manbasini ko'rishingiz va uni nusxasini olishingiz mumkin:",
	'viewpagelogs' => 'Ushbu sahifaga doir qaydlarni koʻrsat',
	'viewprevnext' => "Ko'rish ($1 {{int:pipe-separator}} $2) ($3).",
);

$messages['val'] = array(
	'views' => 'Vistes',
	'viewcount' => 'Esta pàgina ha segut visitada {{plural:$1|una vegada|$1 vegaes}}.',
	'versionrequired' => 'Fa falta la versió $1 del MediaWiki',
	'versionrequiredtext' => 'Fa falta la versió $1 del MediaWiki per a utilisar esta pàgina. mira [[Special:Version]]',
	'viewdeleted' => 'Vols mostrar $1?',
	'viewsource' => 'Mostra la font',
	'viewsourcefor' => 'per a $1',
	'viewsourcetext' => "Pots visualisar i copiar la font d'esta pàgina:",
	'viewpagelogs' => "Visualisa els registres d'esta pàgina",
	'viewprevnext' => 'Anar a ($1) ($2) ($3).',
	'version' => 'Versió',
	'viewdeletedpage' => 'Visualisa les pàgines eliminades',
);

$messages['ve'] = array(
	'version-other' => 'Zwiṅwe',
);

$messages['vec'] = array(
	'variants' => 'Varianse',
	'views' => 'Visite',
	'viewcount' => 'Sta pagina la xe stà leta {{PLURAL:$1|na olta|$1 olte}}.',
	'view-pool-error' => 'En sto momento i server i xè sovracarichi.
Tropi utenti i sta tentando de visuałisare sta pajina.
Atendare qualche minudo prima de riprovare a cargare ła pajina.

$1',
	'versionrequired' => 'Version $1 de MediaWiki richiesta',
	'versionrequiredtext' => "Par usare sta pajina xè nesesario dispore de ła version $1 del software MediaWiki. Varda [[Special:Version|l'aposita pajina]].",
	'viewsourceold' => 'varda el testo',
	'viewsourcelink' => 'varda el testo',
	'viewdeleted' => 'Varda $1?',
	'viewsource' => 'Varda el testo',
	'viewsourcetext' => 'Se pole vardar e copiar el testo de sta pagina:',
	'virus-badscanner' => 'Erore de configurasion: antivirus sconossuo: "$1"',
	'virus-scanfailed' => 'scansion fałia (codexe $1)',
	'virus-unknownscanner' => 'antivirus sconossuo:',
	'viewpagelogs' => 'Varda i registri de sta pagina',
	'viewprevnext' => 'Varda ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => "Sto file no'l gà passà la verifica.",
	'viewdeletedpage' => 'Varda łe pàxene scancełàe',
	'version' => 'Version',
	'version-extensions' => 'Estension instalè',
	'version-specialpages' => 'Pagine speciali',
	'version-parserhooks' => 'Hook del parser',
	'version-variables' => 'Variabili',
	'version-other' => 'Altro',
	'version-mediahandlers' => 'Gestori de contenuti multimediài',
	'version-hooks' => 'Hook',
	'version-extension-functions' => 'Funzion introdote da estensioni',
	'version-parser-extensiontags' => 'Tag riconossiùi dal parser introdoti da estensioni',
	'version-parser-function-hooks' => 'Hook par funzioni del parser',
	'version-hook-name' => "Nome de l'hook",
	'version-hook-subscribedby' => 'Sotoscrizioni',
	'version-version' => '(Version $1)',
	'version-license' => 'Licensa',
	'version-poweredby-credits' => "Sta wiki la va con '''[//www.mediawiki.org/ MediaWiki]''', copyright © 2001-$1 $2.",
	'version-poweredby-others' => 'altri',
	'version-license-info' => "MediaWiki xe un software lìbaro; te pol redistribuirlo e/o modificarlo secondo i termini de la Licensa Publica Zeneral GNU publicà da la Free Software Foundation; secondo la version 2 de la Licensa, o (a scelta tua) una qualunque altra version sucessiva.

MediaWiki el xe distribuìo sperando che el possa vegner utile, ma SENSA NISSUNA GARANSIA; sensa gnanca la garansia inplicita de COMERCIALIZASSION o de ADATAMENTO A UN USO PARTICOLARE. Varda la Licensa Publica Zeneral GNU par ulteriori detagli.

Insieme co sto programa te dovaressi 'ver ricevùo na copia de la Licensa Publica Zeneral GNU; se nò, scrìveghe a la Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA o [//www.gnu.org/licenses/old-licenses/gpl-2.0.html và a lèzartela online].",
	'version-software' => 'Software instalà',
	'version-software-product' => 'Prodoto',
	'version-software-version' => 'Version',
);

$messages['vep'] = array(
	'variants' => 'Variantad',
	'view' => 'Nähta',
	'views' => 'Kacundad',
	'viewcount' => "Nece lehtpol' kaceltihe {{PLURAL:$1|kerdal|$1 kerdad}}.",
	'view-pool-error' => "Pakičem armahtust!
Serverad oma üläkormatud.
Äjahk kävutajid lattäs kacta necidä lehtpol't.
Varastagat pordon aigad i lat'kät pörttas lehtpolele.

$1",
	'versionrequired' => 'Pidab kävutada MediaWikin $1 versii',
	'versionrequiredtext' => 'Pidab kävutada MedaWikin $1-versii necen lehtpolen kactes.
Kacu [[Special:Version|informacii kävutadud versijoiš]].',
	'viewsourceold' => 'kacta augotižkod',
	'viewsourcelink' => 'kacta augotižkod',
	'viewdeleted' => 'Kacta $1?',
	'viewsource' => 'Kc. purde',
	'viewsource-title' => 'Ozutada $1-lehtpolen lähtmižtekst',
	'viewsourcetext' => 'Sab lugeda da kopiruida necen lehtpolen augotižtekst:',
	'virus-badscanner' => "Järgendusen petuz: tundmatoi virusoiden skaner: ''$1''",
	'virus-scanfailed' => 'Skaniruindan petuz (kod $1)',
	'virus-unknownscanner' => 'tundmatoi antivirus:',
	'viewpagelogs' => 'Ozutada aigkirjad necen lehtpolen täht',
	'viewprevnext' => 'Kacta ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => 'Nece fail ei völ sanu vahvištust.',
	'viewdeletedpage' => 'Lugeda čutud lehtpolid',
	'video-dims' => '$1, $2×$3',
	'variantname-zh-hans' => 'hans',
	'version' => 'Versii',
	'version-extensions' => 'Seižutadud ližad',
	'version-specialpages' => 'Specialižed lehtpoled',
	'version-parserhooks' => 'Sintaksižen analizatoran sabustajad',
	'version-variables' => 'Vajehtujad lugud',
	'version-skins' => 'Nägutemad',
	'version-other' => 'Toine',
	'version-mediahandlers' => 'Median radimed',
	'version-hooks' => 'Sabutajad',
	'version-extension-functions' => 'Ližoiden funkcijad',
	'version-parser-extensiontags' => 'Sintaksižen analizatoran ližoiden virgad',
	'version-parser-function-hooks' => 'Sintaksižen analizatoran funkcijoiden sabutajad',
	'version-hook-name' => 'Sabustajan nimi',
	'version-hook-subscribedby' => 'Ezipakitoitajad',
	'version-version' => '(Versii $1)',
	'version-license' => 'Licenzii',
	'version-poweredby-others' => 'toižed',
	'version-software' => 'Seižutadud programmišt',
	'version-software-product' => 'Produkt',
	'version-software-version' => 'Versii',
);

$messages['vi'] = array(
	'variants' => 'Biến thể',
	'view' => 'Xem',
	'viewdeleted_short' => 'Xem {{PLURAL:$1|sửa đổi|$1 sửa đổi}} đã xóa',
	'views' => 'Xem',
	'viewcount' => 'Trang này đã được đọc {{PLURAL:$1|một|$1}} lần.',
	'view-pool-error' => 'Xin lỗi, máy chủ hiện đang bị quá tải.
Có quá nhiều thành viên đang cố gắng xem trang này.
Xin hãy đợi một lát rồi thử truy cập lại vào trang.

$1',
	'versionrequired' => 'Cần phiên bản $1 của MediaWiki',
	'versionrequiredtext' => 'Cần phiên bản $1 của MediaWiki để sử dụng trang này. Xem [[Special:Version|trang phiên bản]].',
	'viewsourceold' => 'xem mã nguồn',
	'viewsourcelink' => 'xem mã nguồn',
	'viewdeleted' => 'Xem $1?',
	'viewsource' => 'Xem mã nguồn',
	'viewsource-title' => 'Xem mã nguồn của $1',
	'viewsourcetext' => 'Bạn vẫn có thể xem và chép xuống mã nguồn của trang này:',
	'viewyourtext' => "Bạn vẫn có thể xem và chép xuống mã nguồn '''các sửa đổi của bạn''' tại trang này:",
	'virus-badscanner' => "Cấu hình sau: không nhận ra bộ quét virus: ''$1''",
	'virus-scanfailed' => 'quét thất bại (mã $1)',
	'virus-unknownscanner' => 'không nhận ra phần mềm diệt virus:',
	'viewpagelogs' => 'Xem nhật trình của trang này',
	'viewprevnext' => 'Xem ($1 {{int:pipe-separator}} $2) ($3).',
	'verification-error' => 'Tập tin này không qua được bước thẩm tra.',
	'viewdeletedpage' => 'Xem các trang bị xóa',
	'variantname-zh-hans' => 'Giản thể',
	'variantname-zh-hant' => 'Phồn thể',
	'variantname-zh-cn' => 'Giản thể Hoa Lục',
	'variantname-zh-tw' => 'Phồn thể Đài Loan',
	'variantname-zh-hk' => 'Phồn thể Hồng Kông',
	'variantname-zh-mo' => 'Phồn thể Ma Cao',
	'variantname-zh-sg' => 'Giản thể Singapore',
	'variantname-zh-my' => 'Giản thể Mã Lai',
	'variantname-zh' => 'Không chuyển tự',
	'variantname-gan-hans' => 'Giản thể',
	'variantname-gan-hant' => 'Phồn thể',
	'variantname-gan' => 'Cám nguyên văn',
	'variantname-kk-cyrl' => 'Kirin',
	'variantname-kk-latn' => 'Latinh',
	'variantname-kk-arab' => 'Ả Rập',
	'variantname-ku-arab' => 'Ả Rập',
	'variantname-ku-latn' => 'Latinh',
	'variantname-tg-cyrl' => 'Kirin',
	'variantname-tg-latn' => 'Latinh',
	'variantname-ike-cans' => 'Âm tiết Thổ dân Canada',
	'variantname-ike-latn' => 'Latinh',
	'variantname-shi-tfng' => 'Tifinagh',
	'variantname-shi-latn' => 'Latinh',
	'version' => 'Phiên bản',
	'version-extensions' => 'Các phần mở rộng được cài đặt',
	'version-specialpages' => 'Trang đặc biệt',
	'version-parserhooks' => 'Hook trong bộ xử lý',
	'version-variables' => 'Biến',
	'version-antispam' => 'Chống spam',
	'version-skins' => 'Hình dạng',
	'version-other' => 'Phần mở rộng khác',
	'version-mediahandlers' => 'Bộ xử lý phương tiện',
	'version-hooks' => 'Các hook',
	'version-extension-functions' => 'Hàm mở rộng',
	'version-parser-extensiontags' => 'Thẻ mở rộng trong bộ xử lý',
	'version-parser-function-hooks' => 'Hook cho hàm cú pháp trong bộ xử lý',
	'version-hook-name' => 'Tên hook',
	'version-hook-subscribedby' => 'Được theo dõi bởi',
	'version-version' => '(Phiên bản $1)',
	'version-license' => 'Giấy phép bản quyền',
	'version-poweredby-credits' => "Wiki này chạy trên '''[//www.mediawiki.org/ MediaWiki]''', bản quyền © 2001–$1 $2.",
	'version-poweredby-others' => 'những người khác',
	'version-license-info' => "MediaWiki là phần mềm tự do; bạn được phép tái phân phối và/hoặc sửa đổi nó theo những điều khoản của Giấy phép Công cộng GNU do Quỹ Phần mềm Tự do xuất bản; phiên bản 2 hay bất kỳ phiên bản nào mới hơn nào của Giấy phép.

MediaWiki được phân phối với hy vọng rằng nó sẽ hữu ích, nhưng '''không có bất kỳ một bảo đảm nào cả''', ngay cả những bảo đảm ngụ ý cho '''các mục đích thương mại''' hoặc cho '''một mục đích đặc biệt nào đó'''. Xem Giấy phép Công cộng GNU để biết thêm chi tiết.

Có lẽ bạn đã nhận [{{SERVER}}{{SCRIPTPATH}}/COPYING bản sao Giấy phép Công cộng GNU] đi kèm với tác phẩm này; nếu không, hãy viết thư đến:
 Free Software Foundation, Inc.
 51 Franklin St., Fifth Floor
 Boston, MA 02110-1301
 USA
hoặc [//www.gnu.org/licenses/old-licenses/gpl-2.0.html đọc nó trực tuyến].",
	'version-software' => 'Phần mềm được cài đặt',
	'version-software-product' => 'Phần mềm',
	'version-software-version' => 'Phiên bản',
);

$messages['vls'] = array(
	'viewsourceold' => 'Brontekst bekykn',
	'viewsourcelink' => 'Brontekst bekykn',
	'viewsource' => 'Brontekst bekykn',
);

$messages['vmf'] = array(
	'variants' => 'Warjandn',
	'views' => 'Ôôsichdn',
	'viewcount' => 'Dii sajdn is bis jeds {{PLURAL:$1|aamôôl|$1-môôl}} fârlangd wôrn.',
	'view-pool-error' => "Schaad, di särwa ghumn grôd ned nôôch, wal dsfiil lajd dii
sajdn ham woln. Ward n'bôôr minuudn un brobiir's dan nochâmôôl.

$1",
	'versionrequired' => "S'brauchd dii wärsjoon $1 fon MediaWiki.",
	'viewsourceold' => 'Wighidhägsd dsajchn',
	'viewsourcelink' => 'Wighidhägsd dsjachn',
	'viewdeleted' => '$1 dsajchn?',
	'viewsource' => 'Gwäl-dhägsd ôôgugn',
	'viewpagelogs' => 'Logbicher fär dii sajdn dsajchn',
	'viewprevnext' => 'Dsajch ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['vo'] = array(
	'views' => 'Logams',
	'viewcount' => 'Pad at pelogon {{PLURAL:$1|balna|$1na}}.',
	'versionrequired' => 'Fomam: $1 ela MediaWiki paflagon',
	'versionrequiredtext' => 'Fomam: $1 ela MediaWiki zesüdon ad gebön padi at. Logolös [[Special:Version|fomamapadi]].',
	'viewsourceold' => 'logön fonätavödemi',
	'viewsourcelink' => 'logedön fonäti',
	'viewdeleted' => 'Logön eli $1?',
	'viewsource' => 'Logön fonäti',
	'viewsourcefor' => 'tefü $1',
	'viewsourcetext' => 'Kanol logön e kopiedön fonätakoti pada at:',
	'virus-badscanner' => "Parametem badik: program tavirudik nesevädik: ''$1''",
	'virus-scanfailed' => 'skrutam no eplöpon (kot $1)',
	'virus-unknownscanner' => 'program tavirudik nesëvadik:',
	'viewpagelogs' => 'Jonön jenotalisedis pada at',
	'viewprevnext' => 'Logön padis ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Jonön padis pemoüköl',
	'version' => 'Fomam',
	'version-extensions' => 'Veitükumams pestitöl',
	'version-specialpages' => 'Pads patik',
	'version-other' => 'Votik',
	'version-hooks' => 'Huköms',
	'version-hook-name' => 'Hukömanem',
	'version-hook-subscribedby' => 'Pagebon fa',
	'version-version' => '(Fomam $1)',
	'version-license' => 'Dälazöt',
	'version-software' => 'Programs pestitöl',
	'version-software-product' => 'Prodäd',
	'version-software-version' => 'Fomam',
);

$messages['vot'] = array(
	'views' => 'Prestavleńńõd',
	'viewsourcelink' => 'lähtekoodi',
	'viewsource' => 'Lähtekoodi',
	'viewpagelogs' => 'Näüt sene tšüľľee logid',
	'viewprevnext' => 'Näüt ($1 {{int:pipe-separator}} $2) ($3)',
);

$messages['vro'] = array(
	'variants' => 'Tõõsõndiq',
	'view' => 'Näütäq',
	'viewdeleted_short' => 'Kaeq {{PLURAL:$1|ütte|$1}} kistutõdut redaktsiooni',
	'views' => 'Kaemisõq',
	'viewcount' => 'Seo lehe pääl om käüt $1 {{PLURAL:$1|kõrd|kõrda}}.',
	'view-pool-error' => "Serveriq ommaq parhilla üle koormaduq.
Pall'o hulga pruukjit pruuv kõrraga seod lehte kaiaq.
Olõq hää, oodaq vähäkese inne ku vahtsõst proomit.

$1",
	'versionrequired' => 'Om vaia MediaWiki kujjo $1',
	'versionrequiredtext' => 'Seo lehe kaemisõs om vaia MediaWiki kujjo $1. Kaeq [[Special:Version|kujoteedüst]].',
	'viewsourceold' => 'näütäq lättekuudi',
	'viewsourcelink' => 'kaeq lätteteksti',
	'viewdeleted' => 'Näüdädäq $1?',
	'viewsource' => 'Kaeq lätteteksti',
	'viewsourcetext' => 'Võit kaiaq ja kopidaq taa lehe lättekoodi:',
	'virus-badscanner' => "Viga säädmiisin: tundmalda viirusõkaidsõq: ''$1''",
	'virus-scanfailed' => 'viirusõotsminõ lää-s kõrda (viakuud $1)',
	'virus-unknownscanner' => 'tundmalda viirusõkaidsõq:',
	'viewpagelogs' => 'Kaeq seo lehe muutmisnimekirjä.',
	'viewprevnext' => 'Näütäq ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Kaeq kistutõduid lehti',
	'version' => 'Kujo',
	'version-version' => '(Kujo $1)',
	'version-software-version' => 'Kujo',
);

$messages['wa'] = array(
	'views' => 'Vuwes',
	'viewcount' => 'Cisse pådje la a stî léjhowe {{PLURAL:$1|on côp|$1 côps}}.',
	'view-pool-error' => "Mande escuze, les sierveus sont fortcherdjîs pol moumint.
Gn a trop d' uzeus ki saynut di vey cisse pådje ci.
Soeyoz vayant di ratinde ene miete divant di rsayî di vey cisse pådje ci.

$1",
	'versionrequired' => "I vs fåt l' modêye $1 di MediaWiki",
	'versionrequiredtext' => "I vs fåt l' modêye $1 di MediaWiki po-z eployî cisse pådje ci. Loukîz a [[Special:Version]]",
	'viewsourcelink' => 'Vey côde sourdant',
	'viewdeleted' => 'Vey $1?',
	'viewsource' => 'Vey côde sourdant',
	'viewsourcetext' => 'Loukîz li contnou di l’ årtike, et s’ li rcopyî si vos vloz, por vos bouter dsu foû des fyis :',
	'viewpagelogs' => 'Vey les djournås po cisse pådje ci',
	'viewprevnext' => 'Vey ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Vey les disfacêyès pådjes',
	'version' => 'Modêye des programes',
);

$messages['war'] = array(
	'variants' => 'Mga pagkadirudilain',
	'view' => 'Kitaa',
	'viewdeleted_short' => '{{PLURAL:$1|usa nga ginpara nga pagliwat|$1 ka ginpara nga mga pagliwat}}',
	'views' => 'Mga paglantaw',
	'viewcount' => 'Ini nga pakli ginkanhi hin {{PLURAL:$1|makausa|$1 ka beses}}.',
	'view-pool-error' => 'Pasayloa, an mga server diri na kaya yana nga takna.
Damo nga nagamit in gusto sinmulod hini nga pakli.
Alayon paghulat makadali san-o ka inmutro pagsulod hin nga pakli utro.

$1',
	'versionrequired' => 'Kinahanglan an Bersion $1 han MediaWiki',
	'versionrequiredtext' => 'Kinahanglan an Bersyon $1 han MediaWiki ha paggamit hini nga pakli.  Kitaa an [[Special:Version|bersyon nga pakli]].',
	'viewsourceold' => 'kitaa an ginkuhaan',
	'viewsourcelink' => 'kitaa an ginkuhaan',
	'viewdeleted' => '¿Kitaa in $1?',
	'viewsource' => 'Kitaa an ginkuhaan',
	'viewsourcetext' => 'Puydi ka kinmita ngan kinmopya han gintikangan han pakli:',
	'virus-unknownscanner' => 'diri-nasasabtan nga antivirus:',
	'viewpagelogs' => 'Kitaa an mga log para hini nga pakli',
	'viewprevnext' => 'Kitaa an ($1 {{int:pipe-separator}} $2) ($3)',
	'version' => 'Bersyon',
	'version-license' => 'Lisensya',
	'version-software-product' => 'Produkto',
);

$messages['wo'] = array(
	'variants' => 'Wuute',
	'views' => 'Xool yo',
	'viewcount' => 'Xët wii nemmeeku nañ ko {{PLURAL:$1|$1 yoon|$1 yoon}}.',
	'view-pool-error' => 'jéggalu, joxekaay yi dañoo xat nii-nii.
Jëfandikukat yiy jéem a ubbi xët wii dañoo bari.
Taaxiirlul ba ci kanam nga jéemaat.

$1',
	'versionrequired' => 'Laaj na $1 sumbub MediaWiki',
	'versionrequiredtext' => 'Laaj na $1 sumbum MediaWiki ngir man a jëfandikoo wii xët. Xoolal [[Special:Version|fii]]',
	'viewsourceold' => 'Xool gongikuwaayam',
	'viewsourcelink' => 'xool gongikuwaayam',
	'viewdeleted' => 'Xool $1 ?',
	'viewsource' => 'Xool gongikuwaayam',
	'viewsourcetext' => 'Man ngaa xool te duppi li nekk ci bii jukki ngir man cee liggéey :',
	'virus-badscanner' => "Tànnéef wu bon: saytukatu wiris bees xamul: ''$1''",
	'virus-scanfailed' => 'Saytu gi dog na (code $1)',
	'viewpagelogs' => 'Xool yéenekaayu xët wii',
	'viewprevnext' => 'Xool ($1 {{int:pipe-separator}} $2) ($3).',
	'viewdeletedpage' => 'Xool xët yi ñu far',
);

$messages['wuu'] = array(
	'variants' => '变量',
	'views' => '查看',
	'viewcount' => '迭只页面已经拨浏览过$1趟。',
	'view-pool-error' => '弗好意思，服务器现在过载，请等歇再访问。

$1',
	'versionrequired' => '需要$1版本个MediaWiki',
	'versionrequiredtext' => '要$1版本个MediaWiki再好使用此页。参见[[Special:Version|版本页]]。',
	'viewsourceold' => '查看源码',
	'viewsourcelink' => '查看源码',
	'viewdeleted' => '望望$1看？',
	'viewsource' => '源码',
	'viewsourcetext' => '侬可以查看搭仔复制箇只页面个源码：',
	'virus-badscanner' => "设置问题：未知个反病毒扫描器：''$1''",
	'virus-scanfailed' => '扫描失败（代码 $1）',
	'virus-unknownscanner' => '未知个反病毒扫描器：',
	'viewpagelogs' => '查看该页面日志',
	'viewprevnext' => '查看（$1 {{int:pipe-separator}} $2）（$3）',
	'viewdeletedpage' => '望望删脱个页面',
	'variantname-zh-tw' => '台湾',
	'version' => '版本',
);

$messages['xal'] = array(
	'variants' => 'Суңһлтс',
	'views' => 'Хәләврүд',
	'viewcount' => 'Тер халхд $1 {{PLURAL:$1|дәкҗ|дәкҗ|дәкҗ}} орҗ.',
	'view-pool-error' => 'Гемим тәвтн, ода серверүд хар-хату көдлмштә.
Дегд дала күн тер халх үзхәр бәәнә.
Буйн болтха, бәәҗәһәд дәкәд арһ хәәтн.

$1',
	'versionrequired' => "MediaWiki'н $1 һарц кергтә",
	'versionrequiredtext' => "Тер халх олзхар, MediaWiki'н $1 һарц кергтә.
[[Special:Version|Һарца халх]] хәләтн.",
	'viewsourceold' => 'ишиг үзх',
	'viewsourcelink' => 'ишиг хәләх',
	'viewdeleted' => '$1 үзүлхү?',
	'viewsource' => 'Ишиг хәләх',
	'virus-unknownscanner' => 'медгдго антивирус:',
	'viewpagelogs' => 'Тер халхна сеткүлдүд үзүлх',
	'viewprevnext' => 'Гүүһәд хәләх ($1 {{int:pipe-separator}} $2) ($3)',
	'version-software-product' => 'Һарц',
	'version-software-version' => 'Һарц',
);

$messages['xh'] = array(
	'viewsource' => 'Jonga i Source',
);

$messages['xmf'] = array(
	'variants' => 'ვარიანტეფი',
	'views' => 'ძირაფეფი',
	'viewsourceold' => 'წყუშ ძირაფა',
	'viewsourcelink' => 'ქოძირი წყუ',
	'viewsource' => 'ქოძირი წყუ',
	'viewsourcetext' => 'თქვა შეილებუნა ქოძირათ თე ხასჷლაშ დაჭყაფური ფაილი დო ქუდარსხუათ თიშ მანგი:',
	'viewpagelogs' => 'თე ხასილაშო ორეგისტრაციე ჟურნალეფიშ ძირაფა',
	'viewprevnext' => 'ქოძირ  ($1 {{int:pipe-separator}} $2) ($3).',
	'version' => 'ვერსია',
);

$messages['yi'] = array(
	'variants' => 'װאַריאַנטן',
	'view' => 'באַקוקן',
	'viewdeleted_short' => 'באַקוקן {{PLURAL:$1|איין געמעקטע ענדערונג|$1 געמעקטע ענדערונגען}}',
	'views' => 'קוקן',
	'viewcount' => 'דער בלאט איז געווארן געליינט {{PLURAL:$1|איין מאל|$1 מאל}}.',
	'view-pool-error' => 'אנטשולדיגט, די סערווערס זענען איבערגעפילט איצט.
צופיל באניצער פרובירן צו ליינען דעם בלאט.
ביטע ווארטן א ביסל צייט בעפאר איר פרובירט ווידער אריינגיין אינעם בלאט.

$1',
	'versionrequired' => 'ווערסיע $1 פֿון מעדיעוויקי געפֿאדערט',
	'versionrequiredtext' => 'ווערסיע $1 פֿון מעדיעוויקי איז געפֿאדערט צו ניצן דעם בלאט.
פֿאר מער אינפֿארמאציע זעט [[Special:Version|ווערסיע בלאט]].',
	'viewsourceold' => 'ווײַזן מקור',
	'viewsourcelink' => 'ווײַזן מקור',
	'viewdeleted' => 'זען $1?',
	'viewsource' => 'ווײַזן מקור',
	'viewsource-title' => 'באקוקן מקור פֿון $1',
	'viewsourcetext' => 'איר קענט זען און קאפירן דעם מקור פון דעם בלאַט:',
	'viewyourtext' => "איר קענט באקוקן דעם מקור פון '''אייערע רעדאקטירונגען''' צו דעם בלאט:",
	'virus-badscanner' => "שלעכטע קאנפֿיגוראציע: אומבאוואוסטער ווירוס איבערקוקער: ''$1''",
	'virus-scanfailed' => 'איבערקוקן נישט געראטן (קאד: $1)',
	'virus-unknownscanner' => 'אומבאוואוסטער אנטי־ווירוס:',
	'viewpagelogs' => 'װײַזן לאָג-ביכער פֿאַר דעם בלאַט',
	'viewprevnext' => 'קוקט אויף ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'זען אויסגעמעקטע בלעטער',
	'version' => 'ווערסיע',
	'version-specialpages' => 'ספעציעלע בלעטער',
	'version-variables' => 'וואַריאַבלען',
	'version-other' => 'אנדער',
	'version-version' => '(ווערסיע $1)',
	'version-license' => 'ליצענץ',
	'version-poweredby-others' => 'אַנדערע',
	'version-software' => 'אינסטאַלירט ווייכוואַרג',
	'version-software-product' => 'פראדוקט',
	'version-software-version' => 'ווערסיע',
);

$messages['yo'] = array(
	'views' => 'Àwọn ìfihàn',
	'viewcount' => 'A ti wo ojúewé yi ni {{PLURAL:$1|ẹ̀kan péré|iye ìgbà $1}}.',
	'view-pool-error' => 'Àforíjì, ẹ̀rọ ìwọ̀fà ti kún lọ́wọ́ báyìí.
Ọ̀pọ̀lọpọ̀ àwọn oníṣe úngbìyànjú láti wo ojúewé yìí.
Ẹ jọ̀wọ́ ẹ dúro ná díẹ̀ kí ẹ tó tún gbìyànjú láti wo ojúewé yìí.

$1',
	'versionrequired' => 'Àtẹ̀jáde $1 ti MediaWiki ṣe dandan',
	'versionrequiredtext' => 'Àtẹ̀jáde $1 ti MediaWiki ṣe dandan láti lo ojúewé yìí.
Ẹ wo [[Special:Version|ojúewé àtẹ̀jáde]].',
	'viewsourceold' => 'wo àmìọ̀rọ̀',
	'viewsourcelink' => 'wo àmìọ̀rọ̀',
	'viewdeleted' => 'Ẹ wo $1?',
	'viewsource' => 'Wo àmìọ̀rọ̀',
	'viewsourcefor' => 'fún $1',
	'viewsourcetext' => 'Ẹ lè wo ati ẹ lè se àwòkọ ọ̀rọ̀àmì ojúewé yi:',
	'virus-scanfailed' => 'ìkúnà scan (àmìọ̀rọ̀ $1)',
	'virus-unknownscanner' => 'ògùn-kòkòrò àìmọ̀:',
	'viewpagelogs' => 'Ẹ wo àkọsílẹ̀ ìṣẹ̀lẹ̀ fún ojúewé yìí',
	'viewprevnext' => 'Ẹ wo ($1 {{int:pipe-separator}} $2) ($3)',
	'viewdeletedpage' => 'Wíwò àwọn ojúewé tí a ti parẹ́',
	'version' => 'Àtẹ̀jáde',
	'version-specialpages' => 'Àwọn ojúewé pàtàkì',
	'version-other' => 'Òmíràn',
	'version-version' => '(Àtẹ̀jáde $1)',
	'version-license' => 'Ìwé àṣẹ',
	'version-software-version' => 'Àtẹ̀jáde',
);

$messages['yue'] = array(
	'variants' => '變換',
	'view' => '去睇',
	'viewdeleted_short' => '去睇$1次刪除咗嘅修改',
	'views' => '去睇',
	'viewcount' => '呢一頁已經有$1人次睇過。',
	'view-pool-error' => '對唔住，個伺服器響呢段時間超出咗負荷。
太多用戶試過去睇呢一版。
響再睇呢一版之前請等多一陣。

$1',
	'versionrequired' => '係需要用 $1 版嘅 MediaWiki',
	'versionrequiredtext' => '要用呢一頁，要用MediaWiki版本 $1 。睇睇[[Special:Version|版本頁]]。',
	'viewsourceold' => '睇吓原始碼',
	'viewsourcelink' => '睇吓原始碼',
	'viewdeleted' => '去睇$1？',
	'viewsource' => '睇吓原始碼',
	'viewsourcetext' => '你可以睇吓或者複製呢一頁嘅原始碼：',
	'virus-badscanner' => "壞設定: 未知嘅病毒掃瞄器: ''$1''",
	'virus-scanfailed' => '掃瞄失敗 (代碼 $1)',
	'virus-unknownscanner' => '未知嘅防病毒:',
	'viewpagelogs' => '睇呢頁嘅日誌',
	'viewprevnext' => '去睇 ($1 {{int:pipe-separator}} $2) ($3)',
	'verification-error' => '檔案未通過驗證。',
	'viewdeletedpage' => '去睇被刪除咗嘅頁面',
	'variantname-zh-hans' => '簡體',
	'variantname-zh-hant' => '繁體',
	'variantname-zh-cn' => '簡體（中國大陸）',
	'variantname-zh-tw' => '正體（台灣）',
	'variantname-zh-hk' => '繁體（香港）',
	'variantname-zh-sg' => '簡體（新加坡）',
	'variantname-zh' => '無變換',
	'variantname-sr-ec' => '斯拉夫易卡語',
	'variantname-sr-el' => '拉丁易卡語',
	'variantname-sr' => '無變換',
	'variantname-kk-cyrl' => '哈薩克西里爾字',
	'variantname-kk-latn' => '哈薩克拉丁文',
	'variantname-kk-arab' => '哈薩克阿剌伯文',
	'variantname-ku-arab' => '庫爾德阿剌伯文',
	'variantname-ku-latn' => '庫爾德拉丁文',
	'variantname-ku' => '無變換',
	'version' => '版本',
	'version-extensions' => '裝咗嘅擴展',
	'version-specialpages' => '特別頁',
	'version-parserhooks' => '語法鈎',
	'version-variables' => '變數',
	'version-antispam' => '垃圾防止',
	'version-skins' => '畫面',
	'version-other' => '其他',
	'version-mediahandlers' => '媒體處理器',
	'version-hooks' => '鈎',
	'version-extension-functions' => '擴展函數',
	'version-parser-extensiontags' => '語法擴展標籤',
	'version-parser-function-hooks' => '語法函數鈎',
	'version-hook-name' => '鈎名',
	'version-hook-subscribedby' => '利用於',
	'version-version' => '(版本 $1)',
	'version-license' => '牌照',
	'version-poweredby-credits' => "呢個 Wiki 係由 '''[//www.mediawiki.org/ MediaWiki]''' 驅動，版權所有 © 2001-$1 $2。",
	'version-poweredby-others' => '其他',
	'version-license-info' => 'MediaWiki係自由軟件；你可以根據Free Software Foundation所發表嘅GNU General Public License條款規定，就本程式再發佈同／或修改；無論你根據嘅係呢個牌照嘅第二版或（任你揀）任一日之後發行嘅版本。

MediaWiki是基於使用目的而加以發佈，但係就唔會負上任何嘅責任；亦都唔會對適售性或都係特定目的適用性嘅默示性擔保。詳情請目睇GNU General Public License。

你應該已經收到跟往呢個程式嘅[{{SERVER}}{{SCRIPTPATH}}/COPYING GNU General Public License嘅副本]；如果冇嘅話，請寫信到至Free Software Foundation, Inc.：51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA，或[//www.gnu.org/licenses/old-licenses/gpl-2.0.html 上網睇]。',
	'version-software' => '裝咗嘅軟件',
	'version-software-product' => '產品',
	'version-software-version' => '版本',
);

$messages['za'] = array(
	'views' => 'Cazyawj',
	'versionrequired' => 'Sihyau MediaWiki $1',
	'versionrequiredtext' => 'Sihyau MediaWik $1 caengj daeng sawjyungh.',
	'viewsource' => 'Liuq lagh mae-nej',
);

$messages['zea'] = array(
	'variants' => 'Varianten',
	'view' => 'Lezen',
	'viewdeleted_short' => '{{PLURAL: $1|Eên geschrapte bewarkienge|$1 geschrapte bewarkiengen}} bekieken',
	'views' => 'Acties',
	'viewcount' => 'Deêze pagina is {{PLURAL:$1|1 keêr|$1 keêr}} bekeken.',
	'view-pool-error' => "Sorry, de servers zij op 't moment overbelast.
Te vee gebrukers proberen deêze pagina te bekieken.
Wacht asseblief even vòdatjieu opnuuw toegang probeert te kriegen tot deêze pagina.

$1",
	'versionrequired' => 'Versie $1 van MediaWiki is vereist',
	'versionrequiredtext' => 'Versie $1 van MediaWiki is vereist om deêze pahina te gebruken. Meêr info is beschikbaer op de pahina [[Special:Version|softwareversie]].',
	'viewsourceold' => 'brontekst bekieken',
	'viewsourcelink' => 'brontekst bekieken',
	'viewdeleted' => '$1 bekieken?',
	'viewsource' => 'brontekst bekieken',
	'viewsourcetext' => 'Je kan de brontekst van deêze pagina bekieken en kopiëren:',
	'viewpagelogs' => 'Bekiek de logboeken vò deêze bladzie',
	'viewprevnext' => 'Bekiek ($1 {{int:pipe-separator}} $2) ($3).',
);

$messages['zh'] = array(
	'variantname-zh-hans' => '简体',
	'variantname-zh-hant' => '繁體',
	'variantname-zh-cn' => 'disable',
	'variantname-zh-tw' => 'disable',
	'variantname-zh-hk' => 'disable',
	'variantname-zh-mo' => 'disable',
	'variantname-zh-sg' => 'disable',
	'variantname-zh-my' => 'disable',
	'variantname-zh' => 'disable',
);

$messages['zh-classical'] = array(
	'variantname-zh-hans' => '简体',
	'variantname-zh-hant' => '繁體',
	'variantname-zh-cn' => 'disable',
	'variantname-zh-tw' => 'disable',
	'variantname-zh-hk' => 'disable',
	'variantname-zh-mo' => 'disable',
	'variantname-zh-sg' => 'disable',
	'variantname-zh-my' => 'disable',
	'variantname-zh' => 'disable',
);

$messages['zh-hans'] = array(
	'variants' => '变换',
	'view' => '查看',
	'viewdeleted_short' => '查看$1个被删除的编辑',
	'views' => '查看',
	'viewcount' => '此页面已被浏览过$1次。',
	'view-pool-error' => '抱歉，服务器超负荷运转。
过多用户正尝试查看本页面。
请在再次尝试访问本页面之前稍等片刻。

$1',
	'versionrequired' => '需要版本为$1的MediaWiki',
	'versionrequiredtext' => '需要版本为$1的MediaWiki才能使用本页。请见[[Special:Version|版本页面]]。',
	'viewsourceold' => '查看源代码',
	'viewsourcelink' => '查看源代码',
	'viewdeleted' => '查看$1？',
	'viewsource' => '查看源代码',
	'viewsource-title' => '查看$1的源代码',
	'viewsourcetext' => '您可以查看并复制此页面的源代码：',
	'viewyourtext' => "您可以查看并复制'''您对此页面作出编辑后'''的源代码：",
	'virus-badscanner' => "错误的配置：未知的病毒扫描程序：''$1''",
	'virus-scanfailed' => '扫描失败（代码 $1）',
	'virus-unknownscanner' => '未知的反病毒软件：',
	'viewpagelogs' => '查看本页面的日志',
	'viewprevnext' => '查看（$1{{int:pipe-separator}}$2）（$3）',
	'verification-error' => '文件未通过验证。',
	'viewdeletedpage' => '查看被删页面',
	'variantname-zh-hans' => '简体',
	'variantname-zh-hant' => '繁体',
	'variantname-zh-cn' => '大陆简体',
	'variantname-zh-tw' => '台湾正体',
	'variantname-zh-hk' => '香港繁体',
	'variantname-zh-sg' => '新加坡简体',
	'variantname-zh' => '不转换',
	'variantname-gan-hans' => '',
	'variantname-kk-cyrl' => '',
	'version' => '版本',
	'version-extensions' => '已安装的扩展程序',
	'version-specialpages' => '特殊页面',
	'version-parserhooks' => '解析器钩',
	'version-variables' => '变量',
	'version-antispam' => '垃圾防止',
	'version-skins' => '皮肤',
	'version-other' => '其他',
	'version-mediahandlers' => '媒体处理器',
	'version-hooks' => '钩',
	'version-extension-functions' => '扩展函数',
	'version-parser-extensiontags' => '解析器扩展标签',
	'version-parser-function-hooks' => '解析器函数钩',
	'version-hook-name' => '钩名',
	'version-hook-subscribedby' => '署名',
	'version-version' => '（版本$1）',
	'version-license' => '授权协议',
	'version-poweredby-credits' => "本Wiki由'''[//www.mediawiki.org/ MediaWiki]'''驱动，版权所有 © 2001-$1 $2。",
	'version-poweredby-others' => '其他',
	'version-license-info' => 'MediaWiki为自由软件；您可依据自由软件基金会所发表的GNU通用公共授权条款规定，就本程序再为发布与／或修改；无论您依据的是本授权的第二版或（您自行选择的）任一日后发行的版本。

MediaWiki是基于使用目的而加以发布，然而不负任何担保责任；亦无对适售性或特定目的适用性所为的默示性担保。详情请参照GNU通用公共授权。

您应已收到附随于本程序的[{{SERVER}}{{SCRIPTPATH}}/COPYING GNU通用公共授权的副本]；如果没有，请写信至自由软件基金会：51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA，或[//www.gnu.org/licenses/old-licenses/gpl-2.0.html 在线阅读]。',
	'version-software' => '已安装的软件',
	'version-software-product' => '产品',
	'version-software-version' => '版本',
);

$messages['zh-hant'] = array(
	'variants' => '變換',
	'view' => '檢視',
	'viewdeleted_short' => '查看$1項已刪除的修訂',
	'views' => '檢視',
	'viewcount' => '本頁面已經被瀏覽$1次。',
	'view-pool-error' => '抱歉，伺服器在這段時間中已經超出負荷。
太多用戶嘗試檢視這個頁面。
在嘗試訪問這個頁面之前請再稍等一會。

$1',
	'versionrequired' => '需要MediaWiki $1 版',
	'versionrequiredtext' => '需要版本$1的 MediaWiki 才能使用此頁。參見[[Special:Version|版本頁]]。',
	'viewsourceold' => '檢視原始碼',
	'viewsourcelink' => '檢視原始碼',
	'viewdeleted' => '檢視 $1？',
	'viewsource' => '查看原始碼',
	'viewsource-title' => '查看$1的源代碼',
	'viewsourcetext' => '{{GENDER:|你|妳|你}}可以檢視並複製本頁面的原始碼。',
	'viewyourtext' => "您可以查看並複製'''您對此頁面作出編輯後'''的源代碼：",
	'virus-badscanner' => "損壞設定: 未知的病毒掃瞄器: ''$1''",
	'virus-scanfailed' => '掃瞄失敗 （代碼 $1）',
	'virus-unknownscanner' => '未知的防病毒:',
	'viewpagelogs' => '查詢這個頁面的日誌',
	'viewprevnext' => '檢視 （$1 {{int:pipe-separator}} $2） （$3）',
	'verification-error' => '檔案未通過驗證。',
	'viewdeletedpage' => '檢視被刪除的頁面',
	'variantname-zh-hans' => '簡體',
	'variantname-zh-hant' => '繁體',
	'variantname-zh-cn' => '大陸簡體',
	'variantname-zh-tw' => '台灣正體',
	'variantname-zh-hk' => '香港繁體',
	'variantname-zh-sg' => '新加坡簡體',
	'variantname-zh' => '不轉換',
	'version' => '版本',
	'version-extensions' => '已經安裝的擴展',
	'version-specialpages' => '特殊頁面',
	'version-parserhooks' => '語法鈎',
	'version-variables' => '變數',
	'version-antispam' => '垃圾防止',
	'version-skins' => '外觀',
	'version-other' => '其他',
	'version-mediahandlers' => '媒體處理器',
	'version-hooks' => '鈎',
	'version-extension-functions' => '擴展函數',
	'version-parser-extensiontags' => '語法擴展標籤',
	'version-parser-function-hooks' => '語法函數鈎',
	'version-hook-name' => '鈎名',
	'version-hook-subscribedby' => '利用於',
	'version-version' => '（版本 $1）',
	'version-license' => '授權',
	'version-poweredby-credits' => "這個 Wiki 由 '''[//www.mediawiki.org/ MediaWiki]''' 驅動，版權所有 © 2001-$1 $2。",
	'version-poweredby-others' => '其他',
	'version-license-info' => 'MediaWiki為自由軟件；您可依據自由軟件基金會所發表的GNU通用公共授權條款規定，就本程式再為發佈與／或修改；無論您依據的是本授權的第二版或（您自行選擇的）任一日後發行的版本。

MediaWiki是基於使用目的而加以發佈，然而不負任何擔保責任；亦無對適售性或特定目的適用性所為的默示性擔保。詳情請參照GNU通用公共授權。

您應已收到附隨於本程式的[{{SERVER}}{{SCRIPTPATH}}/COPYING GNU通用公共授權的副本]；如果沒有，請寫信至自由軟件基金會：51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA，或[//www.gnu.org/licenses/old-licenses/gpl-2.0.html 線上閱讀]。',
	'version-software' => '已經安裝的軟件',
	'version-software-product' => '產品',
	'version-software-version' => '版本',
);

$messages['zh-tw'] = array(
	'viewsourcetext' => '你可以檢視並複製本頁面的原始碼。',
	'variantname-zh-tw' => '台灣繁體',
	'version-parserhooks' => '語法鉤',
	'version-hooks' => '鉤',
	'version-parser-function-hooks' => '語法函數鉤',
	'version-hook-name' => '鉤名',
);

$messages['zh-yue'] = array(
	'viewsourcetext' => '你可以檢視並複製本頁面的原始碼。',
	'variantname-zh-tw' => '台灣繁體',
	'version-parserhooks' => '語法鉤',
	'version-hooks' => '鉤',
	'version-parser-function-hooks' => '語法函數鉤',
	'version-hook-name' => '鉤名',
);

