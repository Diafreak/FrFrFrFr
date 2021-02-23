// load js after the dom content is loaded
document.addEventListener('DOMContentLoaded', function()
{
    // "Email ändern"-Button
    document.getElementById('submitEmailChange').addEventListener('click', function(event)
    {
        if (!validateEmailInput())
        {
            event.preventDefault();
            event.stopPropagation();
        }
    });


    // "Passwort ändern"-Button
    document.getElementById('submitPasswordChange').addEventListener('click', function(event)
    {
        if (!validatePasswortInputs())
        {
            event.preventDefault();
            event.stopPropagation();
        }
    });


    // "Adresse ändern/hinzufügen"-Button
    document.getElementById('submitAddress').addEventListener('click', function(event)
    {
        if (!validateAddressInputs())
        {
            event.preventDefault();
            event.stopPropagation();
        }
    });
})



// =========================================
// =============== FUNCTIONS ===============
// =========================================

function validateEmailInput()
{
    validInput = true;

    var email = document.getElementById('chemail');

    var errorSpan    = document.getElementById('errorEmail');
    var errorSpanPHP = document.getElementById('errorPHPemail');

    validInput = validEmail(errorSpan, email, validInput);

    if (!validInput)
    {
        errorSpanPHP.style.display = "none";
        document.getElementById('submitEmailChange').style.border = "1px solid red";
    }

    return validInput;
}



function validatePasswortInputs()
{
    validInputs = true;

    var oldPW        = document.getElementById('oldPassword');
    var newPW        = document.getElementById('newPassword');
    var newPWConfirm = document.getElementById('newPasswordConfirm');

    var errorSpan          = document.getElementById('errorPW');
    var errorSpanPWConfirm = document.getElementById('errorPWConfirm');
    var errorSpanPHP       = document.getElementById('errorPHPpassword');


    validInputs = validPassword(errorSpan, oldPW, newPW, validInputs);
    validInputs = validPasswordConfirm(errorSpanPWConfirm, newPW, newPWConfirm, validInputs);

    if (!validInputs)
    {
        errorSpanPHP.style.display = "none";
        document.getElementById('submitPasswordChange').style.border = "1px solid red";
    }

    return validInputs;
}



// ===================================================
// =============== EXTRACTED FUNCTIONS ===============
// ===================================================

function validEmail(errorSpan, email, validInputs)
{
    errorSpan.style.display = "block";
    email.className         = "errorinput";

    if (email.value == null || email.value == "")
    {
        validInputs = false;
        errorSpan.textContent = "E-Mail darf nicht leer sein.";
    }
    else if (email.value.length > 120)
    {
        validInputs = false;
        errorSpan.textContent = "E-Mail darf max. 120 Zeichen lang sein.";
    }
    else if (invalidEmailPattern())
    {
        validInputs = false;
        errorSpan.textContent = "Bitte eine valide E-Mail angeben.";
    }
    else
    {
        errorSpan.style.display = "none";
        email.className = email.className.replace('errorinput', '');
    }

    return validInputs;
}


// check if email has pattern of x@x.xx
function invalidEmail(email)
{
    var regexEmail = /^[^@]+@[^@]+\.([^@]+){2,}$/m;

    // return false if email matches the regex
    if (email.value.match(regexEmail))
    {
        return false;
    }

    // return true if the email doesn't match the regex
    return true;
}



function validPassword(errorSpanPW, oldPw, newPw, validInputs)
{
    errorSpanPW.style.display = "block";
    newPw.className           = "errorinput";

    if (newPw != null && newPw.value != null && newPw.value != "")
    {
        var uppercase    = newPw.value.match('[A-Z]+');
        var lowercase    = newPw.value.match('[a-z]+');
        var number       = newPw.value.match('[0-9]+');
        var specialChars = newPw.value.match('[^a-zA-Z0-9]+');
    }

    if (oldPw == null || oldPw.value == null || oldPw.value == "")
    {
        oldPw.className         = "errorinput";
        validInputs = false;
        errorSpanPW.textContent = "Bitte altes Passwort angeben.";
    }
    // if new password is empty
    else if (newPw == null || newPw.value == null || newPw.value == "")
    {
        validInputs = false;
        errorSpanPW.textContent = "Neues Passwort darf nicht leer sein.";
    }
    // if new password has less chars than 8
    else if (newPw.value.length < 8)
    {
        validInputs = false;
        errorSpanPW.textContent = "Passwort muss mind. 8 Zeichen lang sein.";
    }
    // if new password is longer than 255
    else if (newPw.value.length > 255)
    {
        validInputs = false;
        errorSpanPW.textContent = "Passwort darf max. 255 Zeichen lang sein.";
    }
    // if password does not have at least: 1 Upper-, 1 lowercase letter, 1 number and 1 specialChar
    else if (!uppercase || !lowercase || !number || !specialChars)
    {
        validInputs = false;

        // create error message with what the password is missing
        var errorMessage = "Passwort muss noch mind. ";

        if (!uppercase)    errorMessage += "1 Großbuchstaben, ";
        if (!lowercase)    errorMessage += "1 Kleinbuchstaben, ";
        if (!number)       errorMessage += "1 Zahl, ";
        if (!specialChars) errorMessage += "1 Sonderzeichen, ";

        // remove last comma
        errorMessage = errorMessage.replace(/,\s*$/, " ");

        errorMessage += "entahlten.";
        errorSpanPW.textContent = errorMessage;
    }
    // password is valid
    else
    {
        errorSpanPW.style.display = "none";
        newPs.className = newPw.className.replace('errorinput', '');
    }

    if (oldPw.value != null && oldPw.value != "")
    {
        oldPw.className = oldPw.className.replace('errorinput', '');
    }

    return validInputs;
}


function validPasswordConfirm(errorSpanPWConfirm, newPW, pwConfirm, validInputs)
{
    errorSpanPWConfirm.style.display = "block";
    pwConfirm.className              = "errorinput";

    if (newPW.value != pwConfirm.value || pwConfirm.value == "")
    {
        validInputs = false;
        errorSpanPWConfirm.textContent = "Passwörter stimmen nicht überein.";
    }
    else
    {
        errorSpanPWConfirm.style.display = "none";
        pwConfirm.className = pwConfirm.className.replace('errorinput', '');
    }

    return validInputs;
}