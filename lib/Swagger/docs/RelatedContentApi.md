# Swagger\Client\RelatedContentApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getRelatedContentFromContentUrl**](RelatedContentApi.md#getRelatedContentFromContentUrl) | **GET** /related-content/from-content-url | get the content related to content by url
[**getRelatedContentFromEntityId**](RelatedContentApi.md#getRelatedContentFromEntityId) | **GET** /related-content/from-entity-id/{entityId} | get the content related to an entity
[**getRelatedContentFromEntityName**](RelatedContentApi.md#getRelatedContentFromEntityName) | **GET** /related-content/from-entity-name/{name} | get content related to an entity (by name)


# **getRelatedContentFromContentUrl**
> \Swagger\Client\ContentEntity\Models\FilteredRelatedContent getRelatedContentFromContentUrl($content_url, $limit)

get the content related to content by url



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\RelatedContentApi();
$content_url = "content_url_example"; // string | 
$limit = 20; // int | 

try { 
    $result = $api_instance->getRelatedContentFromContentUrl($content_url, $limit);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RelatedContentApi->getRelatedContentFromContentUrl: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **content_url** | **string**|  | [optional] 
 **limit** | **int**|  | [optional] [default to 20]

### Return type

[**\Swagger\Client\ContentEntity\Models\FilteredRelatedContent**](FilteredRelatedContent.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getRelatedContentFromEntityId**
> \Swagger\Client\ContentEntity\Models\FilteredRelatedContent getRelatedContentFromEntityId($entity_id, $limit, $include_root_relations)

get the content related to an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\RelatedContentApi();
$entity_id = "entity_id_example"; // string | 
$limit = 20; // int | 
$include_root_relations = true; // bool | 

try { 
    $result = $api_instance->getRelatedContentFromEntityId($entity_id, $limit, $include_root_relations);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RelatedContentApi->getRelatedContentFromEntityId: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **limit** | **int**|  | [optional] [default to 20]
 **include_root_relations** | **bool**|  | [optional] [default to true]

### Return type

[**\Swagger\Client\ContentEntity\Models\FilteredRelatedContent**](FilteredRelatedContent.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getRelatedContentFromEntityName**
> \Swagger\Client\ContentEntity\Models\FilteredRelatedContent getRelatedContentFromEntityName($name, $limit, $include_root_relations)

get content related to an entity (by name)



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\RelatedContentApi();
$name = "name_example"; // string | 
$limit = 20; // int | 
$include_root_relations = true; // bool | 

try { 
    $result = $api_instance->getRelatedContentFromEntityName($name, $limit, $include_root_relations);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RelatedContentApi->getRelatedContentFromEntityName: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **name** | **string**|  | 
 **limit** | **int**|  | [optional] [default to 20]
 **include_root_relations** | **bool**|  | [optional] [default to true]

### Return type

[**\Swagger\Client\ContentEntity\Models\FilteredRelatedContent**](FilteredRelatedContent.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

