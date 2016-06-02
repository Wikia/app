# Swagger\Client\UserAvatarsApi

All URIs are relative to *https://localhost/*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteUserAvatar**](UserAvatarsApi.md#deleteUserAvatar) | **DELETE** /user/{userId}/avatar | Delete the users avatar
[**getAvatarForUser**](UserAvatarsApi.md#getAvatarForUser) | **GET** /user/{userId}/avatar | Get an user avatar
[**postUserAvatar**](UserAvatarsApi.md#postUserAvatar) | **POST** /user/{userId}/avatar | Creates an avatar for a user
[**putUserAvatar**](UserAvatarsApi.md#putUserAvatar) | **PUT** /user/{userId}/avatar | Create an avatar for a user, potentially overwriting any existing one


# **deleteUserAvatar**
> deleteUserAvatar($user_id)

Delete the users avatar



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\UserAvatarsApi();
$user_id = "user_id_example"; // string | 

try { 
    $api_instance->deleteUserAvatar($user_id);
} catch (Exception $e) {
    echo 'Exception when calling UserAvatarsApi->deleteUserAvatar: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**|  | 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getAvatarForUser**
> getAvatarForUser($user_id, $if_none_match)

Get an user avatar

For external image retrieval Thumbnailer should be used, which supports image downscaling

### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\UserAvatarsApi();
$user_id = "user_id_example"; // string | 
$if_none_match = "if_none_match_example"; // string | 

try { 
    $api_instance->getAvatarForUser($user_id, $if_none_match);
} catch (Exception $e) {
    echo 'Exception when calling UserAvatarsApi->getAvatarForUser: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**|  | 
 **if_none_match** | **string**|  | [optional] 

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **postUserAvatar**
> \Swagger\Client\User\Avatars\Models\UserAvatarCreatedResult postUserAvatar($user_id, $file)

Creates an avatar for a user



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\UserAvatarsApi();
$user_id = "user_id_example"; // string | 
$file = "/path/to/file.txt"; // \SplFileObject | 

try { 
    $result = $api_instance->postUserAvatar($user_id, $file);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserAvatarsApi->postUserAvatar: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**|  | 
 **file** | **\SplFileObject**|  | [optional] 

### Return type

[**\Swagger\Client\User\Avatars\Models\UserAvatarCreatedResult**](UserAvatarCreatedResult.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: multipart/form-data
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **putUserAvatar**
> \Swagger\Client\User\Avatars\Models\UserAvatarCreatedResult putUserAvatar($user_id, $file)

Create an avatar for a user, potentially overwriting any existing one



### Example 
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$api_instance = new Swagger\Client\Api\UserAvatarsApi();
$user_id = "user_id_example"; // string | 
$file = "/path/to/file.txt"; // \SplFileObject | 

try { 
    $result = $api_instance->putUserAvatar($user_id, $file);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserAvatarsApi->putUserAvatar: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**|  | 
 **file** | **\SplFileObject**|  | [optional] 

### Return type

[**\Swagger\Client\User\Avatars\Models\UserAvatarCreatedResult**](UserAvatarCreatedResult.md)

### Authorization

No authorization required

### HTTP reuqest headers

 - **Content-Type**: multipart/form-data
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

