# Requirements - Current + Add User Feature

## 1. Database Connection
- Connect to PostgreSQL database
- Handle connection errors

## 2. User Data Display  
- Query all users from database
- Display in HTML table with columns: ID, First Name, Last Name, Email, Phone, Created Date
- Show "No users found" if table is empty

## 3. Add New User Feature
- "Thêm User" button on main page
- Form với fields: First Name, Last Name, Email, Phone
- Form validation (required fields, email format, unique email)
- Save new user to database
- Success/error feedback to user
- Redirect to main page after successful add

## 4. Basic HTML Pages
- Main page: User table + Add User button
- Add User page: Form to create new user
- Basic CSS for forms và buttons

## 5. Form Validation Rules
- **First Name**: Required, 1-50 characters, letters và spaces only
- **Last Name**: Required, 1-50 characters, letters và spaces only  
- **Email**: Required, valid email format, unique trong database
- **Phone**: Optional, 10-20 characters, numbers và các ký tự +()-space

## 6. Technical Specs
- PHP 8.0+ với PDO extension
- PostgreSQL database
- HTML forms với proper validation
- SQL INSERT với prepared statements
- Error handling cho database operations
- Basic CSRF protection

## 7. User Experience
- Simple navigation giữa pages
- Clear form labels và validation messages
- Success feedback: "User đã được thêm thành công"
- Error feedback: Specific error messages for validation failures
