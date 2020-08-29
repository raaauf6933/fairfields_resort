
    var digitsOnly = /[0-9]/g;
    var integerOnly = /[0-9\.]/g;
    var isbnOnly = /[0-9\.\-]/g;
    var phoneOnly = /[0-9\-]/g;
    var alphaOnly = /[A-Za-z\ ]/g;
    var dateOnly = /[0-9\/]/g;
    var alphanumeric = /[A-Za-z0-9]/g;
function restrictCharacters(myfield, e, restrictionType) {
    if (!e) var e = window.event
    if (e.keyCode) code = e.keyCode;
    else if (e.which) code = e.which;
    var character = String.fromCharCode(code);

    if (code==27) {this.blur(); return false; }

    if (!e.ctrlKey && code!=9 && code!=8 && code!=36 && code!=37 && code!=38 && (code!=39 || (code==39 && character=="'")) && code!=40) {
        if (character.match(restrictionType)) {
            return true;
        } else {
            return false;
        }

    }
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
