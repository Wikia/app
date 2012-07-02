-- MySQL for the Education Program extension.
-- Licence: GNU GPL v3+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >


-- Links the campus ambassadors with all their courses.
-- The is secondary storage for queries. The canonical data is in ep_course.campus_ambs
CREATE TABLE IF NOT EXISTS /*_*/ep_cas_per_course (
  cpc_ca_id                  INT unsigned        NOT NULL, -- Foreign key on ep_cas.ca_id
  cpc_course_id              INT unsigned        NOT NULL -- Foreign key on ep_course.course_id
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ep_cas_per_course ON /*_*/ep_cas_per_course (cpc_ca_id, cpc_course_id);

-- Links the online ambassadors with all their courses.
-- The is secondary storage for queries. The canonical data is in ep_course.online_ambs
CREATE TABLE IF NOT EXISTS /*_*/ep_oas_per_course (
  opc_oa_id                  INT unsigned        NOT NULL, -- Foreign key on ep_oas.oa_id
  opc_course_id              INT unsigned        NOT NULL -- Foreign key on ep_course.course_id
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/ep_oas_per_course ON /*_*/ep_oas_per_course (opc_oa_id, opc_course_id);