This extension powers the new Trivia Quizzes module in Mediawiki. It requires the `content-types-consumption` library to be installed and committed to code. Simply run `npm install` from the extension directory, `.gitignore` handles only committing the distribution.

At the moment the extension will be visible in the right rail if the current conditions are true:

- `wgEnableTriviaQuizzesAlpha` is `true`
- The current article page is whitelisted in `wgTriviaQuizzesEnabledPages`

The embedded module will replace the "Recent Wiki Activity" (Oasis extension) if this is the case.

For questions, comments or concerns please reach out to `#cake-team`.
