<? include("conf/config.php");
include("inc/header.php");
if(!isset($_GET['id'])) {
	echo "Error: No tournament ID supplied";
} else {

	$t_id = $_GET['id'];

	$result = $db->select("Tournament", "*",
		"TournamentID = $t_id")[0]; // get the goods

	$participants =$tournament->getParticipants($t_id);
	//$matches =$tournament->getMatches($t_id);
	//print_r($participants);
	$num_participants = count($participants);

	?>
<canvas id="myCanvas" width="100%" height="100%">
Your browser does not support the HTML5 canvas tag.</canvas>

<script>

var num_participants = <? echo $num_participants; ?>;
var c=document.getElementById("myCanvas");
var ctx=c.getContext("2d");
ctx.canvas.width  = window.innerWidth;
ctx.canvas.height = window.innerHeight;

ctx.font="40px Arial";
ctx.fillText("<? echo $result['Name']; ?>",window.innerWidth/2,50);

var players = new Array();
var player_height = ctx.canvas.height/4;
var player_width = ctx.canvas.width/3;
	
	<? foreach($participants as $val){
		echo "players.push( '" . $val['Name'] . "');";
	}?>

	for(var j=1;j<=num_participants; j++) {
		ctx.fillText(players[j-1],10,player_height * j);
		if(j%2==0){
			ctx.moveTo(player_width,player_height * j);
			ctx.lineTo(player_width * (2),player_height * (j-1));
			ctx.stroke();	
		}
		else{
			ctx.moveTo(player_width,player_height * j);
			ctx.lineTo(player_width * (2),player_height * (j+1));
			ctx.stroke();		
		}
		
	}

</script>

<?require_once("inc/footer.php")?>
