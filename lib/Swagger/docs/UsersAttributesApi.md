# Swagger\Client\UsersAttributesApi

All URIs are relative to *https://localhost/user-attribute*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteAttribute**](UsersAttributesApi.md#deleteAttribute) | **DELETE** /user/{userId}/attr/{attrName} | Deletes attribute for this user
[**getAllAttributes**](UsersAttributesApi.md#getAllAttributes) | **GET** /user/{userId} | Returns all available attributes for the specified userId
[**getAllAttributesForMultipleUsers**](UsersAttributesApi.md#getAllAttributesForMultipleUsers) | **GET** /user/bulk | Returns all available attributes for the specified list of users
[**getAttribute**](UsersAttributesApi.md#getAttribute) | **GET** /user/{userId}/attr/{attrName} | Returns specific attribute for specified user
[**saveAttribute**](UsersAttributesApi.md#saveAttribute) | **PUT** /user/{userId}/attr/{attrName} | Saves an attribute for a specified user
[**saveAttributes**](UsersAttributesApi.md#saveAttributes) | **PATCH** /user/{userId} | Saves multiple attributes for a specified user


# **deleteAttribute**
> deleteAttribute($user_id, $attr_name)

Deletes attribute for this user



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: access_token
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-AccessToken', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-AccessToken', 'BEARER');
// Configure API key authorization: user_id
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-UserId', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-UserId', 'BEARER');

$api_instance = new Swagger\Client\Api\UsersAttributesApi();
$user_id = "user_id_example"; // string | id of the user to be modified
$attr_name = "attr_name_example"; // string | Name of attribute to be deleted for specified user

try { 
    $api_instance->deleteAttribute($user_id, $attr_name);
} catch (Exception $e) {
    echo 'Exception when calling UsersAttributesApi->deleteAttribute: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| id of the user to be modified | 
 **attr_name** | **string**| Name of attribute to be deleted for specified user | 

### Return type

void (empty response body)

### Authorization

[access_token](../README.md#access_token), [user_id](../README.md#user_id)

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getAllAttributes**
> \Swagger\Client\User\Attributes\Models\AllUserAttributesHalResponse getAllAttributes($user_id)

Returns all available attributes for the specified userId



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: access_token
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-AccessToken', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-AccessToken', 'BEARER');
// Configure API key authorization: user_id
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-UserId', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-UserId', 'BEARER');

$api_instance = new Swagger\Client\Api\UsersAttributesApi();
$user_id = "user_id_example"; // string | The ID of the user

try { 
    $result = $api_instance->getAllAttributes($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersAttributesApi->getAllAttributes: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The ID of the user | 

### Return type

[**\Swagger\Client\User\Attributes\Models\AllUserAttributesHalResponse**](AllUserAttributesHalResponse.md)

### Authorization

[access_token](../README.md#access_token), [user_id](../README.md#user_id)

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/hal+json; charset=UTF-8

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getAllAttributesForMultipleUsers**
> \Swagger\Client\User\Attributes\Models\UsersWithAttributes getAllAttributesForMultipleUsers($id)

Returns all available attributes for the specified list of users



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: access_token
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-AccessToken', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-AccessToken', 'BEARER');
// Configure API key authorization: user_id
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-UserId', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-UserId', 'BEARER');

$api_instance = new Swagger\Client\Api\UsersAttributesApi();
$id = array("id_example"); // string[] | 

try { 
    $result = $api_instance->getAllAttributesForMultipleUsers($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersAttributesApi->getAllAttributesForMultipleUsers: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | [**string[]**](string.md)|  | [optional] 

### Return type

[**\Swagger\Client\User\Attributes\Models\UsersWithAttributes**](UsersWithAttributes.md)

### Authorization

[access_token](../README.md#access_token), [user_id](../README.md#user_id)

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/hal+json; charset=UTF-8

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getAttribute**
> \Swagger\Client\User\Attributes\Models\UserAttributeHalResponse getAttribute($user_id, $attr_name)

Returns specific attribute for specified user

Returns the requested attribute value for the requested userId

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: access_token
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-AccessToken', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-AccessToken', 'BEARER');
// Configure API key authorization: user_id
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-UserId', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-UserId', 'BEARER');

$api_instance = new Swagger\Client\Api\UsersAttributesApi();
$user_id = "user_id_example"; // string | The userId of the user
$attr_name = "attr_name_example"; // string | The name of the attribute to be retrieved

try { 
    $result = $api_instance->getAttribute($user_id, $attr_name);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersAttributesApi->getAttribute: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The userId of the user | 
 **attr_name** | **string**| The name of the attribute to be retrieved | 

### Return type

[**\Swagger\Client\User\Attributes\Models\UserAttributeHalResponse**](UserAttributeHalResponse.md)

### Authorization

[access_token](../README.md#access_token), [user_id](../README.md#user_id)

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/hal+json; charset=UTF-8

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **saveAttribute**
> \Swagger\Client\User\Attributes\Models\UserAttributeHalResponse saveAttribute($user_id, $attr_name, $value)

Saves an attribute for a specified user



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: access_token
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-AccessToken', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-AccessToken', 'BEARER');
// Configure API key authorization: user_id
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-UserId', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-UserId', 'BEARER');

$api_instance = new Swagger\Client\Api\UsersAttributesApi();
$user_id = "user_id_example"; // string | The id of the user
$attr_name = "attr_name_example"; // string | The name of the attribute to be saved
$value = "value_example"; // string | Value for the specified attribute

try { 
    $result = $api_instance->saveAttribute($user_id, $attr_name, $value);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersAttributesApi->saveAttribute: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The id of the user | 
 **attr_name** | **string**| The name of the attribute to be saved | 
 **value** | **string**| Value for the specified attribute | 

### Return type

[**\Swagger\Client\User\Attributes\Models\UserAttributeHalResponse**](UserAttributeHalResponse.md)

### Authorization

[access_token](../README.md#access_token), [user_id](../README.md#user_id)

### HTTP reuqest headers

 - **Content-Type**: application/x-www-form-urlencoded
 - **Accept**: application/hal+json; charset=UTF-8

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **saveAttributes**
> \Swagger\Client\User\Attributes\Models\UserAttributeHalResponse saveAttributes($user_id)

Saves multiple attributes for a specified user

This operation is Atomic - partial updates are not possible. When passing not valid attribute, entire operation will be cancelled. The attributes to be updated are sent as a form encoded HashMap where the key is the attribute name and the value is the attribute value. Eg 'location=SanFrancisco&bio=NewBio'

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: access_token
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-AccessToken', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-AccessToken', 'BEARER');
// Configure API key authorization: user_id
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-Wikia-UserId', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. BEARER) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-Wikia-UserId', 'BEARER');

$api_instance = new Swagger\Client\Api\UsersAttributesApi();
$user_id = "user_id_example"; // string | The id of the user

try { 
    $result = $api_instance->saveAttributes($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersAttributesApi->saveAttributes: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The id of the user | 

### Return type

[**\Swagger\Client\User\Attributes\Models\UserAttributeHalResponse**](UserAttributeHalResponse.md)

### Authorization

[access_token](../README.md#access_token), [user_id](../README.md#user_id)

### HTTP reuqest headers

 - **Content-Type**: application/x-www-form-urlencoded
 - **Accept**: application/hal+json; charset=UTF-8

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

