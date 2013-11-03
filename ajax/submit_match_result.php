<?include("../conf/config.php");

if(isset($_POST["result"]) && isset($_POST["MatchID")) {
	print_r($_POST);	
	//if($db->update("`Match`", "Result = '$_POST[result]'", " MatchID = $_POST[MatchID]") == 1)
	 // echo "SUCCESS";
	//else
	 // echo "FAILED";
}
?>
