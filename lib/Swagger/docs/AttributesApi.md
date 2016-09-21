# Swagger\Client\AttributesApi

All URIs are relative to *https://localhost/user-attribute*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getAttributes**](AttributesApi.md#getAttributes) | **GET** /attr | Returns all available attributes for any user
[**getUserAttributeByName**](AttributesApi.md#getUserAttributeByName) | **GET** /attr/{name} | Returns the value of the given attribute


# **getAttributes**
> \Swagger\Client\User\Attributes\Models\AllAttributesHalResponse getAttributes()

Returns all available attributes for any user



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\AttributesApi();

try { 
    $result = $api_instance->getAttributes();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AttributesApi->getAttributes: ', $e->getMessage(), "\n";
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Swagger\Client\User\Attributes\Models\AllAttributesHalResponse**](AllAttributesHalResponse.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/hal+json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getUserAttributeByName**
> \Swagger\Client\User\Attributes\Models\AttributeHalResponse getUserAttributeByName($name)

Returns the value of the given attribute

Returns the value of the specified attribute for the specified user

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\AttributesApi();
$name = "name_example"; // string | name of the user attribute

try { 
    $result = $api_instance->getUserAttributeByName($name);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AttributesApi->getUserAttributeByName: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **name** | **string**| name of the user attribute | 

### Return type

[**\Swagger\Client\User\Attributes\Models\AttributeHalResponse**](AttributeHalResponse.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/hal+json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

