# Swagger\Client\ReverseLookupApi

All URIs are relative to *https://localhost/user-preference*

Method | HTTP request | Description
------------- | ------------- | -------------
[**findUsersWithGlobalPreference**](ReverseLookupApi.md#findUsersWithGlobalPreference) | **GET** /reverse-lookup/global/{preferenceName}/users | Finds all users that has the global preference set to a value
[**findWikisWithLocalPreference**](ReverseLookupApi.md#findWikisWithLocalPreference) | **GET** /reverse-lookup/local/{preferenceName}/wikis | finds wikis where at least one user has a local preference set to a value


# **findUsersWithGlobalPreference**
> findUsersWithGlobalPreference($preference_name, $value, $limit, $user_id_continue)

Finds all users that has the global preference set to a value



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\ReverseLookupApi();
$preference_name = "preference_name_example"; // string | The preference name to search for, if not value provided it will return all users that have the named preference
$value = "value_example"; // string | The preference value (optionally provided)
$limit = 1000; // int | How many results to return
$user_id_continue = 0; // int | Find results after userId (results returned in ascending order)

try {
    $api_instance->findUsersWithGlobalPreference($preference_name, $value, $limit, $user_id_continue);
} catch (Exception $e) {
    echo 'Exception when calling ReverseLookupApi->findUsersWithGlobalPreference: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **preference_name** | **string**| The preference name to search for, if not value provided it will return all users that have the named preference |
 **value** | **string**| The preference value (optionally provided) | [optional]
 **limit** | **int**| How many results to return | [optional] [default to 1000]
 **user_id_continue** | **int**| Find results after userId (results returned in ascending order) | [optional] [default to 0]

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findWikisWithLocalPreference**
> string[] findWikisWithLocalPreference($preference_name, $value)

finds wikis where at least one user has a local preference set to a value



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\ReverseLookupApi();
$preference_name = "preference_name_example"; // string | The preference name to search for
$value = "1"; // string | The preference value

try {
    $result = $api_instance->findWikisWithLocalPreference($preference_name, $value);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ReverseLookupApi->findWikisWithLocalPreference: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **preference_name** | **string**| The preference name to search for |
 **value** | **string**| The preference value | [optional] [default to 1]

### Return type

**string[]**

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

