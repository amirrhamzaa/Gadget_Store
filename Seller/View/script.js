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