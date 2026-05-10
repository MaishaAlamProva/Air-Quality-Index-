function Validate() {
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirmpassword').value;
    let location = document.getElementById('location').value;
    let zipcode = document.getElementById('zipcode').value;
    let city = document.getElementById('city').value;
    let color = document.getElementById('color').value;
    let terms = document.getElementById('terms').checked;

    const emailRegex = /^\d{2}-\d{5}-\d@student\.aiub\.edu$/i;
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])[A-Za-z\d@$!%*#?&]{6,}$/;
    const zipcodeRegex = /^\d{4}$/;
    const locationRegex = /^[A-Za-z\s]+$/;

    const errorElement = document.getElementById('error');

    // Clear previous errors
    errorElement.innerHTML = '';

    if (email === "" || password === "" || confirmPassword === "" || 
        location === "" || zipcode === "" || city === "" || color === "") {
        errorElement.innerHTML = "*Please fill all the fields first";
        return false;
    }

    if (!terms) {
        errorElement.innerHTML = "*Please accept terms and conditions";
        return false;
    }

    if (!emailRegex.test(email.trim())) {
        errorElement.innerHTML = "*Email must be like xx-xxxxx-x@student.aiub.edu";
        return false;
    }

    if (!passwordRegex.test(password)) {
        errorElement.innerHTML = "*Password must be at least 6 characters with an uppercase letter, number, and special character";
        return false;
    }

    if (password !== confirmPassword) {
        errorElement.innerHTML = "*Passwords don't match";
        return false;
    }

    if (!locationRegex.test(location.trim())) {
        errorElement.innerHTML = "*Location must contain only letters and spaces";
        return false;
    }

    if (!zipcodeRegex.test(zipcode.trim())) {
        errorElement.innerHTML = "*Zip code must be 4 digits";
        return false;
    }

    if (color === "#000000") {
        errorElement.innerHTML = "*Please pick a color";
        return false;
    }

    errorElement.style.color = "green";
    errorElement.innerHTML = "Form submitted successfully!!";
    return true;
}