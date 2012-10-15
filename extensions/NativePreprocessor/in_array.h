#include <stdbool.h>

bool zval_in_array(const zval* value, const HashTable* array, bool strict);
bool str_in_array(const char* string, int string_len, const HashTable* array, bool strict);

