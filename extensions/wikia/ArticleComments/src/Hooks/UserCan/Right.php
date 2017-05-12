<?php
namespace Extensions\Wikia\ArticleComments\Hooks\UserCan;

abstract class Right {
	const COMMENT_CREATE = 'commentcreate';
	const COMMENT_DELETE = 'commentdelete';
	const COMMENT_EDIT = 'commentedit';
	const COMMENT_MOVE = 'commentmove';
	const EDIT = 'edit';
}
