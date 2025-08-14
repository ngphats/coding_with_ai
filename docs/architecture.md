# Code Structure - Complete CRUD System

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
    // SELECT all users
}

function getUserById($id) {
    // SELECT specific user
}

function updateUser($id, $firstName, $lastName, $email, $phone = null) {
    // UPDATE existing user
    // Return success/failure
}

function deleteUser($id) {
    // DELETE user by ID
    // Return success/failure
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
    case 'edit':
        if ($_POST) {
            // Process edit form submission
            // Validate input
            // Update user
            // Redirect with message
        } else {
            // Show edit user form
        }
        break;
    case 'delete':
        // Delete user with confirmation
        // Redirect with message
        break;
    default:
        // Default to list
}
```

### 4. HTML Templates
```php
function renderUserList($users) {
    // User table với Edit + Delete buttons
}

function renderAddUserForm($errors = []) {
    // Form HTML để create user
}

function renderEditUserForm($user, $errors = []) {
    // Form HTML để update user
}

function renderSuccessMessage($message) {
    // Success feedback display
}

function renderErrorMessage($message) {
    // Error feedback display
}
```

### 5. CSS Styling
```css
/* Modern yellow/amber color scheme */
/* Table styles với responsive design */
/* Form styles với proper spacing */
/* Button styles cho các actions */
/* Message styles cho feedback */
/* Layout: 1280px wide container */
```

## Page Flow
1. **Main Page** (`?action=list`): User table + Add button + Edit/Delete actions
2. **Add Page** (`?action=add`): Form to create user
3. **Edit Page** (`?action=edit&id=X`): Form to update existing user
4. **Delete Action** (`?action=delete&id=X`): Confirm and delete user
5. **Form Submit**: Validate → Process → Redirect with message

## Design Patterns
- **Single Responsibility**: Mỗi function có 1 nhiệm vụ cụ thể
- **MVC trong 1 file**: Model (DB functions), View (HTML rendering), Controller (request handling)
- **Error Handling**: Try-catch cho tất cả database operations
- **RESTful Routes**: GET for forms, POST for submissions
- **Confirmation Pattern**: JavaScript confirm() for destructive actions

## Security Considerations
- Prepared statements cho SQL queries
- Input sanitization với htmlspecialchars()
- XSS prevention
- SQL injection prevention
- User confirmation for delete operations

## Scalability Notes
- Code được tổ chức để dễ dàng tách thành nhiều files sau này
- Comments chi tiết để AI hiểu context
- Function naming convention rõ ràng
- Consistent error handling patterns
- Modular HTML rendering functions
