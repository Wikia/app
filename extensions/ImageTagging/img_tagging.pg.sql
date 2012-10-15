
CREATE SEQUENCE imagetags_id_seq;

CREATE TABLE imagetags (
  unique_id   INTEGER PRIMARY KEY NOT NULL DEFAULT nextval('imagetags_id_seq'),
  img_page_id INTEGER NOT NULL,
  img_name    TEXT NOT NULL,
  article_tag TEXT NOT NULL,
  tag_rect    TEXT NOT NULL,
  user_text   TEXT NOT NULL
);
