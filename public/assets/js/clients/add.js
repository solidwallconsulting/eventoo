"use strict";

let translation = {
	emptyClientName: {
		fr: {
			message : 'Veuillez saisir le nom du client. Le nom du client ne peut pas être vide.'
		},
		en: {
			message : 'Please enter the name of the customer. Customer name cannot be empty.'
		},
		
	},
	clientNameLength: {
		fr: {
			message : 'Veuillez réessayer entre 1 et 75 caractères'
		},
		en: {
			message : 'Please try again between 1 and 75 characters'
		},
		
	},

	emptyClientFirstName: {
		fr: {
			message : 'Veuillez saisir votre prénom. Le prénom ne peut pas être vide.'
		},
		en: {
			message : 'Please enter your first name. The first name cannot be empty.'
		},
		
	},
	clientFirstNameLength: {
		fr: {
			message : 'Veuillez réessayer entre 1 et 50 caractères'
		},
		en: {
			message : 'Please try again between 1 and 50 characters'
		},
		
	},
	

	emptyClientLasttName: {
		fr: {
			message : 'Veuillez saisir votre nom. Le prénom ne peut pas être vide.'
		},
		en: {
			message : 'Please enter your last name. The last name cannot be empty.'
		},
		
	},
	clientLastNameLength: {
		fr: {
			message : 'Veuillez réessayer entre 1 et 50 caractères'
		},
		en: {
			message : 'Please try again between 1 and 50 characters'
		},
		
	},

	emptyClientCivility : {
		fr: {
			message : 'Veuillez choisir votre civilité. La civilité ne peut pas être vide.'
		},
		en: {
			message : 'Please choose your civility. Civility cannot be empty.'
		},
		
	},

	emptyClientFunction: {
		fr: {
			message : 'Veuillez saisir votre fonction. La fonction ne peut pas être vide.'
		},
		en: {
			message : 'Please enter your function. The function cannot be empty.'
		},
		
	},
	clientFunctionLength: {
		fr: {
			message : 'Veuillez réessayer entre 1 et 75 caractères'
		},
		en: {
			message : 'Please try again between 1 and 75 characters'
		},
		
	},
	clientPhoneEmpty : {
		fr: {
			message : "Veuillez réessayer entre 1 et 75 caractères"
		},
		en: {
			message : 'Please try again between 1 and 75 characters'
		},
		
	},

	clientEmailEmpty : {
		fr: {
			message : "Saisissez votre email"
		},
		en: {
			message : 'Enter your email'
		}, 

	},
	clientValidEmail : {
			
		fr: {
			message : "L'adresse email renseignée n'est pas valide"
		},
		en: {
			message : 'The email address entered is not valid'
		},
	},

	clientPasswordEmpty : {
		fr: {
			message : "Saisissez votre mot de pass"
		},
		en: {
			message : 'Enter your password'
		}, 

	},
	clientValidPassword : {
			
		fr: {
			message : "Le mot de passe inséré ne respecte pas la condition ci-dessous. Veuillez réessayer 8 caractères minimum"
		},
		en: {
			message : 'The entered password does not respect the condition below. Please try again 8 characters minimum'
		},
	},

	clientPhotoErr : {
			
		fr: {
			message : "La photo inséré ne respecte pas les conditions ci-dessous. Veuillez réessayer Dimension minimale 400*400 pixels (optimale 700*700 pixels)  Format .jpg, jpeg ou .png "
		},
		en: {
			message : 'The inserted photo does not respect the conditions below. Please try again Minimum dimension 400 * 400 pixels (optimal 700 * 700 pixels) Format .jpg, jpeg or .png'
		},
	},
	
	clientLogoErr : {
			
		fr: {
			message : "Le logo inséré ne respecte pas les conditions ci-dessous. Veuillez réessayer Dimension minimale 400*400 pixels (optimale 700*700 pixels)  Format .jpg, jpeg ou .png "
		},
		en: {
			message : 'The inserted logo does not respect the conditions below. Please try again Minimum dimension 400 * 400 pixels (optimal 700 * 700 pixels) Format .jpg, jpeg or .png'
		},
	},
	

}

let lng = document.getElementById('translation').getAttribute('trans');

console.log(lng);
 
let validation  = FormValidation.formValidation(
	document.getElementById('add_client_form'),
	{
		fields: {
			 
			clientName: {
				validators: {
					notEmpty: {
						message: lng =='en_EN' ? translation.emptyClientName.en.message : translation.emptyClientName.fr.message
					},
					stringLength: {
						min:1,
						max:75,
						message: lng =='en_EN' ? translation.clientNameLength.en.message : translation.clientNameLength.fr.message
					}
				}
			},
			firstname: {
				validators: {
					notEmpty: { 
						message: lng =='en_EN' ? translation.emptyClientFirstName.en.message : translation.emptyClientFirstName.fr.message
					},
					stringLength: {
						min:1,
						max:50,
						message: lng =='en_EN' ? translation.clientFirstNameLength.en.message : translation.clientFirstNameLength.fr.message
					}
				} 
			},
			lastname: { 
				validators: {
					notEmpty: {
						message: lng =='en_EN' ? translation.emptyClientLasttName.en.message : translation.emptyClientLasttName.fr.message
					},
					stringLength: {
						min:1,
						max:50, 
						message: lng =='en_EN' ? translation.clientLastNameLength.en.message : translation.clientLastNameLength.fr.message
					}
				} 
			},
			civility: {
				validators: {
					notEmpty: { 
						message: lng =='en_EN' ? translation.emptyClientCivility.en.message : translation.emptyClientCivility.fr.message
					}
				}
			},
			function: { 
				validators: {
					notEmpty: {
						message: lng =='en_EN' ? translation.emptyClientFunction.en.message : translation.emptyClientFunction.fr.message
					},
					stringLength: {
						min:1,
						max:50, 
						message: lng =='en_EN' ? translation.clientFunctionLength.en.message : translation.clientFunctionLength.fr.message
					}
				}
			},
			phone: {
				validators: {
					notEmpty: {
						message: lng =='en_EN' ? translation.clientPhoneEmpty.en.message : translation.clientPhoneEmpty.fr.message
					}, 
				}
			},
			email: {
				validators: {
					notEmpty: {
						message: lng =='en_EN' ? translation.clientEmailEmpty.en.message : translation.clientEmailEmpty.fr.message
					},
					emailAddress: {
						message: lng =='en_EN' ? translation.clientValidEmail.en.message : translation.clientValidEmail.fr.message
					}
				}
			},
			password: {
				validators: {
					notEmpty: {
						message: lng =='en_EN' ? translation.clientPasswordEmpty.en.message : translation.clientPasswordEmpty.fr.message
					},
					stringLength: {
						min:8,
						max:75,
						message: lng =='en_EN' ? translation.clientValidPassword.en.message : translation.clientValidPassword.fr.message
					}
				}
			},


		},

		plugins: {
			trigger: new FormValidation.plugins.Trigger(),
			// Validate fields when clicking the Submit button
			submitButton: new FormValidation.plugins.SubmitButton(),
			// Submit the form when all fields are valid
			defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
			// Bootstrap Framework Integration
			bootstrap: new FormValidation.plugins.Bootstrap({
				eleInvalidClass: '',
				eleValidClass: '',
			}),
 
		}
	}
);




jQuery(document).ready(function () {
	

    var didUpdatePhone = false;
	let photoErr = $("#photoErr");
	let logoErr = $("#logoErr");

	$("#avatar").click(function(){
		$("#cropper_image").click();
	})
 
	$("#logo").click(function(){
		$("#cropper_logo").click();
	})
 

	$("#mobile-number").on('change',function(e){
		console.log(e);

		var countryCode = $(".iti__selected-dial-code").html();
		console.log(countryCode);
		$("#selectedCountryIndex").val(countryCode)
	})
	

	$("#pre-validation").click(function(){
		let photo = $("#cropper_image").val();
		let logo = $("#cropper_logo").val();

		 

		if (photo == '') {
			photoErr.html(lng =='en_EN' ? translation.clientPhotoErr.en.message : translation.clientPhotoErr.fr.message) 
		} else {
			photoErr.html('')
		}
		
		if (logo == '') {
			logoErr.html(lng =='en_EN' ? translation.clientLogoErr.en.message : translation.clientLogoErr.fr.message )
		} else {
			logoErr.html('')
		}
		
		if (photo == '' || logo =='') {
			 KTUtil.scrollTop();
		} 


		validation.validate()
			.then(function(status) {
				console.log(status);
				if (status ==='Invalid') {
					KTUtil.scrollTop();
				}else{
					$("#add_client_form").submit();
				}
			});
 
		
	})


	
   



	/**
	 * 
	 * cropper
	 * new Cropper(element[, options])
	 */

	

	 var avatar = document.getElementById('avatar');
	 var image = $("#image");
	 var input = $("#cropper_image");
 
	 var $alert = $('.alert');
	 var $modal = $('#modal');
	 var cropper;
 
	 $('[data-toggle="tooltip"]').tooltip();
 
	 input.on('change', function (e) {
	   var files = e.target.files;
	   var done = function (url) {
		   console.log(url);
		 input.value = '';
		 image.attr('src',url);
		 $alert.hide();
		 $modal.modal('show');
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
 
	 $modal.on('shown.bs.modal', function () {
		 console.log();
	   cropper = new Cropper(document.getElementById("image"), {
		 aspectRatio: 1,
		 viewMode: 3,
	   });
	 }).on('hidden.bs.modal', function () {
	   cropper.destroy();
	   cropper = null;
	 });
 
	 document.getElementById('crop').addEventListener('click', function () {
	   var initialAvatarURL;
	   var canvas;
 
	   $modal.modal('hide');
 
	   if (cropper) {
		 canvas = cropper.getCroppedCanvas({
		   width: 160,
		   height: 160,
		 });
		 initialAvatarURL = avatar.src;
		 avatar.src = canvas.toDataURL();
		  
		 $alert.removeClass('alert-success alert-warning');
		 canvas.toBlob(function (blob) {
 
 
			 let file = new File([blob], "img.jpg",{type:"image/jpeg", lastModified:new Date().getTime()});
			 let container = new DataTransfer();
 
			 container.items.add(file);
 
			 document.getElementById('cropper_image').files = container.files ;
			 photoErr.html('')
			 
 
 
 
 
		 });
	   }
	 });




	 /******************************************* */


	 /**
	 * 
	 * cropper
	 * new Cropper(element[, options])
	 */

	

	  var logo = document.getElementById('logo');
	  var imageLogo = $("#image-logo");
	  var inputLogo = $("#cropper_logo");
  
	  var $alertLogo = $('.alert');
	  var $modalLogo = $('#modal-logo');
	  var cropper;
  
	  $('[data-toggle="tooltip"]').tooltip();
  
	  inputLogo.on('change', function (e) {
		var files = e.target.files;
		var done = function (url) {
			console.log(url);
			inputLogo.value = '';
			imageLogo.attr('src',url);
		  $alertLogo.hide();
		  $modalLogo.modal('show');
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
  
	  $modalLogo.on('shown.bs.modal', function () {
		  console.log();
		cropper = new Cropper(document.getElementById('image-logo'), {
		  aspectRatio: 1,
		  viewMode: 3,
		});
	  }).on('hidden.bs.modal', function () {
		cropper.destroy();
		cropper = null;
	  });
  
	  document.getElementById('crop-logo-btn').addEventListener('click', function () {
		var initialAvatarURL;
		var canvas;
  
		$modalLogo.modal('hide');
  
		if (cropper) {
		  canvas = cropper.getCroppedCanvas({
			width: 160,
			height: 160,
		  });
		  initialAvatarURL = avatar.src;
		  logo.src = canvas.toDataURL();
		   
		  $alertLogo.removeClass('alert-success alert-warning');
		  canvas.toBlob(function (blob) {
  
  
			  let file = new File([blob], "img.jpg",{type:"image/jpeg", lastModified:new Date().getTime()});
			  let container = new DataTransfer();
  
			  container.items.add(file);
  
			  document.getElementById('cropper_logo').files = container.files ;
			  logoErr.html('')
			  
  
  
  
  
		  });
		}
	  });

});
