#!/usr/bin/perl

my $myclass="";
while(<>) {
	if (/class/){
		$myclass=$_;
	}
	s/function(.*?)(\(.*$)/function$1$2\nwfDebug("$myclass--$1\\n");\n/;
	print;
}
