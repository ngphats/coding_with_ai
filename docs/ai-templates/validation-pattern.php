<?php
/**
 * AI Template: Validation Pattern
 * Use this template for all input validation
 * 
 * AI-INSTRUCTIONS:
 * 1. Always validate on both client and server side
 * 2. Return array of field-specific errors
 * 3. Use descriptive error messages
 * 4. Handle optional fields properly
 */

/**
 * AI Template: Comprehensive Validation Function
 */
function validateInput($data, $requiredFields = [], $rules = []) {
    $errors = [];
    
    // Step 1: Check required fields
    foreach ($requiredFields as $field) {
        if (empty(trim($data[$field] ?? ''))) {
            $errors[$field] = ucfirst($field) . ' is required';
        }
    }
    
    // Step 2: Apply specific validation rules
    foreach ($rules as $field => $rule) {
        $value = $data[$field] ?? '';
        
        switch ($rule['type']) {
            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = 'Please enter a valid email address';
                }
                break;
                
            case 'phone':
                if (!empty($value) && !preg_match('/^[\d\-\+\(\)\s]+$/', $value)) {
                    $errors[$field] = 'Please enter a valid phone number';
                }
                break;
                
            case 'length':
                $min = $rule['min'] ?? 0;
                $max = $rule['max'] ?? 255;
                $length = strlen(trim($value));
                
                if ($length < $min) {
                    $errors[$field] = ucfirst($field) . " must be at least {$min} characters";
                } elseif ($length > $max) {
                    $errors[$field] = ucfirst($field) . " must be less than {$max} characters";
                }
                break;
                
            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $errors[$field] = ucfirst($field) . ' must be a number';
                }
                break;
                
            case 'regex':
                if (!empty($value) && !preg_match($rule['pattern'], $value)) {
                    $errors[$field] = $rule['message'] ?? ucfirst($field) . ' format is invalid';
                }
                break;
        }
    }
    
    return $errors;
}

/**
 * AI Template: User Input Validation (Specific Example)
 */
function validateUserInput($data) {
    $errors = [];
    
    // Required fields validation
    if (empty(trim($data['first_name'] ?? ''))) {
        $errors['first_name'] = 'First name is required';
    }
    
    if (empty(trim($data['last_name'] ?? ''))) {
        $errors['last_name'] = 'Last name is required';
    }
    
    if (empty(trim($data['email'] ?? ''))) {
        $errors['email'] = 'Email is required';
    }
    
    // Format validation
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    
    // Length validation
    if (strlen(trim($data['first_name'] ?? '')) > 50) {
        $errors['first_name'] = 'First name must be less than 50 characters';
    }
    
    if (strlen(trim($data['last_name'] ?? '')) > 50) {
        $errors['last_name'] = 'Last name must be less than 50 characters';
    }
    
    if (strlen(trim($data['email'] ?? '')) > 100) {
        $errors['email'] = 'Email must be less than 100 characters';
    }
    
    // Optional field validation
    if (!empty($data['phone']) && !preg_match('/^[\d\-\+\(\)\s]+$/', $data['phone'])) {
        $errors['phone'] = 'Please enter a valid phone number';
    }
    
    if (!empty($data['phone']) && strlen(trim($data['phone'])) > 20) {
        $errors['phone'] = 'Phone number must be less than 20 characters';
    }
    
    return $errors;
}

/**
 * AI Template: Client-Side Validation (JavaScript)
 */
?>
<script>
function validateForm() {
    const errors = [];
    
    // Get form fields
    const firstName = document.getElementById('first_name').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    
    // Clear previous errors
    clearErrors();
    
    // Required field validation
    if (!firstName) {
        showError('first_name', 'First name is required');
        errors.push('first_name');
    }
    
    if (!lastName) {
        showError('last_name', 'Last name is required');
        errors.push('last_name');
    }
    
    if (!email) {
        showError('email', 'Email is required');
        errors.push('email');
    }
    
    // Format validation
    if (email && !isValidEmail(email)) {
        showError('email', 'Please enter a valid email address');
        errors.push('email');
    }
    
    if (phone && !isValidPhone(phone)) {
        showError('phone', 'Please enter a valid phone number');
        errors.push('phone');
    }
    
    // Return validation result
    return errors.length === 0;
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    const phoneRegex = /^[\d\-\+\(\)\s]+$/;
    return phoneRegex.test(phone);
}

function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    field.classList.add('error');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

function clearErrors() {
    // Remove error classes
    document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
    
    // Remove error messages
    document.querySelectorAll('.field-error').forEach(el => el.remove());
}
</script>

<?php
/**
 * AI VALIDATION CHECKLIST:
 * 
 * ✅ Server-side validation (never trust client)
 * ✅ Client-side validation (better UX)
 * ✅ Required field checks
 * ✅ Format validation (email, phone, etc.)
 * ✅ Length validation
 * ✅ Descriptive error messages
 * ✅ Field-specific error mapping
 * ✅ Handle optional fields properly
 * ✅ Escape output in error messages
 * 
 * VALIDATION RULES:
 * - Required: first_name, last_name, email
 * - Optional: phone
 * - Email: valid format
 * - Phone: digits, spaces, dashes, parentheses only
 * - Length: reasonable limits for all fields
 * 
 * NEVER:
 * ❌ Trust client-side validation alone
 * ❌ Generic "invalid input" messages
 * ❌ Missing length validation
 * ❌ Unescaped error output
 */
?>
