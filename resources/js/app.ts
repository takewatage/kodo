import './bootstrap'

import { createApp, h, DefineComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import '../sass/app.scss'
import GuestLayout from '../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Layouts/GuestLayout.vue'
import { vuetify } from '@/utils/vuetfly'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue'))
        page.then((module) => {
            module.default.layout = module.default.layout || GuestLayout
            return module
        })
        return page
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
        app.config.globalProperties.route = route
        app.use(plugin).use(ZiggyVue, Ziggy).use(vuetify).mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})
