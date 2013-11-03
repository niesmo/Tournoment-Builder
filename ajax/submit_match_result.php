<?include("../conf/config.php");
//print_r($_POST);
if(isset($_POST['result']) && isset($_POST['MatchID'])) {
	//print_r($_POST);
	//echo $tournament->submitMatch($_POST['MatchID']);
	$tournament->submitMatch($_POST['MatchID'] , $_POST['result']);
	echo "SUCCESS";
}
?>
