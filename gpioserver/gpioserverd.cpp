#include <sys/types.h>
#include <sys/stat.h>
#include <stdio.h>
#include <stdlib.h>
#include <fcntl.h>
#include <errno.h>
#include <unistd.h>
#include <syslog.h>
#include <string.h>
#include <sstream>

#include "mysql.cpp"

using namespace std;

#define DAEMON_NAME "gpioserver"

int intRevision;
const char* strRevision;

void process(){
}

int main(int argc, char *argv[]) {

	//Set our Logging Mask and open the Log
	setlogmask(LOG_UPTO(LOG_NOTICE));
	openlog(DAEMON_NAME, LOG_CONS | LOG_NDELAY | LOG_PERROR | LOG_PID, LOG_USER);

	pid_t pid, sid;

	//Fork the Parent Process
	pid = fork();

	if (pid < 0) { exit(EXIT_FAILURE); }

	//We got a good pid, Close the Parent Process
	if (pid > 0) { exit(EXIT_SUCCESS); }

	pid = getpid();

	// Create PID file.
	FILE *fp = fopen("/var/run/gpioserver.pid", "w");
	if (!fp) {
		syslog(LOG_NOTICE, "Failed opening PID file.");
		exit(EXIT_FAILURE);
	}
	fprintf(fp, "%d\n", pid);
	fclose(fp);

	//Change File Mask
	umask(0);

	//Create a new Signature Id for our child
	sid = setsid();
	if (sid < 0) { exit(EXIT_FAILURE); }

	//Change Directory
	//If we cant find the directory we exit with failure.
	if ((chdir("/")) < 0) { exit(EXIT_FAILURE); }

	//Close Standard File Descriptors
	close(STDIN_FILENO);
	close(STDOUT_FILENO);
	close(STDERR_FILENO);


	// Get raspberry pi board revision
	intRevision = mysql_get_revision();
	switch (intRevision) {
	case 1:
		strRevision = "1";
		break;
	case 2:
		strRevision = "2";
		break;
	}
	std::string strRev = strRevision;
	mysql_log_insert("Revision: ", strRev);

	syslog(LOG_NOTICE, "gpioserverd Starting.");

	//----------------
	//Main Process
	//----------------
	while(true){
		//Run our Process
		process();
		//Sleep for 1 second
		sleep(1);
	}
	//Close the log
	closelog ();
}
