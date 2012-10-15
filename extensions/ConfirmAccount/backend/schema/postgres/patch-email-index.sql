BEGIN;

CREATE UNIQUE INDEX acr_email ON account_requests (acr_email);

COMMIT;
