# Wikia to Fandom Rebranding

## Links

* [JIRA case: SUS-853](https://wikia-inc.atlassian.net/browse/SUS-853)
* [Crowdin i18n project](https://crowdin.com/project/wikia-to-fandom)

## Notes

`GlobalMessages0.i18n.php` contains overrides for relevant interface messages
and is a subject for Crowdin translators. Before the release, it must be merged
to the `dev` branch so that it is included for message cache warm-up. After the
release all the messages from `GlobalMessages0.i18n.php` have to be moved to
their original files, respectively and `GlobalMessages0.i18n.php` file has to
be removed. The `tests` directory contains a simple test and has to be removed
once the rebranding process is complete.

## Contact

* [Mix](mailto:mix@wikia.com)

