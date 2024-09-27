import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import { PerfectScrollbar } from 'vue3-perfect-scrollbar';
import Popper from 'vue3-popper';
import i18n from '@/i18n';
import appSetting from '@/app-setting';
import { createPinia } from 'pinia';
const pinia = createPinia();

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)  // Pinia is used here before accessing any store
            .use(i18n)
            .component('PerfectScrollbar', PerfectScrollbar)
            .component('Popper', Popper)  // Fixed the extra space
            .mount(el);  

        appSetting.init();
    },
    progress: {
        color: '#4B5563',
    },
});

