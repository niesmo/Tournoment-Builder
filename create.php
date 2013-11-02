<? include("inc/header.php");
if($_POST[submit]){
	print_r($_POST);
	$con=mysqli_connect(":/media/sdp1/home/masterme120/private/mysql/socket", "root",
		"1yy5u8Uwmy1go57h", "Tournament");
	if(mysqli_connect_errno($con)) {
		echo "Connection to MySQL database failed: " . mysqli_connect_error();
	} else {
		mysqli_query($con, "INSERT INTO Tournament (Name, Type, StartDate, Status, Description,
			Rules) VALUES ('$_POST[name]', '$_POST[type]', 'NOW()', 'OPEN',
			'$_POST[description]', '$_POST[rules]');");
	}
	
}
?>
<form action="#" method="POST">
  <fieldset>
    <legend>Create Tournament</legend>
	<input name="name" type="text" placeholder="Tournament Name">
	<select name="type">
	  <option value="SINGLE">Single Elimination</option>
	  <option value="DOUBLE">Double Elimination</option>
	  <option value="ELO">Elo Ranking System</option>
	  <option value="MTG">Tournament Inspired by MtG</option>
	</select>
	<textarea name="description" rows="3"></textarea>
	<textarea name="rules" rows="3"></textarea>
	<input type="submit" name="submit" value="Creat Tournament" />
  </fieldset>
</form>
<?include("inc/footer.php");?>
