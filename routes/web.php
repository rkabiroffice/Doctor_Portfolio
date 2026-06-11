<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\ContentSectionController;
use App\Http\Controllers\Admin\DoctorProfileController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\BiographyController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\PortfolioSectionController;
use App\Http\Controllers\Admin\PrescriptionController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::post('/appointments', [PublicController::class, 'storeAppointment'])->name('appointments.store');
Route::get('/appointments/patient/{patient}', [PublicController::class, 'getPatient'])->name('appointments.patient.lookup');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/hero-section', [HeroSectionController::class, 'index'])->name('admin.hero.index');
    Route::get('/admin/hero-section/create', [HeroSectionController::class, 'create'])->name('admin.hero.create');
    Route::post('/admin/hero-section', [HeroSectionController::class, 'store'])->name('admin.hero.store');
    Route::get('/admin/hero-section/{heroSection}/edit', [HeroSectionController::class, 'edit'])->name('admin.hero.edit');
    Route::put('/admin/hero-section/{heroSection}', [HeroSectionController::class, 'update'])->name('admin.hero.update');
    Route::delete('/admin/hero-section/{heroSection}', [HeroSectionController::class, 'destroy'])->name('admin.hero.destroy');
    Route::get('/admin/hero-section/export/{format}', [HeroSectionController::class, 'export'])->name('admin.hero.export');
    Route::get('/admin/hero-section/sample/{format}', [HeroSectionController::class, 'downloadSample'])->name('admin.hero.sample');
    Route::post('/admin/hero-section/import', [HeroSectionController::class, 'import'])->name('admin.hero.import');

    Route::get('/admin/about-section', [AboutSectionController::class, 'index'])->name('admin.about.index');
    Route::get('/admin/about-section/create', [AboutSectionController::class, 'create'])->name('admin.about.create');
    Route::post('/admin/about-section', [AboutSectionController::class, 'store'])->name('admin.about.store');
    Route::get('/admin/about-section/{aboutSection}/edit', [AboutSectionController::class, 'edit'])->name('admin.about.edit');
    Route::put('/admin/about-section/{aboutSection}', [AboutSectionController::class, 'update'])->name('admin.about.update');
    Route::delete('/admin/about-section/{aboutSection}', [AboutSectionController::class, 'destroy'])->name('admin.about.destroy');
    Route::get('/admin/about-section/export/{format}', [AboutSectionController::class, 'export'])->name('admin.about.export');
    Route::get('/admin/about-section/sample/{format}', [AboutSectionController::class, 'downloadSample'])->name('admin.about.sample');
    Route::post('/admin/about-section/import', [AboutSectionController::class, 'import'])->name('admin.about.import');

    Route::get('/admin/biography', [BiographyController::class, 'index'])->name('admin.biography.index');
    Route::get('/admin/biography/create', [BiographyController::class, 'create'])->name('admin.biography.create');
    Route::post('/admin/biography', [BiographyController::class, 'store'])->name('admin.biography.store');
    Route::get('/admin/biography/{biography}/edit', [BiographyController::class, 'edit'])->name('admin.biography.edit');
    Route::put('/admin/biography/{biography}', [BiographyController::class, 'update'])->name('admin.biography.update');
    Route::delete('/admin/biography/{biography}', [BiographyController::class, 'destroy'])->name('admin.biography.destroy');
    Route::get('/admin/biography/export/{format}', [BiographyController::class, 'export'])->name('admin.biography.export');
    Route::get('/admin/biography/sample/{format}', [BiographyController::class, 'downloadSample'])->name('admin.biography.sample');
    Route::post('/admin/biography/import', [BiographyController::class, 'import'])->name('admin.biography.import');

    Route::get('/admin/doctor-profile', [DoctorProfileController::class, 'index'])->name('admin.doctor-profile.index');
    Route::get('/admin/doctor-profile/create', [DoctorProfileController::class, 'create'])->name('admin.doctor-profile.create');
    Route::post('/admin/doctor-profile', [DoctorProfileController::class, 'store'])->name('admin.doctor-profile.store');
    Route::get('/admin/doctor-profile/{doctorProfile}/edit', [DoctorProfileController::class, 'edit'])->name('admin.doctor-profile.edit');
    Route::put('/admin/doctor-profile/{doctorProfile}', [DoctorProfileController::class, 'update'])->name('admin.doctor-profile.update');
    Route::delete('/admin/doctor-profile/{doctorProfile}', [DoctorProfileController::class, 'destroy'])->name('admin.doctor-profile.destroy');
    Route::get('/admin/doctor-profile/export/{format}', [DoctorProfileController::class, 'export'])->name('admin.doctor-profile.export');
    Route::get('/admin/doctor-profile/sample/{format}', [DoctorProfileController::class, 'downloadSample'])->name('admin.doctor-profile.sample');
    Route::post('/admin/doctor-profile/import', [DoctorProfileController::class, 'import'])->name('admin.doctor-profile.import');

    Route::get('/admin/content-sections', [ContentSectionController::class, 'index'])->name('admin.content-sections.index');
    Route::get('/admin/content-sections/create', [ContentSectionController::class, 'create'])->name('admin.content-sections.create');
    Route::post('/admin/content-sections', [ContentSectionController::class, 'store'])->name('admin.content-sections.store');
    Route::get('/admin/content-sections/{contentSection}/edit', [ContentSectionController::class, 'edit'])->name('admin.content-sections.edit');
    Route::put('/admin/content-sections/{contentSection}', [ContentSectionController::class, 'update'])->name('admin.content-sections.update');
    Route::delete('/admin/content-sections/{contentSection}', [ContentSectionController::class, 'destroy'])->name('admin.content-sections.destroy');
    Route::get('/admin/content-sections/export/{format}', [ContentSectionController::class, 'export'])->name('admin.content-sections.export');
    Route::get('/admin/content-sections/sample/{format}', [ContentSectionController::class, 'downloadSample'])->name('admin.content-sections.sample');
    Route::post('/admin/content-sections/import', [ContentSectionController::class, 'import'])->name('admin.content-sections.import');

    Route::get('/admin/sections', [PortfolioSectionController::class, 'index'])->name('admin.sections.index');
    Route::get('/admin/sections/create', [PortfolioSectionController::class, 'create'])->name('admin.sections.create');
    Route::post('/admin/sections', [PortfolioSectionController::class, 'store'])->name('admin.sections.store');
    Route::get('/admin/sections/{portfolioSection}/edit', [PortfolioSectionController::class, 'edit'])->name('admin.sections.edit');
    Route::put('/admin/sections/{portfolioSection}', [PortfolioSectionController::class, 'update'])->name('admin.sections.update');
    Route::delete('/admin/sections/{portfolioSection}', [PortfolioSectionController::class, 'destroy'])->name('admin.sections.destroy');
    Route::get('/admin/sections/export/{format}', [PortfolioSectionController::class, 'export'])->name('admin.sections.export');
    Route::get('/admin/sections/sample/{format}', [PortfolioSectionController::class, 'downloadSample'])->name('admin.sections.sample');
    Route::post('/admin/sections/import', [PortfolioSectionController::class, 'import'])->name('admin.sections.import');

    Route::get('/admin/services', [ServiceController::class, 'index'])->name('admin.services.index');
    Route::get('/admin/services/create', [ServiceController::class, 'create'])->name('admin.services.create');
    Route::post('/admin/services', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::get('/admin/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
    Route::put('/admin/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');
    Route::get('/admin/services/export/{format}', [ServiceController::class, 'export'])->name('admin.services.export');
    Route::get('/admin/services/sample/{format}', [ServiceController::class, 'downloadSample'])->name('admin.services.sample');
    Route::post('/admin/services/import', [ServiceController::class, 'import'])->name('admin.services.import');

    Route::get('/admin/education', [EducationController::class, 'index'])->name('admin.education.index');
    Route::get('/admin/education/create', [EducationController::class, 'create'])->name('admin.education.create');
    Route::post('/admin/education', [EducationController::class, 'store'])->name('admin.education.store');
    Route::get('/admin/education/{education}/edit', [EducationController::class, 'edit'])->name('admin.education.edit');
    Route::put('/admin/education/{education}', [EducationController::class, 'update'])->name('admin.education.update');
    Route::delete('/admin/education/{education}', [EducationController::class, 'destroy'])->name('admin.education.destroy');
    Route::get('/admin/education/export/{format}', [EducationController::class, 'export'])->name('admin.education.export');
    Route::get('/admin/education/sample/{format}', [EducationController::class, 'downloadSample'])->name('admin.education.sample');
    Route::post('/admin/education/import', [EducationController::class, 'import'])->name('admin.education.import');

    Route::get('/admin/blogs', [BlogController::class, 'index'])->name('admin.blogs.index');
    Route::get('/admin/blogs/create', [BlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/admin/blogs', [BlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/admin/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/admin/blogs/{blog}', [BlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/admin/blogs/{blog}', [BlogController::class, 'destroy'])->name('admin.blogs.destroy');
    Route::get('/admin/blogs/export/{format}', [BlogController::class, 'export'])->name('admin.blogs.export');
    Route::get('/admin/blogs/sample/{format}', [BlogController::class, 'downloadSample'])->name('admin.blogs.sample');
    Route::post('/admin/blogs/import', [BlogController::class, 'import'])->name('admin.blogs.import');

    Route::get('/admin/clinics', [ClinicController::class, 'index'])->name('admin.clinics.index');
    Route::get('/admin/clinics/create', [ClinicController::class, 'create'])->name('admin.clinics.create');
    Route::post('/admin/clinics', [ClinicController::class, 'store'])->name('admin.clinics.store');
    Route::get('/admin/clinics/{clinic}/edit', [ClinicController::class, 'edit'])->name('admin.clinics.edit');
    Route::put('/admin/clinics/{clinic}', [ClinicController::class, 'update'])->name('admin.clinics.update');
    Route::delete('/admin/clinics/{clinic}', [ClinicController::class, 'destroy'])->name('admin.clinics.destroy');
    Route::get('/admin/clinics/export/{format}', [ClinicController::class, 'export'])->name('admin.clinics.export');
    Route::get('/admin/clinics/sample/{format}', [ClinicController::class, 'downloadSample'])->name('admin.clinics.sample');
    Route::post('/admin/clinics/import', [ClinicController::class, 'import'])->name('admin.clinics.import');

    Route::get('/admin/patients', [PatientController::class, 'index'])->name('admin.patients.index');
    Route::get('/admin/patients/create', [PatientController::class, 'create'])->name('admin.patients.create');
    Route::post('/admin/patients', [PatientController::class, 'store'])->name('admin.patients.store');
    Route::get('/admin/patients/{patient}/edit', [PatientController::class, 'edit'])->name('admin.patients.edit');
    Route::put('/admin/patients/{patient}', [PatientController::class, 'update'])->name('admin.patients.update');
    Route::delete('/admin/patients/{patient}', [PatientController::class, 'destroy'])->name('admin.patients.destroy');

    Route::get('/admin/schedules', [ScheduleController::class, 'index'])->name('admin.schedules.index');
    Route::get('/admin/schedules/create', [ScheduleController::class, 'create'])->name('admin.schedules.create');
    Route::post('/admin/schedules', [ScheduleController::class, 'store'])->name('admin.schedules.store');
    Route::get('/admin/schedules/{schedule}/edit', [ScheduleController::class, 'edit'])->name('admin.schedules.edit');
    Route::put('/admin/schedules/{schedule}', [ScheduleController::class, 'update'])->name('admin.schedules.update');
    Route::delete('/admin/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('admin.schedules.destroy');
    Route::get('/admin/schedules/export/{format}', [ScheduleController::class, 'export'])->name('admin.schedules.export');
    Route::get('/admin/schedules/sample/{format}', [ScheduleController::class, 'downloadSample'])->name('admin.schedules.sample');
    Route::post('/admin/schedules/import', [ScheduleController::class, 'import'])->name('admin.schedules.import');

    Route::get('/admin/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('/admin/reviews/create', [ReviewController::class, 'create'])->name('admin.reviews.create');
    Route::post('/admin/reviews', [ReviewController::class, 'store'])->name('admin.reviews.store');
    Route::get('/admin/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('admin.reviews.edit');
    Route::put('/admin/reviews/{review}', [ReviewController::class, 'update'])->name('admin.reviews.update');
    Route::delete('/admin/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    Route::get('/admin/reviews/export/{format}', [ReviewController::class, 'export'])->name('admin.reviews.export');
    Route::get('/admin/reviews/sample/{format}', [ReviewController::class, 'downloadSample'])->name('admin.reviews.sample');
    Route::post('/admin/reviews/import', [ReviewController::class, 'import'])->name('admin.reviews.import');

    Route::get('/admin/medicines', [MedicineController::class, 'index'])->name('admin.medicines.index');
    Route::get('/admin/medicines/create', [MedicineController::class, 'create'])->name('admin.medicines.create');
    Route::post('/admin/medicines', [MedicineController::class, 'store'])->name('admin.medicines.store');
    Route::get('/admin/medicines/{medicine}/edit', [MedicineController::class, 'edit'])->name('admin.medicines.edit');
    Route::put('/admin/medicines/{medicine}', [MedicineController::class, 'update'])->name('admin.medicines.update');
    Route::delete('/admin/medicines/{medicine}', [MedicineController::class, 'destroy'])->name('admin.medicines.destroy');
    Route::get('/admin/medicines/search', [MedicineController::class, 'search'])->name('admin.medicines.search');
    Route::get('/admin/medicines/export/{format}', [MedicineController::class, 'export'])->name('admin.medicines.export');
    Route::get('/admin/medicines/sample/{format}', [MedicineController::class, 'downloadSample'])->name('admin.medicines.sample');
    Route::post('/admin/medicines/import', [MedicineController::class, 'import'])->name('admin.medicines.import');

    Route::get('/admin/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::get('/admin/appointments/create', [AppointmentController::class, 'create'])->name('admin.appointments.create');
    Route::post('/admin/appointments', [AppointmentController::class, 'store'])->name('admin.appointments.store');
    Route::get('/admin/appointments/{appointment}', [AppointmentController::class, 'show'])->name('admin.appointments.show');
    Route::put('/admin/appointments/{appointment}', [AppointmentController::class, 'update'])->name('admin.appointments.update');
    Route::delete('/admin/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');
    Route::post('/admin/reports', [ReportController::class, 'store'])->name('admin.reports.store');
    Route::get('/admin/reports/{report}/preview', [ReportController::class, 'preview'])->name('admin.reports.preview');
    Route::get('/admin/reports/{report}/download', [ReportController::class, 'download'])->name('admin.reports.download');
    Route::delete('/admin/reports/{report}', [ReportController::class, 'destroy'])->name('admin.reports.destroy');
    Route::get('/admin/appointments/export/{format}', [AppointmentController::class, 'export'])->name('admin.appointments.export');
    Route::get('/admin/appointments/sample/{format}', [AppointmentController::class, 'downloadSample'])->name('admin.appointments.sample');
    Route::post('/admin/appointments/import', [AppointmentController::class, 'import'])->name('admin.appointments.import');

    Route::get('/admin/prescriptions', [PrescriptionController::class, 'index'])->name('admin.prescriptions.index');
    Route::get('/admin/prescriptions/create', [PrescriptionController::class, 'create'])->name('admin.prescriptions.create');
    Route::post('/admin/prescriptions', [PrescriptionController::class, 'store'])->name('admin.prescriptions.store');
    Route::get('/admin/prescriptions/{prescription}/edit', [PrescriptionController::class, 'edit'])->name('admin.prescriptions.edit');
    Route::get('/admin/prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('admin.prescriptions.show');
    Route::put('/admin/prescriptions/{prescription}', [PrescriptionController::class, 'update'])->name('admin.prescriptions.update');
    Route::delete('/admin/prescriptions/{prescription}', [PrescriptionController::class, 'destroy'])->name('admin.prescriptions.destroy');
    Route::get('/admin/prescriptions/{prescription}/pdf', [PrescriptionController::class, 'downloadPdf'])->name('admin.prescriptions.pdf');
    Route::get('/admin/prescriptions/export/{format}', [PrescriptionController::class, 'export'])->name('admin.prescriptions.export');
    Route::get('/admin/prescriptions/sample/{format}', [PrescriptionController::class, 'downloadSample'])->name('admin.prescriptions.sample');
    Route::post('/admin/prescriptions/import', [PrescriptionController::class, 'import'])->name('admin.prescriptions.import');

    Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/admin/roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/admin/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::put('/admin/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    Route::get('/admin/roles/export/{format}', [RoleController::class, 'export'])->name('admin.roles.export');
    Route::get('/admin/roles/sample/{format}', [RoleController::class, 'downloadSample'])->name('admin.roles.sample');
    Route::post('/admin/roles/import', [RoleController::class, 'import'])->name('admin.roles.import');

    Route::resource('/admin/translations', TranslationController::class)
        ->except(['show'])
        ->names([
            'index' => 'admin.translations.index',
            'create' => 'admin.translations.create',
            'store' => 'admin.translations.store',
            'edit' => 'admin.translations.edit',
            'update' => 'admin.translations.update',
            'destroy' => 'admin.translations.destroy',
        ]);

    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::put('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');
});


