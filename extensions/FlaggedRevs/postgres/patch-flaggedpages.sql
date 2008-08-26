BEGIN;

CREATE TABLE flaggedpages (
  fp_page_id INTEGER NOT NULL DEFAULT 0 ,
  fp_reviewed INTEGER NOT NULL DEFAULT 0 ,
  fp_stable INTEGER NULL,
  fp_quality INTEGER default NULL,
  PRIMARY KEY (fp_page_id)
);
CREATE INDEX fp_reviewed_page ON flaggedpages (fp_reviewed,fp_page_id),
CREATE INDEX fp_quality_page ON flaggedpages (fp_quality,fp_page_id)

-- Migrate old page_ext hacks over
INSERT INTO /*$wgDBprefix*/flaggedpages (fp_page_id,fp_reviewed,fp_stable,fp_quality)
SELECT page_id,page_ext_reviewed,page_ext_stable,page_ext_quality FROM /*$wgDBprefix*/page
WHERE page_ext_stable IS NOT NULL;

-- Leave the old fields and indexes for now

COMMIT;