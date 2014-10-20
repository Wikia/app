<?php

class ExactTargetUserHooksTaskInstanceHelper {
	/**
	 * Returns new instance of ExactTargetCreateUserTask
	 * @return ExactTargetCreateUserTask
	 */
	public function getExactTargetCreateUserTask() {
		return new ExactTargetCreateUserTask();
	}

	/**
	 * Returns new instance of ExactTargetUpdateUserTask
	 * @return ExactTargetUpdateUserTask
	 */
	public function getExactTargetUpdateUserTask() {
		return new ExactTargetUpdateUserTask();
	}

	/**
	 * Returns new instance of ExactTargetRemoveUserTask
	 * @return ExactTargetRemoveUserTask
	 */
	public function getExactTargetRemoveUserTask() {
		return new ExactTargetRemoveUserTask();
	}
}
