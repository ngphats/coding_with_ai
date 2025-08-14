# Requirements - Complete CRUD User Management System

## 1. Database Connection
- Connect to PostgreSQL database
- Handle connection errors

## 2. User Data Display  
- Query all users from database
- Display in HTML table with columns: ID, First Name, Last Name, Email, Phone, Created Date
- Show "No users found" if table is empty
- Add "Edit" và "Delete" action links for each user

## 3. Add New User Feature ✅
- "Thêm User" button on main page
- Form với fields: First Name, Last Name, Email, Phone
- Form validation (required fields, email format, unique email)
- Save new user to database
- Success/error feedback to user
- Redirect to main page after successful add

## 4. Edit User Feature ✅
- "Edit" link for each user trong table
- Edit form với current user data pre-populated
- Same validation rules như Add User
- Check duplicate email (excluding current user)
- Update user trong database
- Success/error feedback
- Redirect to main page after successful update

## 5. Delete User Feature 🔄
- "Delete" link for each user trong table
- Confirmation dialog to prevent accidental deletions
- Remove user từ database permanently
- Success/error feedback
- Redirect to main page after successful deletion
- Handle edge cases (user not found, database errors)

## 6. Basic HTML Pages
- Main page: User table + Add User button + Edit/Delete links
- Add User page: Form to create new user
- Edit User page: Form to update existing user
- Delete confirmation: Confirmation dialog hoặc page
- Basic CSS for forms và buttons

## 7. Form Validation Rules
- **First Name**: Required, 1-50 characters, letters và spaces only
- **Last Name**: Required, 1-50 characters, letters và spaces only  
- **Email**: Required, valid email format, unique trong database (exclude current user for edits)
- **Phone**: Optional, 10-20 characters, numbers và các ký tự +()-space

## 8. Technical Specs
- PHP 8.0+ với PDO extension
- PostgreSQL database
- HTML forms với proper validation
- SQL INSERT/UPDATE/DELETE với prepared statements
- Error handling cho database operations
- Basic CSRF protection
- JavaScript confirmation dialogs

## 9. User Experience
- Simple navigation giữa pages
- Clear form labels và validation messages
- Success feedback: "User đã được thêm/cập nhật thành công"
- Error feedback: Specific error messages for validation failures
