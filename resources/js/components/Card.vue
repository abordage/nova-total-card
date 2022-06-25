<template>
    <card class="flex flex-col items-center justify-center">
        <p v-if="card.error !== null" class="font-semibold text-red-500 text-xs text-left px-6">{{ card.error }}</p>
        <h2 v-else class="text-90 text-xl md:text-2xl">
            <span class="font-semibold">{{ card.title }}:</span> {{ formattedTotal }}
        </h2>
    </card>
</template>

<script>
export default {
    props: {
        card: {
            type: Object,
            required: true,
        },
    },

    computed: {
        formattedTotal () {
            return this.card.total ? Number(this.card.total).toLocaleString() : this.card.total
        }
    },
}
</script>
