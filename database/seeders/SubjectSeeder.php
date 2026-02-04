<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // Science Subjects
            ['name' => 'Mathematics', 'bn_name' => 'গণিত', 'category' => 'Science', 'icon' => 'calculator'],
            ['name' => 'Physics', 'bn_name' => 'পদার্থবিজ্ঞান', 'category' => 'Science', 'icon' => 'atom'],
            ['name' => 'Chemistry', 'bn_name' => 'রসায়ন', 'category' => 'Science', 'icon' => 'flask'],
            ['name' => 'Biology', 'bn_name' => 'জীববিজ্ঞান', 'category' => 'Science', 'icon' => 'dna'],
            ['name' => 'Higher Mathematics', 'bn_name' => 'উচ্চতর গণিত', 'category' => 'Science', 'icon' => 'calculator'],
            ['name' => 'ICT', 'bn_name' => 'আইসিটি', 'category' => 'Science', 'icon' => 'computer'],
            ['name' => 'General Science', 'bn_name' => 'সাধারণ বিজ্ঞান', 'category' => 'Science', 'icon' => 'microscope'],

            // Commerce Subjects
            ['name' => 'Accounting', 'bn_name' => 'হিসাববিজ্ঞান', 'category' => 'Commerce', 'icon' => 'book'],
            ['name' => 'Finance', 'bn_name' => 'ফাইন্যান্স', 'category' => 'Commerce', 'icon' => 'chart-line'],
            ['name' => 'Business Studies', 'bn_name' => 'ব্যবসা শিক্ষা', 'category' => 'Commerce', 'icon' => 'briefcase'],
            ['name' => 'Economics', 'bn_name' => 'অর্থনীতি', 'category' => 'Commerce', 'icon' => 'coins'],
            ['name' => 'Business Organization', 'bn_name' => 'ব্যবসা সংগঠন', 'category' => 'Commerce', 'icon' => 'building'],

            // Arts Subjects
            ['name' => 'English', 'bn_name' => 'ইংরেজি', 'category' => 'Arts', 'icon' => 'language'],
            ['name' => 'Bangla', 'bn_name' => 'বাংলা', 'category' => 'Arts', 'icon' => 'book-open'],
            ['name' => 'History', 'bn_name' => 'ইতিহাস', 'category' => 'Arts', 'icon' => 'landmark'],
            ['name' => 'Geography', 'bn_name' => 'ভূগোল', 'category' => 'Arts', 'icon' => 'globe'],
            ['name' => 'Civics', 'bn_name' => 'পৌরনীতি', 'category' => 'Arts', 'icon' => 'users'],
            ['name' => 'Social Science', 'bn_name' => 'সামাজিক বিজ্ঞান', 'category' => 'Arts', 'icon' => 'people-group'],
            ['name' => 'Islam Studies', 'bn_name' => 'ইসলাম শিক্ষা', 'category' => 'Arts', 'icon' => 'mosque'],
            ['name' => 'Hindu Religion', 'bn_name' => 'হিন্দু ধর্ম', 'category' => 'Arts', 'icon' => 'om'],
            ['name' => 'Bangladesh Studies', 'bn_name' => 'বাংলাদেশ ও বিশ্ব পরিচয়', 'category' => 'Arts', 'icon' => 'flag'],

            // Language Subjects
            ['name' => 'Arabic', 'bn_name' => 'আরবি', 'category' => 'Language', 'icon' => 'language'],
            ['name' => 'Hindi', 'bn_name' => 'হিন্দি', 'category' => 'Language', 'icon' => 'language'],
            ['name' => 'Sanskrit', 'bn_name' => 'সংস্কৃত', 'category' => 'Language', 'icon' => 'language'],

            // Other Subjects
            ['name' => 'General Knowledge', 'bn_name' => 'সাধারণ জ্ঞান', 'category' => 'Other', 'icon' => 'brain'],
            ['name' => 'Moral Education', 'bn_name' => 'নৈতিক শিক্ষা', 'category' => 'Other', 'icon' => 'heart'],
            ['name' => 'Agriculture Studies', 'bn_name' => 'কৃষি শিক্ষা', 'category' => 'Other', 'icon' => 'seedling'],
            ['name' => 'Home Economics', 'bn_name' => 'গার্হস্থ্য বিজ্ঞান', 'category' => 'Other', 'icon' => 'home'],
            ['name' => 'Physical Education', 'bn_name' => 'শারীরিক শিক্ষা', 'category' => 'Other', 'icon' => 'running'],
            ['name' => 'Arts & Crafts', 'bn_name' => 'চারু ও কারুকলা', 'category' => 'Other', 'icon' => 'palette'],
            ['name' => 'Music', 'bn_name' => 'সংগীত', 'category' => 'Other', 'icon' => 'music'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        $this->command->info('Subjects seeded successfully!');
        $this->command->info('Total Subjects: ' . count($subjects));
        $this->command->info('Science: ' . Subject::where('category', 'Science')->count());
        $this->command->info('Commerce: ' . Subject::where('category', 'Commerce')->count());
        $this->command->info('Arts: ' . Subject::where('category', 'Arts')->count());
        $this->command->info('Language: ' . Subject::where('category', 'Language')->count());
        $this->command->info('Other: ' . Subject::where('category', 'Other')->count());
    }
}
