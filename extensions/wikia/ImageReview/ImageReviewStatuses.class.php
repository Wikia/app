<?php

class ImageReviewStatuses {
	const STATE_ANY = -1;

	const STATE_UNREVIEWED = 0;
	const STATE_IN_REVIEW = 1;
	const STATE_APPROVED = 2;
	const STATE_REJECTED = 4;
	const STATE_DELETED = 3;
	const STATE_QUESTIONABLE = 5;
	const STATE_QUESTIONABLE_IN_REVIEW = 6;
	const STATE_REJECTED_IN_REVIEW = 7;
	const STATE_AUTO_APPROVED = 8;

	const STATE_WIKI_DISABLED = 97;
	const STATE_INVALID_IMAGE = 98;
	const STATE_ICO_IMAGE = 99;
}
