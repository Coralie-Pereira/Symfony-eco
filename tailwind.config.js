/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        customYellow: '#FFD700', // Remplacez cela par le code hexadécimal de votre jaune/or préféré
      },
    },
  },
  plugins: [],
}

