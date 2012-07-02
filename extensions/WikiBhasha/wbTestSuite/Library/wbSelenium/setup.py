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

#!/usr/bin/python
from distutils.core import Command
from distutils.command.install_data import install_data
from distutils.command.install import INSTALL_SCHEMES
from unittest import TextTestRunner, TestLoader
from glob import glob
from os.path import splitext, basename, dirname, join as pjoin, split as psplit, splitext
import os
import sys

wb_package_dir = 'src'
bdist_include = (wb_package_dir, ['py', 'js'])
sdist_includes = [bdist_include] + [('tests', ['py', 'js']), ('examples', ['py', 'js', 'html'])]

setup_args = dict(
    name="wbSelenium",
    version="0.0.1",
    description='WikiBhasha Customised Selenium Library for Robot Framework',
    author='Microsoft',
    author_email='wikibfb@microsoft.com',
    url='http://WikiBhasha.org',
    package_dir = {'':wb_package_dir},
)
 
try:
    # if we have setuptools use the depedency resolver, otherwise
    # use distutils without dependency resolution
    from setuptools import setup
    setup_args['install_requires'] = []
    print 'Installer found and using setuptools'
except:
    from distutils.core import setup
    print 'Installer using distutils'


class osx_install_data(install_data):
    # On MacOS, the platform-specific lib dir is /System/Library/Framework/Python/.../
    # which is wrong. Python 2.5 supplied with MacOS 10.5 has an Apple-specific fix
    # for this in distutils.command.install_data#306. It fixes install_lib but not
    # install_data, which is why we roll our own install_data class.

    def finalize_options(self):
        # By the time finalize_options is called, install.install_lib is set to the
        # fixed directory, so we set the installdir to install_lib. The
        # install_data class uses ('install_data', 'install_dir') instead.
        self.set_undefined_options('install', ('install_lib', 'install_dir'))
        install_data.finalize_options(self)

if sys.platform == "darwin": 
    cmdclasses = {'install_data': osx_install_data} 
else: 
    cmdclasses = {'install_data': install_data} 

def fullsplit(path, result=None):
    """
    Split a pathname into components (the opposite of os.path.join) in a
    platform-neutral way.
    """
    if result is None:
        result = []
    head, tail = psplit(path)
    if head == '':
        return [tail] + result
    if head == path:
        return result
    return fullsplit(head, [tail] + result)

# Tell distutils to put the data_files in platform-specific installation
# locations. See here for an explanation:
# http://groups.google.com/group/comp.lang.python/browse_thread/thread/35ec7b2fed36eaec/2105ee4d9e8042cb
for scheme in INSTALL_SCHEMES.values():
    scheme['data'] = scheme['purelib']

# Compile the list of packages available, because distutils doesn't have
# an easy way to do this. Find data files to be included.
root_dir = dirname(__file__)
if root_dir != '':
    os.chdir(root_dir)

def get_packages_and_files(path, exts=[]):
    # if no extensions are set then allow all files
    inexts = lambda file, exts: not exts or splitext(file)[1][1:] in exts
    packages, data_files  = [], []
    for dirpath, dirnames, filenames in os.walk(path):
        # Ignore dirnames that start with '.'
        for i, dirname in enumerate(dirnames):
            if dirname.startswith('.'): del dirnames[i]
        no_prefix_path = fullsplit(dirpath)[1:]
        if '__init__.py' in filenames:
            packages.append('.'.join(no_prefix_path)) # skip src/ prefix
        elif filenames:
            curr_files = [pjoin(dirpath, f) for f in filenames if inexts(f, exts)]
            data_files.append([os.sep.join(no_prefix_path), curr_files])
    return (packages, data_files)

packages, data_files = get_packages_and_files(bdist_include[0], bdist_include[1])

setup_args['packages'], setup_args['data_files'] = packages, data_files

# grab all the dist_files to generate the MANIFEST.in
# needed for `python setup.py sdist`
manifest = open('MANIFEST.in', 'w')
for folder, exts in sdist_includes:
    manifest.write('recursive-include %s *.%s\n' % (folder, " *.".join(exts)))
manifest.close()

# Small hack for working with bdist_wininst.
# See http://mail.python.org/pipermail/distutils-sig/2004-August/004134.html
if len(sys.argv) > 1 and sys.argv[1] == 'bdist_wininst':
    for file_info in data_files:
        file_info[0] = '\\PURELIB\\%s' % file_info[0]

# Enable 'test' option seen in `setuptools` for `distutils`
# thanks to da44en.wordpress.com
class TestCommand(Command):
    user_options = [ ]

    def initialize_options(self):
        self._dir = os.getcwd()

    def finalize_options(self):
        pass

    def run(self):
        '''
        Finds all the tests modules in tests/, and runs them.
        '''
        testfiles = [ ]
        for t in glob(pjoin(self._dir, 'tests', '*.py')):
            if not t.endswith('__init__.py'):
                testfiles.append('.'.join(
                    ['tests', splitext(basename(t))[0]])
                )

        tests = TestLoader().loadTestsFromNames(testfiles)
        t = TextTestRunner(verbosity = 1)
        t.run(tests)

cmdclasses.update({'test':TestCommand})

setup_args['cmdclass'] = cmdclasses

if __name__ == '__main__':
    setup(**setup_args)
