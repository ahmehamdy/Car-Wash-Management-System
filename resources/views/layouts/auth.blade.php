<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CarWash Pro</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #1a365d;
            --secondary-blue: #2d3748;
            --accent-yellow: #f6c90e;
            --light-gray: #f7fafc;
            --dark-gray: #4a5568;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .auth-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .auth-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .auth-sidebar {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-sidebar h3 {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .auth-sidebar ul {
            list-style: none;
            padding: 0;
        }

        .auth-sidebar li {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }

        .auth-sidebar i {
            color: var(--accent-yellow);
            margin-left: 10px;
            margin-top: 5px;
        }

        .form-control:focus {
            border-color: var(--accent-yellow);
            box-shadow: 0 0 0 0.25rem rgba(246, 201, 14, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            padding: 12px 24px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #152642;
            border-color: #152642;
        }

        .btn-outline-primary {
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .social-btn {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
        }

        .social-btn:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }

        .role-card {
            border: 2px solid #dee2e6;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .role-card:hover, .role-card.active {
            border-color: var(--accent-yellow);
            background-color: rgba(246, 201, 14, 0.05);
        }

        .role-card.active {
            border-width: 3px;
        }

        .role-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-blue);
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            position: relative;
        }

        .step.active {
            background-color: var(--accent-yellow);
            color: var(--primary-blue);
        }

        .step.completed {
            background-color: var(--primary-blue);
            color: white;
        }

        .step::after {
            content: '';
            position: absolute;
            top: 50%;
            left: -20px;
            width: 20px;
            height: 2px;
            background-color: #e9ecef;
        }

        .step:first-child::after {
            display: none;
        }

        .password-toggle {
            cursor: pointer;
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .password-input {
            padding-left: 40px !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-sidebar {
                padding: 2rem;
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Validation styles */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: block;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                <i class="bi bi-droplet-half text-warning"></i> CarWash Pro
            </a>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted d-none d-md-block">ليس لديك حساب؟</span>
                <a href="{{ route('register') }}" class="btn btn-outline-primary">تسجيل جديد</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1 py-5">
        <div class="auth-container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">© 2023 CarWash Pro. جميع الحقوق محفوظة.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white text-decoration-none me-3">سياسة الخصوصية</a>
                    <a href="#" class="text-white text-decoration-none">شروط الاستخدام</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Password toggle visibility
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle
            const toggleButtons = document.querySelectorAll('.password-toggle');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            });

            // Role selection
            const roleCards = document.querySelectorAll('.role-card');
            roleCards.forEach(card => {
                card.addEventListener('click', function() {
                    roleCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Update hidden input
                    const roleInput = document.getElementById('role');
                    if (roleInput) {
                        roleInput.value = this.dataset.role;
                    }
                });
            });

            // Form validation
            const forms = document.querySelectorAll('.needs-validation');
            forms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            });
        });

        // Handle registration steps
        function nextStep(currentStep, nextStep) {
            document.getElementById('step' + currentStep).classList.remove('active');
            document.getElementById('step' + currentStep).classList.add('completed');
            document.getElementById('step' + nextStep).classList.add('active');

            document.getElementById('formStep' + currentStep).classList.add('d-none');
            document.getElementById('formStep' + nextStep).classList.remove('d-none');
        }

        function prevStep(currentStep, prevStep) {
            document.getElementById('step' + currentStep).classList.remove('active');
            document.getElementById('step' + prevStep).classList.add('active');
            document.getElementById('step' + prevStep).classList.remove('completed');

            document.getElementById('formStep' + currentStep).classList.add('d-none');
            document.getElementById('formStep' + prevStep).classList.remove('d-none');
        }
    </script>
    @stack('scripts')
</body>
</html>
