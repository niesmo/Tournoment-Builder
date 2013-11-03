<?include("conf/config.php");
if(isset($_POST["result"]) && isset($_POST["MatchID")) {
	db->update("`Match`", "Result=$_POST[result]", "MatchID=$_POST[MatchID]");
}?>