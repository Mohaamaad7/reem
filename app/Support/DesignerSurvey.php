<?php

namespace App\Support;

class DesignerSurvey
{
    public const AVAILABLE = 1;
    public const UNAVAILABLE = 0;

    public static function sections(): array
    {
        return [
            [
                'title' => 'المحور الأول: جودة المحتوى والتعلم',
                'questions' => [
                    1 => 'وضوح أهداف التطبيق.',
                    2 => 'ساعدني التطبيق على التعلم بسهولة في أي وقت.',
                    3 => 'ساعدني التطبيق على التعلم بسهولة في أي مكان.',
                    4 => 'المادة العلمية للتطبيق المقترح منظمة بشكل منطقي.',
                    5 => 'يحتوي التطبيق على عدد كافٍ من الأشكال والصور التوضيحية.',
                ],
            ],
            [
                'title' => 'المحور الثاني: الفائدة المهنية والتطبيقية',
                'questions' => [
                    6 => 'يلبي التطبيق الاحتياجات الفعلية لدى المهتمين بالتصميم على الأقمشة.',
                    7 => 'يسهم التطبيق في تحسين مستوى الأداء في التصميم على الأقمشة.',
                    8 => 'يعد التطبيق المقترح أحد الأساليب الحديثة لتعلم التصميم على الأقمشة.',
                ],
            ],
            [
                'title' => 'المحور الثالث: الاتجاه نحو التعلم بالمحمول',
                'questions' => [
                    9 => 'استخدام الهواتف المحمولة في التعلم أمر مشجع.',
                    10 => 'يساير التطبيق المقترح التطور العلمي والتكنولوجي في مجال التصميم على الأقمشة باستخدام الهواتف المحمولة.',
                ],
            ],
            [
                'title' => 'المحور الرابع: الصعوبات والاتجاهات الوجدانية',
                'questions' => [
                    11 => 'شعرت بملل أثناء أدائي للمهارات بواسطة التطبيق.',
                    12 => 'وجدت صعوبة في التعامل مع التطبيق المقترح.',
                    13 => 'أسلوب الدراسة شيق بالتطبيق المقترح.',
                ],
            ],
        ];
    }

    public static function questions(): array
    {
        $questions = [];

        foreach (self::sections() as $section) {
            $questions += $section['questions'];
        }

        return $questions;
    }

    public static function labels(): array
    {
        return [
            self::AVAILABLE => 'متوفر',
            self::UNAVAILABLE => 'غير متوفر',
        ];
    }

    public static function label($value): string
    {
        if ($value === null || $value === '') {
            return 'غير محدد';
        }

        return self::labels()[(int) $value] ?? 'غير محدد';
    }
}
