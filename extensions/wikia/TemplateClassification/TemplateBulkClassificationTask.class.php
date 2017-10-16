<?php

namespace Wikia\TemplateClassification;

use Wikia\Tasks\Tasks\BaseTask;

class TemplateBulkClassificationTask extends BaseTask {

	public function classifyTemplates( $templates, $templateType, $userId, $category ) {
		$wikiId = $this->getWikiId();

		$utcs = new \UserTemplateClassificationService();
		$errors = $utcs->classifyMultipleTemplates( $wikiId, $templates, $templateType, $userId );

		$this->logResults( $wikiId, $templates, $templateType, $userId, $category, $errors );
	}

	private function logResults( $wikiId, $templates, $templateType, $userId, $category, $errors ) {
		if ( !empty( $errors ) ) {
			$this->error( 'bulkClassificationFailed', [
				'wiki_id' => $wikiId,
				'category' => $category,
				'template_type' => $templateType,
				'user_id' => $userId,
				'bulk_type' => 'task',
				'failed' => $errors,
				'failed_ratio' => count( $errors ) . ' / ' . count( $templates )
			] );
		} else {
			$this->info( 'bulkClassificationSuccess', [
				'wiki_id' => $wikiId,
				'category' => $category,
				'template_type' => $templateType,
				'user_id' => $userId,
				'bulk_type' => 'task',
				'templates_classified' => count( $templates )
			] );
		}
	}
}
