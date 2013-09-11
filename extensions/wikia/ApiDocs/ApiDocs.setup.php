<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ApiDocs',
	'author' => 'Artur Dwornik',
//	'descriptionmsg' => 'imageserving-desc',
	'version' => '0.1',
);

$dir = __DIR__ . '/';

$app = F::app();

$wgAutoloadClasses['ApiDocsController'] = "{$dir}ApiDocsController.class.php";
$wgAutoloadClasses['Wikia\ApiDocs\Services\ApiDocsService'] = "{$dir}services/ApiDocsService.php";


$wgSpecialPages['ApiDocs'] = 'ApiDocsController';


global $IP;
// load swagger
$swaggerRoot = $IP . "/lib/vendor/swagger-php/";
$wgAutoloadClasses['Swagger\Parser']  = $swaggerRoot . "library/Swagger/Parser.php";
$wgAutoloadClasses['Swagger\Logger']  = $swaggerRoot . "library/Swagger/Logger.php";
$wgAutoloadClasses['Swagger\Swagger'] = $swaggerRoot . "library/Swagger/Swagger.php";

$wgAutoloadClasses['Swagger\Annotations\Parameter']          = $swaggerRoot . "library/Swagger/Annotations/Parameter.php";
$wgAutoloadClasses['Swagger\Annotations\Parameters']         = $swaggerRoot . "library/Swagger/Annotations/Parameters.php";
$wgAutoloadClasses['Swagger\Annotations\Model']              = $swaggerRoot . "library/Swagger/Annotations/Model.php";
$wgAutoloadClasses['Swagger\Annotations\ErrorResponse']      = $swaggerRoot . "library/Swagger/Annotations/ErrorResponse.php";
$wgAutoloadClasses['Swagger\Annotations\AllowableValues']    = $swaggerRoot . "library/Swagger/Annotations/AllowableValues.php";
$wgAutoloadClasses['Swagger\Annotations\AbstractAnnotation'] = $swaggerRoot . "library/Swagger/Annotations/AbstractAnnotation.php";
$wgAutoloadClasses['Swagger\Annotations\Resource']           = $swaggerRoot . "library/Swagger/Annotations/Resource.php";
$wgAutoloadClasses['Swagger\Annotations\Operation']          = $swaggerRoot . "library/Swagger/Annotations/Operation.php";
$wgAutoloadClasses['Swagger\Annotations\Property']           = $swaggerRoot . "library/Swagger/Annotations/Property.php";
$wgAutoloadClasses['Swagger\Annotations\ErrorResponses']     = $swaggerRoot . "library/Swagger/Annotations/ErrorResponses.php";
$wgAutoloadClasses['Swagger\Annotations\Items']              = $swaggerRoot . "library/Swagger/Annotations/Items.php";
$wgAutoloadClasses['Swagger\Annotations\Properties']         = $swaggerRoot . "library/Swagger/Annotations/Properties.php";
$wgAutoloadClasses['Swagger\Annotations\Operations']         = $swaggerRoot . "library/Swagger/Annotations/Operations.php";
$wgAutoloadClasses['Swagger\Annotations\Api']                = $swaggerRoot . "library/Swagger/Annotations/Api.php";

// load doctrine
$doctrineCommonRoot = $IP . "/lib/vendor/DoctrineCommon-2.3.0/Doctrine/Common/";
$files = ["./PropertyChangedListener.php","./Cache/RedisCache.php","./Cache/ApcCache.php","./Cache/CacheProvider.php","./Cache/WinCacheCache.php","./Cache/MemcachedCache.php","./Cache/FileCache.php","./Cache/MemcacheCache.php","./Cache/PhpFileCache.php","./Cache/ArrayCache.php","./Cache/XcacheCache.php","./Cache/Cache.php","./Cache/ZendDataCache.php","./Cache/FilesystemCache.php","./CommonException.php","./Collections/ArrayCollection.php","./Collections/ExpressionBuilder.php","./Collections/Selectable.php","./Collections/Criteria.php","./Collections/Expr/Comparison.php","./Collections/Expr/Value.php","./Collections/Expr/ExpressionVisitor.php","./Collections/Expr/CompositeExpression.php","./Collections/Expr/Expression.php","./Collections/Expr/ClosureExpressionVisitor.php","./Collections/Collection.php","./Persistence/ObjectManager.php","./Persistence/ConnectionRegistry.php","./Persistence/ObjectManagerAware.php","./Persistence/Mapping/ClassMetadataFactory.php","./Persistence/Mapping/AbstractClassMetadataFactory.php","./Persistence/Mapping/RuntimeReflectionService.php","./Persistence/Mapping/ReflectionService.php","./Persistence/Mapping/ClassMetadata.php","./Persistence/Mapping/MappingException.php","./Persistence/Mapping/StaticReflectionService.php","./Persistence/Mapping/Driver/MappingDriverChain.php","./Persistence/Mapping/Driver/DefaultFileLocator.php","./Persistence/Mapping/Driver/MappingDriver.php","./Persistence/Mapping/Driver/FileDriver.php","./Persistence/Mapping/Driver/PHPDriver.php","./Persistence/Mapping/Driver/AnnotationDriver.php","./Persistence/Mapping/Driver/FileLocator.php","./Persistence/Mapping/Driver/StaticPHPDriver.php","./Persistence/Mapping/Driver/SymfonyFileLocator.php","./Persistence/Proxy.php","./Persistence/Event/LifecycleEventArgs.php","./Persistence/Event/ManagerEventArgs.php","./Persistence/Event/OnClearEventArgs.php","./Persistence/Event/PreUpdateEventArgs.php","./Persistence/Event/LoadClassMetadataEventArgs.php","./Persistence/PersistentObject.php","./Persistence/ManagerRegistry.php","./Persistence/AbstractManagerRegistry.php","./Persistence/ObjectRepository.php","./Comparable.php","./Lexer.php","./NotifyPropertyChanged.php","./Reflection/ReflectionProviderInterface.php","./Reflection/Psr0FindFile.php","./Reflection/StaticReflectionProperty.php","./Reflection/StaticReflectionClass.php","./Reflection/StaticReflectionMethod.php","./Reflection/StaticReflectionParser.php","./Reflection/ClassFinderInterface.php","./EventArgs.php","./Util/ClassUtils.php","./Util/Debug.php","./Util/Inflector.php","./Annotations/AnnotationReader.php","./Annotations/Annotation.php","./Annotations/AnnotationRegistry.php","./Annotations/TokenParser.php","./Annotations/FileCacheReader.php","./Annotations/IndexedReader.php","./Annotations/CachedReader.php","./Annotations/DocParser.php","./Annotations/SimpleAnnotationReader.php","./Annotations/Annotation/IgnoreAnnotation.php","./Annotations/Annotation/Required.php","./Annotations/Annotation/Attribute.php","./Annotations/Annotation/Target.php","./Annotations/Annotation/Attributes.php","./Annotations/Reader.php","./Annotations/DocLexer.php","./Annotations/PhpParser.php","./Annotations/AnnotationException.php","./EventManager.php","./EventSubscriber.php","./Version.php"];
foreach ( $files as $file ) {
	$parts = explode( "/", $file );   // "./Cache/RedisCache.php" -> [".", "Cache", "RedisCache.php"]
	array_shift( $parts );            //  [".", "Cache", "RedisCache.php"] -> [ "Cache", "RedisCache.php" ]
	$className = str_replace( ".php", "", array_pop( $parts ) ); //$parts = ["Cache"]; $className = "RedisCache"
	$parts[] = $className;
	$fullClassName = "Doctrine\\Common\\" . implode( '\\', $parts );
	$wgAutoloadClasses[$fullClassName] = $doctrineCommonRoot . $file;
	//var_dump(  $fullClassName . " | " . $doctrineCommonRoot . $file );
}
