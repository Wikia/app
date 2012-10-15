/*                 JQuery header comments
 *          for Visual Studio IntelliSense support
 * 
 * **************************************************************
 * ************ CONTAINS NO FUNCTIONAL JQUERY CODE **************
 * **************************************************************
 * 
 * Generated with InfoBasis JQuery IntelliSense Header Generator
 * 
 * Sources:
 *     API version: 1.2.3
 *     Documentation version: 1.2.2
 * 
 * JQuery is Copyright (c) John Resig (jquery.com)
 */


jQuery = $ = function (expression, context) {
	/// <summary>
	/// 1: $(expression, context) - This function accepts a string containing a CSS selector which is then used to match a set of elements.
	/// 2: $(html) - Create DOM elements on-the-fly from the provided String of raw HTML.
	/// 3: $(elements) - Wrap jQuery functionality around a single or multiple DOM Element(s).
	/// 4: $(callback) - A shorthand for $(document).ready().
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expression">
	/// 1: expression - An expression to search with.
	/// 2: html - A string of HTML to create on the fly.
	/// 3: elements - DOM element(s) to be encapsulated by a jQuery object.
	/// 4: callback - The function to execute when the DOM is ready.
	/// </param>
	/// <param name="context" optional="true">
	/// 1: context - A DOM Element, Document or jQuery to use as context
	/// </param>
};

$.prototype = {
	length: {},
	prevObject: {},
	init: function (selector, context) {},
	jquery: {},
	size: function () {
	/// <summary>
	/// The number of elements in the jQuery object.
	/// </summary>
	/// <returns type="Number"></returns>
},
	get: function (index) {
	/// <summary>
	/// 1: get() - Access all matched DOM elements.
	///   returns Array<Element>
	/// 2: get(index) - Access a single matched DOM element at a specified index in the matched set.
	///   returns Element
	/// </summary>
	/// <returns type="Object"></returns>
	/// <param name="index" optional="true">
	/// 2: index - Access the element in the Nth position.
	/// </param>
},
	pushStack: function (elems) {},
	setArray: function (elems) {},
	each: function (callback) {
	/// <summary>
	/// Execute a function within the context of every matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="callback">The callback to execute for each matched element. Example: function callback(index, domElement) {  this; // this == domElement}</param>
},
	index: function (subject) {
	/// <summary>
	/// Searches every matched element for the object and returns the index of the element, if found, starting with zero.
	/// </summary>
	/// <returns type="Number"></returns>
	/// <param name="subject">Object to search for.</param>
},
	attr: function (name, value) {
	/// <summary>
	/// 1: attr(name) - Access a property on the first matched element. This method makes it easy to retrieve a property value from the first matched element. If the element does not have an attribute with such a name, undefined is returned.
	/// 2: attr(properties) - Set a key/value object as properties to all matched elements.
	///   returns jQuery
	/// 3: attr(key, value) - Set a single property to a value, on all matched elements.
	///   returns jQuery
	/// 4: attr(key, fn) - Set a single property to a computed value, on all matched elements.
	///   returns jQuery
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="name">
	/// 1: name - The name of the property to access.
	/// 2: properties - Key/value pairs to set as object properties.
	/// 3: key - The name of the property to set.
	/// 4: key - The name of the property to set.
	/// </param>
	/// <param name="value" optional="true">
	/// 3: value - The value to set the property to.
	/// 4: fn - A function returning the value to set. Scope: Current element, argument: Index of current element Example: function callback(indexArray) {  // indexArray == position in the jQuery object  this; // dom element}
	/// </param>
},
	css: function (name, value) {
	/// <summary>
	/// 1: css(name) - Return a style property on the first matched element.
	///   returns String
	/// 2: css(properties) - Set a key/value object as style properties to all matched elements.
	///   returns jQuery
	/// 3: css(name, value) - Set a single style property to a value on all matched elements.
	///   returns jQuery
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="name">
	/// 1: name - The name of the property to access.
	/// 2: properties - Key/value pairs to set as style properties.
	/// 3: name - The name of the property to set.
	/// </param>
	/// <param name="value" optional="true">
	/// 3: value - The value to set the property to.
	/// </param>
},
	text: function (val) {
	/// <summary>
	/// 1: text() - Get the combined text contents of all matched elements.
	///   returns String
	/// 2: text(val) - Set the text contents of all matched elements.
	///   returns jQuery
	/// 3: text() - Get the combined text contents of all matched elements.
	///   returns String
	/// 4: text(val) - Set the text contents of all matched elements.
	///   returns jQuery
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="val" optional="true">
	/// 2: val - The text value to set the contents of the element to.
	/// 4: val - The text value to set the contents of the element to.
	/// </param>
},
	wrapAll: function (html) {
	/// <summary>
	/// 1: wrapAll(html) - Wrap all the elements in the matched set into a single wrapper element.
	/// 2: wrapAll(elem) - Wrap all the elements in the matched set into a single wrapper element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="html">
	/// 1: html - A string of HTML that will be created on the fly and wrapped around the target.
	/// 2: elem - A DOM element that will be wrapped around the target.
	/// </param>
},
	wrapInner: function (html) {
	/// <summary>
	/// 1: wrapInner(html) - Wrap the inner child contents of each matched element (including text nodes) with an HTML structure.
	/// 2: wrapInner(elem) - Wrap the inner child contents of each matched element (including text nodes) with a DOM element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="html">
	/// 1: html - A string of HTML that will be created on the fly and wrapped around the target.
	/// 2: elem - A DOM element that will be wrapped around the target.
	/// </param>
},
	wrap: function (html) {
	/// <summary>
	/// 1: wrap(html) - Wrap all matched elements with a structure of other elements.
	/// 2: wrap(elem) - Wrap all matched elements with a structure of other elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="html">
	/// 1: html - A string of HTML that will be created on the fly and wrapped around the target.
	/// 2: elem - A DOM element that will be wrapped around the target.
	/// </param>
},
	append: function (content) {
	/// <summary>
	/// Append content to the inside of every matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="content">Content to append to the target.</param>
},
	prepend: function (content) {
	/// <summary>
	/// Prepend content to the inside of every matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="content">Content to prepend to the target.</param>
},
	before: function (content) {
	/// <summary>
	/// Insert content before each of the matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="content">Content to insert before each target.</param>
},
	after: function (content) {
	/// <summary>
	/// Insert content after each of the matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="content">Content to insert after each target.</param>
},
	end: function () {
	/// <summary>
	/// Revert the most recent 'destructive' operation, changing the set of matched elements to its previous state (right before the destructive operation).
	/// </summary>
	/// <returns type="jQuery"></returns>
},
	find: function (expr) {
	/// <summary>
	/// Searches for all elements that match the specified <a href='Selectors'>expression</a>. This method is a good way to find additional descendant elements with which to process.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr">An expression to search with.</param>
},
	clone: function (expr) {
	/// <summary>
	/// 1: clone() - Clone matched DOM Elements and select the clones.
	/// 2: clone(expr) - Clone matched DOM Elements, and all their event handlers, and select the clones.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr" optional="true">
	/// 2: expr - Set to true to enable cloning of event handlers.
	/// </param>
},
	filter: function (expr) {
	/// <summary>
	/// 1: filter(expr) - Removes all elements from the set of matched elements that do not match the specified expression(s). 
	/// 2: filter(fn) - Removes all elements from the set of matched elements that does not match the specified function. 
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr">
	/// 1: expr - An expression to pass into the filter
	/// 2: fn - A function to pass into the filter Example: function callback(indexInJQueryObject) {  var keepItBoolean = true;  this; // dom element  return keepItBoolean;}
	/// </param>
},
	not: function (expr) {
	/// <summary>
	/// Removes elements matching the specified expression from the set of matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr">An expression with which to remove matching elements, an element to remove from the set or a set of elements to remove from the jQuery set of matched elements.</param>
},
	add: function (expr) {
	/// <summary>
	/// Adds more elements, matched by the given expression, to the set of matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr">An expression whose matched elements are added for String, a string of HTML to create on the fly for DOMElement or one or more Elements to add if an Array.</param>
},
	is: function (expr) {
	/// <summary>
	/// Checks the current selection against an expression and returns true, if at least one element of the selection fits the given expression.
	/// </summary>
	/// <returns type="Boolean"></returns>
	/// <param name="expr">The expression with which to filter</param>
},
	hasClass: function (cssClass) {
	/// <summary>
	/// 1: hasClass(cssClass) - Returns true if the specified class is present on at least one of the set of matched elements.
	/// 2: hasClass(cssClass) - Checks the current selection against a class and returns true, if at least one element of the selection has the given class.
	/// </summary>
	/// <returns type="Boolean"></returns>
	/// <param name="cssClass">
	/// 1: cssClass - One CSS class name to be checked for.
	/// 2: cssClass - The class to match.
	/// </param>
},
	val: function (val) {
	/// <summary>
	/// 1: val() - Get the content of the value attribute of the first matched element.
	///   returns String, Array
	/// 2: val(val) - Set the value attribute of every matched element.
	///   returns jQuery
	/// 3: val(val) - Checks, or selects, all the radio buttons, checkboxes, and select options that match the set of values.
	///   returns jQuery
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="val" optional="true">
	/// 2: val - The value to set on the matched element.
	/// 3: val - The set of values to check/select.
	/// </param>
},
	html: function (val) {
	/// <summary>
	/// 1: html() - Get the html contents (innerHTML) of the first matched element. This property is not available on XML documents (although it will work for XHTML documents).
	///   returns String
	/// 2: html(val) - Set the html contents of every matched element. This property is not available on XML documents (although it will work for XHTML documents).
	///   returns jQuery
	/// 3: html() - Get the html contents (innerHTML) of the first matched element. This property is not available on XML documents (although it will work for XHTML documents).
	///   returns String
	/// 4: html(val) - Set the html contents of every matched element. This property is not available on XML documents (although it will work for XHTML documents).
	///   returns jQuery
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="val" optional="true">
	/// 2: val - Set the html contents to the specified value.
	/// 4: val - Set the html contents to the specified value.
	/// </param>
},
	replaceWith: function (content) {
	/// <summary>
	/// Replaces all matched elements with the specified HTML or DOM elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="content">Content to replace the matched elements with.</param>
},
	eq: function (position) {
	/// <summary>
	/// 1: eq(position) - Reduce the set of matched elements to a single element.
	/// 2: eq(index) - Reduce the set of matched elements to a single element. 
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="position">
	/// 1: position - The index of the element to select.
	/// 2: index - The index of the element in the jQuery object.
	/// </param>
},
	slice: function (start, end) {
	/// <summary>
	/// Selects a subset of the matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="start">Where to start the subset. The first element is at zero. Can be negative to start from the end of the selection.</param>
	/// <param name="end" optional="true">Where to end the subset. If unspecified, ends at the end of the selection.</param>
},
	map: function (callback) {
	/// <summary>
	/// Translate a set of elements in the jQuery object into another set of values in an array (which may, or may not, be elements).
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="callback">The function to execute on each element in the set. Example: function callback(index, domElement) {  var replacement;  this; // also dom element  // replacement == null : delete spot  // replacement == array : insert the elements of the array  // else replace the spot with replacement  return replacement;}</param>
},
	andSelf: function () {
	/// <summary>
	/// Add the previous selection to the current selection.
	/// </summary>
	/// <returns type="jQuery"></returns>
},
	data: function (key, value) {},
	removeData: function (key) {},
	domManip: function (args, table, reverse, callback) {},
	extend: function () {},
	parent: function (expr) {
	/// <summary>
	/// Get a set of elements containing the unique parents of the matched set of elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr" optional="true">An expression to filter the parents with.</param>
},
	parents: function (expr) {
	/// <summary>
	/// Get a set of elements containing the unique ancestors of the matched set of elements (except for the root element). The matched elements can be filtered with an optional expression. 
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr" optional="true">An expression to filter the ancestors with</param>
},
	next: function (expr) {
	/// <summary>
	/// Get a set of elements containing the unique next siblings of each of the given set of elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr" optional="true">An expression with which to filter the returned set.</param>
},
	prev: function (expr) {
	/// <summary>
	/// Get a set of elements containing the unique previous siblings of each of the matched set of elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr" optional="true">An expression to filter the previous Elements with.</param>
},
	nextAll: function (expr) {
	/// <summary>
	/// Find all sibling elements after the current element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr" optional="true">An expression to filter the next Elements with.</param>
},
	prevAll: function (expr) {
	/// <summary>
	/// Find all sibling elements before the current element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr" optional="true">An expression to filter the previous Elements with.</param>
},
	siblings: function (expr) {
	/// <summary>
	/// Get a set of elements containing all of the unique siblings of each of the matched set of elements. Can be filtered with an optional expressions. 
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr" optional="true">An expression to filter the sibling Elements with</param>
},
	children: function (expr) {
	/// <summary>
	/// Get a set of elements containing all of the unique immediate children of each of the matched set of elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr" optional="true">An expression to filter the child Elements with.</param>
},
	contents: function () {
	/// <summary>
	/// Find all the child nodes inside the matched elements (including text nodes), or the content document, if the element is an iframe.
	/// </summary>
	/// <returns type="jQuery"></returns>
},
	appendTo: function (content) {
	/// <summary>
	/// Append all of the matched elements to another, specified, set of elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="content">target to which the content will be appended.</param>
},
	prependTo: function (content) {
	/// <summary>
	/// Prepend all of the matched elements to another, specified, set of elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="content">target to which the content will be prepended.</param>
},
	insertBefore: function (content) {
	/// <summary>
	/// Insert all of the matched elements before another, specified, set of elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="content">Content after which the selected element(s) is inserted.</param>
},
	insertAfter: function (content) {
	/// <summary>
	/// Insert all of the matched elements after another, specified, set of elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="content">Content after which the selected element(s) is inserted.</param>
},
	replaceAll: function (selector) {
	/// <summary>
	/// Replaces the elements matched by the specified selector with the matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="selector">The elements to find and replace the matched elements with.</param>
},
	removeAttr: function (name) {
	/// <summary>
	/// Remove an attribute from each of the matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="name">The name of the property to remove.</param>
},
	addClass: function (cssClass) {
	/// <summary>
	/// Adds the specified class(es) to each of the set of matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="cssClass">One or more CSS classes to add to the elements, these are separated by spaces.</param>
},
	removeClass: function (cssClass) {
	/// <summary>
	/// Removes all or the specified class(es) from the set of matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="cssClass">One or more CSS classes to remove from the elements, these are separated by spaces.</param>
},
	toggleClass: function (cssClass) {
	/// <summary>
	/// Adds the specified class if it is not present, removes the specified class if it is present.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="cssClass">A CSS class to toggle on the elements.</param>
},
	remove: function (expr) {
	/// <summary>
	/// Removes all matched elements from the DOM. 
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="expr" optional="true">A jQuery expression to filter the set of elements to be removed.</param>
},
	empty: function () {
	/// <summary>
	/// Remove all child nodes from the set of matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
},
	height: function (val) {
	/// <summary>
	/// 1: height() - Get the current computed, pixel, height of the first matched element.
	///   returns Integer
	/// 2: height(val) - Set the CSS height of every matched element.
	///   returns jQuery
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="val" optional="true">
	/// 2: val - Set the CSS 'height' property to the specified value.
	/// </param>
},
	width: function (val) {
	/// <summary>
	/// 1: width() - Get the current computed, pixel, width of the first matched element.
	///   returns Integer
	/// 2: width(val) - Set the CSS width of every matched element.
	///   returns jQuery
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="val" optional="true">
	/// 2: val - Set the CSS 'width' property to the specified value.
	/// </param>
},
	bind: function (type, data, fn) {
	/// <summary>
	/// Binds a handler to one or more events (like click) for each matched element. Can also bind custom events.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="type">One or more event types separated by a space</param>
	/// <param name="data" optional="true">Additional data passed to the event handler as event.data</param>
	/// <param name="fn">A function to bind to the event on each of the set of matched elements Example: function callback(eventObject) {  this; // dom element}</param>
},
	one: function (type, data, fn) {
	/// <summary>
	/// Binds a handler to one or more events to be executed <i>once</i> for each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="type">An event type</param>
	/// <param name="data" optional="true">Additional data passed to the event handler as event.data</param>
	/// <param name="fn">A function to bind to the specified event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}</param>
},
	unbind: function (type , data ) {
	/// <summary>
	/// This does the opposite of bind, it removes bound events from each of the matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="type " optional="true">An event type to unbind.</param>
	/// <param name="data " optional="true">A function to unbind from the event on each of the set of matched elements.</param>
},
	trigger: function (type , data ) {
	/// <summary>
	/// Trigger a type of event on every matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="type ">An event type to trigger.</param>
	/// <param name="data " optional="true">Additional data to pass as arguments (after the event object) to the event handler.</param>
},
	triggerHandler: function (type , data ) {
	/// <summary>
	/// This particular method triggers all bound event handlers on an element (for a specific event type) WITHOUT executing the browsers default actions.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="type ">An event type to trigger.</param>
	/// <param name="data " optional="true">Additional data to pass as arguments (after the event object) to the event handler.</param>
},
	toggle: function (fn, fn2) {
	/// <summary>
	/// 1: toggle(fn, fn2) - Toggle between two function calls every other click.
	/// 2: toggle() - Toggles each of the set of matched elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 1: fn - The function to execute on every even click. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
	/// <param name="fn2" optional="true">
	/// 1: fn2 - The function to execute on every odd click. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	hover: function (over, out) {
	/// <summary>
	/// Simulates hovering (moving the mouse on, and off, an object). This is a custom method which provides an 'in' to a frequent task.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="over">The function to fire when the mouse is moved over a matched element. Example: function callback(eventObject) {  this; // dom element}</param>
	/// <param name="out">The function to fire when the mouse is moved off of a matched element. Example: function callback(eventObject) {  this; // dom element}</param>
},
	ready: function (fn) {
	/// <summary>
	/// Binds a function to be executed whenever the DOM is ready to be traversed and manipulated.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn">The function to be executed when the DOM is ready. Example: function callback(jQueryReference) {  this; // document}</param>
},
	blur: function (fn) {
	/// <summary>
	/// 1: blur() - Triggers the blur event of each matched element.
	/// 2: blur(fn) - Bind a function to the blur event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 2: fn - A function to bind to the blur event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	focus: function (fn) {
	/// <summary>
	/// 1: focus() - Triggers the focus event of each matched element. 
	/// 2: focus(fn) - Binds a function to the focus event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 2: fn - A function to bind to the focus event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	load: function (url, data, callback) {
	/// <summary>
	/// Load HTML from a remote file and inject it into the DOM.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="url">The URL of the HTML page to load.</param>
	/// <param name="data">Key/value pairs that will be sent to the server.</param>
	/// <param name="callback">The function called when the ajax request is complete (not necessarily success). Example: function (responseText, textStatus, XMLHttpRequest) {  this; // dom element}</param>
},
	resize: function (fn) {
	/// <summary>
	/// Bind a function to the resize event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn">A function to bind to the resize event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}</param>
},
	scroll: function (fn) {
	/// <summary>
	/// Bind a function to the scroll event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn">A function to bind to the scroll event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}</param>
},
	unload: function (fn) {
	/// <summary>
	/// Binds a function to the unload event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn">function to bind to the unload event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}</param>
},
	click: function (fn) {
	/// <summary>
	/// 1: click() - Triggers the click event of each matched element.
	/// 2: click(fn) - Binds a function to the click event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 2: fn - A function to bind to the click event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	dblclick: function (fn) {
	/// <summary>
	/// 1: dblclick() - Triggers the dblclick event of each matched element.
	/// 2: dblclick(fn) - Binds a function to the dblclick event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 2: fn - The function to bind to the dblclick event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	mousedown: function (fn) {},
	mouseup: function (fn) {
	/// <summary>
	/// Bind a function to the mouseup event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn">A function to bind to the mouseup event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}</param>
},
	mousemove: function (fn) {
	/// <summary>
	/// Bind a function to the mousemove event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn">A function to bind to the mousmove event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}</param>
},
	mouseover: function (fn) {
	/// <summary>
	/// Bind a function to the mouseover event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn">A function to bind to the mouseover event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}</param>
},
	mouseout: function (fn) {
	/// <summary>
	/// Bind a function to the mouseout event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn">A function to bind to the mouseout event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}</param>
},
	change: function (fn) {
	/// <summary>
	/// 1: change() - Triggers the change event of each matched element.
	/// 2: change(fn) - Binds a function to the change event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 2: fn - A function to bind to the change event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	select: function (fn) {
	/// <summary>
	/// 1: select() - Trigger the select event of each matched element.
	/// 2: select(fn) - Bind a function to the select event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 2: fn - A function to bind to the select event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	submit: function (fn) {
	/// <summary>
	/// 1: submit() - Trigger the submit event of each matched element.
	/// 2: submit(fn) - Bind a function to the submit event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 2: fn - A function to bind to the submit event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	keydown: function (fn) {
	/// <summary>
	/// 1: keydown() - Triggers the keydown event of each matched element.
	/// 2: keydown(fn) - Bind a function to the keydown event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 2: fn - A function to bind to the keydown event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	keypress: function (fn) {
	/// <summary>
	/// 1: keypress() - Triggers the keypress event of each matched element.
	/// 2: keypress(fn) - Binds a function to the keypress event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 2: fn - A function to bind to the keypress event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	keyup: function (fn) {
	/// <summary>
	/// 1: keyup() - Triggers the keyup event of each matched element.
	/// 2: keyup(fn) - Bind a function to the keyup event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 2: fn - A function to bind to the keyup event on each of the matched elements. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	error: function (fn) {
	/// <summary>
	/// 1: error() - Triggers the error event of each matched element.
	/// 2: error(fn) - Binds a function to the error event of each matched element.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="fn" optional="true">
	/// 2: fn - An event handler function to bind to the error event. Example: function callback(eventObject) {  this; // dom element}
	/// </param>
},
	serialize: function () {
	/// <summary>
	/// Serializes a set of input elements into a string of data. This will serialize all given elements.
	/// </summary>
	/// <returns type="jQuery"></returns>
},
	serializeArray: function () {
	/// <summary>
	/// Serializes all forms and form elements (like the <a href='Ajax/serialize'>.serialize()</a> method) but returns a JSON data structure for you to work with.
	/// </summary>
	/// <returns type="jQuery"></returns>
},
	ajaxStart: function (callback) {
	/// <summary>
	/// Attach a function to be executed whenever an AJAX request begins and there is none already active. This is an <a href='Ajax_Events'>Ajax Event</a>.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="callback">The function to execute. Example: function () {  this; // dom element listening}</param>
},
	ajaxStop: function (callback) {
	/// <summary>
	/// Attach a function to be executed whenever all AJAX requests have ended. This is an <a href='Ajax_Events'>Ajax Event</a>.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="callback">The function to execute. Example: function () {  this; // dom element listening}</param>
},
	ajaxComplete: function (callback) {
	/// <summary>
	/// Attach a function to be executed whenever an AJAX request completes. This is an <a href='Ajax_Events'>Ajax Event</a>.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="callback">The function to execute. Example: function (event, XMLHttpRequest, ajaxOptions) {  this; // dom element listening}</param>
},
	ajaxError: function (callback) {
	/// <summary>
	/// Attach a function to be executed whenever an AJAX request fails. This is an <a href='Ajax_Events'>Ajax Event</a>.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="callback">The function to execute. Example: function (event, XMLHttpRequest, ajaxOptions, thrownError) {  // thrownError only passed if an error was caught  this; // dom element listening}</param>
},
	ajaxSuccess: function (callback) {
	/// <summary>
	/// Attach a function to be executed whenever an AJAX request completes successfully. This is an <a href='Ajax_Events'>Ajax Event</a>.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="callback">The function to execute. Example: function (event, XMLHttpRequest, ajaxOptions) {  this; // dom element listening}</param>
},
	ajaxSend: function (callback) {
	/// <summary>
	/// Attach a function to be executed before an AJAX request is sent. This is an <a href='Ajax_Events'>Ajax Event</a>.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="callback">The function to execute. Example: function (event, XMLHttpRequest, ajaxOptions) {  this; // dom element listening}</param>
},
	show: function (speed, callback) {
	/// <summary>
	/// 1: show() - Displays each of the set of matched elements if they are hidden.
	/// 2: show(speed, callback) - Show all matched elements using a graceful animation and firing an optional callback after completion.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="speed" optional="true">
	/// 2: speed - A string representing one of the three predefined speeds ("slow", "normal", or "fast") or the number of milliseconds to run the animation (e.g. 1000).
	/// </param>
	/// <param name="callback" optional="true">
	/// 2: callback - A function to be executed whenever the animation completes, executes once for each element animated against. Example: function callback() {  this; // dom element}
	/// </param>
},
	hide: function (speed, callback) {
	/// <summary>
	/// 1: hide() - Hides each of the set of matched elements if they are shown.
	/// 2: hide(speed, callback) - Hide all matched elements using a graceful animation and firing an optional callback after completion.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="speed" optional="true">
	/// 2: speed - A string representing one of the three predefined speeds ("slow", "normal", or "fast") or the number of milliseconds to run the animation (e.g. 1000).
	/// </param>
	/// <param name="callback" optional="true">
	/// 2: callback - A function to be executed whenever the animation completes, executes once for each element animated against. Example: function callback() {  this; // dom element}
	/// </param>
},
	_toggle: function () {},
	slideDown: function (speed, callback) {
	/// <summary>
	/// Reveal all matched elements by adjusting their height and firing an optional callback after completion.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="speed">A string representing one of the three predefined speeds ("slow", "normal", or "fast") or the number of milliseconds to run the animation (e.g. 1000).</param>
	/// <param name="callback" optional="true">A function to be executed whenever the animation completes, executes once for each element animated against. Example: function callback() {  this; // dom element}</param>
},
	slideUp: function (speed, callback) {
	/// <summary>
	/// Hide all matched elements by adjusting their height and firing an optional callback after completion.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="speed">A string representing one of the three predefined speeds ("slow", "normal", or "fast") or the number of milliseconds to run the animation (e.g. 1000).</param>
	/// <param name="callback" optional="true">A function to be executed whenever the animation completes, executes once for each element animated against. Example: function callback() {  this; // dom element}</param>
},
	slideToggle: function (speed, callback) {
	/// <summary>
	/// Toggle the visibility of all matched elements by adjusting their height and firing an optional callback after completion.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="speed">A string representing one of the three predefined speeds ("slow", "normal", or "fast") or the number of milliseconds to run the animation (e.g. 1000).</param>
	/// <param name="callback" optional="true">A function to be executed whenever the animation completes, executes once for each element animated against. Example: function callback() {  this; // dom element}</param>
},
	fadeIn: function (speed, callback) {
	/// <summary>
	/// Fade in all matched elements by adjusting their opacity and firing an optional callback after completion.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="speed">A string representing one of the three predefined speeds ("slow", "normal", or "fast") or the number of milliseconds to run the animation (e.g. 1000).</param>
	/// <param name="callback" optional="true">A function to be executed whenever the animation completes, executes once for each element animated against. Example: function callback() {  this; // dom element}</param>
},
	fadeOut: function (speed, callback) {
	/// <summary>
	/// Fade out all matched elements by adjusting their opacity and firing an optional callback after completion.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="speed">A string representing one of the three predefined speeds ("slow", "normal", or "fast") or the number of milliseconds to run the animation (e.g. 1000).</param>
	/// <param name="callback" optional="true">A function to be executed whenever the animation completes, executes once for each element animated against. Example: function callback() {  this; // dom element}</param>
},
	fadeTo: function (speed, opacity, callback) {
	/// <summary>
	/// Fade the opacity of all matched elements to a specified opacity and firing an optional callback after completion.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="speed">A string representing one of the three predefined speeds ("slow", "normal", or "fast") or the number of milliseconds to run the animation (e.g. 1000).</param>
	/// <param name="opacity">The opacity to fade to (a number from 0 to 1).</param>
	/// <param name="callback" optional="true">A function to be executed whenever the animation completes, executed once for each element animated against. Example: function callback() {  this; // dom element}</param>
},
	animate: function (params, duration, easing, callback) {
	/// <summary>
	/// 1: animate(params, duration, easing, callback) - A function for making your own, custom animations.
	/// 2: animate(params, options) - A function for making your own, custom animations.
	/// </summary>
	/// <returns type="jQuery"></returns>
	/// <param name="params">
	/// 1: params - A set of style attributes that you wish to animate, and to what end.
	/// 2: params - A set of style attributes that you wish to animate, and to what end.
	/// </param>
	/// <param name="duration" optional="true">
	/// 1: duration - A string representing one of the three predefined speeds ("slow", "normal", or "fast") or the number of milliseconds to run the animation (e.g. 1000).
	/// 2: options - A set of options with which to configure the animation.
	/// </param>
	/// <param name="easing" optional="true">
	/// 1: easing - The name of the easing effect that you want to use (Plugin Required). There are two built-in values, "linear" and "swing".
	/// </param>
	/// <param name="callback" optional="true">
	/// 1: callback - A function to be executed whenever the animation completes, executes once for each element animated against.
	/// </param>
},
	queue: function (callback) {
	/// <summary>
	/// 1: queue() - Returns a reference to the first element's queue (which is an array of functions).
	///   returns Array<Function>
	/// 2: queue(callback) - Adds a new function, to be executed, onto the end of the queue of all matched elements.
	///   returns jQuery
	/// 3: queue(queue) - Replaces the queue of all matched element with this new queue (the array of functions).
	///   returns jQuery
	/// </summary>
	/// <returns type="Object"></returns>
	/// <param name="callback" optional="true">
	/// 2: callback - The function to add to the queue. Example: function callback() {  this; // dom element  // to continue the queue you must call  jQuery(this).dequeue();}
	/// 3: queue - The queue to replace all the queues with.  The functions have the same parameters and this value as queue(callback).
	/// </param>
},
	stop: function () {
	/// <summary>
	/// Stops all the currently running animations on all the specified elements. 
	/// </summary>
	/// <returns type="jQuery"></returns>
},
	dequeue: function () {
	/// <summary>
	/// Removes a queued function from the front of the queue and executes it.
	/// </summary>
	/// <returns type="jQuery"></returns>
},
	offset: function () {
	/// <summary>
	/// Get the current offset of the first matched element relative to the viewport.
	/// </summary>
	/// <returns type="Object{top,left}"></returns>
}
};

$.extend = function () {};

$.noConflict = function (deep) {};

$.isFunction = function (fn) {};

$.isXMLDoc = function (elem) {};

$.globalEval = function (data) {};

$.nodeName = function (elem, name) {};

$.cache = {};

$.data = function (elem, name, data) {};

$.removeData = function (elem, name) {};

$.each = function (object, callback, args) {};

$.prop = function (elem, value, type, i, name) {};

$.className = {};

$.swap = function (elem, options, callback) {};

$.css = function (elem, name, force) {};

$.curCSS = function (elem, name, force) {};

$.clean = function (elems, context) {};

$.attr = function (elem, name, value) {};

$.trim = function (text) {};

$.makeArray = function (array) {};

$.inArray = function (elem, array) {};

$.merge = function (first, second) {};

$.unique = function (array) {};

$.grep = function (elems, callback, inv) {};

$.map = function (elems, callback) {};

$.browser = {};

$.boxModel = {};

$.props = {};

$.expr = {};

$.parse = {};

$.multiFilter = function (expr, elems, not) {};

$.find = function (t, context) {};

$.classFilter = function (r, m, not) {};

$.filter = function (t, r, not) {};

$.dir = function (elem, dir) {};

$.nth = function (cur, result, dir, elem) {};

$.sibling = function (n, elem) {};

$.event = {};

$.isReady = {};

$.readyList = {};

$.ready = function () {};

$.get = function (url, data, callback, type) {};

$.getScript = function (url, callback) {};

$.getJSON = function (url, data, callback) {};

$.post = function (url, data, callback, type) {};

$.ajaxSetup = function (settings) {};

$.ajaxSettings = {};

$.lastModified = {};

$.ajax = function (s) {};

$.handleError = function (s, xml, status, e) {};

$.active = {};

$.httpSuccess = function (r) {};

$.httpNotModified = function (xml, url) {};

$.httpData = function (r, type) {};

$.param = function (a) {};

$.speed = function (speed, easing, fn) {};

$.easing = {};

$.timers = {};

$.fx = function (elem, options, prop) {};

$.easing.linear = function (p, n, firstNum, diff) {};

$.easing.swing = function (p, n, firstNum, diff) {};

$.ajaxSettings.global = {};

$.ajaxSettings.type = {};

$.ajaxSettings.timeout = {};

$.ajaxSettings.contentType = {};

$.ajaxSettings.processData = {};

$.ajaxSettings.async = {};

$.ajaxSettings.data = {};

$.ajaxSettings.username = {};

$.ajaxSettings.password = {};

$.ajaxSettings.accepts = {};

$.ajaxSettings.accepts.xml = {};

$.ajaxSettings.accepts.html = {};

$.ajaxSettings.accepts.script = {};

$.ajaxSettings.accepts.json = {};

$.ajaxSettings.accepts.text = {};

$.ajaxSettings.accepts._default = {};

$.props.float = {};

$.props.cssFloat = {};

$.props.styleFloat = {};

$.props.innerHTML = {};

$.props.className = {};

$.props.value = {};

$.props.disabled = {};

$.props.checked = {};

$.props.readonly = {};

$.props.selected = {};

$.props.maxlength = {};

$.props.selectedIndex = {};

$.props.defaultValue = {};

$.props.tagName = {};

$.props.nodeName = {};

$.browser.version = {};

$.browser.safari = {};

$.browser.opera = {};

$.browser.msie = {};

$.browser.mozilla = {};

$.className.add = function (elem, classNames) {};

$.className.remove = function (elem, classNames) {};

$.className.has = function (elem, className) {};

