<script lang="ts">

import Search from "@/components/Api/Search.vue";
import Translate from "@/components/Api/Translate.vue";
import {computed, ComputedRef, ref} from "vue";
import {useRoute} from "vue-router";

export default {
    components: {Translate, Search},
    setup() {
        const route = useRoute();
        const hasQuery: ComputedRef<boolean> = computed((): boolean => !!route.query.q);

        return {
            hasQuery
        }
    }
}
</script>
<template>
    <Search v-if="hasQuery" />
    <Translate v-else />
</template>
