import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                display: ['Space Grotesk', ...defaultTheme.fontFamily.sans],
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                accent: {
                    DEFAULT: '#00E5FF',
                    50: '#E0FAFF',
                    100: '#B3F1FF',
                    200: '#80E8FF',
                    300: '#4DDDFF',
                    400: '#1AD4FF',
                    500: '#00E5FF',
                    600: '#00CCE5',
                    700: '#00B8CC',
                    800: '#009EAD',
                    900: '#006670',
                },
                neo: {
                    yellow: '#FFE500',
                    pink: '#FF6B6B',
                    green: '#00E676',
                    purple: '#BB86FC',
                    orange: '#FF9100',
                }
            },
            borderRadius: {
                'xl': '12px',
            },
            boxShadow: {
                'nb': '4px 4px 0 #000000',
                'nb-sm': '3px 3px 0 #000000',
                'nb-lg': '6px 6px 0 #000000',
                'nb-accent': '4px 4px 0 #00B8CC',
                'nb-hover': '6px 6px 0 #00B8CC',
                'nb-white': '4px 4px 0 #FFFFFF',
            },
            animation: {
                'float': 'float 3s ease-in-out infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-8px)' },
                },
            },
        },
    },

    plugins: [forms],
};
