export interface IUser {
    id: number
    name: string
    urlName: string
    email: string
    emailVerifiedAt: string | null
    role: number
    introduction: string
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: IUser
    }
    appName: string
}
