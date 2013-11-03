<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET['id'])) {
	echo "Error: No tournament ID supplied";
} else {

	$t_id = $_GET['id'];

?>
    <div class="row-fluid">
    <div class="span12">
	<?
	$result = $db->select("Tournament", "*",
		"TournamentID = $t_id")[0]; // get name, description, and rules
	echo "<h1>" . $result['Name'] . "</h1>"; // name
	echo "<p>" . $result['Description'] . "</p>"; // description
	echo "<h3>Rules:</h3><p>" . $result['Rules'] . "</p>";

	$participants =$tournament->getParticipants($t_id);
	$matches =$tournament->getMatches($t_id);
	print_r($participants);
	if(count($participants)>0){
		echo "<h3>Current Participants:</h3><ol>";
		foreach($participants as $val){
			echo "<li>";
			echo $val['Name'];
			echo "</li>\n";
		}	
	}
	else{
		echo "<h3>No Participants</h3>";
	}
	
	echo "</ol></div><div class='span6'>";
}
?>

</div>
</div>
<?require_once("inc/footer.php")?>
