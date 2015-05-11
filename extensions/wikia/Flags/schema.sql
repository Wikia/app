-- Table flags_params
CREATE TABLE flags_params (
    flag_id int    NOT NULL ,
    flag_type_id int    NOT NULL ,
    wiki_id int    NOT NULL ,
    page_id int    NOT NULL ,
    param_name varchar(128)    NOT NULL ,
    param_value text    NOT NULL ,
    CONSTRAINT flags_params_pk PRIMARY KEY (flag_id,param_name)
);
CREATE INDEX params_on_wikia_idx ON flags_params (wiki_id,param_name);

-- Table flags_to_pages
CREATE TABLE flags_to_pages (
    flag_id int    NOT NULL  AUTO_INCREMENT,
    flag_type_id int    NOT NULL ,
    wiki_id int    NOT NULL ,
    page_id int    NOT NULL ,
    CONSTRAINT flags_to_pages_pk PRIMARY KEY (flag_id)
);
CREATE INDEX flags_on_page_idx ON flags_to_pages (wiki_id,page_id);
CREATE INDEX flag_types_on_wikia_idx ON flags_to_pages (wiki_id);
CREATE  UNIQUE INDEX uni_flags_on_page_on_wiki_idx ON flags_to_pages (wiki_id,page_id,flag_type_id);


-- Table flags_types
CREATE TABLE flags_types (
    flag_type_id int    NOT NULL  AUTO_INCREMENT,
    wiki_id int    NOT NULL ,
    flag_group int    NOT NULL ,
    flag_name varchar(128)    NOT NULL ,
    flag_view varchar(255)    NOT NULL ,
    flag_targeting int    NOT NULL ,
    flag_params_names text    NULL ,
    CONSTRAINT flags_types_pk PRIMARY KEY (flag_type_id)
);
CREATE INDEX flags_types_on_wiki_idx ON flags_types (wiki_id,flag_type_id);
CREATE  UNIQUE INDEX uni_wiki_id_flag_name_idx ON flags_types (wiki_id,flag_name);

-- foreign keys
-- Reference:  flag_type_id (table: flags_to_pages)
ALTER TABLE flags_to_pages ADD CONSTRAINT flag_type_id FOREIGN KEY flag_type_id (flag_type_id)
    REFERENCES flags_types (flag_type_id)
    ON DELETE CASCADE;

-- Reference:  flags_params_flags_to_pages (table: flags_params)
ALTER TABLE flags_params ADD CONSTRAINT flags_params_flags_to_pages FOREIGN KEY flags_params_flags_to_pages (flag_id)
    REFERENCES flags_to_pages (flag_id)
    ON DELETE CASCADE;

-- End of file.
