$(document).ready(function(){
    

    $("#meeting_sessions_tableRotation").on('change',function(e){
        const val = e.target.value;

        if (val == '1') {
            $("#matchmaking_row").slideDown();
        }else{
            $("#matchmaking_row").slideUp();


            $("#meeting_sessions_matchmaking").val(0);
            $("#meeting_sessions_matchmaking").trigger('change')
        }
    })


    
    $("#meeting_sessions_matchmaking").on('change',function(e){
        const val = e.target.value;

        if (val == '1') {
            $("#byWho_row").slideDown();
            $("#accessebility_row").slideDown();
        }else{
            $("#byWho_row").slideUp();
            $("#accessebility_row").slideUp();
        }
    })


    
})