-- This index makes the Contributors extension faster
-- when performing the initial SELECT for larger wikis
ALTER TABLE /*wgDBprefix*/revision
ADD INDEX page_usertext ( rev_page , rev_user_text );