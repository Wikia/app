#!/bin/bash
export myfile=$1; 

small/apiview.pl  $myfile > $myfile.new && 
	mv $myfile.new $myfile
