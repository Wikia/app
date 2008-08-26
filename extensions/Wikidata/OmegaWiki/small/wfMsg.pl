#!/usr/bin/perl


while(<>) {
	s/wfMsg\(\s*\"(ow_)?(.*?)\"(.*?)\)/wfMsg_sc("$2"$3)/;
	s/wfMsg\(\s*\'(ow_)?(.*?)\'(.*?)\)/wfMsg_sc("$2"$3)/;
	print;
}
