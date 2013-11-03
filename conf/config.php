<?
session_start();
error_reporting(E_ALL);
function __autoload($class)
{
    require_once (__DIR__ . "/../classes/" . $class . "_class.php");
}
require_once(__DIR__ . "/../inc/functions.php");


define ( DB_USER, "root" );
define ( DB_PASS, "1yy5u8Uwmy1go57h" );
define ( DB_HOST, "localhost" );
define ( DB_DB, "Tournament" );

$db = new Database ( DB_HOST, DB_USER, DB_PASS, DB_DB );
if (!$db->isConnected())
    die("DATABASE IS NOT CONNECTED");
//else
//    echo "<h1>We are connected</h1>";
$tournament = new Tournament($db);
?>
