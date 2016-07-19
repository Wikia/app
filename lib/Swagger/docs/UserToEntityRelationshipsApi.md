# Swagger\Client\UserToEntityRelationshipsApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create**](UserToEntityRelationshipsApi.md#create) | **PUT** /user/{userId}/entity/{entityId} | creates a relationship from a piece of content to an entity
[**getRelatedEntities**](UserToEntityRelationshipsApi.md#getRelatedEntities) | **GET** /user/{userId} | get the entities related to a user
[**unrelate**](UserToEntityRelationshipsApi.md#unrelate) | **DELETE** /user/{userId}/entity/{entityId} | delete the relationship between a user and an entity


# **create**
> create($entity_id, $user_id)

creates a relationship from a piece of content to an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\UserToEntityRelationshipsApi();
$entity_id = "entity_id_example"; // string | 
$user_id = "user_id_example"; // string | 

try { 
    $api_instance->create($entity_id, $user_id);
} catch (Exception $e) {
    echo 'Exception when calling UserToEntityRelationshipsApi->create: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **user_id** | **string**|  | 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getRelatedEntities**
> \Swagger\Client\ContentEntity\Models\Entity[] getRelatedEntities($user_id)

get the entities related to a user



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\UserToEntityRelationshipsApi();
$user_id = "user_id_example"; // string | 

try { 
    $result = $api_instance->getRelatedEntities($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserToEntityRelationshipsApi->getRelatedEntities: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**|  | 

### Return type

[**\Swagger\Client\ContentEntity\Models\Entity[]**](Entity.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **unrelate**
> unrelate($entity_id, $user_id)

delete the relationship between a user and an entity



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\UserToEntityRelationshipsApi();
$entity_id = "entity_id_example"; // string | 
$user_id = "user_id_example"; // string | 

try { 
    $api_instance->unrelate($entity_id, $user_id);
} catch (Exception $e) {
    echo 'Exception when calling UserToEntityRelationshipsApi->unrelate: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **entity_id** | **string**|  | 
 **user_id** | **string**|  | 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

