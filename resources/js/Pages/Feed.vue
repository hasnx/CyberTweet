<template>
    <CyberLayout :auth="auth">
        <div class="max-w-2xl">
            <!-- Post Creation -->
            <div
                class="mb-8 bg-gray-900 p-4 rounded-lg border border-neon-pink"
            >
                <form @submit.prevent="submitPost">
                    <div class="relative">
                        <textarea
                            v-model="newPost.content"
                            class="w-full bg-gray-800 text-neon-blue border-none rounded p-3 focus:ring-2 focus:ring-neon-pink"
                            placeholder="What's happening in Night City?"
                            rows="3"
                            maxlength="280"
                        ></textarea>
                        <div
                            class="absolute bottom-3 right-3 flex items-center space-x-2"
                        >
                            <div class="relative w-8 h-8">
                                <svg class="w-8 h-8 transform -rotate-90">
                                    <circle
                                        cx="16"
                                        cy="16"
                                        r="14"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        fill="none"
                                        class="text-gray-700"
                                    />
                                    <circle
                                        cx="16"
                                        cy="16"
                                        r="14"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        fill="none"
                                        :stroke-dasharray="circumference"
                                        :stroke-dashoffset="dashOffset"
                                        class="text-neon-pink transition-all duration-200"
                                    />
                                </svg>
                                <span
                                    class="absolute inset-0 flex items-center justify-center text-xs text-neon-pink"
                                >
                                    {{ 280 - newPost.content.length }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-2">
                        <button
                            type="submit"
                            class="bg-neon-pink hover:bg-neon-pink/80 text-black px-6 py-2 rounded-full font-bold transition-all duration-300 shadow-neon"
                        >
                            UPLOAD TO NETWORK
                        </button>
                    </div>
                </form>
            </div>

            <!-- Posts Feed -->
            <div class="space-y-4">
                <div
                    v-for="post in posts"
                    :key="post.id"
                    class="bg-gray-900 p-4 rounded-lg border border-neon-blue hover:border-neon-pink transition-all duration-300"
                >
                    <div class="flex items-start space-x-3">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <Link
                                    :href="route('profile.show', post.user.id)"
                                    class="font-bold text-neon-pink hover:text-neon-blue transition-all duration-300 relative group"
                                >
                                    {{ post.user.name }}
                                    <span
                                        class="absolute inset-0 bg-neon-pink/20 opacity-0 group-hover:opacity-100 blur transition-opacity"
                                    ></span>
                                </Link>
                                <span class="text-gray-500">{{
                                    formatDate(post.created_at)
                                }}</span>
                            </div>
                            <p class="mt-2 text-white">{{ post.content }}</p>
                            <div class="mt-4 flex space-x-6">
                                <button
                                    @click="likePost(post)"
                                    class="flex items-center space-x-2 hover-glitch"
                                    :class="{
                                        'text-neon-pink': post.liked,
                                        'text-gray-400 hover:text-neon-pink':
                                            !post.liked,
                                    }"
                                    :data-text="post.likes_count + ' Likes'"
                                >
                                    <component
                                        :is="
                                            post.liked
                                                ? HeartIcon
                                                : HeartOutlineIcon
                                        "
                                        class="w-5 h-5 icon-glitch"
                                    />
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
                                    <component
                                        :is="
                                            post.reposted
                                                ? ArrowPathIcon
                                                : ArrowPathOutlineIcon
                                        "
                                        class="w-5 h-5"
                                    />
                                    <span>{{ post.reposts_count }}</span>
                                    <span>Reposts</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </CyberLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm, router, Link } from "@inertiajs/vue3";
import CyberLayout from "@/Layouts/CyberLayout.vue";
import { HeartIcon, ArrowPathIcon } from "@heroicons/vue/24/solid";
import {
    HeartIcon as HeartOutlineIcon,
    ArrowPathIcon as ArrowPathOutlineIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    posts: {
        type: Array,
        required: true,
    },
    auth: {
        type: Object,
        required: true,
    },
});

const newPost = useForm({
    content: "",
});

const submitPost = () => {
    newPost.post(route("posts.store"), {
        onSuccess: () => {
            newPost.reset();
        },
    });
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

const formatDate = (date) => {
    return new Date(date).toLocaleDateString();
};

const circumference = computed(() => 2 * Math.PI * 14);
const dashOffset = computed(() => {
    const progress = newPost.content.length / 280;
    return circumference.value * (1 - progress);
});
</script>

<style>
.shadow-neon {
    box-shadow: 0 0 10px theme("colors.neon-pink");
}

@keyframes glitch {
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

.text-glitch {
    animation: glitch 1s infinite;
}

.icon-glitch {
    animation: iconGlitch 2s infinite;
}

@keyframes iconGlitch {
    0% {
        transform: translate(0);
        filter: none;
    }
    2% {
        transform: translate(-2px, 2px);
        filter: drop-shadow(2px 0 theme("colors.neon-pink"))
            drop-shadow(-2px 0 theme("colors.neon-blue"));
    }
    4% {
        transform: translate(0);
        filter: none;
    }
    96% {
        transform: translate(0);
        filter: none;
    }
    98% {
        transform: translate(2px, -2px);
        filter: drop-shadow(-2px 0 theme("colors.neon-pink"))
            drop-shadow(2px 0 theme("colors.neon-blue"));
    }
    100% {
        transform: translate(0);
        filter: none;
    }
}

.hover-glitch {
    position: relative;
}

.hover-glitch::before,
.hover-glitch::after {
    content: attr(data-text);
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    opacity: 0;
    transition: opacity 0.3s;
}

.hover-glitch::before {
    top: 2px;
    color: theme("colors.neon-pink");
    z-index: -1;
}

.hover-glitch::after {
    top: -2px;
    color: theme("colors.neon-blue");
    z-index: -2;
}

.hover-glitch:hover::before,
.hover-glitch:hover::after {
    opacity: 0.5;
}
</style>
