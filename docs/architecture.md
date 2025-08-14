# Code Structure - With Add User Feature

## File: index.php (Everything in one file)

### 1. Configuration & Connection
```php
<?php
// Database configuration
// PDO connection setup
// Error handling
```

### 2. Helper Functions
```php
function validateUserInput($data) {
    // Validate form input
    // Return array of errors
}

function createUser($firstName, $lastName, $email, $phone = null) {
    // INSERT new user into database
    // Return success/failure
}

function getUsers() {
    // Existing SELECT functionality
}
```

### 3. Request Routing
```php
$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        // Display user table (existing functionality)
        break;
    case 'add':
        if ($_POST) {
            // Process form submission
            // Validate input
            // Create user
            // Redirect with message
        } else {
            // Show add user form
        }
        break;
    default:
        // Default to list
}
```

### 4. HTML Templates
```php
function renderUserList($users) {
    // Existing table + "Thêm User" button
}

function renderAddUserForm($errors = []) {
    // Form HTML với validation errors
}

function renderSuccessMessage($message) {
    // Success feedback display
}
```

### 5. CSS Styling
```css
/* Existing table styles */
/* New form styles */
/* Button styles */
/* Error message styles */
```

## Page Flow
1. **Main Page** (`?action=list`): User table + Add button
2. **Add Page** (`?action=add`): Form to create user
3. **Form Submit**: Validate → Create → Redirect with message

## Design Patterns
- **Single Responsibility**: Mỗi function có 1 nhiệm vụ cụ thể
- **MVC trong 1 file**: Model (DB functions), View (HTML rendering), Controller (request handling)
- **Error Handling**: Try-catch cho tất cả database operations

## Security Considerations
- Prepared statements cho SQL queries
- Input sanitization
- CSRF protection (sẽ thêm sau)
- XSS prevention

## Scalability Notes
- Code được tổ chức để dễ dàng tách thành nhiều files sau này
- Comments chi tiết để AI hiểu context
- Function naming convention rõ ràng
