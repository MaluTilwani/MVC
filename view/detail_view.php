<?php
require_once "../model/User.php";
$userModel = new User();

$viewUser = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $viewUser = $userModel->getUserById($id);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>User detail view</title>
    <style>
.form-container {
    width: 100%;
    max-width: 600px; 
    margin: 60px auto;
    padding: 30px 40px;
    background: #fcfcfc;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    font-family: Arial, sans-serif;
    box-sizing: border-box;
}



input, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #d7ccc8; 
    background-color: #fff;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

input:focus, select:focus {
    border-color: #6d4c41; 
    outline: none;
    box-shadow: 0 0 5px rgba(109, 76, 65, 0.4);
}
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px; 
    border-radius: 6px;
    border: 1px solid #d7ccc8;
    background-color: #fff;
    font-size: 1rem;
    resize: vertical;
}


button {
    width: 100%;
    padding: 12px;
    background-color:rgb(118, 84, 72); /* brown */
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color:rgb(116, 78, 67); 
}

.error {
    color: #c94f3a; 
    text-align: center;
    font-weight: 600;
}

    </style>
</head>
<body>
<div class="form-container">
    <h2 class="text-center">User Detail View</h2><br/>
    <form>
        <label><strong>ID:</strong></label>
        <input type="text" name="id" readonly value="<?= htmlspecialchars($viewUser['id']) ?>">

        <label><strong>Name:</strong></label>
        <input type="text" name="name" readonly value="<?= htmlspecialchars($viewUser['name']) ?>">

        <label><strong>Email:</strong></label>
        <input type="email" name="email" readonly value="<?= htmlspecialchars($viewUser['email']) ?>">

        <label><strong>Phone:</strong></label>
        <input type="text" name="phone" readonly value="<?= htmlspecialchars($viewUser['phone']) ?>">

        <label><strong>Gender:</strong></label>
        <select name="gender" disabled>
            <option value="">Select Gender</option>
            <option value="male" <?= $viewUser['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
            <option value="female" <?= $viewUser['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
            <option value="other" <?= $viewUser['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
        </select>

        <label><strong>Address:</strong></label>
        <textarea name="address" disabled><?= htmlspecialchars($viewUser['address']) ?></textarea>

        <label><strong>Role:</strong></label>
        <select name="role" disabled>
            <option value="">Select Role</option>
            <option value="team" <?= $viewUser['role'] === 'team' ? 'selected' : '' ?>>Team</option>
            <option value="employee" <?= $viewUser['role'] === 'employee' ? 'selected' : '' ?>>Employee</option>
            <option value="admin" <?= $viewUser['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select><br/><br/>

        <label><strong>Status:</strong></label>
        <span>
            <?php
            $role = strtolower($viewUser['role']);
            if (in_array($role, ['admin', 'employee', 'team'])) {
                echo '<span class="badge bg-success"><b>Active</b></span>';
            } else {
                echo '<span class="badge bg-danger"><b>Inactive</b></span>';
            }
            ?>
        </span>
    </form>
</div>


</body>
</html>

