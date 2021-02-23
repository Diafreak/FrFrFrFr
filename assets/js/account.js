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


    // "Produkt hinzufügen"-Button
    document.getElementById('submitNewProduct').addEventListener('click', function(event)
    {
        if (!validateNewProductInputs())
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

    validInput = validEmail(errorSpan, email, validInputs);

    if (!validInput)
    {
        errorSpanPHP.style.display = "none";
        document.getElementById('submitEmailChange').style.border = "1px solid red";
    }

    return validInput;
}



function validatePasswortInputs()
{
    validInput = true;

    var password = document.getElementById('chemail');
    var password = document.getElementById('chemail');

    var errorSpan    = document.getElementById('errorEmail');
    var errorSpanPHP = document.getElementById('errorPHPemail');

    validInput = validPassword(errorSpan, password, validInputs);

    if (!validInput)
    {
        errorSpanPHP.style.display = "none";
        document.getElementById('submitEmailChange').style.border = "1px solid red";
    }

    return validInput;
}


function validateAddressInputs()
{

}


function validateNewProductInputs()
{

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



function validPassword(errorSpanPW, password, validInputs)
{
    errorSpanPW.style.display = "block";
    password.className        = "errorinput";

    var uppercase    = password.value.match('[A-Z]+');
    var lowercase    = password.value.match('[a-z]+');
    var number       = password.value.match('[0-9]+');
    var specialChars = password.value.match('[^a-zA-Z0-9]+');

    if (password.value == null || password.value == "")
    {
        validInputs = false;
        errorSpanPW.textContent = "Passwort darf nicht leer sein.";
    }
    else if (password.value.length < 8)
    {
        validInputs = false;
        errorSpanPW.textContent = "Passwort muss mind. 8 Zeichen lang sein.";
    }
    else if (password.value.length > 255)
    {
        validInputs = false;
        errorSpanPW.textContent = "Passwort darf max. 255 Zeichen lang sein.";
    }
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
    else
    {
        errorSpanPW.style.display = "none";
        password.className = password.className.replace('errorinput', '');
    }

    return validInputs;
}