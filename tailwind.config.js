import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                cyber: ['Rajdhani', 'sans-serif'],
            },
            colors: {
                'neon-pink': '#FF003C',
                'neon-blue': '#00FFF5',
                'neon-yellow': '#FFE600',
                'cyber-black': '#0D0D0D',
                'cyber-gray': '#1A1A1A',
            },
            boxShadow: {
                'neon': '0 0 10px var(--tw-shadow-color)',
            },
        },
    },

    plugins: [forms, typography],
};
