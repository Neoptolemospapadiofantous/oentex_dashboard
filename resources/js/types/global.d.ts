import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import { route as ziggyRoute } from 'ziggy-js';
import { PageProps as AppPageProps } from './';
import { I18n } from 'vue-i18n';
import { ComponentCustomProperties } from 'vue';
import { RouteParam, Router } from 'ziggy-js';

declare global {
    interface Window {
        axios: AxiosInstance;
    }

    /* eslint-disable no-var */
    var route: typeof ziggyRoute;
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}

// Not Needed
// declare module '@vue/runtime-core' {
//     interface ComponentCustomProperties {
//       $t: I18n['t']; // Correctly type the $t function using I18n's type
//     }
// }

// declare module '@vue/runtime-core' {
//     interface ComponentCustomProperties {
//       route: (name: string, params?: RouteParam, absolute?: boolean, customZiggy?: Router) => string;
//     }
//   }