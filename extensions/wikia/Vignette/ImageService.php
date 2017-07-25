<?php

interface ImageService {
	public function getMostRecentRevision( ImageRevision $revision );
	public function getArchivedRevision( ImageRevision $revision );
}
