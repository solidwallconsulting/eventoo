$(document).ready(function () {

    $("#mobile-number").intlTelInput(
        {
            preferredCountries: ["tn"],
            separateDialCode: true,
            nationalMode: false,
            formatOnDisplay: true,
        }
    );

    $(".mobile-number").intlTelInput(
        {
            preferredCountries: ["tn"],
            separateDialCode: true,
            nationalMode: false,
            formatOnDisplay: true,
        }
    );




    $(".password-toogler").click(function () {
        console.log("toggle pass");
        let passwordInput = $(this).parent().parent().parent().children(".password-target");
        let attr = passwordInput.attr('type');
        if (attr === 'password') {
            passwordInput.attr('type', 'text')
        } else {
            passwordInput.attr('type', 'password')
        }

    })



    /** datatable settings */

    "use strict";
    // Class definition

    var KTDatatableHtmlTableDemo = function () {
        // Private functions

        // demo initializer
        var demo = function () {

            var datatable = $('.general_datatable').KTDatatable({
                data: {
                    saveState: { cookie: false },
                },
                columns: [
                    {
                        field: 'first',
                        width: 30,
                    }, 
                    {
                        field:"order",
                        width : 45
                    },
                    {
                        field: 'last',
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        width: 100,
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

    KTDatatableHtmlTableDemo.init();



    $(".back-btn").click(function(e){
        e.preventDefault();
        history.back();
    })
 
    $(function () {
        $('[data-toggle="popover"]').popover()
      })


});