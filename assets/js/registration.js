
// load js after the dom content is loaded
document.addEventListener('DOMContentLoaded', function()
{
    // document.getElementById('submitRegistration').onclick = function()
    // {
    //     return validateInputs();
    // };

    // "Registrieren"-Button
    document.getElementById('submitRegistration').addEventListener('click', function(event)
    {
        if (!validateInputs())
        {
            event.preventDefault();
            event.stopPropagation();
        }

        validateInputs();
    });



    function validateInputs()
    {
        var validInputs = true;

        var firstName       = document.getElementById('firstname');
        var lastName        = document.getElementById('lastname');
        var email           = document.getElementById('email');
        var password        = document.getElementById('password');
        var passwordConfirm = document.getElementById('passwordconfirm');

        var errorSpanFName     = document.getElementById('errorFirstName');
        var errorSpanLName     = document.getElementById('errorLastName');
        var errorSpanEmail     = document.getElementById('errorEmail');
        var errorSpanPW        = document.getElementById('errorPW');
        var errorSpanPWConfirm = document.getElementById('errorPWConfirm');

        // validateFirstName(firstName);
        // validateLastName( lastName);
        // validateEmail(email);
        // validatePassword(password);
        // validatePasswordConfirm(password);


        // validateFirstName
        errorSpanFName.style.display = "block";
        firstName.className = "errorinput";

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



        // validateLastName
        errorSpanLName.style.display = "block";
        lastName.className = "errorinput";

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



        // validateEmail
        errorSpanEmail.style.display = "block";
        email.className = "errorinput";

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
        else if (invalidEmail())
        {
            validInputs = false;
            errorSpanEmail.textContent = "Bitte eine valide E-Mail angeben.";
        }
        else
        {
            errorSpanEmail.style.display = "none";
            email.className = email.className.replace('errorinput', '');
        }



        // check if email has pattern of x@x.xx
        function invalidEmail()
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



        // validatePassword
        errorSpanPW.style.display = "block";
        password.className = "errorinput";

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



        // validatePasswordConfirm
        errorSpanPWConfirm.style.display = "block";
        passwordConfirm.className = "errorinput";

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



        // red border for "Registrieren"-Button
        if (!validInputs)
        {
            document.getElementById('submitRegistration').style.border = "1px solid red";
        }


        return validInputs;
    }
})