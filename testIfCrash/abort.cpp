#include <cstddef>
#include <stdio.h>
#include <signal.h>

int main() {
	//raise(SIGSEGV); //segmentation fail
	raise(SIGABRT); //abnormal termination
	//raise(SIGFPE);  //floating point exception
	//raise(SIGILL);  //invalid instruction
	//raise(SIGTERM);  //termination request
	return -1;
}



