# Contributing to VisualEditor

Thank you for helping us develop VisualEditor!

We inherit the contribution guidelines from VisualEditor core. Be sure to read the
[Contribution guidelines](https://git.wikimedia.org/blob/VisualEditor%2FVisualEditor.git/master/CONTRIBUTING.md)
in the VisualEditor repository.


## Running tests

The VisualEditor plugins for MediaWiki can be tested within your MediaWiki install.

[Configure your wiki](https://www.mediawiki.org/wiki/Manual:JavaScript_unit_testing) to
allow running of tests. In `LocalSettings.php`, set:
```php
// https://www.mediawiki.org/wiki/Manual:JavaScript_unit_testing
$wgEnableJavaScriptTest = true;
```

Then open `http://URL_OF_MEDIAWIKI/index.php/Special:JavaScriptTest/qunit`
(for example, <http://localhost/w/index.php/Special:JavaScriptTest/qunit>).
