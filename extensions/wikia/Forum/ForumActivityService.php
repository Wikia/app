<?php

interface ForumActivityService {
	/**
	 * Returns information about the N most recently modified Forum threads.
	 * Information includes thread URL, thread title, author data, and timestamp.
	 *
	 * @return array
	 */
	public function getRecentlyUpdatedThreads(): array;
}
