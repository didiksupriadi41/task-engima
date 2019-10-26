var username = document.getElementById('username-field');
var email = document.getElementById('email-field');
var phone = document.getElementById('phone-field');
var password = document.getElementById('password-field');
var confirmPassword = document.getElementById('confirmPassword-field');
var usernameWrapper = document.getElementById('username-wrapper');
var emailWrapper = document.getElementById('email-wrapper');
var phoneWrapper = document.getElementById('phone-wrapper');
var passwordWrapper = document.getElementById('password-wrapper');
var confirmPasswordWrapper = document.getElementById('confirmPassword-wrapper');

var filePathField = document.getElementById('filePath-field');
var fileField = document.getElementById('file-field');
var fileButton = document.getElementById('btn-file');

var formRegister = document.getElementById('form-register');
var submitButton = document.getElementById('btn-submit');

var valid = true;
var validUsername = true;
var validEmail = true;
var validPhone = true;

var loc = window.location.pathname;
loc = loc.split("/");
var dir = loc.slice(0, loc.lastIndexOf("public") + 1).join("/");


function errorMessage(message, parent) {
    var node = document.createElement('div');
    var textNode = document.createTextNode(message);
    node.appendChild(textNode);
    node.classList.add('error-message');

    if (parent.lastChild.className == 'error-message') {
        parent.removeChild(parent.lastChild);
    }

    parent.appendChild(node);
}

function validateEmail(email, emailWrapper) {
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)||(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (re.test(String(email).toLowerCase())) {
        return true;
    }
    errorMessage('Email is not valid!', emailWrapper);
    return false;
}

function validatePhone(phone, phoneWrapper) {
    var re = /^[0-9]{9,12}$/
    if (re.test(String(phone).toLowerCase())) {

        return true;
    }
    errorMessage('Phonenumber is not valid!', phoneWrapper);
    return false;
}

function validateUsername(username, usernameWrapper) {
    var re = /^[a-z0-9_]{3,15}$/
    if (re.test(String(username).toLowerCase())) {
        return true;
    }
    errorMessage('Username is not valid!', usernameWrapper);
    return false;

}

function validateEmpty(field, type, parent) {
    if (field.value == '') {
        errorMessage(type + ' cannot be empty!', parent);
        return false;
    }
    return true;
}

function ajax(type, value, field, parent) {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = (JSON.parse(xhr.responseText).result);
            if (!response) {
                field.style.border = '1px solid green';
            } else {
                var message = type + ' ' + value + ' is exist! Please use another ' + type;
                errorMessage(message, parent);
                switch (type) {
                    case "username":
                        validUsername = false;
                        break;
                    case "email":
                        validEmail = false;
                        break;
                    case "phone":
                        validPhone = false;
                        break;
                    default:
                        break;
                }

            }
        }
    }

    xhr.open('GET', dir + '/api/validate?type=' + type + '&value=' + value);
    xhr.send();
}

username.addEventListener('change', function () {

    valid = true;
    this.style.border = '';
    if (usernameWrapper.lastChild.className == 'error-message') {
        usernameWrapper.removeChild(usernameWrapper.lastChild);
    }
    if (validateUsername(this.value, usernameWrapper)) {
        validUsername = true;
        ajax('username', this.value, username, usernameWrapper);
    } else {
        valid = false;
    }
});

email.addEventListener('change', function () {
    valid = true;
    this.style.border = '';
    if (emailWrapper.lastChild.className == 'error-message') {
        emailWrapper.removeChild(emailWrapper.lastChild);
    }
    if (validateEmail(this.value, emailWrapper)) {
        validEmail = true;
        ajax('email', this.value, email, emailWrapper);
    } else {
        valid = false;
    }
});

phone.addEventListener('change', function () {
    valid = true;
    this.style.border = '';
    if (phoneWrapper.lastChild.className == 'error-message') {
        phoneWrapper.removeChild(phoneWrapper.lastChild);
    }
    if (validatePhone(this.value, phoneWrapper)) {
        validPhone = true;
        ajax('phone', this.value, phone, phoneWrapper);
    } else {
        valid = false;
    }
});

password.addEventListener('change', function () {
    valid = true;
    this.style.border = '';
    if (passwordWrapper.lastChild.className == 'error-message') {
        passwordWrapper.removeChild(passwordWrapper.lastChild);
    }
    if (validateEmpty(password, 'password', passwordWrapper)) {
        password.style.border = '1px solid green';
    }
});

confirmPassword.addEventListener('change', function () {
    valid = true;
    this.style.border = '';
    if (confirmPasswordWrapper.lastChild.className == 'error-message') {
        confirmPasswordWrapper.removeChild(confirmPasswordWrapper.lastChild);
    }
    if (this.value == password.value) {
        confirmPassword.style.border = '1px solid green';
    } else {
        errorMessage('Password and Confirm Password doesn\'t match', confirmPasswordWrapper)
        valid = false
    }
});

fileButton.addEventListener('click', function (e) {
    e.preventDefault();
    fileField.click();
});

fileField.addEventListener('change', function () {
    filePathField.value = fileField.files[0].name;
});

submitButton.addEventListener('click', function (e) {
    e.preventDefault();
    if (!validateEmail(email.value, emailWrapper)) {
        valid = false;
    }
    if (!validatePhone(phone.value, phoneWrapper)) {
        valid = false;
    }
    if (!validateUsername(username.value, usernameWrapper)) {
        valid = false;
    }
    if (!validateEmpty(username, 'username', usernameWrapper)) {
        valid = false;
    }
    if (!validateEmpty(email, 'email', emailWrapper)) {
        valid = false;
    }
    if (!validateEmpty(phone, 'phone', phoneWrapper)) {
        valid = false;
    }
    if (!validateEmpty(password, 'password', passwordWrapper)) {
        valid = false;
    }
    if (!validateEmpty(confirmPassword, 'confirmPassword', confirmPasswordWrapper)) {
        valid = false;
    }
    if (password.value != confirmPassword.value) {
        valid = false;
    }

    if (valid && validUsername && validEmail && validPhone) {
        formRegister.submit();
    }
})