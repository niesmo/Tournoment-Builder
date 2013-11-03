<?include("../conf/config.php");
//print_r($_POST);
if(isset($_POST['result']) && isset($_POST['MatchID'])) {
	//print_r($_POST);
	//echo $tournament->submitMatch($_POST['MatchID']);
	if($db->update("`Match`", "Result = '$_POST[result]'", " MatchID = $_POST[MatchID]") == 1)
	 	echo "SUCCESS";
	else
	 	echo "FAILED";
}
?>
