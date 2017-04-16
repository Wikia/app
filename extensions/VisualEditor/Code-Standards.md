# Code Standards

## Background

Reason for creating this document is to establish certain code standards for entire
Contributions team. It is meant to help with onboarding new developers to the team
and with code reviews.

## Standards

* Always use strict comparison instead of type converting comparison
 * ```===``` instead of ```==``` and ```!==``` instead of ```!=```
* Do not depend on type converting
 * Correct: ```if ( !!callToAFunctionThatReturnsString() ) { ... }```
 * Incorrect: ```if ( callToAFunctionThatReturnsString() ) { ... }```
