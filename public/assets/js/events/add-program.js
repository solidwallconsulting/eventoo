$(document).ready(function(){


    $('#room_programm_tags').select2({ 
        tags: true
    });

    $('#room_programm_participants').select2({ 
        tags: false
    });
    
    $('#room_programm_sponsors').select2({ 
        tags: false
    });
    
    $('#room_programm_exposers').select2({ 
        tags: false
    });



    // validation
    let translation = {
 
        participants: {
            fr: {
                message : "Veuillez choisir les participants."
            },
            en: {
                message : 'Please choose the participants.'
            },
            
        },
        exposers: {
            fr: {
                message : "Veuillez choisir les exposants."
            },
            en: {
                message : 'Please choose the exhibitors.'
            },
            
        },

        sponsors: {
            fr: {
                message : "Veuillez choisir les sponsors."
            },
            en: {
                message : 'Please choose the sponsors.'
            },
            
        },


        title: {
            fr: {
                message : "Veuillez choisir un titre."
            },
            en: {
                message : 'Please choose a title.'
            },
            
        },

        startDate: {
            fr: {
                message : "Veuillez choisir date et heure de début."
            },
            en: {
                message : 'Please choose the starting time and date.'
            },
            
        },

        endDate: {
            fr: {
                message : "Veuillez choisir date et heure de fin."
            },
            en: {
                message : 'Please choose the ending time and date.'
            },
            
        },


        liveLinkURL: {
            fr: {
                message : "Veuillez entrer une valeur."
            },
            en: {
                message : 'Please enter a value.'
            },
            
        },
        liveTranslationLinkURL: {
            fr: {
                message : "Veuillez entrer une valeur."
            },
            en: {
                message : 'Please enter a value.'
            },
            
        },

        reShareLinkURL: {
            fr: {
                message : "Veuillez entrer une valeur."
            },
            en: {
                message : 'Please enter a value.'
            },
            
        },

        reShareTranslationLinkURL: {
            fr: {
                message : "Veuillez entrer une valeur."
            },
            en: {
                message : 'Please enter a value.'
            },
            
        },
        mainSponsorPhotoURL : {
            fr: {
                message : "Veuillez choisir image de sponsor."
            },
            en: {
                message : 'Please select a sponsor image.'
            },
            
        },

        roomKeyWords : {
            fr: {
                message : "Veuillez ajouter des tags."
            },
            en: {
                message : 'Please add tags.'
            },
            
        },



 
    }
    
    let lng = document.getElementById('translation').getAttribute('trans');
     
     
    let eventValidation  = FormValidation.formValidation(
        document.getElementById('add_room_program_form'),
        {
            fields: {
              
                participants: {
                    selector: '[event-selector="participants"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.participants.en.message : translation.participants.fr.message
                        }
                    }
                },
                /*sponsors: {
                    selector: '[event-selector="sponsors"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.sponsors.en.message : translation.sponsors.fr.message
                        }
                    }
                },
                exposers: {
                    selector: '[event-selector="exposers"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.exposers.en.message : translation.exposers.fr.message
                        }
                    }
                },*/

                title: {
                    selector: '[event-selector="title"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.title.en.message : translation.title.fr.message
                        }
                    }
                },

                /*mainSponsorPhotoURL: {
                    selector: '[event-selector="mainSponsorPhotoURL"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.mainSponsorPhotoURL.en.message : translation.mainSponsorPhotoURL.fr.message
                        }
                    }
                },*/



                roomKeyWords : {
                    selector: '[event-selector="roomKeyWords"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.roomKeyWords.en.message : translation.roomKeyWords.fr.message
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

                liveLinkURL: {
                    selector: '[event-selector="liveLinkURL"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.liveLinkURL.en.message : translation.liveLinkURL.fr.message
                        }
                    }
                },

                liveTranslationLinkURL: {
                    selector: '[event-selector="liveTranslationLinkURL"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.liveTranslationLinkURL.en.message : translation.liveTranslationLinkURL.fr.message
                        }
                    }
                },
                reShareLinkURL: {
                    selector: '[event-selector="reShareLinkURL"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.reShareLinkURL.en.message : translation.reShareLinkURL.fr.message
                        }
                    }
                },

                reShareTranslationLinkURL: {
                    selector: '[event-selector="reShareTranslationLinkURL"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.reShareTranslationLinkURL.en.message : translation.reShareTranslationLinkURL.fr.message
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
					$("#add_room_program_form").submit();
				}
			});
 
		
	})



    
    
})