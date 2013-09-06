# Wikia JavaScript Coding Conventions

## Language Rules
* Early returns
* Semi-colons
* Function declaration within blocks
* Error handling and custom exception handling
* Delete Operator
* Modifying prototypes of built in objects

## Style Rules
* White space
* Structure
* Commenting
* Naming Conventions
	* vars
	* modules
	* folders
	* files
	* constants
	* casing
* Directory Structure
* AMD
* Prefix jQuery objects with $

### Style Rules
#### White space guidelines
We are using jQuery's guidelines: http://contribute.jquery.org/style-guide/js/

#### Prefixing jQuery objects
All variables referencing jQuery objects, should be prefixed with a $. For example:

```javascript
var $div = $('div');
```

