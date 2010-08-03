<?php
/* Copyright (c) 2008 River Tarnell <river@loreley.flyingparchment.org.uk>. */
/*
 * Permission is granted to anyone to use this software for any purpose,
 * including commercial applications, and to alter it and redistribute it
 * freely. This software is provided 'as-is', without any express or implied
 * warranty.
 */
/* $Id: ABC.php 47659 2009-02-22 13:52:20Z raymond $ */

if (!defined('MEDIAWIKI'))
	die();
	
# The on-disk path where ABC files and rendered images / PDFs
# will be placed.
# Example: $abcPath = "/var/www/wiki/abc";
$abcPath = false; 

# The HTTP path where the above directory is found.
# Example: $abcURL = "/wiki/abc";
$abcURL = false;

# Path to the abcm2ps executable.  Required.
$abcm2ps = "/usr/bin/abcm2ps";

# Path to the ps2pdf executable.  Required.
$abcps2pdf = "/usr/bin/ps2pdf14";

# Path to the abc2midi executable.  Optional; set this if you
# want to enable MIDI rendering.
#$abc2midi = "/usr/bin/abc2midi";
$abc2midi = false;

# Path to the TiMidity++ executable.  Optional; set this if you
# want Ogg Vorbis rendering.  Requires MIDI rendering.
#$abctimidity = "/usr/bin/timidity";
$abctimidity = false;

# Default instrument number for Vorbis.
# 0 = Piano, 40 = Violin, 73 = Flute.  See General MIDI
# specification or your TiMidity++ patch description for others.
$abcMIDIvoice = 1;

# If you have the OggHandler extension installed, set this to
# 'true' to embed the OggHandler below the music.  This will
# allow users to listen to the music on the page.  To use this,
# you must enable Ogg Vorbis rendering.
$abcOggHandler = false;

# Set this if you will render the outputs (ps, pdf, png, etc.) 
# outside of the extension.  Nothing will be generated except the
# .abc file.
$abcDelayedRendering = false;

$wgExtensionCredits['parserhooks'][] = array(
	'name'           => 'ABC',
	'author'         => 'River Tarnell',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:ABC',
	'svn-date'       => '$LastChangedDate: 2009-02-22 14:52:20 +0100 (ndz, 22 lut 2009) $',
	'svn-revision'   => '$LastChangedRevision: 47659 $',
	'description'    => 'Adds <tt>&lt;abc&gt;</tt> tag to format ABC music',
	'descriptionmsg' => 'abcdesc',
);
$wgExtensionMessagesFiles['ABC'] =  dirname(__FILE__) . '/ABC.i18n.php';

if (defined('MW_SUPPORTS_PARSERFIRSTCALLINIT')) {
	$wgHooks['ParserFirstCallInit'][] = 'efABCInit';
} else {
	$wgExtensionFunctions[] = 'efABCParserInit';
}

function
efABCInit() {
global	$wgParser, $wgOut, $abcOggHandler;
	wfLoadExtensionMessages('ABC');
	$wgParser->setHook( 'abc', 'efABCRender' );
	
	if ($abcOggHandler) {
		$oh = new OggHandler();
		$oh->setHeaders($wgOut);
	}
	
	return true;
}
 
function
efABCRender($input, $args, $parser) {
global	$abcPath, $abcURL, $abc2midi, $abctimidity, $abcOggHandler,
	$abcDelayedRendering, $wgLang;

	if ($abcPath == false || $abcURL == false)
		return 'Error: $abcPath and $abcURL must be set to use the ABC extension.';

	/*
	 * To avoid re-rendering the same tunes on every view,
	 * use the hash of the ABC content for the filename.
	 * This has the added benefit that rendering the same tune
	 * on different pages will only cause one rendering.
	 */
	$float = "left";
	if (isset($args['float']) && $args['float'] == 'right')
		$float = "right";

	$abc = preg_replace("/^\n+/", "", $input);
	$hash = sha1($input);
	$error = "";

	$hashbits = array(
		substr($hash, 0, 2),
		substr($hash, 2, 2),
		substr($hash, 4, 2));
	$directory = "{$hashbits[0]}/{$hashbits[1]}/{$hashbits[2]}";
	$filename = "$abcPath/$directory/$hash";

	if (!@file_exists("$abcPath/$directory"))
		if (!@mkdir("$abcPath/$directory", 0777, true))
			return "Cannot create directory \"$abcPath/$directory\".";

	/*
	 * Try to extract the title from the ABC.  This is used as the
	 * alt text for the image.
	 */
	$title = "Unknown song";
	if (preg_match("/^T:\s*(.*)$/m", $input, $matches))
		$title = $matches[1];

	if (!abcCreateABC($abc, $filename, $error))
		return str_replace("\n", "<br />", htmlspecialchars($error));

	if (!$abcDelayedRendering) {
		if (!abcCreatePS($abc, $filename, $error))
			return str_replace("\n", "<br />", htmlspecialchars($error));
		if (!abcCreatePNG($abc, $filename, $error))
			return str_replace("\n", "<br />", htmlspecialchars($error));
		if (!abcCreatePDF($abc, $filename, $error))
			return str_replace("\n", "<br />", htmlspecialchars($error));
		if ($abc2midi)
			if (!abcCreateMIDI($abc, $filename, $error))
				return str_replace("\n", "<br />", htmlspecialchars($error));
		if ($abc2midi && $abctimidity)
			if (!abcCreateVorbis($abc, $filename, $error))
				return str_replace("\n", "<br />", htmlspecialchars($error));
	}

	/*
	 * Succeeded to create all the output formats, return the
	 * output.  We produce an image from the PNG, and include
	 * links to the ABC and PS.
	 */
	$e_title = htmlspecialchars($title);
	$e_imgpath = htmlspecialchars("$abcURL/$directory/$hash.png");
	$e_abcpath = htmlspecialchars("$abcURL/$directory/$hash.abc");
	$e_pspath = htmlspecialchars("$abcURL/$directory/$hash.ps");
	$e_pdfpath = htmlspecialchars("$abcURL/$directory/$hash.pdf");
	$e_midipath = htmlspecialchars("$abcURL/$directory/$hash.mid");
	$e_vorbispath = htmlspecialchars("$abcURL/$directory/$hash.ogg");

	$links = array();
	$links[] = "<a href=\"$e_abcpath\">" . wfMsg('abcabc') . "</a>";
	$links[] = "<a href=\"$e_pspath\">" . wfMsg('abcps') . "</a>";
	$links[] = "<a href=\"$e_pdfpath\">" . wfMsg('abcpdf') . "</a>";
	if ($abc2midi)
		$links[] = "<a href=\"$e_midipath\">" . wfMsg('abcmidi') . "</a>";
	if ($abctimidity)
		$links[] = "<a href=\"$e_vorbispath\">" . wfMsg('abcvorbis') . "</a>";

	$e_dllinks = wfMsg('abcdownload') . " " . $wgLang->pipeList( $links );

	$ogghtml = "";

	if ($abcOggHandler) {
		$oh = new OggTransformOutput(null,
			"$filename.ogg", false,
			250, 0, 0, false, 
			"$filename.ogg", false);
		$ogghtml = $oh->toHtml(array('alt' => $title));
	}

	$output = <<<EOF
<div style="float: $float; border: solid 1px #aaaaaa; margin: 0.2em;" class="abc-music">
	<img src="$e_imgpath" alt="$e_title" />
	<div style="text-align: center">
		$e_dllinks
	</div>
	<div style='margin-left: auto; margin-right: auto;'>
		$ogghtml
	</div>
</div>
EOF;
	return $output;
}

function
abcCreateABC($abc, $pfx, &$error)
{
global	$abcPath;
	if (!@file_exists($abcPath)) {
		$error = "Error: $abcPath does not exist.";
		return false;
	}
	
	$filename = "$pfx.abc";
	if (file_exists($filename))
		return true;
		
	if (($f = @fopen($filename, "w")) === false) {
		$last = error_get_last();
		$msg = $last['msg'];
		$error = "Error: cannot create $filename: $msg";
		return false;
	}
	
	if (@fwrite($f, $abc) === false) {
		@unlink($filename);
		$last = error_get_last();
		$msg = $last['msg'];
		$error = "Error: cannot write to $filename: $msg";
		return false;
	}
       
	if (@fclose($f) === false) {
		@unlink($filename);
		$last = error_get_last();
		$msg = $last['msg'];
		$error = "Error: cannot write to $filename: $msg";
		return false;
	}

	return true;
}

function
abcCreatePS($abc, $pfx, &$error)
{
global	$abcm2ps, $abcPath;
	if (!@file_exists($abcm2ps)) {
		$error = "Error: $abcm2ps not found.";
		return false;
	}
	
	$input = "$pfx.abc";
	$output = "$pfx.ps";

	if (file_exists($output))
		return true;
	
	$cmd = "$abcm2ps -E $input -O $pfx";
	@exec($cmd, $cmd_out, $ret);
	if ($ret != 0 || !@file_exists("{$pfx}001.eps")) {
		$error = "Error: $abcm2ps failed to convert input (ret: $ret).\n";
		$error .= "Output: " . join("\n", $cmd_out);
		return false;
	}
	
	if (@rename("{$pfx}001.eps", "{$pfx}.ps") === false) {
		$error = "Error: cannot rename output file.";
		return false;
	}
	
	return true;
}

function
abcCreatePDF($abc, $pfx, &$error)
{
global	$abcps2pdf, $abcPath;
	if (!@file_exists($abcps2pdf)) {
		$error = "Error: $abcps2pdf not found.";
		return false;
	}
	
	$input = "$pfx.ps";
	$output = "$pfx.pdf";

	if (file_exists($output))
		return true;

	$cmd = "$abcps2pdf -dEPSCrop $input $output";
	@exec($cmd, $cmd_out, $ret);
	if ($ret != 0 || !@file_exists("$pfx.pdf")) {
		$error = "Error: $abcps2pdf failed to convert input (ret: $ret).\n";
		$error .= "Output: " . join("\n", $cmd_out);
		return false;
	}
	
	return true;
}

function
abcCreatePNG($abc, $pfx, &$error)
{
global	$wgImageMagickConvertCommand, $abcPath;
	if (!$wgImageMagickConvertCommand) {
		$error = "Error: ImageMagick not enabled.";
		return false;
	}
	
	$input = "$pfx.ps";
	$output = "$pfx.png";

	if (file_exists($output))
		return true;

	$cmd = "$wgImageMagickConvertCommand $input $output";
	@exec($cmd, $cmd_out, $ret);
	if ($ret != 0 || !@file_exists($output)) {
		$error = "Error: ImageMagick failed to convert input [$output] (ret: $ret).";
		$error .= "Output: " . join("\n", $cmd_out);
		return false;
	}

	return true;
}

function
abcCreateMIDI($abc, $pfx, &$error)
{
global	$abc2midi, $abcPath;
	if (!$abc2midi) {
		$error = "Error: $abc2midi not found.";
		return false;
	}
	
	$input = "$pfx.abc";
	$output = "$pfx.mid";

	if (file_exists($output))
		return true;

	$cmd = "$abc2midi $input -o $output";
	@exec($cmd, $cmd_out, $ret);
	if ($ret != 0 || !@file_exists($output)) {
		$error = "Error: $abc2midi failed to convert input [$output] (ret: $ret).";
		$error .= "Output: " . join("\n", $cmd_out);
		return false;
	}

	return true;
}

function
abcCreateVorbis($abc, $pfx, &$error)
{
global	$abctimidity, $abcMIDIvoice, $abcPath;
	if (!@file_exists($abctimidity)) {
		$error = "Error: TiMidity++ not enabled.";
		return false;
	}
	
	$input = "$pfx.mid";
	$output = "$pfx.ogg";

	if (file_exists($output))
		return true;

	$cmd = "$abctimidity -Ei$abcMIDIvoice -Ov -id $input";
	@exec($cmd, $cmd_out, $ret);
	if ($ret != 0 || !@file_exists($output)) {
		$error = "Error: TiMidity++ failed to convert input [$output] (ret: $ret).";
		$error .= "Output: " . join("\n", $cmd_out);
		return false;
	}

	return true;
}
