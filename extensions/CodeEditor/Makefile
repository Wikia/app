# Helper to pull the ace goodies

.PHONY: all clean refresh

all: refresh

clean:
	rm -rf modules/ace ace-git

refresh: ace-git
	test -d modules/ace || mkdir modules/ace
	(cd ace-git && git checkout master && git pull origin master)
	rsync -av ace-git/build/src/ modules/ace/
	cp ace-git/LICENSE modules/ace/LICENSE

ace-git:
	git clone git://github.com/ajaxorg/ace.git ace-git

