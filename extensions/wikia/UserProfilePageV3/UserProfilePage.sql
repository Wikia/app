CREATE TABLE upp_interview_question (
	uiqu_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	uiqu_wiki_id INT(11) NOT NULL,
	uiqu_body VARCHAR(255),
	uiqu_order TINYINT DEFAULT 1,
	uiqu_answers_count INT(11) DEFAULT 0,
	KEY wiki_id (uiqu_wiki_id)
) Engine=InnoDB;
