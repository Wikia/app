try {
    GM_log('inheritance');
}catch(err){
    
}

/* Simple JavaScript Inheritance
 * By John Resig http://ejohn.org/
 * MIT Licensed.
 */
// Inspired by base2 and Prototype
(function(){
  var initializing = false;
  var fnTest = /xyz/.test(function(){xyz;}) ? /\b_super\b/ : /.*/;

  // The base Class implementation (does nothing)
  this.Class = function(){};
 
  // Create a new Class that inherits from this class
  Class.extend = function(prop) {
    var _super = this.prototype;
   
    // Instantiate a base class (but only create the instance,
    // don't run the init constructor)
    initializing = true;
    var prototype = new this();
    initializing = false;
   
    // Copy the properties over onto the new prototype
    for (var name in prop) {
      // Check if we're overwriting an existing function
      prototype[name] = typeof prop[name] == "function" &&
        typeof _super[name] == "function" && fnTest.test(prop[name]) ?
        (function(name, fn){
          return function() {
            var tmp = this._super;
           
            // Add a new ._super() method that is the same method
            // but on the super-class
            this._super = _super[name];
           
            // The method only need to be bound temporarily, so we
            // remove it when we're done executing
            var ret = fn.apply(this, arguments);       
            this._super = tmp;
           
            return ret;
          };
        })(name, prop[name]) :
        prop[name];
    }
   
    // The dummy class constructor
    function Class() {
      // All construction is actually done in the init method
      if ( !initializing && this.init )
        this.init.apply(this, arguments);
    }
   
    // Populate our constructed prototype object
    Class.prototype = prototype;
   
    // Enforce the constructor to be what we expect
    Class.constructor = Class;

    // And make this class extendable
    Class.extend = arguments.callee;
   
    return Class;
  };
})();

/********
 * 
 * The following code comes from Alex Sexton at http://alexsexton.com/?p=51. 
 * The code appears to be unlicensed. 
 * 
 */

//Make sure Object.create is available in the browser (for our prototypal inheritance)
//Courtesy of Papa Crockford
if (typeof Object.create !== 'function') {
   Object.create = function (o) {
       function F() {}
       F.prototype = o;
       return new F();
   };
}
(function($){
  $.plugin = function(name, object) {
     $.fn[name] = function(options) {
        var args = Array.prototype.slice.call(arguments, 1);
        return this.each(function() {
           var instance = $.data(this, name);
           if (instance) {
              instance[options].apply(instance, args);
           } else {
              instance = $.data(this, name, Object.create(object).init(options, this));
           }
        });
     };
  };
  
})(jQuery);

/************ END ALEX'S CODE *************/
