function submitResult(m_id, res){
    alert(res);
    $.ajax({
       url:'http://masterme120.chronos.feralhosting.com/hackathon/dev/ajax/submit_match_result.php',
       type: 'POST',
       data:{MatchID : m_id , result : res },
       success: function (data){
           alert(data);
       }
        
    });
}

$(document).ready(function(){
    //alert("test");
});
