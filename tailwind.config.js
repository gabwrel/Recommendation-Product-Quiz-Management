/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js}", "./*.{html,js}"],
  theme: {
    extend: {
      fontFamily: {
        'inter': ['Inter', 'sans-serif'],
      },
      colors: {
        'mckenzie': '#8E7242',
        'bc1': '#2A68DC',
        'bc2': '#4DA3FF',
        'bc3': '#3677E4'
      },
    },
  },
  plugins: [],
}
