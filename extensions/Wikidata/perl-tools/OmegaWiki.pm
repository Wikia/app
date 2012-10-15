# Example usage to import UMLS into an existing OmegaWiki database:
# use OmegaWiki;
# my $importer=new OmegaWiki('wikidatadb','root','MyPass');
# $importer->setSourceDB('umls');
# $importer->initialize;
# $importer->importCompleteUMLS();
#
# NOTE: When importing UMLS, we expect the presence of the semantic network data
# in the tables SRDEF and the manually created tables SEMRELHIER and SEMTYPEHIER.
# SEMRELHIER and SEMTYPEHIER contain information about the relations between
# semantic types and relation types, using RB as the code for "broader than"
# and RN for "narrower than".
#
# Todo for UMLS:
# SyntransCollection
# RelationCollection
# Fully deal with alternative definitions referring to the same concept
# Deal with preferred lexical expressions, primary concepts (general weighting mechanism?)

package OmegaWiki;
use DBI;
use Encode;
use POSIX qw(strftime);

sub new {	
	my $type=shift;
	my $self={};
	$self->{targetdb}=shift;
	$self->{targetuser}=shift;
	$self->{targetpass}=shift;
	$self->{targethost}=shift || 'localhost';
	$self->{targetport}=shift || '3306';
	$self->{targetdriver}=shift || 'mysql';
	bless($self, $type);
	return($self);
}

sub setSourceDB { 
	my $self=shift;
	$self->{sourcedb}=shift;
	$self->{sourceuser}=shift || $self->{targetuser};
	$self->{sourcepass}=shift || $self->{targetpass};
	$self->{sourcehost}=shift || $self->{targethost};
	$self->{sourceport}=shift || $self->{targetport};
	$self->{sourcedriver}=shift || $self->{targetdriver};
}

sub connectSourceDB {
	my $self=shift;
	my $dsn = 'dbi:'.$self->{sourcedriver}.':'.$self->{sourcedb}.':'.$self->{sourcehost}.':'.$self->{sourceport};
	$self->{dbs}=DBI->connect($dsn,$self->{sourceuser},$self->{sourcepass});
}

sub connectTargetDB {
	my $self=shift;
	my $dsn = 'dbi:'.$self->{targetdriver}.':'.$self->{targetdb}.':'.$self->{targethost}.':'.$self->{targetport};
	$self->{dbt}=DBI->connect($dsn,$self->{targetuser},$self->{targetpass});
}

sub connectDBs() {
	my $self = shift;
	
	$self->connectSourceDB();
	$self->connectTargetDB();
}

sub loadLanguages() {
	my $self = shift;

	my %la=$self->loadLangs();
	$self->{la}=\%la;
	my %la_iso=$self->loadLangsIso();
	$self->{la_iso}=\%la_iso;
}

sub initialize {
	my $self=shift;
	$self->connectDBs();
	$self->loadLanguages();	
}

sub importCompleteUMLS {
	my $self=shift;
	my $level=shift || 0; # 0= complete; 1=reltypes+; 2=rel+

	my %sourceAbbreviations = $self->loadSourceAbbreviations();
	$self->importUMLS(\%sourceAbbreviations, $level);
}

sub importUMLS() {
	my $self=shift;
	my $sourceAbbreviationsReference = shift;
	my $level=shift || 0;						# 0= complete; 1=reltypes+; 2=rel+
	
	my %sourceAbbreviations = %{$sourceAbbreviationsReference};
	my %cid=$self->getOrCreateCollections(\%sourceAbbreviations);
	$self->{cid}=\%cid;

	if ($level<1){
		while (($sourceAbbreviation, $collectionId) = each %cid) {
			print "Import UMLS terms for $sourceAbbreviation\n";
			$self->importUMLSterms($sourceAbbreviation, $collectionId);
		}
	}
	
	if($level<2) {
		print "Import UMLS relation types 'REL'\n";
		$self->importUMLSrelationtypes('REL');
		print "Import UMLS relation types 'RELA'\n";
		$self->importUMLSrelationtypes('RELA');
	}

	if($level<3) {
		while (($sourceAbbreviation, $collectionId) = each %cid) {
			my %rt=$self->loadReltypes();
			$self->{reltypes}=\%rt;
			print "Import UMLS relations 'REL' for $sourceAbbreviation\n";
			$self->importUMLSrelations('REL',$sourceAbbreviation);
			print "Import UMLS relations 'RELA' for $sourceAbbreviation\n";
			$self->importUMLSrelations('RELA',$sourceAbbreviation);
		}
	}

	if($level<4) {
		print "Import SN types 'STY'\n";
		$self->importSNtypes('STY');
		print "Import SN types 'RL'\n";
		$self->importSNtypes('RL');
		print "Import ST relations 'STY'\n";
		$self->importSTrelations('STY');
		print "Import ST relations 'RL'\n";		
		$self->importSTrelations('RL');
	#	$self->importSTrelations2();
	}
	
	if($level<5) {
		while (($sourceAbbreviation, $collectionId) = each %cid) {
			my %attribs=$self->loadAttributes();
			$self->{attribs}=\%attribs;
			print "Import UMLS types for $sourceAbbreviation\n";			
			$self->importUMLSstypes($sourceAbbreviation);
		}
	}
}

sub importGEMET {
	my $self=shift;
	$self->connectSourceDB();
	$self->connectTargetDB();
	my %la=$self->loadLangs();
	$self->{la}=\%la;
	my %cid=$self->bootstrapGemetCollection();
	$self->{cid}=\%cid;
	$self->initRel($self->{cid}{'GEMETREL'});
	my %rt=$self->loadReltypes();
	$self->{reltypes}=\%rt;
	$self->importGemetTerms();
	$self->importGemetRelations();
	$self->importGemetThemes();
}

sub importUMLSstypes {
	my $self=shift;
	my $sab=shift;
	
	my $getassocs=$self->{dbs}->prepare("select MRSTY.CUI, MRSTY.STY from MRCONSO,MRSTY where MRCONSO.SAB like ? and MRCONSO.CUI=MRSTY.CUI");
	$getassocs->execute($sab);
	while(my $row=$getassocs->fetchrow_hashref()) {
		my %rv=$self->getMidForMember($row->{CUI});
		my $att=$self->{attribs}{$row->{STY}};
		#print "$rv{mid} is a $row->{STY} ($att)\n";
		$self->addRelation($rv{rid},0,$rv{mid},$att, my $checkfordupes=1);
	}
}

sub getCollections(){
	my $self=shift;
	my %cid;
	$cid{'CRISP'}=$self->findCollection($self->findMeaning($self->findItem('CRISP Thesaurus, 2005',$self->{la}{'en'})));
	$cid{'STY'}=$self->findCollection($self->findMeaning($self->findItem('Semantic Network 2005AC Semantic Types',$self->{la}{'en'})));
	$cid{'RL'}=$self->findCollection($self->findMeaning($self->findItem('Semantic Network 2005AC Relation Types',$self->{la}{'en'})));
	$cid{'REL'}=$self->findCollection($self->findMeaning($self->findItem('UMLS Relation Types 2005',$self->{la}{'en'})));
	$cid{'RELA'}=$self->findCollection($self->findMeaning($self->findItem('UMLS Relation Attributes 2005',$self->{la}{'en'})));
	$cid{'ICPC'}=$self->findCollection($self->findMeaning($self->findItem('The International Classification of Primary Care (ICPC), 1993',$self->{la}{'en'})));
	$cid{'MESH'}=$self->findCollection($self->findMeaning($self->findItem('Medical Subject Headings (MeSH), 2005',$self->{la}{'en'})));
#	$cid{'SP'}=$self->findCollection($self->findMeaning($self->findItem('Swiss-Prot',$self->{la}{'en'})));
	return %cid;
}

sub findCollection() {
	my $self=shift;
	my $mid=shift;
	my $findcoll=$self->{dbt}->prepare("select collection_id from uw_collection_ns where collection_mid=? and is_latest=1");
	$findcoll->execute($mid);
	my $row=$findcoll->fetchrow_hashref();
	return $row->{collection_id};
}

sub getCollection {
	my $self = shift;
	my $expression = shift;
	
	return $self->findCollection($self->findMeaning($self->findExpressionId($expression,$self->{la}{'en'})));
}

sub bootstrapCollection {
	my $self = shift;
	my $expression = shift;
	my $collectionType = shift;
	
	%rv=$self->addExpression($expression,$self->{la}{'en'});
	return $self->addCollection($rv{mid},$collectionType);
}

sub getOrCreateCollection {
	my $self = shift;
	my $expression = shift;

	my $result = $self->getCollection($expression);
	
	if (!$result) {
		$result = $self->bootstrapCollection($expression, '');
	}
	
	return $result;		
}

sub getOrCreateCollections {
	my $self = shift;
	my $sourceAbbreviationsReference = shift;
	my %sourceAbbreviations = %{$sourceAbbreviationsReference};
	my %cid;
	
    while (($key, $value) = each %sourceAbbreviations) {
		$cid{$key}	= $self->getOrCreateCollection($value);
    }

	return %cid;
}

sub loadSourceAbbreviations {
	my $self = shift;
	my %sab;
	
	my $dataset = $self->{dbs}->prepare("select * from mrsab");
	$dataset->execute();
	while (my $row = $dataset->fetchrow_hashref()) {
		$sab{$row->{RSAB}} = $row->{SON};
	}
	return %sab;
}

# SEMTYPEHIER and SEMRELHIER contain only the is_a relationships, whereas
# srstr contains all others
# FIXME: only use SRSTR
sub importSTrelations2 {
	my $self=shift;
	my $getrels=$self->{dbs}->prepare("select * from srstr where rel!='isa'");
	$getrels->execute();
	while(my $row=$getrels->fetchrow_hashref()) {
		my %rv1=$self->getMidForMember($row->{TYPE1},$self->{cid}{'STY'});
		my %rv2=$self->getMidForMember($row->{TYPE2},$self->{cid}{'STY'});
		my $rtmid=$self->{reltypes}{$row->{REL}};
		#print "Adding relation $row->{REL} ($rtmid) between $row->{TYPE1} and $row->{TYPE2}\n";
		$self->addRelation($rv1{rid},$rtmid,$rv1{mid},$rv2{mid},my $checkfordupes=1);
	}
}


sub importSTrelations {	
	my $self=shift;
	my $which=shift;
	my $table;
	my $field1;
	my $field2;
	if($which eq 'STY') {
		$table='semtypehier';
		$field1='SEMTYPE1';
		$field2='SEMTYPE2';
	} elsif($which eq 'RL') {
		$table='semrelhier';
		$field1='RELTYPE1';
		$field2='RELTYPE2';
	}
		
	my $gettypehier=$self->{dbs}->prepare("select * from $table");
	$gettypehier->execute();
	while(my $typehier=$gettypehier->fetchrow_hashref()) {	
		my %rv1=$self->getMidForMember($typehier->{$field1},$self->{cid}{$which});
		my %rv2=$self->getMidForMember($typehier->{$field2},$self->{cid}{$which});
		my $rtmid=$self->{reltypes}{$typehier->{RELATION}};
		print "Adding relation $typehier->{RELATION} ($rtmid) between $typehier->{$field1} and $typehier->{$field2}\n";
		$self->addRelation($rv1{rid},$rtmid,$rv1{mid},$rv2{mid},my $checkfordupes=1);
	}
}

# $member_id - the collection-internal identifier for this member
# $cid The collection in which to search for this member (optional)
# Returns the DefinedMeaningID and the revision id
sub getMidForMember {
	my $self=shift;
	my $member_id=shift;
	my $cid=shift;
	my %rv;
	my $getmid;
	if($cid) {
		$getmid=$self->{dbt}->prepare("select member_mid,revision_id from uw_collection_contents where collection_id=? and internal_member_id=? and is_latest_set=1 limit 1");
		$getmid->execute($cid,$member_id);
	} else {
		$getmid=$self->{dbt}->prepare("select member_mid,revision_id from uw_collection_contents where internal_member_id=? and is_latest_set=1 limit 1");
		$getmid->execute($member_id);
	}
	my $member_mid=$getmid->fetchrow_hashref();
	$rv{mid}=$member_mid->{member_mid};
	$rv{rid}=$member_mid->{revision_id};
	return %rv;

}

sub loadReltypes {
	my $self=shift;
	my %reltypes;
	# Get the relation type
	$getreltype=$self->{dbt}->prepare("select member_mid,internal_member_id from uw_collection_contents,uw_collection_ns where uw_collection_ns.collection_type='RELT' and uw_collection_ns.collection_id=uw_collection_contents.collection_id");
	$getreltype->execute();
	while (my $reltype=$getreltype->fetchrow_hashref()) {
		$reltypes{$reltype->{internal_member_id}}=$reltype->{member_mid};
	}
	return %reltypes;
}

sub loadAttributes {
	my $self=shift;
	my %attributes;
	$getatt=$self->{dbt}->prepare("select member_mid,internal_member_id from uw_collection_contents,uw_collection_ns where uw_collection_ns.collection_type='ATTR' and uw_collection_ns.collection_id=uw_collection_contents.collection_id");
	$getatt->execute();
	while (my $att=$getatt->fetchrow_hashref()) {
		$attributes{$att->{internal_member_id}}=$att->{member_mid};
	}
	return %attributes;
}


# Get all SRDEF attributes
# Get relations between SRDEF
sub importSNtypes {
	my $self=shift;
	my $type=shift;
	$getsemtypes=$self->{dbs}->prepare("select semtypeab,type,definition from srdef where type=?");
	$getsemtypes->execute($type);
	while (my $semtype=$getsemtypes->fetchrow_hashref()) {
		my $type_expression=$semtype->{semtypeab};
		my $type_code=$type_expression;
		$type_expression=~s/_/ /g;
		$type_expression=lc($type_expression);
		my %rv=$self->addExpression($type_expression,$self->{la}{'en'},0,$self->{cid}{$type},$type_code);
		$self->addMeaningText($rv{'rid'},$rv{'mid'},$semtype->{definition},undef,$self->{la}{'en'});	
		#print $type_expression." - $self->{cid}{$type} - $type_code\n";
	}
}

sub importUMLSrelations {
	my $self=shift;
	my $which=shift; # REL or RELA
	my $source=shift; # SAB as MySQL LIKE string
	my $getrels;
	
	if($which eq 'REL') {
		$getrels=$self->{dbs}->prepare("select cui1,cui2,rel from MRREL where sab like ?");
	} elsif($which eq 'RELA') {
		$getrels=$self->{dbs}->prepare("select cui1,cui2,rela from MRREL where sab like ? and rela!=''");
	}
	$getrels->execute($source);
	while(my $rel=$getrels->fetchrow_hashref()) {
		my $relid=$rel->{lc($which)};
		# These mean the same thing
		if($relid eq 'CHD') {
			$relid='RN';			
		} elsif($relid eq 'PAR') {
			$relid='RB';
		}
		$getmid=$self->{dbt}->prepare("select member_mid,revision_id from uw_collection_contents where internal_member_id=? and is_latest_set=1 limit 1");
		# Note that the direction in UMLS is opposite to ours
		$getmid->execute($rel->{cui2});
		my $mid1=$getmid->fetchrow_hashref();
		$getmid->execute($rel->{cui1});
		my $mid2=$getmid->fetchrow_hashref();
		# FIXME: We are ignoring term relations for now!
		if(($mid1->{member_mid} && $mid2->{member_mid}) && ($mid1->{member_mid} != $mid2->{member_mid}) && $self->{reltypes}{$relid}) {
			# Add the relation
			#print "Found relation ".$relid." (".$self->{reltypes}{$relid}.") between ".$mid1->{member_mid}." and ".$mid2->{member_mid}.".\n";
			$self->addRelation($mid1->{revision_id},$self->{reltypes}{$relid},$mid1->{member_mid},$mid2->{member_mid},my $checkfordupes=1);
		} else {
			if(!$mid1->{member_mid} && $mid2->{member_mid}) {
				print "Did not find MID for ".$rel->{cui1}."!\n";
			} elsif($mid1->{member_mid} && !$mid2->{member_mid}) {
				print "Did not find MID for ".$rel->{cui2}."!\n";
			} elsif(!$mid1->{member_mid} && !$mid2->{member_mid}) {
			   print "Did not find MIDs for ".$rel->{cui1}." and ".$rel->{cui2}."!\n";
			}
		}
	}

}


sub bootstrapGemetCollection {
	my $self=shift;
	my %cid;
	%rv=$self->addExpression('GEMET Environmental Thesaurus Relation Types',$self->{la}{'en'});
	$cid{'GEMETREL'}=$self->addCollection($rv{mid},'RELT');
	%rv=$self->addExpression('GEMET Environmental Thesaurus Relation Types',$self->{la}{'en'});
	$cid{'GEMET'}=$self->addCollection($rv{mid},'');
	return %cid;
}


sub bootstrapCollections {
	my $self=shift;
	my %cid;
	my %rv;
	
	%rv=$self->addExpression('CRISP Thesaurus, 2005',$self->{la}{'en'});
	$cid{'CRISP'}=$self->addCollection($rv{mid},'');
	%rv=$self->addExpression('Semantic Network 2005AC Semantic Types',$self->{la}{'en'});
	$cid{'STY'}=$self->addCollection($rv{mid},'ATTR');
	%rv=$self->addExpression('Semantic Network 2005AC Relation Types',$self->{la}{'en'});
	$cid{'RL'}=$self->addCollection($rv{mid},'RELT');
	%rv=$self->addExpression('UMLS Relation Types 2005',$self->{la}{'en'});
	$cid{'REL'}=$self->addCollection($rv{mid},'RELT');
	%rv=$self->addExpression('UMLS Relation Attributes 2005',$self->{la}{'en'});
	$cid{'RELA'}=$self->addCollection($rv{mid},'RELT');
	%rv=$self->addExpression('The International Classification of Primary Care (ICPC), 1993',$self->{la}{'en'});
	$cid{'ICPC'}=$self->addCollection($rv{mid},'');	
	%rv=$self->addExpression('Medical Subject Headings (MeSH), 2005',$self->{la}{'en'});
	$cid{'MESH'}=$self->addCollection($rv{mid},'');
#	%rv=$self->addExpression('Swiss-Prot',$self->{la}{'en'});
#	$cid{'SP'}=$self->addCollection($rv{mid},'');
	return %cid;
}

sub addCollection {
	my $self=shift;
	my $mid=shift;
	my $collection_type=shift;
	my $addcollection=$self->{dbt}->prepare('INSERT INTO uw_collection_ns(collection_mid,is_latest,collection_type) values(?,1,?)');
	$addcollection->execute($mid,$collection_type);
	my $cid=$self->{dbt}->last_insert_id(undef,undef,undef,undef);
	my $updatefirstver=$self->{dbt}->prepare('UPDATE uw_collection_ns set first_ver=? where collection_id=?');
	$updatefirstver->execute($cid,$cid);
	return $cid;
}

sub importUMLSrelationtypes {
	my $self=shift;
	my $which=shift;
	my $getreltypes;
	if($which eq 'REL') {
		# CHD and PAR are to be interpreted as RN and RB, SUBX is not used
		$getreltypes=$self->{dbs}->prepare("select * from rel where ABBREV!='CHD' and ABBREV!='PAR' and ABBREV!='SUBX'");
	} elsif($which eq 'RELA') {
		$getreltypes=$self->{dbs}->prepare("select * from rela");
	}
	$getreltypes->execute();
	while(my $reltype=$getreltypes->fetchrow_hashref()) {
		my %rv=$self->addExpression($reltype->{FULL},$self->{la}{'en'},0,$self->{cid}{$which},$reltype->{ABBREV});
	}
}

sub importUMLSterms {
	my $self=shift;
	my $sab=shift; # the source abbreviation which to import
	my $cid=shift; # which collection to associate the defined meanings with

	$getterm=$self->{dbs}->prepare("select str,cui,lat from MRCONSO where sab like ?");
	$getterm->execute($sab);
	my %textmid;
	while(my $r=$getterm->fetchrow_hashref()) {
		my %rv;
		my $dupe=0;
		my %cuimid=$self->getMidForMember($r->{cui});

		# Create new expression / Defined Meaning
		if(!$cuimid{mid}) {
			%rv=$self->addExpression($r->{str},$self->{la_iso}{lc($r->{lat})},0,$cid,$r->{cui});
			# If this is the first time we encounter this CUI, import the definitions
			# Note that we'll take any definitions, regardless of the SABs specified!
			if($rv{mid}!=-1) {
				$getdefs=$self->{dbs}->prepare("select def from MRDEF where cui=?");
				$getdefs->execute($r->{cui});
				while(my $d=$getdefs->fetchrow_hashref()) {
					# UMLS only has English definitions
					$self->addMeaningText($rv{rid},$rv{mid},$d->{def},0,$self->{la}{'en'});
				}
				$textmid{$rv{mid}}=1;
			}			
		# Add as SynTrans to existing Defined Meaning
		} else {
			%rv=$self->addExpression($r->{str},$self->{la_iso}{lc($r->{lat})},$cuimid{mid});
		}
	}
}


sub importGemetTerms {
	my $self=shift;
	my $cid=shift;
	# Get all English terms as base
	$getterm=$self->{dbs}->prepare("select * from term where langcode=?");
	$getterm->execute('en');
	while($r=$getterm->fetchrow_hashref()) {
		# Add English term as defined meaning
		my %rv=$self->addExpression($r->{name},$self->{la}{'en'},0,);
	
		# All translations
		$gettrans=$self->{dbs}->prepare("select name,langcode from term where id_concept=? and langcode!='en'");
		$gettrans->execute($r->{id_concept});
		# Add them with the same meaning ID
		while($t=$gettrans->fetchrow_hashref()) {
			print "Language: $t->{langcode}\n";
			%tv=$self->addExpression($t->{name},$self->{la}{$t->{langcode}},$rv{mid});
		}
		# All definitions
		$getdef=$self->{dbs}->prepare("select definition,langcode from scope where id_concept=?");
		$getdef->execute($r->{id_concept});
		my $tcid=0;
		while($d=$getdef->fetchrow_hashref()) {
			if(!$tcid) {
				my %mv=$self->addMeaningText($rv{rid},$rv{mid},$d->{definition},0,$self->{la}{$d->{langcode}});
				$tcid=$mv{tcid};
	
			} else {
				$self->addMeaningText($rv{rid},$rv{mid},$d->{definition},$tcid,$self->{la}{$d->{langcode}});
			
			}
		}
	}
}


sub importGemetRelations {
	my $self=shift;
	# Import GEMET relations
	my $getrels=$self->{dbs}->prepare("select * from relation");
	$getrels->execute();
	while(my $rrow=$getrels->fetchrow_hashref()) {
		%rv_A=$self->findGemetItem($rrow->{id_concept});
		%rv_B=$self->findGemetItem($rrow->{id_relation});
		if($rv_A{mid} && $rv_B{mid}) {
			$self->addRelation($rv_A{rid},$self->{reltypes}{$rrow->{id_type}},$rv_A{mid},$rv_B{mid});
		}
	}
}

sub importGemetThemes {
	my $self=shift;
	# Get all themes
	my $getthemes=$self->{dbs}->prepare("select * from theme");
	my $gettheme_set=$self->{dbs}->prepare("select * from theme where id_theme=?");
	$getthemes->execute();
	while(my $theme_row=$getthemes->fetchrow_hashref()) {
		my $theme=$theme_row->{description};
		my @themes=split(/[,;]( ){0,1}/,$theme);
		foreach(@themes) {
			$_=~s/^ *$//i;
			if($_) {
				# Does this theme have a expression?
				my $t=$_;
				my %it=$self->findLatestRevision($t,$self->{la}{$theme_row->{langcode}});
				if($it{liid}) {
					# Get the meaning
					print "NEW THEME: $t - retrieving existing MID for LIID... ".$it{liid};
					$it{mid}=$self->findMeaning($rv{liid});
					print $it{mid}."\n";
					#print $t. " is a dupe! - $dupes\n";
					#$dupes++;
				} else {
					# Do we have any of its translations?
					# We can only add those if the theme does
					# not contain a , - otherwise we can't match!
					my $tra_mid=0;
					if(!($theme_row->{description}=~m/[,;]/i)) {
						print "NEW THEME: $t - no record, looking for its known translations in GEMET\n";
						#print "Checking for translations of ".$theme_row->{description}."\n";	
						$gettheme_set->execute($theme_row->{id_theme});					
						while((my $tra_row=$gettheme_set->fetchrow_hashref()) && !$tra_mid) {
						if($tra_lid=$self->findExpressionId($tra_row->{description},$self->{la}{$tra_row->{langcode}})) {
							$tra_mid=$self->findMeaning($tra_lid);
							
						}
						}
					} else {
						print "NEW THEME: $t - split from the original GEMET data\n";
					}
					# Let's make one
					if($tra_mid) {
						print "Adding new term as translation of $tra_mid\n";	
						%it = $self->addExpression($t,$self->{la}{$theme_row->{langcode}},$tra_mid);
					} else {
						print "Adding new term independently, we do not know its translations.\n";
						%it = $self->addExpression($t,$self->{la}{$theme_row->{langcode}});
					}
					
					
				}
				
				if(!$have_rel{$theme_row->{id_theme}}) {
				# Get all items which have this relation
				my $getconcepts=$self->{dbs}->prepare('select id_concept from concept_theme where id_theme=?');
				$getconcepts->execute($theme_row->{id_theme});
				while(my $concrow=$getconcepts->fetchrow_hashref()) {
					# Get LIID,RID->meaning for the item
					my %tr=$self->findGemetItem($concrow->{id_concept});
					if($tr{rid}) {					
						$self->addRelation($tr{rid},$self->{reltypes}{it},$tr{mid},$it{mid});
						print "Tied up a relation..";
					} else {
						print "Missing record to tie the relation to..";
					}
				}
				print "\n";
				$have_rel{$theme_row->{id_theme}}=1;
				}
	
			}
		}
	}
	#Split theme into parts
}

sub findGemetItem {
	my $self=shift;
	my $concept_id=shift;	
	# get a word, language
	my $getword=$self->{dbs}->prepare("select langcode,name from term where id_concept=? LIMIT 1");
	$getword->execute($concept_id);
	my $wordrow=$getword->fetchrow_hashref();
	
	# find an expression + meaning
	my %rv=$self->findLatestRevision($wordrow->{name},$self->{la}{$wordrow->{langcode}});
	$rv{mid}=$self->findMeaning($rv{liid});
	return %rv;
}

sub addRelation {
	my $self=shift;
	my $revid=shift;
	my $rtid=shift;
	my $mid_A=shift;
	my $mid_B=shift;
	my $checkfordupes=shift;
	
	if($checkfordupes) {
		my $checkRelationDuplicates=$self->{dbt}->prepare('select 1 as one from uw_meaning_relations where meaning1_mid=? and meaning2_mid=? and relationtype_mid=? and is_latest_set=1 limit 1');
		$checkRelationDuplicates->execute($mid_A,$mid_B,$rtid);
		#print "Checking dupe $mid_A, $mid_B, relation type $rtid\n";
		my $dupecheck=$checkRelationDuplicates->fetchrow_hashref();
		if($dupecheck->{one}) {
			print "Duplicate relation, not adding.\n";
			return false;
		}
	}	

	my $newkey= $self->getSetIdWhere('uw_meaning_relations','meaning1_mid',$mid_A) || $self->getMaxId('set_id','uw_meaning_relations');
	my $addrel=$self->{dbt}->prepare('insert into uw_meaning_relations(set_id,meaning1_mid,meaning2_mid,relationtype_mid,is_latest_set,first_set,revision_id) values(?,?,?,?,?,?,?)');
	$addrel->execute($newkey,$mid_A,$mid_B,$rtid,1,$newkey,$revid); 
	
	print "newkey: $newkey\n";
	print "mid_A: $mid_A\n";
	print "mid_B: $mid_B\n";
	print "rtid: $rtid\n";
	print "revid: $revid\n";
}


sub findMeaning {
	my $self=shift;
	my $liid=shift;
	# Search syntrans table
	my $getsyn=$self->{dbt}->prepare("select defined_meaning_id from uw_syntrans where expression_id=?");
	$getsyn->execute($liid);
	my $syn_row=$getsyn->fetchrow_hashref();
	if($syn_row->{defined_meaning_id}) {
		return $syn_row->{defined_meaning_id};
	}
	my $getdm=$self->{dbt}->prepare("select defined_meaning_id from uw_defined_meaning where expression_id=? limit 1");
	$getdm->execute($liid);
	my $dm_row=$getdm->fetchrow_hashref();
	if($dm_row->{defined_meaning_id}) {
		return $dm_row->{defined_meaning_id};
	}
	return 0;
}

# If there already is a meaning text for this DefinedMeaning, it will add the MeaningText as an alternative definition
sub addMeaningText {
	my $self=shift;
	my $rid=shift;
	my $mid=shift;
	my $meaningtext=shift; # optional
	my $meaningtext_set=shift; # optional TCID set to join with
	my $lid=shift; # ID, not code
	my %rv;
	
	# Add text row entry
	my $maketext=$self->{dbt}->prepare('insert into text(old_text) values(?)');
	$maketext->execute($meaningtext);
	# Get text row ID
	$tid=$self->{dbt}->last_insert_id(undef,undef,undef,undef);
	# Get new or existing translated content set ID
	$tcid=$meaningtext_set || $self->getMaxId('set_id','translated_content');
	# Create new translated content set
	my $maketc=$self->{dbt}->prepare('insert into translated_content(set_id,language_id,text_id,first_set,revision_id) values(?,?,?,?,?)');
	$maketc->execute($tcid,$lid,$tid,$tcid,$rid);
	$rv{tcid}=$tcid;

	# THIS DOESN'T WORK FOR DEFINITIONS IN MULTIPLE LANGUAGES
	# Check if a meaning text has already been set
	my $lookformeaning=$self->{dbt}->prepare('select meaning_text_tcid from uw_defined_meaning where defined_meaning_id=? and is_latest_ver=1');
	$lookformeaning->execute($mid);
	my $mrow=$lookformeaning->fetchrow_hashref();
	if($mrow->{meaning_text_tcid}) {
		# There is a meaning text - the new one is only an alternative
		my $altset=$self->getSetIdWhere('uw_alt_meaningtexts','meaning_mid',$mid) || $self->getMaxId('set_id','uw_alt_meaningtexts');
		my $addaltmeaning=$self->{dbt}->prepare('insert into uw_alt_meaningtexts(set_id,meaning_mid,meaning_text_tcid,is_latest_set,first_set,revision_id) values(?,?,?,?,?,?)');
		$addaltmeaning->execute($altset,$mid,$tcid,1,$altset,$rid)
	} else {
		my $updatemeaning=$self->{dbt}->prepare('update uw_defined_meaning set meaning_text_tcid=? where defined_meaning_id=?');
		$updatemeaning->execute($tcid,$mid);
 	}
	return %rv;
}


# If the expression already exists, add a new DefinedMeaning - unless this is a translation or synonym; if a record already exists in SynTrans with this expression _and_ $translation_of as a DefinedMeaning, do not do anything
sub addExpression {
	my $self=shift;
	# return MID, RID, LID, TCID!
	my $expression=shift;
	my $lid=shift; # ID, not code
	my $translation_of=shift; # 0 or MID (!), optional
	my $collection_id=shift; # optional
	my $collection_internal_member_id=shift; # what does the collection use to refer to this member?
	my %rv;
	my $isdupe=0;
	my %firv=$self->findLatestRevision($expression,$lid);
	if($firv{liid}) { $isdupe=1; }

	if(!$isdupe) {
	
		#create page
		my $pt=$self->canonize($expression);
		$makepage=$self->{dbt}->prepare('insert into page(page_namespace,page_title,page_is_new,page_title_language_id,page_touched) values(?,?,?,?,?)');
		$makepage->execute(16,$pt,1,$lid,$self->mwtimestamp());
		$pid=$self->{dbt}->last_insert_id(undef,undef,undef,undef);
		print "PID: $pid\n";
		
		$rv{pid}=$pid;
		
		#create revision
		$makerev=$self->{dbt}->prepare('insert into revision(rev_page,rev_comment,rev_user,rev_user_text,rev_timestamp) values(?,?,?,?,?)');
		$makerev->execute($pid,'Initial import',2,'GEMET',$self->mwtimestamp());
		
		#get revision_id
		$rid=$self->getId('select rev_id from revision where rev_page=?',$pid);
		$rv{rid}=$rid;
		
		#update page to link to revision
		$updatepage=$self->{dbt}->prepare('update page set page_latest=? where page_id=?');
		$updatepage->execute($rid,$pid);
		
		#create expression
		$makeitem=$self->{dbt}->prepare('insert into uw_expression_ns(spelling,language_id,is_latest) values(?,?,1)');
		$makeitem->execute($expression,$lid);
		$liid=$self->{dbt}->last_insert_id(undef,undef,undef,undef);
		$rv{liid}=$liid;
		
		# update firstver
		$updateitem=$self->{dbt}->prepare('update uw_expression_ns set first_ver=? where expression_id=?');
		$updateitem->execute($liid,$liid);
		
		#update revision to link to expression
		$updaterev=$self->{dbt}->prepare('update revision set rev_data_id=? where rev_id=?');
		$updaterev->execute($liid,$rid);
		
	} else {
	
		$rid=$firv{rid};	
		$liid=$firv{liid};
		$rv{rid}=$rid;
		$rv{liid}=$liid;
		
	}
	
	#create definedmeaning
	if(!$translation_of) {
		$makemean=$self->{dbt}->prepare('insert into uw_defined_meaning(expression_id,revision_id) values(?,?)');
		$makemean->execute($liid,$rid);
		# We always want a syntrans record, so in this case it links to its own
		# def. meaning
		$translation_of=$self->{dbt}->last_insert_id(undef,undef,undef,undef);
		$mid=$translation_of;	
		$rv{mid}=$mid;
		$updatemeaningver=$self->{dbt}->prepare('update uw_defined_meaning set first_ver=? where defined_meaning_id=?');
		$updatemeaningver->execute($mid,$mid);
		if($collection_id) {
			$addtocoll=$self->{dbt}->prepare('insert into uw_collection_contents(set_id, collection_id, member_mid, is_latest_set, first_Set, revision_id, internal_member_id) values(?,?,?,?,?,?,?)');
			#fixme set association
			$addtocoll->execute(1,$collection_id,$mid,1,1,$rid,$collection_internal_member_id);
		}
	}
	
	# Check if we already have this specific record
	$checkdupes=$self->{dbt}->prepare('select set_id from uw_syntrans where defined_meaning_id=? and expression_id=?');
	$checkdupes->execute($translation_of,$liid);
	my $duperow=$checkdupes->fetchrow_hashref();
	my $dupeid=$duperow->{set_id};
	if(!$dupeid) {
	
		# Check if this is part of a set
		$getset=$self->{dbt}->prepare('select set_id from uw_syntrans where defined_meaning_id=? and is_latest_set=1');
		$getset->execute($mid);
		$row=$getset->fetchrow_hashref();
		my $setid=$row->{set_id} || $self->getMaxId('set_id','uw_syntrans');
		# Add syntrans record
		$maketrans=$self->{dbt}->prepare('insert into uw_syntrans(set_id,defined_meaning_id,expression_id,first_set,revision_id,is_latest_set,endemic_meaning) values(?,?,?,?,?,1,1)');
		$maketrans->execute($setid,$translation_of,$liid,$setid,$rid);
		$rv{setid}=$setid;
		$rv{mid}=$translation_of;
	} else{
		$rv{setid}=$dupeid; # Dupe
		$rv{mid}=-1; # Dupe
	}
	return %rv;
	
}

sub findLatestRevision {
	my $self = shift;
	my $expressionSpelling = shift;
	my $languageId = shift;
    
    my $expressionId = $self->findExpressionId($expressionSpelling, $languageId);
    if ($expressionId != 0) {
		my $getRevisionId = $self->{dbt}->prepare('select rev_id from revision where rev_data_id=?');
		$getRevisionId->execute($expressionId);
		my %revision;
		$revision{liid} = $expressionId;
		$revision{rid} = $getRevisionId->fetchrow_hashref->{rev_id};
		return %revision;
    } else {
    	return 0;
    }
}

sub findExpressionId {
	my $self = shift;
	my $expressionSpelling = shift;
	my $languageId = shift;
	
	my $getItem = $self->{dbt}->prepare("select expression_id from uw_expression_ns where spelling=binary ? and language_id=? and is_latest=1");
	$getItem->execute($expressionSpelling, $languageId);
	my $itemRow = $getItem->fetchrow_hashref();
	if ($itemRow) {
		return $itemRow->{expression_id};
	} else {
		return 0;
	}
}

sub getMaxId {
	my $self=shift;
	my $field=shift;
	my $table=shift;
	$getmax=$self->{dbt}->prepare("select max($field) as maxset from $table");
	$getmax->execute();
	my $row=$getmax->fetchrow_hashref();
	return $row->{maxset}+1;
}

sub getSetIdWhere {
	my $self=shift;
	my $table=shift;
	my $wherefield=shift;
	my $wherekey=shift;
	$getmax=$self->{dbt}->prepare("select set_id from $table WHERE $wherefield=? AND is_latest_set=1 limit 1");
	$getmax->execute($wherekey);
	my $row=$getmax->fetchrow_hashref();
	return $row->{set_id};
}


sub getId {
	my $self=shift;
	my $prep=shift;
	$prep=~m/select (.*?) from/i;
	my $field=$1;
	my $getlang=$self->{dbt}->prepare($prep);
	$getlang->execute(@_);
	my $row=$getlang->fetchrow_hashref();
	my $id=$row->{$field};
	return $id;
}

sub mwtimestamp {
	my $self=shift;
	use POSIX qw(strftime);
	return(strftime "%Y%m%d%H%M%S", localtime);
}


sub canonize {
	my $self=shift;
	my $title=shift;
	#$title=ucfirst($title);
	$title=~s/ /_/ig;
	return $title;
}

sub initlangs {
	my $self=shift;
	%langs=(
	en_en=>'English',
	en_de=>'Englisch',
	'en-US_de'=>'Englisch (USA)',
	'en-US_en'=>'English (United States)',
	bg_en=>'Bulgarian',
	bg_de=>'Bulgarisch',
	cs_en=>'Czech',
	cs_de=>'Tschechisch',
	da_en=>'Dansk',
	da_de=>'D?isch',
	de_en=>'German',
	de_de=>'Deutsch',
	es_en=>'Spanish',
	es_de=>'Spanisch',
	et_en=>'Estonian',
	et_de=>'Estnisch',
	eu_en=>'Basque',
	eu_de=>'Baskisch',
	fi_en=>'Finnish',
	fi_de=>'Finnisch',
	fr_en=>'French',
	fr_de=>'Franz?isch',
	hu_en=>'Hungarian',
	hu_de=>'Ungarisch',
	it_en=>'Italian',
	it_de=>'Italienisch',
	nl_en=>'Dutch',
	nl_de=>'Niederl?disch',
	no_en=>'Norwegian',
	no_de=>'Norwegisch',
	pl_en=>'Polish',
	pl_de=>'Polnisch',
	pt_en=>'Portuguese',
	pt_de=>'Portugiesisch',
	ru_en=>'Russian',
	ru_de=>'Russisch',
	sk_en=>'Slovak',
	sk_de=>'Slowakische Sprache',
	sl_en=>'Slovenian',
	sl_de=>'Slowenisch',
	el_en=>'Greek',
	el_de=>'Griechisch',
	sv_en=>'Swedish',
	sv_de=>'Schwedisch');
	foreach(keys(%langs)) {
		$key=$_;
		$key=~m/(.*?)_(.*)/i;
		$lang=$1;
		#print "Lang: $lang\n";
		$wordlang=$2;
		if($wordlang eq 'en') {
			$addwm=$self->{dbt}->prepare("insert into language(wikimedia_key) values(?)");
			$addwm->execute($lang);
		}
	}
	foreach(keys(%langs)) {
		$key=$_;
		$key=~m/(.*?)_(.*)/i;
		$lang=$1;
		#print "Lang: $lang\n";
		$wordlang=$2;
		$langword_u=$langs{$key};
		$langword=encode("utf8",$langword_u);
		$newwm=$self->{dbt}->prepare("select language_id from language where wikimedia_key=?");
		$newwm->execute($lang);	
		my $row=$newwm->fetchrow_hashref();
		$newwm->execute('en');
		my $en_row=$newwm->fetchrow_hashref();
		$newwm->execute('de');
		my $de_row=$newwm->fetchrow_hashref();
		$newword=$self->{dbt}->prepare("insert into language_names values (?,?,?)");
		if($wordlang eq 'en') {
			$newword->execute($row->{language_id},$en_row->{language_id},$langword);
		} elsif($wordlang eq 'de') {
			$newword->execute($row->{language_id},$de_row->{language_id},$langword);
		}
	}
}

sub initRel {
	my $self=shift;
	my $cid=shift;
	%rel_types=(
	bt_en=>'broader terms',
	bt_de=>'breitere Begriffe',
	nt_en=>'narrower terms',
	nt_de=>'engere Begriffe',
	rt_en=>'related terms',
	rt_de=>'verwandte Begriffe',
	it_en=>'is part of theme',
	it_de=>'ist Themenbestandteil von'
	);
	
	%rel_definitions=(
	bt_en=>'Those terms in a thesaurus which are broader than others',
	bt_de=>'Die Begriffe in einem Thesaurus, die breiter sind als andere',
	nt_en=>'Those terms in a thesaurus which are narrower than others',
	nt_de=>'Die Begriffe in einem Thesaurus, die enger sind als andere',
	rt_en=>'Those terms in a thesaurus which are related to others',
	rt_de=>'Die Begriffe in einem Thesaurus, die mit anderen verwandt sind',
	it_en=>'Those terms in a thesaurus or dictionary which are associated with a topic',
	it_de=>'Die Begriffe in einem Thesaurus oder Woerterbuch, die mit einem Thema assoziiert sind');
	
	foreach(keys(%rel_types)) {
		$key=$_;
		$key=~m/(..)_(..)/i;
		$ident=$1;
		$lang=$2;
		if($lang eq 'de') {
			$en_key="$ident\_en";	
			my %rv=$self->addExpression($rel_types{$en_key},$self->{la}{'en'},0,$cid,$ident);
			$self->addMeaningText($rv{rid},$rv{mid},$rel_definitions{$en_key},0,$self->{la}{'en'});
			my %dv=$self->addExpression($rel_types{$key},$self->{la}{'de'},$rv{'mid'});
			$self->addMeaningText($dv{rid},$dv{mid},$rel_definitions{$key},$rv{'tcid'},$self->{la}{'de'});
		}
	}
}

sub loadLangs {
	my $self=shift;
	my %la;
	$getlangs=$self->{dbt}->prepare('select language_id,wikimedia_key from language');
	$getlangs->execute();
	while($langrow=$getlangs->fetchrow_hashref()) {
		$la{$langrow->{wikimedia_key}}=$langrow->{language_id};
	}
	return %la;
}

sub loadLangsIso {
	my $self=shift;
	my %la_iso;
	$getlangs=$self->{dbt}->prepare('select language_id,iso639_2 from language');
	$getlangs->execute();
	while($langrow=$getlangs->fetchrow_hashref()) {
		$la_iso{$langrow->{iso639_2}}=$langrow->{language_id};
	}
	return %la_iso;
}

return(1);
