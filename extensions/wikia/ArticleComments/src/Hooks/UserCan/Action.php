<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan;

abstract class Action {
	const CREATE = 'create';
	const EDIT = 'edit';
	const DELETE = 'delete';
	const MOVE = 'move';
	const MOVE_TARGET = 'move-target';
	const UNDELETE = 'undelete';
}
