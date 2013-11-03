function progressTournament(t_id){
	$.ajax({
		url:'ajax/progressTournament.php',
		type: 'POST',
		data: {TournamentID :t_id },
		success: function(data){
			//alert(data);
			location.reload(true);
		/*	$.ajax({
				url:'ajax/gen_match.php',
				type: 'POST',
				data: {id : t_id },
				success: function(data){
					location.reload(true);
				}
			});*/
		}
	});	
}

function removeParticipant(part_id ){
	$.ajax({
		url:'ajax/remove_participant.php',
		type: 'POST',
		data: {Participant :part_id },
		success: function(data){
			if(data == "SUCCESS"){
				location.reload(true);
			}
			else{
				alert(data);
				alert("Something went wrong!!");
			}
			
		}
	});
}

function submitResult(m_id, res, t_id){
    	$.ajax({
		url:'ajax/submit_match_result.php',
		type: 'POST',
		data: {MatchID :m_id ,result : res },
		success: function(data){
			//alert(data);
			if(data == "SUCCESS"){
				location.reload(true);
			}
			else{
				alert(data);
				alert("Something went wrong!!");
			}
			
		}
	});
	/*$.ajax({
		url:'ajax/gen_match.php',
		type: 'POST',
		data: {MatchID :m_id, id : t_id },
		success: function(data){
			if(data == "SUCCESS"){
				location.reload(true);
			}
			else{
				alert(data);
				alert("Something went wrong!!");
			}
			
		}
	});*/
	
	
}

$(document).ready(function(){
    //alert("test");
});
