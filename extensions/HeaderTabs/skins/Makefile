all: combined-min.js combined-history-min.js combined-min.css

# Minify
combined-min.js: combined.js
	yuicompressor combined.js >combined-min.js

combined-history-min.js: combined-history.js
	yuicompressor combined-history.js >combined-history-min.js

combined-min.css: combined.css
	yuicompressor combined.css >combined-min.css

# JS
combined.js: utilities.js tabview-min.js event-min.js headertabs.js
	cat utilities.js tabview-min.js event-min.js headertabs.js >combined.js

combined-history.js: utilities.js tabview-min.js event-min.js history-min.js headertabs.js
	cat utilities.js tabview-min.js event-min.js history-min.js headertabs.js >combined-history.js

# CSS
combined.css: fonts-min.css tabview.css headertabs.css
	cat fonts-min.css tabview.css headertabs.css >combined.css

# Fetch JS
utilities.js:
	wget http://yui.yahooapis.com/2.5.1/build/utilities/utilities.js

tabview-min.js:
	wget http://yui.yahooapis.com/2.5.1/build/tabview/tabview-min.js

event-min.js:
	wget http://yui.yahooapis.com/2.5.1/build/event/event-min.js

history-min.js:
	wget http://yui.yahooapis.com/2.5.1/build/history/history-min.js

# Fetch CSS
fonts-min.css:
	wget http://yui.yahooapis.com/2.5.1/build/fonts/fonts-min.css

tabview.css:
	wget http://yui.yahooapis.com/2.5.1/build/tabview/assets/skins/sam/tabview.css

clean:
	rm -f combined.js combined-history.js combined.css utilities.js tabview-min.js event-min.js history-min.js fonts-min.css tabview.css 
