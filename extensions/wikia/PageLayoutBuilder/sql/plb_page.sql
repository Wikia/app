CREATE TABLE /*$wgDBprefix*/plb_page (
    `plb_p_layout_id` int(10) NOT NULL,
	`plb_p_page_id` int(10) NOT NULL,
    PRIMARY KEY (`plb_p_layout_id`, `plb_p_page_id`)
) ENGINE=InnoDB;