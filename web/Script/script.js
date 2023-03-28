
function validatePassword(){
    let password = document.getElementById("password")
        , password1 = document.getElementById("password1");
    if(password.value != password1.value) {
        password1.setCustomValidity("Les mots de passes ne correspondent pas");
    } else {
        password1.setCustomValidity('');
    }
}
function showModif(modif){
    alert("Enregistrer");
}
function aff(element){
    let elm = document.getElementById(element)
    if(getComputedStyle(elm).display != "none"){
        elm.style.display = "none";
    } else {
        elm.style.display = "block";
    }
}