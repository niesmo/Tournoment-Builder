<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET['id'])) {
	echo "Error: No tournament ID supplied";
} else {
	if($_POST['submit']){
		$db->insert("Participant", "Name", "'$_POST[name]'");
		$id = $db->lastInsertedId(); // get ParticipantID
		$db->insert("Entry", "TournamentID, ParticipantID", "$_GET[id], $id");
	}?>
      <div class="row-fluid">
        <div class="span6">
	<?
	$result = $db->select("Tournament", "Name, Description, Rules",
		"TournamentID = $_GET[id]")[0]; // get name, description, and rules
	echo "<h1>" . $result['Name'] . "</h1>"; // name
	echo "<p>" . $result['Description'] . "</p>"; // description
	echo "<h3>Rules:</h3><p>" . $result['Rules'] . "</p>";

	$participants =$tournament->getParticipants($_GET['id']);
	// print_r($participants);

	echo "<h3>Current Participants:</h3><ol>";
	foreach($participants as $val){
		echo "<li>";
		echo $val['Name'];
		echo "</li>\n";
	}
	echo "</ol></div><div class=\"span6\"";
}
?>


<form action="#" method="POST">
  <fieldset>
    <h2 class="form-signin-heading">Register for this tournament</h2>
	<input name="name" type="text" placeholder="Participant Name">
	<input class="btn btn-primary btn-large" type="submit" name="submit" value="Submit Entry" />
  </fieldset>
</form>
</div>
</div>
<?require_once("inc/footer.php")?>
