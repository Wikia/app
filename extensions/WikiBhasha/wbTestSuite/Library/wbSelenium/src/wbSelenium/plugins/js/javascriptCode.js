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

Selenium.prototype.getJavaScript = function(locator)
{
    var element = this.browserbot.findElement(locator);
    return (element.href);
};

Selenium.prototype.doExecuteScript = function(url)
{
   try
    {
     this.browserbot.openLocation(url);
    }
    catch (e)
    {
        throw new SeleniumError("Threw an exception: " + e.message);
    }
};