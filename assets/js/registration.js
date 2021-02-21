
// load js after the dom content is loaded
document.addEventListener('DOMContentLoaded', function()
{
    // "Registrieren"-Button
    document.getElementById('submitRegistration').onclick = function()
    {
        return validateInputs();
    };



    function validateInputs()
    {
        var validInputs = true;

        var firstName       = document.getElementById('firstname');
        var lastName        = document.getElementById('lastname');
        var email           = document.getElementById('email');
        var password        = document.getElementById('password');
        var passwordConfirm = document.getElementById('passwordconfirm');

        // validateFirstName(firstName);
        // validateLastName( lastName);
        // validateEmail(email);
        // validatePassword(password);
        // validatePasswordConfirm(password);


        // validateFirstName
        document.getElementById('errorFirstName').style.display = "block";
        firstName.className = "errorinput";

        if (firstName.value == null || firstName.value == "")
        {
            validInputs = false;
            document.getElementById('errorFirstName').textContent = "Vorname darf nicht leer sein.";
        }
        else if (firstName.value.length < 2)
        {
            validInputs = false;
            document.getElementById('errorFirstName').textContent = "Vorname muss mind. 2 Zeichen lang sein.";
        }
        else if (firstName.value.length > 50)
        {
            validInputs = false;
            document.getElementById('errorFirstName').textContent = "Vorname darf max. 50 Zeichen lang sein.";
        }
        else
        {
            document.getElementById('errorFirstName').style.display = "none";
            firstName.className = firstName.className.replace('errorinput', '');
        }



        // validateLastName
        document.getElementById('errorLastName').style.display = "block";
        lastName.className = "errorinput";

        if (lastName.value == null || lastName.value == "")
        {
            validInputs = false;
            document.getElementById('errorLastName').textContent = "Nachname darf nicht leer sein.";
        }
        else if (lastName.value.length < 2)
        {
            validInputs = false;
            document.getElementById('errorLastName').textContent = "Nachname muss mind. 2 Zeichen lang sein.";
        }
        else if (lastName.value.length > 50)
        {
            validInputs = false;
            document.getElementById('errorLastName').textContent = "Nachname darf max. 50 Zeichen lang sein.";
        }
        else
        {
            document.getElementById('errorLastName').style.display = "none";
            lastName.className = lastName.className.replace('errorinput', '');
        }



        // validateEmail
        document.getElementById('errorEmail').style.display = "block";
        email.className = "errorinput";

        if (email.value == null || email.value == "")
        {
            validInputs = false;
            document.getElementById('errorEmail').textContent = "E-Mail darf nicht leer sein.";
        }
        else if (email.value.length > 120)
        {
            validInputs = false;
            document.getElementById('errorEmail').textContent = "E-Mail darf max. 120 Zeichen lang sein.";
        }
        else if (invalidEmail())
        {
            validInputs = false;
            document.getElementById('errorEmail').textContent = "Bitte eine valide E-Mail angeben.";
        }
        else
        {
            document.getElementById('errorEmail').style.display = "none";
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
        document.getElementById('errorPW').style.display = "block";
        password.className = "errorinput";

        var uppercase    = password.value.match('[A-Z]+');
        var lowercase    = password.value.match('[a-z]+');
        var number       = password.value.match('[0-9]+');
        var specialChars = password.value.match('[^a-zA-Z0-9]+');
        
        if (password.value == null || password.value == "")
        {
            validInputs = false;
            document.getElementById('errorPW').textContent = "Passwort darf nicht leer sein.";
        }
        else if (password.value.length < 8)
        {
            validInputs = false;
            document.getElementById('errorPW').textContent = "Passwort muss mind. 8 Zeichen lang sein.";
        }
        else if (password.value.length > 255)
        {
            validInputs = false;
            document.getElementById('errorPW').textContent = "Passwort darf max. 255 Zeichen lang sein.";
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
            document.getElementById('errorPW').textContent = errorMessage;
        }
        else
        {
            document.getElementById('errorPW').style.display = "none";
            password.className = password.className.replace('errorinput', '');
        }



        // validatePasswordConfirm
        document.getElementById('errorPWConfirm').style.display = "block";
        passwordConfirm.className = "errorinput";

        if (password.value != passwordConfirm.value || passwordConfirm.value == "")
        {
            validInputs = false;
            document.getElementById('errorPWConfirm').textContent = "Passwörter stimmen nicht überein.";
        }
        else
        {
            document.getElementById('errorPWConfirm').style.display = "none";
            passwordConfirm.className = passwordConfirm.className.replace('errorinput', '');
        }


        return validInputs;
    }
})