<?php
/**
 * Templates for the Player Extension to MediaWiki
 *
 * Things in {{{tripple curly braces}}} are placeholders. See the README
 * file or http://www.mediawiki.org/wiki/Extension:Player for
 * information about the template syntax.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @licence: do what you please
 */

# Generic embedding, relying on mime type and browser plugin
$wgPlayerGenericTemplate =
		'<object type="{{{type}}}" data="{{{url}}}"
			{{{#attr:height}}} {{{#attr:width}}}
			{{{#attr:id}}} {{{#attr:style}}} {{{#attr:class}}}>

			{{{#param:hidden}}}
			{{{#param:autostart}}}
			{{{#param:autoplay}}}
			{{{#param:loop}}}
			{{{#param:palette}}}
			{{{#param:controls}}}
			{{{#param:menu}}}

			<noembed>{{{plainalt}}}</noembed>

			<embed type="{{{type}}}" src="{{{url}}}"
				{{{#attr:height}}} {{{#attr:width}}}
				{{{#attr:autostart}}} {{{#attr:autoplay}}} {{{#attr:loop}}}
				{{{#attr:hidden}}} {{{#attr:controls}}} {{{#attr:menu}}}/>
		</object>';

# Generic embedding, relying on mime type and browser plugin,
# plus a workaround for a kink in Adobe's SVG plugin.
$wgPlayerSvgPluginTemplate =
		'<object type="image/svg+xml" data="{{{url}}}"
			{{{#attr:height}}} {{{#attr:width}}}
			{{{#attr:id}}} {{{#attr:style}}} {{{#attr:class}}}>

			{{{#param:url|src}}}

			<noembed>{{{plainalt}}}</noembed>

			<embed type="{{{type}}}" data="{{{src}}}"
				{{{#attr:height}}} {{{#attr:width}}}/>
		</object>';

# Requesting Flash/ShockWave plugin explicitely
$wgPlayerFlashPluginTemplate =
		'<object type="application/x-shockwave-flash" data="{{{fullurl}}}"
			{{{#attr:height}}} {{{#attr:width}}}
			codebase="http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0"
			{{{#attr:id}}} {{{#attr:style}}} {{{#attr:class}}}>

			{{{#param:fullurl|movie}}}
			{{{#param:flashvars|FlashVars}}}
			{{{#param:quality}}}
			{{{#param:menu}}}
			{{{#param:wmode}}}
			{{{#param:scale}}}

			<noembed>{{{plainalt}}}</noembed>

			<embed type="{{{type}}}" src="{{{fullurl}}}"
				{{{#attr:height}}} {{{#attr:width}}}
				pluginspage="http://www.macromedia.com/go/getflashplayer"
				{{{#attr:quality}}}
				{{{#attr:menu}}}
				{{{#attr:wmode}}}
				{{{#attr:scale}}}
				{{{#attr:flashvars}}}/>
		</object>';


# pattern for FlashVars used by FlowPlayer (used in $wgPlayerFlowPlayerTemplate)
define('FLOWPLAYER_FLASHVARS_TEMPLATE', '
config={
	autoPlay: "{{{autoplay|true}}}",
	loop: "{{{loop|true}}}",
	initialScale: "{{{fit|fit}}}",
	playList: [ { name: "{{{filename}}}" , type: "flv", url: "{{{fullurl}}}" } ],
}');

# Use FlowPlayer to play FLV
$wgPlayerFlowPlayerTemplate =
		'<object type="application/x-shockwave-flash" data="{{{#env:wgPlayerExtensionPath}}}/FlowPlayerLight.swf"
			{{{#attr:height}}} {{{#attr:width}}}
			codebase="http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0"
			{{{#attr:id}}} {{{#attr:style}}} {{{#attr:class}}}>

			<param name="movie" value="{{{#env:wgPlayerExtensionPath}}}/FlowPlayerLight.swf"/>
			<param name="FlashVars" value="'.htmlspecialchars(FLOWPLAYER_FLASHVARS_TEMPLATE).'"/>
			<param name="allowScriptAccess" value="sameDomain"/>
			<param name="allowNetworking" value="all"/>
			<param name="quality" value="hi"/>
			<param name="wmode" value="transparent"/>
			<param name="autoPlay" value="true"/>
			<param name="loop" value="true"/>

			{{{#param:menu}}}

			<noembed>{{{plainalt}}}</noembed>

			<embed type="application/x-shockwave-flash"
				src="{{{#env:wgPlayerExtensionPath}}}/FlowPlayerLight.swf"
				pluginspage="http://www.macromedia.com/go/getflashplayer"
				{{{#attr:height}}} {{{#attr:width}}}
				{{{#attr:menu}}}
				allowscriptaccess="sameDomain"
				allownetworking="all"
				quality="hi"
				wmode="transparent"
				autoplay="true"
				loop="true"
				flashvars="'.htmlspecialchars(FLOWPLAYER_FLASHVARS_TEMPLATE).'"/>
		</object>';

# Use Cortado player to play OGG vorbis/theora
$wgPlayerCortadoPlayerTemplate =
		'<div><!-- type: {{{type}}} -->
		<applet code="com.fluendo.player.Cortado.class"
			archive="{{{#env:wgPlayerExtensionPath}}}/cortado-ovt-stripped-0.2.2.jar"
			{{{#attr:height}}} {{{#attr:width}}} {{{#attr:uniq|id}}}>

			<param name="url" value="{{{fullurl}}}"/>
			<param name="bufferSize" value="2000"/>
			<param name="bufferLow" value="10"/>
			<param name="bufferHigh" value="20"/>
			<param name="showStatus" value="{{{showStatus|show}}}"/>
			<param name="live" value="{{{live|false}}}"/>

			{{{plainalt}}}
		</applet>
		{{{#ifunset:terse|<br /><button onclick="document.getElementById(&quot;{{{uniq}}}&quot;).restart();">Restart</button>}}}
		</div>';

# force generic (pseudo-mime)
$wgPlayerTemplates['generic'] = $wgPlayerGenericTemplate;

# generic audio
$wgPlayerTemplates['audio/mp3'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['audio/wav'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['audio/midi'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['audio/basic'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['audio/x-aiff'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['audio/x-pn-realaudio'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['audio/ogg'] = $wgPlayerGenericTemplate;

# generic video
$wgPlayerTemplates['video/mpeg'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['video/ogg'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['application/ogg'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['video/x-msvideo'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['video/x-ms-asf'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['video/quicktime'] = $wgPlayerGenericTemplate;

# generic documents
$wgPlayerTemplates['application/rtf'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['application/pdf'] = $wgPlayerGenericTemplate;
$wgPlayerTemplates['application/postscript'] = $wgPlayerGenericTemplate;

# other
$wgPlayerTemplates['x-world/x-vrml'] = $wgPlayerGenericTemplate;

# special cases and workarounds for kinks in specific plugins
$wgPlayerTemplates['image/svg'] = $wgPlayerSvgPluginTemplate;
$wgPlayerTemplates['image/svg+xml'] = $wgPlayerSvgPluginTemplate;
$wgPlayerTemplates['application/x-shockwave-flash'] = $wgPlayerFlashPluginTemplate;

# MS Office
# $wgPlayerTemplates['application/vnd.ms-excel'] = $wgPlayerGenericTemplate;
# $wgPlayerTemplates['application/vnd.ms-powerpoint'] = $wgPlayerGenericTemplate;
# $wgPlayerTemplates['application/vnd.ms-works'] = $wgPlayerGenericTemplate;
# $wgPlayerTemplates['application/msword'] = $wgPlayerGenericTemplate;
# $wgPlayerTemplates['application/vnd.ms-excel'] = $wgPlayerGenericTemplate;

# embedded players
# $wgPlayerTemplates['video/x-flv'] = $wgPlayerFlowPlayerTemplate;
# $wgPlayerTemplates['audio/ogg'] = $wgPlayerCortadoPlayerTemplate; #vorbis
# $wgPlayerTemplates['video/ogg'] = $wgPlayerCortadoPlayerTemplate; #theora
# $wgPlayerTemplates['application/ogg'] = $wgPlayerCortadoPlayerTemplate; #other ogg

# resolution detectors
# $wgPlayerVideoResolutionDetector = 'mplayer $file -vo BadDummy -ao BadDummy 2>&1 | grep ^VIDEO';
# $wgPlayerVideoResolutionDetector = array(
#	'*' => 'mplayer $file -vo BadDummy -ao BadDummy 2>&1 | grep ^VIDEO',
#	'video/ogg' => array(
#		'command' => 'ogginfo $file | egrep -i "^(width|height)"',
#		'outpattern' => '/^.*(width: )(\d+)[ \r\n]+(height: )(\d+).*$/si',
#		'outreplace' => '\2x\4',
#	)
#);

$wgPlayerMimeOverride = array(
	'image/svg' => 'image/svg+xml',   #there's some confusion about the correct type for SVG
	'video/ogg' => 'application/ogg', #video/ogg is hardcoded for theora, but isn't supported by all browsers
	'audio/ogg' => 'application/ogg', #audio/ogg is hardcoded for vorbis, but isn't supported by all browsers
);
