-- Table flags_types
CREATE TABLE flags_types (
    flag_type_id int unsigned   NOT NULL  AUTO_INCREMENT,
    wiki_id int unsigned   NOT NULL ,
    flag_group smallint unsigned   NOT NULL ,
    flag_name varchar(128)    NOT NULL ,
    flag_view varchar(255)    NOT NULL ,
    flag_targeting tinyint unsigned   NOT NULL ,
    flag_params_names text    NULL ,
    CONSTRAINT flags_types_pk PRIMARY KEY (flag_type_id)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
CREATE INDEX flags_types_wiki_id_idx ON flags_types (wiki_id);

-- Table flags_to_pages
CREATE TABLE flags_to_pages (
    flag_id int unsigned    NOT NULL  AUTO_INCREMENT,
    wiki_id int unsigned   NOT NULL ,
    page_id int unsigned   NOT NULL ,
    flag_type_id int unsigned   NOT NULL ,
    CONSTRAINT flags_to_pages_pk PRIMARY KEY (flag_id)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
CREATE INDEX flags_on_pages_wiki_id_idx ON flags_to_pages (wiki_id);
CREATE INDEX flags_on_pages_page_id_idx ON flags_to_pages (page_id);
CREATE INDEX flags_on_pages_flag_type_id_idx ON flags_to_pages (flag_type_id);

-- Table flags_params
CREATE TABLE flags_params (
    param_id int unsigned   NOT NULL  AUTO_INCREMENT,
    flag_id int unsigned  NOT NULL ,
    flag_type_id int unsigned  NOT NULL ,
    param_name varchar(128)    NOT NULL ,
    param_value text    NULL ,
    CONSTRAINT flags_params_pk PRIMARY KEY (param_id)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;
CREATE INDEX flags_on_pages_flag_id_idx ON flags_params (flag_id);
CREATE INDEX flags_on_pages_flag_type_id_idx ON flags_params (flag_type_id);
CREATE INDEX flags_on_pages_param_name_idx ON flags_params (param_name);

-- foreign keys
-- Reference:  flag_type_id (table: flags_to_pages)
ALTER TABLE flags_to_pages ADD CONSTRAINT flag_type_id FOREIGN KEY flag_type_id (flag_type_id)
    REFERENCES flags_types (flag_type_id)
    ON DELETE CASCADE;

-- Reference:  flags_params_flag_id (table: flags_params)
ALTER TABLE flags_params ADD CONSTRAINT flags_params_flag_id FOREIGN KEY flags_params_flag_id (flag_id)
    REFERENCES flags_to_pages (flag_id)
    ON DELETE CASCADE;

-- End of file.
