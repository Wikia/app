use OmegaWiki;
use POSIX qw(strftime);

my $startTime = time;

# Example usage to import UMLS completely into an existing OmegaWiki database:
# my $importer=new OmegaWiki('wikidatadb','root','MyPass');
# $importer->setSourceDB('umls');
# $importer->initialize;
# $importer->importCompleteUMLS();

# Example usage to import a part of UMLS into an existing OmegaWiki database:
# my $importer=new OmegaWiki('wikidatadb','root','MyPass');
# $importer->setSourceDB('umls');
# $importer->initialize;
# my %sourceAbbreviations = $importer->loadSourceAbbreviations();
# delete($sourceAbbreviations{"MSH"});
# $importer->importUMLS(\%sourceAbbreviations);

my $importer=new OmegaWiki('wikidata_icpc','root','');
$importer->setSourceDB('umls');
#$importer->setSourceDB('swissprot');
$importer->initialize;
#$importer->importCompleteUMLS();

#read the source abbreviations and remove those you do not wish to import
my %sourceAbbreviations = $importer->loadSourceAbbreviations();
my @deleteList;
while (($key, $val) = each(%sourceAbbreviations)) {
	
#remove all that contains "MSH":	
#	if (index($key,"MSH") >= 0) {
#		push(@deleteList, $key); 
#	}

#remove all that does not contain "ICPC":
	if (index($key,"ICPC") < 0) {
		push(@deleteList, $key); 
	}
}

foreach $sab (@deleteList){
	delete($sourceAbbreviations{$sab});
}

$importer->importUMLS(\%sourceAbbreviations);


my $endTime = time;
print "\n";
print "Import started at: " . (strftime "%H:%M:%S", localtime($startTime)) . "\n";
print "Import ended at:   " . (strftime "%H:%M:%S", localtime($endTime)) . "\n";
print "Elapsed time:      " . (strftime "%H:%M:%S", gmtime($endTime - $startTime)) . "\n";

exit 0;