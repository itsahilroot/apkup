/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.php"],
  darkMode: 'class',
  safelist: [
    'bg-primary',
    'text-primary',
    'border-primary',
    'bg-secondary',
    'text-secondary',
    'border-secondary',
    'hover:bg-primary',
    'hover:text-primary',
    'hover:border-primary',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#27b427',
        secondary: '#00bcd4',
      },
    },
  },
  plugins: [],
}
