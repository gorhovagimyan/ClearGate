<template>
    <Link
        :href="href"
        :method="method"
        class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 transition-colors duration-200"
        :class="{ 'bg-gray-700': active }"
    >
        <div class="mr-3">
            <slot name="icon" />
        </div>
        <span><slot /></span>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
    href: {
        type: String,
        required: true
    },
    method: {
        type: String,
        default: 'get'
    }
})

const page = usePage()
const active = computed(() => page.url === props.href)
</script> 