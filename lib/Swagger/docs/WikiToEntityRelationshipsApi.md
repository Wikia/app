# Swagger\Client\WikiToEntityRelationshipsApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create**](WikiToEntityRelationshipsApi.md#create) | **PUT** /wiki/relationships/{wikiId}/entity/{entityId} | creates a relationship between wiki and entity
[**getRelatedEntities**](WikiToEntityRelationshipsApi.md#getRelatedEntities) | **GET** /wiki/relationships/{wikiId} | get the entities related to wiki
[**getRelatedWikis**](WikiToEntityRelationshipsApi.md#getRelatedWikis) | **GET** /wiki/relationships/entity/{entityId} | get wiki related to an entity
[**unrelate**](WikiToEntityRelationshipsApi.md#unrelate) | **DELETE** /wiki/relationships/{wikiId}/entity/{entityId} | delete the relationship between wiki and entity
[**unrelateAllFromWiki**](WikiToEntityRelationshipsApi.md#unrelateAllFromWiki) | **DELETE** /wiki/relationships/{wikiId} | delete all of a wiki&#39;s entity relationships


# **create**
> create($wiki_id, $entity_id)

creates a relationship between wiki and entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\WikiToEntityRelationshipsApi();
$wiki_id = "wiki_id_example"; // string | 
$entity_id = "entity_id_example"; // string | 

try { 
    $api_instance->create($wiki_id, $entity_id);
} catch (Exception $e) {
    echo 'Exception when calling WikiToEntityRelationshipsApi->create: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wiki_id** | **string**|  | 
 **entity_id** | **string**|  | 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getRelatedEntities**
> \Swagger\Client\ContentEntity\Models\Entity[] getRelatedEntities($wiki_id)

get the entities related to wiki



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\WikiToEntityRelationshipsApi();
$wiki_id = "wiki_id_example"; // string | 

try { 
    $result = $api_instance->getRelatedEntities($wiki_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WikiToEntityRelationshipsApi->getRelatedEntities: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wiki_id** | **string**|  | 

### Return type

[**\Swagger\Client\ContentEntity\Models\Entity[]**](Entity.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getRelatedWikis**
> string[] getRelatedWikis($entity_id)

get wiki related to an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\WikiToEntityRelationshipsApi();
$entity_id = "entity_id_example"; // string | 

try { 
    $result = $api_instance->getRelatedWikis($entity_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WikiToEntityRelationshipsApi->getRelatedWikis: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 

### Return type

**string[]**

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **unrelate**
> unrelate($wiki_id, $entity_id)

delete the relationship between wiki and entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\WikiToEntityRelationshipsApi();
$wiki_id = "wiki_id_example"; // string | 
$entity_id = "entity_id_example"; // string | 

try { 
    $api_instance->unrelate($wiki_id, $entity_id);
} catch (Exception $e) {
    echo 'Exception when calling WikiToEntityRelationshipsApi->unrelate: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wiki_id** | **string**|  | 
 **entity_id** | **string**|  | 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **unrelateAllFromWiki**
> unrelateAllFromWiki($wiki_id)

delete all of a wiki's entity relationships



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\WikiToEntityRelationshipsApi();
$wiki_id = "wiki_id_example"; // string | 

try { 
    $api_instance->unrelateAllFromWiki($wiki_id);
} catch (Exception $e) {
    echo 'Exception when calling WikiToEntityRelationshipsApi->unrelateAllFromWiki: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wiki_id** | **string**|  | 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

