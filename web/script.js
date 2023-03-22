var password = document.getElementById("password")
    , confirm_password = document.getElementById("password1");

function validatePassword(){
    if(password.value != password1.value) {
        password1.setCustomValidity("Mot de passe non identiques");
    } else {
        password1.setCustomValidity('');
    }
}

password.onchange = validatePassword;
password1.onkeyup = validatePassword;