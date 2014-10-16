<?php

namespace Wikia\Vignette;

interface FileInterface {
	public function isOld();
	public function getArchiveTimestamp();

	public function getHashPath();
	public function getTimestamp();
	public function getName();
}
