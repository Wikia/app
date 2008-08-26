#!/usr/bin/perl
use strict;
use Data::Dumper;
#Replace attribs 2 (

# seeks out the attributes globals and replaces them with rather more sane code
# still leaves a small amount of mess at times 
# I should still watch out for scope

sub joinpairs {
	my @a=@_;
	my @b;
	for(my $pointer=0;$pointer<$#a;$pointer+=2) {
		push (@b, [$a[$pointer], $a[$pointer+1]]);
	}
	return \@b;
}

my $global=0; # state variable: are we inside a (multiline?) php 'global' statement
my $statement="";
my $block_num=0; # the next number we shall assign to a block
my @block_stack=0; # your actual current block number is $block_stack[0] (ie, peek the stack)
my %globals;
while(<>) {
	if (/global/) {
		$global=1; #start of global statement 
		print $statement;
		$statement="";
	}

	#if ($global) {
	#	s/\$(\w+)(Attributes?|Structure)\;/;/g;
	#	s/\$(\w+)(Attributes?|Structure)\W//g;
	#	s/^\s*$//; # remove empty lines
	#}	
	$statement.=$_;


	# This makes some evil assumptions, but we're just
	# trying to _cut down_ on the number of errors, we don't
	# eliminate them entirely, since we're just running this 
	# script once, after all
	if (/\{/) { # Block start
		$block_num++;	
		unshift(@block_stack, $block_num);
	}
	
	if (/\}/) { #Block end
		my $end=shift(@block_stack);
	}
	
	if (/\;/) { #found a statement terminator. 
		if (not $statement=~/^\s*\/\// or $statement=~/^\s*\#/) {
			my @matches=[];
				$statement=~/^(\s*).*/;	
				my $indent=$1;
			if ($global) {
				@matches=($statement=~/\$(\w+)(Attributes?|Structure)\W/g);
				if (@matches) {
					$globals{$block_stack[0]}=joinpairs(@matches);
					$statement=~s/\$(\w+)(Attributes?|Structure)\;/;/g;
					$statement=~s/\$(\w+)(Attributes?|Structure)\W//gm;
					#$statement=~s/;/ ,;/ if $statement=~/global.*\$\w*(.*);/gs; # if there are still params left, we need a comma
					print "\n${indent}\$o=OmegaWikiAttributes::getInstance();\n";
					#my $target=";\n${indent}\$o=OmegaWikiAttributes::getInstance();";
					#$statement=~s/;/$target/g;
					
				}
				$statement=~s/,\s*;/;/gm; # remove redundant trailing commas 
				$statement=~s/.*global\s*;\s*//gs; # perhaps the global statement is entirely redundant?
				$statement=~s/^\s*$//gm; # remove empty lines (redundant now?)
				$global=0; # end of global statement
			}
			#$statement=~s/\$o\s*=\s*\$omegaWikiAttributes;/\$o=OmegaWikiAttributes::getInstance();/g;

			my @tomatch; #matching only those vars found in the global statement
			foreach my $block (@block_stack){
				#print "$block\n";
				if ($globals{$block}) {
					my $items=$globals{$block};
					push(@tomatch, @$items);
				}
			}

			foreach my $item (@tomatch) {
				my $name=@$item[0];
				my $type=@$item[1];
				my $ending=$type unless $type eq "Attribute";
				#print ">>>> n: $name t: $type e: $ending\n";
				$statement=~s/\$${name}${type}(\W)/\$o\-\>${name}${ending}$1/gm;
			}
			$statement=~s/->getAttributeValue\(\s*\$o->(\w+)\s*\)/->$1/g;
			$statement=~s/\-\>setAttributeValue\(\s*\$o->(\w+)\s*,\s*(.*)\s*\)/->$1 = $2/g;
			#print $block_stack[0].": ".$statement; # and peek too
			#print "[".join(", ",@block_stack)."]\n";
		}
		print $statement; # Write out this statement
	
		$statement="";	# and start on a new one.
		
	} 
	#print $block_stack[0].": ".$_;
}
print $statement;	# flush out any remaining lines
#print Dumper(%globals);

