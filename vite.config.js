import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'; // Import the 'path' module
import vueI18n from '@intlify/unplugin-vue-i18n/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            refresh: true,
        }),
        vueI18n({
            include: path.resolve(__dirname, 'resources/js/locales/**'),
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),      // Alias for resources/js
            '@css': path.resolve(__dirname, 'resources/css'),   // Alias for resources/css
            '@images': path.resolve(__dirname, 'resources/images'), // Alias for resources/images
            '@components': path.resolve(__dirname, 'resources/js/components'), // Alias for components
            '@views': path.resolve(__dirname, 'resources/js/views'), // Alias for views
            '@locales': path.resolve(__dirname, 'resources/js/locales'), // Alias for locales (i18n)
        },
    }
    
});
