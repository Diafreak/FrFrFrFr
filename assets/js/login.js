
// load js after the dom content is loaded
document.addEventListener('DOMContentLoaded', function()
{
    // "Login"-Button
    document.getElementById('submitLogin').onclick = function()
    {
        return validateInputs();
    };



    function validateInputs()
    {
        var validInputs = true;

        var email     = document.getElementById('email');
        var password  = document.getElementById('password');

        var errorSpan = document.getElementById('errorEmptyFields');


        // check if fields are empty
        errorSpan.style.display = "block";
        errorSpan.textContent   = "Alle Felder müssen ausgefüllt sein!";
        email.className    = "errorinput";
        password.className = "errorinput";

        if (email.value    == null || email.value    == ""
        &&  password.value == null || password.value == "")
        {
            validInputs = false;
        }
        else if (email.value == null || email.value == "")
        {
            validInputs = false;
            password.className = password.className.replace('errorinput', '');
        }
        else if (password.value == null || password.value == "")
        {
            validInputs = false;
            email.className = email.className.replace('errorinput', '');
        }
        else
        {
            errorSpan.textContent   = "";
            errorSpan.style.display = "none";
            email.className    = email.className.   replace('errorinput', '');
            password.className = password.className.replace('errorinput', '');
        }


        // red border for "Login"-Button
        if (!validInputs)
        {
            document.getElementById('submitLogin').style.border = "1px solid red";
        }


        return validInputs;
    }
})