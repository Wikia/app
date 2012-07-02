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

from functools import wraps
from time import sleep

class exception_retry_decorator(object):

    def __init__(self, exception_type, message="", tries=15, delay=1):
        """Decorate a function which throws exceptions `exception_type` and 
        continously run the function for `tries`, pausing between each try
        by `delay`"""
        self.exception = exception_type(message + ": timed out after %s seconds" % (tries * delay))
        self.exception_type, self.tries, self.delay = exception_type, tries, delay
    
    def __call__(self, f):
        @wraps(f)
        def retry(*args, **kwargs):
            tries, delay = self.tries, self.delay
            while tries:
                sleep(delay)
                tries -= 1 # this is why tries is a list
                try: ret_val = f(*args, **kwargs)
                except self.exception_type: pass
                else: return ret_val
            raise self.exception
        return retry
