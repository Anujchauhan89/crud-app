<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "contacts_db";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

class Contact {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->createTable();
    }

    private function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS contacts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            phone VARCHAR(20) NOT NULL
        )";
        $this->conn->query($sql);
    }

    public function create($name, $last_name, $phone) {
        $stmt = $this->conn->prepare("INSERT INTO contacts (name, last_name, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $last_name, $phone);
        return $stmt->execute();
    }

    public function update($id, $name, $last_name, $phone) {
        $stmt = $this->conn->prepare("UPDATE contacts SET name = ?, last_name = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $last_name, $phone, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM contacts WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAll($limit, $offset) {
        $sql = "SELECT * FROM contacts LIMIT $limit OFFSET $offset";
        return $this->conn->query($sql);
    }

    public function getTotal() {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM contacts");
        $row = $result->fetch_assoc();
        return $row['total'];
    }

     public function importFromXML($filePath) {
    $xml = simplexml_load_file($filePath);

    if ($xml === false) {
        return false;
    }

    $contactsInserted = 0;

    foreach ($xml->contact as $contact) {
        $name = (string) $contact->name;
        $last_name = (string) $contact->lastName; // Updated from last_name to lastName
        $phone = (string) $contact->phone;

        if (!empty($name) && !empty($last_name) && !empty($phone)) {
            if ($this->create($name, $last_name, $phone)) {
                $contactsInserted++;
            }
        }
    }

    return $contactsInserted;
}

}

$db = new Database();
$contact = new Contact($db->getConnection());

$limit = 5; // Number of contacts per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$contacts = $contact->getAll($limit, $offset);
$totalContacts = $contact->getTotal();
$totalPages = ceil($totalContacts / $limit);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $contact->update($_POST['id'], $_POST['name'], $_POST['last_name'], $_POST['phone']);
    } elseif (isset($_POST['delete_id'])) {
        $contact->delete($_POST['delete_id']);
    } elseif (isset($_POST['import']) && isset($_FILES['xmlFile']) && $_FILES['xmlFile']['error'] == 0) {
        $fileTmpPath = $_FILES['xmlFile']['tmp_name'];
        $contactsInserted = $contact->importFromXML($fileTmpPath);

        if ($contactsInserted > 0) {
            echo "<div class='alert alert-success'>Successfully imported $contactsInserted contacts.</div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to import contacts. Please check the XML file format.</div>";
        }
    } else {
        $contact->create($_POST['name'], $_POST['last_name'], $_POST['phone']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 900px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			padding-top: 321px;
        }
        h2 {
            color: #343a40;
        }
        .btn-custom {
            width: 100%;
            border-radius: 5px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        input:focus, select:focus, textarea:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table-dark th {
            background-color: #343a40;
            color: white;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .btn-danger:hover {
            background-color: #dc3545;
        }
        .edit-contact, .delete-contact {
            cursor: pointer;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <h2 class="text-center mb-4">Contact Management</h2>
        
        <!-- Form to Add/Update Contact -->
        <form id="contactForm" class="mb-3">
            <input type="hidden" id="contactId" name="id">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="col-md-4">
                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" required>
                </div>
                <div class="col-md-4">
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone" required>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-custom">Save Contact</button>
                </div>
            </div>
        </form>

        <!-- Form to Import Contacts via XML -->
        <form action="" method="post" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="xmlFile" class="form-label">Upload Contacts (XML)</label>
                <input type="file" class="form-control" id="xmlFile" name="xmlFile" accept=".xml" required>
            </div>
            <button type="submit" name="import" class="btn btn-success">Import Contacts</button>
        </form>

        <!-- Contact List Table -->
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="contactTable">
                <?php while ($row = $contacts->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['last_name'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-contact" data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>" data-last_name="<?= $row['last_name'] ?>" data-phone="<?= $row['phone'] ?>">Edit</button>
                        <button class="btn btn-danger btn-sm delete-contact" data-id="<?= $row['id'] ?>">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    
    <script>
        $(document).ready(function () {
            $('#contactForm').submit(function (e) {
                e.preventDefault();
                $.post('', $(this).serialize(), function () {
                    location.reload();
                });
            });
            $('.edit-contact').click(function () {
                $('#contactId').val($(this).data('id'));
                $('#name').val($(this).data('name'));
                $('#last_name').val($(this).data('last_name'));
                $('#phone').val($(this).data('phone'));
            });
            $('.delete-contact').click(function () {
                $.post('', { delete_id: $(this).data('id') }, function () {
                    location.reload();
                });
            });
        });
    </script>
</body>
</html>
