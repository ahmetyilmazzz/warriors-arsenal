function confirmDelete(weaponName) {
    return confirm(`"${weaponName}" adlı silahı silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!`);
}

function validateRegisterForm() {
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const passwordRepeat = document.getElementById('password_repeat').value.trim();
    const fullName = document.getElementById('full_name').value.trim();

    if (fullName === '') {
        alert('Ad soyad boş bırakılamaz!');
        document.getElementById('full_name').focus();
        return false;
    }
    if (username.length < 3) {
        alert('Kullanıcı adı en az 3 karakter olmalıdır!');
        document.getElementById('username').focus();
        return false;
    }
    if (!email.includes('@') || !email.includes('.')) {
        alert('Geçerli bir e-posta adresi girin!');
        document.getElementById('email').focus();
        return false;
    }
    if (password.length < 6) {
        alert('Şifre en az 6 karakter olmalıdır!');
        document.getElementById('password').focus();
        return false;
    }
    if (password !== passwordRepeat) {
        alert('Şifreler eşleşmiyor!');
        document.getElementById('password_repeat').focus();
        return false;
    }
    return true;
}

function validateWeaponForm() {
    const name = document.getElementById('name').value.trim();
    const type = document.getElementById('type').value.trim();
    
    if (name === '') {
        alert('Silah adı boş bırakılamaz!');
        document.getElementById('name').focus();
        return false;
    }
    
    if (type === '') {
        alert('Silah türü boş bırakılamaz!');
        document.getElementById('type').focus();
        return false;
    }
    
    return true;
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function searchWeapons() {
    const searchTerm = document.getElementById('searchInput').value;
    if (searchTerm.length >= 2 || searchTerm.length === 0) {
        window.location.href = `list.php?search=${encodeURIComponent(searchTerm)}`;
    }
}

function handleSearchKeyPress(event) {
    if (event.key === 'Enter') {
        searchWeapons();
    }
}

function sortTable(columnIndex) {
    const table = document.getElementById('weaponsTable');
    if (!table) return;
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = Array.from(tbody.getElementsByTagName('tr'));
    
    const isAscending = table.getAttribute('data-sort-direction') !== 'asc';
    table.setAttribute('data-sort-direction', isAscending ? 'asc' : 'desc');
    
    rows.sort((a, b) => {
        const aValue = a.getElementsByTagName('td')[columnIndex].textContent.trim();
        const bValue = b.getElementsByTagName('td')[columnIndex].textContent.trim();
        
        if (isAscending) {
            return aValue.localeCompare(bValue, 'tr', { numeric: true });
        } else {
            return bValue.localeCompare(aValue, 'tr', { numeric: true });
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

document.addEventListener('DOMContentLoaded', function() {
    try {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    } catch (e) {
        console.error("Bootstrap Tooltip hatası:", e);
    }
    
    try {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                if (bootstrap && bootstrap.Alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        });
    } catch (e) {
        console.error("Bootstrap Alert hatası:", e);
    }
    
    const forms = document.querySelectorAll('form.needs-validation');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            if (form.id === 'registerForm') {
                isValid = validateRegisterForm();
            } else if (form.id === 'weaponForm') {
                isValid = validateWeaponForm();
            }

            if (!isValid) {
                event.preventDefault(); 
                return;
            }

            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<span class="loading"></span> İşleniyor...';
                submitBtn.disabled = true;
            }
        });
    });

    const backToTopBtn = document.getElementById('backToTop');
    if (backToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.display = 'block';
            } else {
                backToTopBtn.style.display = 'none';
            }
        });
    }
});