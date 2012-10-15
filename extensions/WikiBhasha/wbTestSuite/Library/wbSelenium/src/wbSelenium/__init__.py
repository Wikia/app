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

from __future__ import with_statement 
import os
import sys
import inspect
import tempfile
import httplib
from wbSelenium.utils.logging import log, info, debug, warn, html
from wbSelenium.utils.timing import exception_retry_decorator
from SeleniumLibrary import SeleniumLibrary, selenium

__wb_SELENIUM_LIBRARY_VER__= "0.1"

DEFAULT_HOST = 'localhost'
DEFAULT_PORT = 4444

class TempJSExtensionFile(object):
    """Create a temporary user-extensions.js and folder to be used by 
    selenium server. This class is a duck type of class `file` 
    implementing methods write, flush, close, __enter__, __exit__ and the
    name attribute.
        
    A temporary directory is created using tempfile.mkdtemp where we create
    the file named user-extenions.js. The file is cleaned up when the delete
    is eventually called on this object, however if for any reason this is
    unsucessful there is no harm in manually deleting the temp dir.

    By default the temporary directory is created in the system temp
    directory, however you can specify one as an arg to __init__. close() 
    or __exit__() will delete both the temporary file and the temp directory. 
    
    This class implements both the __enter__ and __exit__ methods to allow
    usage with the builtin "with" statement.

    In order to enable multiple javascript files with the -userExtensions
    option we were forced to concatenate all of them into one
    user-extensions.js file. We orignally tried including other JS files
    from user-extensions.js, however we were unable to find an
    implementation that worked in both IE and firefox. Additionally, we
    did not want to alter SeleniumServer in anyway to allow easy upgrading.
    """

    DEFAULT_TMP_DIR = tempfile.gettempdir() # os.getcwd()
    EXT_FILE_NAME = "user-extensions.js"

    def __init__(self, temp_dir=DEFAULT_TMP_DIR):
        """Construct a temporary directory containing a file named
        user-extenions.js in the system's temporary directory."""
        self.name = os.path.join(tempfile.mkdtemp(dir=temp_dir), 
                                 TempJSExtensionFile.EXT_FILE_NAME)
        log("creating javascript tempfile: %s" % self.name)
        self.file = open(self.name, 'w')

    def write(self, text):
        """Write `text` to the temporary file"""
        self.file.write(text)

    def flush(self):
        """Flush write buffer to file"""
        self.file.flush()
    
    def close(self):
        """Delete the temporary file and directory __init__ made"""
        dir = os.path.dirname(self.name)
        self.file.close()
        os.remove(self.name)
        os.rmdir(dir)    
        log("(cleaning up javascript mess) deleted file: %s and dir: %s" % (self.file.name, dir))

    def __enter__(self):
        """Necessary to provide "with" interface"""
        return self

    def __exit__(self, type, value, traceback):    
        """Necessary to provide "with" interface"""
        self.close()

    def __str__(self):
        """Print the temporary file's absolute path"""
        return self.name

def selenium_server_is_running(host=DEFAULT_HOST, port=DEFAULT_PORT):
    """Check if a selenium-server is running on `host` and `port`"""
    conn = httplib.HTTPConnection(host, int(port))
    try: conn.connect()
    except httplib.socket.error: return False
    else: return True

@exception_retry_decorator(RuntimeError, "waiting for selenium-server")
def wait_until_server_has_started(host=DEFAULT_HOST, port=DEFAULT_PORT):
    """Stall callee until selenium-server on `host` and `port` becomes active"""
    log("waiting until selenium-server has started")
    if not selenium_server_is_running(host, port): raise RuntimeError 

class wbSelenium(SeleniumLibrary):
    """This class checks the plugins directory for any selenium extensions
    that the user may have added and generates a selenium object which
    contains these plugins. It also controls a selenium server which can
    use custom javascript files specified in your plugin directory. Acts
    as a wrapper to the Robot SeleniumLibrary.

    By default this class looks at the class variable BASE_DIR to load the
    standard wbSelenium keywords and their respective JS files which are
    found in BASE_DIR/JS_DIR. If the user specifies an additional
    plugin_dir as an argument to the "Library wbSelenium" then this
    folder will be searched for py files, and the JS_DIR subdirectory will
    be searched for js files to allow custom keywords. This file merely
    locates the external python and js files, and extends from the classes
    specified in this py files.

    This plugin system eliminates the need for wb-SELENIUM users to modify their
    local SeleniumLibrary installations or their selenium-server.jar files.
    Thus, SeleniumLibrary and selenium-server can be easily upgraded
    without the need to merge changes or deal with dependencies.
    """

    ROBOT_LIBRARY_SCOPE = 'GLOBAL'
    ROBOT_LIBRARY_VERSION = __wb_SELENIUM_LIBRARY_VER__
    BASE_DIR = os.path.join(os.path.dirname(__file__), "plugins")
    JS_DIR = 'js'

    def __init__(self, timeout=60, host=DEFAULT_HOST, port=DEFAULT_PORT, plugin_dir=""):
        """Load the wbSelenium library with arguments for Robot's
        SeleniumLibrary and selenium-server.

        Classes defined in python files are searched in the base directory
        and plugin directory. This class inherits from SeleniumLibrary and
        also all other classes specified in the plugin and base
        directories. Dynamic inheritance is implemented using the
        Class.__bases__ += method which means all external classes must be
        new style (inherit from object). """
        SeleniumLibrary.__init__(self, timeout, host, port)
        # use plugin dir if specified, otherwise just load WikiBhasha base
        extension_paths = [wbSelenium.BASE_DIR] + (plugin_dir and [os.path.abspath(plugin_dir)] or [])
        # get list of all of the javascript files and flatten list
        js_files = sum([self._get_ext_js(path) for path in extension_paths], [])
        self._user_ext_file = js_files and TempJSExtensionFile() or None
        def process_curry(file):
            self._process_js_ext(file, self._user_ext_file)
        map(process_curry, js_files)
        # inherit from other extensions (must take a flat tuple)
        ext_classes = tuple(sum([self._get_ext_classes(path) for path in extension_paths], []))
        # plugins override SeleniumLibrary in MRO
        wbSelenium.__bases__ = ext_classes + wbSelenium.__bases__ 
        for klass in ext_classes:
            log("wbSelenium imported class: " + klass.__name__)
            #super(klass, self).__init__()
            klass.__init__(self)

    def start_selenium_server(self, *params):
        """Start a selenium-server using extensions specified in the 
        constructor and selenium-server *params.

        Note that server params `port`, `timeout` and `userExtensions` are 
        not appliciable as they are specified in the wbSelenium 
        constructor."""
        if selenium_server_is_running(self._server_host, self._server_port):
            error = 'an instance of selenium-server on host %s, port %s is already running, please shutdown and rerun testcase' % (self._server_host, self._server_port) 
            warn(error)
            raise RuntimeError, error
        params += ('-port', str(self._server_port))
        if self._user_ext_file:
            params += ('-userExtensions', self._user_ext_file.name)
        SeleniumLibrary.start_selenium_server(self, *params) # unfortunatly this fails silently as well
        wait_until_server_has_started(self._server_host, self._server_port)

    @exception_retry_decorator(OSError, "could not close file")
    def shut_down_selenium_server(self):
        """Stop the previously started selenium-server and clean up any
        temporary files that were created."""
        try: SeleniumLibrary.shut_down_selenium_server(self)
        # error only is thrown when log file was not created,
        # this only happens when a previous sele-server was 
        # running that we didn't start
        except AttributeError: warn("stopped selenium server that we didn't start")
        else: self._user_ext_file.close()
    
    @staticmethod
    def _process_js_ext(script_path, tmpfile):     
        """Open file in "script_path" and append it to the existing
        temporary file"""
        with open(script_path, 'r') as script_file:
            tmpfile.write(os.linesep + script_file.read())
            tmpfile.flush()

    @staticmethod
    def _get_ext_js(path):
        """Return a list of files (their absolute path) in "path" which
        end in extension ".js".
    
        This method is static as it is independent of the class instances
        and it is easier to test as static."""
        log("searching path %s for javascript files" % path)
        full_path = os.path.join(path, wbSelenium.JS_DIR)
        files = []
        if os.path.exists(full_path):
            files = [os.path.abspath(os.path.join(full_path, file))
                     for file in os.listdir(full_path) 
                     if os.path.splitext(file)[1].startswith(".js")]
        log("found files %s in path %s" % (files, path))
        return files

    @staticmethod
    def _get_ext_classes(path):
        """Return a list of class objects defined in all ".py" files within
        "path".
        
        All .py modules are imported using "__import__", while classes are
        identified using the "inspect" module. The sys.path list is altered
        to allow imports from the external path. 

        This method is static as it is independent of the class instances
        and it is easier to test as static."""
        #path = os.abspath(path)
        log("searching path %s for python plugin classes to extend from" % path)
        if not os.path.exists(path):
            raise ImportError, "extension directory path %s does not exist" % (path,) 
        # add the specified path to sys.path so we can import from them
        sys.path.append(path)
        try:
            # only do top level search for .py files
            # this may need to change if we want pyc support
            extensions = [__import__(os.path.splitext(file)[0]) for file in os.listdir(path)
                          if os.path.splitext(file)[1] == ".py"]
            # only get classes that are defined inside the module, ignore imported classes
            def get_classes_from_module(module):
                classes = inspect.getmembers(module, inspect.isclass)
                # filter out hidden classes and imported classes
                return filter(lambda x: x[1].__module__ == module.__name__ and
                              not x[1].__name__.startswith('_'), classes)
            # grab all the classes defined within the module and flatten list
            classes = sum([dict(get_classes_from_module(module))
                       .values() for module in extensions], [])
                            
        finally:
            # remove the module path that we previously added to sys
            sys.path.remove(path)
        log("found classes %s in path %s" % (classes, path))
        return classes

    def get_keyword_names(self):
        """Return all keywords defined in this class. Robot uses this
        method when determining what classes define what keywords.

        Note that we also proxy requests directly to the selenium object
        because SeleniumLibrary does not define all selenium keywords."""
        methods =  [method for method in dir(self) if  not method.startswith("_") and callable(getattr(self, method)) ]
        selenium_methods = [method for method in dir(selenium) if not method.startswith("_") and callable(getattr(selenium, method))]
        methods.extend([m for m in selenium_methods if m not in methods])
        return methods

    def __getattr__(self, name):
        """Get a keyword (method) from this library. Proxy all undefined
        requests to the selenium object.

        Note that a CallBack is necessary because __getattr__ is called
        for all keywords by Robot when you include the Library, however 
        SeleniumLibrary's selenium object has not be instantiated yet,
        causing an attribute error."""
        #log("Method %s called on wbSelenium" % name) # verbose
        if name in dir(selenium):
            obj =  CallBack(self,name)
            return obj.__call__
        else:
            #warn("no method %s found in wbSelenium" % name) # verbose
            raise AttributeError, name

class CallBack(object):
    """Provides a wrapper for an object which may not exist yet but
    can be called sometime in the future. Useful when dealing with
    Robot framework and SeleniumLibrary because Robot tries to retrieve
    attributes before they are ready."""
    def __init__(self,library,method):
        self.library = library
        self.method = method
    def __call__(self,*args):
        method = getattr(self.library._selenium, self.method)
        return method(*args)

if __name__=='__main__':
    testObj = wbSelenium()
    keyword_names = testObj.get_keyword_names()
    print "\n".join(keyword_names)
