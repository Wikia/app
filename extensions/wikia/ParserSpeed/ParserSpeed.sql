
CREATE TABLE parser_speed_article (
  wiki_id INT NOT NULL,
  article_id INT NOT NULL,

  average_time NUMERIC(10,3),
  minimum_time NUMERIC(10,3),
  maximum_time NUMERIC(10,3),

  wikitext_size INT,
  html_size INT,

  updated TIMESTAMP,

  PRIMARY KEY (wiki_id,article_id)
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
