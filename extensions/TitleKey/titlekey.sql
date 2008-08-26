CREATE TABLE /*$wgDBprefix*/titlekey (
  -- Ref to page_id
  tk_page int unsigned NOT NULL,

  -- Keep a denormalized copy of the namespace for filtering
  tk_namespace int NOT NULL,

  -- Normalized title.
  -- With namespace prefix, case-folded, in space form.
  tk_key varchar(255) binary NOT NULL,
  
  PRIMARY KEY tk_page (tk_page),
  INDEX name_key (tk_namespace, tk_key)

) /*$wgDBTableOptions*/;
