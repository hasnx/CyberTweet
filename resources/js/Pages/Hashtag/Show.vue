<template>
    <CyberLayout :auth="auth">
        <div class="max-w-2xl">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-neon-pink mb-2">
                    #{{ hashtag.name }}
                </h1>
                <p class="text-neon-blue">{{ hashtag.posts_count }} posts</p>
            </div>

            <div class="space-y-4">
                <PostItem
                    v-for="post in posts"
                    :key="post.id"
                    :post="post"
                    @like="likePost"
                    @repost="repostPost"
                />
            </div>
        </div>
    </CyberLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import CyberLayout from "@/Layouts/CyberLayout.vue";
import PostItem from "@/Components/PostItem.vue";

defineProps({
    hashtag: Object,
    posts: Array,
    auth: Object,
});
</script>
