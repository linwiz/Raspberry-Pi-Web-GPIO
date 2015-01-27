#include <stdio.h>
#include <mysql.h>
#include <string>

class FFError {
public:
	std::string Label;

	FFError( ) { Label = (char *)"Generic Error"; }
	FFError( char *message ) { Label = message; }
	~FFError() { }
	inline const char*   GetMessage  ( void )   { return Label.c_str(); }
};

using namespace std;

string hostName = "localhost";
string userId   = "user";
string password = "pass";
string DB   = "gpio";

int mysql_log_insert(string datas, string str) {
	MYSQL  *MySQLConRet;
	MYSQL  *MySQLConnection = NULL;

	MySQLConnection = mysql_init( NULL );

	try {
		MySQLConRet = mysql_real_connect( MySQLConnection, hostName.c_str(), userId.c_str(), password.c_str(), DB.c_str(), 0, NULL, 0 );
		if ( MySQLConRet == NULL )
			throw FFError( (char*) mysql_error(MySQLConnection) );

	} catch ( FFError e ) {
		printf("%s\n",e.Label.c_str());
		return 1;
	}
	int mysqlStatus = 0;
	MYSQL_RES  *mysqlResult = NULL;
	try {
		string sqlInsStatement = "INSERT INTO log (data) VALUES ('" + datas + str + "')";
		mysqlStatus = mysql_query( MySQLConnection, sqlInsStatement.c_str() );
		if (mysqlStatus) {
			throw FFError( (char*)mysql_error(MySQLConnection) );
		}
} catch ( FFError e ) {
		printf("%s\n",e.Label.c_str());
		mysql_close(MySQLConnection);
		return 1;
	}
	if(mysqlResult) {
		mysql_free_result(mysqlResult);
		mysqlResult = NULL;
	}

	// --------------------------------------------------------------------
	// Close datbase connection
	mysql_close(MySQLConnection);
	return 0;
}

int mysql_get_revision() {
	MYSQL  *MySQLConRet;
	MYSQL  *MySQLConnection = NULL;

	MySQLConnection = mysql_init( NULL );

	try {
		MySQLConRet = mysql_real_connect( MySQLConnection, hostName.c_str(), userId.c_str(), password.c_str(), DB.c_str(), 0, NULL, 0 );
		if ( MySQLConRet == NULL )
			throw FFError( (char*) mysql_error(MySQLConnection) );

	}
	catch ( FFError e ) {
		printf("%s\n",e.Label.c_str());
		return 1;
	}

	int mysqlStatus = 0;
	MYSQL_RES  *mysqlResult = NULL;

	// --------------------------------------------------------------------
	// Perform a SQL SELECT and retrieve data
	MYSQL_ROW mysqlRow;
	MYSQL_FIELD *mysqlFields;
	my_ulonglong numRows;
	unsigned int numFields;
	int intRevision;

	try {
		string sqlSelStatement = "SELECT piRevision FROM config WHERE configVersion=1";
		mysqlStatus = mysql_query( MySQLConnection, sqlSelStatement.c_str() );

		if (mysqlStatus)
			throw FFError( (char*)mysql_error(MySQLConnection) );
		else
			mysqlResult = mysql_store_result(MySQLConnection); // Get the Result Set

		// print query results
		while(mysqlRow = mysql_fetch_row(mysqlResult)) { // row pointer in the result set
			for(int ii=0; ii < numFields; ii++) {
				char* revision = mysqlRow[ii];
				stringstream strRevision;
				strRevision << revision;
				strRevision >> intRevision;
			}
		}

		if(mysqlResult) {
			mysql_free_result(mysqlResult);
			mysqlResult = NULL;
		}
	}
	catch ( FFError e ) {
		printf("%s\n",e.Label.c_str());
		mysql_close(MySQLConnection);
		return 1;
	}

	// --------------------------------------------------------------------
	// Close datbase connection
	mysql_close(MySQLConnection);
	return intRevision;
}
