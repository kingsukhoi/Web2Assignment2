window.addEventListener('load', main);


function addPasswordCheck() {
    // from https://codepen.io/diegoleme/pen/surIK?editors=1010
    function validatePassword(){
        if(password.value !== confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    }
    const password = document.getElementById('password');
    const confirm_password = document.getElementById('confirm-password');
    password.addEventListener('change', validatePassword);
    confirm_password.addEventListener('keyup', validatePassword);
}

function main() {
    addPasswordCheck();
}
