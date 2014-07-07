BEGIN;

ALTER TABLE flaggedpages 
	ADD fp_pending_since TIMESTAMPTZ NULL;
	
CREATE INDEX fp_pending_since ON flaggedpages (fp_pending_since);

COMMIT;
