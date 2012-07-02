#######################################################################
#
#   Copyright (c) Microsoft. 
#
#	This code is licensed under the Apache License, Version 2.0.
#   THIS CODE IS PROVIDED *AS IS* WITHOUT WARRANTY OF
#   ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING ANY
#   IMPLIED WARRANTIES OF FITNESS FOR A PARTICULAR
#   PURPOSE, MERCHANTABILITY, OR NON-INFRINGEMENT.
#
#   The apache license details from 
#   'http://www.apache.org/licenses/' are reproduced 
#   in 'Apache2_license.txt'
#
#######################################################################

from SeleniumLibrary.selenium import selenium
from threading import Thread
import httplib
import urllib
import sys

class CustomSelenium(object):
    """This class is meant to augment SeleniumLibrary/selenium.py by
    adding additional functionality. 

    Placing a method here is identical to placing a method in 
    SeleniumLibrary/selenium.py's selenium class. In most cases this isn't
    necessary and one can simply add keywords to SeleniumLibrary/__init__.py 
    using the regular plugin style of creating a class which is 
    automatically inherited by wbSelenium. The metaclass defined here 
    (_AllMethodsPrivate) gets around this inheritance (by making all 
    methods private) and instead adds them to the selenium class 
    (SeleniumLibrary.selenium: selenium).

    This template can be used to augment other SeleniumLibrary classes
    using the same type of metaclass."""

    class __AllMethodsPrivate(type):
        """Hide all the methods defined here so they are not automatically
        inherited by wbSelenium, and instead add them to selenium class
        defined in SeleniumLibrary.selenium module."""
        def __new__(cls, classname, bases, classdict):
            for attr, item in classdict.items():
                if callable(item) and not attr.startswith('_'):
                    # hide methods by prepending '__'
                    classdict['__' + attr] = item
                    # make it a selenium class attribute instead
                    setattr(selenium, attr, item)
                    del classdict[attr] # remove the orignal attribute
            return type.__new__(cls,classname,bases,classdict)
        
    __metaclass__ = __AllMethodsPrivate

    def do_command_async(self, verb, args, callback=None):
        """Enables asychronous do_commands with an optional `callback` that
        is passed the response message. 
    
        This is useful for methods which may not immediately return a
        response, such as clicking a file upload dialog."""
        if callback is not None and not callable(callback):
            raise RuntimeError, "do_command_async `callback` is not callable"
        def wrap_with_callback():
            ret_val = self.do_command(verb, args)
            if callable(callback): callback(ret_val)
        thread = Thread(target=wrap_with_callback)
        thread.setDaemon(True)
        thread.start()

    def click_async(self, locator, callback=None):
        """Perform an asynchronous click operation on element `locator`
        and call `callback` upon asynchronous completion. This function
        is useful for selenium calls which don't immediately return
        response codes (i.e. file upload)"""
        self.do_command_async("click", [locator], callback)

    def go_back_async(self, callback=None):
        """Perform an asynchronous click operation on element `locator`
        and call `callback` upon asynchronous completion. This function
        is useful for selenium calls which don't immediately return
        response codes (i.e. file upload)"""
        self.do_command_async("goBack", [callback])

    def get_javascript(self, locator):
        """Select `value` from dropdown `locator`"""
        return self.get_string("getJavaScript", [locator])
