$(document).ready(function(){

 
    var exposerTable= function () {
        // Private functions

        // demo initializer
        var demo = function () {

            var datatable = $('#participants-table').KTDatatable({
                data: {
                    saveState: { cookie: false },
                },
                columns: [
                    {
                        field: 'first',
                        width: 20,
                    }, 
                    {
                        field: 'profile',
                        width: 'auto',
                        margin:'auto',
                        textAlign:'right'
                    }, 
                    {
                        field: 'phone',
                        width: 'auto',
                        margin:'auto',
                        textAlign:'center'
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


});