# Changelog

Tất cả các thay đổi quan trọng sẽ được ghi lại trong file này.

## [v0.7.0-AI.1] - 2025-08-14

### Added - AI-Native Workflow Implementation
- **AI Context System**: Created comprehensive AI development context
- **AI Learning Log**: Track AI learning progression and pattern evolution
- **AI Templates**: Reusable code patterns for consistent development
- **Semantic Versioning**: AI-aware version numbering system

### Files Added
- `docs/ai-context.md` - AI development patterns and guidelines
- `docs/ai-learning-log.md` - AI learning progression tracking
- `docs/ai-templates/` - Template patterns for AI code generation
  - `form-pattern.php` - Standard form handling template
  - `delete-pattern.php` - Safe delete operation template
  - `validation-pattern.php` - Input validation template

### AI Learning Enhancements
- **Pattern Documentation**: All established patterns documented for AI reference
- **Anti-Pattern Guidelines**: Things AI should avoid
- **Security Checklists**: AI validation checklists for secure development
- **Code Quality Standards**: Consistent coding standards for AI

### Technical Notes
- No functional changes to application
- Same functionality with enhanced AI development workflow
- Documentation-first approach formalized
- AI learning feedback loop established

## [v0.7.0] - 2025-08-14

### Added
- **Delete User Functionality**: Complete CRUD operations now available
- **Delete Confirmation**: JavaScript confirm dialog before deletion
- **Delete Button**: Red "Delete" button trong Actions column
- **Success Messages**: Confirmation messages sau khi delete user
- **Error Handling**: Comprehensive error handling cho delete operations
- **User Validation**: Check if user exists before deletion
- **CSS Danger Class**: New btn-danger styling for destructive actions

### Features
- ✅ **Complete CRUD**: Create, Read, Update, Delete operations
- ✅ **Confirmation Dialog**: "Bạn có chắc chắn muốn xóa user..." prompt
- ✅ **User-Friendly Messages**: Success/error feedback với user names
- ✅ **Safe Deletion**: Validates user existence before deletion
- ✅ **Professional UI**: Consistent red danger buttons for delete actions

### Technical Implementation
- **New Function**: `deleteUser($pdo, $id)` với proper error handling
- **New Route**: `case 'delete'` trong routing system  
- **New CSS**: `.btn-danger` class với red styling và hover effects
- **New Variables**: `--danger-color` và `--danger-hover` CSS variables
- **Database Safety**: DELETE query với prepared statements
- **UI Enhancement**: Delete buttons positioned next to Edit buttons

### Database Operations
- **Query**: `DELETE FROM users WHERE id = ?` với PDO prepared statement
- **Validation**: Check user existence trước khi delete
- **Response**: Return success/error với user name trong message
- **Security**: SQL injection prevention với parameterized queries

## [v0.6.1] - 2025-08-14

### Changed
- **Color Scheme**: Updated primary colors từ blue → professional yellow/amber palette
- **Button Styling**: All buttons now use yellow branding colors
- **Form Focus States**: Input focus effects updated to yellow theme
- **Hover Effects**: Interactive elements use consistent yellow color scheme
- **Brand Identity**: Modern yellow branding throughout application

### Technical Details
- **CSS Variables**: Updated --primary-color (#2563eb → #f59e0b)
- **CSS Variables**: Updated --primary-hover (#1d4ed8 → #d97706)
- **Focus States**: Updated rgba focus box-shadows to match yellow theme
- **Accessibility**: Maintained color contrast ratios cho readability
- **No Breaking Changes**: All functionality preserved với new visual identity

### Related Issues
- ✅ [Issue #010](docs/issues/010.md) - Change Color Scheme to Yellow Palette

## [v0.6.0] - 2025-08-14

### Changed
- **Wide Layout**: Expanded main container width từ 500px → 1280px
- **Table Display**: Removed horizontal scroll constraints cho better table viewing
- **Screen Utilization**: Better use của available screen space on large displays
- **Professional Appearance**: Enhanced layout cho desktop usage

### Technical Details
- **CSS Update**: .container max-width expanded to 1280px
- **Table Enhancement**: Removed overflow-x auto và min-width constraints
- **Form Balance**: Kept forms at 500px width cho optimal readability
- **Responsive Design**: Maintains mobile/tablet responsiveness
- **No Breaking Changes**: All functionality preserved với improved layout

### Related Issues
- ✅ [Issue #009](docs/issues/009.md) - Expand Layout to 1280px Width

## [v0.5.2] - 2025-08-14

### Changed
- **Main Container Width**: Adjusted max-width từ 1200px → 500px cho toàn bộ layout
- **Table Responsiveness**: Added horizontal scroll support cho tables trong narrow containers
- **Compact Layout**: All content now fits trong 500px wide layout

### Technical Details
- **CSS Update**: .container max-width property updated to 500px
- **Table Enhancement**: Added overflow-x: auto và min-width: 600px cho tables
- **Responsive Design**: Maintains usability across all content types
- **No Breaking Changes**: All functionality preserved với improved layout

### Related Issues
- ✅ [Issue #008](docs/issues/008.md) - Main Content Container Width Adjustment

## [v0.5.1] - 2025-08-14

### Changed
- **Form Container Width**: Adjusted max-width từ 600px → 500px theo UI requirements
- **Better Form Proportions**: More compact form layout for better visual balance

### Technical Details
- **CSS Update**: .form-container max-width property updated
- **Responsive**: Maintains responsive behavior across all screen sizes
- **No Breaking Changes**: All existing functionality preserved

### Related Issues
- ✅ [Issue #007](docs/issues/007.md) - Form Container Max-Width Adjustment

## [v0.5.0] - 2025-08-14

### Added
- **Modern Design System** với CSS Variables
- **Enhanced UI/UX** với professional styling
- **Responsive Design** với mobile-first approach
- **Interactive Elements** với hover/focus states
- **Improved Typography** với system font stack
- **Better Form Styling** với enhanced validation display
- **Table Enhancements** với hover effects và better structure
- **Color System** với semantic color variables

### Changed
- **Complete CSS Overhaul**: Modern design system replacing basic styles
- **Enhanced Button System**: Multiple variants với proper states
- **Improved Table Design**: Better spacing, shadows, và interactions
- **Form Improvements**: Better input design với focus states
- **Mobile Responsiveness**: Optimized cho all device sizes
- **Visual Hierarchy**: Better typography scale và spacing

### Technical Details
- **CSS Variables**: Centralized design tokens
- **Modern CSS**: Flexbox, Grid, và advanced selectors
- **Responsive Breakpoints**: 768px, 480px breakpoints
- **Performance**: Optimized CSS với efficient selectors
- **Accessibility**: Better color contrast và focus states
- **Cross-browser**: Modern browser support

### Related Issues
- ✅ [Issue #006](docs/issues/006.md) - UI/UX Improvements (Phase 1)

## [v0.4.0] - 2025-08-14

### Added
- Edit User functionality với pre-populated form
- getUserById() function for individual user retrieval
- updateUser() function với duplicate email checking (excluding current user)
- "Edit" action links trong user table
- Actions column trong user table
- Edit form với proper validation và error handling

### Changed
- Enhanced routing system: added `?action=edit&id={user_id}` route
- User table now includes Actions column với Edit links
- Improved CSS với .btn-sm styling for action buttons
- Better error handling for invalid user IDs và not found cases

### Technical Details
- **New Routes**: `?action=edit&id={user_id}`
- **New Functions**: `getUserById($pdo, $id)`, `updateUser($pdo, $id, ...)`
- **Validation**: Same rules như Add User, plus duplicate email check excluding current user
- **Database**: UPDATE statements với WHERE clause và prepared statements
- **Security**: ID validation, user existence checking, SQL injection prevention
- **UX**: Pre-populated forms, consistent styling, proper redirects

### Related Issues
- ✅ [Issue #005](docs/issues/005.md) - Edit User functionality

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
