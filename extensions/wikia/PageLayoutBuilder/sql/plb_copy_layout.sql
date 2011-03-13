CREATE TABLE plb_copy_layout (
    `plb_c_layout_id` int(10) NOT NULL,
    `plb_c_from_city_id` int(10) NOT NULL,
    `plb_c_to_city_id` int(10) NOT NULL,
    PRIMARY KEY (`plb_c_layout_id`, `plb_c_from_city_id`, `plb_c_to_city_id`)
) ENGINE=InnoDB;