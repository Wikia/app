<?php

use Wikia\Logger\Loggable;

class MarkWikiAsClosedController extends WikiaController {

    use Loggable;

    const WIKI_ID = 'wikiId';
    const REASON = 'reason';

    public function init() {
        $this->assertCanAccessController();
        $this->response->setFormat(WikiaResponse::FORMAT_JSON);
    }

    public function markWikiAsClosed() {
        try {
            $this->markWikiClosed();
        } catch (WikiaBaseException $exception) {
            // This is normally done in WikiaDispatcher::dispatch(),
            // but because it's an internal request, we would return 200 and only log error to ELK stack
            $this->response->setCode( $exception->getCode() );
            $this->response->setVal(
                'exception',
                [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode()
                ]
            );
        }
    }

    private function markWikiClosed() {
        $wikiId = $this->request->getVal(self::WIKI_ID);
        $reason = $this->request->getVal(self::REASON);
        if (empty($wikiId) || empty($reason)) {
            throw new BadRequestException();
        }

        try {
            $res = WikiFactory::setPublicStatus(WikiFactory::CLOSE_ACTION, $wikiId, $reason);
        } catch (Solarium_Client_HttpException $exception) {
            // This is horrible hack due to Solar not working on dev
            $this->info("Solar not working properly");
        }


        if ($res === WikiFactory::CLOSE_ACTION) {
            WikiFactory::setFlags($wikiId, WikiFactory::FLAG_FREE_WIKI_URL | WikiFactory::FLAG_CREATE_DB_DUMP | WikiFactory::FLAG_CREATE_IMAGE_ARCHIVE);
            WikiFactory::clearCache($wikiId);
        } else {
            $this->error("Unexpected response: " . $res);
        }
    }

    /**
     * Make sure to only allow authorized POST methods.
     * @throws WikiaHttpException
     */
    public function assertCanAccessController() {
        if (!$this->request->isInternal()) {
            throw new ForbiddenException('Access to this controller is restricted');
        }
        if (!$this->request->wasPosted()) {
            throw new MethodNotAllowedException('Only POST allowed');
        }
    }
}
