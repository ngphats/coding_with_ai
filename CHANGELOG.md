# Changelog

Tất cả các thay đổi quan trọng sẽ được ghi lại trong file này.

## [v0.3.0] - 2025-08-14

### Added
- Add User functionality với complete form
- Form validation (server-side và client-side)
- Success/error feedback system
- Duplicate email detection
- Routing system với ?action parameter
- "Thêm User" button trên main page
- Professional form styling và responsive design

### Changed
- **Major rewrite**: index.php từ simple display → full CRUD application
- Added helper functions: validateUserInput(), createUser(), getUsers()
- Improved architecture với proper routing và separation of concerns
- Enhanced CSS styling cho forms và buttons
- Better error handling và user experience

### Technical Details
- **Routing**: `?action=list` (default), `?action=add`
- **Validation**: Required fields, email format, character limits, regex patterns
- **Database**: INSERT với prepared statements và duplicate checking
- **Security**: Input sanitization, SQL injection prevention, XSS protection
- **UX**: Form persistence on errors, clear success/error messages

### Related Issues
- ✅ Closes #004: Add User Creation Functionality

## [v0.2.1] - 2025-08-13

### Added
- Phone number display trong HTML table
- Page title "User Management System"

### Changed
- SQL query: Include phone column trong SELECT statement
- HTML table: Added Phone column header và data display
- Empty state: Updated colspan từ 5 thành 6

### Technical Details
- **Query**: `SELECT id, first_name, last_name, email, phone, created_at FROM users`
- **Display**: Phone column between Email và Created Date
- **Escaping**: `htmlspecialchars($user['phone'] ?? '')` cho null safety

### Related Issues
- ✅ Closes #3: Update index.php cho Phone Number column

## [v0.2.0] - 2025-08-13

### Added
- Thêm cột Phone Number vào user table
- Migration script để update existing database
- Phone number display trong HTML table
- **Issue Management System** - ISSUES.md để track tasks

### Changed
- Database schema: Thêm column `phone VARCHAR(20)`
- SQL query: Include phone column trong SELECT
- HTML table: Thêm Phone column header và data
- Sample data: Include phone numbers

### Technical Details
- **Database**: `ALTER TABLE users ADD COLUMN phone VARCHAR(20)`
- **Query**: Updated to select phone column
- **Display**: Added phone column in table between Email và Created Date
- **Issues**: Created ISSUES.md - closes #2, created #3

### Related Issues
- ✅ Closes #2: Add Phone Number column to database schema
- 📋 Opens #3: Update index.php cho Phone Number column

## [v0.1.0] - 2025-08-13

### Added
- Initial MVP implementation
- Basic user display functionality  
- PostgreSQL database connection
- HTML table với CSS styling
- Documentation structure (docs-first workflow)

### Features
- Display users in table format
- Columns: ID, First Name, Last Name, Email, Created Date
- Basic error handling
- Clean CSS styling
