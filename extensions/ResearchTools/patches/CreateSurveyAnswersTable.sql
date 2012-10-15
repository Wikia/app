-- Responses
CREATE TABLE /*_*/research_tools_survey_answers (
  -- Keys to the primary key fields in research_tools_survey_responses
  rtsa_response INTEGER UNSIGNED NOT NULL,
  -- Question, foreign key to research_tools_survey_questions
  rtsa_question INTEGER UNSIGNED NOT NULL,
  -- Integer value
  rtsa_value_integer INTEGER SIGNED NULL,
  -- Text value
  rtsa_value_text VARBINARY(255) NOT NULL DEFAULT ''
) /*$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/rtsr_response_question_key ON /*_*/research_tools_survey_answers (
	rtsa_response, rtsa_question
);
