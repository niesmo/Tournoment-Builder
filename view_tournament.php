<? include("conf/config.php");
includeHeader("View Tournament");
if(!isset($_GET['id'])) {
	echo "Error: No tournament ID supplied";
} else {

	$t_id = $_GET['id'];

	$result = $db->select("Tournament", "*",
		"TournamentID = $t_id")[0]; // get the goods

	$participants =$tournament->getParticipants($t_id);

	$matches =$tournament->getMatches($t_id);

	$num_participants = count($participants);

}
	?>
<canvas id="myCanvas" width="100%" height="100%">
Your browser does not support the HTML5 canvas tag.</canvas>

<script>

var num_participants = <? echo $num_participants; ?>;
var num_buckets = Math.pow(2,(Math.ceil(Math.log(num_participants)/Math.LN2)));

var c=document.getElementById("myCanvas");
var ctx=c.getContext("2d");
ctx.canvas.width  = window.innerWidth;
ctx.canvas.height = window.innerHeight;

ctx.font="40px Arial";
ctx.fillText("<? echo $result['Name']; ?>",window.innerWidth/2,50);

var players = new Array();

var player_height = ctx.canvas.height/6;
var player_width = 150;
	
	<? foreach($participants as $val){
		echo "players.push( '" . $val['Name'] . "');";
	}?>

//build structure
function drawLines(num_row,column){
	var start_height = player_height * column;
	if(num_row==1){
		ctx.fillText("Winner",player_width * column,start_height);
		ctx.moveTo(player_width * column, start_height);
		ctx.lineTo(player_width * (column +1),start_height);
		ctx.stroke();
	}
	else{
		for(var i=0;i<num_row;i++){
			ctx.fillText(num_row,player_width * column,start_height);
			ctx.moveTo(player_width * column,start_height + (player_height * i) +5);
			ctx.lineTo(player_width * (column+1),start_height + (player_height * i)+5);
			ctx.stroke();
			//diaganol lines
			if (num_row%2==0) {
				ctx.lineTo(player_width * (column+2),start_height + (player_height * (i+.5)));
				ctx.stroke();	
			}else{
				ctx.lineTo(player_width * (column+2),start_height + (player_height * (i-.5)));
				ctx.stroke();	
			}
		}
		drawLines(num_row/2,column+2);
	}
}
	drawLines(num_buckets,1);


	// for(var j=1;j<=num_participants; j++) {
	// 	ctx.fillText(players[j-1],10,player_height * j);
	// 	ctx.moveTo(10,player_height * j + 5);
	// 	ctx.lineTo(150,player_height * j +5);
	// 	ctx.stroke();	
	// 	if(j%2==0){
	// 		//if result = First -> Green
	// 		ctx.moveTo(player_width,player_height * j +5);
	// 		ctx.lineTo(player_width * (2),player_height * (j-.5));
	// 		ctx.stroke();
	// 		ctx.lineTo(player_width * (3),player_height * (j-.5));
	// 		ctx.stroke();
	// 		ctx.lineTo(player_width * (4),player_height * (j-1.5));
	// 		ctx.stroke();	
	// 		ctx.lineTo(player_width * (5),player_height * (j-1.5));
	// 		ctx.stroke();
	// 	}
	// 	else{
	// 		//if result = Second -> Green
	// 		ctx.moveTo(player_width,player_height * j +5);
	// 		ctx.lineTo(player_width * (2),player_height * (j+.5));
	// 		ctx.stroke();
	// 		ctx.moveTo(player_width*3,player_height * j +5);		
	// 		ctx.lineTo(player_width * (4),player_height * (j+1.5));
	// 		ctx.stroke();
	// 	}
		
	// }

</script>

<?require_once("inc/footer.php")?>
