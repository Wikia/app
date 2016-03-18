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

	/**
	 * @var ContextSource[][]
	 */
	private $contextStack = [];
	private $sharedContext = [];
	private $listener = null;

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
		return $this->pushContextSource(new ContextSource($context), $type);
	}

	/**
	 * add context that will be present in all messages until a corresponding popContext() call. Multiple context
	 * arrays are stored as a stack.
	 *
	 * @param ContextSource $context
	 * @param string $type
	 * @return int amount of context arrays for the current type, including $context
	 */
	public function pushContextSource(ContextSource $contextSource, $type=self::RECORD_TYPE_CONTEXT) {
		if (!isset($this->contextStack[$type])) {
			$this->contextStack[$type] = [];
		}
		if (is_null($this->listener)) {
			$this->listener = function(ContextSource $cs) {
				wfDebug("WebProcessor::listener - got update ".json_encode($cs->getContext())."\n");
				$this->refreshContext();
			};
		}

		$contextSource->listen($this->listener);

		array_unshift($this->contextStack[$type], $contextSource);
		$this->prepareContext($type);

		return count($this->contextStack[$type]);
	}

	/**
	 * pop a context array from the context stack. Unless there's a good reason not to, this should always be called
	 * sometime after pushContext()
	 *
	 * @param string $type
	 * @return ContextSource
	 */
	public function popContext($type=self::RECORD_TYPE_CONTEXT) {
		$contextSource = array_shift($this->contextStack[$type]);
		$contextSource->unlisten($this->listener);

		$this->prepareContext($type);

		return $contextSource;
	}

	private function refreshContext() {
		$this->prepareContext(self::RECORD_TYPE_CONTEXT);
		$this->prepareContext(self::RECORD_TYPE_FIELDS);
	}

	/**
	 * @param string $type
	 * @return array list of context objects for the given $type
	 */
	private function prepareContext($type) {
		if (!isset($this->contextStack[$type])) {
			$this->contextStack[$type] = [];
		}

		$stack = array_reverse($this->contextStack[$type]);
		wfDebug(__METHOD__.' - stack #1 ' . json_encode($stack) ."\n");
		$getContextFunc = function(ContextSource $contextSource) {
			return $contextSource->getContext();
		};
		$stack = array_map($getContextFunc,$stack);
		wfDebug(__METHOD__.' - stack #2 ' . json_encode($stack) ."\n");

		if (!empty ($stack)) {
			$stack = call_user_func_array('array_merge', $stack);
		}

		$this->sharedContext[$type] = $stack;
		return $this->sharedContext[$type];
	}

} 