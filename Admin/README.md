# Gadget Store

## Structure
This project follows the instructor repository structure: `Controller/`, `Model/`, and `View/`. The original Gadget Store HTML/CSS/JS design is kept in `View/dashboard.php`, `View/style.css`, and `View/script.js`; PHP/MySQL functionality is connected underneath it.

## XAMPP setup
1. Put `Gadget-Store` inside `C:\xampp\htdocs\`.
2. Start Apache and MySQL.
3. Create/import the `gadget_store` database using `database.sql`.
4. The database connection uses MySQL user `root`, password `123456`, database `gadget_store`, matching the instructor repository's password convention.
5. Open `http://localhost/Gadget-Store/Gadget-Store/` if the outer folder is named `Gadget-Store`, or the matching local path if you extracted it directly.

## Main UI
The admin dashboard is a single-page interface with the supplied original sidebar, cards, tables, modals, icons, responsive layout, and styling. Products, users and categories are loaded from MySQL. Add/Edit/Delete operations use `Controller/adminController.php`.
