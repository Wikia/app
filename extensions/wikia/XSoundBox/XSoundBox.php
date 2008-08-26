<?php
if (!defined('MEDIAWIKI')) die();

// Extension written by CorfiX.
// Tomasz Klim, 2007


$wgExtensionFunctions [] = 'wfXSoundBox';
$wgXSoundRepoPath = '/images/_ext_xsound/images/';
$wgXSoundRepoURL = 'http://images.wikia.com/_ext_xsound/images/';

function wfXSoundBox() {
	global $wgParser;
	$wgParser->setHook( 'xsound', 'EmbedXSound' );
}

function EmbedXSound($fName, $argV) {
	global $wgStylePath;
	global $wgUploadPath, $wgUploadDirectory;
	global $wgXSoundRepoPath, $wgXSoundRepoURL;

	# 'Oh, well, better don't ask.' :]
	$fFullName = (empty($argV['src']) ? $fName : $argV['src']); $fFullName {0} = strtoupper($fFullName{0});
	$xFlashFile = (empty($argV['ext']) ? $wgStylePath . '/JukeboxLite.swf' : $wgStylePath . '/JukeboxFull.swf');

	$fBaseName = substr($fFullName, 0, strlen($fFullName) - 4);
	$fExtension = substr($fFullName, strlen($fFullName) - 3);

	$strHash = md5($fFullName);
	$outDirSuffix = substr($strHash, 0, 1) . "/" . substr($strHash, 0, 2) . "/";

	# Echo $wgUploadDirectory . '/' . $outDirSuffix . $fFullName . ' --- ';

	if (file_exists($wgUploadDirectory . '/' . $outDirSuffix . $fFullName)) {
		if (strtoupper($fExtension) != 'MP3') {
			$fSndPath = $wgUploadDirectory . '/'  . $outDirSuffix . $fBaseName . '.mp3';
			$fMP3Path = $wgXSoundRepoPath . $outDirSuffix . $fBaseName . '.mp3';

			if (!file_exists($fMP3Path)) {
				$outDir = $wgXSoundRepoPath . $outDirSuffix;
					
				if (!file_exists($outDir)) {
					exec("mkdir -p $outDir");
				}

				exec("/usr/local/bin/sox $fSndPath -t wav - | /usr/local/bin/lame - $fMP3Path");

				if (!file_exists($fMP3Path)) {
					wfDebug('XSound tried to convert ' . $fSndPath . ' to ' . $fMP3Path . ' but FAILED.');
				}
			}
		}

		$fMP3URL = (strtoupper($fExtension) != 'MP3') 
			 ? ($wgXSoundRepoPath . $outDirSuffix . $fBaseName . '.mp3')
			 : ($wgUploadPath . '/' . $outDirSuffix . $fBaseName . '.mp3');

		$fPageURL = (Title::MakeTitle(NS_MEDIA, $fFullName)->Exists())
			 ? ($wgXSoundRepoURL . $outDirSuffix . $fBaseName . 'mp3')
			 : ( Title::MakeTitle(NS_MEDIA, $fFullName)->GetLocalUrl());

		return ''
		//. '<span class="xsound">' . '&nbsp;&nbsp;&nbsp;'
		. '<p style="display:inline">'
		. '<object type="application/x-shockwave-flash" data="' . $xFlashFile . '" width="' . (!empty($argV['ext']) ? 215 : 20) . '" height="' . (!empty($argV['ext']) ? 60 : 20) . '">'
		. '<param name="movie" value="' . $xFlashFile . '" />'
		. '<param name="flashvars" value="URL=' . $fMP3URL .'" />'
		. '</object>'
		. '</p>'
		//. '</span>'
		. (!empty($argV['ext']) ? '' : '&nbsp;<a href="' . $fPageURL . '" class="old" title="' . htmlspecialchars($fFullName) . '">' . htmlspecialchars($fFullName) . '</a>');
	} else {
		$URI = Title::MakeTitle(NS_SPECIAL, 'Upload')->GetLocalUrl('wpDestFile=' . urlencode($fFullName));
		return '<a href="' . $URI . '" class="new" title="' . htmlspecialchars($fFullName) . '">' . htmlspecialchars($fFullName) . '</a>'
		. '<!-- File is missing: ' . $wgUploadDirectory . '/' . $outDirSuffix . $fFullName
		. '; PHP: ' . file_exists($wgUploadDirectory . '/' . $outDirSuffix . $fFullName) . ' -->';
	}
}


?>
