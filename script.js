function validateForm() {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();

    if (name.length < 3) {
        alert("Name must be at least 3 characters");
        return false;
    }
    if (!email.includes("@") || !email.includes(".")) {
        alert("Please enter a valid email");
        return false;
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters");
        return false;
    }
    return true;
}
