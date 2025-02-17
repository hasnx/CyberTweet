<template>
    <CyberLayout :auth="auth">
        <div class="max-w-2xl">
            <!-- Search Results -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-neon-pink mb-4">
                    Search Results for "{{ query }}"
                </h2>

                <!-- Users Section -->
                <div v-if="users.length > 0" class="mb-8">
                    <h3 class="text-lg font-bold text-neon-blue mb-4">
                        People
                    </h3>
                    <div class="space-y-4">
                        <div
                            v-for="user in users"
                            :key="user.id"
                            class="bg-gray-900 p-4 rounded-lg border border-neon-blue hover:border-neon-pink transition-all duration-300"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <img
                                        :src="user.profile_photo_url"
                                        :alt="user.name"
                                        class="w-12 h-12 rounded-full border border-neon-pink"
                                    />
                                    <div>
                                        <Link
                                            :href="
                                                route('profile.show', user.id)
                                            "
                                            class="font-bold text-neon-pink hover:text-neon-blue transition-all duration-300"
                                        >
                                            {{ user.name }}
                                        </Link>
                                        <p class="text-gray-400">
                                            @{{ user.email.split("@")[0] }}
                                        </p>
                                    </div>
                                </div>
                                <button
                                    @click="followUser(user)"
                                    class="px-4 py-1 rounded-full text-sm font-bold transition-all duration-300"
                                    :class="
                                        user.isFollowing
                                            ? 'bg-gray-800 text-neon-pink border border-neon-pink'
                                            : 'bg-neon-pink text-black'
                                    "
                                >
                                    {{
                                        user.isFollowing
                                            ? "DISCONNECT"
                                            : "CONNECT"
                                    }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Posts Section -->
                <div v-if="posts.length > 0">
                    <h3 class="text-lg font-bold text-neon-blue mb-4">Posts</h3>
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

                <!-- No Results -->
                <div
                    v-if="posts.length === 0 && users.length === 0"
                    class="bg-gray-900 p-6 rounded-lg border border-neon-pink text-center"
                >
                    <p class="text-neon-blue text-lg">
                        No results found in the network
                    </p>
                </div>
            </div>
        </div>
    </CyberLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import CyberLayout from "@/Layouts/CyberLayout.vue";
import PostItem from "@/Components/PostItem.vue";

const props = defineProps({
    query: String,
    posts: Array,
    users: Array,
    auth: Object,
});

const followUser = (user) => {
    if (user.isFollowing) {
        router.delete(route("profile.unfollow", user.id), {
            preserveScroll: true,
        });
    } else {
        router.post(
            route("profile.follow", user.id),
            {},
            {
                preserveScroll: true,
            }
        );
    }
};
</script>
