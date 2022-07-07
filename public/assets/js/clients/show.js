$(document).ready(function(){
     var _initAvatar = function () { 
		_photo = new KTImageInput('kt_user_update_avatar');
 
	}
    var didUpdatePhone = false;

    $('form[name="client_update"]') .on('submit',function(e){

        if (didUpdatePhone == false) {
             e.preventDefault();
 
             var countryCode = $(".iti__selected-dial-code").html();


             console.log("hi",countryCode);


             $('#client_update_countryIndex').val(countryCode)
 
             didUpdatePhone = true;
             $('form[name="client_update"]').submit();
        } 
 
     })
 

     _initAvatar();



     /*$(".avatar-change").change(function(){
          console.log("changed");
          var form = $(this).closest("form");

          form.submit();

     })*/






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
          initialAvatarURL = logo.src;
          logo.src = canvas.toDataURL();
           
          $alertLogo.removeClass('alert-success alert-warning');
          canvas.toBlob(function (blob) {


               let file = new File([blob], "img.jpg",{type:"image/jpeg", lastModified:new Date().getTime()});
               let container = new DataTransfer();

               container.items.add(file);

               document.getElementById('cropper_logo').files = container.files ;
               
                $("#update-logo-form").submit();

          });
        }
     });


     

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
			 
                $("#update-photo-form").submit();
 
 
		 });
	   }
	 });




     $("#avatar").click(function(){
		$("#cropper_image").click();
	})
 
	$("#logo").click(function(){
		$("#cropper_logo").click();
	})

})