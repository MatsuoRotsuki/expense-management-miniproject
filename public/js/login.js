const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const emailErrorMessage = document.getElementById('email_error');
const passwordErrorMessage = document.getElementById('password_error');

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

emailInput.addEventListener('input', () => {
    if (!checkEmailFormat(emailInput.value)) {
        emailErrorMessage.classList.remove('invisible');
        emailInput.classList.add('error');
    } else {
        emailErrorMessage.classList.add('invisible');
        emailInput.classList.remove('error');
    }
})

passwordInput.addEventListener('input', () => {
    if (!checkPasswordFormat(passwordInput.value)) {
        passwordErrorMessage.classList.remove('invisible');
        passwordInput.classList.add('error');
    } else {
        passwordErrorMessage.classList.add('invisible');
        passwordInput.classList.remove('error');
    }
})

// async function showLoginSuccess() {
//     return new Promise((resolve) => {
//         Swal.fire({
//             icon: 'success',
//             title: 'Invalid',
//             text: 'Please wait a moment to change the page',
//             timer: 10000,
//             timerProgressBar: true,
//             showConfirmButton: false
//         }).then((result) => {
//             resolve();
//         });
//     });
// }

function checkOnSubmit() {
    if (!checkEmailFormat(emailInput.value) || !checkPasswordFormat(passwordInput.value)) {
        notifyInvalid('Invalid email or password')
        return false;
    }
    return true;
}