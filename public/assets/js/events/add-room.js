jQuery(document).ready(function () { 
    let translation = {
        roomName: {
            fr: {
                message : "Veuillez saisir le nom du salle."
            },
            en: {
                message : 'Please enter the room name.'
            },
            
        },
        maximumNumberOfParticipants: {
            fr: {
                message : "Veuillez entrer le nombre maximum de participants."
            },
            en: {
                message : 'Please enter the maximum number of participants.'
            },
            
        },
        roomKeyWords: {
            fr: {
                message : "Veuillez entrer des mots clés"
            },
            en: {
                message : 'Please enter key words'
            },
            
        },
        roomPhotoURL: {
            fr: {
                message : "Veuillez choisir une image"
            },
            en: {
                message : 'Please choose a picture'
            },
            
        },
        photoAlt: {
            fr: {
                message : "Veuillez choisir une photo Alt"
            },
            en: {
                message : 'Please choose a picture Alt'
            },
            
        },

        privacy: {
            fr: {
                message : "Veuillez choisir une type de confidentialité"
            },
            en: {
                message : 'Please choose a type privacy'
            },
            
        },
 
 
    }
    
    let lng = document.getElementById('translation').getAttribute('trans');
     
     
    let eventValidation  = FormValidation.formValidation(
        document.getElementById('add_event_room_form'),
        {
            fields: {
                roomName: {
                    selector: '[event-selector="roomName"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.roomName.en.message : translation.roomName.fr.message
                        }
                    }
                },  

                maximumNumberOfParticipants: {
                    selector: '[event-selector="maximumNumberOfParticipants"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.maximumNumberOfParticipants.en.message : translation.maximumNumberOfParticipants.fr.message
                        }
                    }
                }, 
                roomKeyWords: {
                    selector: '[event-selector="roomKeyWords"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.roomKeyWords.en.message : translation.roomKeyWords.fr.message
                        }
                    }
                }, 


               

                photoAlt: {
                    selector: '[event-selector="photoAlt"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.photoAlt.en.message : translation.photoAlt.fr.message
                        }
                    }
                }, 

                privacy: {
                    selector: '[event-selector="privacy"]',
                    validators: {
                        notEmpty: {
                            message: lng =='en_EN' ? translation.privacy.en.message : translation.privacy.fr.message
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








    /**INIT TAGS */

    // tagging support
		$('#event_rooms_keyWords').select2({
			placeholder: "Add a tag",
			tags: true
		});


       
        


        
	$("#event_logo").click(function(){
		$("#events_logoURL").click();
	})



    $("#event_room_image").click(function(){
		$("#event_rooms_photoURL").click();
	})


 
	var logo2 = document.getElementById('event_room_image');
	var imageLogo2 = $("#image-logo-2");
	var inputLogo2 = $("#event_rooms_photoURL");

	var $alertLogo2 = $('.alert');
	var $modalLogo2 = $('#modal-logo-2');
	var cropper2;

	$('[data-toggle="tooltip"]').tooltip();

	inputLogo2.on('change', function (e) {
	  var files = e.target.files;
	  var done = function (url) { 
		  inputLogo2.value = '';
		  imageLogo2.attr('src',url);
		$alertLogo2.hide();
		$modalLogo2.modal('show');
	  };
	  var reader;
	  var file;
	  var url;

	  if (files && files.length > 0) {
		file = files[0];

		if (URL) {
		  done(URL.createObjectURL(file));
		} else if (FileReader) {
		  reader = new FileReader();
		  reader.onload = function (e) {
			done(reader.result);
		  };
		  reader.readAsDataURL(file);
		}
	  }
	});

	$modalLogo2.on('shown.bs.modal', function () {
		 
	    cropper2 = new Cropper(document.getElementById('image-logo-2'), {
 
	  });
	}).on('hidden.bs.modal', function () {
	  cropper2.destroy();
	  cropper2 = null;
	});

	document.getElementById('crop-logo-btn-2').addEventListener('click', function () {
	
	  var canvas;

	  $modalLogo2.modal('hide');

	  if (cropper2) {
		canvas = cropper2.getCroppedCanvas({
		  
		});
		 
		logo2.src = canvas.toDataURL();
		 
		$alertLogo2.removeClass('alert-success alert-warning');
		canvas.toBlob(function (blob) {


			let file = new File([blob], "img.jpg",{type:"image/jpeg", lastModified:new Date().getTime()});
			let container = new DataTransfer();

			container.items.add(file);

			document.getElementById('event_rooms_photoURL').files = container.files ;
		 




		});
	  }
	});

});
