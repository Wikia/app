SLIMBOX V2.04 README
====================
The ultimate lightweight Lightbox clone
... now using the jQuery javascript library

(c) Christophe Beyls 2007-2010
MIT-style license

http://code.google.com/p/slimbox/


Included files:

example.html     A simple example page demonstrating how to use Slimbox with the default configuration.
example.jpg      An example image used on the example page.
README.txt       The file you are reading.
css/*            The Slimbox stylesheet and its associated images. You can edit them to customize Slimbox appearance.
                 You can choose between the standard slimbox2.css or slimbox2-rtl.css which is designed for right-to-left languages.
js/slimbox2.js   The minified version of Slimbox 2, plus the editable autoloading code using default options.
src/slimbox2.js  The Slimbox 2 source. Contains many comments and is not suitable for production use (needs to be minified first).
src/autoload.js  The default autoloading code included after the main minified code in the final production file. It activates Slimbox on selected links.
extra/*          Some extra scripts that you can add to the autoload code block inside slimbox2.js to add special functionality.


Slimbox 2 requires the jQuery library (version 1.3 or more recent) to be installed on your website in order to work properly.

You can remove or customize the provided autoload code block by editing the slimbox2.js file. By default, it behaves like Lightbox.
When deploying slimbox2.js, you MUST always preserve the copyright notice at the beginning of the file.

If you are a developer and want to edit the provided source code, it is strongly recommended to minify the script using "YUI Compressor"
by Julien Lecomte before distribution. It will strip spaces and comments and shrink the variable names in order to obtain the smallest file size.

For more information, please read the documentation on the official project page.


Enjoy!