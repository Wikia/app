#!/usr/bin/perl -sw

package WikiText::ParseDiscussion;

## Package for parsing discussions set out in wikitext, with signatures etc.
## Currently does not attempt to alter threading, owing to the inconsistent and confusing
##  indentation standards across wikis, discussion pages and users.
## May or may not blow up when people quote each other's posts, this is pretty rough and
##  ready

use YAML;

my $posts;
my $current_post;
my $signatureLinkRegex = ## srsly
	qr/\[\[(?: (?: User[ _](?: talk)?:)|(?: Special:Contributions\/) )([^\[\]|]+)(?: \|[^\[\]]*)?\]\]/xi;

sub reset_state {
	$posts = [];
	$current_post = { 'content' => '' };
}

sub input_line {
	my ($unused,$line) = @_;
	
	## Check for blank posts.
	$line =~ s/\s*$//g;
	if (!$line) { return; }
	
	$line =~ s/^:+\s*//g;
	
	## Add to the content.
	$current_post->{'content'} .= $line;
	
	if ($line =~ /\d{2}:\d{2}, \d{1,2} \w+ \d{4} \(UTC\)/) {
		$current_post->{'timestamp'} = $&;
		## Finishes with a timestamp, must be a comment.
		my @signatureLikeLinks = ($line =~ /$signatureLinkRegex/g );
		
		$current_post->{'user'} = pop @signatureLikeLinks;
		
		push @$posts, $current_post;
		
		$current_post = { 'content' => '' };
	}
}

sub get_posts {
	return $posts;
}

reset;
1;
