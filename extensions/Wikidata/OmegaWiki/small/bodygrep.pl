#!/usr/bin/perl
use strict;
use Data::Dumper;
# func_grep that returns entire function bodies.


my $search_term=shift;

my $function=0; # state variable: are we inside a function?
my $statement="";
my $block_num=0; # the next number we shall assign to a block
my @block_stack=0; # your actual current block number is $block_stack[0] (ie, peek the stack)
my @function_stack;
my @class_stack;
my %globals;
my $pretty_newline=0;
my $body="";
my $line=0;
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
		if (/function/ && /$search_term/) {
			unshift (@function_stack,[$block_num,$line,1]); 
			$function=1;
		}
		$pretty_newline=0;
	}
	
	$body.=$_ if $function;

	if (/\}/) { #Block end
		my $end=shift(@block_stack);
		if ($end==$function_stack[0][0]) {
			my $fn_data=shift (@function_stack);
			my $fn_line=@$fn_data[1];
			print "\n" if $pretty_newline;
			$pretty_newline=0;
			if ($function) {
				my $class=$class_stack[0][1];
				if ($class_stack[0][2]) { #2 already shown?
					print "$class";
					$class_stack[0][2]=0;
				}
				print "$fn_line:$body";
				$body="";
				$function=0;
			}

			$pretty_newline=1;
		}

		if ($end==$class_stack[0][0]) {
			shift (@class_stack);
			print "\n" if $pretty_newline;
			$pretty_newline=0;
		}
	}
	
}

