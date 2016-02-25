Template Classification extension
=================================

The extension contains code for manual (user) template classification. Classifying templates lets us understand our content better. The extension provides a modal UI with a list of types a user can choose from to determine template type.
Is also shows a type label on template page which is an entry point to the edit modal.

More about types and classification can be found on [Template types help](http://community.wikia.com/wiki/Help:Template_types)

### Manual vs. machine classification
In parallel to the manual classification that is done by users, a machine classification is done based on some heuristics.
Machine classification is not a part of this extension, although a template's classification can fall back to a machine type.

### Supported types
Machine classification can have any type and the list keeps expanding. UI supports only certain types defined within this extension to avoid causing a [choice paralysis](http://www.wikiwand.com/en/Analysis_paralysis).
List of types supported by the manual classification is defined in [\UserTemplateClassificationService::$templateTypes](services/UserTemplateClassificationService.class.php).

### Storage
Types are stored in [TemplateClassification Service](/includes/wikia/services/TemplateClassificationService.class.php).
It returns both manual and machine classification where manual has higher priority.
