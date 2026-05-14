/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './app/Filament/**/*.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#7CB800',
                    50: '#F5FFB0',
                    100: '#EEFF80',
                    200: '#DFFF00',
                    300: '#CAEE00',
                    400: '#AACC00',
                    500: '#7CB800',
                    600: '#5E9200',
                    700: '#446800',
                    800: '#2e4800',
                    900: '#1c2e00',
                },
                accent: {
                    DEFAULT: '#DFFF00',
                    50: '#FAFFD0',
                    100: '#F5FF90',
                    200: '#ECFF40',
                    300: '#DFFF00',
                    400: '#CAEE00',
                    500: '#AACC00',
                    600: '#88AA00',
                    700: '#668800',
                },
                bg: '#F8FFE0',
            },
            fontFamily: {
                sans: ['Nunito', 'Be Vietnam Pro', 'system-ui', 'sans-serif'],
            },
        }
    },
    plugins: [],
}
