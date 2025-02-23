/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', 'sans-serif'],
            },
            colors: {
                primary: '#6366F1',
                'primary-dark': '#4F46E5',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
