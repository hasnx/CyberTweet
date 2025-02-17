<template>
    <div class="min-h-screen bg-black">
        <CyberNav :auth="auth" />
        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Profile Header -->
            <div
                class="bg-gray-900 p-6 rounded-lg border border-neon-pink mb-8"
            >
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <img
                            :src="user.profile_photo_url"
                            :alt="user.name"
                            class="w-24 h-24 rounded-full border-2 border-neon-pink shadow-neon"
                        />
                        <div
                            class="absolute inset-0 rounded-full glitch-effect"
                        ></div>
                    </div>
                    <div class="flex-1">
                        <h1
                            class="text-2xl font-bold text-neon-pink text-glitch"
                        >
                            {{ user.name }}
                        </h1>
                        <p class="text-gray-400">
                            @{{ user.email.split("@")[0] }}
                        </p>
                        <div class="flex space-x-6 mt-4">
                            <div class="text-center">
                                <span
                                    class="block text-xl font-bold text-neon-blue"
                                    >{{ stats.posts_count }}</span
                                >
                                <span class="text-gray-400">Posts</span>
                            </div>
                            <div class="text-center">
                                <span
                                    class="block text-xl font-bold text-neon-blue"
                                    >{{ stats.followers_count }}</span
                                >
                                <span class="text-gray-400">Followers</span>
                            </div>
                            <div class="text-center">
                                <span
                                    class="block text-xl font-bold text-neon-blue"
                                    >{{ stats.following_count }}</span
                                >
                                <span class="text-gray-400">Following</span>
                            </div>
                        </div>
                    </div>
                    <div v-if="user.id !== auth.user.id" class="ml-auto">
                        <button
                            @click="toggleFollow"
                            class="px-6 py-2 rounded-full font-bold transition-all duration-300 shadow-neon"
                            :class="{
                                'bg-neon-pink text-black hover:bg-neon-pink/80':
                                    !isFollowing,
                                'bg-gray-800 text-neon-pink border border-neon-pink hover:bg-gray-700':
                                    isFollowing,
                            }"
                        >
                            {{ isFollowing ? "DISCONNECT" : "CONNECT" }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- User Posts -->
            <div class="space-y-4">
                <div
                    v-for="post in posts"
                    :key="post.id"
                    class="bg-gray-900 p-4 rounded-lg border border-neon-blue hover:border-neon-pink transition-all duration-300"
                >
                    <div class="flex items-start space-x-3">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-500">{{
                                    formatDate(post.created_at)
                                }}</span>
                            </div>
                            <p class="mt-2 text-white">{{ post.content }}</p>
                            <div class="mt-4 flex space-x-6">
                                <button
                                    @click="likePost(post)"
                                    class="flex items-center space-x-2"
                                    :class="{
                                        'text-neon-pink': post.liked,
                                        'text-gray-400 hover:text-neon-pink':
                                            !post.liked,
                                    }"
                                >
                                    <span>{{ post.likes_count }}</span>
                                    <span>Likes</span>
                                </button>
                                <button
                                    @click="repostPost(post)"
                                    class="flex items-center space-x-2"
                                    :class="{
                                        'text-neon-blue': post.reposted,
                                        'text-gray-400 hover:text-neon-blue':
                                            !post.reposted,
                                    }"
                                >
                                    <span>{{ post.reposts_count }}</span>
                                    <span>Reposts</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm, router, Link } from "@inertiajs/vue3";
import CyberNav from "@/Components/CyberNav.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    posts: {
        type: Array,
        required: true,
    },
    stats: {
        type: Object,
        required: true,
    },
    isFollowing: {
        type: Boolean,
        required: true,
    },
    auth: {
        type: Object,
        required: true,
    },
});

const toggleFollow = () => {
    if (props.isFollowing) {
        router.delete(route("profile.unfollow", props.user.id), {
            preserveScroll: true,
        });
    } else {
        router.post(
            route("profile.follow", props.user.id),
            {},
            {
                preserveScroll: true,
            }
        );
    }
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString();
};

const likePost = (post) => {
    if (post.liked) {
        router.delete(route("posts.unlike", post.id), {
            preserveScroll: true,
        });
    } else {
        router.post(
            route("posts.like", post.id),
            {},
            {
                preserveScroll: true,
            }
        );
    }
};

const repostPost = (post) => {
    if (post.reposted) {
        router.delete(route("posts.unrepost", post.id), {
            preserveScroll: true,
        });
    } else {
        router.post(
            route("posts.repost", post.id),
            {},
            {
                preserveScroll: true,
            }
        );
    }
};
</script>

<style scoped>
.shadow-neon {
    box-shadow: 0 0 15px theme("colors.neon-pink");
}

.glitch-effect {
    animation: glitch 2s infinite;
    background: rgba(255, 0, 60, 0.2);
    mix-blend-mode: overlay;
}

@keyframes glitch {
    0% {
        transform: translate(0);
    }
    20% {
        transform: translate(-2px, 2px);
    }
    40% {
        transform: translate(-2px, -2px);
    }
    60% {
        transform: translate(2px, 2px);
    }
    80% {
        transform: translate(2px, -2px);
    }
    100% {
        transform: translate(0);
    }
}

.text-glitch {
    position: relative;
    animation: textGlitch 3s infinite;
}

@keyframes textGlitch {
    0% {
        text-shadow: 0.05em 0 0 theme("colors.neon-pink"),
            -0.05em -0.025em 0 theme("colors.neon-blue");
    }
    14% {
        text-shadow: 0.05em 0 0 theme("colors.neon-pink"),
            -0.05em -0.025em 0 theme("colors.neon-blue");
    }
    15% {
        text-shadow: -0.05em -0.025em 0 theme("colors.neon-pink"),
            0.025em 0.025em 0 theme("colors.neon-blue");
    }
    49% {
        text-shadow: -0.05em -0.025em 0 theme("colors.neon-pink"),
            0.025em 0.025em 0 theme("colors.neon-blue");
    }
    50% {
        text-shadow: 0.025em 0.05em 0 theme("colors.neon-pink"),
            0.05em 0 0 theme("colors.neon-blue");
    }
    99% {
        text-shadow: 0.025em 0.05em 0 theme("colors.neon-pink"),
            0.05em 0 0 theme("colors.neon-blue");
    }
    100% {
        text-shadow: -0.025em 0 0 theme("colors.neon-pink"),
            -0.025em -0.025em 0 theme("colors.neon-blue");
    }
}
</style>
