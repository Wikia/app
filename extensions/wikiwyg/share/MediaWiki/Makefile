.PHONY: all clean split-js

COMBINED_FILE=MediaWikiWyg.js

ALL_JS_SOURCE_FILES= \
	../../lib/Wikiwyg.js \
	../../lib/Wikiwyg/Util.js \
	../../lib/Wikiwyg/Debug.js \
	../../lib/Wikiwyg/Toolbar.js \
	../../lib/Wikiwyg/Preview.js \
	../../lib/Wikiwyg/Wikitext.js \
	../../lib/Wikiwyg/Wysiwyg.js \
	../../lib/Wikiwyg/HTML.js \
	lib/Wikiwyg/MediaWiki.js

all: $(COMBINED_FILE)

clean:
	rm -f $(COMBINED_FILE)

$(COMBINED_FILE): $(ALL_JS_SOURCE_FILES) Makefile
	rm -f $@;
	for js in $(ALL_JS_SOURCE_FILES); do       \
	   (echo "// BEGIN $$js"; cat $$js) >> $@; \
	done

split-js:
	perl \
	-e 'my $$text = `cat $(COMBINED_FILE)`;' \
	-e 'while($$text) {' \
	-e '    $$text =~ s/\/\/ BEGIN (.*?)\n(.*?)(?=\/\/ BEGIN |\z)//s' \
	-e '	  or die "fubarred";' \
	-e '    open(OUT, "> $$1") or die "Cannot open $$1 for output";' \
	-e '    print OUT $$2;' \
	-e '    close OUT;' \
	-e '}'
