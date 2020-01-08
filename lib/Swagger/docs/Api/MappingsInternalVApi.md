# Swagger\Client\MappingsInternalVApi

All URIs are relative to *https://localhost/article-video*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getMediaIdsForProduct**](MappingsInternalVApi.md#getMediaIdsForProduct) | **GET** /internal/v2/mappings/{product} | 


# **getMediaIdsForProduct**
> \Swagger\Client\ArticleVideo\Models\MediaIdsForProductResponse getMediaIdsForProduct($product)



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

$api_instance = new Swagger\Client\Api\MappingsInternalVApi();
$product = "product_example"; // string | 

try {
    $result = $api_instance->getMediaIdsForProduct($product);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MappingsInternalVApi->getMediaIdsForProduct: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **product** | **string**|  |

### Return type

[**\Swagger\Client\ArticleVideo\Models\MediaIdsForProductResponse**](../Model/MediaIdsForProductResponse.md)

### Authorization

[access_token](../../README.md#access_token), [user_id](../../README.md#user_id)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

