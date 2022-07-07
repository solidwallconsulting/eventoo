$(document).ready(function(){
    let lng = document.getElementById('translation').getAttribute('trans');

    let translation = {
        label: {
            fr: {
                message : "Veuillez saisir le nom de profile."
            },
            en: {
                message : 'Please enter the name of the profil.'
            },
            
        },
        tarification: {
            fr: {
                message : "Veuillez saisir le type de tarfication."
            },
            en: {
                message : 'Please select the tarification method.'
            },
            
        },
        price: {
            fr: {
                message : "Veuillez saisir la tarif."
            },
            en: {
                message : 'Please enter the amount to pay.'
            },
            
        },
        /*
         descreption: {
            fr: {
                message : "Veuillez saisir une déscription."
            },
            en: {
                message : 'Please enter a description.'
            },
            
        }, */
        numberParticipants: {
            fr: {
                message : "Veuillez saisir le nombres disponibles."
            },
            en: {
                message : 'Please enter the available numbers.'
            },
            
        },
        
    }

    FormValidation.formValidation(
        document.getElementById('add_event_profile'),
        {
            fields: {
                'event_profiles[label]': {
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.label.en.message : translation.label.fr.message
                        },
                    }
                },
                'event_profiles[tarification]': {
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.tarification.en.message : translation.tarification.fr.message
                        },
                    }
                },
                /**
                 * 'event_profiles[price]': {
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.price.en.message : translation.price.fr.message
                        },
                    }
                },
                 */
                /**
                 * 'event_profiles[descreption]': {
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.descreption.en.message : translation.descreption.fr.message
                        },
                    }
                },
                 */
                'event_profiles[participantsNumber]': {
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.numberParticipants.en.message : translation.numberParticipants.fr.message
                        },
                    }
                },
                
    
    
            },
    
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                // Bootstrap Framework Integration
                bootstrap: new FormValidation.plugins.Bootstrap(),
                // Validate fields when clicking the Submit button
                submitButton: new FormValidation.plugins.SubmitButton(),
                                                // Submit the form when all fields are valid
                defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            }
        }
    );

    $("#event_profiles_tarification").on('change',function(e){
        const val = e.target.value;
        if (val == '0' ) {
            $("#event_profiles_price").attr('disabled','disabled');
        }else{
            $("#event_profiles_price").removeAttr('disabled','disabled');
        }
    })




    
    $("#search-input").on('keyup',function(e){
        const val = e.target.value;
        const event = $(this).attr('event');
        const profile = $(this).attr('profile');

         
        $('#preview-list-feilds').html("...");
        $.ajax({
            url: "/common/search-feilds-by-event",
            data : {
                event : event,
                query : val,
                profile : profile,
                
                
            },
            method:'post'
          }).done(function(data) {
            console.log(data);

 

            let blocHTML ='';

            for (let i = 0; i < data.length; i++) {
                const element = data[i];

                blocHTML= blocHTML+`
                <div class="d-flex align-items-center flex-grow-1">
                 

                <!--begin::Section-->
                <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                    <!--begin::Info-->
                    <div class="d-flex flex-column align-items-cente py-2 w-75">
                        <!--begin::Title-->
                        <a href="#" class="text-dark-75 font-weight-bold text-hover-primary font-size-lg mb-1">
                        ${ lng == "en_EN" ? element.label_en : element.label_fr }
                        </a>
                        <!--end::Title-->
 
                    </div>
                    <!--end::Info-->

                    <!--begin::Label-->
                    <span attr-id="${element.id}"  class="c-pointer add-attr-to-event label label-lg label-light-primary label-inline font-weight-bold py-4">${ lng == "en_EN" ? 'add' : 'ajouter' }</span>
                    <!--end::Label-->
                </div>
                <!--end::Section-->
            </div>
                `;
                
            }

            $('#preview-list-feilds').html(blocHTML);


            



            $(".add-attr-to-event").click(function(){
                const thisBTN = $(this);

                const idAttr = $(this).attr('attr-id');  
                
                console.log(idAttr);
 
                $.ajax({
                    url: "/common/add-feilds-to-profile",
                    data : {
                        profile : profile,
                        feild : idAttr
                    },
                    method:'post'
                  }).done(function(data) {
                    console.log(data);

                    if (data.success === true) {
                        $("#alert-section").html(`<div class="alert alert-success mt-2 mb-2">${data.message}</div>`);
                        setTimeout(() => {
                           // location.reload();
                        }, 1500);

                        thisBTN.html(lng == "en_EN" ? 'added' : 'ajouté');
                         
                    }else{
                        $("#alert-section").html(`<div class="alert alert-danger mt-2 mb-2">${data.message}</div>`);
                    }
                  })
            })

          });

    })

    $("#search-input").trigger("keyup");


    $("#search-input").trigger("keyup");




    $(".remove-feild-from-profile").click(function(){
        const id = $(this).attr('association-id'); 
        $(this).parent().remove();

        $.ajax({
            url: "/common/remove-feild-from-profile",
            data : { 
                association : id
            },
            method:'post'
          }).done(function(data) {
            console.log(data);

            if (data.success === true) {
                $("#alert-section").html(`<div class="alert alert-success mt-2 mb-2">${data.message}</div>`);
            }else{
                $("#alert-section").html(`<div class="alert alert-danger mt-2 mb-2">${data.message}</div>`);
            }
          }).fail((err)=>{
                $("#alert-section").html(`<div class="alert alert-danger mt-2 mb-2">Something went wrong.</div>`);
          })
        
    })
})