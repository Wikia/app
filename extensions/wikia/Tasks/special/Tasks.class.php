<?php
class Tasks {
	const EXTERNAL_TASK_HOOK_NAME = 'tasks_external';

	private $title = null;
	private $app = null;

	public function __construct(Title $title=null) {
		$this->app = F::app();
		$this->title = $title;
	}

	public function getTaskClasses() {
		$dir = __DIR__.'/../Tasks/*.class.php';
		$baseClassName = 'Wikia\\Tasks\\Tasks\\';
		$taskClasses = [];

		foreach (glob($dir) as $file) {
			$className = basename($file, '.class.php');
			if ($className == 'BaseTask') {
				continue;
			}

			$fullClassName = $baseClassName.$className;

			$taskClasses[] = [
				'name' => $fullClassName,
				'value' => $className,
			];
		}

		wfRunHooks(self::EXTERNAL_TASK_HOOK_NAME, [$taskClasses]);
		return $taskClasses;
	}

	public function getClassMethods($class) {
		/** @var \Wikia\Tasks\Tasks\BaseTask $instance */
		$instance = new $class();
		$mirror = new ReflectionClass($class);
		$mirrorClass = $mirror->getName();

		$methods = [];
		foreach ($mirror->getMethods(ReflectionMethod::IS_PUBLIC) as $methodMirror) {
			$methodClass = $methodMirror->getDeclaringClass();
			$methodName = $methodMirror->getName();

			if ($methodName == 'getAdminNonExecuteables' ||
				in_array($methodName, $instance->getAdminNonExecuteables()) ||
				$methodClass->getName() != $mirrorClass) {
					continue;
			}

			$methodDocsRaw = $methodMirror->getDocComment();
			$paramDocs = [];
			$methodDoc = "";

			if ($methodDocsRaw) {
				$methodDocLines = [];
				foreach (explode("\n", $methodDocsRaw) as $line) {
					$line = preg_replace('/(\/?\*+\/?\s?)/', '', trim($line));
					if (empty($line)) {
						continue;
					} elseif (preg_match('/^@param ((([a-z]+) \$([a-z0-9_]))|(\$([a-z0-9_]) ([a-z]+)))(.*?)$/', $line, $paramMatches)) {
						if (!empty($paramMatches[5])) {
							$paramDocs[$paramMatches[6]] = [
								'type' => $paramMatches[7],
								'doc' => trim($paramMatches[8]),
							];
						} else {
							$paramDocs[$paramMatches[4]] = [
								'type' => $paramMatches[3],
								'doc' => trim($paramMatches[8]),
							];
						}
					} elseif (preg_match('/^@return/', $line)) {
						$methodDocLines []= "\n$line";
					} else {
						$methodDocLines []= $line;
					}
				}

				$methodDoc = trim(implode("\n", $methodDocLines));
			}

			$method = [
				'name' => $methodName,
				'docs' => $methodDoc,
				'params' => [],
			];

			foreach ($methodMirror->getParameters() as $paramMirror) {
				$paramName = $paramMirror->getName();

				$method['params'] []= [
					'name' => $paramName,
					'default' => $paramMirror->isDefaultValueAvailable() ? $paramMirror->getDefaultValue() : '',
					'docs' => isset($paramDocs[$paramName]) ? $paramDocs[$paramName]['doc'] : '',
					'type' => isset($paramDocs[$paramName]) ? $paramDocs[$paramName]['type'] : '',
				];
			}

			$methods []= $method;
		}

		return $methods;
	}
}