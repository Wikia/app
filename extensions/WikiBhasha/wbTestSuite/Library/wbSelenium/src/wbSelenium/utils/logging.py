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

LOG_ON = True

# basic logging methods for Robot reports
def log(message, level='INFO'):
    if LOG_ON:
        print '*%s* %s' % (level, message)

def info(message):
    log(message)
       
def debug(message):
    log(message, 'DEBUG')
        
def warn(message):
    log(message,  "WARN")
        
def html(self, message):
    log(message, 'HTML')
