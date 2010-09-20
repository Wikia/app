/*
 * bezen.error.js - "catch all" mechanism for window.onerror (IE/FF), 
 *                  setTimeout and setInterval.
 *
 * author:    Eric Bréchemier <bezen@eric.brechemier.name>
 * license:   Creative Commons Attribution 3.0 Unported
 *            http://creativecommons.org/licenses/by/3.0/
 * version:   2010-01-14 "Calvin's Snowball"
 *
 * To Cecile, with Love,
 * you were the first to wait for the conception of this library
 *
 * Tested successfully in
 *   Firefox 2, Firefox 3, Firefox 3.5,
 *   Internet Explorer 6, Internet Explorer 7, Internet Explorer 8,
 *   Chrome 3, Safari 3, Safari 4,
 *   Opera 9.64, Opera 10.10
 *
 * The intent of this module is to deploy a safety net to catch and log
 * unexpected errors at the top level. This is done by configuring a proper
 * callback in window.onerror for IE and Firefox.
 *
 * Sadly, window.onerror is still not supported in Opera, Safari and Chrome.
 * In these browsers, errors are not reported for code triggered by setTimeout.
 *
 * For this purpose, this module defines an alternate setTimeout/setInterval 
 * which catches errors and calls any handler attached to window.onerror.
 *
 * You can set the safeSetTimeout/safeSetInterval methods defined by this 
 * module to window.setTimeout and window.setInterval manually, or you can
 * call bezen.error.catchAll() which will do it for you. In addition, catchAll
 * will set window.onerror to a default handler which logs errors using
 * bezen.log.error(), if available. You may define your own handler instead, 
 * by setting your own function to window.error either before or after calling
 * catchAll().
 *
 * You may use the catchError method in your own code to catch and report
 * errors to window.onerror in the same way as this module does for setTimeout
 * and setInterval.
 */
/*requires bezen.js */
/*optional bezen.log.js */ // if defined, the default handler for 
                           // window.onerror will log errors to bezen.log.error
/*jslint nomen:false, white:false, onevar:false, plusplus:false, evil:true */
/*global bezen, window */
bezen.error = (function() {
  // Builder of 
  // Closure object for "catch all" mechanism for window.onerror,
  // setTimeout, and setInterval.
   
  // Define aliases
  var unsafeSetTimeout = window.setTimeout,
      unsafeSetInterval = window.setInterval;
  
  var reportError = function(error,url,line){
    // Convenience method to report all errors: if the module bezen.log is
    // present, an error message is created and logged, otherwise this call
    // is ignored.
    //
    // The intent of this method is to offer a single entry point to report
    // all errors caught in try/catch blocks and other safety nets such as
    // window.onerror.
    //
    // There are two allowed forms to call it:
    // - with a single Error parameter, for use in a catch clause:
    //     try {
    //       throw new Error('message','file',42);
    //     } catch(e){
    //       bezen.error.reportError(e);
    //     }
    //
    // - with 3 parameters, for use in window.onerror or direct calls:
    //     reportError('failed to load data','script.js',0);
    //
    // params:
    //   error - (object) Error object (1-param form)
    //           or (string) error message (3-param form)
    //   url     - (string) file where the error was raised
    //   line    - (integer) line number
    //
    // Warning:
    //   The fileName and lineNumber properties of the error object are
    //   not standard, and only available in Firefox browser. In other 
    //   browsers the error logs will end with 'at undefined[undefined]'.
    //
    // References:
    //   Error - MDC
    //   https://developer.mozilla.org/en/Core_JavaScript_1.5_Reference
    //                                   /Global_Objects/Error
    //
    //   Error Object (Windows Scripting - JScript)
    //   http://msdn.microsoft.com/en-us/library/dww52sbt(VS.85).aspx

    if (!bezen.log){
      return;
    }
     
    if (typeof error === 'object'){
      // convert 1-param call to 3-param call
      reportError(error.message, error.fileName, error.lineNumber);
      return;
    }
     
    bezen.log.error(error + ' at ' + url + '[' + line + ']', true);
  };
   
  var onerror = function(message,url,line) { 
    // Default error handler for window.onerror
    //
    // The handler will be set to window.onerror by catchAll(), and will be
    // triggered for errors caughts by safeSetTimeout and safeSetInterval as
    // well.
    //
    // Note:
    //   Without the catch all mechanism defined by this module, window.onerror
    //   is only supported by Mozilla Firefox and IE without script debugger.
    //   window.onerror is not called in IE if script debugger is enabled.
    //   It is not called in Opera, Safari and Chrome either. 
    //
    //   With this module, window.onerror will be triggered in all browsers 
    //   for any error caught in code starting by a setTimeout/setInterval,
    //   and in some browsers (Firefox/IE) for uncaught errors.
    //
    // params:
    //   message - (string) error message
    //   url     - (string) file where the error was raised
    //   line    - (integer) line number
     
    reportError('window.onerror: ' + message, url, line);
    return true; // do not report error in browser
  };
   
  var catchError = function(func,description){
    // A wrapper for the given function to catch and report errors to
    // the window.onerror handler
    //
    // Notes:
    //   - a handler should have been assigned to window.onerror beforehand,
    //     either directly or by calling catchAll() to set a default handler.
    //     In case no window.onerror handler has been set, the call is ignored.
    //
    //   - in case the first argument is not a function, an error is reported
    //     with reportError(), and the bezen.nix function is returned.
    //
    // params:
    //   func - (function) (!nil) the function to call safely
    //   description - (string) (optional) (default: 'error.catchError') 
    //                 a description of the function for logging purpose
    //                 e.g. 'object.method'
    //
    // return: (any)
    //   bezen.nix (function that does nothing) if func is not a function,
    //   a new function wrapping func in a try/catch otherwise
    //
    description = description || 'error.catchError';
     
    if (typeof func!=='function'){
      reportError(description+': A function is expected, found '+ typeof func);
      return bezen.nix;
    }
     
    var safefunc = function(){
      try {
        return func.apply(this,arguments);
      } catch(e) {
        if (window.onerror){
          window.onerror(description+': '+e.message+' in '+func,
                         e.fileName, e.lineNumber,true);
        }
      }
    };
    return safefunc;
  };
  
  var safeSetTimeout = function(func,delay){
    // a safe alternative to setTimeout, catching and logging errors thrown
    // by the callback
    //
    // params:
    //   func - (function or string) the function to call safely,
    //          or a string of code to evaluate safely
    //   delay - (integer) the delay
    //
    // return:
    //   the handler returned by setTimeout
    if (typeof func === 'string') {
      if (bezen.log){
        bezen.log.warn('window.setTimeout: eval is evil: "'+func+'"');
      }
      func = new Function(func);
    }
    return unsafeSetTimeout(catchError(func,'window.setTimeout'),delay);
  };
 
  var safeSetInterval = function(func,delay){
    // a safe alternative to setInterval, catching and logging errors thrown
    // by the callback
    //
    // params:
    //   func - (function or string) the function to call safely, or a string
    //          of code to evaluate safely
    //   delay - (integer) the delay
    //
    // return:
    //   the handler returned by setInterval
    if (typeof func === 'string') {
      if (bezen.log){
        bezen.log.warn('window.setInterval: eval is evil: "'+func+'"');
      }
      func = new Function(func);
    }
     
    return unsafeSetInterval(catchError(func,'window.setInterval'),delay);
  };
   
  var catchAll = function(){
    // configure a handler to window.onerror and override setTimeout to catch 
    // and log errors while preventing them from being displayed to the 
    // end-user by the browser.
    //
    // This method should be called as soon as possible before any significant
    // code is run:
    //   * calls to setTimeout, window.setTimeout
    //   * calls to setInterval, window.setInterval
    //   * internal/external script code possibly throwing errors
    //
    // Note: this method will override any listener previously set to
    //       window.onerror, as well as the native window.setTimeout and
    //       window.setInterval. Back up those original functions if needed.
    // 
    
    window.onerror = onerror;
    window.setTimeout = safeSetTimeout;
    window.setInterval = safeSetInterval;
  };
   
  return { // public API
    reportError: reportError,
    onerror: onerror,
    safeSetTimeout: safeSetTimeout,
    safeSetInterval: safeSetInterval,
    catchError: catchError,
    catchAll: catchAll,
     
    _: { // private section, for unit tests
    }
  };
}());
