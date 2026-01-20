@extends('layouts.dashboard')

@section('title', 'تعديل الملف الشخصي')
@section('page-title', 'تعديل الملف الشخصي')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i> المعلومات الشخصية
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')

                        <!-- صورة الملف الشخصي -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="profile-picture-container text-center">
                                    <div class="profile-picture-wrapper mb-3">
                                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                                             alt="Profile Picture"
                                             class="profile-picture rounded-circle border"
                                             id="profileImagePreview"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                        <div class="profile-upload-overlay" id="uploadOverlay">
                                            <i class="bi bi-camera fs-4"></i>
                                        </div>
                                    </div>
                                    <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="changePhotoBtn">
                                        <i class="bi bi-camera me-1"></i> تغيير الصورة
                                    </button>
                                    @error('avatar')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    الصور المسموحة: JPG, PNG, GIF. الحد الأقصى: 2MB
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- الاسم -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الاسم الأول <span class="text-danger">*</span></label>
                                <input type="text" name="first_name"
                                       class="form-control @error('first_name') is-invalid @enderror"
                                       value="{{ old('first_name', Auth::user()->first_name) }}"
                                       required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">اسم العائلة <span class="text-danger">*</span></label>
                                <input type="text" name="last_name"
                                       class="form-control @error('last_name') is-invalid @enderror"
                                       value="{{ old('last_name', Auth::user()->last_name) }}"
                                       required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- البريد الإلكتروني -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', Auth::user()->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- رقم الهاتف -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="text" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', Auth::user()->phone) }}"
                                       placeholder="05XXXXXXXX">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- تاريخ الميلاد -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">تاريخ الميلاد</label>
                                <input type="date" name="birth_date"
                                       class="form-control @error('birth_date') is-invalid @enderror"
                                       value="{{ old('birth_date', Auth::user()->birth_date ? \Carbon\Carbon::parse(Auth::user()->birth_date)->format('Y-m-d') : '') }}">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- الجنس -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الجنس</label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">اختر الجنس</option>
                                    <option value="male" {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                                    <option value="female" {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : '' }}>أنثى</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- العنوان -->
                            <div class="col-12 mb-3">
                                <label class="form-label">العنوان</label>
                                <textarea name="address"
                                          class="form-control @error('address') is-invalid @enderror"
                                          rows="3">{{ old('address', Auth::user()->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- نبذة -->
                            <div class="col-12 mb-4">
                                <label class="form-label">نبذة عنك</label>
                                <textarea name="bio"
                                          class="form-control @error('bio') is-invalid @enderror"
                                          rows="4"
                                          placeholder="اكتب نبذة مختصرة عن نفسك...">{{ old('bio', Auth::user()->bio) }}</textarea>
                                <div class="form-text">يمكنك كتابة وصف مختصر عن نفسك (اختياري)</div>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- أزرار الحفظ -->
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-1"></i> إلغاء
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i> حفظ التغييرات
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- تغيير كلمة المرور -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-lock me-2"></i> تغيير كلمة المرور
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('password.update') }}" method="POST" id="passwordForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">كلمة المرور الحالية <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       id="currentPassword"
                                       required>
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="currentPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">كلمة المرور الجديدة <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="newPassword"
                                       required>
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="newPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">تأكيد كلمة المرور الجديدة <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation"
                                       class="form-control"
                                       id="confirmPassword"
                                       required>
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="confirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted" id="passwordHint">قوة كلمة المرور</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-key me-1"></i> تحديث كلمة المرور
                        </button>
                    </form>
                </div>
            </div>

            <!-- حذف الحساب -->
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i> حذف الحساب
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">
                            <i class="bi bi-exclamation-octagon me-2"></i> تحذير!
                        </h6>
                        <p class="mb-0">
                            عند حذف حسابك، سيتم حذف جميع بياناتك نهائياً ولا يمكن استرجاعها.
                            الرجاء التأكد قبل المتابعة.
                        </p>
                    </div>

                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash me-1"></i> حذف الحساب
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal حذف الحساب -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i> تأكيد حذف الحساب
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من رغبتك في حذف حسابك؟</p>
                <p class="text-danger">
                    <i class="bi bi-info-circle me-1"></i>
                    لا يمكن التراجع عن هذه العملية. سيتم حذف جميع بياناتك بشكل دائم.
                </p>

                <form action="{{ route('profile.destroy') }}" method="POST" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')

                    <div class="mb-3">
                        <label class="form-label">أدخل كلمة المرور للتأكيد</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="أدخل كلمة المرور" required>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                        <label class="form-check-label" for="confirmDelete">
                            أنا أدرك أن حذف الحساب لا يمكن التراجع عنه
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i> نعم، احذف الحساب
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-picture-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-upload-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transition: opacity 0.3s;
        cursor: pointer;
    }

    .profile-picture-wrapper:hover .profile-upload-overlay {
        opacity: 1;
    }

    .toggle-password {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .progress-bar {
        transition: width 0.3s, background-color 0.3s;
    }

    .border-danger {
        border: 1px solid #dc3545 !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // تحميل صورة الملف الشخصي
    const avatarInput = document.getElementById('avatarInput');
    const profileImagePreview = document.getElementById('profileImagePreview');
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    const uploadOverlay = document.getElementById('uploadOverlay');

    changePhotoBtn.addEventListener('click', () => avatarInput.click());
    uploadOverlay.addEventListener('click', () => avatarInput.click());

    avatarInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImagePreview.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // إظهار/إخفاء كلمة المرور
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });

    // قياس قوة كلمة المرور
    const newPasswordInput = document.getElementById('newPassword');
    const passwordStrengthBar = document.getElementById('passwordStrength');
    const passwordHint = document.getElementById('passwordHint');

    newPasswordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        let hint = '';
        let color = '#dc3545';

        if (password.length >= 8) strength += 25;
        if (/[A-Z]/.test(password)) strength += 25;
        if (/[0-9]/.test(password)) strength += 25;
        if (/[^A-Za-z0-9]/.test(password)) strength += 25;

        if (strength === 0) {
            hint = 'ضعيفة جداً';
            color = '#dc3545';
        } else if (strength <= 50) {
            hint = 'ضعيفة';
            color = '#fd7e14';
        } else if (strength <= 75) {
            hint = 'جيدة';
            color = '#ffc107';
        } else {
            hint = 'قوية';
            color = '#198754';
        }

        passwordStrengthBar.style.width = strength + '%';
        passwordStrengthBar.style.backgroundColor = color;
        passwordHint.textContent = `قوة كلمة المرور: ${hint}`;
        passwordHint.style.color = color;
    });

    // التحقق من صحة النموذج
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const firstName = this.querySelector('input[name="first_name"]').value.trim();
        const lastName = this.querySelector('input[name="last_name"]').value.trim();
        const email = this.querySelector('input[name="email"]').value.trim();

        if (!firstName || !lastName || !email) {
            e.preventDefault();
            alert('الرجاء ملء جميع الحقول المطلوبة');
            return false;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            alert('الرجاء إدخال بريد إلكتروني صحيح');
            return false;
        }
    });

    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        const currentPassword = this.querySelector('input[name="current_password"]').value;
        const newPassword = this.querySelector('input[name="password"]').value;
        const confirmPassword = this.querySelector('input[name="password_confirmation"]').value;

        if (!currentPassword || !newPassword || !confirmPassword) {
            e.preventDefault();
            alert('الرجاء ملء جميع حقول كلمة المرور');
            return false;
        }

        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('كلمة المرور الجديدة غير متطابقة');
            return false;
        }

        if (newPassword.length < 8) {
            e.preventDefault();
            alert('كلمة المرور الجديدة يجب أن تكون 8 أحرف على الأقل');
            return false;
        }
    });

    // التحقق قبل حذف الحساب
    document.getElementById('deleteAccountForm').addEventListener('submit', function(e) {
        const password = this.querySelector('input[name="password"]').value;
        const confirmCheck = document.getElementById('confirmDelete').checked;

        if (!password) {
            e.preventDefault();
            alert('الرجاء إدخال كلمة المرور للتأكيد');
            return false;
        }

        if (!confirmCheck) {
            e.preventDefault();
            alert('الرجاء الموافقة على الشروط');
            return false;
        }

        if (!confirm('هل أنت متأكد تماماً من حذف حسابك؟ لا يمكن التراجع عن هذه العملية.')) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection







{{-- @extends('layouts.dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Update Profile Info -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
@endsection --}}
