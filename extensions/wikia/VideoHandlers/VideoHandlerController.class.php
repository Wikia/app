<?php

class VideoHandlerController extends WikiaController {
	
	public function getEmbedCode() {
		$articleId = $this->getVal('articleId', '');
		$title = $this->getVal('title', '');
		$width = $this->getVal('width', '');
		$autoplay = $this->getVal('autoplay', false);
		
		$error = '';
		if (empty($title)) {
			$error = $this->wf->msgForContent('videohandler-error-missing-title');
		}
		else {
			if (empty($width)) {
				$error = $this->wf->msgForContent('videohandler-error-missing-width');
			}
			else {
				$file = wfFindFile($title);
				if ($file === false) {
					$error = $this->wf->msgForContent('videohandler-error-video-no-exist');
				}
				else {
					$videoId = $file->getVideoId();
					$assetUrl = $file->getPlayerAssetUrl();
					$embedCode = $file->getEmbedCode($articleId, $width, $autoplay, true);
					$this->setVal('videoId', $videoId);
					$this->setVal('asset', $assetUrl);
					$this->setVal('embedCode', $embedCode);					
					//@todo support json embed code
				}				
			}
		}

		if (!empty($error)) {
			$this->setVal('error', $error);
		}
	}
}