CREATE TABLE /*$wgDBprefix*/plb_field (
    `plb_f_element_id` int(10) NOT NULL,
    `plb_f_layout_id` int(10) NOT NULL,
    `plb_f_prop` blob,
	`plb_f_is_deleted` int(1) default 0,
    PRIMARY KEY (`plb_f_layout_id`, `plb_f_element_id`)
) ENGINE=InnoDB;