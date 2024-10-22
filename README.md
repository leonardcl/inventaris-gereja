
# Church Inventory Management System

![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue)
![MySQL](https://img.shields.io/badge/MySQL-v5.7-orange)
![License: MIT](https://img.shields.io/badge/License-MIT-green)

![Description of the image](img.webp)

This repository contains the **Church Inventory Management System** developed as part of a Service Learning project at Universitas Kristen Petra (UKP). The system allows church administrators to manage the inventory of equipment and track lending records in a web-based interface.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

---

## Overview

This project aims to help manage church inventory efficiently by tracking items and their lending status. Users can add new items, manage borrowing requests, and monitor returned equipment through a web interface.

---

## Features

- **Inventory Management**: Add, edit, and delete items from the inventory.
- **Borrowing System**: Track items that are borrowed and manage the return process.
- **User Authentication**: Admin and user authentication for secure access.
- **Report Generation**: Generate reports for inventory tracking and lending history.

---

## Technologies Used

- **PHP**: Backend language for handling server-side operations.
- **MySQL**: Database for storing inventory and user data.
- **CSS**: Used for styling the web interface.

---

## Installation

### Prerequisites

- PHP 7.4+
- MySQL database
- Apache server

### Steps

1. Clone the repository:

```bash
git clone https://github.com/leonardcl/inventaris-gereja.git
cd inventaris-gereja
```

2. Set up the MySQL database using the provided schema in `database.sql`.

3. Update the database connection credentials in `connect.php`:

```php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "inventaris-ltls";
```

4. Launch the application on a local PHP server.

```bash
php -S localhost:8000
```

---

## Usage

1. Log in as an admin with the default credentials:
   - **Username**: admin
   - **Password**: admin

2. Navigate to the dashboard to manage inventory, track borrowings, and generate reports.

---

## Contributing

Feel free to fork this repository and submit pull requests. Contributions are welcome!

---

## License

This project is licensed under the MIT License.
