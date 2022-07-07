$(document).ready(function(){
    let invitationsCount = $("#invitations-count");
    let roomID =  $("#room-id").val();
    
    
    function showAlert(message){
        $(".bloc-message").html(message);
        $(".alert-toast").animate({'bottom':'0'},1000)

        setTimeout(() => {
            $(".alert-toast").animate({'bottom':'-200px'},1000) 
        }, 4000);
        
        
    }


    function sendAppointmentInvitation(participantID,button){
        const ajaxParams = {
            dataType: 'json',
            method: 'POST',
            data: { participantID: participantID, roomID: roomID },
            timeout: 30000,
            url:'/main-app/networking-api/send-invitation'
        }
        $.ajax(ajaxParams).done(function(response, textStatus, jqXHR) {
             console.log(response);
             if (response.success == true) { 
                invitationsCount.html(Number(invitationsCount.html()) + 1);
                
                button.attr('disabled',true)
                button.html( button.attr('success-message-translate'));
                showAlert(response.message);
             } else {
                 showAlert(response.message);
             }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
            invitationsCount.html(Number(invitationsCount.html()) - 1);
        }).always(function() {
            
        });
    }
    
    
    
    $(".send-invitation").click(function(){
        

        

        const participantID = $(this).attr('target');

        sendAppointmentInvitation(participantID,$(this));

    })


    $("#search-by-name").on('keyup',function(e){
        const val = e.target.value.trim().toLowerCase();

        $(".participant-search").each(function(){
            if ( $(this).attr('fullname').toLowerCase().indexOf(val) != -1 ) {
                $(this).show();
            } else {
                $(this).hide();
            }
        })
    })








    
});