<?php
namespace Extensions\Wikia\Blogs\Hooks\UserCan;

abstract class Action {
	const CREATE = 'create';
	const EDIT = 'edit';
	const MOVE = 'move';
	const MOVE_TARGET = 'move-target';
	const PROTECT = 'protect';
}
