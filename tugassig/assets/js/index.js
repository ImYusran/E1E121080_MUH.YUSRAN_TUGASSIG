const inputUsername = document.getElementById('username');
const inputPassword = document.getElementById('password');
const submitBtn = document.getElementById('submitBtn');

submitBtn.setAttribute('disabled', true);

inputUsername.addEventListener('input', () => {
    validateInput();
})

inputPassword.addEventListener('input', () => {
    validateInput();
})

function validateInput() {
    var usernameValue = inputUsername.value.trim();
    var passwordValue = inputPassword.value.trim();

    if (usernameValue !== "" && passwordValue !== "") {
        submitBtn.removeAttribute('disabled');
    } else {
        submitBtn.setAttribute('disabled', true)
    }
}