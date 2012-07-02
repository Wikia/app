#
# Handy makefile to combine and minify css and javascript files
#

all: tags/Storyboard/jquery.ajaxscroll.min.js

# JavaScript Minification

tags/Storyboard/jquery.ajaxscroll.min.js: tags/Storyboard/jquery.ajaxscroll.js jsmin 
	if [ -e ./jsmin ]; then ./jsmin < tags/Storyboard/jquery.ajaxscroll.js > tags/Storyboard/jquery.ajaxscroll.min.js;\
	else jsmin < tags/Storyboard/jquery.ajaxscroll.js > tags/Storyboard/jquery.ajaxscroll.min.js; fi

# JSMin - For more info on JSMin, see: http://www.crockford.com/javascript/jsmin.html

jsmin:
	type -P jsmin &>/dev/null || ( wget http://www.crockford.com/javascript/jsmin.c; gcc jsmin.c -o jsmin )

# Actions

distclean: clean
	rm -rf jsmin
	rm -rf jsmin.c

clean:
	rm -f tags/Storyboard/jquery.ajaxscroll.min.js

