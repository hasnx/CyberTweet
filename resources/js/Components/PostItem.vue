<template>
    <div
        class="bg-gray-900/95 rounded-lg border border-neon-blue/50 p-4 hover:border-neon-pink transition-all duration-300"
    >
        <div class="flex space-x-4">
            <!-- User Avatar -->
            <div class="relative flex-shrink-0">
                <img
                    :src="post.user.profile_photo_url"
                    :alt="post.user.name"
                    class="w-10 h-10 rounded-full border border-neon-pink"
                />
                <div
                    class="absolute inset-0 rounded-full glitch-effect opacity-0 group-hover:opacity-100"
                ></div>
            </div>

            <!-- Post Content -->
            <div class="flex-1 min-w-0">
                <!-- Post Header -->
                <div class="flex items-center space-x-2">
                    <Link
                        :href="
                            route('profile.show', {
                                username: post.user.username,
                            })
                        "
                        class="font-bold text-neon-pink hover:text-neon-blue transition-colors"
                    >
                        {{ post.user.name }}
                    </Link>
                    <span class="text-gray-500">·</span>
                    <span class="text-gray-400 text-sm">
                        {{ formatDate(post.created_at) }}
                    </span>
                </div>

                <!-- Post Text -->
                <p class="mt-2 text-white whitespace-pre-wrap">
                    {{ post.content }}
                </p>

                <!-- Post Actions -->
                <div class="mt-4 flex space-x-6">
                    <button
                        @click="$emit('like', post)"
                        class="flex items-center space-x-2 group"
                        :class="{
                            'text-neon-pink': post.liked,
                            'text-gray-400 hover:text-neon-pink': !post.liked,
                        }"
                    >
                        <HeartIcon
                            v-if="post.liked"
                            class="w-5 h-5 icon-glitch"
                        />
                        <HeartOutlineIcon
                            v-else
                            class="w-5 h-5 group-hover:scale-110 transition-transform"
                        />
                        <span>{{ post.likes_count }}</span>
                    </button>

                    <button
                        @click="$emit('repost', post)"
                        class="flex items-center space-x-2 group"
                        :class="{
                            'text-neon-blue': post.reposted,
                            'text-gray-400 hover:text-neon-blue':
                                !post.reposted,
                        }"
                    >
                        <ArrowPathIcon
                            v-if="post.reposted"
                            class="w-5 h-5 icon-glitch"
                        />
                        <ArrowPathOutlineIcon
                            v-else
                            class="w-5 h-5 group-hover:scale-110 transition-transform"
                        />
                        <span>{{ post.reposts_count }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { HeartIcon, ArrowPathIcon } from "@heroicons/vue/24/solid";
import {
    HeartIcon as HeartOutlineIcon,
    ArrowPathIcon as ArrowPathOutlineIcon,
} from "@heroicons/vue/24/outline";

defineProps({
    post: {
        type: Object,
        required: true,
    },
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
    });
};
</script>
