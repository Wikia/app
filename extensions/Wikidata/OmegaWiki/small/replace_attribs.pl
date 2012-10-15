#!/usr/bin/perl

# seeks out the attributes globals and replaces them with rather more sane code
# (currently only used on OmegaWikiAttributes)
# still leaves a small amount of mess at times (since I'm running line-by line, which I really
# probably shouldn't, should probably go statement-by-statement instead)


$global=0; # state variable: are we inside a (multiline?) php 'global' statement?

while(<>) {
	if (/global/) {
		$global=1; #start of global statement 
	}

	if ($global) {
		s/\$(\w+)(Attributes?|Structure)\;/;/g;
		s/\$(\w+)(Attributes?|Structure)\W//g;
		s/^\s*$//; # remove empty lines
	}		

	if (/\;/) {
		$global=0; # end of global statement
	}

	s/\$(\w+)Attribute(\W)/\$t\-\>$1$2/g;
	s/\$(\w+)Attributes(\W)/\$t\-\>$1Attributes$2/g;
	s/\$(\w+)Structure(\W)/\$t\-\>$1Structure$2/g;
	print
}
