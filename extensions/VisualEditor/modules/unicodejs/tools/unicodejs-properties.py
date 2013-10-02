#!/usr/bin/env python

"""Generates unicodejs.*properties.js from Unicode data"""

import re, urllib2

for breaktype in ['Grapheme', 'Word']:
	# a list of property name strings like "Extend", "Format" etc
	properties = []

	# range[property] -> character range list e.g. [0x0040, [0x0060-0x0070], 0x00A3, ...]
	ranges = {}

	# Analyse unicode data file
	url = "http://www.unicode.org/Public/UNIDATA/auxiliary/" + breaktype + "BreakProperty.txt"
	for line in urllib2.urlopen( url ):
		line = line.strip()
		# Ignore comment or blank lines
		if re.search( r"^\s*(#|$)", line ): continue
		# Find things like one of the following:
		#   XXXX       ; propertyname
		#   XXXX..YYYY ; propertyname
		m = re.search( r"^([0-9A-F]{4,5})(?:\.\.([0-9A-F]{4,5}))?\s*;\s*(\w+)\s*#", line )
		if not m:
			raise ValueError( "Bad line: %r" % line )
		start, end, prop = m.groups()
		if start == 'D800' and end == 'DFFF':
			continue # raw surrogates are not treated

		if not ranges.has_key( prop ):
			properties.append( prop )
		ranges.setdefault( prop, [] ).append( (start, end) )

	# Translate ranges into js fragments
	fragments = []
	for prop in properties:
		rangeStrings = []
		for start, end in ranges[prop]:
			if not end:
				rangeStrings.append( "0x" + start )
			else:
				rangeStrings.append( "[0x" + start + ", 0x" + end + "]" )
		fragments.append( "'" + prop + "': [" + ", ".join( rangeStrings ) + "]" )

	# Write js file
	js = "unicodeJS." + breaktype.lower() + "breakproperties = {\n\t"
	js += ",\n\t".join( fragments )
	js += "\n};\n"
	jsFilename = "../unicodejs." + breaktype.lower() + "breakproperties.js"
	open( jsFilename, "w" ).write( js )
	print "wrote " + jsFilename
