Template Classification extension
=================================

Extension contains code for manual (user) template classification. Classifying templates lets us understand our content better.
 Extension provides modal UI with list of types user can choose to determine template type.
 Is also shows type label on template page, which is an entry point to edit modal.

More about types and classification can be found on [Template types help](http://community.wikia.com/wiki/Help:Template_types)

### Manual vs machine classification
Is parallel to manual classification that is done by user a machine classification is done based on some heuristics.
Machine classification is not part of this extension, although label can fallback to machine type.

### Supported types
Machine classification can have any type and the list keeps expanding. UI supports only certain types defined within this extension.
List of types supported for manual classification is defined in [\UserTemplateClassificationService::$templateTypes](services/UserTemplateClassificationService.class.php).

### Storage
Types are stored in [TemplateClassification Service](/includes/wikia/services/TemplateClassificationService.class.php).
It returns both manual and machine classification, where manual has higher priority.
