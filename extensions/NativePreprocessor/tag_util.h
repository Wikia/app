enum internalTags {
	None,
	includeonly,
	onlyinclude,
	noinclude,
	EndInternalTags
};

int array_max_strlen( const HashTable* array );
int identifyTag(const char* string, int string_len, const HashTable* array, enum internalTags *internalTag, char* lowername);

