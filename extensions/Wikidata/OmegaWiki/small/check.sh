#!/bin/bash
export myfile=$1; 

small/wfMsg.pl $myfile 		|
	diff -dy $myfile - 	| 
	less
