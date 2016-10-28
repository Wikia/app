# Swagger\Client\ContentToEntityRelationshipsApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create**](ContentToEntityRelationshipsApi.md#create) | **PUT** /content/relationships/entity/{entityId} | creates a relationship from a piece of content to an entity
[**getRelatedContent**](ContentToEntityRelationshipsApi.md#getRelatedContent) | **GET** /content/relationships/entity/{entityId} | get the content related to an entity
[**getRelatedEntities**](ContentToEntityRelationshipsApi.md#getRelatedEntities) | **GET** /content/relationships/entity | get the entities related to some content
[**unrelate**](ContentToEntityRelationshipsApi.md#unrelate) | **DELETE** /content/relationships/entity/{entityId} | delete the relationship between content and an entity
[**unrelateAllFromContent**](ContentToEntityRelationshipsApi.md#unrelateAllFromContent) | **DELETE** /content/relationships/entity | delete all of a content&#39;s entity relationships


# **create**
> create($entity_id, $content_id)

creates a relationship from a piece of content to an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\ContentToEntityRelationshipsApi();
$entity_id = "entity_id_example"; // string | 
$content_id = "content_id_example"; // string | 

try { 
    $api_instance->create($entity_id, $content_id);
} catch (Exception $e) {
    echo 'Exception when calling ContentToEntityRelationshipsApi->create: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **content_id** | **string**|  | [optional] 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getRelatedContent**
> string[] getRelatedContent($entity_id)

get the content related to an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\ContentToEntityRelationshipsApi();
$entity_id = "entity_id_example"; // string | 

try { 
    $result = $api_instance->getRelatedContent($entity_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContentToEntityRelationshipsApi->getRelatedContent: ', $e->getMessage(), "\n";
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

# **getRelatedEntities**
> \Swagger\Client\ContentEntity\Models\Entity[] getRelatedEntities($content_id)

get the entities related to some content



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\ContentToEntityRelationshipsApi();
$content_id = "content_id_example"; // string | 

try { 
    $result = $api_instance->getRelatedEntities($content_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ContentToEntityRelationshipsApi->getRelatedEntities: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **content_id** | **string**|  | [optional] 

### Return type

[**\Swagger\Client\ContentEntity\Models\Entity[]**](Entity.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **unrelate**
> unrelate($entity_id, $content_id)

delete the relationship between content and an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\ContentToEntityRelationshipsApi();
$entity_id = "entity_id_example"; // string | 
$content_id = "content_id_example"; // string | 

try { 
    $api_instance->unrelate($entity_id, $content_id);
} catch (Exception $e) {
    echo 'Exception when calling ContentToEntityRelationshipsApi->unrelate: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **content_id** | **string**|  | [optional] 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **unrelateAllFromContent**
> unrelateAllFromContent($content_id)

delete all of a content's entity relationships



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\ContentToEntityRelationshipsApi();
$content_id = "content_id_example"; // string | 

try { 
    $api_instance->unrelateAllFromContent($content_id);
} catch (Exception $e) {
    echo 'Exception when calling ContentToEntityRelationshipsApi->unrelateAllFromContent: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **content_id** | **string**|  | [optional] 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

