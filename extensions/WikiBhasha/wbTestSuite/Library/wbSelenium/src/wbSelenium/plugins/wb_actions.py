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

import random
import time
from robot.utils import secs_to_timestr, timestr_to_secs
from SeleniumLibrary.selenium import selenium
from SeleniumLibrary.javascript import JavaScript
from robot.libraries.BuiltIn import BuiltIn


class wbActions(object): 

    def return_random_number(self, minvalue, maxvalue):
        """Returns random floating point number within range `minvalue` and `maxvalue`"""
        minvalue = float(minvalue)
        maxvalue = float(maxvalue)
        return random.uniform(minvalue, maxvalue)

    def wait_until_page_contains(self, text, timeout):
        """Waits until `text` appears on current page or `timeout` expires.
        Over-rided the Robot Framework built-in keyword to make it work with IE.
        """
        try:
            #if not('*iexplore' in self._selenium.browserStartCommand or '*iehta' in self._selenium.browserStartCommand):
            #    JavaScript.wait_until_page_contains(self, text, timeout)
            #else:
            self._wait_until_keyword_returns_true(timeout, timestr_to_secs(timeout)/10, "is_text_present", text)               
        except Exception, err:
            if not 'did not become true' in str(err):
                raise
            timestr = secs_to_timestr(timestr_to_secs(timeout))
            raise AssertionError("Text '%s' did not appear in '%s'" 
                                  % (text, timestr))

    def wait_until_page_contains_element(self, locator, timeout):
        """
        Waits until `element` appears on current page or `timeout` expires.
        """
        try:
            self._wait_until_keyword_returns_true(timeout, timestr_to_secs(timeout)/10, "is_element_present", locator)               
        except Exception, err:
            if not 'did not become true' in str(err):
                raise
            timestr = secs_to_timestr(timestr_to_secs(timeout))
            raise AssertionError("Element '%s' did not appear in '%s'" 
                                  % (locator, timestr))
        
    def wait_for_page_to_load(self,timeout):
        """
        Waits for a new page to load.
        Over-rided the Robot Framework built-in keyword to fix the timing issues.
        """
        timeout = timestr_to_secs(timeout)
        self._selenium.wait_for_page_to_load(timeout*1000)

    def wait_until_element_visible(self, locator, timeout):
        """
        Waits until the element is visble. Can be used to wait for ajax calls. 
        """
        try:
            self._wait_until_keyword_returns_true(timeout, timestr_to_secs(timeout)/10, "is_visible", locator)               
        except Exception, err:
            if not 'did not become true' in str(err):
                raise
            timestr = secs_to_timestr(timestr_to_secs(timeout))
            raise AssertionError("Element '%s' did not appear in '%s'" 
                                  % (locator, timestr))

    def execute_script(self, script):
        browser = self._selenium.browserStartCommand 
        if not browser in ['*iexplore', '*iehta', '*chrome', '*firefox']:
            raise DataError("Keyword 'Execute Script' can only be used with '*chrome', '*iexplore', '*iehta', '*firefox' browsers")
        self._info("Executing Javascript '%s'" % (script))
        if browser in ['*iexplore', '*iehta']:
            self._selenium.run_script(script)
        else:
            self.do_command("executeScript", [script,])
    
    def _wait_until_keyword_returns_true(self, timeout, retry_interval, name, *args):
        """Helper method for wait_until_page_contains"""
        timeout = timestr_to_secs(timeout)
        retry_interval = timestr_to_secs(retry_interval)
        starttime = time.time()
        while time.time() - starttime < timeout:
            try:
                self._info("Waiting %s for condition '%s' to be true." 
                    % (secs_to_timestr(timestr_to_secs(retry_interval)), args[0]))  
                if not BuiltIn.run_keyword(BuiltIn(), name, *args):
                    time.sleep(retry_interval)
                else:
                    self._info("Return True in '%s' " % (secs_to_timestr(time.time() - timestr_to_secs(starttime))))
                    return True              
            except Exception:
                time.sleep(retry_interval)
        raise AssertionError("did not become true")

    def _wait_for_asycronous_callback(self, inputlocator):
        """
        Perform an asynchronous operation on element `inputlocator`
        and call `callback` upon asynchronous completion. This function
        is useful for selenium calls which don't immediately return
        response codes
        """
        splitstring = inputlocator.split(":")
        locator = splitstring[0]
        pattern = splitstring[1]
        count = 60
        i = 0
        for i in range(count):
            value = self.get_value(locator)
            if (value == pattern):
                break
            time.sleep(1)

    def mouse_drag(self, locator, cord, inputlocator):
        """Simulates a mouse down event on an image.
        Key attributes for images are `id`, `src` and `alt`. See
        `introduction` for details about locating elements.
        """
        self._selenium.mouse_down_at(locator,cord)
        self._wait_for_asycronous_callback(inputlocator)

        
    


