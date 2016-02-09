<?php

namespace Wikia\ExactTarget;

interface ExactTargetTaskProvider {

	public function getDeleteUserTask();
	public function getCreateUserTask();
	public function getRetrieveUserTask();
	public function getUserDataVerificationTask();
	public function getRetrieveWikiTask();
	public function getWikiDataVerificationTask();
	public function getUpdateWikiHelper();

}
