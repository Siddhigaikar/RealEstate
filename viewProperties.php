<?php
session_start();
include 'db.php';

if (!isset($_SESSION["id"])) {
    header("Location:login.php");
    exit();
}

$result = $conn->query("SELECT * FROM properties");
?>

<!doctype html>
<html lang="en">
<head>
    <title>View Menu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(-45deg, #e3f2fd, #fce4ec, #e8f5e9, #fff3e0);
            background-size: 400% 400%;
            animation: gradient 10s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }

        thead {
            background: linear-gradient(90deg, #212529, #495057, #212529);
            color: white;
        }

        tbody tr {
            transition: 0.3s;
        }

        tbody tr:hover {
            background-color: #dbeafe;
            transform: scale(1.01);
        }

        tbody td {
            vertical-align: middle;
        }

        .property-img {
            width: 70px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>
</head>

<body>

<header>
            <nav
                class="navbar navbar-expand-sm navbar-dark bg-dark"
            >
                <div class="container">
                    <a class="navbar-brand" href="#">RealEstate</a>
                    <button
                        class="navbar-toggler d-lg-none"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapsibleNavId"
                        aria-controls="collapsibleNavId"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavId">
                        <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" aria-current="page"
                                    >Hello <?php echo $_SESSION["name"];?>
                                    <span class="visually-hidden">(current)</span></a
                                >
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard.php">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="addProperty.php">Add Property</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link active" href="viewProperties.php">View Properties</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pdf.php">Export Data</a>
                            </li>
                            
                        </ul>
                        <form class="d-flex" action="logout.php">
                            <button class="btn btn-outline-success">Logout</button>
                        </form>
                        
                    </div>
                </div>
            </nav>
            
        </header>

<div class="container mt-4">
    <h2 class="text-center mb-4">Property Details</h2>

    <div class="table-responsive shadow rounded">
        <table class="table table-bordered table-hover text-center mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Property Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Property Type</th>
                    <th>Bedrooms</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td>
                        <img class="property-img"
                             src="uploads/<?php echo $row["image"]; ?>"
                             alt="Property image">
                    </td>
                    <td><?php echo $row["property_name"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td>₹<?php echo $row["price"]; ?></td>
                    <td><?php echo $row["location"]; ?></td>
                    <td><?php echo $row["property_type"]; ?></td>
                    <td><?php echo $row["bedrooms"]; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>