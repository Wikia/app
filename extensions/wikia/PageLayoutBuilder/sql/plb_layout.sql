CREATE TABLE /*$wgDBprefix*/plb_layout (
    `plb_l_layout_id` int(10) NOT NULL,
    `plb_l_propert` blob default "",
    `plb_l_isdelete`  int(1) default 0,
    PRIMARY KEY (`plb_l_layout_id`)
) ENGINE=InnoDB;