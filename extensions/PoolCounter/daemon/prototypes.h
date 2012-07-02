int listensocket(short int port) ;
void on_connect(int listener, short type, void* arg) ;
void on_client(int fd, short type, void* arg) ;
static void end(int signal) ;
void setup_signals() ;
