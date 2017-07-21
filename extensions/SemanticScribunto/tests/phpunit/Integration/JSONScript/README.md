## TestCases
Contains 12 files with a total of 55 tests:

* [ask-001.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/ask-001.json) Test `mw.smw.ask` functions defined in module.smw.lua
* [ask-002.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/ask-002.json) test case to cover '... return results in correct order' for function mw.swm.ask
* [ask-003.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/ask-003.json) Test `mw.smw.ask` with format=debug
* [getQueryResult-001.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/getQueryResult-001.json) Test `mw.smw.ask` functions defined in module.smw.lua
* [getQueryResult-002.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/getQueryResult-002.json) test case to cover '... return results in correct order' for function mw.swm.getQueryResult
* [info-001.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/info-001.json) Test `mw.smw.info` functions defined in module.smw.info
* [set-001.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/set-001.json) Test `mw.smw.set` functions defined in module.smw.lua
* [set-002.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/set-002.json) Test mw.smw.set to produce error output
* [set-003.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/set-003.json) Test `#set` for various `_num` values without explicit precision (3 digit implicit), with/without leading zero, different printouts, negative numbers (#753, en, `smwgMaxNonExpNumber`)
* [set-004.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/set-004.json) Test `#set` for various `_qty` values without explicit precision (3 digit implicit), with/without leading zero, and different printouts (#753, en, `smwgMaxNonExpNumber`)
* [set-005.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/set-005.json) Test in-text annotation for `_boo` datatype (`wgContLang=ja`, `wgLang=ja`)
* [subobject-001.json](https://github.com/SemanticMediaWiki/SemanticScribunto/tree/master/tests/phpunit/Integration/JSONScript/TestCases/subobject-001.json) Test `mw.smw.subobject` functions defined in module.smw.subobject

-- Last updated on 2017-01-21 by `readmeContentsBuilder.php`

## Writing a test case

### Assertions

Integration tests aim to prove that the "integration" between MediaWiki,
Semantic MediaWiki, and Scribunto works at a sufficient level therefore assertion
may only check or verify a specific part of an output or data to avoid that
system information (DB ID, article url etc.) distort to overall test results.

### Add a new test case

- Follow the `ask-001.json` example on how to structure the JSON file (setup,
  test etc.)
- Add example pages with content (including value annotations `[[SomeProperty::SomeValue]]`)
  expected to be tested
- If necessary add a new lua module file to the Fixtures directory and import the
  content for the test (see `ask-001.json`)
