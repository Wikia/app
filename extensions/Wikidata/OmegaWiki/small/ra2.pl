#!/usr/bin/perl
use strict;
#Replace attribs 2 (

# seeks out the attributes globals and replaces them with rather more sane code
# (currently only used on OmegaWikiAttributes)
# still leaves a small amount of mess at times (since I'm running line-by line, which I really
# probably shouldn't, should probably go statement-by-statement instead)


my $global=0; # state variable: are we inside a (multiline?) php 'global' statement
my $statement="";

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
	if (/\;/) {
		if ($global) {
			if ($statement=~/\$(\w+)(Attributes?|Structure)/g) {
				$statement=~s/\$(\w+)(Attributes?|Structure)\;/;/g;
				$statement=~s/\$(\w+)(Attributes?|Structure)\W//gm;
				#$statement=~s/;/ ,;/ if $statement=~/global.*\$\w*(.*);/gs; # if there are still params left, we need a comma
				#$statement=~/^(\s*).*/;	
				#my $indent=$1;
				#$statement=~s/;/\$omegaWikiAttributes;\n$indent\$o=\$omegaWikiAttributes/g;
			}
			$statement=~s/.*global\s*;\s*//gs; # perhaps the global statement is entirely redundant?
			$statement=~s/^\s*$//gm; # remove empty lines (redundant now?)
			$global=0; # end of global statement
		}
		$statement=~s/\$o\s*=\s*\$omegaWikiAttributes;/\$o=OmegaWikiAttributes::getInstance();/g;
		#$statement=~s/\$(\w+)Attribute(\W)/\$o\-\>$1$2/g;
		#$statement=~s/\$(\w+)Attributes(\W)/\$o\-\>$1Attributes$2/g;
		#$statement=~s/\$(\w+)Structure(\W)/\$o\-\>$1Structure$2/g;

		print $statement;
		$statement="";
		
	} 
	

}
