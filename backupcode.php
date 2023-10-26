<!--branch.php-->
<!DOCTYPE html>
<html>
<head>
    <title>Branch List</title>
    <link rel="stylesheet" type="text/css" href="./styles/branch.css">
    <link rel="stylesheet" type="text/css" href="./styles/modal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-2 bg-light" style="border-right: 1px solid black;">
                <div class="row container vh-100 align-items-center m-1">
                    <div>
                        <img src="./styles/assets/car-icon.png" alt="" class="profile-picture rounded-circle" style="height:150px;width:150px;border-radius:50%">
                    </div>
                    <div class="row gap-2">
                        <button onclick="toCartypes()" class="btn btn-light" type="button">Cartypes</button>
                        <button onclick="toBranches()" class="btn btn-light" type="button">Branches</button>
                        <button onclick="toCustomers()" class="btn btn-light" type="button">Customers</button>
                    </div>
                    <button onclick="logout()" class="btn btn-warning">Logout</button>
                </div>
            </div>
            <div class="col-7 bg-dark-light">
                <div style="display: flex; justify-content: space-between; margin-top: 10px; margin-bottom: 10px">
                    <h3 style="text-align: left;">Branches</h3>
                    <button id="addBranchButton" onclick="showAddForm()" style="background: linear-gradient(to right, #00FF00, #00AA00); color: white; text-align: right; border-radius: 5px; padding: 5px 30px; text-decoration: none; border: transparent">Add Branch</button>
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
                                echo '<button class="edit-button" data-id="'.$row["id"].'" >EDIT</button>';
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
            <div class="col-3 bg-light" style="border-left: 1px solid black">
                <!-- Form for adding a new branch (initially hidden) -->
                <div id="addForm" style="display: none; margin-bottom: 10px;">
                    <h3 style="text-align: center; padding-top: 20px">Add New Branch</h3>
                    <form id="branchForm" style="padding-top: 50px;">
                        <label for="branchName">Branch Name:</label>
                        <input type="text" id="branchName" name="branchName" required style="width: 350px;">  
                        <br>
                        <br>
                        <div style="float: right;">
                            <button type="button" onclick="addBranch()" style="background-color: #00AA00; border: transparent; border-radius: 5px">Add Branch</button>
                            <button type="button" onclick="hideBranch()" style="background-color: white; border: transparent; border-radius: 5px">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
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
    <script src="./scripts/navigation.js"></script>

    <script>
        // JavaScript functions to handle button actions and form visibility
        function showAddForm() {
    document.getElementById("addForm").style.display = "block"; // Fix the assignment here
    const button = document.getElementById("addBranchButton");
    button.style.display = "none";
}

        function hideBranch() {
            document.getElementById("addForm").style.display = "none";
            const button = document.getElementById("addBranchButton");
            button.style.display = "inline";
        }

        function addBranch() {
            // Get form data
            let branchName = document.getElementById("branchName").value;

            // Validate form data (add your own validation logic here)
            if (!branchName) {
                alert("Please fill out all fields.");
                return;
            }

            // Send an AJAX request to add the branch
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert("Branch added successfully.");
                    // Reload the page after adding a new branch
                    location.reload();
                }
            };
            xhr.open("POST", "./scripts/add_branch.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("branchName=" + branchName);
        }

        // JavaScript functions to handle button actions
        function editBranch(branchId) {
            // Implement your edit branch functionality here
        }

        function deleteBranch(branchId) {
            // Use a confirmation dialog
            if (confirm("Are you sure you want to delete this branch?")) {
                // If confirmed, send an AJAX request to delete the branch
                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Update the UI as needed
                        alert("Branch deleted successfully.");
                        // Reload the page or remove the row from the table
                        location.reload();
                    }
                };
                xhr.open("POST", "./scripts/delete_branch.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("id=" + branchId);
            }
        }

        function viewProducts(branchId) {
            // Implement your view products functionality here
            alert("View products for branch with ID: " + branchId);
        }
    </script>

    <script>
        // jQuery for showing and handling the edit modal
        
        $(".edit-button").on("click", function() {
                const id = $(this).data("id");
                const name = $(this).closest("tr").find("td:first-child").text();
                const $editForm = $(".editForm");

                // Populate the modal with data
                $editForm.find("#hiddenInput").val(id);
                $editForm.find(".legendText").text("Edit Branch: " + name);

                // Show the modal
                $(".modal").removeClass("d-none");
        });
        // Handle the form submission
        $(".editForm").on("submit", function(event) {
            event.preventDefault();
            const formData = $(this).serialize();

            // Send an AJAX request to update the branch
            $.ajax({
                type: "POST",
                url: "./scripts/update_branch.php", // Update with the correct path
                data: formData,
                success: function(response) {
                    alert(response);
                    location.reload(); // Reload the page after a successful update
                }
            });
        });
        function logout() {
                if (confirm("Are you sure you want to log out?")) {
                    window.location.href = "login.php";
                }
            }
    </script>
</body>
</html>

<!--
    
another backup-->

<!DOCTYPE html>
<html>
<head>
    <title>Branch List</title>
    <link rel="stylesheet" type="text/css" href="./styles/branch.css">
</head>
<body>
<div class="row">
    <div class="column1">
        <h2>Column 1</h2>
        <p>This is the content of column 1.</p>
    </div>
    <div class="column2">
    <h2>Branch List</h2>

<button id="addBranchButton" onclick="showAddForm()" style="margin-bottom: 10px">Add Branch</button>

<!-- Form for adding a new branch (initially hidden) -->
    <div id="addForm" style="display: none; margin-bottom: 10px;">
        <h3>Add New Branch</h3>
        <form id="branchForm">
            <label for="branchName">Branch Name:</label>
            <input type="text" id="branchName" name="branchName" required>  
            <button type="button" onclick="addBranch()">Add Branch</button>
            <button type="button" onclick="hideBranch()">Cancel</button>
    </form>
    </div>


<table>
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
                echo '<button class="edit-button" data-id="'.$row["id"].'" onclick="editBranch(' . $row["id"] . ')">EDIT</button>';
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
        <h2>Column 3</h2>
        <p>This is the content of column 3.</p>
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

    
</body>


</html>
