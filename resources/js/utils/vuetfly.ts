import { createVuetify } from 'vuetify'
import { aliases, mdi } from 'vuetify/iconsets/mdi'
import Ja from 'dayjs/locale/ja'
export const vuetify = createVuetify({
    theme: {
        defaultTheme: 'dark',
        themes: {
            dark: {
                colors: {
                    primary: '#dbc5a4',
                    secondary: '#e7d9ba',
                    neutral: '#d1bbaf',
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
        thresholds: {
            xs: 0,
            sm: 340,
            md: 540,
            lg: 768,
            xl: 1080,
            xxl: 1280,
        },
    },
    date: {
        locale: {
            ja: Ja,
        },
        formats: {
            year: 'YYYY年',
            monthAndYear: 'YYYY年M月',
            normalDateWithWeekday: 'M月D日(dd)',
        },
    },
})
