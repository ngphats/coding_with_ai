---
applyTo: '**'
---

# User Management System - AI Context

## Project Overview
- **Type**: PHP User Management System với PostgreSQL
- **Approach**: Documentation-First Development
- **Architecture**: Single-file MVP (index.php)
- **Current Version**: v0.2.1 (Phone Number feature completed)

## Key Files to Reference
1. **README.md** - Project overview, current status, structure
2. **CHANGELOG.md** - Version history với detailed technical changes
3. **docs/requirements.md** - What we need to implement
4. **docs/architecture.md** - Code structure và patterns
5. **docs/database.md** - DB setup và schema
6. **docs/issues/README.md** - Current active issues và priorities

## AI Workflow Instructions
1. **Always read README.md first** - Contains current project status
2. **Check docs/issues/README.md** - For active issues và next priorities
3. **Reference appropriate docs/** - For detailed specs
4. **Update CHANGELOG.md** - When completing any changes
5. **Follow Documentation-First** - Update docs before coding

## Current Context (2025-08-14)
- **Status**: MVP completed với phone number feature
- **Active Issues**: None (all current issues completed)
- **Backlog**: None (clean slate for new requirements)
- **Architecture**: Single index.php file với embedded HTML/CSS/JS

## Technical Stack
- **Backend**: PHP 8.0+ với PDO
- **Database**: PostgreSQL với users table
- **Frontend**: HTML table với basic CSS styling
- **Security**: PDO prepared statements, htmlspecialchars() escaping

## Development Guidelines
- Keep single-file approach for now
- Docs-first: Update requirements → architecture → implement
- Track all changes through issues system
- Maintain version history trong CHANGELOG
- Test thoroughly before marking issues complete
