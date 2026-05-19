<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>استمارة تحكيم جديدة</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="background-color: #f4f4f4; padding: 20px;">
        <div style="background-color: #fff; padding: 20px; border-radius: 5px; max-width: 600px; margin: auto;">
            <h2 style="color: #166534;">إشعار استمارة تحكيم جديدة</h2>
            <p>لقد تلقيت استمارة تحكيم جديدة عبر النظام.</p>
            
            <p><strong>نوع الاستمارة:</strong> {{ $type === 'expert' ? 'لجنة التحكيم (ملحق 9 و 10)' : 'المصممين (ملحق 11)' }}</p>
            
            @if($type === 'expert')
                <p><strong>اسم المحكم:</strong> {{ $model->evaluator_name ?? 'غير محدد' }}</p>
            @else
                <p><strong>اسم المصمم:</strong> {{ $model->designer_name ?? 'غير محدد' }}</p>
                <p><strong>المصنع:</strong> {{ $model->factory_name ?? 'غير محدد' }}</p>
            @endif

            <p>يمكنك الاطلاع على كافة التفاصيل والنتائج من خلال لوحة تحكم الإدارة.</p>
            
            <br>
            <p>مع تحيات،<br>نظام رونق - جامعة القصيم</p>
        </div>
    </div>
</body>
</html>
