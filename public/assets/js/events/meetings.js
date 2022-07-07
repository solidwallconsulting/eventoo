$(document).ready(function(){


    // filters

    let timeFiler = $("#time-filter");
    var timeFilterValue = '';
    

    let dateFiler = $("#date-filter");
    var dateFilterValue = '';
    

    let participantFiler = $("#participant-filter");
    var participantFilerValue = '';
    

    let tableFilter = $("#table-filter");
    var tableFilterValue = '';
    

    let searchEngine = $("#search-engine");
    let searchEngineValue ='';


    function search(){ 
        
        $(".search-time-line").each(function(el){
             
            if (tableFilterValue != "") {
                
                if ( 
                
                    $(this).attr('time-filter').indexOf(timeFilterValue) != -1 
                    &&
                    $(this).attr('date-filter').indexOf(dateFilterValue) != -1 
                    &&
                    $(this).attr('table-filter') == tableFilterValue
                    
     
                    ) {    

                        
                    $(this).css({"display":"table-row"})
                }else{
                    $(this).css({"display":"none"})
                }

            } else {
                

                if ( 
                
                    $(this).attr('time-filter').indexOf(timeFilterValue) != -1 
                    &&
                    $(this).attr('date-filter').indexOf(dateFilterValue) != -1 
                    
     
                    ) {
                        
                        $(this).css({"display":"table-row"})
                        
                        $(this).removeClass("hidden-row")
                }else{
                    $(this).css({"display":"none"})
                    $(this).addClass("hidden-row")
                }


            }
        })

        


        $(".search-time-line").each(function(el){
              


            if ( $(this).hasClass('hidden-row') == false) {
                if ( 
                
                    $(this).attr('time-filter').indexOf(searchEngineValue) != -1 
                    ||
                    $(this).attr('date-filter').indexOf(searchEngineValue) != -1 
                    ||
                    $(this).attr('table-filter').indexOf(searchEngineValue) != -1 
                    
                    ||
                    $(this).attr('participant-name').toLowerCase().indexOf(searchEngineValue.toLowerCase()) != -1 
                    

                    ||
                    $(this).attr('session-name').toLowerCase().indexOf(searchEngineValue.toLowerCase()) != -1 
                    
      
                    ) {    
    
                        
                    $(this).css({"display":"table-row"})
                }else{
                    $(this).css({"display":"none"})
                }
            }



        })

        
    }

    
    function participantCHangeUI(){
        

        $(".participant-item").each(function(el){
            if(  $(this).attr('participant-filter') === participantFilerValue  ){
                $(this).show();
            }else{
                $(this).hide();
            }
        })
        


        /*if (val === '') {
            $(".participant-item").show();

        }*/
    }





    timeFiler.on('change',(e)=>{
        const val = e.target.value; 
        console.log(val); 
        timeFilterValue = val;  
        //search();
    })



    dateFiler.on('change',(e)=>{
        const val = e.target.value; 
        console.log(val); 
        dateFilterValue = val;  
        //search();
    })


    participantFiler.on('change',(e)=>{
        const val = e.target.value; 
        console.log(val); 
        participantFilerValue = val;  

        //participantCHangeUI();

        
    })



    tableFilter.on('keyup',(e)=>{
        const val = e.target.value; 
        console.log(val); 
        tableFilterValue = val;  

        //participantCHangeUI();

        
    })

    tableFilter.on('change',(e)=>{
        const val = e.target.value; 
        console.log(val); 
        tableFilterValue = val;  

        //participantCHangeUI();

        
    })



    searchEngine.on('change',(e)=>{
        const val = e.target.value;  
        searchEngineValue = val;  

        //participantCHangeUI();

        
    })



     


    $("#reset-btn").click(function(){
       
    })

    $("#search-btn").click(function(){
        
        search();
        
        if (participantFilerValue != '') {
            participantCHangeUI();
        }
    })







    /***************************** */




    function updateRealiationsStatus(id,status){
        const ajaxParams = {
            dataType: 'json',
            method: 'POST',
            data: {  },
            timeout: 30000,
            url:'/common/meeting-sessions/update_session_meeting_realisation/'+id+'/'+status
        }
        $.ajax(ajaxParams).done(function(response, textStatus, jqXHR) {
            console.log(response);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            
        }).always(function() {
            
        });
    }
    
    function updatePresenceStatus(id,status){
        const ajaxParams = {
            dataType: 'json',
            method: 'POST',
            data: {   },
            timeout: 30000,
            url:'/common/meeting-sessions/update_session_meeting_presence/'+id+'/'+status
        }
        $.ajax(ajaxParams).done(function(response, textStatus, jqXHR) {
            console.log(response);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            
        }).always(function() {
            
        });
    }
    


    $(".update-presence").on('change',function(e){
        const id = $(this).attr('id-session');
        const status = e.target.value;


        updatePresenceStatus(id,status);
        
    })


 
    
    $(".update-realisation").on('change',function(e){
        const id = $(this).attr('id-session');
        const status = e.target.value;


        updateRealiationsStatus(id,status);
        
    })


         


         
    

   
})