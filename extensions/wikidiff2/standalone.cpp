#include <stdio.h>
#include <sys/stat.h>
#include "wikidiff2.h"

/**
 *  Standalone (i.e. PHP-free) application to produce HTML-formatted word-level diffs from two files
 */


void report_file_error(char* filename) 
{
	char errorFormat[] = "Error opening file \"%s\"";
	char * error = new char[strlen(filename) + sizeof(errorFormat)];
	sprintf(error, errorFormat, filename);
	perror(error);
	delete[] error;
	exit(1);
}

char* file_get_contents(char* filename) 
{
	struct stat s;
	char* buffer;
	if (stat(filename, &s)) {
		report_file_error(filename);
	}
	FILE * file = fopen(filename, "rb");
	if (!file) {
		report_file_error(filename);
	}
	buffer = new char[s.st_size + 1];
	size_t bytes_read = fread(buffer, 1, s.st_size, file);
	buffer[bytes_read] = '\0';
	fclose(file);
	return buffer;
}

int main(int argc, char** argv) 
{
	if (argc != 3) {
		printf("Usage: wikidiff2 <file1> <file2>\n");
		exit(1);
	}

	char *buffer1 = file_get_contents(argv[1]);
	char *buffer2 = file_get_contents(argv[2]);
	const char *diff = wikidiff2_do_diff(buffer1, buffer2, 2);
	fputs(diff, stdout);
	return 0;
}


