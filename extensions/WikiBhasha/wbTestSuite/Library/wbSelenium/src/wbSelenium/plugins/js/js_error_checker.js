/*
*
*   Copyright (c) Microsoft. 
*
*	This code is licensed under the Apache License, Version 2.0.
*   THIS CODE IS PROVIDED *AS IS* WITHOUT WARRANTY OF
*   ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING ANY
*   IMPLIED WARRANTIES OF FITNESS FOR A PARTICULAR
*   PURPOSE, MERCHANTABILITY, OR NON-INFRINGEMENT.
*
*   The apache license details from 
*   'http://www.apache.org/licenses/' are reproduced 
*   in 'Apache2_license.txt' 
*
*/

// private namespace for WikiBhasha functions
 var wb_wb = function(){
    var errorList = [];
    var errorHandler = function(errMsg,url,line){
        errorList.push({"msg":errMsg, "url":url, "line":line});
    };
    // initialization
    var oldHandler = window.onerror;
    window.onerror = function(errMsg,url,line){
        errorHandler(errMsg,url,line);
        if(oldHandler){ oldHandler(errMsg,url,line); }
            return true; // surpress errors
    };
    // public methods/attributes
    return { 'errors': errorList };
}();

Selenium.prototype.getAllJSErrors = function(){
    return wb_wb.errors;
};
