let validate = true;

function validateField(field, errorElement, regex, errorMessage) {
    if (field.value === "") {
        errorElement.innerHTML = "This field can't be empty";
        errorElement.style.color = "red";
        validate = false;
    } else if (!regex.test(field.value)) {
        errorElement.innerHTML = errorMessage;
        errorElement.style.color = "red";
        validate = false;
    } else {
        errorElement.innerHTML = ""; // Clear error message
    }
}

function NameValidate(n, n_er) {
    validateField(n, n_er, /^[A-Za-z\s]+$/, "Invalid value");
}

function EmailValidate(email, em_er) {
    validateField(email, em_er, /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/, "Invalid email format");
}

function PhnValidate(phn, phn_er) {
    validateField(phn, phn_er, /^[0-9]{10}$/, "Invalid mobile number format");
}

function BigTextValidate(txt, txt_er) {
    validateField(txt, txt_er, /^[A-Za-z0-9\s,.-]+$/, "Invalid Values");
}

function ZipValidate(z, z_er) {
    validateField(z, z_er, /^[0-9]{6}$/, "Invalid zip (length should be 6)");
}

function PwdValidate(pwd, pwd_er) {
    validateField(pwd, pwd_er, /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%?&])[A-Za-z\d@$!%?&]{8,}$/, 
                  "Password must be at least 8 characters long, contain an uppercase letter, a lowercase letter, a number, and a special character.");
}

function ImgValidate(img, img_er) {
    validateField(img, img_er, /.+/, "This field can't be empty");
}

function CommanValidate(cm, cm_er) {
    validateField(cm, cm_er, /.+/, "This field can't be empty");
}

function RateValidate(r, r_er) {
    validateField(r, r_er, /^[0-9]{1,100}$/, "Must be in numbers");
}

function PriceValidate(p, p_er) {
    validateField(p, p_er, /^[0-9]+$/, "Must be in numbers");
}

// Call this function on form submission
function validateForm() {
    validate = true; // Reset validate to true

    // Call validation functions
    NameValidate(document.getElementById('name'), document.getElementById('name_er'));
    EmailValidate(document.getElementById('email'), document.getElementById('email_er'));
    PwdValidate(document.getElementById('pwd'), document.getElementById('pwd_er'));
    // Call other validation functions as needed...

    if (validate) {
        document.getElementById('Login').submit(); // Submit the form if valid
    }
    return false; // Prevent default form submission
}