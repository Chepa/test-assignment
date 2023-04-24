<script lang="ts">
import {ref} from "vue";
import api from "@/use/api";

export interface TranslateResponse {
    status: string,
    result?: string
    message?: string,
}

export default {
    setup() {
        const input = ref<string>('');
        const translation = ref<string>('');
        const error = ref<string>('');

        const translate = async (): Promise<void> => {
            error.value = '';
            translation.value = '';

            try {
                const response = await api.post<TranslateResponse>('/api/translate', {word: input.value});
                console.log(response.data);

                if (response.data) {
                    const data = response.data;

                    if (data.status == 'success' && data.result) {
                        translation.value = data.result;
                    } else if (data.message) {
                        error.value = data.message;
                    }
                }
            } catch (e: any) {
                console.log(e);
                error.value = e.message;
            }
        }

        return {
            error,
            input,
            translation,
            translate
        }
    }
}
</script>
<template>
    <div v-if="error" class="alert alert-danger" role="alert">{{ error }}</div>
    <div v-if="translation" class="card my-4">
        <div class="card-body">
            {{ translation }}
        </div>
    </div>
    <form>
        <div class="mb-3">
            <input v-model="input" type="text" class="form-control">
        </div>
        <button @click="translate" type="button" class="btn btn-primary">Submit</button>
    </form>
</template>
