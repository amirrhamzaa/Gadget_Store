function addProduct(){
    alert("Add Product");
}

function editProduct(){
    alert("Edit Product");
}

function deleteProduct(button){
    var result = confirm("Are you sure you want to delete this product?");
    
    if(result == true){
        var row = button.parentElement.parentElement;
        row.remove();
    }
}

function searchProduct(){
    var input = document.getElementById("search");
    var filter = input.value.toLowerCase();
    var table = document.getElementById("productTable");
    var rows = table.getElementsByTagName("tr");
    
    for(var i = 1; i < rows.length; i++){
        var product = rows[i].getElementsByTagName("td")[0];

        if(product){
            var text = product.innerText.toLowerCase();

            if(text.includes(filter)){
                rows[i].style.display = "";
            }
            else{
                rows[i].style.display = "none";
            }
        }
    }
}


function changeStatus(select){
    alert("Order status changed to " + select.value);
}

function updateStock(button){
    var row = button.parentElement.parentElement;
    var input = row.getElementsByClassName("stock-input")[0];
    var stockValue = row.getElementsByClassName("stock-value")[0];
    stockValue.innerHTML = input.value;
    alert("Stock updated successfully");
}

function validateSettings()
{
    let name = document.getElementById("sellerName").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    let address = document.getElementById("address").value;

    let hasNameError = false;
    let hasEmailError = false;
    let hasPhoneError = false;
    let hasAddressError = false;


    if(name == "")
    {
        document.getElementById("sellerNameError").innerHTML =
        "Seller name is required";

        hasNameError = true;
    }
    else
    {
        document.getElementById("sellerNameError").innerHTML = "";

        hasNameError = false;
    }


    if(email == "")
    {
        document.getElementById("emailError").innerHTML =
        "Email is required";

        hasEmailError = true;
    }
    else if(!email.includes("@"))
    {
        document.getElementById("emailError").innerHTML =
        "Enter a valid email";

        hasEmailError = true;
    }
    else
    {
        document.getElementById("emailError").innerHTML = "";

        hasEmailError = false;
    }


    if(phone == "")
    {
        document.getElementById("phoneError").innerHTML =
        "Phone number is required";

        hasPhoneError = true;
    }
    else if(phone.length < 11)
    {
        document.getElementById("phoneError").innerHTML =
        "Enter a valid phone number";

        hasPhoneError = true;
    }
    else
    {
        document.getElementById("phoneError").innerHTML = "";

        hasPhoneError = false;
    }


    if(address == "")
    {
        document.getElementById("addressError").innerHTML =
        "Address is required";

        hasAddressError = true;
    }
    else
    {
        document.getElementById("addressError").innerHTML = "";

        hasAddressError = false;
    }


    if(
        !hasNameError &&
        !hasEmailError &&
        !hasPhoneError &&
        !hasAddressError
    )
    {
        return true;
    }

    return false;
}