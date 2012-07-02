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

class wbAssertions(object): 

    def element_should_contain_exact_text(self, locator, expected , message=''):
      """Verifies element identified by `locator` contains a child element
         that has ONLY the expected text within it."""
      self._info("Verifying element '%s' contains EXACT text '%s'." 
                  % (locator, expected))
      actual = str(self._selenium.get_text(self._parse_locator(locator)))
      if not expected in map(str.strip, actual.split("\n")):
          if not message:
              message = "Element '%s' should have contained EXACT text '%s' but "\
                        "did not" % (locator, expected)
          raise AssertionError(message)
