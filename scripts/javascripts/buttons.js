
        // JavaScript functions to handle button actions and form visibility
        function showAddForm() {
            document.getElementById("addForm").style.display = "block";
            const button=document.getElementById("addBranchButton");
            button.style.display = "none"
        }

        function hideBranch() {
            document.getElementById("addForm").style.display = "none";
            const button=document.getElementById("addBranchButton");
            button.style.display = "inline"
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
            // Implement your edit functionality here
            //alert("Edit branch with ID: " + branchId);

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
            window.location.href="cartype.php?id=" + branchId
        }


        $(document).ready(function(){
            $(".edit-button").on("click",function(){
                const id = $(this).data("id");
                const $editModal = $(".editModal");
                const $editForm = $editModal.find(".editForm");

                $editModal.removeClass("d-none")
            });
        });
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