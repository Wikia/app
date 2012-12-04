# VisualEditor Code Guidelines

We inherit the code structure (about whitespace, naming and comments) conventions
from MediaWiki:
* [Manual:Coding conventions/JavaScript#Code structure](https://www.mediawiki.org/wiki/Manual:Coding_conventions/JavaScript#Code_structure) on mediawiki.org.

## Documentation comments

* End sentences in a full stop.
* Continue sentences belonging to an annotation on the next line, indented with an
  additional space.
* Types in documentation comments should be separated by a pipe character. Use types
  that are listed in the Types section of this document, otherwise use the identifier
  (full path from the global scope) of the constructor function (e.g. `{ve.dm.BranchNode}`).


### Annotations

We use the following annotations. They should be used in the order as they are described
here for consistency.

* @class
* @mixin
* @abstract
* @constructor
* @extends {Type}
* @private
* @static
* @method
* @until Text: Optional details.
* @source
* @context {Type} The type of the `this` value.
* @param {Type} varName Optional description.
* @returns {Type} Optional description.

### Types

Special values:
* undefined
* null
* Infinity
* NaN

Native language types:
* Boolean
* String
* Number
* Object

Native constructors:
* Array
* Date

Browser constructors:
* DOMElement (alias for HTMLElement)

jQuery constructors:
* jQuery
* jQuery.Event