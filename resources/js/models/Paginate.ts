import { Paginate } from '@team-decorate/alcts'
import Model from '@team-decorate/alcts/dist/Model'
import { IIndexable } from '@team-decorate/alcts/dist/interfaces/IIndexxable'

export interface ILink {
    active: boolean
    label: string
    url?: string
}
interface PaginationData<T> {
    current_page: number
    data?: any[]
    first_page_url: string
    from: number
    last_page: number
    last_page_url: string
    links: ILink[]
    next_page_url: string | null
    path: string
    per_page: number
    prev_page_url: string | null
    to: number
    total: number
}

export default class PaginationModel<T> {
    currentPage = 0
    data: T[] = []
    firstPageUrl = ''
    from = 0
    lastPage = 0
    lastPageUrl = ''
    links: ILink[] = []
    nextPageUrl: string | null = null
    path = ''
    perPage = 0
    prevPageUrl: string | null = null
    to = 0
    total = 0

    constructor(
        data?: any,
        model?: {
            new (data: IIndexable): T
        }
    ) {
        if (data) {
            const paginationData = data as PaginationData<T>
            this.currentPage = paginationData.current_page
            this.data = []
            if (model) {
                this.data = this.setModel(data.data, model)
            }
            this.firstPageUrl = paginationData.first_page_url
            this.from = paginationData.from
            this.lastPage = paginationData.last_page
            this.lastPageUrl = paginationData.last_page_url
            this.links = paginationData.links as ILink[]
            this.nextPageUrl = paginationData.next_page_url
            this.path = paginationData.path
            this.perPage = paginationData.per_page
            this.prevPageUrl = paginationData.prev_page_url
            this.to = paginationData.to
            this.total = paginationData.total
        }
    }

    setModel(data: any, model: { new (data: IIndexable): T }) {
        return data.map((x: any) => {
            return new model(x)
        })
    }

    // setData<T extends Model>(
    //     data: T[],
    //     model: {
    //         new (data: IIndexable): T
    //     }
    // ) {
    //     const item = data.map((x) => {
    //         return new model(x)
    //     })
    //     console.log(this.data)
    //     console.log(item)
    //     this.data = item as T[]
    //     return this
    // }

    // setModel<T extends Model>(model: { new (data: IIndexable): T }) {
    //     PaginationModel<T>.data :T[] = this.data.map((v) => {
    //         // const data: any = v[1]
    //         if(v) {
    //             return new model(v)
    //         }
    //     })
    //
    //     return this
    // }
}
