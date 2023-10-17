import './bootstrap'

import { createApp, h, DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import { createVuetify } from 'vuetify'
import { aliases, mdi } from 'vuetify/iconsets/mdi'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import '../sass/app.scss'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

const vuetify = createVuetify({
    theme: {
        defaultTheme: 'dark',
        themes: {
            dark: {
                colors: {
                    primary: '#dbc5a4',
                    white: '#ffffff',
                },
            },
        },
    },
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
    display: {
        mobileBreakpoint: 'sm',
    },
})

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(vuetify)
            .mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})
