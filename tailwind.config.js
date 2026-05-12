/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/css/**/*.css',
    ],
    theme: {
        extend: {
            colors: {
                'morris-cream': '#F8F5F0',
                'morris-primary': '#064E3B',
                'morris-terracotta': '#9F1239',
                'morris-gold': '#B45309',
                'morris-indigo': '#1E3A8A',
                'morris-olive': '#3F6212',
                'morris-text': '#1C1917',
                'morris-border': '#E7E5E4',
            },
            fontFamily: {
                'brand': ['Amiri', 'serif'],
                'magic': ['"Aref Ruqaa"', 'serif'],
                'body': ['Cairo', 'sans-serif'],
            },
            boxShadow: {
                'morris': '0 4px 20px -2px rgba(27, 74, 64, 0.08)',
                'morris-hover': '0 10px 30px -5px rgba(27, 74, 64, 0.15)',
            },
        },
    },
    plugins: [],
};
