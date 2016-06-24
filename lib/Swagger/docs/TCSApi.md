# Swagger\Client\TCSApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getTemplateDetails**](TCSApi.md#getTemplateDetails) | **GET** /{wiki_id}/{page_id}/providers | Provides all template types with providers information
[**getTemplateType**](TCSApi.md#getTemplateType) | **GET** /{wiki_id}/{page_id} | Provides template type
[**getTemplateTypesOnWiki**](TCSApi.md#getTemplateTypesOnWiki) | **GET** /{wiki_id} | Provides template types on wiki
[**insertTemplateDetails**](TCSApi.md#insertTemplateDetails) | **POST** /{wiki_id}/{page_id} | Save template type data


# **getTemplateDetails**
> \Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeProvider[] getTemplateDetails($wiki_id, $page_id)

Provides all template types with providers information

Returns assigned template types with providers distinction

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\TCSApi();
$wiki_id = 56; // int | Wikia ID
$page_id = 56; // int | Article ID

try { 
    $result = $api_instance->getTemplateDetails($wiki_id, $page_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TCSApi->getTemplateDetails: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wiki_id** | **int**| Wikia ID | 
 **page_id** | **int**| Article ID | 

### Return type

[**\Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeProvider[]**](TemplateTypeProvider.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getTemplateType**
> \Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeHolder getTemplateType($wiki_id, $page_id)

Provides template type

Returns assigned template type

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\TCSApi();
$wiki_id = 56; // int | Wikia ID
$page_id = 56; // int | Article ID

try { 
    $result = $api_instance->getTemplateType($wiki_id, $page_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TCSApi->getTemplateType: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wiki_id** | **int**| Wikia ID | 
 **page_id** | **int**| Article ID | 

### Return type

[**\Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeHolder**](TemplateTypeHolder.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getTemplateTypesOnWiki**
> \Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeHolder[] getTemplateTypesOnWiki($wiki_id)

Provides template types on wiki

Returns list of template pages and their types

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\TCSApi();
$wiki_id = 56; // int | Wikia ID

try { 
    $result = $api_instance->getTemplateTypesOnWiki($wiki_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TCSApi->getTemplateTypesOnWiki: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wiki_id** | **int**| Wikia ID | 

### Return type

[**\Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeHolder[]**](TemplateTypeHolder.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **insertTemplateDetails**
> insertTemplateDetails($wiki_id, $page_id, $body)

Save template type data

Save template types with information about provider and its origin

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\TCSApi();
$wiki_id = 56; // int | Wikia ID
$page_id = 56; // int | Article ID
$body = new \Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeProvider(); // \Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeProvider | Provider data

try { 
    $api_instance->insertTemplateDetails($wiki_id, $page_id, $body);
} catch (Exception $e) {
    echo 'Exception when calling TCSApi->insertTemplateDetails: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **wiki_id** | **int**| Wikia ID | 
 **page_id** | **int**| Article ID | 
 **body** | [**\Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeProvider**](\Swagger\Client\TemplateClassification\Storage\Models\TemplateTypeProvider.md)| Provider data | [optional] 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

