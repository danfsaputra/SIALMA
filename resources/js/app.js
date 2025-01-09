import "./bootstrap";
import "../css/app.css";
import PrimeVue from "primevue/config";
import "@/primevue/assets/styles.scss";
// import '@vite(['resources/sass/app.scss', 'resources/js/app.js'])';
import "tailwindcss/defaultTheme";
import "primevue/resources/themes/lara-light-blue/theme.css";
import Toast from "primevue/toast";
import ToastService from "primevue/toastservice";
import DialogService from "primevue/dialogservice";
import ConfirmationService from "primevue/confirmationservice";
import BadgeDirective from "primevue/badgedirective";
import Tooltip from "primevue/tooltip";
import Ripple from "primevue/ripple";
import StyleClass from "primevue/styleclass";
import ConfirmDialog from "primevue/confirmdialog";
import ConfirmPopup from "primevue/confirmpopup";
import Dialog from "primevue/dialog";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import useAuth from "@/composables/auth.js";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

const { attempt } = useAuth();

const options = {
    confirmButtonColor: "#4183f2",
    cancelButtonColor: "#ec4248",
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        attempt().then(() => {
            return createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(PrimeVue, { ripple: true })
                .use(ToastService)
                .use(DialogService)
                .use(ConfirmationService)
                .directive("tooltip", Tooltip)
                .directive("badge", BadgeDirective)
                .directive("ripple", Ripple)
                .directive("styleclass", StyleClass)
                .component("Toast", Toast)
                .component("ConfirmDialog", ConfirmDialog)
                .component("ConfirmPopup", ConfirmPopup)
                .component("Dialog", Dialog)
                .use(ZiggyVue)
                .use(VueSweetalert2, options)
                .mount(el);
        });
    },
    progress: {
        color: "#4B5563",
    },
});
