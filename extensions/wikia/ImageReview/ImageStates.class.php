<?php

class ImageStates {

	private function __construct() {}

	const ANY = -1;
	const UNREVIEWED = 0;
	const IN_REVIEW = 1;
	const APPROVED = 2;
	const DELETED = 3;
	const REJECTED = 4;
	const QUESTIONABLE = 5;
	const QUESTIONABLE_IN_REVIEW = 6;
	const REJECTED_IN_REVIEW = 7;
	const AUTO_APPROVED = 8;
	const APPROVED_AND_TRANSFERRING = 21;
	const WIKI_DISABLED = 97;
	const INVALID_IMAGE = 98;
	const ICO_IMAGE = 99;
}
