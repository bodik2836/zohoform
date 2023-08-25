<script setup>
import useDealStages from "../../../zoho/deals/deal_stages.js";
import {onMounted} from "vue";

export default {
    setup() {
        const { dealStages, getDealStages } = useDealStages();

        onMounted(getDealStages)

        return { dealStages }
    }
}
</script>

<template>

</template>

<style scoped>

</style>
