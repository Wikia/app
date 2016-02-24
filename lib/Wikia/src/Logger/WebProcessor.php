<?php
/**
 * WebProcessor
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 * @see \Monolog\Processor\WebProcessor
 */

namespace Wikia\Logger;


class WebProcessor {
	const RECORD_TYPE_FIELDS = 'extra';
	const RECORD_TYPE_CONTEXT = 'context';

	private $contextStack = [];
	private $sharedContext = [];

	public function __invoke(array $record) {
		foreach ($this->sharedContext as $type => $context) {
			$record[$type] = array_merge($record[$type], $this->sharedContext[$type]);
		}

		return $record;
	}

	/**
	 * add context that will be present in all messages until a corresponding popContext() call. Multiple context
	 * arrays are stored as a stack.
	 *
	 * @param array $context
	 * @param string $type
	 * @return int amount of context arrays for the current type, including $context
	 */
	public function pushContext(array $context, $type=self::RECORD_TYPE_CONTEXT) {
		if (!isset($this->contextStack[$type])) {
			$this->contextStack[$type] = [];
		}

		array_unshift($this->contextStack[$type], $context);
		$this->prepareContext($type);

		return count($this->contextStack[$type]);
	}

	/**
	 * pop a context array from the context stack. Unless there's a good reason not to, this should always be called
	 * sometime after pushContext()
	 *
	 * @param string $type
	 * @return array
	 */
	public function popContext($type=self::RECORD_TYPE_CONTEXT) {
		$context = array_shift($this->contextStack[$type]);
		$this->prepareContext($type);

		return $context;
	}

	/**
	 * @param string $type
	 * @return array list of context objects for the given $type
	 */
	private function prepareContext($type) {
		$stack = array_reverse($this->contextStack[$type]);

		if (!empty ($stack)) {
			$stack = call_user_func_array('array_merge', $stack);
		}

		$this->sharedContext[$type] = $stack;
		return $this->sharedContext[$type];
	}

} 