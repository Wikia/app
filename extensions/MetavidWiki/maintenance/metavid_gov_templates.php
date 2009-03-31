<?
require_once ( '../../../maintenance/commandLine.inc' );

require_once ( 'metavid2mvWiki.inc.php' );
require_once ( 'maintenance_util.inc.php');

if ( count( $args ) == 0 || isset ( $options['help'] ) ) {
	print<<<EOT
	Programatic updates of Templates 
	defaut: updates no template
	
	options: template_name #updates template by name
			 all #updates all templates 
			

EOT;
die();
}

$mvForceUpdate = ( isset( $options['force'] ) ) ? true:false;

print "should run on: ". $args[0];

switch ( $args[0] ) {
	case 'all':
		print " updating all templates is not yet supported";
	break;
	default :
		upTemplates( $args[0],$mvForceUpdate );
	break;
}


function upTemplates( $templateName, $force = false ) {
	global $valid_attributes;
	
if($templateName=='Ht_en'){
/***************************************************
 * Transcripts:
 * updates transcript templates
 ***************************************************/
 	$wgTemplateTitle = Title :: makeTitle( NS_TEMPLATE, 'Ht_en' );
	do_update_wiki_page( $wgTemplateTitle, '<noinclude>
		This is the default Template for the display of transcript text.
		</noinclude><includeonly>{{ #if:  {{{PersonName|}}} | {{ #ifexist: Image:{{{PersonName}}}.jpg | [[Image:{{{PersonName}}}.jpg|44px|left]]|[[Image:Missing person.jpg|44px|left]]}} |}}{{ #if:{{{PersonName|}}}|[[{{{PersonName}}}]]: |}}{{{BodyText}}}
		</includeonly>', null, $force );
}
if($templateName=='archive_org_ftypes'){
/****************************************************
 * Archive.org file type semantics
 ****************************************************/
	$archive_org_ftypes = array( '64Kb_MPEG4', '256Kb_MPEG4', 'MPEG1', 'MPEG2', 'flash_flv' );
	foreach ( $archive_org_ftypes as $ftype ) {
		$pTitle = Title::makeTitle( SMW_NS_PROPERTY, 'Ao_file_' . $ftype );
		do_update_wiki_page( $pTitle, '[[has type::URL]]', null, $force );
	}
}
if($templateName=='Bill'){
/*****************************************************
 * Bill Templates
 ****************************************************/
	$bill_template = '<noinclude>Bill Person Template simplifies the structure of articles about Bills.
	<pre>{{Bill|
	GovTrackID=The GovTrack Bill ID (used to key-into GovTracks Bill info)|
	ThomasID=The bill\'s Thomas id (used for Thomas linkback)|
	MAPLightBillID=The Map light Bill ID (used for supporting and opposing interest)|
	OpenCongressBillID=The open congress bill id (used for bill rss feeds)|
	Title Description=The short title/description of the bill|
	Date Introduced=The date the bill was introduced|
	Session=The session of congress (110 for 2007-08, 109 for 2005-2006 etc)|
	Bill Key=The short bill name ie: H.R. #|
	Sponsor=Who the Bill was Sponsored By|
	Cosponsor #=Cosponsor, Where # is 1-70 for listing all cosponsors|
	Supporting Interest #=Interest, Where # is 1-20 for listing top supporting interests|
	Opposing Interest #=Interest, Where # is 1-20 for listing top opposing interests|
	}}</pre>The template name (Bill) should be given as the \'\'first\'\' thing on a page. The Cosponsored list should come at the end.
	</noinclude><includeonly>
	==Bill [[Bill Key:={{{Bill Key}}}]] in the {{ #if: {{{Session|}}}| [[Congress Session:={{{Session}}}]] |}} of Congress==
	<span style="float:right">{{navimg|xsize=50|ysize=50|image=Crystal_Clear_mimetype_video_search.png|link=Category:{{{Bill Key}}}}}</span>
	{{ #if: {{{Title Description|}}}|{{{Title Description}}} |}}
	{{ #if: {{{Bill Key|}}}| <br>Media in [[:Category:{{{Bill Key}}}]] |}}
	{{ #if: {{{Date Introduced|}}}|* Date Introduced: [[Date Bill Introduced:={{{Date Introduced}}}]] |}}
	{{ #if: {{{Sponsor|}}}|* Sponsor: [[Bill Sponsor:={{{Sponsor}}}]] |}}';
	$bill_template .= '
	{{ #if: {{{Cosponsor 1|}}}|* Cosponsor: [[Bill Cosponsor:={{{Cosponsor 1}}}]] |}}';
	
	// $bill_template.='{{ #for: {{{n}}} | {{{Cosponsor $n$}}}<br /> }}';
	for ( $i = 2; $i < 70; $i++ ) {
	$bill_template .= '{{ #if: {{{Cosponsor ' . $i . '|}}}|, [[Bill Cosponsor:={{{Cosponsor ' . $i . '}}}]] |}}';
	}
	// output mapLight info if present:
	$bill_template .= '{{ #if: {{{Supporting Interest 1|}}}|<h2>Intrests who <span style="color:green">support</span> bill becoming law</h2>' . "\n[[Data_Source_URL:=http://maplight.org/map/us/bill/{{{MapLightBillID}}}|MAPLight Source]]" . ' |}}';
	for ( $i = 1; $i < 20; $i++ ) {
	$bill_template .= '{{ #if: {{{Supporting Interest ' . $i . '|}}}|* [[Supporting Interest:={{{Supporting Interest ' . $i . '}}}]]' . "\n" . ' |}}';
	}
	$bill_template .= '{{ #if: {{{Opposing Interest 1|}}}|<h2>Interests who <span style="color:red">oppose</span> bill becoming law</h2>' . "\n" . ' |}}';
	for ( $i = 1; $i < 20; $i++ ) {
	$bill_template .= '{{ #if: {{{Opposing Interest ' . $i . '|}}}|* [[Opposing Interest:={{{Opposing Interest ' . $i . '}}}]]' . "\n" . '|}}';
	}
	// @@todo could do inline rss once we get a good cache model for http://www.mediawiki.org/wiki/Extension:RSS_Reader
	// maybe just action=purge on as a cron job, with $parser->disableCache(); commented out
	$bill_template .= '
	{{ #if: {{{OpenCongressBillID|}}}|==Bill RSS Feeds==
	* In the News [http://www.opencongress.org/bill/{{{OpenCongressBillID|}}}/atom_news]
	* Blog Coverage [http://www.opencongress.org/bill/{{{OpenCongressBillID|}}}/atom_blogs]
	* Bill Actions [http://www.opencongress.org/bill/{{{OpenCongressBillID|}}}/atom][[Open Congress Bill ID:={{{OpenCongressBillID|}}}|]]
	|}}';
	
	$bill_template .= '
	==Data Sources==
	{{ #if: {{{ThomasID|}}}|* [[Metavid Sources#Thomas|Thomas]] Official Bill Information:[[Data_Source_URL:=http://thomas.loc.gov/cgi-bin/bdquery/z?{{{ThomasID}}}:]] [[Thomas Bill ID:={{{ThomasID}}}| ]]
	|}}{{ #if: {{{GovTrackID|}}}|* [[Metavid Sources#GovTrack|GovTrack]] Bill Overview:[[Data_Source_URL:=http://www.govtrack.us/congress/bill.xpd?bill={{{GovTrackID}}}]] [[GovTrack Bill ID:={{{GovTrackID}}}| ]]
	|}}{{ #if: {{{MapLightBillID|}}}|* [[Metavid Sources#MapLight|MapLight]] Bill Overview:[[Data_Source_URL:=http://maplight.org/map/us/bill/{{{MapLightBillID}}}]] [[MAPLight_Bill_ID:={{{MapLightBillID}}}| ]]
	|}}
	[[Category:Bill]]
	</includeonly>';
	// update bill template:
	$wgTemplateTitle = Title :: makeTitle( NS_TEMPLATE, 'Bill' );
		do_update_wiki_page( $wgTemplateTitle, $bill_template , null, $force );
	
	// update semnatic property types:
	foreach ( array( 'Page' => array( 'Bill Key', 'Bill Sponsor', 'Bill Cosponsor', 'Congress Session' ),
				  'String' => array( 'Thomas Bill ID', 'Open_Congress_Bill_ID', 'GovTrack_Bill_ID', 'MAPLight_Bill_ID' ),
				  'URL' => array( 'Data_Source_URL' ),
				  'Date' => array( 'Date_Bill_Introduced' )
	) as $type => $type_set ) {
		foreach ( $type_set as $propName ) {
				$wgPropTitle = Title::newFromText( $propName, SMW_NS_PROPERTY );
					do_update_wiki_page( $wgPropTitle, '[[has type::' . $type . ']]', null, $force );
			}
	}
}
if($templateName=='Interest Group'){
/***************************************
 * Interest Group templates:
 **************************************/

	  global $mvMaxContribPerInterest, $mvMaxForAgainstBills;
	 $interest_template = '<noinclude>Interest Group Template simplifies the structure of articles about Interest Groups.
	<pre>{{Interest Group|
	MAPLight Interest ID=The MapLight Interest ID|
	Funded Name #=funded name where 1 is 1-' . $mvMaxContribPerInterest . ' for top ' . $mvMaxContribPerInterest . ' contributions|
	Funded Amount #=funded amount to name 1 (required pair to funded name #)|
	Supported Bill #=Bills the Interest group supported (long name) 1-' . $mvMaxForAgainstBills . '|
	Opposed Bill #=Bills Interest group Opposed (long name) 1-' . $mvMaxForAgainstBills . '|
	}}</pre>
	</noinclude><includeonly>
	{{ #if: {{{Funded Name 1|}}}|==Recipients Funded==
	Showing contributions 2001-2008 Senate / 2005-2008 House [[Data_Source_URL:=http://maplight.org/map/us/interest/{{{MAPLight Interest ID}}}/view/all|MAPLight source]]
	|}}';
	/*
	 * output top $mvMaxContribPerInterest contributers
	 */
	for ( $i = 1; $i <= $mvMaxContribPerInterest; $i++ ) {
		if ( $i <= 10 ) { // only display 10:
			$interest_template .= '{{ #if: {{{Funded Name ' . $i . '|}}}|*[[Funded:={{{Funded Name ' . $i . '}}};{{{Funded Amount ' . $i . '}}}]] |}}';
			if ( $i != 10 )$interest_template .= "\n";
		} else {
			$interest_template .= '{{ #if: {{{Funded Name ' . $i . '|}}}|*[[Funded:={{{Funded Name ' . $i . '}}};{{{Funded Amount ' . $i . '}}}|]] |}}';
		}
	}
	
	/*
	 * output bills supported / opposed template vars:
	 */
	foreach ( array( 'Supported', 'Opposed' ) as $pos ) {
		// $interest_template.='\nShowing contributions 2001-2008 Senate / 2005-2008 House [[Data_Source_URL:=http://maplight.org/map/us/interest/{{{MAPLight Interest ID}}}|MAPLight source]]';
		$interest_template .= '{{ #if: {{{' . $pos . ' Bill 1|}}}|<h3>' . $pos . ' Bills</h3>
	Pulled from maplight [[Data_Source_URL:=http://maplight.org/map/us/interest/{{{MAPLight Interest ID}}}/bills|source]]
	|}}';
		for ( $i = 1; $i <= $mvMaxForAgainstBills; $i++ ) {
			$interest_template .= '{{ #if: {{{' . $pos . ' Bill ' . $i . '|}}}|*[[' . $pos . ' Bill:={{{' . $pos . ' Bill ' . $i . '}}}]]
	|}}';
		}
	}
	$interest_template .= '[[Category:Interest Group]]
	</includeonly>';
	
	$wgTemplateTitle = Title :: makeTitle( NS_TEMPLATE, 'Interest Group' );
	do_update_wiki_page( $wgTemplateTitle, $interest_template , null, $force );
	
	$wgPropTitle = Title::newFromText( 'Funded', SMW_NS_PROPERTY );
	do_update_wiki_page( $wgPropTitle, '[[has type:=Page;Number]]', null, $force );
}
if($templateName=='Congress_Person'){
	$template_body = '<noinclude>Congress Person template simplifies 
			the structure of articles about Congress People.
			<pre>{{Congress Person|'."\n";
	foreach ( $valid_attributes as $dbKey => $attr ) {
		list ( $name, $desc ) = $attr;
		$template_body .= $name . '=' . $desc . "|\n";
	}
$template_body .='
}}</pre>The order of the fields is not relevant. The template name (Congress Person) should be given as the \'\'first\'\' thing on a page.
</noinclude><includeonly> __NOTOC__ __NOEDITSECTION__ <div id="NOTITLEHACK"></div><div id="profile"><p>{{ #if: {Image:{{PAGENAME}}.jpg}| [[Image:{{PAGENAME}}.jpg]]
|}}<span>{{PAGENAME}} ({{{Title}}} - {{{Party}}} - {{{State}}})</span></p></div>
<div id="resultsArea">{{#mvData:PERSONSPEECHES|num_results=5|person={{PAGENAME}}}}</div>
<div id="searchSideBar">
<div id="searchSideBar2Top"></div>
<div id="searchSideBarInner" class="suggestionsBox">
<div class="block first_block">
   <h6 class="profile">Overview</h6>
</div><div class="block wide_block">
{{ #if: {{{GovTrack Person ID|}}}|
<ul><li>[[Data_Source_URL:=http://www.opencongress.org/people/show/{{{GovTrack Person ID}}}|]][http://www.opencongress.org/people/show/{{{GovTrack Person ID}}} Profile on OpenCongress]
<ul>
<li>
[http://www.opencongress.org/people/atom_news/{{{GovTrack Person ID}}} In the News RSS]
</li>
<li>
[http://www.opencongress.org/people/atom_blogs/{{{GovTrack Person ID}}} In the Blogs RSS]
</li>
</ul>
</li>
{{ #if: {{{Bio Guide ID|}}}|<li>[http://bioguide.congress.gov/scripts/biodisplay.pl?index={{{Bio Guide ID}}} Official Biography] </li>
|}}
</ul>
|}}
</div>
<div class="block">
<h6 class="profile">Recent Bills Sponsored</h6>
</div>
{{#ask: [[Bill Sponsor::{{PAGENAME}}]]
| format=ul
| limit=4
}}
<div class="block">
<h6 class="profile">Recent Bills Co-Sponsored</h6>
</div>
{{#ask: [[Bill Cosponsor::{{PAGENAME}}]]
| format=ul
| limit=4
}}
<div class="block">
<h6 class="profile">Top Funding Sources</h6>
</div>
{{ #if: {{{MAPLight Person ID|}}}|[[Data_Source_URL:=http://www.maplight.org/map/us/legislator/{{{MAPLight Person ID}}}|MAPLight Source]]  
 |}}{{ #if: {{{Total Received|}}}|Total Campaign Contributions for {{PAGENAME}}: {{{Total Received}}} <br>|}}
{{ #if: {{{Contributions Date Range|}}}|Contributions Date Range: {{{Contributions Date Range}}} |}}
<ul>
{{ #if: {{{Funding Interest 1|}}}|<li>[[Funding Interest:={{{Funding Interest 1}}};{{{Funding Amount 1}}}]]</li> 
|}}{{ #if: {{{Funding Interest 2|}}}|<li>[[Funding Interest:={{{Funding Interest 2}}};{{{Funding Amount 2}}}]]</li> 
|}}{{ #if: {{{Funding Interest 3|}}}|<li>[[Funding Interest:={{{Funding Interest 3}}};{{{Funding Amount 3}}}]]</li> 
|}}{{ #if: {{{Funding Interest 4|}}}|<li>[[Funding Interest:={{{Funding Interest 4}}};{{{Funding Amount 4}}}]]</li>
|}}</ul>
{{ #if: {{{Funding Interest 5|}}}|[[Funding Interest:={{{Funding Interest 5}}};{{{Funding Amount 5}}}|]]|}}{{ #if: {{{Funding Interest 6|}}}|*[[Funding Interest:={{{Funding Interest 6}}};{{{Funding Amount 6}}}| ]]|}}{{ #if: {{{Funding Interest 7|}}}|*[[Funding Interest:={{{Funding Interest 7}}};{{{Funding Amount 7}}}| ]]|}}{{ #if: {{{Funding Interest 8|}}}|[[Funding Interest:={{{Funding Interest 8}}};{{{Funding Amount 8}}}|]]|}}{{ #if: {{{Funding Interest 9|}}}|[[Funding Interest:={{{Funding Interest 9}}};{{{Funding Amount 9}}}|]]|}}{{ #if: {{{Funding Interest 10|}}}|[[Funding Interest:={{{Funding Interest 10}}};{{{Funding Amount 10}}}|]]|}}
</div>


{{ #if: {{{Committee Member 1|}}}|
===Committee Membership===
|}}{{ #if: {{{Committee Member 1|}}}|*[[Committee Member:={{{Member of Committee 1}}}]] 
|}}{{ #if: {{{Committee Member 2|}}}|*[[Committee Member:={{{Member of Committee 2}}}]] 
|}}{{ #if: {{{Committee Member 3|}}}|*[[Committee Member:={{{Member of Committee 3}}}]] 
|}}{{ #if: {{{Committee Member 4|}}}|*[[Committee Member:={{{Member of Committee 4}}}]] 
|}}{{ #if: {{{Committee Member 5|}}}|*[[Committee Member:={{{Member of Committee 5}}}]] 
|}}{{ #if: {{{Committee Member 6|}}}|*[[Committee Member:={{{Member of Committee 6}}}]] 
|}}{{ #if: {{{Committee Member 7|}}}|*[[Committee Member:={{{Member of Committee 7}}}]] 
|}}{{ #if: {{{Committee Member 8|}}}|*[[Committee Member:={{{Member of Committee 8}}}]] 
|}}{{ #if: {{{Committee Member 9|}}}|*[[Committee Member:={{{Member of Committee 9}}}]] 
|}}{{ #if: {{{Committee Member 10|}}}|*[[Committee Member:={{{Member of Committee 10}}}]] 
|}}{{ #if: {{{Committee Member 11|}}}|*[[Committee Member:={{{Member of Committee 11}}}]] 
|}}{{ #if: {{{Committee Member 12|}}}|*[[Committee Member:={{{Member of Committee 12}}}]] 
|}}{{ #if: {{{Committee Member 13|}}}|*[[Committee Member:={{{Member of Committee 13}}}]] 
|}}{{ #if: {{{Committee Member 14|}}}|*[[Committee Member:={{{Member of Committee 14}}}]] 
|}}{{ #if: {{{Committee Member 15|}}}|*[[Committee Member:={{{Member of Committee 15}}}]] 

|}}
</div>';
		//output all the database fileds (hidden): 
		foreach ( $valid_attributes as $dbKey => $attr ) {
			list ( $name, $desc ) = $attr;
				$template_body .= "{{ #if: {{{" . $name . "|}}}| [[$name:={{{" . $name . "}}}| ]] |}}";
		}	
		//finish up template output: 
$template_body .='
[[Category:Congress Person]] [[Category:Person]]
<div style="clear:both"></div>
</includeonly>';
		//now insert template body: 
		$wgTemplateTitle = Title :: makeTitle( NS_TEMPLATE, 'Congress_Person' );
		do_update_wiki_page( $wgTemplateTitle, $template_body , null, $force );
		
		//update attribute string types:
		foreach ( $valid_attributes as $dbKey => $attr ) {
			list ( $name, $desc, $type ) = $attr;
			$wgPropTitle = Title::newFromText( $name, SMW_NS_PROPERTY );
			do_update_wiki_page( $wgPropTitle, "[[has type:=$type]]", null, $force );
		}
	}
}

