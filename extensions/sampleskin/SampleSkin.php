<?php
# 
# Sample file -- "How to implement a custom skin"
# Read this file and make the needed changes to your environment to set
# up a new skin.
#
# This sample sets up a skin based on PHPTal templates.
#
# The sample project consists of these files:
#
# * extensions/sampleskin/SampleSkin.php
#   This file. You have to activate it by adding
#   require_once('extensions/sampleskin/SampleSkin.php');
#   to your LocalSettings.php
#
# * extensions/sampleskin/xhtml_sampleskin.pt
#   PHPTal template file. Copy it to 
#   templates/xhtml_sampleskin.pt
#
# * extensions/sampleskin/main.css
#   The CSS file of this skin. Copy it to
#   stylesheets/sampleskin/main.css
#   You might have to create that directory first.
#

# The sample skin is based on PHPTal, so include the base class here:
require_once('Skin.php');
require_once('SkinPHPTal.php');

# Tell MediaWiki to initialize this extension after initializing all the defaults
# The string you append to the $wgExtensionFunctions array should be the name of
# the function used to initialize the extension. 
# Choose a name that is unique.
$wgSkinExtensionFunctions[] = 'wfSampleSkinExtension';

function wfSampleSkinExtension() {
	# Add the name to the list of valid skin names.
	# This list is used to display the select box in the users preferences.
	global $wgValidSkinNames;
	$wgValidSkinNames['sampleskin'] = 'SampleSkin';
}

# The sample skin is based on PHPTal, so we inherit from that class.
class SkinSampleSkin extends SkinPHPTal {
	# To load our own template files, we overload the initPage method:
	function initPage( &$out ) {
		SkinPHPTal::initPage( $out );
		# The skin name of this skin, used for the user's CSS, e.g.
		# User:JeLuF/sampleskin.css
		# will be loaded after all other css files.
		#
		# Also used as the name for the directory of your CSS files:
		# stylesheets/sampleskin/main.css
		# is your base css file.
		# Copy your CSS files to that directory.
		$this->skinname = 'sampleskin';

		# This points to the PHPTal template file. Copy this file
		# to the templates directory. The file name must end in .pt, 
		# but the template variable must not. So this is the setting
		# for xhtml_sampleskin.pt:
		# 
		$this->template = 'xhtml_sampleskin';
	}
}


