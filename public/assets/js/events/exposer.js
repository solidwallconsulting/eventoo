$(document).ready(function(){
    
    var minCroppedWidth = 120;
    var minCroppedHeight = 120;
    var maxCroppedWidth = 450;
    var maxCroppedHeight = 450;
	
 
	var imageLogo = $("#image-logo-exposer");
	var inputLogo = $("#exposer_logoURL");
 
	var $modalLogo = $('#exposer-modal-logo');
	var cropper;

	$('[data-toggle="tooltip"]').tooltip();

	inputLogo.on('change', function (e) {
	  var files = e.target.files;
	  var done = function (url) {
		  console.log(url);
		  inputLogo.value = '';
		  imageLogo.attr('src',url); 
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
		 
	       cropper = new Cropper(document.getElementById('image-logo-exposer'), {
			 data: {
              width: (minCroppedWidth + maxCroppedWidth) / 2,
              height: (minCroppedHeight + maxCroppedHeight) / 2,
            }, 

          crop: function (event) {
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
            },
	  });
	}).on('hidden.bs.modal', function () {
	  cropper.destroy();
	  cropper = null;
	});



    document.getElementById('crop-exposer-logo-btn').addEventListener('click', function () {
		 
		var canvas;
  
		$modalLogo.modal('hide');
  
		if (cropper) {
		  canvas = cropper.getCroppedCanvas({
			width: 160,
			height: 160,
		  }); 
		  document.getElementById('add-exposer-logo-holder').src = canvas.toDataURL();
		    
		  canvas.toBlob(function (blob) {
  
  
			  let file = new File([blob], "img.jpg",{type:"image/jpeg", lastModified:new Date().getTime()});
			  let container = new DataTransfer();
  
			  container.items.add(file);
  
			  document.getElementById('exposer_logoURL').files = container.files ;

              $("#addExposerModal").modal('show');
			   
		  });
		}
	  });



    $("#add-exposer-logo-holder").click(function(){
		
        
        // close add modal and open cropper modal
        $("#addExposerModal").modal('hide');

        $("#exposer_logoURL").click();

    })



    /*******************datatableµµµµµµµµµµµµµµµµµµµµµµµµµ */



    

        /** datatable settings */
 
    
        var exposerTable= function () {
            // Private functions
    
            // demo initializer
            var demo = function () {
    
                var datatable = $('#exposer-table').KTDatatable({
                    data: {
                        saveState: { cookie: false },
                    },
                    columns: [
                        {
                            field: 'first',
                            width: 20,
                        }, 
                        {
                            field: 'logo',
                            width: 55,
                        }, 
                        
                        {
                            field: 'last',
                            width: 80,
                        },
                    ],
                });
    
    
    
            };
    
            return {
                // Public functions
                init: function () {
                    // init dmeo
                    demo();
                },
            };
        }();
    
        exposerTable.init();
    
    
    
        
     

})