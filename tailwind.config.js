const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "primary-bg": "#16161a",
                "primary-bg-hover": "#18181c",
                "secondary-bg": "rgba(255,255,255,0.05)",
                "secondary-bg-hover": "rgba(255,255,255,0.08)",
                "brand-clr": "#ffca00",
                "brand-clr-hover": "#ffd740",
                "primary-clr": "#ffffff",
                "secondary-clr": "#818181",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
