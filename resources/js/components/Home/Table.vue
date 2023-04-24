<script lang="ts">
import api from "@/use/api";
import { ref } from 'vue';
import { Word } from "@/models/Word";

declare const window: Window &
    typeof globalThis & {
    languages: string[]
}
export interface Row {
    theme: string,
    words: Word[]
}

export interface FetchResponse {
    data: Row[]
}

export default {
    inject: ['languages'],
    setup() {
        const languages = ref<string[]>([]);
        const themes = ref<Row[]|[]>([]);
        const fetch = async (): Promise<void> => {
            try {
                const response = await api.get<FetchResponse>(`/dictionary/`);
                themes.value = response.data.data;
            } catch (e) {
                console.log(e);
            }
        }
        fetch();

        languages.value = window.languages;

        return {
            themes,
            languages
        }
    }
}
</script>
<template>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col" :key="`th-${i}`" v-for="(lang, i) in languages">{{ lang }}</th>
            </tr>
        </thead>
        <tbody>
            <tr :key="`tr-${i}`" v-for="(theme, i) in themes">
                <th scope="row">{{ theme.theme }}</th>
                <td :key="`td-${i}`" v-for="(word, i) in theme.words">{{ word.word }}</td>
            </tr>
        </tbody>
    </table>
</template>
