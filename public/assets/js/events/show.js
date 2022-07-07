


$(document).ready(function(){

    var minCroppedWidth = 2160;
    var minCroppedHeight = 1080;
    var maxCroppedWidth = 4320;
    var maxCroppedHeight = 2160;
	
	var logo = document.getElementById('event_cover');
	var imageLogo = $("#image-logo");
	var inputLogo = $("#events_photoURL");

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
		 
	       cropper = new Cropper(document.getElementById('image-logo'), {
			/* data: {
              width: (minCroppedWidth + maxCroppedWidth) / 2,
              height: (minCroppedHeight + maxCroppedHeight) / 2,
            },*/
    
          
           

         /* crop: function (event) {
              var width = event.detail.width;
              var height = event.detail.height;
    
              if (
                width < minCroppedWidth
                || height < minCroppedHeight
                || width > maxCroppedWidth
                || height > maxCroppedHeight
              ) {
                cropper.setData({
                  width: Math.max(minCroppedWidth, Math.min(maxCroppedWidth, width)),
                  height: Math.max(minCroppedHeight, Math.min(maxCroppedHeight, height)),
                });
              } 
            },*/
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
		  
		});
		initialAvatarURL = logo.src;
		logo.src = canvas.toDataURL();
		 
		$alertLogo.removeClass('alert-success alert-warning');
		canvas.toBlob(function (blob) {


			let file = new File([blob], "img.jpg",{type:"image/jpeg", lastModified:new Date().getTime()});
			let container = new DataTransfer();

			container.items.add(file);

			document.getElementById('events_photoURL').files = container.files ;
		 




		});
	  }
	});
	
	$("#event_cover").click(function(){
		$("#events_photoURL").click();
	})
	



	/***********************************************same for logo ****************************************** */

	
	$("#event_logo").click(function(){
		$("#events_logoURL").click();
	})



 
	var logo2 = document.getElementById('event_logo');
	var imageLogo2 = $("#image-logo-2");
	var inputLogo2 = $("#events_logoURL");

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
			 /**
			  * data: {
              width: (minCroppedWidthLogo + maxCroppedWidthLogo) / 2,
              height: (minCroppedHeightLogo + maxCroppedHeightLogo) / 2,
            },
			  */
    
          
           

          /*crop: function (event) {
              var width = event.detail.width;
              var height = event.detail.height;
    
              if (
                width < minCroppedWidthLogo
                || height < minCroppedHeightLogo
                || width > maxCroppedWidthLogo
                || height > maxCroppedHeightLogo
              ) {
                cropper.setData({
                  width: Math.max(minCroppedWidthLogo, Math.min(maxCroppedWidthLogo, width)),
                  height: Math.max(minCroppedHeightLogo, Math.min(maxCroppedHeightLogo, height)),
                });
              } 
            },*/
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

			document.getElementById('events_logoURL').files = container.files ;
		 




		});
	  }
	});

})
  