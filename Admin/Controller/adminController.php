<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
require_once("../Model/DatabaseConnection.php");

if (!isset($_SESSION["isLoggedIn"])) { http_response_code(401); echo json_encode(["success"=>false,"message"=>"Please login first."]); exit(); }

$db = new DatabaseConnection();
$connection = $db->openConnection();
$action = $_POST["action"] ?? "";

function respond($success, $message = "") { echo json_encode(["success"=>$success,"message"=>$message]); exit(); }
function clean($connection, $value) { return $connection->real_escape_string(trim((string)$value)); }

switch ($action) {
    case "add_product":
    case "update_product":
        $id = (int)($_POST["id"] ?? 0);
        $name = clean($connection, $_POST["product_name"] ?? "");
        $description = clean($connection, $_POST["description"] ?? "");
        $price = (float)($_POST["price"] ?? 0);
        $stock = (int)($_POST["stock"] ?? 0);
        $category = clean($connection, $_POST["category"] ?? "");
        $status = clean($connection, $_POST["status"] ?? "Active");
        $image = "";
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . "/../View/uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $allowed = ["jpg","jpeg","png","gif","webp"];
            if (in_array($ext, $allowed, true)) {
                $fileName = uniqid("product_", true) . "." . $ext;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadDir.$fileName)) $image = "uploads/".$fileName;
            }
        }
        if ($action === "add_product") {
            $stmt=$connection->prepare("INSERT INTO products (product_name,description,price,stock,category,image,status) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("ssdiiss",$name,$description,$price,$stock,$category,$image,$status);
        } else {
            if ($image !== "") { $stmt=$connection->prepare("UPDATE products SET product_name=?,description=?,price=?,stock=?,category=?,image=?,status=? WHERE id=?"); $stmt->bind_param("ssdiissi",$name,$description,$price,$stock,$category,$image,$status,$id); }
            else { $stmt=$connection->prepare("UPDATE products SET product_name=?,description=?,price=?,stock=?,category=?,status=? WHERE id=?"); $stmt->bind_param("ssdissi",$name,$description,$price,$stock,$category,$status,$id); }
        }
        
        if ($action === "update_product" && $image === "") {
            $sql = "UPDATE products SET product_name='$name',description='$description',price=$price,stock=$stock,category='$category',status='$status' WHERE id=$id";
            if (!$connection->query($sql)) respond(false,$connection->error);
        } else if (!$stmt->execute()) respond(false,$stmt->error);
        respond(true);

    case "add_user":
    case "update_user":
        $id=(int)($_POST["id"]??0); $name=clean($connection,$_POST["name"]??""); $email=clean($connection,$_POST["email"]??""); $phone=clean($connection,$_POST["phone"]??"");
        $role=($_POST["role"]??"")==="Delivery Agent" ? "Delivery" : clean($connection,$_POST["role"]??"Customer");
        $status=clean($connection,$_POST["status"]??"Active"); $address=clean($connection,$_POST["address"]??""); $password=$_POST["password"]??"";
        if ($action === "add_user") {
            if (strlen($password)<6) respond(false,"Password must be at least 6 characters.");
            $hash=password_hash($password,PASSWORD_DEFAULT);
            $stmt=$connection->prepare("INSERT INTO users (name,email,phone,role,password,status,address) VALUES (?,?,?,?,?,?,?)"); $stmt->bind_param("sssssss",$name,$email,$phone,$role,$hash,$status,$address);
        } else {
            if ($password !== "") { $hash=password_hash($password,PASSWORD_DEFAULT); $stmt=$connection->prepare("UPDATE users SET name=?,email=?,phone=?,role=?,password=?,status=?,address=? WHERE id=?"); $stmt->bind_param("sssssssi",$name,$email,$phone,$role,$hash,$status,$address,$id); }
            else { $stmt=$connection->prepare("UPDATE users SET name=?,email=?,phone=?,role=?,status=?,address=? WHERE id=?"); $stmt->bind_param("ssssssi",$name,$email,$phone,$role,$status,$address,$id); }
        }
        if (!$stmt->execute()) respond(false,$stmt->error); respond(true);

    case "add_category":
    case "update_category":
        $id=(int)($_POST["id"]??0); $name=clean($connection,$_POST["name"]??""); $description=clean($connection,$_POST["description"]??""); $status=clean($connection,$_POST["status"]??"Active");
        if ($action === "add_category") { $stmt=$connection->prepare("INSERT INTO categories (name,description,status) VALUES (?,?,?)"); $stmt->bind_param("sss",$name,$description,$status); }
        else { $stmt=$connection->prepare("UPDATE categories SET name=?,description=?,status=? WHERE id=?"); $stmt->bind_param("sssi",$name,$description,$status,$id); }
        if (!$stmt->execute()) respond(false,$stmt->error); respond(true);

    case "update_order_status":
        $id=(int)($_POST["id"]??0);
        $allowedStatuses=["Pending","Processing","Delivered","Cancelled"];
        $status=$_POST["status"]??"Pending";
        if (!in_array($status,$allowedStatuses,true)) respond(false,"Invalid status.");
        $stmt=$connection->prepare("UPDATE orders SET status=? WHERE id=?"); $stmt->bind_param("si",$status,$id);
        if (!$stmt->execute()) respond(false,$stmt->error); respond(true);

    case "update_profile":
        $id = (int)($_SESSION["user_id"] ?? 0);
        if ($id <= 0) respond(false, "No logged-in user found.");
        $name = clean($connection, $_POST["name"] ?? "");
        $email = clean($connection, $_POST["email"] ?? "");
        $phone = clean($connection, $_POST["phone"] ?? "");
        $password = $_POST["password"] ?? "";
        if ($name === "") respond(false, "Name is required.");
        if ($email === "") respond(false, "Email is required.");
        if ($password !== "") {
            if (strlen($password) < 6) respond(false, "Password must be at least 6 characters.");
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $connection->prepare("UPDATE users SET name=?,email=?,phone=?,password=? WHERE id=?");
            $stmt->bind_param("ssssi", $name, $email, $phone, $hash, $id);
        } else {
            $stmt = $connection->prepare("UPDATE users SET name=?,email=?,phone=? WHERE id=?");
            $stmt->bind_param("sssi", $name, $email, $phone, $id);
        }
        if (!$stmt->execute()) {
            $msg = ($connection->errno === 1062) ? "This email is already in use by another account." : $stmt->error;
            respond(false, $msg);
        }
        $_SESSION["username"] = $name;
        respond(true);

    case "delete_product": $id=(int)($_POST["id"]??0); $stmt=$connection->prepare("DELETE FROM products WHERE id=?"); $stmt->bind_param("i",$id); break;
    case "delete_user": $id=(int)($_POST["id"]??0); $stmt=$connection->prepare("DELETE FROM users WHERE id=?"); $stmt->bind_param("i",$id); break;
    case "delete_category": $id=(int)($_POST["id"]??0); $stmt=$connection->prepare("DELETE FROM categories WHERE id=?"); $stmt->bind_param("i",$id); break;
    default: respond(false,"Unknown action.");
}

if (!$stmt->execute()) respond(false,$stmt->error);
respond(true);
?>