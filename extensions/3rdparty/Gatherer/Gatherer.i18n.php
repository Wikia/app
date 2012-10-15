<?php

/**
 * i18n for Gatherer extension
 */

$messages = array();

/** English (English)
 * @author Ryan Schmidt
 */
$messages['en'] = array(
	'gatherer' => 'Create or update a card page', // special page title text
	'gatherer-create' => 'Create or update a card page', // fieldset legend text
	'gatherer-name' => 'Card name:',
	'gatherer-bepatient' => 'Please be patient after you click "Submit" It may take a minute or so to finish uploading and creating everything.',
	'gatherer-done' => 'The card page has been successfully created/updated! View it <span class="plainlinks">[$1 here]</span>!',
	'gatherer-rarity-desc' => 'Rarity symbol image from Gatherer',
	'gatherer-card-desc' => '{{subst:Cardfairuse|$1|$2}}',
	'gatherer-rarity-com' => 'Uploading rarity symbol image using [[Special:Gatherer|Gatherer]]',
	'gatherer-card-com' => 'Uploading card image using [[Special:Gatherer|Gatherer]]',
	'gatherer-submit' => 'Submit',
	'gatherer-nocard' => 'The card does not exist. Check your spelling.',
	'gatherer-connerror' => 'Encountered a connection error. Please try again later.',
	'gatherer-imgerr' => 'The card images could not be retrieved. Please check to make sure that Gatherer is online, then try again.',
	'gatherer-phperr' => "PHP's ''allow_url_fopen'' directive is off, and as such this page will not work.

Please notify a system administrator so that it may be enabled.",
	'gatherer-notsup' => 'Split/Flip cards and Basic Lands are not yet supported',
	'gatherer-cardpage-com' => 'Creating or updating card page using [[Special:Gatherer|Gatherer]]',
);

// Cardpage template
// DO NOT TRANSLATE THIS MESSAGE!
$messages['en']['gatherer-cardpage'] = <<<EOT
{{Cardpage
|name=$1
|type=$2
|cost=$3
|cmc=$4
|rules=$5
|flavor=$6
|p/t=$7
|planeswalker=$8
|image1=$9
|p/r1=$10
|image2=$11
|p/r2=$12
|image3=$13
|p/r3=$14
|image4=$15
|p/r4=$16
|image5=$17
|p/r5=$18
|image6=$19
|p/r6=$20
|image7=$21
|p/r7=$22
|image8=$23
|p/r8=$24
|image9=$25
|p/r9=$26
|image10=$27
|p/r10=$28
|image11=$29
|p/r11=$30
|image12=$31
|p/r12=$32
|image13=$33
|p/r13=$34
|image14=$35
|p/r14=$36
|image15=$37
|p/r15=$38
}}
EOT;

// relative listing of all sets
// DO NOT TRANSLATE THIS MESSAGE!
$messages['en']['gatherer-sets'] = <<<EOT
<pre>Core Sets
Limited Edition Alpha=1E=black
Limited Edition Beta=2E=black
Unlimited Edition=2U=white
Revised Edition=3E=white
Fourth Edition=4E=white
Fifth Edition=5E=white
Classic Sixth Edition=6E=white
Seventh Edition=7E=white
Eighth Edition=8ED=white
Ninth Edition=9ED=white
Tenth Edition=10E=black

Starter Sets
Starter 2000=P4=white
Starter 1999=P3=white
Portal=PO=black
Portal Second Age=P2=black
Portal Three Kingdoms=PK=white

Special Sets
From the Vault: Dragons=DRB=black
Elves vs. Goblins=EVG=black
Unhinged=UNH=silver
Beatdown Box Set=BD=white
Battle Royale Box Set=BR=white
Chronicles=CH=white
Unglued=UG=silver

Online Sets
Masters Edition=MED=black
Masters Edition II=ME2=black

Non-block Expansions
Arabian Nights=AN=black
Antiquities=AQ=black
Legends=LE=black
The Dark=DK=black
Fallen Empires=FE=black

Ice Age Block
Ice Age=IA=black
Homelands=HM=black
Alliances=AL=black
Coldsnap=CSP=black

Mirage Block
Mirage=MI=black
Visions=VI=black
Weatherlight=WL=black

Tempest Block
Tempest=TE=black
Stronghold=ST=black
Exodus=EX=black

Urza Block
Urza's Saga=UZ=black
Urza's Legacy=GU=black
Urza's Destiny=CG=black

Masques Block
Mercadian Masques=MM=black
Nemesis=NE=black
Prophecy=PR=black

Invasion Block
Invasion=IN=black
Planeshift=PS=black
Apocalypse=AP=black

Odyssey Block
Odyssey=ODY=black
Torment=TOR=black
Judgment=JUD=black

Onslaught Block
Onslaught=ONS=black
Legions=LGN=black
Scourge=SCG=black

Mirrodin Block
Mirrodin=MRD=black
Darksteel=DST=black
Fifth Dawn=5DN=black

Kamigawa Block
Champions of Kamigawa=CHK=black
Betrayers of Kamigawa=BOK=black
Saviors of Kamigawa=SOK=black

Ravnica Block
Ravnica: City of Guilds=RAV=black
Guildpact=GPT=black
Dissension=DIS=black

Time Spiral Block
Time Spiral=TSP=black
Time Spiral "Timeshifted"=TSB=black
Planar Chaos=PLC=black
Future Sight=FUT=black

Lorwyn Block
Lorwyn=LRW=black
Morningtide=MOR=black

Shadowmoor Block
Shadowmoor=SHM=black
Eventide=EVE=black

Shards Block
Shards of Alara=ALA=black
Conflux=CON=black
</pre>
EOT;
