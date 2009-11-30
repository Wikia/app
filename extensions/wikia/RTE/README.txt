Markers definition:

* \x7f-01-XXXX (RTEMarker::PLACEHOLDER) - Placeholders for images, templates, etc. Generated in RTE::getPlaceholderMarker.
* \x7f-02-XXXX (RTEMarker::EXTERNAL_WIKITEXT) - Used for marking external links wikitext in Preprocessor and then handling those links in Parser.
* \x7f-03-XXXX (RTEMarker::INTERNAL_WIKITEXT) - Used for marking internal links wikitext in Preprocessor and then handling those links in Parser.
* \x7f-04-XXXX (RTEMarker::IMAGE_DATA) - Used for marking images in Parser and then handling in makeImage function of RTEParser.
* \x7f-05-XXXX (RTEMarker::INTERNAL_DATA) - Used for marking internal links data in Parser and then handling in RTELinker.
* \x7f-06-XXXX (RTEMarker::EXTERNAL_DATA) - Used for marking external links data in Parser and then handling in RTELinker.

* \x7f-ENTITY-XXX-\x7f - Used for marking HTML entities (used internally in RTEParser and RTEReverseParser during parsing).
* \x7f-FF - Used to encode double quotes (") in JSON-encoded strings.


HTML attributes used by RTE:

* _rte_attribs - stores original list of HTML attributes and their values (to preserve their order and formatting)
* _rte_data - JSON-encoded meta data of given node (template, image, ...)
* _rte_empty_lines_before - number of empty lines of wikitext before given node
* _rte_entity - used in entities' wrapping spans (contains "name" of wrapped entity)
* _rte_placeholder - indicates given node is placeholder (template, magic word, broken image link, ...)
* _rte_spaces_before - number of spaces at the beginning of given node text content (list item, table cell)
* _rte_style - stores original value of style attribute (to preserve their order and formatting)
* _rte_washtml - indicates whether given node was HTML node in wikitext
