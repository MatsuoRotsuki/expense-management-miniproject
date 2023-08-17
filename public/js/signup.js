const emailInput = document.getElementsByName('email').item(0);
const passwordInput = document.getElementsByName('password').item(0);
const firstNameInput = document.getElementsByName('firstname').item(0);
const lastNameInput = document.getElementsByName('lastname').item(0);
const confirmpasswordInput = document.getElementsByName('confirmpassword').item(0);

const emailErrorMessage = document.getElementById('email_error');
const passwordErrorMessage = document.getElementById('password_error');
const firstnameErrorErrorMessage = document.getElementById('firstname_error');
const lastnameErrorErrorMessage = document.getElementById('lastname_error');
const passwordConfirmErrorMessage = document.getElementById('confirmpassword_error');

function notifyInvalid(message) {
    Swal.fire({
        icon: 'error',
        title: 'Invalid',
        text: message,
    });
}

function checkEmailFormat(email) {
    var pattern = /^[\w.-]+@[\w.-]+\.\w+$/;
    return pattern.test(email);
}

function checkPasswordFormat(inputString) {
    var pattern = /^.{7,}$/;
    return pattern.test(inputString);
}

function checkNameFormat(inputString) {
    var pattern = /^.{1,}$/;
    return pattern.test(inputString);
}


const arrayField = [
    {
        field: emailInput,
        error: emailErrorMessage,
        check: checkEmailFormat
    },
    {
        field: passwordInput,
        error: passwordErrorMessage,
        check: checkPasswordFormat
    },
    {
        field: firstNameInput,
        error: firstnameErrorErrorMessage,
        check: checkNameFormat
    },
    {
        field: lastNameInput,
        error: lastnameErrorErrorMessage,
        check: checkNameFormat
    },
    {
        field: confirmpasswordInput,
        error: passwordConfirmErrorMessage,
        check: checkPasswordFormat
    },
]

arrayField.forEach(item => {
    item.field.addEventListener('input', () => {
        if (!item.check(item.field.value)) {
            item.error.classList.remove('invisible')
            item.field.classList.add('error')
        } else {
            item.error.classList.add('invisible')
            item.field.classList.remove('error')
        }
    })
})

function checkOnSubmit() {
    if (
        !checkEmailFormat(emailInput.value)
        || !checkPasswordFormat(passwordInput.value)
        || !checkNameFormat(firstNameInput.value)
        || !checkNameFormat(lastNameInput.value)
        || !checkPasswordFormat(confirmpasswordInput.value)
    ) {
        notifyInvalid('Invalid field exists')
        return false;
    }

    if (confirmpasswordInput.value !== passwordInput.value) {
        notifyInvalid('Password and confirm password do not match!')
        return false;
    }

    return true;
}