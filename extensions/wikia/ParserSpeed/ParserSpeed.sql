
CREATE TABLE parser_speed_article (
  wiki_id INT NOT NULL,
  article_id INT NOT NULL,

  page_ns INT,

  average_time NUMERIC(10,3),
  minimum_time NUMERIC(10,3),
  maximum_time NUMERIC(10,3),

  wikitext_size INT,
  html_size INT,

  exp_func_count INT,
  node_count INT,
  post_expand_size INT,
  temp_arg_size INT,

  updated TIMESTAMP,

  PRIMARY KEY (wiki_id,article_id),
  KEY namespace (wiki_id,page_ns),
  KEY avg_time (wiki_id,average_time),
  KEY min_time (wiki_id,minimum_time),
  KEY max_time (wiki_id,maximum_time),
  KEY wikitext_size (wiki_id,wikitext_size),
  KEY html_size (wiki_id,html_size),
  KEY exp_func_count (wiki_id,exp_func_count),
  KEY node_count (wiki_id,node_count),
  KEY post_expand_size (wiki_id,post_expand_size),
  KEY temp_arg_size (wiki_id,temp_arg_size)
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


/*
ALTER TABLE parser_speed_article ADD exp_func_count INT;
ALTER TABLE parser_speed_article ADD node_count INT;
ALTER TABLE parser_speed_article ADD post_expand_size INT;
ALTER TABLE parser_speed_article ADD temp_arg_size INT;
ALTER TABLE parser_speed_article ADD KEY exp_func_count (wiki_id,exp_func_count);
ALTER TABLE parser_speed_article ADD KEY node_count (wiki_id,node_count);
ALTER TABLE parser_speed_article ADD KEY post_expand_size (wiki_id,post_expand_size);
ALTER TABLE parser_speed_article ADD KEY temp_arg_size (wiki_id,temp_arg_size);

*/