<?php

namespace Wikia\Vignette;

interface FileInterface {
	public function getRel();
	public function getTimestamp();
	public function getName();
}
