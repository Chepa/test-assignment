<script lang="ts">
import {ref} from "vue";
import api from "@/use/api";
import {useRoute} from "vue-router";

export interface SearchResponse {
    status: string,
    message?: string,
    result?: {
        word: string,
        examples: string[]
    }
}

export default {
    setup() {
        const route = useRoute();
        const error = ref<string>('');
        const translation = ref<string>('');
        const examples = ref<string[]>([]);

        const search = async (): Promise<void> => {
            error.value = '';
            try {
                const response = await api.post<SearchResponse>('/api/search', {q: route.query.q});

                if (response.data) {
                    const data = response.data;


                    if (data.status == 'success' && data.result) {
                        translation.value = data.result.word;
                        examples.value = data.result.examples;
                    } else if (data.message) {
                        error.value = data.message;
                    }
                }
            } catch (e: any) {
                error.value = e.message;
            }
        }
        search();

        return {
            translation,
            error,
            examples
        }
    }
}
</script>
<template>
    <div v-if="error" class="alert alert-danger" role="alert">{{ error }}</div>
    <div v-if="translation" class="card">
        <div class="card-body">
            <p><strong>{{ translation }}</strong></p>
            <ul class="list-group">
                <li :key="`example-${i}`" v-for="(example, i) in examples" class="list-group-item">{{ example }}</li>
            </ul>
        </div>
    </div>
</template>
