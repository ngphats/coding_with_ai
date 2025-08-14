<?php
/**
 * AI Template: Delete Pattern
 * Use this template for all delete operations
 * 
 * AI-INSTRUCTIONS:
 * 1. Always require confirmation for destructive actions
 * 2. Verify entity exists before deletion
 * 3. Include entity name in confirmation and success messages
 * 4. Use danger styling for delete buttons
 */

/**
 * Route Handler for Delete Action
 */
case 'delete':
    // Step 1: Validate ID parameter
    $id = $_GET['id'] ?? 0;
    if (!$id || !is_numeric($id)) {
        header('Location: index.php?error=' . urlencode('Invalid entity ID'));
        exit;
    }
    
    // Step 2: Execute delete operation
    $result = deleteEntity($pdo, $id);
    
    // Step 3: Redirect with appropriate message
    if ($result['success']) {
        header('Location: index.php?message=' . urlencode($result['message']));
    } else {
        header('Location: index.php?error=' . urlencode($result['error']));
    }
    exit;

/**
 * AI Template: Delete Function
 */
function deleteEntity($pdo, $id) {
    try {
        // Step 1: Check if entity exists and get name for feedback
        $checkSql = "SELECT id, name FROM entities WHERE id = ?";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([$id]);
        $entity = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$entity) {
            return ['success' => false, 'error' => 'Entity không tồn tại'];
        }
        
        // Step 2: Delete the entity
        $sql = "DELETE FROM entities WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$id]);
        
        // Step 3: Provide meaningful feedback
        if ($result && $stmt->rowCount() > 0) {
            return ['success' => true, 'message' => "Entity '{$entity['name']}' đã được xóa thành công!"];
        } else {
            return ['success' => false, 'error' => 'Failed to delete entity'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
    }
}

/**
 * AI Template: Delete Button HTML
 * Include this in your table actions column
 */
?>
<td>
    <a href="index.php?action=edit&id=<?= $entity['id'] ?>" class="btn btn-sm">Edit</a>
    <a href="index.php?action=delete&id=<?= $entity['id'] ?>" 
       class="btn btn-sm btn-danger"
       onclick="return confirm('Bạn có chắc chắn muốn xóa entity \'<?= htmlspecialchars($entity['name']) ?>\'? Hành động này không thể hoàn tác.')">Delete</a>
</td>

<?php
/**
 * AI Template: CSS for Delete Button
 */
?>
<style>
/* Danger Button Styling */
.btn-danger {
    background-color: var(--danger-color);
    color: white;
    border: 2px solid var(--danger-color);
}

.btn-danger:hover {
    background-color: var(--danger-hover);
    border-color: var(--danger-hover);
    transform: translateY(-1px);
}

/* CSS Variables (add to :root) */
:root {
    --danger-color: #dc2626;
    --danger-hover: #b91c1c;
}
</style>

<?php
/**
 * AI SAFETY CHECKLIST for Delete Operations:
 * 
 * ✅ ID validation (numeric, not empty)
 * ✅ Entity existence check
 * ✅ Confirmation dialog with entity name
 * ✅ Prepared statement for SQL
 * ✅ Meaningful success/error messages
 * ✅ Visual distinction (red/danger styling)
 * ✅ Proper error handling (try-catch)
 * ✅ Exit after redirect
 * 
 * NEVER:
 * ❌ Delete without confirmation
 * ❌ Use direct SQL concatenation
 * ❌ Ignore return values
 * ❌ Generic error messages
 * ❌ Missing existence validation
 */
?>
