#!/usr/bin/perl -sw

use JSON;
use YAML;
use WikiText::ParseHeadings;

WikiText::ParseHeadings->reset();

while (<>) {
	WikiText::ParseHeadings->parse_line($_);
}

WikiText::ParseHeadings->finish_parse();
print Dump( WikiText::ParseHeadings->structure );
