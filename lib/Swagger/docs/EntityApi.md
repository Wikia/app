# Swagger\Client\EntityApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create**](EntityApi.md#create) | **POST** /entity | creates a new entity given the definition
[**delete**](EntityApi.md#delete) | **DELETE** /entity/{entityId} | deletes an entity
[**getById**](EntityApi.md#getById) | **GET** /entity/{entityId} | gets an entity by its id
[**update**](EntityApi.md#update) | **POST** /entity/{entityId} | updates an entity with a new definition


# **create**
> \Swagger\Client\ContentEntity\Models\Entity create($name, $classification)

creates a new entity given the definition



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\EntityApi();
$name = "name_example"; // string | 
$classification = "classification_example"; // string | 

try { 
    $result = $api_instance->create($name, $classification);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EntityApi->create: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **name** | **string**|  | [optional] 
 **classification** | **string**|  | [optional] 

### Return type

[**\Swagger\Client\ContentEntity\Models\Entity**](Entity.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: application/x-www-form-urlencoded
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **delete**
> delete($entity_id)

deletes an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\EntityApi();
$entity_id = "entity_id_example"; // string | 

try { 
    $api_instance->delete($entity_id);
} catch (Exception $e) {
    echo 'Exception when calling EntityApi->delete: ', $e->getMessage(), "\n";
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

# **getById**
> \Swagger\Client\ContentEntity\Models\Entity getById($entity_id)

gets an entity by its id



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\EntityApi();
$entity_id = "entity_id_example"; // string | 

try { 
    $result = $api_instance->getById($entity_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EntityApi->getById: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 

### Return type

[**\Swagger\Client\ContentEntity\Models\Entity**](Entity.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update**
> update($entity_id, $name, $classification)

updates an entity with a new definition



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\EntityApi();
$entity_id = "entity_id_example"; // string | 
$name = "name_example"; // string | 
$classification = "classification_example"; // string | 

try { 
    $api_instance->update($entity_id, $name, $classification);
} catch (Exception $e) {
    echo 'Exception when calling EntityApi->update: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **name** | **string**|  | [optional] 
 **classification** | **string**|  | [optional] 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

