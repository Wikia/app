# Swagger\Client\MetadataApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create**](MetadataApi.md#create) | **PUT** /entity/{entityId}/metadata/{metaDataName} | creates new metadata for an entity
[**delete**](MetadataApi.md#delete) | **DELETE** /entity/{entityId}/metadata/{metaDataName} | delete an entity metadata entry
[**deleteAll**](MetadataApi.md#deleteAll) | **DELETE** /entity/{entityId}/metadata | delete all of an entity&#39;s metadata
[**get**](MetadataApi.md#get) | **GET** /entity/{entityId}/metadata/{metaDataName} | get a specific metadata entry for an entity
[**getAll**](MetadataApi.md#getAll) | **GET** /entity/{entityId}/metadata | get all metadata for an entity
[**update**](MetadataApi.md#update) | **POST** /entity/{entityId}/metadata/{metaDataName} | update a specific metadata entry for an entity


# **create**
> create($entity_id, $meta_data_name, $body)

creates new metadata for an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\MetadataApi();
$entity_id = "entity_id_example"; // string | 
$meta_data_name = "meta_data_name_example"; // string | 
$body = "body_example"; // string | 

try { 
    $api_instance->create($entity_id, $meta_data_name, $body);
} catch (Exception $e) {
    echo 'Exception when calling MetadataApi->create: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **meta_data_name** | **string**|  | 
 **body** | **string**|  | [optional] 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **delete**
> delete($entity_id, $meta_data_name)

delete an entity metadata entry



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\MetadataApi();
$entity_id = "entity_id_example"; // string | 
$meta_data_name = "meta_data_name_example"; // string | 

try { 
    $api_instance->delete($entity_id, $meta_data_name);
} catch (Exception $e) {
    echo 'Exception when calling MetadataApi->delete: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **meta_data_name** | **string**|  | 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **deleteAll**
> deleteAll($entity_id)

delete all of an entity's metadata



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\MetadataApi();
$entity_id = "entity_id_example"; // string | 

try { 
    $api_instance->deleteAll($entity_id);
} catch (Exception $e) {
    echo 'Exception when calling MetadataApi->deleteAll: ', $e->getMessage(), "\n";
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

# **get**
> \Swagger\Client\ContentEntity\Models\MetaData get($entity_id, $meta_data_name)

get a specific metadata entry for an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\MetadataApi();
$entity_id = "entity_id_example"; // string | 
$meta_data_name = "meta_data_name_example"; // string | 

try { 
    $result = $api_instance->get($entity_id, $meta_data_name);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MetadataApi->get: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **meta_data_name** | **string**|  | 

### Return type

[**\Swagger\Client\ContentEntity\Models\MetaData**](MetaData.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getAll**
> \Swagger\Client\ContentEntity\Models\MetaData[] getAll($entity_id)

get all metadata for an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\MetadataApi();
$entity_id = "entity_id_example"; // string | 

try { 
    $result = $api_instance->getAll($entity_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MetadataApi->getAll: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 

### Return type

[**\Swagger\Client\ContentEntity\Models\MetaData[]**](MetaData.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update**
> update($entity_id, $meta_data_name, $body)

update a specific metadata entry for an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\MetadataApi();
$entity_id = "entity_id_example"; // string | 
$meta_data_name = "meta_data_name_example"; // string | 
$body = "body_example"; // string | 

try { 
    $api_instance->update($entity_id, $meta_data_name, $body);
} catch (Exception $e) {
    echo 'Exception when calling MetadataApi->update: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **meta_data_name** | **string**|  | 
 **body** | **string**|  | [optional] 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

