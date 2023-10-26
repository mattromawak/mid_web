<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/customers.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-2 bg-light" style="border-right: 1px solid black;">
                <div class="row container vh-100 align-items-center m-1">
                    <div>
                        <img src="./styles/assets/profile1.jpg" alt="" class="profile-picture rounded-circle" style="height:150px;width:150px;border-radius:50%">
                    </div>
                    <div class="row gap-2">
                        <button onclick="toCartypes()" class="custom-btn btn-12" type="button"><span>Click!</span><span>Cartypes</span></button>
                        <button onclick="branch.php" class="custom-btn btn-12" type="button"><span>Click!</span><span>Branches</span></button>
                        <button onclick="" class="custom-btn btn-12" type="button"><span>Click!</span><span>Customers</span></button>
                    </div>
                    <button onclick="logout()" class="custom-btn btn-7">Logout</button>
                </div>
            </div>
            <div class="col-7 ">
                <div class="col d-flex justify-content-between mt-4">
                    <h2>Customers</h2>
                    <button onclick="showAddForm()" id="addBranchButton" class="btn btn-outline-warning">Add</button>
                </div>
                <div>
                    <table class="table table-bordered table-bordered">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Replace with your database connection details
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $database = "webdev";

                                // Create a database connection
                                $conn = new mysqli($servername, $username, $password, $database);

                                // Check the connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Fetch data from the 'customers' table
                                $sql = "SELECT * FROM customers";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["id"] . "</td>";
                                        echo "<td>" . $row["name"] . "</td>";
                                        echo "<td>" . $row["address"] . "</td>";
                                        echo '<td class="button-container">';
                                        echo '<button class="custom-btn btn-5 " data-id="' . $row["id"] . '" onclick="editBranch(' . $row["id"] . ')">EDIT</button>';
                                        echo '<button class="custom-btn btn-5 ms-2" onclick="deleteBranch(' . $row["id"] . ')">DELETE</button>';
                                        echo '<button class="custom-btn btn-5 ms-2 w-auto pr-2 pl-2" onclick="viewProducts(' . $row["id"] . ')">VIEW PRODUCTS</button>';
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
                        <div id="addForm" style="display: none; margin-bottom: 10px;">
                            <h3 style="text-align: center; padding-top: 20px">Add New Branch</h3>
                            <form action="add_customers.php" method="POST">
                                <div>
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" id="name" name="name" required style="width: 350px;">
                                </div>
                                <div>
                                    <label for="address">Address</label>
                                    <input class="form-control" type="text" id="address" name="address" required style="width: 350px;">
                                </div>
                                <br>
                                <br>
                                <button type="submit" name="submit" class="custom-btn btn-7">Add Branch</button>
                                <button type="button" onclick="hideBranch()" class="custom-btn btn-7">Cancel</button>
                            </form>
                        </div>
                </div>
            </div>
            <div class="col-3 text-center pt-4 " style="border-left: 2px solid #000">
                <h2>Description</h2>
            </div>
        </div>

        <script>
            // JavaScript functions to handle button actions and form visibility
            function logout() {
                if (confirm("Are you sure you want to log out?")) {
                    window.location.href = "login.php";
                }
            }
            function toBranches() {
                    window.location.href = "branch.php";
                }
            
            function toCartypes() {
                    window.location.href = "cartype.php";
                }
            
            function showAddForm() {
                document.getElementById("addForm").style.display = "block";
                const button = document.getElementById("addBranchButton");
                button.style.display = "none"
            }

            function hideBranch() {
                document.getElementById("addForm").style.display = "none";
                const button = document.getElementById("addBranchButton");
                button.style.display = "inline"
            }

            function addBranch() {
                // Get form data
                let name = document.getElementById("name").value;
                let address = document.getElementById("address").value;

                // Validate form data (add your own validation logic here)
                if (!name) {
                    alert("Please fill out all fields.");
                    return;
                }

                // Send an AJAX request to add the branch
                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert("Customer added successfully.");
                        // Reload the page after adding a new branch
                        location.reload();
                    }
                };
                xhr.open("POST", "./scripts/add_customers.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("name=" + name);
            }



            // JavaScript functions to handle button actions
            function editBranch(branchId) {
                // Implement your edit functionality here
                //alert("Edit branch with ID: " + branchId);

            }

            function deleteBranch(branchId) {
                // Use a confirmation dialog
                if (confirm("Are you sure you want to delete this branch?")) {
                    // If confirmed, send an AJAX request to delete the branch
                    let xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
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
            $(document).ready(function() {
                $(".edit-button").on("click", function() {
                    const id = $(this).data("id");
                    const $editModal = $(".editModal");
                    const $editForm = $editModal.find(".editForm");

                    $editModal.removeClass("d-none")
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                // Function to show the modal with data
                function showModalWithData(id, name) {
                    // Get modal and form elements
                    const $modal = $(".modal");
                    const $form = $modal.find("form");
                    const $legend = $(".legendText");

                    // Populate the form with data
                    $form.find("input[id='text']").val(id)
                    $legend.text(name)

                    // Show the modal
                    $modal.removeClass("d-none");
                }


                // Attach click event handler to edit buttons
                $(".edit-button").on("click", function() {
                    const id = $(this).data("id"); // Get the ID from the data attribute
                    const name = $(this).closest("tr").find("td:first-child").text(); // Get the name from the first <td> in the same row
                    const $editForm = $('.editForm');

                    $editForm.find("#hiddenInput").val(id)


                    showModalWithData(id, name);
                });

                $(".editForm").on("submit", function() {
                    var formData = $(".editForm").serialize();

                    // Send an AJAX request to update the branch
                    $.ajax({
                        type: "POST",
                        url: "./scripts/update_branch.php",
                        data: formData,
                        success: function(response) {
                            alert(response);
                            location.reload(); // Reload the page after a successful update
                        }
                    });
                });
            });
        </script>

</body>

</html>