all:

rel:	release
release:
ifndef v
	# Must specify version as 'v' param
	#
	#   make rel v=1.1.1
	#
else
	#
	# Tagging it with release tag
	#
	svn copy . svn+ssh://sergeychernyshev@svn.wikimedia.org/svnroot/mediawiki/tags/extensions/Widgets/REL_${subst .,_,${v}}/
	#
	# Creating release tarball and zip
	#
	svn export http://svn.wikimedia.org/svnroot/mediawiki/tags/extensions/Widgets/REL_${subst .,_,${v}}/ Widgets
	# Not including Makefile into the package since it's not doing anything but release packaging
	rm Widgets/Makefile
	tar -c Widgets |gzip > Widgets_${v}.tgz
	zip -r Widgets_${v}.zip Widgets
	rm -rf Widgets

	# upload to Google Code repository (need account with enough permissions)
	googlecode/googlecode_upload.py -s "MediaWiki Widgets Extension v${v} (tarball)" -p mediawiki-widgets -l "Featured,Type-Archive,OpSys-All" Widgets_${v}.tgz
	googlecode/googlecode_upload.py -s "MediaWiki Widgets Extension v${v} (zip)" -p mediawiki-widgets -l "Featured,Type-Archive,OpSys-All" Widgets_${v}.zip
	rm Widgets_${v}.tgz Widgets_${v}.zip
endif
