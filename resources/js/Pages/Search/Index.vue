<template>
    <CyberLayout :auth="auth">
        <div class="max-w-3xl mx-auto">
            <!-- Search Header -->
            <div
                class="mb-8 bg-gray-900 p-6 rounded-lg border border-neon-pink"
            >
                <h2 class="text-2xl font-bold text-neon-pink mb-2">
                    Search Results
                </h2>
                <p class="text-neon-blue">
                    Found {{ totalResults }} results for "{{ query }}"
                </p>
            </div>

            <!-- Tabs with Loading State -->
            <div class="mb-6 border-b border-gray-800">
                <div class="flex space-x-8">
                    <button
                        v-for="tab in tabs"
                        :key="tab.id"
                        @click="activeTab = tab.id"
                        class="pb-4 px-2 relative transition-all duration-300"
                        :class="{
                            'text-neon-pink': activeTab === tab.id,
                            'text-gray-400 hover:text-neon-blue':
                                activeTab !== tab.id,
                            'opacity-50 cursor-wait': isLoading,
                        }"
                        :disabled="isLoading"
                    >
                        <span class="font-bold">{{ tab.name }}</span>
                        <span class="ml-2 text-sm">{{ tab.count }}</span>
                        <div
                            v-if="activeTab === tab.id"
                            class="absolute bottom-0 left-0 right-0 h-0.5 bg-neon-pink shadow-glow"
                        ></div>
                    </button>
                </div>
            </div>

            <!-- Loading Indicator -->
            <div v-if="isLoading" class="flex justify-center py-12">
                <div
                    class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-neon-pink"
                ></div>
            </div>

            <!-- Content -->
            <div v-else>
                <!-- Users Results -->
                <div v-show="activeTab === 'people'" class="space-y-4">
                    <div
                        v-if="users.length === 0"
                        class="text-gray-400 text-center py-8"
                    >
                        No users found matching "{{ query }}"
                    </div>
                    <div
                        v-for="user in users"
                        :key="user.id"
                        class="bg-gray-900 p-4 rounded-lg border border-neon-blue hover:border-neon-pink transition-all duration-300"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <img
                                        :src="user.profile_photo_url"
                                        :alt="user.name"
                                        class="w-12 h-12 rounded-full border-2 border-neon-pink"
                                    />
                                    <div
                                        class="absolute inset-0 rounded-full glitch-effect"
                                    ></div>
                                </div>
                                <div>
                                    <Link
                                        :href="route('profile.show', user.id)"
                                        class="font-bold text-neon-pink hover:text-neon-blue transition-all duration-300 text-lg"
                                    >
                                        {{ user.name }}
                                    </Link>
                                    <p class="text-gray-400">
                                        @{{ user.email.split("@")[0] }}
                                    </p>
                                </div>
                            </div>
                            <button
                                v-if="user.id !== auth.user.id"
                                @click="followUser(user)"
                                class="px-6 py-2 rounded-full text-sm font-bold transition-all duration-300"
                                :class="
                                    user.isFollowing
                                        ? 'bg-gray-800 text-neon-pink border border-neon-pink'
                                        : 'bg-neon-pink text-black'
                                "
                            >
                                {{
                                    user.isFollowing ? "DISCONNECT" : "CONNECT"
                                }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Posts Results -->
                <div v-show="activeTab === 'posts'" class="space-y-4">
                    <div
                        v-if="posts.length === 0"
                        class="text-gray-400 text-center py-8"
                    >
                        No posts found matching "{{ query }}"
                    </div>
                    <div
                        v-for="post in posts"
                        :key="post.id"
                        class="bg-gray-900 p-6 rounded-lg border border-neon-blue hover:border-neon-pink transition-all duration-300"
                    >
                        <div class="flex items-start space-x-4">
                            <div class="relative flex-shrink-0">
                                <img
                                    :src="post.user.profile_photo_url"
                                    :alt="post.user.name"
                                    class="w-10 h-10 rounded-full border border-neon-pink"
                                />
                                <div
                                    class="absolute inset-0 rounded-full glitch-effect"
                                ></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <Link
                                        :href="
                                            route('profile.show', post.user.id)
                                        "
                                        class="font-bold text-neon-pink hover:text-neon-blue transition-all duration-300"
                                    >
                                        {{ post.user.name }}
                                    </Link>
                                    <span class="text-gray-500">·</span>
                                    <span class="text-gray-400 text-sm">{{
                                        formatDate(post.created_at)
                                    }}</span>
                                </div>
                                <p class="mt-2 text-white whitespace-pre-wrap">
                                    <HighlightedText
                                        :text="post.content"
                                        :query="query"
                                    />
                                </p>
                                <div class="mt-4 flex space-x-6">
                                    <button
                                        @click="likePost(post)"
                                        class="flex items-center space-x-2 group"
                                        :class="{
                                            'text-neon-pink': post.liked,
                                            'text-gray-400 hover:text-neon-pink':
                                                !post.liked,
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
                                        @click="repostPost(post)"
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
                </div>
            </div>

            <!-- No Results -->
            <div
                v-if="!isLoading && totalResults === 0"
                class="bg-gray-900 p-8 rounded-lg border border-neon-pink text-center"
            >
                <p class="text-neon-blue text-lg mb-2">
                    No results found in the network
                </p>
                <p class="text-gray-400">
                    Try different keywords or check your spelling
                </p>
            </div>
        </div>
    </CyberLayout>
</template>

<script setup>
import { ref, computed, h } from "vue";
import { Link, router } from "@inertiajs/vue3";
import CyberLayout from "@/Layouts/CyberLayout.vue";
import { HeartIcon, ArrowPathIcon } from "@heroicons/vue/24/solid";
import {
    HeartIcon as HeartOutlineIcon,
    ArrowPathIcon as ArrowPathOutlineIcon,
} from "@heroicons/vue/24/outline";

const isLoading = ref(false);
const activeTab = ref("people");

const props = defineProps({
    query: String,
    posts: {
        type: Array,
        default: () => [],
    },
    users: {
        type: Array,
        default: () => [],
    },
    auth: Object,
});

const tabs = computed(() => [
    { id: "people", name: "People", count: props.users.length },
    { id: "posts", name: "Posts", count: props.posts.length },
]);

const totalResults = computed(() => props.users.length + props.posts.length);

const formatDate = (date) => {
    return new Date(date).toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
    });
};

const followUser = async (user) => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        if (user.isFollowing) {
            await router.delete(route("profile.unfollow", user.id), {
                preserveScroll: true,
            });
        } else {
            await router.post(
                route("profile.follow", user.id),
                {},
                {
                    preserveScroll: true,
                }
            );
        }
    } catch (error) {
        console.error("Error toggling follow:", error);
    } finally {
        isLoading.value = false;
    }
};

const likePost = async (post) => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        if (post.liked) {
            await router.delete(route("posts.unlike", post.id), {
                preserveScroll: true,
            });
        } else {
            await router.post(
                route("posts.like", post.id),
                {},
                {
                    preserveScroll: true,
                }
            );
        }
    } catch (error) {
        console.error("Error toggling like:", error);
    } finally {
        isLoading.value = false;
    }
};

const repostPost = async (post) => {
    if (isLoading.value) return;
    isLoading.value = true;

    try {
        if (post.reposted) {
            await router.delete(route("posts.unrepost", post.id), {
                preserveScroll: true,
            });
        } else {
            await router.post(
                route("posts.repost", post.id),
                {},
                {
                    preserveScroll: true,
                }
            );
        }
    } catch (error) {
        console.error("Error toggling repost:", error);
    } finally {
        isLoading.value = false;
    }
};

// Move HighlightedText component into setup
const HighlightedText = {
    props: {
        text: String,
        query: String,
    },
    setup(props) {
        return () => {
            if (!props.query) return props.text;

            const parts = props.text.split(
                new RegExp(`(${props.query})`, "gi")
            );
            return h(
                "span",
                {},
                parts.map((part) =>
                    part.toLowerCase() === props.query.toLowerCase()
                        ? h(
                              "span",
                              { class: "bg-neon-pink/20 text-neon-pink" },
                              part
                          )
                        : part
                )
            );
        };
    },
};
</script>

<style scoped>
.shadow-glow {
    box-shadow: 0 0 10px theme("colors.neon-pink");
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
</style>
