<?php
include 'dbconfig.php';
include 'models.php';

$search = $_GET['search'] ?? '';
$result = searchApplicants($conn, $search);

$html = '';
if ($result['statusCode'] === 200) {
    foreach ($result['querySet'] as $applicant) {
        $html .= "<tr>
                    <td>{$applicant['name']}</td>
                    <td>{$applicant['email']}</td>
                    <td>{$applicant['phone']}</td>
                    <td>{$applicant['address']}</td>
                    <td>{$applicant['position_applied']}</td>
                    <td>
                        <i class='fas fa-edit edit-btn' data-id='{$applicant['id']}'></i>
                        <i class='fas fa-trash delete-btn' data-id='{$applicant['id']}'></i>
                    </td>
                </tr>";
    }
}

echo json_encode([
    'html' => $html,
    'total' => countApplicants($conn)
]);
