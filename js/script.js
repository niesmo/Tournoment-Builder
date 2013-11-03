function submitResult(m_id, res){
    	$.ajax({
		url:'ajax/submit_match_result.php',
		type: 'POST',
		data: {MatchID :m_id ,result : res },
		success: function(data){
			alert(data);
			if(data == "SUCCESS"){
				location.reload(true);
			}
			
		}
	});
}

$(document).ready(function(){
    //alert("test");
});
