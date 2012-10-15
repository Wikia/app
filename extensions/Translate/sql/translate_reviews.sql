-- Translation reviews; to store reviews of a page revision by a user.
CREATE TABLE /*$wgDBprefix*/translate_reviews (
  trr_user int NOT NULL,

  -- Link to page.page_id
  trr_page int NOT NULL,

  -- Link to revision.rev_id
  trr_revision int NOT NULL
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/trr_user_page_revision ON /*$wgDBprefix*/translate_reviews
(trr_user, trr_page, trr_revision);
