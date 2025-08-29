### 基本的な使い方

```vue
<!-- SimpleDialog.vue -->
<template>
  <v-card>
    <v-card-title>{{ title }}</v-card-title>
    <v-card-text>{{ message }}</v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn @click="onClose">閉じる</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script setup lang="ts">
interface Props {
  onClose: () => void
  title?: string
  message?: string
}

const props = withDefaults(defineProps<Props>(), {
  title: 'お知らせ',
  message: 'メッセージ'
})
</script>
```

```vue
<!-- 使用例 -->
<script setup lang="ts">
import { useDialogService } from '@/composables/common/useDialogService'
import SimpleDialog from '@/components/dialogs/SimpleDialog.vue'

const dialog = useDialogService()

const showMessage = () => {
  dialog.open({
    component: SimpleDialog,
    props: {
      title: '確認',
      message: '処理が完了しました'
    }
  })
}
</script>
```

### 2. 結果を返すダイアログ

```vue
<!-- ConfirmDialog.vue -->
<template>
    <v-card>
        <v-card-title>{{ title }}</v-card-title>
        <v-card-text>{{ message }}</v-card-text>
        <v-card-actions>
            <v-spacer />
            <v-btn @click="() => onClose(false)">キャンセル</v-btn>
            <v-btn color="primary" @click="() => onClose(true)">確認</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup lang="ts">
    interface Props {
        onClose: (result: boolean) => void
        title?: string
        message?: string
    }

    defineProps<Props>()
</script>
```

```vue
// 使用例
const confirmDelete = async () => {
  const { afterClosed } = dialog.open<{ title: string; message: string }, boolean>({
    component: ConfirmDialog,
    props: {
      title: '削除確認',
      message: '本当に削除しますか？'
    },
    disableClose: true // 外側クリックで閉じない
  })

  const confirmed = await afterClosed()
  if (confirmed) {
    // 削除処理
    await deleteItem()
  }
}
```

### 3. フォームダイアログ

```vue
<!-- UserFormDialog.vue -->
<template>
  <v-card>
    <v-card-title>ユーザー情報入力</v-card-title>
    <v-card-text>
      <v-form ref="form" v-model="valid">
        <v-text-field
          v-model="formData.name"
          label="名前"
          :rules="[v => !!v || '必須項目です']"
          required
        />
        <v-text-field
          v-model="formData.email"
          label="メールアドレス"
          :rules="[
            v => !!v || '必須項目です',
            v => /.+@.+\..+/.test(v) || '有効なメールアドレスを入力してください'
          ]"
          required
        />
      </v-form>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn @click="cancel">キャンセル</v-btn>
      <v-btn 
        color="primary" 
        @click="submit"
        :disabled="!valid"
      >
        保存
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'

interface UserData {
  name: string
  email: string
}

interface Props {
  onClose: (result?: UserData) => void
  initialData?: Partial<UserData>
}

const props = defineProps<Props>()

const valid = ref(false)
const formData = reactive<UserData>({
  name: props.initialData?.name || '',
  email: props.initialData?.email || ''
})

const cancel = () => props.onClose()
const submit = () => {
  if (valid.value) {
    props.onClose(formData)
  }
}
</script>
```

```typescript
// 使用例
interface UserData {
  name: string
  email: string
}

const openUserForm = async () => {
  const { afterClosed } = dialog.open<{ initialData?: Partial<UserData> }, UserData>({
    component: UserFormDialog,
    props: {
      initialData: {
        name: '山田太郎'
      }
    },
    maxWidth: '500px'
  })

  const userData = await afterClosed()
  if (userData) {
    console.log('保存:', userData.name, userData.email)
    await saveUser(userData)
  }
}
```

Promise.then()スタイル
```vue
typescript// async/awaitを使わない場合
const showDialog = () => {
  const { afterClosed } = dialog.open({
    component: MyDialog
  })
  
  afterClosed().then(result => {
    if (result) {
      console.log('結果:', result)
    }
  })
}
```
