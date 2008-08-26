<?php

require_once('XMLImport.php');
require_once('ProgressBar.php');
require_once('../OmegaWiki/WikiDataAPI.php');

function largeFilePositionInMegabytes($position) {
	return round(sprintf("%u", $position) / (1024 * 1024)); 
}

function startsWith($string, $substring) {
	return substr($string, 0, strlen($substring)) == $substring;
}

/*
 * Import Swiss-Prot from the XML file. Be sure to have started a transaction first!
 */
function importSwissProt($xmlFileName, $umlsCollectionId = 0, $goCollectionId = 0, $hugoCollectionId = 0, $EC2GoMapping = array(), $keyword2GoMapping = array()) {
	// Create mappings from EC numbers and SwissProt keywords to GO term meaning id's:	
	$EC2GoMeaningId = array();
	$keyword2GoMeaningId = array();
	
	$hugoCollection = null;
	
//		foreach ($EC2GoMapping as $EC => $GO) {
//			if (array_key_exists($GO, $goCollection)) {
//				$goMeaningId = $goCollection[$GO];
//				$EC2GoMeaningId[$EC] = $goMeaningId;
//			}
//		}
//	
//		foreach ($keyword2GoMapping as $keyword => $GO) {
//			if (array_key_exists($GO, $goCollection)) {
//				$goMeaningId = $goCollection[$GO];
//				$keyword2GoMeaningId[$keyword] = $goMeaningId;
//			}
//		}
	
	if ($hugoCollectionId != 0) 
		$hugoCollection = getCollectionContents($hugoCollectionId);

	// SwissProt import:
	$numberOfMegaBytes = largeFilePositionInMegabytes(filesize($xmlFileName));
	$progressBar = new ProgressBar($numberOfMegaBytes, 1, " Mb");
	
	$fileHandle = fopen($xmlFileName, "r");
	importEntriesFromXMLFile($fileHandle, $umlsCollectionId, $goCollectionId, $hugoCollection, $EC2GoMeaningId, $keyword2GoMeaningId, $progressBar);

	fclose($fileHandle);
}

function importEntriesFromXMLFile($fileHandle, $umlsCollectionId, $goCollectionId, $hugoCollection, $EC2GoMeaningIdMapping, $keyword2GoMeaningIdMapping, ProgressBar $progressBar) {
	$languageId = 85;
	bootstrapCollection("concept mapping", $languageId, "MAPP");

	$collectionId = bootstrapCollection("Swiss-Prot", $languageId, "");
	$classCollectionId = bootstrapCollection("Swiss-Prot classes", $languageId, "CLAS");
	$relationTypeCollectionId = bootstrapCollection("Swiss-Prot relation types", $languageId, "RELT");
	$textAttibuteCollectionId = bootstrapCollection("Swiss-Prot text attributes", $languageId, "TATT");
	$ECCollectionId = bootstrapCollection("Enzyme Commission numbers", $languageId, "");
	
	$goCollection = new CachedCollection($goCollectionId, "GO", $languageId);
	
	$xmlParser = new SwissProtXMLParser();
	$xmlParser->languageId = $languageId;
	$xmlParser->collectionId = $collectionId;
	$xmlParser->classCollectionId = $classCollectionId;
	$xmlParser->relationTypeCollectionId = $relationTypeCollectionId;
	$xmlParser->textAttibuteCollectionId = $textAttibuteCollectionId;
	$xmlParser->ECCollectionId = $ECCollectionId;
	$xmlParser->EC2GoMeaningIdMapping = $EC2GoMeaningIdMapping;
	$xmlParser->keyword2GoMeaningIdMapping = $keyword2GoMeaningIdMapping;
	$xmlParser->goCollection = $goCollection;
	$xmlParser->hugoCollection = $hugoCollection;
	
	// Find some UMLS concepts for cross references from SwissProt:
	if ($umlsCollectionId != 0) {
		// modified from C0033684(protein) to C1254349 
		// UMLS Semantic Type : Amino Acid, Peptide, or Protein 
		$xmlParser->proteinConceptId = getCollectionMemberId($umlsCollectionId, "C1254349");
		// UMLS Semantic Type : Gene or Genome
		$xmlParser->geneConceptId = getCollectionMemberId($umlsCollectionId, "C0017337");
		// UMLS Semantic Type: Organism
		$xmlParser->organismConceptId = getCollectionMemberId($umlsCollectionId, "C0029235");
	}

	$xmlParser->molecularFunctionConceptId = $goCollection->getOrCreateMember("GO:0003674", "molecular function");
	$xmlParser->biologicalProcessConceptId = $goCollection->getOrCreateMember("GO:0008150", "biological process");
	$xmlParser->cellularComponentConceptId = $goCollection->getOrCreateMember("GO:0005575", "cellular component");
	
	$xmlParser->setProgressBar($progressBar);
	$xmlParser->initialize();
	
	parseXML($fileHandle, $xmlParser);
}

class CachedCollection {
	protected $collectionId;
	protected $contents;
	protected $languageId;
	
	public function __construct($collectionId, $collectionName, $languageId, $collectionType = "") {
		$this->collectionId = $collectionId;
		$this->languageId = $languageId;
		
		if ($this->collectionId == 0)
			$this->collectionId = bootstrapCollection($collectionName, $languageId, $collectionType);
			
		$this->contents = getCollectionContents($this->collectionId);
	}
	
	public function getOrCreateMember($internalMemberId, $spelling = "") {
		if (isset($this->collectionContents[$internalMemberId]))
			return $this->collectionContents[$internalMemberId];
		else {
			if ($spelling == "")
				$spelling = $internalMemberId;
			
			$expression = findOrCreateExpression($spelling, $this->languageId); 
			$definedMeaningId = createNewDefinedMeaning($expression->id, $this->languageId, $spelling);
			addDefinedMeaningToCollection($definedMeaningId, $this->collectionId, $internalMemberId);
			$this->collectionContents[$internalMemberId] = $definedMeaningId;
			
			return $definedMeaningId;
		}
	}
}

class SwissProtXMLParser extends BaseXMLParser {
	public $languageId;
	public $collectionId;
	public $classCollectionId;
	public $relationTypeCollectionId;
	public $textAttibuteCollectionId;
	public $ECCollectionId;
	public $EC2GoMeaningIdMapping;
	public $keyword2GoMeaningIdMapping;
	public $goCollection;
	public $hugoCollection;
	public $numberOfEntries = 0;
	
	public $proteins = array();
	public $species = array();
	public $genes = array();
	public $organismSpecificGenes = array();
	public $attributes = array();
	public $ECNumbers = array();
	
	public $functionalDomains = array();
	public $similarityDomains = array();
	public $similarityFamilies = array();
		
	public $proteinConceptId = 0;
	public $organismSpecificProteinConceptId = 0;
	public $organismSpecificGeneConceptId = 0;
	public $geneConceptId = 0;
	public $organismConceptId = 0;
	public $occursInConceptId = 0;
	public $isManifestationOfConceptId = 0;
	public $functionalDomainConceptId = 0;
	public $biologicalProcessConceptId = 0;
	public $molecularFunctionConceptId = 0;
	public $cellularComponentConceptId = 0;
//	public $keywordConceptId = 0;
	public $containsConceptId = 0;
	public $enzymeCommissionNumberConceptId = 0;
	public $activityConceptId = 0;
	
	// comment relation Ids
	public $hasURLid = 0;
	// comment top classes
	public $semanticGroupId = 0;
	// comment aspects type	
	public $functionalAspectId = 0;
	public $localizationAspectId = 0;
	public $structuralAspectId = 0;
	public $pharmaceuticalAspectId = 0;
	public $externalInformationId = 0;
	public $otherAspectId = 0;
	public $functionallyRelatedId = 0;
	public $spatiallyRelatedId = 0;
	public $physicallyRelatedId = 0;
	public $temporallyRelatedId = 0;
	public $terminologicallyRelatedId = 0;
	public $conceptuallyRelatedId  = 0;
	// comment types
	public $subcellularLocationId = 0;
	public $tissueSpecificityId = 0;
	public $catalyticActivityId = 0;
	public $cofactorId = 0;
	public $functionId = 0;
	public $diseaseId = 0;
	public $enzymeRegulationId = 0;
	public $inductionId = 0;
	public $interactionId = 0;
	public $pathwayId = 0;
	public $rnaEditingId = 0;
	public $developmentalStageId = 0;
	public $alternativeProductId = 0;
	public $domainId = 0;
	public $ptmId = 0;
	public $polymorphismId = 0;
	public $similarityId = 0;
	public $massSpectrometryId = 0;
	public $subunitId = 0;
	public $allergenId = 0;
	public $pharmaceuticalId = 0;
	public $biotechnologyId = 0;
	public $toxicDoseId = 0;
	public $biophysicochemicalPropertiesId = 0;
	public $webResourceId = 0;
	public $onlineInformationId = 0;
	public $miscellaneousId = 0;
	public $cautionId = 0;
	public $conceptualPartOfId = 0;
	public $consistsOfId = 0;
	
	protected $progressBar;
	
	protected function bootstrapDefinedMeaning($spelling, $definition = null) {
		if (!isset($definition)) 
			$definition = $spelling;
		
		$expression = $this->getOrCreateExpression($spelling);
		$definedMeaningId = createNewDefinedMeaning($expression->id, $this->languageId, $definition);

		return $definedMeaningId;
	}
	
	protected function bootstrapConcept($conceptId, $spelling, $classId = 0, $definition = "") {
		if ($conceptId == 0)
			$conceptId = $this->bootstrapDefinedMeaning($spelling);
			
		if ($classId != 0)	
			addClassMembership($conceptId, $classId);
			
		if ($definition != "")
			addDefinedMeaningDefiningDefinition($conceptId, 85, $definition);
			
		return $conceptId;
	}
	
	protected function bootstrapConceptIds() {
		$this->proteinConceptId = $this->bootstrapConcept($this->proteinConceptId, "amino acid, peptide or protein");
		$this->organismSpecificProteinConceptId = $this->bootstrapConcept($this->organismSpecificProteinConceptId, "organism specific protein");
		$this->organismSpecificGeneConceptId = $this->bootstrapConcept($this->organismSpecificGeneConceptId, "organism specific gene");
		$this->geneConceptId = $this->bootstrapConcept($this->geneConceptId, "gene or genome");
		$this->organismConceptId = $this->bootstrapConcept($this->organismConceptId, "organism");
		$this->occursInConceptId = $this->bootstrapConcept($this->occursInConceptId, "occurs in", 0, "Takes place in or happens under given conditions, circumstances, or time periods, or in a given location or population. This includes appears in, transpires, comes about, is present in, and exists in.");
		$this->isManifestationOfConceptId = $this->bootstrapConcept($this->isManifestationOfConceptId, "is manifestation of", 0, "That part of a phenomenon which is directly observable or concretely or visibly expressed, or which gives evidence to the underlying process. This includes expression of, display of, and exhibition of.");
		$this->functionalDomainConceptId = $this->bootstrapConcept($this->functionalDomainConceptId, "functional domain");
		$this->biologicalProcessConceptId = $this->bootstrapConcept($this->biologicalProcessConceptId, "biological process");		
		$this->molecularFunctionConceptId = $this->bootstrapConcept($this->molecularFunctionConceptId, "molecular function");		
		$this->cellularComponentConceptId = $this->bootstrapConcept($this->cellularComponentConceptId, "cellular component");		
//		$this->keywordConceptId = $this->bootstrapConcept($this->keywordConceptId, "keyword");
		$this->enzymeCommissionNumberConceptId = $this->bootstrapConcept($this->enzymeCommissionNumberConceptId, "enzyme commission number");

		// create top class for semantic comment types and link it to the root class
		$this->semanticGroupId = $this->bootstrapConcept($this->semanticGroupId, "Semantic Group");
		
		// define a different comment type aspects and link them with the comment top class
		$this->localizationAspectId = $this->bootstrapConcept($this->localizationAspectId, "Localization aspects", $this->semanticGroupId);
		$this->functionalAspectId = $this->bootstrapConcept($this->functionalAspectId, "Functional aspects", $this->semanticGroupId);
		$this->structuralAspectId = $this->bootstrapConcept($this->structuralAspectId, "Structural aspects", $this->semanticGroupId);
		$this->pharmaceuticalAspectId = $this->bootstrapConcept($this->pharmaceuticalAspectId, "Pharmaceutical aspects", $this->semanticGroupId);
		$this->externalInformationId = $this->bootstrapConcept($this->externalInformationId, "External information", $this->semanticGroupId);
		$this->otherAspectId = $this->bootstrapConcept($this->otherAspectId, "Other aspects", $this->semanticGroupId);
		$this->functionallyRelatedId = $this->bootstrapConcept($this->functionallyRelatedId, "Functionally related", $this->semanticGroupId);
		$this->spatiallyRelatedId = $this->bootstrapConcept($this->spatiallyRelatedId, "Spatially related", $this->semanticGroupId);
		$this->physicallyRelatedId = $this->bootstrapConcept($this->physicallyRelatedId, "Physically related", $this->semanticGroupId);
		$this->temporallyRelatedId = $this->bootstrapConcept($this->temporallyRelatedId, "Temporally related", $this->semanticGroupId);
		$this->terminologicallyRelatedId = $this->bootstrapConcept($this->terminologicallyRelatedId, "Terminologically related", $this->semanticGroupId);
		$this->conceptuallyRelatedId = $this->bootstrapConcept($this->conceptuallyRelatedId, "Conceptually related", $this->semanticGroupId);
		
		// some relations and their super class
		$this->activityConceptId = $this->bootstrapConcept($this->activityConceptId, "performs", $this->functionallyRelatedId);
		$this->containsConceptId = $this->bootstrapConcept($this->containsConceptId, "contains", $this->functionallyRelatedId);
		$this->consistsOfId = $this->bootstrapConcept($this->consistsOfId, "consists of", $this->physicallyRelatedId);
		$this->conceptualPartOfId = $this->bootstrapConcept($this->conceptualPartOfId, "conceptual part of", $this->conceptuallyRelatedId);	
		
		// assign each comment type to one type aspect (later perhaps to multiple aspects)
		$this->subcellularLocationId = $this->bootstrapConcept($this->subcellularLocationId, "subcellular location", $this->localizationAspectId);
		$this->tissueSpecificityId = $this->bootstrapConcept($this->tissueSpecificityId, "tissue specificity", $this->localizationAspectId);
		$this->catalyticActivityId = $this->bootstrapConcept($this->catalyticActivityId, "catalytic activity", $this->functionalAspectId);
		$this->cofactorId = $this->bootstrapConcept($this->cofactorId, "cofactor", $this->functionalAspectId);
		$this->functionId = $this->bootstrapConcept($this->functionId, "function", $this->functionalAspectId);
		$this->diseaseId = $this->bootstrapConcept($this->diseaseId, "disease", $this->functionalAspectId);
		$this->enzymeRegulationId = $this->bootstrapConcept($this->enzymeRegulationId, "enzyme regulation", $this->functionalAspectId);
		$this->inductionId = $this->bootstrapConcept($this->inductionId, "induction", $this->functionalAspectId);
		$this->interactionId = $this->bootstrapConcept($this->interactionId, "interaction", $this->functionalAspectId);
		$this->pathwayId = $this->bootstrapConcept($this->pathwayId, "pathway", $this->functionalAspectId);
		$this->rnaEditingId = $this->bootstrapConcept($this->rnaEditingId, "RNA editing", $this->functionalAspectId);
		
		$this->alternativeProductId = $this->bootstrapConcept($this->alternativeProductId, "alternative product", $this->structuralAspectId);
		$this->domainId = $this->bootstrapConcept($this->domainId, "domain", $this->structuralAspectId);
		$this->ptmId = $this->bootstrapConcept($this->ptmId, "PTM", $this->structuralAspectId);
		$this->polymorphismId = $this->bootstrapConcept($this->polymorphismId, "polymorphism", $this->structuralAspectId);
		$this->similarityId = $this->bootstrapConcept($this->similarityId, "similarity", $this->structuralAspectId);
		$this->massSpectrometryId = $this->bootstrapConcept($this->massSpectrometryId, "mass spectometry", $this->structuralAspectId);
		$this->subunitId = $this->bootstrapConcept($this->subunitId, "subunit", $this->structuralAspectId);
		
		$this->allergenId = $this->bootstrapConcept($this->allergenId, "allergen", $this->pharmaceuticalAspectId);
		$this->pharmaceuticalId = $this->bootstrapConcept($this->pharmaceuticalId, "pharmaceutical", $this->pharmaceuticalAspectId);
		$this->biotechnologyId = $this->bootstrapConcept($this->biotechnologyId, "biotechnology", $this->pharmaceuticalAspectId);
		$this->toxicDoseId = $this->bootstrapConcept($this->toxicDoseId, "toxic dose", $this->pharmaceuticalAspectId);
		$this->biophysicochemicalPropertiesId = $this->bootstrapConcept($this->biophysicochemicalPropertiesId, "biophysicochemical properties", $this->pharmaceuticalAspectId);

		$this->onlineInformationId = $this->bootstrapConcept($this->onlineInformationId, "online information", $this->externalInformationId);
		$this->developmentalStageId = $this->bootstrapConcept($this->developmentalStageId, "developmental stage", $this->otherAspectId);
		$this->miscellaneousId = $this->bootstrapConcept($this->miscellaneousId, "miscellaneous", $this->otherAspectId);
		$this->cautionId = $this->bootstrapConcept($this->cautionId, "caution", $this->otherAspectId);
	}
	
	public function setProgressBar(ProgressBar $progressBar) {
		$this->progressBar = $progressBar;
	}
	
	public function initialize() {
		$this->bootstrapConceptIds();
		
		// Add concepts to classes
		addDefinedMeaningToCollectionIfNotPresent($this->proteinConceptId, $this->classCollectionId, "amino acid, peptide, or protein");
		addDefinedMeaningToCollectionIfNotPresent($this->geneConceptId, $this->classCollectionId, "gene or genome");
		addDefinedMeaningToCollectionIfNotPresent($this->organismConceptId, $this->classCollectionId, "organism");
		addDefinedMeaningToCollectionIfNotPresent($this->functionalDomainConceptId, $this->classCollectionId, "functional domain");
		addDefinedMeaningToCollectionIfNotPresent($this->organismSpecificProteinConceptId, $this->classCollectionId, "organism specific protein");
		addDefinedMeaningToCollectionIfNotPresent($this->organismSpecificGeneConceptId, $this->classCollectionId, "organism specific gene");		
		addDefinedMeaningToCollectionIfNotPresent($this->enzymeCommissionNumberConceptId, $this->classCollectionId, "enzyme commission number");
		
		// Add concepts to relation types
		addDefinedMeaningToCollectionIfNotPresent($this->geneConceptId, $this->relationTypeCollectionId, "gene or genome");
		addDefinedMeaningToCollectionIfNotPresent($this->isManifestationOfConceptId, $this->relationTypeCollectionId, "is manifestation of");
		addDefinedMeaningToCollectionIfNotPresent($this->occursInConceptId, $this->relationTypeCollectionId, "occurs in");		
		addDefinedMeaningToCollectionIfNotPresent($this->activityConceptId, $this->relationTypeCollectionId, "performs");
		addDefinedMeaningToCollectionIfNotPresent($this->biologicalProcessConceptId, $this->relationTypeCollectionId, "biological process");
		addDefinedMeaningToCollectionIfNotPresent($this->molecularFunctionConceptId, $this->relationTypeCollectionId, "molecular function");
		addDefinedMeaningToCollectionIfNotPresent($this->cellularComponentConceptId, $this->relationTypeCollectionId, "cellular component");		
//		addDefinedMeaningToCollectionIfNotPresent($this->keywordConceptId, $this->relationTypeCollectionId, "keyword");
		addDefinedMeaningToCollectionIfNotPresent($this->consistsOfId, $this->relationTypeCollectionId, "consists of");
		addDefinedMeaningToCollectionIfNotPresent($this->containsConceptId, $this->relationTypeCollectionId, "contains");
		addDefinedMeaningToCollectionIfNotPresent($this->conceptualPartOfId, $this->relationTypeCollectionId, "conceptual part of");
	}
	
	public function startElement($parser, $name, $attributes) {
		global
			$numberOfBytes;

		if (count($this->stack) == 0){
			$handler = new UniProtXMLElementHandler();
			$handler->name = $name;
			$handler->importer = $this;
			$handler->setAttributes($attributes);
			$this->stack[] = $handler;						
		}
		else {
			if (count($this->stack) == 1) {
				if ($this->progressBar != null) {
					$currentByteIndex = largeFilePositionInMegabytes(xml_get_current_byte_index($parser));
					$this->progressBar->setPosition($currentByteIndex);
				}
			}
			
			parent::startElement($parser, $name, $attributes);
		}
	}
	
	public function import(SwissProtEntry $entry){
		$proteinMeaningId = $this->addProtein($entry->protein);

		$organismSpeciesMeaningId = $this->addOrganism($entry->organism, $entry->organismTranslations);

		if ($entry->gene != "") {
			$geneMeaningId = $this->addGene($entry->gene);
			$organismSpecificGene = $this->addOrganismSpecificGene($organismSpeciesMeaningId, $geneMeaningId, $entry->organism, $entry->gene, $entry->geneSynonyms, $entry->HGNCReference);			
		}
		else 
			$organismSpecificGene = -1;
		
		$entryMeaningId = $this->addEntry($entry, $proteinMeaningId, $organismSpecificGene, $organismSpeciesMeaningId);

		$this->numberOfEntries += 1;
	}
	
	public function addProtein(Protein $protein) {
		if (array_key_exists($protein->name, $this->proteins)) 
			$definedMeaningId = $this->proteins[$protein->name];
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($protein->name, $protein->name, $protein->name, $this->collectionId);
			$this->proteins[$protein->name] = $definedMeaningId;
		}
		
		addClassMembership($definedMeaningId, $this->proteinConceptId);			
		
		return $definedMeaningId;
	}
	
	public function addFunctionalDomain(Protein $domain) {
		if (array_key_exists($domain->name, $this->functionalDomains)) {
			$definedMeaningId = $this->functionalDomains[$domain->name];
		}
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($domain->name, "Functional domain " . $domain->name, $domain->name, $this->collectionId);
			$this->functionalDomains[$domain->name] = $definedMeaningId;
		}
		
		addClassMembership($definedMeaningId, $this->functionalDomainConceptId);

		return $definedMeaningId;
	}
	
	public function addContainedProtein(Protein $component, $organismName, $organismSpeciesMeaningId) {
		$proteinMeaningId = $this->addProtein($component);
		$definedMeaningId = $this->addOrganismSpecificProtein(
			$component->name, 
			$organismName, 
			$proteinMeaningId, 
			-1, 
			$organismSpeciesMeaningId
		);

		return $definedMeaningId;
	}
	
	public function addGene($name) {
		if (array_key_exists($name, $this->genes)) {
			$definedMeaningId = $this->genes[$name];
		}
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($name, $name, $name, $this->collectionId);
			$this->genes[$name] = $definedMeaningId;
		}
		
		addClassMembership($definedMeaningId, $this->geneConceptId);
		
		return $definedMeaningId;		
	}
	
	public function addOrganism($name, $translations) {
		if (array_key_exists($name, $this->species)) 
			$definedMeaningId = $this->species[$name];
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($name, $name, $name, $this->collectionId);
			$this->species[$name] = $definedMeaningId;
		}
		
		addClassMembership($definedMeaningId, $this->organismConceptId);
		
		foreach ($translations as $key => $translation) 
			addSynonymOrTranslation($translation, $this->languageId, $definedMeaningId, true);
		
		return $definedMeaningId;		
	}
	
	public function addSimilarityFamily($family) {
		if (array_key_exists($family, $this->similarityFamilies)) 
			$definedMeaningId = $this->similarityFamilies[$family];
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($family, $family, $family, $this->collectionId);
			$this->similarityFamilies[$family] = $definedMeaningId;
		}
		
		return $definedMeaningId;		
	}
	
	public function addSimilarityDomain($domain) {
		if (array_key_exists($domain, $this->similarityDomains)) 
			$definedMeaningId = $this->similarityDomains[$domain];
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($domain, $domain, $domain, $this->collectionId);
			$this->similarityDomains[$domain] = $definedMeaningId;
		}
		
		return $definedMeaningId;		
	}
	
	public function addOrganismSpecificGene($organismSpeciesMeaningId, $geneMeaningId, $organismName, $geneName, $synonyms, $hgncReference) {
		$key = $geneMeaningId . "-" . $organismSpeciesMeaningId;
		//The name of the entry should be the protein name parenthesis species;
		//Example: Protein X (Homo sapiens)
		$description = $geneName . " (" . $organismName . ")";
		
		if (array_key_exists($key, $this->organismSpecificGenes)) 
			$definedMeaningId = $this->organismSpecificGenes[$key];
		else {
			if (!($this->hugoCollection && ($hgncReference != 0) && ($definedMeaningId = $this->hugoCollection[$hgncReference])))
				$definedMeaningId = $this->addExpressionAsDefinedMeaning($description, $description, $geneName, $this->collectionId);

			addSynonymOrTranslation($geneName, $this->languageId, $definedMeaningId, true);
			$this->organismSpecificGenes[$key] = $definedMeaningId;			
		}			
		
		addClassMembership($definedMeaningId, $this->organismSpecificGeneConceptId);
		addClassMembership($definedMeaningId, $geneMeaningId);
		
		// Add relation between specific gene and organism 
		addRelation($definedMeaningId, $this->occursInConceptId, $organismSpeciesMeaningId);
		
		foreach ($synonyms as $key => $synonym) 
			addSynonymOrTranslation($synonym, $this->languageId, $definedMeaningId, true);
		
		return $definedMeaningId;	
	}
	
	protected function addOrganismSpecificProtein($proteinName, $organism, $proteinMeaningId, $organismSpecificGene, $organismSpeciesMeaningId) {
		// The name of the entry should be the protein name parenthesis species
		// Example: Protein X (Homo sapiens)
		$entryDefinition = $proteinName . ' (' . $organism . ')';
		
		// add the expression as defined meaning:
		$expression = $this->getOrCreateExpression($entryDefinition);
		$definedMeaningId = createNewDefinedMeaning($expression->id, $this->languageId, $entryDefinition);
		
		// Add entry synonyms: protein name, Swiss-Prot entry name and species specific protein synonyms		
		addSynonymOrTranslation($proteinName, $this->languageId, $definedMeaningId, false);
		
		// set the class of the entry:
		addClassMembership($definedMeaningId, $this->organismSpecificProteinConceptId);
		addClassMembership($definedMeaningId, $proteinMeaningId);

		// set the gene of the swiss prot entry and relate the gene to the entry:
		if ($organismSpecificGene > 0) 
			addRelation($definedMeaningId, $this->isManifestationOfConceptId, $organismSpecificGene);
		
		// set the species of the swiss prot entry and relate the species to the entry:		
		addRelation($definedMeaningId, $this->occursInConceptId, $organismSpeciesMeaningId);
		
		return $definedMeaningId;
	}
	
	protected function addIsoform(SwissProtEntry $entry, $entryDefinedMeaningId, $proteinMeaningId, $organismSpeciesMeaningId, Isoform $isoform) {
		$expression = "Isoform " . $isoform->names[0] . " of " . $entry->expression();
		$definition = $expression;
		
		foreach ($isoform->notes as $note) 
			$definition .= ". " . $note;
			
		$expressionObject = $this->getOrCreateExpression($expression);
		$isoformId = createNewDefinedMeaning($expressionObject->id, $this->languageId, $definition);
		
		for ($i = 1; $i < count($isoform->names); $i++)
			addSynonymOrTranslation("Isoform " . $isoform->names[$i] . " of " . $entry->protein->name, $this->languageId, $isoformId, true);
		
		addClassMembership($isoformId, $this->organismSpecificProteinConceptId);
		addClassMembership($isoformId, $proteinMeaningId);

		addRelation($isoformId, $this->occursInConceptId, $organismSpeciesMeaningId);
		addRelation($isoformId, $this->conceptualPartOfId, $entryDefinedMeaningId);
		addDefinedMeaningToCollection($isoformId, $this->collectionId, $isoform->id);
		
		return $isoformId;
	}
	
	protected function addComments(SwissProtEntry $entry, $definedMeaningId, $proteinMeaningId, $organismSpeciesMeaningId) {
		foreach ($entry->comments as $key => $comment) {
			$commentType = strtoupper($comment->type);
			$comment->text = trim($comment->text);
			
			// f.) Information in the attribute 'caution' is imported but it many times doesn’t
			// make sense due to the fact it refers to References (in the SP entry) that are
			// not shown in wikiproteins, therefore it should NOT be imported presently.
			if ($commentType == "CAUTION")
				continue; // ignore
			
			// create definedMeaning for SP comment type			
			$attributeMeaningId = $this->getOrCreateAttributeMeaningId($comment->type);
			
			// initialize text value
			$textValue = "";
			$normalProcessing = true;
			
			// link comments with the appropriate definedMeaning(defined by Chrisi and Erik)
			// we have to create relation between comment and its aspect
			// all comments have the relation 'has aspect' 
			switch ($commentType) {
				
			// j.) the comments with the topic, SUBCELLULAR LOCATION and TISSUE SPECIFICITY
			// need to be tagged with the attribute 'Localization Aspects'			
			case "SUBCELLULAR LOCATION":
			case "TISSUE SPECIFICITY":				
				break;
			// k.) the comments with the topic, CATALYTIC ACTIVITY, COFACTOR, FUNCTION, DISEASE,   
			// ENZYME REGULATION, INDUCTION, INTERACTION, PATHWAY, RNA EDITING, and 
			// DEVELOPMENTAL STAGE need to be tagged with the attribute 'Functional Aspects'
			case "CATALYTIC ACTIVITY":
			case "COFACTOR":
			case "FUNCTION":
			case "DISEASE":
			case "ENZYME REGULATION":
			case "INDUCTION":
			case "INTERACTION":
			case "PATHWAY":
			case "RNA EDITING":			
				// add INTERACTION comment parameters
				if ($commentType == "INTERACTION" && count($comment->children) == 2){
					if ($comment->children[0]->att_intactId == $comment->children[1]->att_intactId){
						$textValue .= "with Self (accepted by Swiss-Prot);";
						// build URL
						$comment->url = "http://www.ebi.ac.uk/intact/search/do/search?binary=" . 
						$comment->children[0]->att_intactId . ",". 
						$comment->children[0]->att_intactId;
					}
					else {
						if ($comment->children[1]->label == "")
							$textValue .= "with -";					
						else
							$textValue .= "with " . $comment->children[1]->label;
						
						$textValue .= " (accepted by Swiss-Prot);";
						$comment->url = "http://www.ebi.ac.uk/intact/search/do/search?binary=" . 
						$comment->children[0]->att_intactId . ",". 
						$comment->children[1]->att_intactId;
					}
				}
				// ignore other parameters of INTERACTION comment
				if ($commentType == "INTERACTION")
					$comment->text = "";				
				break;
			//l.)	the comments with the topic, ALTERNATIVE PRODUCTS, DOMAIN, PTM, 
			// POLYMORPHISM, SIMILARITY,  MASS SPECTROMETRY, and SUBUNIT  need to be tagged
			// with the attribute 'Structural Aspects'
			case "ALTERNATIVE PRODUCTS":
				foreach ($comment->isoforms as $isoform) {
					$isoformId = $this->addIsoform($entry, $definedMeaningId, $proteinMeaningId, $organismSpeciesMeaningId, $isoform);
					addRelation($definedMeaningId, $this->alternativeProductId, $isoformId);
				} 
				break;
			case "SIMILARITY":
				if (startsWith($comment->text, "Belongs to the ")) {
					$family = trim(substr($comment->text, strlen("Belongs to the ")));
					$familyId = $this->addSimilarityFamily($family); 					
					
					addRelation($definedMeaningId, $this->conceptualPartOfId, $familyId);
					$normalProcessing = false;
				}
				else if (startsWith($comment->text, "Contains ")) {
					$domain = trim(substr($comment->text, strlen("Contains ")));
					
					while ($domain[0] >= "0" && $domain[0] <= "9")
						$domain = substr($domain, 1);
					
					$domain = trim($domain);
					$domainId = $this->addSimilarityFamily($domain); 					
					
					addRelation($definedMeaningId, $this->consistsOfId, $domainId);
					$normalProcessing = false;
				}
				
				break;
			case "DOMAIN":
			case "PTM":
			case "POLYMORPHISM":
			case "MASS SPECTROMETRY":
			case "SUBUNIT":				
				// add mass SPECTROMETRY to text value
				if ($comment->mass != "") 
					$textValue .= $comment->mass . " is the determined molecular weight; ";
				// add method of MASS SPECTROMETRY to text value
				if ($comment->method != ""){					
					$textValue .= $comment->method . " is the ionization method; ";
				}
				// add error of MASS SPECTROMETRY to text value
				if ($comment->error != ""){					
					$textValue .= $comment->error . " is the accuracy or error range of the MW measurement; ";
				}
				// add position of MASS SPECTROMETRY to text value				
				if ($commentType == "MASS SPECTROMETRY" && count($comment->children) > 0)
					$textValue .= $comment->children[0]->position . " is the part of the protein sequence entry that corresponds to the molecular weight;";
				
				// ignore note of MASS SPECTROMETRY comment
				if ($commentType == "MASS SPECTROMETRY")
					$comment->text = "";
				break;
			//m.) the comments with the topic, ALLERGEN, PHARMACEUTICAL, BIOTECHNOLOGY, 
			// TOXIC DOSE, and BIOPHYSICOCHEMICAL PROPERTIES need to be tagged with the 
			// attribute 'Pharmaceutical Aspects'
			case "ALLERGEN":
			case "PHARMACEUTICAL":
			case "BIOTECHNOLOGY":
			case "TOXIC DOSE":
			case "BIOPHYSICOCHEMICAL PROPERTIES":				
				if ($commentType == "BIOPHYSICOCHEMICAL PROPERTIES") {
					// add Kinetic parameters to text value	
					if (count($comment->children) > 0) {
						$textValue .= "Kinetic parameters:(";
						if ($comment->children[0]->km != "")
							$textValue .= "KM=" . $comment->children[0]->km . "; ";
						if ($comment->children[0]->vMax != "")
							$textValue .= "Vmax=" . $comment->children[0]->vMax;	
						$textValue .= "); ";
					}
					// add phDependence parameter
					if ($comment->phDependence != "")
						$textValue .= "pH dependence: " . $comment->phDependence . "; ";
					// add temperatureDependence parameter
					if ($comment->temperatureDependence != "")
						$textValue .= "temperature dependence: " . $comment->temperatureDependence . ";";
				}				
				break;			
			// o.) the comments with the topic, WEB RESOURCE or ONLINE INFORMATION needs to 
			// be tagged with the attribute 'External Information'
			case "ONLINE INFORMATION":				
				// add comment name to text value
				$label = "";
				
				if ($comment->name != "") 
					$label .= $comment->name;
				
				// add 'NOTE' child text to link label
				if ($comment->note != "") {
					if ($label != "") 
						$label .= ", ";
					
					$label .= $comment->note;
				}
				
				if ($comment->text != "") {
					$textValue = $comment->text;
					
					if ($comment->status != "") 
						$textValue .= " (" . $comment->status . ")"; 
					
					$idToAddLinkTo = addTextAttributeValue($definedMeaningId, $attributeMeaningId, $textValue);
				}
				else
					$idToAddLinkTo = $definedMeaningId;
				
				addLinkAttributeValue($idToAddLinkTo, $this->onlineInformationId, $comment->url, $label);	
				$normalProcessing = false;			
				break;
			//n.) the comments with the topic, MISCELLANEOUS and CAUTION need to be tagged
			// with the attribute 'Other Aspects'
			case "DEVELOPMENTAL STAGE":
			case "MISCELLANEOUS":
			case "CAUTION":
			default:
				break;
			}
			
			if ($normalProcessing) {
				// add comment text to text value			
				if ($textValue != "" && ($comment->text != "" || $comment->status != "")) 
					$textValue .= " TEXT=";
				
				if  ($comment->text != "")
					$textValue .= $comment->text;
				
				// add comment status to text value
				if ($comment->status != "") 
					$textValue .= " (" . $comment->status . ")";
	
				if ($textValue != "") {
					// add the comment fields as text attributes to the entry	
					$textAttributeValueId = addTextAttributeValue($definedMeaningId, $attributeMeaningId, $textValue);
					
					// add the comment URL as URL attribute to the entry and link URL attribute with text attribute
					if ($comment->url != "")
						addLinkAttributeValue($textAttributeValueId, $this->onlineInformationId, $comment->url);
				}
			}
		}
	}
	
	public function addEntry(SwissProtEntry $entry, $proteinMeaningId, $organismSpecificGene, $organismSpeciesMeaningId) {
		$definedMeaningId = $this->addOrganismSpecificProtein($entry->protein->name, $entry->organism, $proteinMeaningId, $organismSpecificGene, $organismSpeciesMeaningId);

		// change name to make sure it works in wiki-urls:
		$swissProtExpression = str_replace('_', '-', $entry->name);
		addSynonymOrTranslation($swissProtExpression, $this->languageId, $definedMeaningId, true);
		
		foreach ($entry->protein->synonyms as $key => $synonym) 
			addSynonymOrTranslation($synonym, $this->languageId, $definedMeaningId, true);
			
		addDefinedMeaningToCollection($definedMeaningId, $this->collectionId, $entry->accession);
		
		// add the comment fields as text attributes to the entry and link comments with
		// the appropriate definedMeaning
		$this->addComments($entry, $definedMeaningId, $proteinMeaningId, $organismSpeciesMeaningId);
		
		// add EC number:
		if ($entry->EC != ""){
			$ECNumberMeaningId = $this->getOrCreateECNumberMeaningId($entry->EC);
			addRelation($definedMeaningId, $this->activityConceptId, $ECNumberMeaningId);
		}
		
		// add keywords:
//		foreach ($entry->keywords as $key => $keyword) {
//			if (array_key_exists($keyword, $this->keyword2GoMeaningIdMapping)) {
//				$goMeaningId = $this->keyword2GoMeaningIdMapping[$keyword];
//				addRelation($definedMeaningId, $this->keywordConceptId, $goMeaningId);
//			}
//		}
		
		foreach ($entry->GOReference as $key => $goReference) {
			$relationConcept = 0;
		
			switch($goReference->type) {
			case "biological process":
				$relationConcept = $this->biologicalProcessConceptId;
				break;
			case "molecular function":
				$relationConcept = $this->molecularFunctionConceptId;
				break;
			case "cellular component":
				$relationConcept = $this->cellularComponentConceptId;
				break;
			}
			
			if ($relationConcept != 0) 
				addRelation($definedMeaningId, $relationConcept, $this->goCollection->getOrCreateMember($goReference->goCode));
		}			
		
 		// Add 'included' functional domains:
		foreach ($entry->protein->domains as $key => $domain) {
			$domainMeaningId = $this->addFunctionalDomain($domain);

			foreach ($domain->synonyms as $domainKey => $synonym) 
				addSynonymOrTranslation($synonym, $this->languageId, $domainMeaningId, true);
			
			addRelation($definedMeaningId, $this->consistsOfId, $domainMeaningId);
		}

 		// Add 'contained' proteins:
		foreach ($entry->protein->components as $key => $component) {
			$componentMeaningId = $this->addContainedProtein($component, $entry->organism, $organismSpeciesMeaningId);
			
			foreach ($component->synonyms as $componentKey => $synonym) 
				addSynonymOrTranslation($synonym, $this->languageId, $componentMeaningId, true);
			
			addRelation($definedMeaningId, $this->containsConceptId, $componentMeaningId);
		}
		
		return $definedMeaningId;		
	}
	
	public function getOrCreateAttributeMeaningId($attribute) {
		if (array_key_exists($attribute, $this->attributes)) 
			$definedMeaningId = $this->attributes[$attribute];
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($attribute, $attribute, $attribute, $this->textAttibuteCollectionId);
			$this->attributes[$attribute] = $definedMeaningId;
		}
		
		return $definedMeaningId;		
	}
	
	public function getOrCreateECNumberMeaningId($EC) {
		if (array_key_exists($EC, $this->ECNumbers)) {
			$definedMeaningId = $this->ECNumbers[$EC];
		}
		elseif (array_key_exists($EC, $this->EC2GoMeaningIdMapping)) {
			$definedMeaningId = $this->EC2GoMeaningIdMapping[$EC];
			$this->ECNumbers[$EC] = $definedMeaningId;
			$expression = $this->getOrCreateExpression($EC);
			$expression->assureIsBoundToDefinedMeaning($definedMeaningId, true);
		}
		else {
			$definedMeaningId = $this->addExpressionAsDefinedMeaning($EC, $EC, $EC, $this->ECCollectionId);
			addClassMembership($definedMeaningId, $this->enzymeCommissionNumberConceptId);
			$this->ECNumbers[$EC] = $definedMeaningId;
		}
		return $definedMeaningId;		
	}
	
	public function getOrCreateExpression($spelling) {
		$expression = findExpression($spelling, $this->languageId);
		if (!$expression) {
			//wfDebug( "create expression $spelling in database");
			$expression = createExpression($spelling, $this->languageId);
		}
		return $expression;		
	}
	
	public function addExpressionAsDefinedMeaning($spelling, $definition, $internalIdentifier, $collectionId) {
		$expression = $this->getOrCreateExpression($spelling);
		$definedMeaningId = createNewDefinedMeaning($expression->id, $this->languageId, $definition);
		addDefinedMeaningToCollection($definedMeaningId, $collectionId, $internalIdentifier);
		return $definedMeaningId;
	}
} 

class UniProtXMLElementHandler extends DefaultXMLElementHandler {
	public $importer;
	
	public function getHandlerForNewElement($name) {
		if ($name == "ENTRY")  
			$result = new EntryXMLElementHandler();
		else 
			$result = parent::getHandlerForNewElement($name);

		$result->name = $name;
		
		return $result;
	}
	
	public function notify($childHandler) {
		if ($childHandler instanceof EntryXMLElementHandler) 
			$this->importer->import($childHandler->entry);
	}
}

class EntryXMLElementHandler extends DefaultXMLElementHandler {
	public $entry;

	public function __construct() {
		$this->entry = new SwissProtEntry();	
	}
	
	public function getHandlerForNewElement($name) {
		switch($name) {
			case "PROTEIN": 
				$result = new ProteinXMLElementHandler();
				break;
			case "GENE":
				$result = new GeneXMLElementHandler();
				break;
			case "ORGANISM":
				$result = new OrganismXMLElementHandler();
				break;
			case "COMMENT":
				$result = new CommentXMLElementHandler();
				break;
			case "DBREFERENCE":
				$result = new DBReferenceXMLElement();
				break;
			default:
				$result = DefaultXMLElementHandler::getHandlerForNewElement($name);
				break;
		}
		
		$result->name = $name;
		
		return $result;
	}
	
	public function notify($childHandler) {
		if ($childHandler instanceof ProteinXMLElementHandler) {
			$this->entry->protein = $childHandler->protein;		
		}
		elseif ($childHandler instanceof GeneXMLElementHandler) {
//			$this->entry->gene = $childHandler->gene;
//			$this->entry->geneSynonyms = $childHandler->synonyms;
			list($this->entry->gene, $this->entry->geneSynonyms) = $childHandler->getResult();
		}
		elseif ($childHandler instanceof OrganismXMLElementHandler) {
			$this->entry->organism = $childHandler->organism;
			$this->entry->organismTranslations = $childHandler->translations;		
		}
		elseif ($childHandler instanceof CommentXMLElementHandler) {
			if ($childHandler->comment != "")
				$this->entry->comments[] = $childHandler->comment;
		}
		elseif ($childHandler instanceof DBReferenceXMLElement) {
			switch (strtoupper($childHandler->type)) {
			case "EC": 
				$this->entry->EC = $childHandler->id; 
				break;
			case "GO": 
				$this->entry->GOReference[] = new GOReference($childHandler->id, $childHandler->property["term"]); 
				break;	
			case "HGNC": 
				$position = strpos($childHandler->id, ":");
				$this->entry->HGNCReference = substr($childHandler->id, $position + 1);
				break;
			}
		}
		elseif($childHandler->name == "ACCESSION") {
			if ($this->entry->accession == "") {
				$this->entry->accession = $childHandler->data;
			} 
			else {
				$this->entry->secundaryAccessions[] = $childHandler->data;
			}
		}
		elseif($childHandler->name == "NAME") {
			$this->entry->name = $childHandler->data;
		}															 
		elseif($childHandler->name == "KEYWORD") {
			$this->entry->keywords[] = $childHandler->attributes["ID"];
		}
	}	
}

class ProteinXMLElementHandler extends DefaultXMLElementHandler {
	public $protein;
	
	public function __construct() {
		$this->protein = new Protein();
	}
	
	public function getHandlerForNewElement($name) {
		if ($name == "NAME") 
			$result = new NameXMLElementHandler();
		else 
			$result = new ProteinXMLElementHandler();
		
		$result->name = $name;
		return $result;
	}
	
	public function notify($childHandler) {
		if (is_a($childHandler, NameXMLElementHandler)) {
			$proteinName = $childHandler->data;
			if ($this->protein->name == "") 
				$this->protein->name = $proteinName;
			else 
				$this->protein->synonyms[]=$proteinName;
		}
		elseif ($childHandler->name == "DOMAIN")
			$this->protein->domains[] = $childHandler->protein;					
		elseif ($childHandler->name == "COMPONENT")
			$this->protein->components[] = $childHandler->protein;					
	}
}

class NameXMLElementHandler extends DefaultXMLElementHandler {
	public $name;
	
	public function close() {
		$this->name = $this->data;
	}
}

class GeneNameXMLElementHandler extends DefaultXMLElementHandler {
	public $name = "";
	public $type = "";

	public function setAttributes($attributes) {
		$this->type = $attributes["TYPE"];	
	}

	public function processData($data) {
		$this->name .= $data;
	}
}

class GeneXMLElementHandler extends DefaultXMLElementHandler {
	public $primaryNames = array();
	public $synonyms = array();
	public $orderedLoci = array();
	public $ORFs = array();
	
	public function getHandlerForNewElement($name) {
		if ($name == "NAME")
			return new GeneNameXMLElementHandler();
		else
			return parent::getHandlerForNewElement($name);
	}
	
	public function notify($childHandler) {
		// We expect a GeneNameXMLElementHandler
		
		switch ($childHandler->type) { 
			case "primary": 
				$this->primaryNames[] = $childHandler->name;
				break;
			case "synonym":
				$this->synonyms[] = $childHandler->name;
				break;
			case "ordered locus":
				$this->orderedLoci[] = $childHandler->name;
				break;
			case "ORF":
				$this->ORFs[] = $childHandler->name;
				break;
		}	
	}
	
	public function getResult() {
		// Primary name is not always present for a gene, fall back to a synonym, ORF or ordered locus
		$name = "";
		$synonyms = array();
		
		foreach($this->primaryNames as $primaryName) 
			if ($name == "")
				$name = $primaryName;
			else
				$synonyms[] = $primaryName;
		
		foreach($this->synonyms as $synonym) 
			if ($name == "")
				$name = $synonym;
			else
				$synonyms[] = $synonym;
		
		foreach($this->ORFs as $ORF) 
			if ($name == "")
				$name = $ORF;
			else
				$synonyms[] = $ORF;
				
		foreach($this->orderedLoci as $orderedLocus) 
			if ($name == "")
				$name = $orderedLocus;
			else
				$synonyms[] = $orderedLocus;

		return array($name, $synonyms);
	}
}

class OrganismXMLElementHandler extends DefaultXMLElementHandler {
	public $organism = "";
	public $translations = array();
	
	public function notify($childHandler) {
		
		if ($childHandler->name == "NAME") {
			// Some of the Organism 'definition' fields have parenthesis containing synonyms
			// of the species
			$organismNames = spliti("\\([^(isolate)(strain)]", $childHandler->data);
			foreach ($organismNames as $orgName) {
				// move last close parenthesis
				if ($orgName !=  $organismNames[0])
					$orgName = ereg_replace ( "\\)$", "", $orgName);
	
				if($this->organism == "")
					$this->organism = $orgName; 
				else 
					$this->translations[] = $orgName;
			 }
		}
	}
}

// class to process comment XML tag
class CommentXMLElementHandler extends DefaultXMLElementHandler {
	public $comment;
	
	public function __construct() {
		$this->comment = new Comment();
	}
		
	public function setAttributes($attributes) {
		DefaultXMLElementHandler::setAttributes($attributes);
		
		// recover comment type
		if (array_key_exists("TYPE", $attributes))
			$this->comment->type = $attributes["TYPE"];
				
		// recover comment status
		if (array_key_exists("STATUS", $attributes))
			$this->comment->status = $attributes["STATUS"];
		
		// recover comment name
		if (array_key_exists("NAME", $attributes))
			$this->comment->name = $attributes["NAME"];
			
		// recover comment method
		if (array_key_exists("METHOD", $attributes))
			$this->comment->method = $attributes["METHOD"];
			
		// recover comment mass
		if (array_key_exists("MASS", $attributes))
			$this->comment->mass = $attributes["MASS"];
			
		// recover comment error
		if (array_key_exists("ERROR", $attributes))
			$this->comment->error = $attributes["ERROR"];
	}
	
	public function getHandlerForNewElement($name) {
		switch ($name) { // composed children
			case "LOCATION": 
			case "KINETICS":  
			case "INTERACTANT":  
				$result = new CommentChildXMLElementHandler();				
				break;
			case "ISOFORM":
				$result = new IsoformXMLElementHandler();
				break;
			default:
				$result = parent::getHandlerForNewElement($name);
				break;
		}
		
		$result->name = $name;
		
		return $result;
	}

	public function notify($childHandler) {		
		if ($childHandler instanceof CommentChildXMLElementHandler){
				// stock all composed comment children (objects)
				$this->comment->children[] = $childHandler->commentChild;	
		}
		else if ($childHandler instanceof IsoformXMLElementHandler)  
			$this->comment->isoforms[] = $childHandler->isoform;
		else
			// there are different comments, so they need a different processing
			switch ($childHandler->name) {
				case "TEXT": // stock comment 'TEXT' child data				
					$this->comment->text = $childHandler->data;
					break;
				case "NOTE": // stock comment 'NOTE' child data
					$this->comment->note = $childHandler->data;
					break;
				case "LINK":
					// stock comment URL link
					$this->comment->url = $childHandler->attributes["URI"];
					break;
				case "PHDEPENDENCE":
					$this->comment->phDependence = $childHandler->data;
					break;
				case "TEMPERATUREDEPENDENCE":
					$this->comment->temperatureDependence = $childHandler->data;
					break;							
				default:
					$this->comment->text = $childHandler->data;
					break;
			}
	}
}

// class to process child of child comment
class CommentChildXMLElementHandler extends DefaultXMLElementHandler {
	public $commentChild;

	public function __construct() {
		$this->commentChild = new CommentChild();
	}
	
	public function setAttributes($attributes) {
		DefaultXMLElementHandler::setAttributes($attributes);

		// recover comment intactId
		if (array_key_exists("INTACTID", $attributes))
			$this->commentChild->att_intactId = $attributes["INTACTID"];
	}
	
	public function notify($childHandler) {
		switch ($childHandler->name) {
			case "BEGIN": // stock mass spectrometry position
			case "END":
				if (array_key_exists("POSITION", $childHandler->attributes)){
					if ($this->commentChild->position == "")
						$this->commentChild->position = $childHandler->attributes["POSITION"];
					else
						$this->commentChild->position .= "-" . $childHandler->attributes["POSITION"];
				}
				break;
			case "KM": // stock KM Kinetic parameter
				$this->commentChild->km = $childHandler->data; 
				break;
			case "VMAX": // stock Vmax Kinetic parameter
				$this->commentChild->vMax = $childHandler->data;
				break;
			case "LABEL": // stock interactant label
				$this->commentChild->label = $childHandler->data;
				break;
		}
	}
}

class Isoform {
	public $id = array();
	public $names = array();
	public $notes = array();
}

class IsoformXMLElementHandler extends DefaultXMLElementHandler {
	public $isoform;
	
	public function __construct() {
		$this->isoform = new Isoform(); 
	}
	
	public function notify($childHandler) {
		switch ($childHandler->name) {
			case "ID":   $this->isoform->id = $childHandler->data; break;
			case "NAME": $this->isoform->names[] = $childHandler->data; break;
			case "NOTE": $this->isoform->notes[] = $childHandler->data; break;
		}
	}
}

class DBReferenceXMLElement extends DefaultXMLElementHandler {
	public $type;
	public $id;
	public $property = array();
	
	public function setAttributes($attributes) {
		DefaultXMLElementHandler::setAttributes($attributes);
		
		$this->type = $attributes["TYPE"];
		$this->id = $attributes["ID"];
	} 
	
	public function notify($childHandler) {
		$this->property[$childHandler->attributes["TYPE"]] = $childHandler->attributes["VALUE"];
	}	
}

class SwissProtEntry {
	public $name = "";
	public $accession = "";
	public $secundaryAccessions = array();
	public $protein;
	public $EC = "";
	public $gene = "";
	public $geneSynonyms = array();
	public $organism = "";
	public $organismTranslations = array();
	public $comments = array();
	public $keywords = array();
	public $GOReference = array();
	public $HGNCReference;
	
	public function expression() {
		return $this->protein->name . " (" . $this->organism . ")"; 
	}
}

// stock different data of comment XML tag
class Comment {
	public $type = "";
	public $name = "";
	public $status = "";
	public $text = "";
	public $note = "";
	public $url = "";
	public $method = "";
	public $mass = "";
	public $error = "";
	public $phDependence = ""	;
	public $temperatureDependence = "";
	public $children = array();  //
	public $isoforms = array(); 
}

// stock data of a composed comment XML tags
class CommentChild {
	public $position = "";
	public $KM = "";
	public $vMax = "";
	public $att_intactId = "";
	public $label = "";			
}
	

class Protein {
	public $name = "";
	public $synonyms = array();
	public $domains = array();
	public $components = array();
}

class GOReference {
	public $type;
	public $goCode;
	
	public function __construct($goCode, $term) {
		$this->goCode = $goCode;
		$typeAbbreviation = substr($term, 0, 1);
		switch($typeAbbreviation) {
		case("P"):
			$this->type = "biological process";
			break;
		case("F"):
			$this->type = "molecular function";
			break;
		case("C"):
			$this->type = "cellular component";
			break;
		}
	}
}

