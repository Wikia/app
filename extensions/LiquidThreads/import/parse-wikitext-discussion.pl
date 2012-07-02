#!/usr/bin/perl -sw

use JSON;
use YAML;
use WikiText::ParseHeadings;
use WikiText::ParseDiscussion;

WikiText::ParseHeadings->reset_state();

while (<>) {
	WikiText::ParseHeadings->parse_line($_);
}

WikiText::ParseHeadings->finish_parse();

my $topLevelStructure = WikiText::ParseHeadings->structure;

recursiveParseStructure( $topLevelStructure );

sub recursiveParseStructure {
	my ($structure, $parent) = @_;
	
	if (ref $structure eq 'HASH') {
		#print "Processing section ".$structure->{'title'}."\n";
		recursiveParseStructure( $structure->{'content'}, $structure );
	} elsif (ref $structure eq 'ARRAY') {
		foreach my $subitem (@$structure) {
			recursiveParseStructure($subitem, $structure);
		}
	} else {
		WikiText::ParseDiscussion->reset_state();
		
		my @lines = split /[\r\n]+/, $structure;
		
		foreach my $line (@lines) {
			WikiText::ParseDiscussion->input_line($line);
		}
		
		@$parent = WikiText::ParseDiscussion->get_posts;
	}
}

print encode_json( $topLevelStructure );
