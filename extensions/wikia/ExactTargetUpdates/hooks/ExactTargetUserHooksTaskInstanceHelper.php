<?php

class ExactTargetUserHooksTaskInstanceHelper {
	/**
	 * Returns new instance of ExactTargetCreateUserTask
	 * @return ExactTargetCreateUserTask
	 */
	public function getCreateUserTask() {
		return new ExactTargetCreateUserTask();
	}

	/**
	 * Returns new instance of ExactTargetUpdateUserTask
	 * @return ExactTargetUpdateUserTask
	 */
	public function getUpdateUserTask() {
		return new ExactTargetUpdateUserTask();
	}

	/**
	 * Returns new instance of ExactTargetRemoveUserTask
	 * @return ExactTargetRemoveUserTask
	 */
	public function getRemoveUserTask() {
		return new ExactTargetRemoveUserTask();
	}
}
