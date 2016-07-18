# Swagger\Client\TCSStatsApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getClassifiedTemplatesByProviderCount**](TCSStatsApi.md#getClassifiedTemplatesByProviderCount) | **GET** /stats/{provider} | Returns number of classified templates on all wikis by provider
[**getClassifiedTemplatesByProviderOnWikiCount**](TCSStatsApi.md#getClassifiedTemplatesByProviderOnWikiCount) | **GET** /stats/{wiki_id}/{provider} | Returns number of classified templates on given wiki by provider
[**getClassifiedTemplatesCount**](TCSStatsApi.md#getClassifiedTemplatesCount) | **GET** /stats | Returns number of classified templates on all wikis
[**getClassifiedTemplatesOnWikiCount**](TCSStatsApi.md#getClassifiedTemplatesOnWikiCount) | **GET** /stats/{wiki_id} | Returns number of classified templates on given wiki


# **getClassifiedTemplatesByProviderCount**
> \Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeStats getClassifiedTemplatesByProviderCount($provider)

Returns number of classified templates on all wikis by provider

Returns number of classified templates on all wikis by provider

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\TCSStatsApi();
$provider = "provider_example"; // string | Provider

try { 
    $result = $api_instance->getClassifiedTemplatesByProviderCount($provider);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TCSStatsApi->getClassifiedTemplatesByProviderCount: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **provider** | **string**| Provider | 

### Return type

[**\Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeStats**](TemplateTypeStats.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getClassifiedTemplatesByProviderOnWikiCount**
> \Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeStats getClassifiedTemplatesByProviderOnWikiCount($wiki_id, $provider)

Returns number of classified templates on given wiki by provider

Returns number of classified templates on given wiki by provider

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\TCSStatsApi();
$wiki_id = 56; // int | Wikia ID
$provider = "provider_example"; // string | Provider

try { 
    $result = $api_instance->getClassifiedTemplatesByProviderOnWikiCount($wiki_id, $provider);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TCSStatsApi->getClassifiedTemplatesByProviderOnWikiCount: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wiki_id** | **int**| Wikia ID | 
 **provider** | **string**| Provider | 

### Return type

[**\Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeStats**](TemplateTypeStats.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getClassifiedTemplatesCount**
> \Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeStats getClassifiedTemplatesCount()

Returns number of classified templates on all wikis

Returns number of classified templates on all wikis

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\TCSStatsApi();

try { 
    $result = $api_instance->getClassifiedTemplatesCount();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TCSStatsApi->getClassifiedTemplatesCount: ', $e->getMessage(), "\n";
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeStats**](TemplateTypeStats.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getClassifiedTemplatesOnWikiCount**
> \Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeStats getClassifiedTemplatesOnWikiCount($wiki_id)

Returns number of classified templates on given wiki

Returns number of classified templates on given wiki

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\TCSStatsApi();
$wiki_id = 56; // int | Wikia ID

try { 
    $result = $api_instance->getClassifiedTemplatesOnWikiCount($wiki_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TCSStatsApi->getClassifiedTemplatesOnWikiCount: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wiki_id** | **int**| Wikia ID | 

### Return type

[**\Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeStats**](TemplateTypeStats.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

