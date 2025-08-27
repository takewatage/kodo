import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import vuetify from 'vite-plugin-vuetify'

export default defineConfig({
    // css: {
    //     devSourcemap: true,
    // },
    // css: {
    //     loaderOptions: {
    //         scss: {
    //             additionalData: '@use "resources/sass/variables" as *;',
    //         },
    //     },
    // },
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.ts'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        vuetify({ autoImport: true }),
    ],
})
