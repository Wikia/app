# Swagger\Client\MappingsApi

All URIs are relative to *https://localhost/article-video*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createMapping**](MappingsApi.md#createMapping) | **POST** /mappings | 
[**deleteItem**](MappingsApi.md#deleteItem) | **DELETE** /mappings/{product}/{id} | 
[**getMappings**](MappingsApi.md#getMappings) | **GET** /mappings | 


# **createMapping**
> createMapping($body)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: access_token
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-AccessToken', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-AccessToken', 'Bearer');
// Configure API key authorization: user_id
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-UserId', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-UserId', 'Bearer');

$api_instance = new Swagger\Client\Api\MappingsApi();
$body = new \Swagger\Client\ArticleVideo\Models\MappingDto(); // \Swagger\Client\ArticleVideo\Models\MappingDto | 

try {
    $api_instance->createMapping($body);
} catch (Exception $e) {
    echo 'Exception when calling MappingsApi->createMapping: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\ArticleVideo\Models\MappingDto**](../Model/\Swagger\Client\ArticleVideo\Models\MappingDto.md)|  | [optional]

### Return type

void (empty response body)

### Authorization

[access_token](../../README.md#access_token), [user_id](../../README.md#user_id)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteItem**
> deleteItem($product, $id)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: access_token
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-AccessToken', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-AccessToken', 'Bearer');
// Configure API key authorization: user_id
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-UserId', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-UserId', 'Bearer');

$api_instance = new Swagger\Client\Api\MappingsApi();
$product = "product_example"; // string | 
$id = "id_example"; // string | 

try {
    $api_instance->deleteItem($product, $id);
} catch (Exception $e) {
    echo 'Exception when calling MappingsApi->deleteItem: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **product** | **string**|  |
 **id** | **string**|  |

### Return type

void (empty response body)

### Authorization

[access_token](../../README.md#access_token), [user_id](../../README.md#user_id)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getMappings**
> \Swagger\Client\ArticleVideo\Models\Mapping[] getMappings()



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: access_token
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-AccessToken', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-AccessToken', 'Bearer');
// Configure API key authorization: user_id
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-UserId', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-UserId', 'Bearer');

$api_instance = new Swagger\Client\Api\MappingsApi();

try {
    $result = $api_instance->getMappings();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MappingsApi->getMappings: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Swagger\Client\ArticleVideo\Models\Mapping[]**](../Model/Mapping.md)

### Authorization

[access_token](../../README.md#access_token), [user_id](../../README.md#user_id)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

