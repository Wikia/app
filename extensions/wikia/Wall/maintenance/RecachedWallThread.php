<?php
class RecachedWallThread extends WallThread {
	public function getThreadKey() {
		return wfMemcKey( WallThread::class, '-thread-key-', $this->mThreadId );
	}
}
