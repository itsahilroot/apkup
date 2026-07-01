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
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
      colors: {
        primary: '#0052e0',
        accent: '#60a5fa',
        brand: {
          blue: '#0052e0',
          blueHover: '#0043b8',
          darkBg: '#090d16',
          darkCard: '#121b2d',
          darkBorder: '#1e293b'
        },
        playGreen: '#10b981',
        gray: {
          850: '#172033',
          950: '#030712'
        },
        slate: {
          150: '#e9eef5'
        }
      },
      scale: {
        '102': '1.02',
      }
    },
  },
  plugins: [],
}
