<template>
    <!-- ... other content ... -->
    <p class="mt-2 text-white">
        <template v-for="(part, index) in formattedContent" :key="index">
            <Link
                v-if="part.type === 'hashtag'"
                :href="route('hashtag.show', part.value.substring(1))"
                class="text-neon-blue hover:text-neon-pink transition-colors"
            >
                {{ part.value }}
            </Link>
            <span v-else>{{ part.value }}</span>
        </template>
    </p>
    <!-- ... other content ... -->
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    post: Object,
});

const formattedContent = computed(() => {
    const parts = [];
    let lastIndex = 0;
    const regex = /#\w+/g;
    let match;

    while ((match = regex.exec(props.post.content)) !== null) {
        if (match.index > lastIndex) {
            parts.push({
                type: "text",
                value: props.post.content.substring(lastIndex, match.index),
            });
        }
        parts.push({
            type: "hashtag",
            value: match[0],
        });
        lastIndex = match.index + match[0].length;
    }

    if (lastIndex < props.post.content.length) {
        parts.push({
            type: "text",
            value: props.post.content.substring(lastIndex),
        });
    }

    return parts;
});
</script>
