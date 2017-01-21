$(function(){

    $('#input').on('keypress', function (event) {
        var regex = new RegExp("^[-/_a-zA-Z0-9\b]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!(key == 8 || key == 27 || key == 46 || key == 37 || key == 39)) {
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        }
    });
    
    $('#inputEmail').on('keypress', function (event) {
        var regex = new RegExp("^[-/_a-zA-Z0-9/@/.\b]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!(key == 8 || key == 27 || key == 46 || key == 37 || key == 39)) {
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        }
    });
            
});