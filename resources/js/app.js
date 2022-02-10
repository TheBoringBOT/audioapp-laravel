require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import FloatingVue from "floating-vue";
import AudioVisual from "vue-audio-visual";
import { library } from "@fortawesome/fontawesome-svg-core";
import "floating-vue/dist/style.css";
import VueClipboard from "vue3-clipboard";
import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";
import {
    faUserSecret,
    faCirclePause,
    faCirclePlay,
    faArrowDown,
    faLink,
    faThumbsUp,
    faInfo,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

// Options for Toast Notifications
const toastOptions = {
    transition: "Vue-Toastification__fade",
    maxToasts: 5,
    newestOnTop: true,
    position: "top-right",
    timeout: 1990,
    closeOnClick: true,
    pauseOnFocusLoss: false,
    pauseOnHover: false,
    draggable: true,
    draggablePercent: 0.3,
    showCloseButtonOnHover: false,
    hideProgressBar: true,
    closeButton: false,
    icon: true,
    rtl: false,
};

library.add(
    faUserSecret,
    faCirclePlay,
    faCirclePause,
    faArrowDown,
    faLink,
    faThumbsUp,
    faInfo
);

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .use(AudioVisual)
            .component("font-awesome-icon", FontAwesomeIcon)
            .use(FloatingVue)
            .use(VueClipboard, {
                autoSetContainer: true,
                appendToBody: true,
            })
            .use(Toast, toastOptions)
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
