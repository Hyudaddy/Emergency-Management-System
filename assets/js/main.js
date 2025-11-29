// Emergency Contact Information Management System
// JavaScript Functions

// Function to confirm deletion
function confirmDelete(message) {
    return confirm(message || 'Are you sure you want to delete this record?');
}

// Function to validate form fields
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.style.borderColor = '#dc3545';
        } else {
            field.style.borderColor = '#ddd';
        }
    });
    
    return isValid;
}

// Function to format phone numbers
function formatPhoneNumber(phoneInput) {
    const phone = phoneInput.value.replace(/\D/g, '');
    const formattedPhone = phone.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
    phoneInput.value = formattedPhone;
}

// Add event listeners when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add form validation to all forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
    
    // Add phone number formatting to phone inputs
    const phoneInputs = document.querySelectorAll('input[type="tel"], input[name="phone_number"]');
    phoneInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value) {
                formatPhoneNumber(this);
            }
        });
    });
});

// Function to show/hide sections
function toggleSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.style.display = section.style.display === 'none' ? 'block' : 'none';
    }
}