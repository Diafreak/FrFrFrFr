
// load js after the dom content is loaded
document.addEventListener('DOMContentLoaded', function()
{
    // "Registrieren"-Button
    document.getElementById('submitRegistration').addEventListener('click', function(event)
    {
        if (!validateInputs())
        {
            event.preventDefault();
            event.stopPropagation();
        }
    });


    document.getElementById('email').addEventListener('keyup', function()
    {
        checkEmailExistence();
    });
})



// =========================================
// =============== FUNCTIONS ===============
// =========================================

function validateInputs()
{
    var validInputs = true;

    // input fields
    var firstName       = document.getElementById('firstname');
    var lastName        = document.getElementById('lastname');
    var email           = document.getElementById('email');
    var password        = document.getElementById('password');
    var passwordConfirm = document.getElementById('passwordconfirm');

    // error spans that display the errors
    var errorSpanFName     = document.getElementById('errorFirstName');
    var errorSpanLName     = document.getElementById('errorLastName');
    var errorSpanEmail     = document.getElementById('errorEmail');
    var errorSpanPW        = document.getElementById('errorPW');
    var errorSpanPWConfirm = document.getElementById('errorPWConfirm');

    // validate each input, if just one of them fails this function returns false
    validInputs = validFirstName(      errorSpanFName,     firstName,       validInputs);
    validInputs = validLastName(       errorSpanLName,     lastName,        validInputs);
    validInputs = validEmail(          errorSpanEmail,     email,           validInputs);
    validInputs = validPassword(       errorSpanPW,        password,        validInputs);
    validInputs = validPasswordConfirm(errorSpanPWConfirm, passwordConfirm, validInputs);


    if (!validInputs)
    {
        // hide PhP Errors so only JS Errors are displayed
        document.getElementById('errorsPHP').style.display = "none";
        // red border for "Registrieren"-Button
        document.getElementById('submitRegistration').style.border = "1px solid red";
    }

    return validInputs;
}


function checkEmailExistence()
{
    validInputs = true;

    var email     = document.getElementById('email');
    var errorSpan = document.getElementById('errorEmailExists');
    var errorSpanEmail     = document.getElementById('errorEmail');

    // only check for email-existence if the entered email is valid
    if (validEmailInputs(email))
    {
        // create a new xhttp-request
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function()
        {
            // check if the response is done and no error happened
            if (this.readyState == 4 && this.status == 200)
            {
                errorSpanEmail.style.display = "none";
                // responseText is false if the email is not in the database
                if (this.responseText == "false")
                {
                    email.style.border = "1px solid green";
                    errorSpan.style.color   = "green";
                    errorSpan.style.display = "block";
                    errorSpan.textContent   = "Email noch nicht vorhanden.";
                }
                // responseText is true if the email is already in the database
                else if (this.responseText == "true")
                {
                    email.style.border = "1px solid red";
                    errorSpan.style.color   = "red";
                    errorSpan.style.display = "block";
                    errorSpan.textContent   = "Email bereits vorhanden!";
                }
            }
        }

        // asynchronous POST request
        xhttp.open("POST", "helper/ajaxValidation/emailExists.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("e="+email.value);
    }
    else
    {
        errorSpan.style.display = "none";
    }
}



// ===================================================
// =============== EXTRACTED FUNCTIONS ===============
// ===================================================

function validFirstName(errorSpanFName, firstName, validInputs)
{
    errorSpanFName.style.display = "block";
    firstName.className          = "errorinput";

    if (firstName.value == null || firstName.value == "")
    {
        validInputs = false;
        errorSpanFName.textContent = "Vorname darf nicht leer sein.";
    }
    else if (firstName.value.length < 2)
    {
        validInputs = false;
        errorSpanFName.textContent = "Vorname muss mind. 2 Zeichen lang sein.";
    }
    else if (firstName.value.length > 50)
    {
        validInputs = false;
        errorSpanFName.textContent = "Vorname darf max. 50 Zeichen lang sein.";
    }
    else
    {
        errorSpanFName.style.display = "none";
        firstName.className = firstName.className.replace('errorinput', '');
    }

    return validInputs;
}


function validLastName(errorSpanLName, lastName, validInputs)
{
    errorSpanLName.style.display = "block";
    lastName.className           = "errorinput";

    if (lastName.value == null || lastName.value == "")
    {
        validInputs = false;
        errorSpanLName.textContent = "Nachname darf nicht leer sein.";
    }
    else if (lastName.value.length < 2)
    {
        validInputs = false;
        errorSpanLName.textContent = "Nachname muss mind. 2 Zeichen lang sein.";
    }
    else if (lastName.value.length > 50)
    {
        validInputs = false;
        errorSpanLName.textContent = "Nachname darf max. 50 Zeichen lang sein.";
    }
    else
    {
        errorSpanLName.style.display = "none";
        lastName.className = lastName.className.replace('errorinput', '');
    }

    return validInputs;
}


function validEmail(errorSpanEmail, email, validInputs)
{
    errorSpanEmail.style.display = "block";
    email.className              = "errorinput";

    if (email.value == null || email.value == "")
    {
        validInputs = false;
        errorSpanEmail.textContent = "E-Mail darf nicht leer sein.";
    }
    else if (email.value.length > 120)
    {
        validInputs = false;
        errorSpanEmail.textContent = "E-Mail darf max. 120 Zeichen lang sein.";
    }
    else if (invalidEmailPattern())
    {
        validInputs = false;
        errorSpanEmail.textContent = "Bitte eine valide E-Mail angeben.";
    }
    else
    {
        errorSpanEmail.style.display = "none";
        email.className = email.className.replace('errorinput', '');
    }

    return validInputs;
}


// function for the ajax-validation of the email, since we only want to know
// if it is valid and do not want to output any errors
function validEmailInputs(email)
{
    if (email.value == null || email.value == ""
    ||  email.value.length > 120
    || invalidEmailPattern())
    {
        return false;
    }

    return true;
}



// check if email has pattern of x@x.xx
function invalidEmailPattern()
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



function validPasswordConfirm(errorSpanPWConfirm, passwordConfirm, validInputs)
{
    errorSpanPWConfirm.style.display = "block";
    passwordConfirm.className        = "errorinput";

    if (password.value != passwordConfirm.value || passwordConfirm.value == "")
    {
        validInputs = false;
        errorSpanPWConfirm.textContent = "Passwörter stimmen nicht überein.";
    }
    else
    {
        errorSpanPWConfirm.style.display = "none";
        passwordConfirm.className = passwordConfirm.className.replace('errorinput', '');
    }

    return validInputs;
}