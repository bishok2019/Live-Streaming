function successCallback(token) { 
    debugger;
}
// Generate a new captcha image
function generateCaptcha() {
    const captcha = generateRandomString(6);
    const captchaValueElement = document.getElementById('captchaValue');
    const captchaImageElement = document.getElementById('captchaImage');
    captchaValueElement.value = captcha;

    const canvas = document.createElement('canvas');
    canvas.width = 150;
    canvas.height = 40;

    const ctx = canvas.getContext('2d');
    ctx.font = 'bold 30px Arial';
    ctx.fillText(captcha, 20, 40);

    captchaImageElement.src = canvas.toDataURL();
    }

// Check if the entered captcha is right or wrong
// function validateCaptcha() {
//     const captchaValue = document.getElementById('captchaValue').value;
//     const userInput = document.getElementById('captchaInput').value;

//     if (userInput === '') {
//     document.getElementById('error').innerHTML = 'Please enter the captcha code!';
//     return false;
//     } else if (captchaValue !== userInput) {
//     document.getElementById('error').innerHTML = 'Incorrect captcha code!';
//     return false;
//     } else {
//     return true;
//     }
//     }

// Call generateCaptcha() on page load to generate an initial captcha code
    window.onload = function() {
    generateCaptcha();
    };
// Generate a random string of a given length
function generateRandomString(length) {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
    }

function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password",);
        var eyeButton = document.querySelector("img[alt='toggle password visibility']");
        if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeButton.src = "img/eye-close.png";
        eyeButton.alt = "hide password";
        } else {
        passwordInput.type = "password";
        eyeButton.src = "img/eye-close.png";
        eyeButton.alt = "show password";
        }
        }
function togglePasswordVisibility1() {
        var passwordInput = document.getElementById("cpassword");
        var eyeButton = document.querySelector("img[alt='toggle password visibility 1']");
        if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeButton.src = "img/eye-close.png";
        eyeButton.alt = "hide password";
        } else {
        passwordInput.type = "password";
        eyeButton.src = "img/eye-close.png";
        eyeButton.alt = "show password";
        }
        }       

function validatePassword() {
        var password = document.getElementById("password").value;
        var lowerCaseLetters = /[a-z]/g;
        var upperCaseLetters = /[A-Z]/g;
        var numbers = /[0-9]/g;
        var specialChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g;

        if (password.length < 8 || !password.match(lowerCaseLetters) ||
         !password.match(upperCaseLetters) || !password.match(numbers) || !password.match(specialChars)) {
            if (password.length < 8) {
                document.getElementById("password").setCustomValidity(
                    "Password must be at least 8 characters long.");
            } else {
                document.getElementById("password").setCustomValidity(
    "Password must contain at least one lowercase letter, one uppercase letter, one number, and one special character.");
            }
        } else {
            document.getElementById("password").setCustomValidity('');
        }
        }
     document.getElementById("password").addEventListener("input", validatePassword);


  