// load js after the dom content is loaded
document.addEventListener('DOMContentLoaded', function()
{

    // =======================================
    // =============== BUTTONS ===============
    // =======================================

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




    // =========================================
    // =============== FUNCTIONS ===============
    // =========================================

    function validateEmailInput()
    {
        validInput = true;

        var email = document.getElementById('chemail');

        var errorSpan    = document.getElementById('errorEmail');
        var errorSpanPHP = document.getElementById('errorPHPemail');

        errorSpan.style.display = "block";
        email.className = "errorinput";

        if (email.value == null || email.value == "")
        {
            validInput = false;
            errorSpan.textContent = "E-Mail darf nicht leer sein.";
        }
        else if (email.value.length > 120)
        {
            validInput = false;
            errorSpan.textContent = "E-Mail darf max. 120 Zeichen lang sein.";
        }
        else if (invalidEmail(email))
        {
            validInput = false;
            errorSpan.textContent = "Bitte eine valide E-Mail angeben.";
        }
        else
        {
            errorSpan.style.display = "none";
            email.className = email.className.replace('errorinput', '');
        }

        if (!validInput)
        {
            errorSpanPHP.style.display = "none";
            document.getElementById('submitEmailChange').style.border = "1px solid red";
        }

        return validInput;
    }



    function validatePasswortInputs()
    {

    }


    function validateAddressInputs()
    {

    }


    function validateNewProductInputs()
    {

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


})