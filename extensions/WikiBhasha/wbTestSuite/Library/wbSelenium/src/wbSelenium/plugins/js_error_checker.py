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

from wbSelenium.utils.logging import log, info, debug, warn, html

class JSErrorChecker(object):
    #def record_js_errors(self):
    #    self.do_command('recordJSErrors', [])

    def report_js_errors(self):
        output = self.get_string('getAllJSErrors', [])
        if output=='':
            info('No JavaScript found on the current Page')
        else:
            warn('ERRORS!:' + output)
