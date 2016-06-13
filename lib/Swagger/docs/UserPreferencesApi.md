# Swagger\Client\UserPreferencesApi

All URIs are relative to *https://localhost/user-preference*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteUserPreferences**](UserPreferencesApi.md#deleteUserPreferences) | **DELETE** /{userId} | deletes all of a user&#39;s preferences
[**getGlobalUserPreferenceByName**](UserPreferencesApi.md#getGlobalUserPreferenceByName) | **GET** /{userId}/global/{preferenceName} | Returns single specific global preference for specific user
[**getLocalUserPreferenceByName**](UserPreferencesApi.md#getLocalUserPreferenceByName) | **GET** /{userId}/local/{preferenceName}/wikia/{wikiId} | Returns single specific local preference for specific user
[**getUserPreferences**](UserPreferencesApi.md#getUserPreferences) | **GET** /{userId} | Returns all the global user preferences for a user
[**setUserPreferences**](UserPreferencesApi.md#setUserPreferences) | **PUT** /{userId} | set a user&#39;s preferences. note - this deletes preferences not in the provided list.


# **deleteUserPreferences**
> deleteUserPreferences($user_id)

deletes all of a user's preferences



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

$api_instance = new Swagger\Client\Api\UserPreferencesApi();
$user_id = "user_id_example"; // string | The id of the user whose preferences are to be deleted

try { 
    $api_instance->deleteUserPreferences($user_id);
} catch (Exception $e) {
    echo 'Exception when calling UserPreferencesApi->deleteUserPreferences: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The id of the user whose preferences are to be deleted | 

### Return type

void (empty response body)

### Authorization

[access_token](../README.md#access_token), [user_id](../README.md#user_id)

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getGlobalUserPreferenceByName**
> \Swagger\Client\User\Preferences\Models\GlobalPreference getGlobalUserPreferenceByName($user_id, $preference_name)

Returns single specific global preference for specific user



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

$api_instance = new Swagger\Client\Api\UserPreferencesApi();
$user_id = "user_id_example"; // string | The Id of the user whose preference will be returned
$preference_name = "preference_name_example"; // string | The name of preference whose value will be returned 

try { 
    $result = $api_instance->getGlobalUserPreferenceByName($user_id, $preference_name);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserPreferencesApi->getGlobalUserPreferenceByName: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The Id of the user whose preference will be returned | 
 **preference_name** | **string**| The name of preference whose value will be returned  | 

### Return type

[**\Swagger\Client\User\Preferences\Models\GlobalPreference**](GlobalPreference.md)

### Authorization

[access_token](../README.md#access_token), [user_id](../README.md#user_id)

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getLocalUserPreferenceByName**
> \Swagger\Client\User\Preferences\Models\LocalPreference getLocalUserPreferenceByName($user_id, $wiki_id, $preference_name)

Returns single specific local preference for specific user



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

$api_instance = new Swagger\Client\Api\UserPreferencesApi();
$user_id = "user_id_example"; // string | The Id of the user whose preference will be returned
$wiki_id = 56; // int | The Id of the wiki for which preference will be returned
$preference_name = "preference_name_example"; // string | The name of preference whose value will be returned 

try { 
    $result = $api_instance->getLocalUserPreferenceByName($user_id, $wiki_id, $preference_name);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserPreferencesApi->getLocalUserPreferenceByName: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The Id of the user whose preference will be returned | 
 **wiki_id** | **int**| The Id of the wiki for which preference will be returned | 
 **preference_name** | **string**| The name of preference whose value will be returned  | 

### Return type

[**\Swagger\Client\User\Preferences\Models\LocalPreference**](LocalPreference.md)

### Authorization

[access_token](../README.md#access_token), [user_id](../README.md#user_id)

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **getUserPreferences**
> \Swagger\Client\User\Preferences\Models\UserPreferences getUserPreferences($user_id)

Returns all the global user preferences for a user

Returns a white listed subset of the users global preferences

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

$api_instance = new Swagger\Client\Api\UserPreferencesApi();
$user_id = "user_id_example"; // string | The id of the user to list the preferences

try { 
    $result = $api_instance->getUserPreferences($user_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UserPreferencesApi->getUserPreferences: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The id of the user to list the preferences | 

### Return type

[**\Swagger\Client\User\Preferences\Models\UserPreferences**](UserPreferences.md)

### Authorization

[access_token](../README.md#access_token), [user_id](../README.md#user_id)

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **setUserPreferences**
> setUserPreferences($user_id, $user_preferences)

set a user's preferences. note - this deletes preferences not in the provided list.



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

$api_instance = new Swagger\Client\Api\UserPreferencesApi();
$user_id = "user_id_example"; // string | The id of the user whose preferences are to be set
$user_preferences = new \Swagger\Client\User\Preferences\Models\UserPreferences(); // \Swagger\Client\User\Preferences\Models\UserPreferences | The user's preferences

try { 
    $api_instance->setUserPreferences($user_id, $user_preferences);
} catch (Exception $e) {
    echo 'Exception when calling UserPreferencesApi->setUserPreferences: ', $e->getMessage(), "\n";
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| The id of the user whose preferences are to be set | 
 **user_preferences** | [**\Swagger\Client\User\Preferences\Models\UserPreferences**](\Swagger\Client\User\Preferences\Models\UserPreferences.md)| The user&#39;s preferences | 

### Return type

void (empty response body)

### Authorization

[access_token](../README.md#access_token), [user_id](../README.md#user_id)

### HTTP reuqest headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

