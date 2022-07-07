$(document).ready(function () {



    // hundle notifications

    const url = '/main-app/api/notifications';
    var newNotifications = [];

    const ajaxParams = {
        dataType: 'json',
        method: 'GET', 
        timeout: 30000,
        url:url
    }
    $.ajax(ajaxParams).done(function(response, textStatus, jqXHR) {
         console.info("Notifications");
         console.log(response);

         

         let blocHTML = '';

         response.forEach(notif => {

            if (notif.seen == 0) {
                newNotifications.push(notif);
            }
            blocHTML = `
                <!--begin::Text-->
                <div class="d-flex flex-column font-weight-bold">
                    <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg ${ notif.seen == 0 ? 'font-weight-bolder' : '' } ">${ notif.title }</a>
                    <span class="text-muted ${ notif.seen == 0 ? 'font-weight-bolder' : '' }">${ notif.content }</span>
                </div>
                <!--end::Text-->
            `;


         });
          
         $("#notifications-zone").html(blocHTML);

       

         if (newNotifications.length != 0) {
             $("#notification-icon").addClass("pulse pulse-danger");
             $("#notification-icon-svp").addClass("svg-icon-danger")
         }else{
            $("#notification-icon-svp").addClass("svg-icon-secondary")
         }

         
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR, textStatus, errorThrown);
       
    }).always(function() {
        
    });


    function clearNotifications(){
        const url = '/main-app/api/clear-notifications';

        const ajaxParams = {
            dataType: 'json',
            method: 'GET', 
            timeout: 30000,
            url:url
        }
        $.ajax(ajaxParams).done(function(response, textStatus, jqXHR) {
             console.info("Clear notifications");
             console.log(response);

             if (response.success === true) {
                $("#notification-icon").removeClass("pulse pulse-danger");
                $("#notification-icon-svp").removeClass("svg-icon-danger")
            
                $("#notification-icon-svp").addClass("svg-icon-secondary")
             }
        
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
           
        }).always(function() {
            
        });


    }


    $("#clear-notifications").click(function(e){
        e.preventDefault();

        clearNotifications();
        
    })


    
    $("#clear-notifications").click(function(e){
        e.preventDefault();

        clearNotifications();
        
    })



    $("#notification-icon").click(function(){ 

        clearNotifications();
        
    })

})