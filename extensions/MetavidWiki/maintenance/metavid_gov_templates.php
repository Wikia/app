<?

function upTemplates($force=false){
/***************************************************
 * Transcripts: 
 * updates transcript templates
 ***************************************************/
 	$wgTemplateTitle = Title :: makeTitle(NS_TEMPLATE, 'Ht_en');
	do_update_wiki_page($wgTemplateTitle, '<noinclude>
		This is the default Template for the display of transcript text. 
		</noinclude><includeonly>{{ #if:  {{{PersonName|}}} | {{ #ifexist: Image:{{{PersonName}}}.jpg | [[Image:{{{PersonName}}}.jpg|44px|left]]|[[Image:Missing person.jpg|44px|left]]}} |}}{{ #if:{{{PersonName|}}}|[[{{{PersonName}}}]]: |}}{{{BodyText}}}
		</includeonly>',null, $force);
/****************************************************
 * Archive.org file type semantics
 ****************************************************/  
	$archive_org_ftypes = array('64Kb_MPEG4','256Kb_MPEG4','MPEG1','MPEG2','flash_flv');
	foreach($archive_org_ftypes as $ftype){
		$pTitle= Title::makeTitle(SMW_NS_PROPERTY, 'Ao_file_'.$ftype );
		do_update_wiki_page($pTitle, '[[has type::URL]]',null, $force);
	}
/*****************************************************
 * Bill Templates
 ****************************************************/	
	$bill_template='<noinclude>Bill Person Template simplifies the structure of articles about Bills.
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
$bill_template.='
{{ #if: {{{Cosponsor 1|}}}|* Cosponsor: [[Bill Cosponsor:={{{Cosponsor 1}}}]] |}}';

//$bill_template.='{{ #for: {{{n}}} | {{{Cosponsor $n$}}}<br /> }}';
for($i=2;$i<70;$i++){	
	$bill_template.='{{ #if: {{{Cosponsor '.$i.'|}}}|, [[Bill Cosponsor:={{{Cosponsor '.$i.'}}}]] |}}';
}
//output mapLight info if present:
$bill_template.='{{ #if: {{{Supporting Interest 1|}}}|<h2>Intrests who <span style="color:green">support</span> bill becoming law</h2>'."\n[[Data_Source_URL:=http://maplight.org/map/us/bill/{{{MapLightBillID}}}|MAPLight Source]]".' |}}';
for($i=1;$i<20;$i++){
	$bill_template.='{{ #if: {{{Supporting Interest '.$i.'|}}}|* [[Supporting Interest:={{{Supporting Interest '.$i.'}}}]]'."\n".' |}}';
}
$bill_template.='{{ #if: {{{Opposing Interest 1|}}}|<h2>Interests who <span style="color:red">oppose</span> bill becoming law</h2>'."\n".' |}}';
for($i=1;$i<20;$i++){
	$bill_template.='{{ #if: {{{Opposing Interest '.$i.'|}}}|* [[Opposing Interest:={{{Opposing Interest '.$i.'}}}]]'."\n".'|}}';
}
//@@todo could do inline rss once we get a good cache model for http://www.mediawiki.org/wiki/Extension:RSS_Reader
// maybe just action=purge on as a cron job, with $parser->disableCache(); commented out 
$bill_template.='
{{ #if: {{{OpenCongressBillID|}}}|==Bill RSS Feeds==
* In the News [http://www.opencongress.org/bill/{{{OpenCongressBillID|}}}/atom_news]
* Blog Coverage [http://www.opencongress.org/bill/{{{OpenCongressBillID|}}}/atom_blogs]
* Bill Actions [http://www.opencongress.org/bill/{{{OpenCongressBillID|}}}/atom][[Open Congress Bill ID:={{{OpenCongressBillID|}}}|]]
|}}';

$bill_template.='
==Data Sources==  		
{{ #if: {{{ThomasID|}}}|* [[Metavid Sources#Thomas|Thomas]] Official Bill Information:[[Data_Source_URL:=http://thomas.loc.gov/cgi-bin/bdquery/z?{{{ThomasID}}}:]] [[Thomas Bill ID:={{{ThomasID}}}| ]] 
|}}{{ #if: {{{GovTrackID|}}}|* [[Metavid Sources#GovTrack|GovTrack]] Bill Overview:[[Data_Source_URL:=http://www.govtrack.us/congress/bill.xpd?bill={{{GovTrackID}}}]] [[GovTrack Bill ID:={{{GovTrackID}}}| ]] 
|}}{{ #if: {{{MapLightBillID|}}}|* [[Metavid Sources#MapLight|MapLight]] Bill Overview:[[Data_Source_URL:=http://maplight.org/map/us/bill/{{{MapLightBillID}}}]] [[MAPLight_Bill_ID:={{{MapLightBillID}}}| ]] 
|}}
[[Category:Bill]]
</includeonly>';	
	//update bill template:
	$wgTemplateTitle = Title :: makeTitle(NS_TEMPLATE, 'Bill');
		do_update_wiki_page($wgTemplateTitle,$bill_template ,null, $force);
			
	//update semnatic property types:
	foreach(array('Page'=>array('Bill Key', 'Bill Sponsor', 'Bill Cosponsor', 'Congress Session'),
				  'String'=>array('Thomas Bill ID','Open_Congress_Bill_ID','GovTrack_Bill_ID','MAPLight_Bill_ID'),
				  'URL'=>array('Data_Source_URL'),
				  'Date'=>array('Date_Bill_Introduced')
	) as $type=>$type_set){
		foreach($type_set as $propName){
				$wgPropTitle = Title::newFromText($propName, SMW_NS_PROPERTY);
					do_update_wiki_page($wgPropTitle, '[[has type::'.$type.']]',null, $force);
			}
	}
/***************************************
 * Interest Group templates:
 **************************************/
 
  global $mvMaxContribPerInterest, $mvMaxForAgainstBills;
 $interest_template = '<noinclude>Interest Group Template simplifies the structure of articles about Interest Groups.
<pre>{{Interest Group|
MAPLight Interest ID=The MapLight Interest ID|
Funded Name #=funded name where 1 is 1-'.$mvMaxContribPerInterest.' for top '.$mvMaxContribPerInterest.' contributions|
Funded Amount #=funded amount to name 1 (required pair to funded name #)|	
Supported Bill #=Bills the Interest group supported (long name) 1-'.$mvMaxForAgainstBills.'|
Opposed Bill #=Bills Interest group Opposed (long name) 1-'.$mvMaxForAgainstBills.'|
}}</pre>
</noinclude><includeonly>
{{ #if: {{{Funded Name 1|}}}|==Recipients Funded==
Showing contributions 2001-2008 Senate / 2005-2008 House [[Data_Source_URL:=http://maplight.org/map/us/interest/{{{MAPLight Interest ID}}}/view/all|MAPLight source]]
|}}';
/*
 * output top $mvMaxContribPerInterest contributers
 */
for($i=1;$i<=$mvMaxContribPerInterest;$i++){
	if($i<=10){ //only display 10:
		$interest_template.='{{ #if: {{{Funded Name '.$i.'|}}}|*[[Funded:={{{Funded Name '.$i.'}}};{{{Funded Amount '.$i.'}}}]] |}}';
		if($i!=10)$interest_template.="\n";
	}else{
		$interest_template.='{{ #if: {{{Funded Name '.$i.'|}}}|*[[Funded:={{{Funded Name '.$i.'}}};{{{Funded Amount '.$i.'}}}|]] |}}';
	}
}

/*
 * output bills supported / opposed template vars:
 */
foreach(array('Supported','Opposed') as $pos){
	//$interest_template.='\nShowing contributions 2001-2008 Senate / 2005-2008 House [[Data_Source_URL:=http://maplight.org/map/us/interest/{{{MAPLight Interest ID}}}|MAPLight source]]';
	$interest_template.='{{ #if: {{{'.$pos.' Bill 1|}}}|<h3>'.$pos.' Bills</h3>
Pulled from maplight [[Data_Source_URL:=http://maplight.org/map/us/interest/{{{MAPLight Interest ID}}}/bills|source]]
|}}'; 
	for($i=1;$i<=$mvMaxForAgainstBills;$i++){	 
		$interest_template.='{{ #if: {{{'.$pos.' Bill '.$i.'|}}}|*[['.$pos.' Bill:={{{'.$pos.' Bill '.$i.'}}}]]
|}}';
	}
}
$interest_template.='[[Category:Interest Group]]
</includeonly>';

$wgTemplateTitle = Title :: makeTitle(NS_TEMPLATE, 'Interest Group');
do_update_wiki_page($wgTemplateTitle,$interest_template ,null, $force);

$wgPropTitle = Title::newFromText('Funded', SMW_NS_PROPERTY);
do_update_wiki_page($wgPropTitle, '[[has type:=Page;Number]]',null, $force);

/***************************************
 *  Update people templates
 ***************************************/ 
	global $valid_attributes;
	$wgTemplateTitle = Title :: makeTitle(NS_TEMPLATE, 'Congress Person');
	$wgTemplateArticle = new Article($wgTemplateTitle);
	$template_body = '<noinclude>Congress Person template simplifies 
			the structure of articles about Congress People.
			<pre>{{Congress Person|' . "\n";
	foreach ($valid_attributes as $dbKey => $attr) {
		list ($name, $desc) = $attr;				 
		$template_body .= $name . '=' . $desc . "|\n";
	}
	//$template_body .= "Committee Member #= The name of the Committee (where # is 1-15)|\n";
	//$template_body .= "Committee Chair #= The name of the Committee (where # is 1-15)|\n";
	$template_body .= "Funding Interest #= Funding Interest Name (where # is 1-10)|\n";
	$template_body .= "Funding Amount #= Funding Amount for Interest (where # is 1-10 and aligns with Funding Interest Name)|\n";
	$template_body .= '}}</pre>' .
	'The order of the fields is not relevant. The template name (Congress Person) should be given as the \'\'first\'\' thing on a page.
			</noinclude>' .
	'<includeonly>' . "\n";
	//hide the table of contents:
	$template_body .= '__NOTOC__ ';
	//include the image if present: 
	$template_body .= '{{ #if: {Image:{{PAGENAME}}.jpg}| [[Image:{{PAGENAME}}.jpg|left]]'."\n".'|}}';
	foreach ($valid_attributes as $dbKey => $attr) {
		list ($name, $desc) = $attr;	
			$template_body .= "{{ #if: {{{" . $name . "|}}}| [[$name:={{{" . $name . "}}}| ]] |}}";		
	}	
	//$template_body.='<span style="width:40%;float:left;">';
	$template_body.='<span style="float:right">{{navimg|xsize=50|ysize=50|image=Crystal_Clear_mimetype_video_search.png|link=Special:MediaSearch/person/{{PAGENAME}} }}</span>';	
	//ask for speeches media~	
	$template_body.="\n".'{{#ask: [[Speech_by::{{PAGENAME}}]] 
|?Category | ?Bill
| intro=<h3>Speeches By {{PAGENAME}}</h3>
| default= | limit=5}}';	
	/*$template_body.='{{#ask: [[Spoken_By::{{PAGENAME}}]] |
| intro=<h3>[[Special:MediaSearch/person/{{PAGENAME}}|Spoken Text]] By {{PAGENAME}}</h3> 
| default= | limit=5}}';	 
*/
	//$template_body.='</span>';
	//$template_body.='<span style="width:40%;float:left;">';
	//ask for inverse relations (bills) : 
	$template_body.='{{#ask: [[Bill Sponsor::{{PAGENAME}}]] |
| intro=<h3>Bills Sponsored</h3>
| default= | limit=5}}';

	$template_body.='{{#ask: [[Bill Cosponsor::{{PAGENAME}}]] |
| intro=<h3>Bills Cosponsored</h3>
| default= | limit=5}}';


	//$template_body.="\n".'[[Special:MediaSearch/person/{{PAGENAME}}|Media Search]]<br>'; 
	//include space for Top 10 Interests Funding	
	$template_body.="\n===Interests Funding===\n";
	$template_body.="{{ #if: {{{MAPLight Person ID|}}}|[[Data_Source_URL:=http://www.maplight.org/map/us/legislator/{{{MAPLight Person ID}}}|MAPLight Source]] \n|}}";
	$template_body.="{{ #if: {{{Total Received|}}}| Total Campaign Contributions for {{PAGENAME}}: {{{Total Received}}} <br>|}}\n";
	$template_body.="{{ #if: {{{Contributions Date Range|}}}|Contributions Date Range: {{{Contributions Date Range}}} |}}\n";	
	for($i=1;$i<=10;$i++){
		$template_body.="{{ #if: {{{Funding Interest $i|}}}|*[[Funding Interest:={{{Funding Interest $i}}};{{{Funding Amount $i}}}]] \n|}}";
	}
	$template_body.="\n";
	
	//comm
	$template_body.="{{ #if: {{{Committee Member $i|}}}|\n===Committee Membership===\n|}}";
	for($i=1;$i<=15;$i++){
		$template_body.="{{ #if: {{{Committee Member $i|}}}|*[[Committee Member:={{{Member of Committee $i}}}]] \n|}}";
	}
	//$template_body.='</span>';
	//$template_body.='<div style="clear:both"></div>';
	//news feeds:
	$template_body.="\n===RSS feeds===\n";
	$template_body.='[[Data_Source_URL:=http://www.opencongress.org/people/show/{{{GovTrack Person ID}}}|OpenCongress Source]]'."\n";
	$template_body.="*[http://www.opencongress.org/people/atom_news/{{{GovTrack Person ID}}} In the News]
*[http://www.opencongress.org/people/atom_blogs/{{{GovTrack Person ID}}} In the Blogs]";
	
	//include some external links:
	$template_body .="\n===External Links===\n".
'{{ #if: {{{Bio Guide ID|}}}|* [http://bioguide.congress.gov/scripts/biodisplay.pl?index={{{Bio Guide ID}}} Offical Biography] |}}'."\n";
'{{ #if: {{{MAPLight Person ID|}}}|* [http://www.maplight.org/map/us/legislator/{{{MAPLight Person ID}}} MapLight Page] |}}'."\n";
'{{ #if: {{{Open Secrets ID|}}}|* [http://www.opensecrets.org/politicians/summary.asp?CID={{{Open Secrets ID}}} Open Secrets Page] |}}'."\n";
'{{ #if: {{{GovTrack Person ID|}}}|* [http://www.govtrack.us/congress/person.xpd?id={{{GovTrack Person ID}}} GovTrack Page] |}}'."\n";
	$template_body .= '[[Category:Congress Person]] [[Category:Person]]
			</includeonly>';
	echo "updated 'Congress Person' template\n";
	do_update_wiki_page($wgTemplateTitle, $template_body,null, $force);
	
	//update types for attr: 
	foreach ($valid_attributes as $dbKey => $attr) {
		list ($name, $desc, $type) = $attr;
		$wgPropTitle = Title::newFromText($name, SMW_NS_PROPERTY);
		do_update_wiki_page($wgPropTitle, "[[has type:=$type]]",null, $force);
	}
	//update special types: 
	$wgPropTitle = Title::newFromText('Funding Interest',SMW_NS_PROPERTY);
	do_update_wiki_page($wgPropTitle, "[[has type:=Page;Number]]",null,$force); 

/************************************
 * some more types: 
 ************************************/
$wgPropTitle = Title::newFromText('Speech by', SMW_NS_PROPERTY);
do_update_wiki_page($wgPropTitle, "[[has type:=Page]]",null,$force); 
		
$wgPropTitle = Title::newFromText('Spoken by', SMW_NS_PROPERTY);
do_update_wiki_page($wgPropTitle, "[[has type:=Page]]",null,$force); 
/************************************
 *  page helpers
 ************************************/
 $wgTempNavImg = Title::makeTitle(NS_TEMPLATE, 'Navimg');
 do_update_wiki_page($wgTempNavImg, '<div style="position: relative; width: {{{xsize|{{{size|}}}}}}px; height: {{{ysize|{{{size|}}}}}}px; overflow: hidden;"><div style="position: absolute; top: 0; left: 0; font-size: 200pt; width: {{{xsize|{{{size|}}}}}}px; height: {{{ysize|{{{size|}}}}}}px;  overflow: hidden; line-height: {{{ysize|{{{size|}}}}}}px; z-index: 3;">[[:{{{link|}}}|{{{linktext|&nbsp;}}}]]</div><div style="position: absolute; top: 0; left: 0; z-index: 2;">[[Image:{{{image|}}}|{{{xsize|{{{size|}}}}}}px|image page]]</div></div><noinclude>
Simple Usage example:<nowiki> {{navimg|xsize=50|ysize=50|image=Wikimedia-logo.svg|link=MediaWiki}} </nowiki>
</noinclude>
');


}

?>