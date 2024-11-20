<?php
include 'dbconfig.php';
include 'models.php';

$search = $_POST['search'] ?? '';
$results = searchApplicants($conn, $search);

if ($results['statusCode'] === 200) {
    echo '<table>';
    echo '<thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Position</th>
                <th>Date Applied</th>
                <th>Actions</th>
            </tr>
          </thead>
          <tbody>';
    foreach ($results['querySet'] as $applicant) {
        echo "<tr>
                <td>" . htmlspecialchars($applicant['name']) . "</td>
                <td>" . htmlspecialchars($applicant['email']) . "</td>
                <td>" . htmlspecialchars($applicant['phone']) . "</td>
                <td>" . htmlspecialchars($applicant['address']) . "</td>
                <td>" . htmlspecialchars($applicant['position_applied']) . "</td>
                <td>" . htmlspecialchars($applicant['date_applied']) . "</td>
                <td>
                    <a href='edit.php?id=" . $applicant['id'] . "' class='edit-icon'>✏️</a>
                    <a href='delete.php?id=" . $applicant['id'] . "' class='delete-icon'>🗑️</a>
                </td>
              </tr>";
    }
    echo '</tbody></table>';
} else {
    echo '<p>No results found.</p>';
}
?>
