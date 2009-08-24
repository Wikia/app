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
	svn export . Widgets
	svn export smarty Widgets/smarty
	# Not including Makefile into the package since it's not doing anything but release packaging
	rm Widgets/Makefile
	tar -c Widgets |gzip > Widgets_${v}.tgz
	zip -r Widgets_${v}.zip Widgets
	rm -rf Widgets
endif
