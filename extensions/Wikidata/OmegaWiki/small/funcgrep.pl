#!/usr/bin/perl
use strict;
use Data::Dumper;
# simple variant on grep, reports class and function names that match.


my $search_term=shift;

my $global=0; # state variable: are we inside a (multiline?) php 'global' statement
my $statement="";
my $block_num=0; # the next number we shall assign to a block
my @block_stack=0; # your actual current block number is $block_stack[0] (ie, peek the stack)
my @function_stack;
my @class_stack;
my %globals;
my $line=0;
my $pretty_newline=0;
while(<>) {

	$line++;
	# This makes some evil assumptions, but we're just
	# trying to _cut down_ on the number of errors, we don't
	# eliminate them entirely, since we're just running this 
	# script once, after all
	if (/\{/) { # Block start
		$block_num++;	
		unshift(@block_stack, $block_num);
		if (/class/) {
			unshift (@class_stack, [$block_num,"$line: $_",1]); # [block num, match, flag already shown]
		}
		if (/function/) {
			unshift (@function_stack,[$block_num,"$line: $_",1]); 
		}
		$pretty_newline=0;
	}
	
	if (/\}/) { #Block end
		my $end=shift(@block_stack);
		if ($end==$function_stack[0][0]) {
			shift (@function_stack);
			print "\n" if $pretty_newline;
			$pretty_newline=0;
		}
		if ($end==$class_stack[0][0]) {
			shift (@class_stack);
			print "\n" if $pretty_newline;
			$pretty_newline=0;
		}
	}
	
	if (/$search_term/) {
		my $function=$function_stack[0][1]; #1 : line string. (0 is used for identifying the correct block)
		my $class=$class_stack[0][1];
		if ($class_stack[0][2]) { #2 already shown?
			print "$class";
			$class_stack[0][2]=0;
		}
		if ($function_stack[0][2]) {
			print "	$function"; 
			$function_stack[0][2]=0;
		}
		my $match;
		$match="$line: $_";
		if ($match ne $function && $match ne $class) { # prevent reporting matching function or class names twice
			print "		$match"; 
		}
		$pretty_newline=1;
	}
}

