import {snakeToCamel, camelToSnake } from '@/utilities/stringUtility'
import axios from 'axios'
import { IUser } from "@/types";

const LIMIT = 10

interface ILink {
    url?: string
    label: string
    active: boolean
}
interface IPaginate {
    originalData: any
    total: number
    perPage: number
    currentPage: number
    lastPage: number
    firstPageUrl: string
    lastPageUrl: string
    nextPageUrl: string
    prevPageUrl: string
    path: string
    from: number
    to: number
    data: any[]
    model: null|any
    auto: boolean
    links: ILink[]
}

export default class Paginate implements IPaginate {
    originalData = null
    currentPage = 0
    firstPageUrl = ''
    from = 0
    lastPage = 0
    lastPageUrl = ''
    nextPageUrl = ''
    path = ''
    perPage = 0
    prevPageUrl = ''
    to = 0
    total = 0
    data = []

    model = null
    auto = true
    links = []
    constructor (data = null, isAuto = true) {
        this.originalData = data
        this.auto = isAuto

        if (data) {
            this.create()
        }
    }

    // get limit () {
    //     if (this.lastPage < LIMIT) {
    //         return this.lastPage
    //     }
    //     return LIMIT
    // }
    //
    // get _model () {
    //     return 'Paginate'
    // }

    // get linkNumbers () {
    //     const page = this.getPage()
    //     return linq.range(this.getFrom(), this.limit)
    //         .select(x => {
    //             const active = page === x
    //             return {
    //                 active: active,
    //                 num: x,
    //                 path: this.getPath(x)
    //             }
    //         })
    //         .toArray()
    // }
    //
    // get hasPrev () {
    //     if(this.prevPageUrl) {
    //         return '/' + this.prevPageUrl.match(/api.*/)[0]
    //     }
    //     return this.prevPageUrl
    // }

    // get prev () {
    //     const num = this.getPage() - 1
    //     return {
    //         path: this.getPath(num),
    //         num: num,
    //         disabled: !this.hasPrev
    //     }
    // }
    //
    // get hasNext () {
    //
    // }
    //
    // get next () {
    //
    // }
    //
    // get hasData() {
    //     return this.data.length
    // }

    // async nextUpdate(key = null, query = null) {
    //     let url = this.hasNext
    //     if(query) {
    //         const q = buildQuery(query)
    //         url = `${url}&${q}`
    //     }
    //     const { data } = await axios.get(url)
    //     const d = this.data
    //     this.create(key ? data[key] : data)
    //     d.push(...this.data)
    //     this.data = d
    // }
    //
    // getPath (num) {
    //     const query = Object.assign({}, store.state.route.query)
    //     query.page = num
    //     return `${this.path}?${buildQuery(query)}`
    //
    // }
    //
    // getFrom () {
    //     let from = 1
    //     const check = Math.floor(this.limit / 2)
    //     const page = this.getPage()
    //     if (this.currentPage > check) {
    //         from = this.currentPage - check
    //     }
    //
    //     if (this.lastPage < page + check) {
    //         from = this.lastPage - (this.limit - 1)
    //     }
    //
    //     return from
    // }
    //
    // getPage () {
    //     let page = store.state.route.query.page || 1
    //     if (!this.auto) {
    //         page = this.currentPage
    //     }
    //     return Number(page)
    // }

    // setModel (model:any) {
    //     this.model = model
    //     return this
    // }
    //
    // setLimit (num: number) {
    //     LIMIT = num
    //     return this
    // }
    //
    create (source = null) {

        const data:any = source || this.originalData
        data.toArray()
            .map((x: { key: string }) => {
            x.key = camelToSnake(x.key)
            return x
        })
            .filter((x: { key: string }) => {
                return this && Object.prototype.hasOwnProperty.call(this, snakeToCamel(x.key))
            })


        linq.from(data)
            .select(x => {
                x.key = camelToSnake(x.key)
                return x
            })
            .where(x => this.hasOwnProperty(snakeToCamel(x.key)))
            .select(x => {
                const key = snakeToCamel(x.key)

                if (typeof this[key] === 'number') {
                    this[key] = Number(x.value)
                    return
                }

                if (key === 'data' && this.model) {
                    this[key] = linq.from(x.value)
                        .select(x => new this.model(x)).toArray()
                    return
                }

                this[key] = x.value
                return x
            })
            .toArray()

        this.path = store.state.route.path
        return this
    }
    //
    // getPostable () {
    //
    //     return linq.from(this)
    //         .where(x => linq.from(FILLABEL).any(xs => xs === x.key))
    //         .where(x => x.value)
    //         .select(x => {
    //             return {
    //                 key: camelToSnake(x.key),
    //                 value: x.value
    //             }
    //         })
    //         .toObject('$.key', '$.value')
    // }

}
