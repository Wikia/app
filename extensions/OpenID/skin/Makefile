all:	openid-combined-min.js

openid-combined-min.js: jquery-1.3.2.min.js jquery.cookie.js openid.js
	cat jquery-1.3.2.min.js jquery.cookie.js openid.js >openid-combined.js
	yuicompressor openid-combined.js -o openid-combined-min.js
	rm -f openid-combined.js
