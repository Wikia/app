--
--This scripts adds pages and revisions for all existing defined meanings
--in the DefinedMeaning namespace. Script is pretty slow with the check if
--pages already exist, by the "not in" operator in the "WHERE" clause. If
--one is sure that there are not any pages for the defined meanings, then
--remove this check from the first INSERT query. The second INSERT query
--and the UPDATE query use the timeStamp, namespaceId combination to assure
--uniqueness.
--

SET @timeStamp = (
	SELECT DATE_FORMAT( CONVERT_TZ( Now( ) , 'system', 'GMT' ) , '%Y%m%d%H%i%s' )
);

SET @namespaceId = (
	SELECT namespace_names.ns_id
	FROM namespace_names
	WHERE namespace_names.ns_name='DefinedMeaning'
	LIMIT 1
);

INSERT INTO page (page_namespace, page_title, page_is_new, page_title_language_id, page_touched)
(
	SELECT @namespaceId as page_namespace,
	concat(REPLACE(uw_expression_ns.spelling," ","_"), "_(", uw_defined_meaning.defined_meaning_id, ")") as page_title,
	1 as page_is_new,
	uw_expression_ns.language_id as page_title_language_id,
	@timeStamp as page_touched

	FROM uw_defined_meaning, uw_expression_ns

	WHERE uw_defined_meaning.expression_id = uw_expression_ns.expression_id 
	AND concat(REPLACE(uw_expression_ns.spelling," ","_"), "_(", uw_defined_meaning.defined_meaning_id, ")") not in 
	(
		SELECT page.page_title
		FROM page
		WHERE page.page_namespace = @namespaceId
	)
	AND uw_expression_ns.remove_transaction_id is NULL
	AND uw_defined_meaning.remove_transaction_id is NULL
);

INSERT INTO revision(rev_page, rev_comment, rev_user, rev_user_text, rev_timestamp)
(
	SELECT page.page_id as rev_page,
	"Automated addition of defined meaning pages" as rev_comment,
	0 as rev_user,	"" as rev_user_text,
	@timeStamp as rev_timestamp

	FROM page
	WHERE page.page_namespace = @namespaceId
	AND page.page_touched = @timeStamp
);

UPDATE page, revision 
SET page.page_latest=revision.rev_id
WHERE revision.rev_page=page.page_id
AND page.page_namespace = @namespaceId
AND page.page_touched = @timeStamp;

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '12 - Add defined meaning pages.sql'); 