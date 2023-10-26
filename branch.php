<!DOCTYPE html>
<html>

<head>
    <title>Branch List</title>
    <link rel="stylesheet" type="text/css" href="./styles/branch.css">
</head>

<body style="padding: 0; margin: 0">
    <div class="row">
        <div class="column1">
            <img src="./styles/assets/admin-profile.jpg" style="width: 150px; height:150px; border-radius: 50%;padding-top:10px">
            <h2 style="color: #FEC60D">ADMIN</h2>
            <div class="button-row">
                <button class="buttonnav" onclick="toCartypes()">CAR TYPES</button>
                <button class="buttonnav" onclick="toBranches()">BRANCH</button>
                <button class="buttonnav" onclick="toCustomers()">CUSTOMERS</button>
            </div>
            <button type="button" class="butLogout">LOGOUT</button>
        </div>
        <div class="column2">
            <div style="display: flex; justify-content: space-between; margin-top: 10px; margin-bottom: 10px">
                <h2 style="color: #FEC60D;">BRANCH LIST</h2>
                <button id="addBranchButton" onclick="showAddForm()" style="padding:10px; width:100px; height: 30px; cursor:pointer; float:right">Add Branch</button>
            </div>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>Branch Name</th>
                        <th>Total Cars Sold</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "webdev";

                    $conn = new mysqli($servername, $username, $password, $database);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch data from the 'branch' table
                    $sql = "SELECT id, name, total_car_sold FROM branch";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["total_car_sold"] . "</td>";
                            echo '<td class="button-container">';
                            echo '<button class="edit-button" data-id="' . $row["id"] . '" onclick="editBranch(' . $row["id"] . ')">EDIT</button>';
                            echo '<button class="delete-button" onclick="deleteBranch(' . $row["id"] . ')">DELETE</button>';
                            echo '<button class="view-button" onclick="viewProducts(' . $row["id"] . ')">VIEW PRODUCTS</button>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No branches found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
        <div class="column3">
            <div id="addForm" style="display: none; margin-bottom: 10px;">
                <h3>Add New Branch</h3>
                <form id="branchForm">
                    <label for="branchName">Branch Name:</label>
                    <input type="text" id="branchName" name="branchName" required>
                    <button type="button" onclick="addBranch()">Add Branch</button>
                    <button type="button" onclick="hideBranch()">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal d-none">
        <div class="modal-container">
            <form class="editForm" action="">
                <legend class="legendText">
                    Edit Page
                </legend>
                <input id="branchName" name="name" type="text" placeholder="Enter New Branch Name">
                <input type="hidden" name="id" id="hiddenInput">
                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <script src="jquery-3.7.1.min.js"></script>
    <script src="./scripts/javascripts/buttons.js"></script>
    <script src="./scripts/javascripts/navigation.js"></script>
</body>

</html>