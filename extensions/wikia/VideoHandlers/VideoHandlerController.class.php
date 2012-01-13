<?php

class VideoHandlerController extends WikiaController {
	
	public function getEmbedCode() {
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
					$embedCode = $file->getEmbedCode($width, $autoplay);
					$this->setVal('videoId', $videoId);
					$this->setVal('html', $embedCode);					
					//@todo support json embed code
				}				
			}
		}

		$this->setVal('error', $error);
	}
}