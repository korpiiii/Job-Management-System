<?php
include 'dbconfig.php';
include 'models.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addApplicant'])) {
    $response = insertApplicant($conn, $_POST);
    echo json_encode(['status' => $response['statusCode']]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Job Management System</title>
</head>
<body>
    <header>
        <h1>Job Management System</h1>
        <p>Manage job applicants and positions effectively.</p>
    </header>

    <main>
        <!-- Dashboard Section -->
        <section class="dashboard">
            <div class="card">
                <h2>Total Applicants</h2>
                <p id="totalApplicants">Loading...</p>
            </div>
            <button class="add-btn" id="showAddModal">Add Applicant</button>
        </section>

        <!-- Search and Table Section -->
        <section id="search-and-table">
            <div class="search-container">
                <input type="text" id="search" placeholder="Search for applicants">
            </div>
            <div id="results-container" class="applicant-table-container">
                <!-- AJAX Populated Content -->
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?= date('Y'); ?> Job Management System. All rights reserved.</p>
    </footer>

    <!-- Add Applicant Modal -->
    <div id="addApplicantModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModal">&times;</span>
            <h2>Add Applicant</h2>
            <form id="addApplicantForm">
                <input type="text" name="name" placeholder="Enter Name" required>
                <input type="email" name="email" placeholder="Enter Email" required>
                <input type="text" name="phone" placeholder="Enter Phone">
                <textarea name="address" placeholder="Enter Address"></textarea>
                <input type="text" name="position_applied" placeholder="Enter Position" required>
                <textarea name="resume" placeholder="Enter Resume"></textarea>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Modal functionality
            const modal = $('#addApplicantModal');
            const closeModal = $('#closeModal');
            $('#showAddModal').on('click', () => modal.show());
            closeModal.on('click', () => modal.hide());

            // Load applicants and total count
            function loadApplicants(query = '') {
                $.ajax({
                    url: 'search.php',
                    method: 'POST',
                    data: { search: query },
                    success: function (data) {
                        $('#results-container').html(data);
                    }
                });
            }
            function loadTotalApplicants() {
                $.ajax({
                    url: 'countApplicants.php',
                    method: 'GET',
                    success: function (data) {
                        $('#totalApplicants').text(data);
                    }
                });
            }

            // Submit new applicant
            $('#addApplicantForm').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '',
                    method: 'POST',
                    data: $(this).serialize() + '&addApplicant=true',
                    success: function (data) {
                        modal.hide();
                        loadApplicants();
                        loadTotalApplicants();
                    }
                });
            });

            // Live search
            $('#search').on('keyup', function () {
                loadApplicants($(this).val());
            });

            loadApplicants();
            loadTotalApplicants();
        });
    </script>
</body>
</html>
