<?php

class ExactTargetUserHooksTaskInstanceHelper {
	/**
	 * Returns new instance of ExactTargetAddUserTask
	 * @return ExactTargetAddUserTask
	 */
	public function getExactTargetAddUserTask() {
		return new ExactTargetAddUserTask();
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
