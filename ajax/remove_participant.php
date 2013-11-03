<?require_once("../conf/config.php");
	if(isset($_POST['Participant'])){
		if($participant->removeParticipant($_POST['Participant']) == 1)
			echo "SUCCESS";
		else
			echo "FAILED";
	}
	echo "FAILED";
?>
