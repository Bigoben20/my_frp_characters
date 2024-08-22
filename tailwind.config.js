import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                rolling: {
                  '0%': { transform: 'rotate(0deg)' },
                  '100%': {transform: 'rotate(360deg)'}
                }
            },
            animation: {
            'rolld20': 'rolling 0.7s ease-in-out infinite',
            }
        },
    },

    plugins: [forms],
};
