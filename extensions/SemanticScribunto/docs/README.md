# mw.smw library functions

The following functions are provided by the `mw.smw` package.

## Overview

- Data retrieval functions

    - [`mw.smw.ask`][doc.ask]
    - [`mw.smw.getPropertyType`][doc.getPropertyType]
    - [`mw.smw.getQueryResult`][doc.getQueryResult]

- Data storage functions

    - [`mw.smw.set`][doc.set]
    - [`mw.smw.subobject`][doc.subobject]

- Miscellaneous

    - [`mw.smw.info`][doc.info]

## Notes

### Difference between `mw.smw.ask` and `mw.smw.getQueryResult`
Both functions allow you to retrieve data from your smw store. The difference lies in the returned table. Where `mw.smw.ask`
returns a very simplistic result set (its values are all pre-formatted and already type cast), `mw.smw.getQueryResult` leaves
you with full control over your returned data, giving you abundant information but delegates all the data processing to you.

In other words:
* `ask` is a quick and easy way to get data which is already pre-processed and may not suite your needs entirely.
However it utilizes native SMW functionality like printout formatting (see [smwdoc] for more information)
* `getQueryResult` gets you the full result set in the same format provided by the [api]

For more information see the sample results in [`mw.smw.ask`][doc.ask] and [`mw.smw.getQueryResult`][doc.getQueryResult].

### Using #invoke

For a detailed description of the `#invoke` function, please have a look at the [Lua reference][lua] manual.

## mw.smw library extension

`ScribuntoLuaLibrary` is the interface for functions that are made available in the `mw.smw` package and can be extended easily with the expectation that some guidelines are followed to ensure future maintainability and release stability.

- Register the function with `ScribuntoLuaLibrary::register`
- Isolate the processing and if necessary add an extra class (e.g. `LuaAskResultProcessor`, `LibraryFactory`) to separate necessary work steps
- Add tests for `PHP` and `Lua` components to ensure that both parts are equally tested and correspond to each other in the expected outcome
- Existing tests should not be altered unless those contain a bug, an unexpected behaviour, or an existing function has changed its behaviour and therefore the expected output

[smwdoc]: https://www.semantic-mediawiki.org/wiki/Semantic_MediaWiki
[api]: https://www.semantic-mediawiki.org/wiki/Serialization_%28JSON%29
[lua]: https://www.mediawiki.org/wiki/Extension:Scribunto/Lua_reference_manual
[doc.ask]: https://github.com/SemanticMediaWiki/SemanticScribunto/blob/master/docs/mw.smw.ask.md
[doc.getPropertyType]: https://github.com/SemanticMediaWiki/SemanticScribunto/blob/master/docs/mw.smw.getPropertyType.md
[doc.getQueryResult]: https://github.com/SemanticMediaWiki/SemanticScribunto/blob/master/docs/mw.smw.getQueryResult.md
[doc.set]: https://github.com/SemanticMediaWiki/SemanticScribunto/blob/master/docs/mw.smw.set.md
[doc.subobject]: https://github.com/SemanticMediaWiki/SemanticScribunto/blob/master/docs/mw.smw.subobject.md
[doc.info]: https://github.com/SemanticMediaWiki/SemanticScribunto/blob/master/docs/mw.smw.info.md
