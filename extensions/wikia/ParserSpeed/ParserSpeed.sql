
CREATE TABLE parser_speed_article (
  wiki_id INT NOT NULL,
  article_id INT NOT NULL,

  page_ns INT,

  average_time NUMERIC(10,3),
  minimum_time NUMERIC(10,3),
  maximum_time NUMERIC(10,3),

  wikitext_size INT,
  html_size INT,

  updated TIMESTAMP,

  PRIMARY KEY (wiki_id,article_id),
  KEY namespace (wiki_id,page_ns),
  KEY avg_time (wiki_id,average_time),
  KEY min_time (wiki_id,minimum_time),
  KEY max_time (wiki_id,maximum_time),
  KEY wikitext_size (wiki_id,wikitext_size),
  KEY html_size (wiki_id,html_size)
);

CREATE TABLE parser_speed_article_rollup (
  wiki_id INT NOT NULL,
  article_id INT NOT NULL,

  page_ns INT NOT NULL,
  page_title VARCHAR(255) NOT NULL,

  average_time NUMERIC(10,3),

  wikitext_size INT,
  html_size INT
);

CREATE TABLE parser_speed_wiki_rollup (
  wiki_id INT NOT NULL,

  score NUMERIC(10,3),

  average_time NUMERIC(10,3),

  wikitext_size INT,
  html_size INT,
  PRIMARY KEY (wiki_id)
);
