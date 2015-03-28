<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

switch (ENVIRONMENT) {
	case 'development':
		$active_group = 'development';
		break;
	case 'testing':
		$active_group = 'testing';
		break;
	default:
		$active_group = 'production';
}

$active_record = TRUE;

$db['development']['hostname'] = 'localhost';
$db['development']['username'] = 'my-bills';
$db['development']['password'] = 'password';
$db['development']['database'] = 'my-bills';
$db['development']['db_debug'] = TRUE;
$db['development']['stricton'] = TRUE;

/*
$db['testing']['hostname'] = 'mysql3.000webhost.com';
$db['testing']['username'] = 'a8228193_mybills';
$db['testing']['password'] = 'B4YU5BZ*%rVwntNTrTp$';
$db['testing']['database'] = 'a8228193_mybills';
$db['testing']['db_debug'] = FALSE;
$db['testing']['stricton'] = FALSE;
*/

$db['testing']['hostname'] = 'localhost';
$db['testing']['username'] = 'cwx10ho2_mybills';
$db['testing']['password'] = '75HKxPWtV5CeAIoY';
$db['testing']['database'] = 'cwx10ho2_mybills';
$db['testing']['db_debug'] = FALSE;
$db['testing']['stricton'] = FALSE;

$db['production']['hostname'] = 'localhost';
$db['production']['username'] = 'dezgo_mybills';
$db['production']['password'] = 'styvF&1AjByjru0cxFc4';
$db['production']['database'] = 'dezgo_mybills';
$db['production']['db_debug'] = FALSE;
$db['production']['stricton'] = FALSE;

$db[$active_group]['dbdriver'] = 'mysql';
$db[$active_group]['dbprefix'] = '';
$db[$active_group]['pconnect'] = TRUE;
$db[$active_group]['cache_on'] = FALSE;
$db[$active_group]['cachedir'] = '';
$db[$active_group]['char_set'] = 'utf8';
$db[$active_group]['dbcollat'] = 'utf8_general_ci';
$db[$active_group]['swap_pre'] = '';
$db[$active_group]['autoinit'] = TRUE;

/*
 * Debug connection issues with this code
 */

/*
echo '<pre>';
print_r($db['default']);
echo '</pre>';

echo 'Connecting to database: ' .$db['default']['database'];
$dbh=mysql_connect
(
		$db['default']['hostname'],
		$db['default']['username'],
		$db['default']['password'])
		or die('Cannot connect to the database because: ' . mysql_error());
mysql_select_db ($db['default']['database']);

echo '<br />   Connected OK:'  ;
die( 'file: ' .__FILE__ . ' Line: ' .__LINE__);
*/

/* End of file database.php */
/* Location: ./application/config/database.php */