# Swagger\Client\EntityToEntityRelationshipsApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create**](EntityToEntityRelationshipsApi.md#create) | **PUT** /entity/{entityId}/relationships/{otherEntityId} | create a relation between two entities. A will be related to B, but B will not be related to A
[**getRelationships**](EntityToEntityRelationshipsApi.md#getRelationships) | **GET** /entity/{entityId}/relationships | get an entity&#39;s relationships
[**unrelate**](EntityToEntityRelationshipsApi.md#unrelate) | **DELETE** /entity/{entityId}/relationships/{otherEntityId} | delete the relationship from a -&gt; b. Does not affect b -&gt; a
[**unrelateAll**](EntityToEntityRelationshipsApi.md#unrelateAll) | **DELETE** /entity/{entityId}/relationships | delete all the relationships from a


# **create**
> create($entity_id, $other_entity_id, $body)

create a relation between two entities. A will be related to B, but B will not be related to A



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\EntityToEntityRelationshipsApi();
$entity_id = "entity_id_example"; // string | 
$other_entity_id = "other_entity_id_example"; // string | 
$body = 1.2; // double | 

try { 
    $api_instance->create($entity_id, $other_entity_id, $body);
} catch (Exception $e) {
    echo 'Exception when calling EntityToEntityRelationshipsApi->create: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **other_entity_id** | **string**|  | 
 **body** | **double**|  | [optional] 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getRelationships**
> \Swagger\Client\ContentEntity\Models\EntityRelationshipGraph getRelationships($entity_id)

get an entity's relationships



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\EntityToEntityRelationshipsApi();
$entity_id = "entity_id_example"; // string | 

try { 
    $result = $api_instance->getRelationships($entity_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EntityToEntityRelationshipsApi->getRelationships: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 

### Return type

[**\Swagger\Client\ContentEntity\Models\EntityRelationshipGraph**](EntityRelationshipGraph.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **unrelate**
> unrelate($entity_id, $other_entity_id)

delete the relationship from a -> b. Does not affect b -> a



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\EntityToEntityRelationshipsApi();
$entity_id = "entity_id_example"; // string | 
$other_entity_id = "other_entity_id_example"; // string | 

try { 
    $api_instance->unrelate($entity_id, $other_entity_id);
} catch (Exception $e) {
    echo 'Exception when calling EntityToEntityRelationshipsApi->unrelate: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **other_entity_id** | **string**|  | 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **unrelateAll**
> unrelateAll($entity_id)

delete all the relationships from a



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\EntityToEntityRelationshipsApi();
$entity_id = "entity_id_example"; // string | 

try { 
    $api_instance->unrelateAll($entity_id);
} catch (Exception $e) {
    echo 'Exception when calling EntityToEntityRelationshipsApi->unrelateAll: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

