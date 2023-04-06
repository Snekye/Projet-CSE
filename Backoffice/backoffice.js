let sections = document.getElementsByClassName("affiche")
let buttons = document.getElementsByClassName("menubutton")
function affiche(id) {
    for (i = 0; i < sections.length; i++) {
        sections[i].setAttribute("style","display: none;")
        buttons[i].setAttribute("style","border-color: #D9D9D9;")
    }
    sections[id].setAttribute("style","display: block;")
    buttons[id].setAttribute("style","border-color: #1B3168;")
}
affiche(0);

function deletepartenaire(id) {
    document.getElementsByClassName("deletepartenaire")[0].setAttribute("style","display: block");
    document.getElementsByClassName("bg")[0].setAttribute("style","display: block");
    document.getElementsByClassName("deletepartenaireinput")[0].setAttribute("value",id);
}
function deleteoffre(id) {
    document.getElementsByClassName("deleteoffre")[0].setAttribute("style","display: block");
    document.getElementsByClassName("bg")[0].setAttribute("style","display: block");
    document.getElementsByClassName("deleteoffreinput")[0].setAttribute("value",id);
}
function deletemessage(id) {
    document.getElementsByClassName("deletemessage")[0].setAttribute("style","display: block");
    document.getElementsByClassName("bg")[0].setAttribute("style","display: block");
    document.getElementsByClassName("deletemessageinput")[0].setAttribute("value",id);
}
function deletecancel() {
    document.getElementsByClassName("deletepartenaire")[0].setAttribute("style","display: none");
    document.getElementsByClassName("deleteoffre")[0].setAttribute("style","display: none");
    document.getElementsByClassName("deletemessage")[0].setAttribute("style","display: none");
    document.getElementsByClassName("bg")[0].setAttribute("style","display: none");
}

if ( window.history.replaceState ) {
window.history.replaceState( null, null, window.location.href );
}