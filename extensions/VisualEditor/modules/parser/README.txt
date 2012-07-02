A combined Mediawiki and html parser in JavaScript running on node.js. Please
see https://www.mediawiki.org/wiki/Future/Parser_development for an overview
of the current implementation, and instructions on running the tests.

npm dependencies: (This should be a proper package.json for npm to do it automatically?)

jquery
jsdom
buffer
optimist
pegjs
querystring
html5
request (implicitly installed by jsdom)
assert

The following additional modules are used in parserTests:

colors (for parserTests eye candy)
diff (parserTests output diffing)
