<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET['id']) && !isset($_POST['id'])) {
	echo "Error: No tournament ID supplied";
} else {

	$t_id = (isset($_GET['id']))?$_GET['id']:$_POST['id'];

	if(isset($_POST['submit'])){
		echo "In the submit if<br>";
		$db->insert("Participant", "Name", "'$_POST[name]'");
		$id = $db->lastInsertedId(); // get ParticipantID
		$db->insert("Entry", "TournamentID, ParticipantID", "$t_id, $id");
	}?>
      <div class="row-fluid">
        <div class="span6">
	<?
	$result = $db->select("Tournament", "Name, Description, Rules",
		"TournamentID = $t_id")[0]; // get name, description, and rules
	echo "<h1>" . $result['Name'] . "</h1>"; // name
	echo "<p>" . $result['Description'] . "</p>"; // description
	echo "<h3>Rules:</h3><p>" . $result['Rules'] . "</p>";

	$participants =$tournament->getParticipants($t_id);
	// print_r($participants);
	if(length($participants)>0){
		echo "<h3>Current Participants:</h3><ol>";
		foreach($participants as $val){
			echo "<li>";
			echo $val['Name'];
			echo "</li>\n";
		}	
	}
	else{
		echo "<h3>No Participants</h3>"
	}
	
	echo "</ol></div><div class='span6'>";
}
?>


<form action="register.php" method="POST">
  <fieldset>
    <h2 class="form-signin-heading">Add Player</h2>
   	<input type="hidden" name="id" value="<? echo $t_id; ?>"/>
	<input name="name" type="text" placeholder="Participant Name"/>
	<input class="btn btn-primary btn-large" type="submit" name="submit" value="Submit Entry" />
  </fieldset>
</form>
</div>
<div class='span6'>
<form action="edit_tournament.php" method="POST">
  <fieldset>
    <h2 class="form-signin-heading"><? echo $result['Name']; ?></h2>
   	<input type="hidden" name="id" value="<? echo $t_id; ?>"/>
	<input name="tournament_name" type="text" placeholder="<? echo $result['Name']; ?>"/>
	<input class="btn btn-primary btn-large" type="submit" name="submit" value="Submit Entry" />
  </fieldset>
</form>
</div>
</div>
<?require_once("inc/footer.php")?>
