declare module '*.vue' {
    import type { DefineComponent } from 'vue'
    const component: DefineComponent<NonNullable<unknown>, NonNullable<unknown>, never>
    export default component
}

// 型のみのエクスポートを許可する場合
declare module '*.vue' {
    import type { DefineComponent } from 'vue'
    const component: DefineComponent<NonNullable<unknown>, NonNullable<unknown>, never>
    export default component
    export * from '*.vue' // 型のエクスポートを許可
}
