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
            keyframes: {
                wiggle: {
                    "0%": {
                        transform: "translateY(20px)",
                    },
                    "100%": {
                        transform: "translateY(0px)",
                    },
                },
            },
            animation: {
                wiggle: "wiggle  ease-in-out ",
            },
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "primary-bg": "#101010",
                "primary-bg-hover": "#18181c",
                "secondary-bg": "rgba(255,255,255,0.05)",
                "nav-bg": "#1c1c1c",
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
