#!/usr/bin/perl -sw

package WikiText::ParseHeadings;

# Parses out headings from wikitext

my $structure = [];
my $pointer = { 0 => $structure };
my $content_buffer;
my $level = 0;

sub parse_line {
	my ($unused, $_) = @_;
	
	my $orig = $_;
	s/\s*$//g;
	
	if (m/^(\=+)\s*(.*?)\s*\=+$/) {
		$level = length($1)-1;
		my $insertLevel = $level - 1;
		
		push @{$pointer->{$level}}, $content_buffer;
		my $insert = { 'title' => $2, 'content' => [] };
		push @{$pointer->{$insertLevel}}, $insert;
		
		$pointer->{$level} = $insert->{'content'};
	} else {
		$content_buffer .= $orig;
	}
}

sub finish_parse {
	push @{$pointer->{$level}}, $content_buffer;
}

sub reset_state {
	$structure = [];
	$pointer = { 0 => $structure };
	$content_buffer = '';
	$level = 0;
}

sub structure { return $structure; }

1;
