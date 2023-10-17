import { Model, IIndexable } from '@team-decorate/alcts'
import { IPost } from '@/types'
import User from '@/models/User'
import dayjs from 'dayjs'

const fillable = ['id', 'groupId', 'userId', 'content', 'viewAuthType', 'createdAt']
export default class Post extends Model implements IPost {
    id = 0
    groupId = 0
    userId = 0
    title = ''
    content = ''
    viewAuthType = null
    createdAt = ''

    user = new User()

    constructor(data?: IIndexable) {
        super()
        this.fillable = fillable

        if (data) {
            this.data = data
        }
    }

    get createdAtDisplay() {
        return dayjs(this.createdAt).format('YYYY.MM.DD')
    }
}
