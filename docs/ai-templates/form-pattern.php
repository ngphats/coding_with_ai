<?php
/**
 * AI Template: Form Handling Pattern
 * Use this template for all form-based features
 * 
 * AI-INSTRUCTIONS:
 * 1. Copy this pattern for new form features
 * 2. Replace ENTITY with actual entity name (User, Product, etc.)
 * 3. Update validation rules as needed
 * 4. Follow the exact error handling pattern
 */

// Step 1: Get entity ID if editing
$id = $_GET['id'] ?? null;
$entity = null;
$errors = [];

// Step 2: Load existing entity for edit mode
if ($id && !is_numeric($id)) {
    header('Location: index.php?error=' . urlencode('Invalid ID'));
    exit;
}

if ($id) {
    $entity = getEntityById($pdo, $id);
    if (!$entity) {
        header('Location: index.php?error=' . urlencode('Entity not found'));
        exit;
    }
}

// Step 3: Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $errors = validateEntityInput($_POST);
    
    if (empty($errors)) {
        if ($id) {
            // UPDATE existing entity
            $result = updateEntity($pdo, $id, $_POST['field1'], $_POST['field2']);
        } else {
            // CREATE new entity
            $result = createEntity($pdo, $_POST['field1'], $_POST['field2']);
        }
        
        if ($result['success']) {
            header('Location: index.php?message=' . urlencode($result['message']));
            exit;
        } else {
            $error = $result['error'];
        }
    }
}

/**
 * AI Template: Validation Function
 */
function validateEntityInput($data) {
    $errors = [];
    
    // Required field validation
    if (empty(trim($data['field1'] ?? ''))) {
        $errors['field1'] = 'Field 1 is required';
    }
    
    // Format validation
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    
    // Length validation
    if (strlen(trim($data['field1'] ?? '')) > 50) {
        $errors['field1'] = 'Field 1 must be less than 50 characters';
    }
    
    // Optional field validation
    if (!empty($data['phone']) && !preg_match('/^[\d\-\+\(\)\s]+$/', $data['phone'])) {
        $errors['phone'] = 'Please enter a valid phone number';
    }
    
    return $errors;
}

/**
 * AI Template: Create Function
 */
function createEntity($pdo, $field1, $field2, $field3 = null) {
    try {
        $sql = "INSERT INTO entities (field1, field2, field3) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            trim($field1),
            trim($field2),
            empty(trim($field3)) ? null : trim($field3)
        ]);
        
        if ($result) {
            return ['success' => true, 'message' => 'Entity created successfully!'];
        } else {
            return ['success' => false, 'error' => 'Failed to create entity'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
    }
}

/**
 * AI Template: Update Function
 */
function updateEntity($pdo, $id, $field1, $field2, $field3 = null) {
    try {
        $sql = "UPDATE entities SET field1=?, field2=?, field3=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            trim($field1),
            trim($field2),
            empty(trim($field3)) ? null : trim($field3),
            $id
        ]);
        
        if ($result && $stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'Entity updated successfully!'];
        } elseif ($result) {
            return ['success' => true, 'message' => 'No changes were made'];
        } else {
            return ['success' => false, 'error' => 'Failed to update entity'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
    }
}

/**
 * AI Template: HTML Form
 */
?>
<form method="POST" class="form-container">
    <h2><?= $entity ? 'Edit Entity' : 'Add New Entity' ?></h2>
    
    <!-- Display errors -->
    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <!-- Field 1 -->
    <div class="form-group">
        <label for="field1">Field 1:</label>
        <input type="text" 
               id="field1" 
               name="field1" 
               value="<?= htmlspecialchars($_POST['field1'] ?? $entity['field1'] ?? '') ?>"
               class="form-control <?= isset($errors['field1']) ? 'error' : '' ?>"
               required>
        <?php if (isset($errors['field1'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['field1']) ?></div>
        <?php endif; ?>
    </div>
    
    <!-- Field 2 -->
    <div class="form-group">
        <label for="field2">Field 2:</label>
        <input type="email" 
               id="field2" 
               name="field2" 
               value="<?= htmlspecialchars($_POST['field2'] ?? $entity['field2'] ?? '') ?>"
               class="form-control <?= isset($errors['field2']) ? 'error' : '' ?>"
               required>
        <?php if (isset($errors['field2'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['field2']) ?></div>
        <?php endif; ?>
    </div>
    
    <!-- Field 3 (Optional) -->
    <div class="form-group">
        <label for="field3">Field 3 (Optional):</label>
        <input type="text" 
               id="field3" 
               name="field3" 
               value="<?= htmlspecialchars($_POST['field3'] ?? $entity['field3'] ?? '') ?>"
               class="form-control <?= isset($errors['field3']) ? 'error' : '' ?>">
        <?php if (isset($errors['field3'])): ?>
            <div class="field-error"><?= htmlspecialchars($errors['field3']) ?></div>
        <?php endif; ?>
    </div>
    
    <!-- Form Actions -->
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <?= $entity ? 'Update Entity' : 'Create Entity' ?>
        </button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>
