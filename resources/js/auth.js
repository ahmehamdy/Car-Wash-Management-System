document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.password-toggle');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
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

    const roleCards = document.querySelectorAll('.role-card');
    roleCards.forEach(card => {
        card.addEventListener('click', function () {
            roleCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');

            const roleInput = document.getElementById('role');
            if (roleInput) {
                roleInput.value = this.dataset.role;
            }
        });
    });

    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
});

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
