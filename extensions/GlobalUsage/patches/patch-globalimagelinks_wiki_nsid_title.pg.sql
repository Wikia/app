--
-- Add the globalimagelinks_wiki_nsid_title index
--

CREATE INDEX globalimagelinks_wiki_nsid_title ON globalimagelinks (gil_wiki, gil_page_namespace_id, gil_page_title);

