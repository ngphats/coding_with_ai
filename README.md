# User Management System

## Mô tả dự án
Hệ thống quản lý người dùng đơn giản sử dụng PHP và PostgreSQL. Dự án được thiết kế để dễ dàng mở rộng và tương tác với AI.

## Công nghệ sử dụng
- **Backend**: PHP 8.0+
- **Database**: PostgreSQL
- **Frontend**: HTML/CSS/JavaScript (đơn giản)

## Cấu trúc thư mục
```
users/
├── README.md           # Documentation chính
├── CHANGELOG.md        # Lịch sử thay đổi
├── docs/              # Tài liệu
│   ├── requirements.md # What we need
│   ├── architecture.md # Code structure  
│   ├── database.md     # DB setup
│   ├── features.md     # What we're building
│   └── issues/         # Issue management
│       ├── README.md   # Issues dashboard
│       ├── 000-template.md # Template for new issues
│       ├── 001.md      # MVP Implementation ✅
│       ├── 002.md      # Database Schema ✅
│       └── 003.md      # Phone Implementation ✅
└── index.php          # Main file (✅ đã tạo)
```

## Tính năng chính (MVP)
- [x] Kết nối PostgreSQL database
- [x] Query users từ database  
- [x] Hiển thị users trong HTML table
- [x] Basic CSS styling

## Cài đặt và chạy
1. Tạo database PostgreSQL
2. Tạo table users với sample data
3. Update database config trong `index.php`
4. Chạy file `index.php` trên web server

## Workflow: Documentation-First Development
1. **Planning Phase**: Viết specs trong docs/ trước khi code
2. **Design Phase**: Chi tiết hóa trong docs/architecture.md
3. **Implementation Phase**: Code theo đúng specs đã định
4. **Testing Phase**: Verify code match với documentation

## Ghi chú cho AI Context
- **MVP hoàn thành**: All planned features implemented
- **1 file index.php**: Chứa config + connection + query + HTML
- **Phone number feature**: Added và working
- **Clean state**: No pending issues, ready for new requirements
- **Database schema**: Table users với 6 columns (including phone)

## Cập nhật gần nhất
- Tạo cấu trúc project cơ bản
- Thiết lập documentation framework
- Setup docs-first workflow
- **v0.2.1**: Phone Number feature completed (2025-08-13)
- **Clean state**: All planned features implemented
