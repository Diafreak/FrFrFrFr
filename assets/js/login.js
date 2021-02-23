
// load js after the dom content is loaded
document.addEventListener('DOMContentLoaded', function()
{
    // document.getElementById('submitLogin').onclick = function()
    // {
    //     return validateInputs();
    // };

    // "Login"-Button
    document.getElementById('submitLogin').addEventListener('click', function(event)
    {
        if (!validateInputs())
        {
            event.preventDefault();
            event.stopPropagation();
        }
    });



    function validateInputs()
    {
        var validInputs = true;

        var email     = document.getElementById('email');
        var password  = document.getElementById('password');

        var errorSpan    = document.getElementById('errorEmptyFields');
        var errorSpanPHP = document.getElementById('errorPHP');


        // check if fields are empty
        validInputs = checkForEmptyFields(errorSpan, email, password, validInputs)


        if (!validInputs)
        {
            // hide php errors when showing JS errors
            errorSpanPHP.style.display = "none";
            // red border for "Login"-Button
            document.getElementById('submitLogin').style.border = "1px solid red";
        }
        // green border for "Login"-Button
        else
        {
            document.getElementById('submitLogin').style.border = "1px solid green";
        }


        return validInputs;
    }
})



// =========================================
// =============== FUNCTIONS ===============
// =========================================

function checkForEmptyFields(errorSpan, email, password, validInputs)
{
    errorSpan.style.display = "block";
    errorSpan.textContent   = "Alle Felder müssen ausgefüllt sein!";
    email.className    = "errorinput";
    password.className = "errorinput";

    // if both fields are empty
    if ( (email.value    == null || email.value    == "")
    &&   (password.value == null || password.value == "") )
    {
        validInputs = false;
    }
    // if email is empty
    else if (email.value == null || email.value == "")
    {
        validInputs = false;
        password.className = password.className.replace('errorinput', '');
    }
    // if password is empty
    else if (password.value == null || password.value == "")
    {
        validInputs = false;
        email.className = email.className.replace('errorinput', '');
    }
    // if all fields are filled
    else
    {
        errorSpan.textContent   = "";
        errorSpan.style.display = "none";
        email.className    = email.className.   replace('errorinput', '');
        password.className = password.className.replace('errorinput', '');
    }

    return validInputs;
}