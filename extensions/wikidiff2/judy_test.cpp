#include <iostream>
#include "JudyHS.h"

using namespace std;

int main(int argc, char** argv)
{
	JudyHS<string> a;
	a["one"] = "1";
	a["two"] = "2";
	a["three"] = "3";
	cout << a["one"] << " " << a["two"] << " " << a["three"] << endl;

	cout << "Memleak test: add/delete" << endl;
	for (int i=0; i<1000000; i++) {
		a["test"] = "test";
		a.Delete("test");
	}

	cout << "Memleak test: add/add" << endl;
	for (int i=0; i<1000000; i++) {
		a["test"] = "test";
	}

	cout << "Memleak test: FreeArray" << endl;
	
	for (int i=0; i<1000000; i++) {
		JudyHS<string> b;
		b["Hello"] = "test";
	}
	cout << "Done, exiting" << endl;
	
	return 0;
}

