function validateForm()
{
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let address = document.getElementById("address").value.trim();

    let isValid = true;

    document.getElementById("nameError").innerHTML = "";
    document.getElementById("emailError").innerHTML = "";
    document.getElementById("passwordError").innerHTML = "";
    document.getElementById("phoneError").innerHTML = "";
    document.getElementById("addressError").innerHTML = "";

    if (name === "")
    {
        document.getElementById("nameError").innerHTML = "Name is required";
        isValid = false;
    }
    else if (name.length < 4)
    {
        document.getElementById("nameError").innerHTML = "Name must be at least 4 characters";
        isValid = false;
    }

    if (email === "")
    {
        document.getElementById("emailError").innerHTML = "Email is required";
        isValid = false;
    }
    else if (!email.endsWith("@gmail.com"))
    {
        document.getElementById("emailError").innerHTML = "Email must end with @gmail.com";
        isValid = false;
    }

    if (password !== "")
    {
        if (password.length < 6)
        {
            document.getElementById("passwordError").innerHTML =
                "Password must be at least 6 characters";

            isValid = false;
        }
    }

    if (phone === "")
    {
        document.getElementById("phoneError").innerHTML =
            "Phone number is required";

        isValid = false;
    }
    else if (!/^[0-9]{11}$/.test(phone))
    {
        document.getElementById("phoneError").innerHTML =
            "Phone number must be exactly 11 digits";

        isValid = false;
    }
    else if (!phone.startsWith("01"))
    {
        document.getElementById("phoneError").innerHTML =
            "Phone number must start with 01";

        isValid = false;
    }

    if (address === "")
    {
        document.getElementById("addressError").innerHTML =
            "Address is required";

        isValid = false;
    }

    return isValid;
}