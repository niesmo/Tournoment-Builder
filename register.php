<? include("conf/config.php");
includeHeader("Register for a Tournament");
if(!isset($_GET['id']) && !isset($_POST['id'])) {
	echo "Error: No tournament ID supplied";
} else {

	$t_id = (isset($_GET['id']))?$_GET['id']:$_POST['id'];

	if(isset($_POST['submit'])){

		$db->insert("Participant", "Name", "'$_POST[name]'");
		$id = $db->lastInsertedId(); // get ParticipantID
		$db->insert("Entry", "TournamentID, ParticipantID", "$t_id, $id");
	}?>
      <div class="row-fluid">
        <div class="span6">
	<?
	$result = $db->select("Tournament", "Name, Description, Rules,MaxPlayer",
		"TournamentID = $t_id")[0]; // get name, description, and rules
	echo "<h1>" . $result['Name'] . "</h1>"; // name
	echo "<p>" . $result['Description'] . "</p>"; // description
	echo "<h3>Rules:</h3><p>" . $result['Rules'] . "</p>";

	$participants =$tournament->getParticipants($t_id);

	if(count($participants)>0){
                                echo "<h3>Current Participants:</h3><table>";
                                $counter = 0;
                                foreach($participants as $val){
                                        echo "<tr><td>". ($counter+=1) .". </td><td>".$val['Name']."</td><td><i class='icon-remove' onclick='removeParticipant(".$val['ParticipantID']." , " .$t_id. " )'></i></td></tr>";
                                }  
                                echo "</table>";                                
                }
	else{
		echo "<h3>No Participants</h3>";
	}
	
	echo "</ol></div><div class='span6'>";
}
?>

<?
echo count($participants);
if($result['MaxPlayer'] < count($participants)){?>
<form action="register.php" method="POST">
  <fieldset>
    <h2 class="form-signin-heading">Register for this tournament</h2>
   	<input type="hidden" name="id" value="<? echo $t_id; ?>"/>
	<input name="name" type="text" placeholder="Participant Name"/><br>
	<input class="btn btn-primary btn-large" type="submit" name="submit" value="Submit Entry" />
  </fieldset>
</form>
<?}else{
	echo "<p>This Tournament is full!!</p>";
}?>

</div>
</div>
<?require_once("inc/footer.php")?>
