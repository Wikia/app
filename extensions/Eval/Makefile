help all:
	@echo options:
	@printf "\tinstall: get GeSHi from CVS into this directory\n"
	@printf "\tupdate: update GeSHi from CVS\n"
	@printf "\tclean: remove the GeSHi directory\n"
	@printf "\thelp: this help message\n"
install:
	cvs -d:pserver:anonymous:@cvs.sourceforge.net:/cvsroot/geshi login
	cvs -z3 -d:pserver:anonymous@cvs.sourceforge.net:/cvsroot/geshi co -P geshi-1.0.X
	
	mv geshi-1.0.X/src/ geshi
	rm -rf geshi-1.0.X/
update:
	cd geshi/ && cvs up -dP
clean:
	rm -rf geshi/
