# Swagger\Client\AutosuggestApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**search**](AutosuggestApi.md#search) | **GET** /autosuggest/entities | finds entities with names like the provided input


# **search**
> \Swagger\Client\ContentEntity\Models\Entity[] search($q, $limit)

finds entities with names like the provided input



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\AutosuggestApi();
$q = "q_example"; // string | 
$limit = 10; // int | 

try { 
    $result = $api_instance->search($q, $limit);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AutosuggestApi->search: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **q** | **string**|  | [optional] 
 **limit** | **int**|  | [optional] [default to 10]

### Return type

[**\Swagger\Client\ContentEntity\Models\Entity[]**](Entity.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

