<?php

use Wikia\Logger\Loggable;

class MarkWikiAsClosedController extends WikiaController {

    use Loggable;

    const WIKI_ID = 'wikiId';
    const REASON = 'reason';

    public function init() {
        $this->response->setFormat(WikiaResponse::FORMAT_JSON);
    }

    public function markWikiAsClosed() {

        $wikiId = $this->request->getVal(self::WIKI_ID);
        $reason = $this->request->getVal(self::REASON);

        if (empty($wikiId) || empty($reason)) {
            throw new BadRequestException();
        }

        $res = WikiFactory::setPublicStatus(WikiFactory::CLOSE_ACTION, $wikiId, $reason);

        if ($res === WikiFactory::CLOSE_ACTION) {
            WikiFactory::setFlags($wikiId, WikiFactory::FLAG_FREE_WIKI_URL | WikiFactory::FLAG_CREATE_DB_DUMP | WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE);
            WikiFactory::clearCache($wikiId);
        } else {
            $this->error("Unexpected response: " . $res);
        }
    }

    public function allowsExternalRequests() {
        return false;
    }

}
