import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import VueTheMask from 'vue-the-mask'
import { createI18n } from 'vue-i18n'

import enMessages from '@/locales/en'; // Türkçe çeviriler
import trMessages from '@/locales/tr'; // Türkçe çeviriler

const messages = {
    tr: trMessages,
    en: enMessages
  };
const i18n = new createI18n({
    locale: 'tr',
    fallbackLocale: 'tr',
    messages
  });

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(VueTheMask)
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .mount(el);
    },
    progress: {
        color: "rgb(168 85 247)",
    },
});
