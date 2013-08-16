# VisualEditor Code Guidelines

We inherit the code structure (about whitespace, naming and comments) conventions
from MediaWiki. See [Manual:Coding conventions/JavaScript#Code structure](https://www.mediawiki.org/wiki/Manual:Coding_conventions/JavaScript#Code_structure) on mediawiki.org.

## Documentation comments

* End sentences in a full stop.
* Continue sentences belonging to an annotation on the next line, indented with an
  additional space.
* Types in documentation comments should be separated by a pipe character. Use types
  that are listed in the Types section of this document, otherwise use the identifier
  (full path from the global scope) of the constructor function (e.g. `{ve.dm.BranchNode}`).

### Generate documentation

#### Gem (Mac OS X)
Ruby ships with OSX but may be outdated. Use [Homebrew](http://mxcl.github.com/homebrew/):
```
$ brew install ruby
```

If you've never used `gem` before, don't forget to add the gem's bin to your `PATH` ([howto](http://stackoverflow.com/a/14138490/319266)).

#### Install
Once you have gem, installing [JSDuck](https://github.com/senchalabs/jsduck) is easy:
```
$ gem install jsduck
```

#### Run
```
$ cd VisualEditor
$ .docs/generate.sh
# open http://localhost/VisualEditor/docs/
```

For more options:
```
$ jsduck --help
```

### Annotations

We use the following annotations. They should be used in the order as they are described
here, for consistency. See [JSDuck/Tags](https://github.com/senchalabs/jsduck/wiki/Tags) for more elaborate documentation.

* @class Name (optional, guessed)
* @abstract
* @extends ClassName
* @mixins ClassName
* @constructor
* @private
* @static
* @method name (optional, guessed)
* @template
* @property name (optional, guessed)
* @until Text: Optional text.
* @source Text
* @context {Type} Optional text.
* @param {Type} name Optional text.
* @emits name
* @returns {Type} Optional text.
* @chainable
* @throws {Type}

### Types

Special values:
* undefined
* null
* this

Primitive types:
* boolean
* number
* string

Built-in classes:
* Array
* Date
* Function
* RegExp
* Object

Browser classes:
* HTMLElement

jQuery classes:
* jQuery
* jQuery.Event
