import { Model, IIndexable } from '@team-decorate/alcts'
import { IUser } from '@/types'

const fillable = ['id', 'name', 'email', 'role', 'introduction']
export default class User extends Model implements IUser {
    id = 0
    name = ''
    email = ''
    emailVerifiedAt = null
    role = 0
    introduction = ''

    constructor(data?: IIndexable) {
        super()
        this.fillable = fillable

        if (data) {
            this.data = data
        }
    }
}
