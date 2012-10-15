This library is an Open Source API key-management system.

It was written to be used at Wikia, but the code in the /lib directory does NOT (and should never) have a dependency on MediaWiki.

The code for using API Gate inside of MediaWiki is inside of /trunk/extensions/wikia/SpecialApiGate

There is some code in this library in the ApiGate_Config.php file which makes it easier to use MediaWiki functionality automatically in ApiGate.
For instance, ApiGate was written to have i18n'ed messages, but for now, it just piggybacks on MediaWikis's functionality if that's available.
The idea here is that we can use that by default when running in MW, and we can implement it cleanly/easily later, when there is a non-MediaWiki
user of ApiGate.