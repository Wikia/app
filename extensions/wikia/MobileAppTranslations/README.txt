@author: Sean Colombo
@date: 20110520

This "extension" is a place to hold the PHP version of the i18n files for Wikia's Mobile apps.

The apps are currently written for the Titanium platform (which has translation files in an XML format) and
may be written in other non-PHP languages or with translation files which are not MediaWiki compatible.

Conversion scripts are used to turn these into standard MediaWiki i18n files so that they can be translated
using our normal systems (e.g. the translators at translatewiki.net).

Conversion scripts should then be used to convert the PHP _back_ to whatever format the mobile apps need.
