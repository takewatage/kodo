import { IIndexable } from '@team-decorate/alcts/dist/interfaces/IIndexxable'

export interface IPaginateLink {
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
    links: IPaginateLink[]
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
    links: IPaginateLink[] = []
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
        },
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
            this.links = paginationData.links as IPaginateLink[]
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
}
