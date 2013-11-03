<? include('../conf/config.php');
if(isset($_GET['round']) && isset($_GET['id'])) {
	echo "found data from request";
} else echo "round and/or id not found in request!";
?>
