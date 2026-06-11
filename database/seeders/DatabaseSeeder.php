<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use App\Models\Appointment;
use App\Models\Biography;
use App\Models\Blog;
use App\Models\Clinic;
use App\Models\Education;
use App\Models\HeroSection;
use App\Models\Medicine;
use App\Models\PortfolioSection;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use App\Models\Review;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        HeroSection::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Advanced Sexual Health, Skin & Infertility Specialist',
                'subtitle' => 'Confidential and professional treatment for male & female sexual health, skin diseases, infertility, diabetes, allergy, and general medical care with modern diagnosis and compassionate consultation.',
                'button_text' => 'Book Appointment',
                'button_link' => '#book',
                'image_url' => 'https://images.pexels.com/photos/5212348/pexels-photo-5212348.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        AboutSection::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Dedicated to Better Health & Confidential Care',
                'subtitle' => 'Providing trusted healthcare solutions with modern treatment and patient-focused consultation.',
                'content' => 'Dr. Md. Raihan Uddin is an experienced physician specializing in sexual health, dermatology, infertility, diabetes, allergy, and family medicine. With advanced clinical training and years of patient care experience, he provides safe, confidential, and evidence-based treatment for both men and women. His goal is to help patients regain confidence, improve health, and achieve a better quality of life through compassionate and personalized care.',
                'image_url' => null,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Biography::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Professional Biography',
                'subtitle' => 'Experienced physician with specialized training in sexual medicine and dermatology.',
                'content' => 'Dr. Md. Raihan Uddin completed his MBBS and advanced medical training in dermatology, diabetes care, and family medicine. He has received professional training in sexual medicine, male infertility, STD management, dermatological procedures, and general medicine. He currently provides consultation for male and female sexual health, skin diseases, infertility issues, diabetes management, allergy treatment, and chronic medical conditions through his Dhaka and Cumilla chambers.',
                'video_url' => null,
                'youtube_url' => null,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $sections = [
            ['section_key' => 'services', 'label' => 'Services', 'title' => 'Specialized Medical Services', 'subtitle' => 'Complete care for sexual health, skin diseases, infertility, diabetes, and general medicine.', 'content' => 'We provide modern, confidential, and patient-centered treatment services for both men and women. Every patient receives professional diagnosis, personalized treatment plans, and continuous medical support.', 'button_text' => null, 'button_link' => null, 'sort_order' => 4, 'is_active' => true],
            ['section_key' => 'education', 'label' => 'Education', 'title' => 'Education, Certification & Professional Training', 'subtitle' => 'Professional credentials that support expert clinical care.', 'content' => 'Clinical training and certifications in sexual health, dermatology, infertility, diabetes, allergy, and family medicine.', 'button_text' => null, 'button_link' => null, 'sort_order' => 5, 'is_active' => true],
            ['section_key' => 'blog', 'label' => 'Blog', 'title' => 'Health Awareness & Medical Articles', 'subtitle' => 'Educational resources about sexual health, skin care, infertility, diabetes, and healthy living.', 'content' => 'Read trusted health articles written to help patients understand symptoms, prevention methods, treatments, and healthy lifestyle practices.', 'button_text' => 'Explore Articles', 'button_link' => '#blog', 'sort_order' => 6, 'is_active' => true],
            ['section_key' => 'schedule', 'label' => 'Schedule', 'title' => 'Visit the doctor at either chamber location based on your convenience.', 'subtitle' => 'Chamber schedules for both clinics.', 'content' => 'Schedule overview.', 'button_text' => null, 'button_link' => null, 'sort_order' => 7, 'is_active' => true],
            ['section_key' => 'reviews', 'label' => 'Reviews', 'title' => 'Patient experiences built on trust, clarity, and confidentiality.', 'subtitle' => 'Authentic patient voices and outcomes.', 'content' => 'Review section heading.', 'button_text' => null, 'button_link' => null, 'sort_order' => 8, 'is_active' => true],
            ['section_key' => 'contact', 'label' => 'Contact', 'title' => 'Book a Confidential Consultation', 'subtitle' => 'Professional medical support for sexual wellness, skin care, infertility, and overall health.', 'content' => 'Schedule your appointment for private and patient-focused healthcare consultation. Patients are encouraged to bring previous reports and medical records during follow-up visits for better treatment planning.', 'button_text' => 'Book Appointment', 'button_link' => '#book', 'sort_order' => 9, 'is_active' => true],
        ];

        foreach ($sections as $section) {
            PortfolioSection::updateOrCreate(['section_key' => $section['section_key']], $section);
        }

        $settings = [
            ['key' => 'site_name', 'value' => 'Dr. Md. Raihan Uddin', 'description' => 'Website name'],
            ['key' => 'site_tagline', 'value' => 'Confidential care for sexual health, skin, infertility, diabetes, allergy, and general medicine.', 'description' => 'Website tagline'],
            ['key' => 'logo_url', 'value' => '', 'description' => 'Logo URL'],
            ['key' => 'logo_text', 'value' => 'Raihan Uddin Clinic', 'description' => 'Logo text displayed in navigation'],
            ['key' => 'favicon_url', 'value' => '', 'description' => 'Favicon URL'],
            ['key' => 'primary_color', 'value' => '#093C5D', 'description' => 'Primary brand color'],
            ['key' => 'secondary_color', 'value' => '#3B7597', 'description' => 'Secondary brand color'],
            ['key' => 'footer_text', 'value' => 'Rahman Care Clinic. All rights reserved.', 'description' => 'Footer copyright text'],
            ['key' => 'meta_description', 'value' => 'Trusted confidential care for sexual health, skin diseases, infertility, diabetes, allergy, and general medical conditions.', 'description' => 'SEO meta description'],
            ['key' => 'meta_keywords', 'value' => 'sexual health, infertility, dermatology, diabetes, allergy, general medicine, confidential care', 'description' => 'SEO keywords'],
            ['key' => 'top_notice', 'value' => 'Dr. Md. Raihan Uddin offers confidential sexual health, skin, infertility, diabetes and allergy care across Dhaka and Cumilla.', 'description' => 'Top scrolling notice text'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/rahmanclinic', 'description' => 'Facebook profile URL'],
            ['key' => 'social_facebook_pages', 'value' => json_encode(['https://facebook.com/page1', 'https://facebook.com/page2']), 'description' => 'Multiple Facebook page URLs as JSON array'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/rahmanclinic', 'description' => 'Twitter profile URL'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/rahmanclinic', 'description' => 'Instagram profile URL'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/rahmanclinic', 'description' => 'LinkedIn profile URL'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/@rahmanclinic', 'description' => 'YouTube channel URL'],
            ['key' => 'social_tiktok', 'value' => 'https://tiktok.com/@rahmanclinic', 'description' => 'TikTok profile URL'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        $services = [
            ['title' => 'Male Sexual Health', 'description' => 'Treatment for erectile dysfunction, premature ejaculation, and low sexual performance.', 'icon' => 'heart', 'sort_order' => 1],
            ['title' => 'Female Sexual Wellness', 'description' => 'Professional consultation for female sexual discomfort and hormonal health.', 'icon' => 'sparkles', 'sort_order' => 2],
            ['title' => 'STD & STI Treatment', 'description' => 'Confidential diagnosis and treatment for sexually transmitted diseases.', 'icon' => 'shield-check', 'sort_order' => 3],
            ['title' => 'Male Infertility Care', 'description' => 'Evaluation and treatment for low sperm count and reproductive issues.', 'icon' => 'dna', 'sort_order' => 4],
            ['title' => 'Female Fertility Consultation', 'description' => 'Medical guidance and fertility support for women.', 'icon' => 'sparkles', 'sort_order' => 5],
            ['title' => 'Skin Allergy Treatment', 'description' => 'Treatment for itching, rashes, eczema, and allergic skin reactions.', 'icon' => 'exclamation-circle', 'sort_order' => 6],
            ['title' => 'Acne & Pimples Care', 'description' => 'Advanced treatment for acne scars, pimples, and oily skin problems.', 'icon' => 'face-smile', 'sort_order' => 7],
            ['title' => 'Hair Fall & Scalp Care', 'description' => 'Diagnosis and treatment for hair loss and scalp disorders.', 'icon' => 'scissors', 'sort_order' => 8],
            ['title' => 'Diabetes Management', 'description' => 'Complete diabetic care, monitoring, and lifestyle guidance.', 'icon' => 'heart-pulse', 'sort_order' => 9],
            ['title' => 'General Medicine Consultation', 'description' => 'Treatment for fever, infection, gastric issues, and common illnesses.', 'icon' => 'stethoscope', 'sort_order' => 10],
            ['title' => 'Chronic Allergy Care', 'description' => 'Long-term management for food, dust, and seasonal allergies.', 'icon' => 'cloud-rain', 'sort_order' => 11],
            ['title' => 'Family Health Checkup', 'description' => 'Comprehensive medical consultation for men, women, and families.', 'icon' => 'family', 'sort_order' => 12],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['title' => $service['title']], array_merge($service, ['is_active' => true]));
        }

        $educationItems = [
            ['degree' => 'MBBS', 'institution' => 'Bachelor of Medicine & Surgery', 'year_completed' => 2008, 'details' => 'Completed primary medical education with clinical training in patient care and diagnosis.', 'type' => 'Education'],
            ['degree' => 'DDV (DU)', 'institution' => 'Diploma in Dermatology & Venereology', 'year_completed' => 2012, 'details' => 'Specialized training in skin diseases and sexual health treatment.', 'type' => 'Certification'],
            ['degree' => 'CCD (BIRDEM)', 'institution' => 'Certificate Course in Diabetes', 'year_completed' => 2014, 'details' => 'Advanced education in diabetes diagnosis, management, and lifestyle care.', 'type' => 'Certification'],
            ['degree' => 'FCGP', 'institution' => 'Family Medicine Certification', 'year_completed' => 2016, 'details' => 'Professional training in family healthcare and chronic disease management.', 'type' => 'Certification'],
            ['degree' => 'PGT (Medicine)', 'institution' => 'Post Graduate Training in Medicine', 'year_completed' => 2018, 'details' => 'Clinical training in internal medicine and patient management.', 'type' => 'Certification'],
            ['degree' => 'STD & Dermatological Surgery Training', 'institution' => 'Specialized Clinical Training', 'year_completed' => 2019, 'details' => 'Hands-on training in STD treatment, leprosy care, hair transplant, and skin procedures.', 'type' => 'Certification'],
            ['degree' => 'Male Infertility Training (USA)', 'institution' => 'International Fertility Training', 'year_completed' => 2021, 'details' => 'Advanced learning in male reproductive and infertility management.', 'type' => 'Certification'],
            ['degree' => 'Fellowship in Sexual Medicine', 'institution' => 'Sexual Medicine Fellowship (India)', 'year_completed' => 2023, 'details' => 'Professional fellowship focused on modern sexual health treatment and counseling.', 'type' => 'Certification'],
        ];

        foreach ($educationItems as $education) {
            Education::updateOrCreate(['degree' => $education['degree']], $education);
        }

        $blogs = [
            ['title' => 'Common Causes of Male Sexual Weakness', 'excerpt' => 'Learn the medical and lifestyle reasons behind sexual performance issues.', 'content' => 'A detailed look at how health, stress, hormones, and lifestyle can affect male sexual performance and how treatment can help.', 'image_url' => 'https://images.pexels.com/photos/4056838/pexels-photo-4056838.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 1],
            ['title' => 'How to Improve Female Sexual Health', 'excerpt' => 'Important tips for hormonal balance and intimate wellness.', 'content' => 'Guidance on nutrition, communication, medical evaluation, and lifestyle changes to support women’s sexual health.', 'image_url' => 'https://images.pexels.com/photos/3760065/pexels-photo-3760065.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 2],
            ['title' => 'Early Signs of Diabetes', 'excerpt' => 'Understand the warning symptoms of diabetes before complications begin.', 'content' => 'Recognizing early warning signs of diabetes enables prompt diagnosis and better long-term management.', 'image_url' => 'https://images.pexels.com/photos/4056538/pexels-photo-4056538.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 3],
            ['title' => 'Best Treatment for Acne & Pimples', 'excerpt' => 'Modern ways to reduce acne and improve skin health.', 'content' => 'Learn evidence-based treatment strategies for acne, pore care, and preventing acne scars.', 'image_url' => 'https://images.pexels.com/photos/3762650/pexels-photo-3762650.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 4],
            ['title' => 'Male Infertility: Causes & Solutions', 'excerpt' => 'Medical reasons behind infertility and available treatments.', 'content' => 'An overview of male reproductive health, sperm quality factors, and current treatment options.', 'image_url' => 'https://images.pexels.com/photos/4327229/pexels-photo-4327229.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 5],
            ['title' => 'Understanding STD Symptoms', 'excerpt' => 'Important facts about sexually transmitted infections and prevention.', 'content' => 'Key symptoms, testing advice, and safe treatment practices for STDs and STIs.', 'image_url' => 'https://images.pexels.com/photos/5212329/pexels-photo-5212329.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 6],
            ['title' => 'Hair Fall: Causes & Prevention', 'excerpt' => 'How stress, hormones, and nutrition affect hair health.', 'content' => 'Insights on what causes hair loss and practical steps to preserve hair and scalp health.', 'image_url' => 'https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 7],
            ['title' => 'Skin Allergy During Seasonal Changes', 'excerpt' => 'Ways to prevent itching, rash, and skin irritation.', 'content' => 'Advice on protecting your skin during seasonal allergy triggers and environmental changes.', 'image_url' => 'https://images.pexels.com/photos/6465128/pexels-photo-6465128.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 8],
            ['title' => 'Healthy Lifestyle for Better Sexual Health', 'excerpt' => 'Daily habits that improve confidence and intimate wellness.', 'content' => 'A lifestyle guide for stronger sexual health, improved energy, and emotional wellbeing.', 'image_url' => 'https://images.pexels.com/photos/3768126/pexels-photo-3768126.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 9],
            ['title' => 'Foods That Help Diabetes Control', 'excerpt' => 'Healthy diet suggestions for diabetic patients.', 'content' => 'Nutrition tips and food choices that support stable blood sugar and better diabetes outcomes.', 'image_url' => 'https://images.pexels.com/photos/5938/food-salad-healthy-lunch.jpg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 10],
            ['title' => 'Female Fertility Health Tips', 'excerpt' => 'Important medical advice for reproductive wellness.', 'content' => 'Supportive tips for women seeking to improve fertility and reproductive health naturally and medically.', 'image_url' => 'https://images.pexels.com/photos/3831659/pexels-photo-3831659.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 11],
            ['title' => 'Importance of Regular Health Checkups', 'excerpt' => 'Why preventive healthcare is essential for long-term wellness.', 'content' => 'Regular health screening helps detect problems early and keeps chronic conditions under control.', 'image_url' => 'https://images.pexels.com/photos/4052171/pexels-photo-4052171.jpeg?auto=compress&cs=tinysrgb&h=1200&w=800', 'sort_order' => 12],
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(['title' => $blog['title']], array_merge($blog, ['is_published' => true]));
        }

        $clinicDhaka = Clinic::updateOrCreate(
            ['name' => 'Pure Scientific Diagnostic Services Ltd. Besides Lazz Pharma Ltd.'],
            [
                'address' => 'Dhaka Medical College Hospital Unit-2 Near Naz Farm, Dhaka',
                'city' => 'Dhaka',
                'phones' => ['01647-386185'],
                'map_embed_url' => null,
                'is_active' => true,
            ]
        );

        $clinicCumilla = Clinic::updateOrCreate(
            ['name' => '1 No. Hospital Gate, Cumilla.'],
            [
                'address' => 'Opposite “Molla House” Swapna Super Market, Cumilla',
                'city' => 'Cumilla',
                'phones' => ['01727-375664'],
                'map_embed_url' => null,
                'is_active' => true,
            ]
        );

        $clinicSchedules = [
            ['clinic_id' => $clinicDhaka->id, 'day_name' => 'Thursday', 'day_order' => 1, 'start_time' => '14:00:00', 'end_time' => '22:00:00', 'appointment_limit' => 20, 'is_closed' => false],
            ['clinic_id' => $clinicDhaka->id, 'day_name' => 'Friday', 'day_order' => 2, 'start_time' => '14:00:00', 'end_time' => '22:00:00', 'appointment_limit' => 20, 'is_closed' => false],
            ['clinic_id' => $clinicDhaka->id, 'day_name' => 'Saturday', 'day_order' => 3, 'start_time' => '14:00:00', 'end_time' => '22:00:00', 'appointment_limit' => 20, 'is_closed' => false],
            ['clinic_id' => $clinicCumilla->id, 'day_name' => 'Monday', 'day_order' => 1, 'start_time' => '13:00:00', 'end_time' => '21:00:00', 'appointment_limit' => 20, 'is_closed' => false],
            ['clinic_id' => $clinicCumilla->id, 'day_name' => 'Tuesday', 'day_order' => 2, 'start_time' => '13:00:00', 'end_time' => '21:00:00', 'appointment_limit' => 20, 'is_closed' => false],
            ['clinic_id' => $clinicCumilla->id, 'day_name' => 'Wednesday', 'day_order' => 3, 'start_time' => '13:00:00', 'end_time' => '21:00:00', 'appointment_limit' => 20, 'is_closed' => false],
        ];

        foreach ($clinicSchedules as $schedule) {
            Schedule::updateOrCreate(
                ['clinic_id' => $schedule['clinic_id'], 'day_name' => $schedule['day_name']],
                $schedule
            );
        }

        Medicine::factory()->count(25)->create();
        Review::factory()->count(6)->create();
        Appointment::factory()->count(16)->create()->each(function ($appointment) {
            if (in_array($appointment->status, ['completed', 'confirmed'])) {
                $prescription = Prescription::factory()->create(['appointment_id' => $appointment->id]);
                $medicines = Medicine::inRandomOrder()->take(rand(2, 5))->get();
                foreach ($medicines as $medicine) {
                    PrescriptionMedicine::factory()->create([
                        'prescription_id' => $prescription->id,
                        'medicine_id' => $medicine->id,
                    ]);
                }
            }
        });

        Role::updateOrCreate(
            ['name' => 'Doctor'],
            [
                'permissions' => ['manage_profile', 'manage_sections', 'manage_services', 'manage_education', 'manage_blogs', 'manage_clinics', 'manage_schedules', 'manage_reviews', 'manage_appointments', 'manage_prescriptions', 'manage_medicines', 'manage_roles', 'manage_settings'],
                'description' => 'Full administrative access for the clinic owner.',
            ]
        );

        Role::updateOrCreate(
            ['name' => 'Receptionist'],
            [
                'permissions' => ['manage_appointments', 'view_profile', 'view_appointments'],
                'description' => 'Can manage bookings and patient scheduling.',
            ]
        );

        Role::updateOrCreate(
            ['name' => 'Assistant'],
            [
                'permissions' => ['view_profile', 'view_appointments', 'manage_reviews', 'manage_blogs'],
                'description' => 'Supports operations and content updates.',
            ]
        );
    }
}
