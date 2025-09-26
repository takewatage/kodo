export type Task = {
    id: string
    description: string
    categoryId: string
    isCompleted: boolean
    createdAt: string
}

export type Category = {
    id: string
    name: string
}
