<?php

$messages = array();

/** English */
$messages['en'] = array (
	'ta-desc'                => 'Recreation of popular templates in PHP',

	# citation separators
	'ta-citesep-section'     => '.',               # separator between sections
	'ta-citesep-end'         => '.',               # final separator (not really a separator)
	'ta-citesep-name'        => ',',               # separator between surname and givenname
	'ta-citesep-author'      => '&#059;',          # separator between authors
	'ta-citesep-authorlast'  => '&#32;&amp;',      # last separator between authors
	'ta-citesep-beforepublication' => ':',         # separator between periodical
	                                               # and publication
	
	# citation messages
	'ta-citeetal'            => "$1 ''et al''.",   # $1 = list of authors
	'ta-citecoauthors'       => '$1$2 $3',         # $1 = authors, $2 = separator
	'ta-citealonedate'       => '$1',              # $1 = date
	'ta-citeauthordate'      => '$1 ($2)',         # $1 = authors or separator
	'ta-citeauthoryearnote'  => '$1 [$2]',         # $1 = date
	'ta-citeeditorsplural'   => '$1, eds',         # $1 = editors
	'ta-citeeditorssingular' => '$1, ed',          # $1 = editor
	'ta-includedworktitle'   => "''$1''",
	'ta-citepubmed-url'      => 'http://www.pubmedcentral.nih.gov/articlerender.fcgi?tool=pmcentrez&artid=$1',
	'ta-citetranstitle-render'  => '&#91;$1&#93;',
	'ta-citewrittenat'       => 'written at $1',
	'ta-citeplacepublisher'  => '$1: $2',          # $1 = place, $2 = publisher
	'ta-citeother'               => '$1',
	'ta-citeinlanguage'      => '$1 (in $2)',      # $1 = title/link
	'ta-citetitletrans'      => '"$1 [$2]"',       # $1 = title/link, $2 = transtitle
	'ta-citeformatrender'    => '$1 ($2)',         # $1 = title/link
	'ta-citenewspublisherplace'  => "''$1'' ($2)",
	'ta-citenewspublisher'       => "''$1''",
	'ta-citeperiodical'      => "''$1''",
	'ta-citeperiodicaltitle' => "''$1''",
	'ta-citebooktitle'       => "''$1''",
	'ta-citebookpubplace'    => '$1: $2',          # $1 = location, $2 = publisher
	'ta-citebookpublisher'   => '$1',
	'ta-citebookpage'        => 'p. $1',
	'ta-citebookisbn'        => '[[Special:BookSources/$1|ISBN $2]]',
	'ta-series'              => '$1',
	'ta-citepublicationplaceandpublisher'   => '($1: $2)',
	'ta-citepublicationplace'   => '($1)',
	'ta-citevolumerender'    => "'''$1'''",
	'ta-citeissuerender'     => '$1 ($2)',         # $1 = volume
	'ta-citeatrender'        => '$1: $2',          # $1 = title info
	'ta-citeatseparated'     => '$1',
	'ta-citetitletyperender' => '$1 ($2)',         # $1 = title/link
	'ta-citepublisherrender' => '$1',
	'ta-citepublished'       => '$1 (published $2)', # $1 = title/link
	'ta-citeeditionrender'   => '$1',
	'ta-citepublication'     => '$1',
	'ta-citepublicationdate' => '$1',
	'ta-citeretrievedupper'  => 'Retrieved $1',   
	'ta-citeretrievedlower'  => 'retrieved $1',
	'ta-citejournal'         => "''$1''",
	'ta-citejournalpage'     => "''$1'': $2",
	
	# citation span messages
	'ta-citationspan'        => '<span class="citation $2">$1</span>',
	'ta-citeprintonlyspan'   => '<span class="printonly">$1</span>',
	'ta-citeaccessdatespan'  => '<span class="reference-accessdate">$1</span>',
);

