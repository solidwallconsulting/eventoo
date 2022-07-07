jQuery(document).ready(function () { 
    let translation = {
        eventName: {
            fr: {
                message : "Veuillez saisir le nom de l'événement."
            },
            en: {
                message : 'Please enter the name of the event.'
            },
            
        },
        totalSubscribersNumber: {
            fr: {
                message : "Veuillez saisir le nombre d’inscrits Total de l'événement."
            },
            en: {
                message : 'Please enter the total number of registrants for the event.'
            },
            
        },
        eventsLengthInDays: {
            fr: {
                message : "Veuillez saisir le nombre de jours de l'événement."
            },
            en: {
                message : 'Please enter the number of days of the event.'
            },
            
        },
        typeZone: {
            fr: {
                message : "Veuillez choisir le fuseau horaire de l'événement."
            },
            en: {
                message : 'Please choose the timezone of the event.'
            },
            
        },
        startDate: {
            fr: {
                message : "Veuillez choisir la date de début de l'événement."
            },
            en: {
                message : 'Please choose the start date of the event.'
            },
            
        },
        endDate: {
            fr: {
                message : "Veuillez choisir la date de fin de l'événement."
            },
            en: {
                message : 'Please choose the end date of the event.'
            },
            
        },
        location:{
            fr: {
                message : "Veuillez choisir le lieu de l'événement."
            },
            en: {
                message : 'Please choose the location of the event.'
            },
            
        },
        eventAccessibility:{
            fr: {
                message : "Veuillez choisir la confidentialité de l'événement."
            },
            en: {
                message : "Please choose the privacy of the event."
            },
            
        },
        eventLng:{
            fr: {
                message : "Veuillez choisir la langue de l'événement."
            },
            en: {
                message : "PPlease choose the language of the event."
            },
            
        },
        eventLng:{
            fr: {
                message : "Veuillez choisir la langue de l'événement."
            },
            en: {
                message : "PPlease choose the language of the event."
            },
            
        },
        willBeAvailableForNMonths:{
            fr: {
                message : "Veuillez choisir la durée de l'événement."
            },
            en: {
                message : "PPlease choose the duration of the event."
            },
            
        },
    
    }
    
    let lng = document.getElementById('translation').getAttribute('trans');
     
     
    let eventValidation  = FormValidation.formValidation(
        document.getElementById('add_event_form'),
        {
            fields: {
                eventName: {
                    selector: '[event-selector="eventName"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.eventName.en.message : translation.eventName.fr.message
                        }
                    }
                },
                totalSubscribersNumber: {
                    selector: '[event-selector="totalSubscribersNumber"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.totalSubscribersNumber.en.message : translation.totalSubscribersNumber.fr.message
                        }
                    }
                },
                eventsLengthInDays: {
                    selector: '[event-selector="eventsLengthInDays"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.eventsLengthInDays.en.message : translation.eventsLengthInDays.fr.message
                        }
                    }
                },

                typeZone: {
                    selector: '[event-selector="typeZone"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.typeZone.en.message : translation.typeZone.fr.message
                        }
                    }
                },
                startDate: {
                    selector: '[event-selector="startDate"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.startDate.en.message : translation.startDate.fr.message
                        }
                    }
                },
                endDate: {
                    selector: '[event-selector="endDate"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.endDate.en.message : translation.endDate.fr.message
                        }
                    }
                },
                location: {
                    selector: '[event-selector="location"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.location.en.message : translation.location.fr.message
                        }
                    }
                },
                eventAccessibility: {
                    selector: '[event-selector="eventAccessibility"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.eventAccessibility.en.message : translation.eventAccessibility.fr.message
                        }
                    }
                },
                eventLng: {
                    selector: '[event-selector="eventLng"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.eventLng.en.message : translation.eventLng.fr.message
                        }
                    }
                },
                willBeAvailableForNMonths: {
                    selector: '[event-selector="willBeAvailableForNMonths"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.willBeAvailableForNMonths.en.message : translation.willBeAvailableForNMonths.fr.message
                        }
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
    


    $("#pre-validation").click(function(){ 
 


		eventValidation.validate()
			.then(function(status) {
				console.log(status);
				if (status ==='Invalid') {
					KTUtil.scrollTop();
				}else{
					$("#add_client_form").submit();
				}
			});
 
		
	})

        


	  

});
