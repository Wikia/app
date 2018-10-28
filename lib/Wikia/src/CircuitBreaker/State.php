<?php
namespace Wikia\CircuitBreaker;

class State
{
	const OPEN = 'open';
	const CLOSED = 'closed';
	const HALFOPEN = 'halfopen';
}
