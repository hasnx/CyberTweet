<template>
    <div
        class="w-80 h-screen bg-gray-900/95 backdrop-blur-sm border-r border-neon-blue/50 fixed left-0 top-0 overflow-y-auto scrollbar-cyberpunk"
    >
        <!-- Logo Section -->
        <div class="p-6 border-b border-neon-blue/50 bg-gray-900/80">
            <h1
                class="text-3xl font-black text-neon-pink glitch-text tracking-wider"
            >
                CyberTweet
            </h1>
            <p class="text-neon-blue text-sm tracking-widest">
                NETWORK_<span class="animate-pulse">2077</span>
            </p>
        </div>

        <!-- User Stats Card -->
        <div
            class="p-4 mx-4 my-4 bg-gray-800/50 rounded-lg border border-neon-pink/50 backdrop-blur-sm hover:border-neon-pink transition-all duration-300"
        >
            <div class="flex items-center space-x-3 mb-4">
                <div class="relative group">
                    <img
                        :src="auth.user.profile_photo_url"
                        :alt="auth.user.name"
                        class="w-12 h-12 rounded-full border-2 border-neon-pink transform transition-all duration-300 group-hover:scale-105"
                    />
                    <div
                        class="absolute inset-0 rounded-full glitch-effect opacity-0 group-hover:opacity-100"
                    ></div>
                </div>
                <div class="min-w-0 flex-1">
                    <Link
                        :href="
                            route('profile.show', {
                                username: auth.user.username,
                            })
                        "
                        class="font-bold text-neon-pink tracking-wide truncate hover:text-neon-blue transition-colors"
                    >
                        {{ auth.user.name }}
                    </Link>
                    <p class="text-sm text-gray-400 font-mono truncate">
                        @{{ auth.user.username }}
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div
                    class="p-2 bg-gray-900/50 rounded hover:bg-gray-900 transition-all duration-300"
                >
                    <p class="text-neon-pink font-bold text-sm">
                        {{ stats.posts }}
                    </p>
                    <p class="text-xs text-gray-400 tracking-wider truncate">
                        POSTS
                    </p>
                </div>
                <div
                    class="p-2 bg-gray-900/50 rounded hover:bg-gray-900 transition-all duration-300"
                >
                    <p class="text-neon-blue font-bold text-sm">
                        {{ stats.following }}
                    </p>
                    <p class="text-xs text-gray-400 tracking-wider truncate">
                        FOLLOWING
                    </p>
                </div>
                <div
                    class="p-2 bg-gray-900/50 rounded hover:bg-gray-900 transition-all duration-300"
                >
                    <p class="text-neon-pink font-bold text-sm">
                        {{ stats.followers }}
                    </p>
                    <p class="text-xs text-gray-400 tracking-wider truncate">
                        FOLLOWERS
                    </p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="px-4 py-2">
            <Link
                v-for="item in navigation"
                :key="item.name"
                :href="item.href"
                class="group flex items-center px-4 py-3 mb-2 rounded-lg border transition-all duration-300 hover:bg-gray-800/50 backdrop-blur-sm"
                :class="[
                    item.current
                        ? 'bg-gray-800/80 text-neon-pink border-neon-pink shadow-glow-sm'
                        : 'text-gray-400 border-transparent hover:text-neon-blue hover:border-neon-blue/50',
                ]"
            >
                <component
                    :is="item.icon"
                    class="mr-3 h-5 w-5 transition-all duration-300"
                    :class="[
                        item.current
                            ? 'text-neon-pink'
                            : 'text-gray-400 group-hover:text-neon-blue',
                    ]"
                />
                <span class="font-medium tracking-wide">{{ item.name }}</span>
                <div v-if="item.badge" class="ml-auto">
                    <span
                        class="px-2 py-1 text-xs rounded-full bg-neon-pink text-black font-bold"
                    >
                        {{ item.badge }}
                    </span>
                </div>
            </Link>
        </nav>

        <!-- Trending Topics -->
        <div class="p-4">
            <h3
                class="text-neon-blue font-bold mb-4 px-4 tracking-wider flex items-center"
            >
                <ChartBarIcon class="w-4 h-4 mr-2" />
                TRENDING_NOW
            </h3>
            <div class="space-y-3">
                <Link
                    v-for="topic in trendingTopics"
                    :key="topic.tag"
                    :href="route('hashtag.show', topic.tag.substring(1))"
                    class="block p-3 bg-gray-800/50 rounded-lg hover:bg-gray-800 transition-all duration-300 border border-transparent hover:border-neon-blue/50 group"
                >
                    <p
                        class="text-neon-pink font-bold group-hover:text-neon-blue transition-colors"
                    >
                        {{ topic.tag }}
                    </p>
                    <p class="text-sm text-gray-400">
                        {{ topic.count.toLocaleString() }} posts
                    </p>
                </Link>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="p-4 border-t border-neon-blue/50 mt-4 bg-gray-900/80">
            <button
                @click="scrollToCreatePost"
                class="w-full bg-neon-pink hover:bg-neon-pink/90 text-black px-6 py-3 rounded-lg font-bold transition-all duration-300 shadow-neon mb-4 tracking-wider flex items-center justify-center space-x-2"
            >
                <PencilSquareIcon class="w-5 h-5" />
                <span>CREATE POST</span>
            </button>
            <button
                @click="logout"
                class="w-full bg-gray-800/50 text-neon-pink border border-neon-pink/50 px-6 py-3 rounded-lg font-bold hover:bg-neon-pink hover:text-black transition-all duration-300 tracking-wider flex items-center justify-center space-x-2"
            >
                <PowerIcon class="w-5 h-5" />
                <span>DISCONNECT</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link, router } from "@inertiajs/vue3";
import {
    HomeIcon,
    UserIcon,
    HashtagIcon,
    BellIcon,
    EnvelopeIcon,
    BookmarkIcon,
    ChartBarIcon,
    PencilSquareIcon,
    PowerIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    auth: {
        type: Object,
        required: true,
        validator: (value) => {
            return value && value.user;
        },
    },
    currentRoute: String,
});

const emit = defineEmits(["show-post-modal"]);

// Mock stats - replace with real data
const stats = computed(() => ({
    posts: 42,
    following: 128,
    followers: 256,
}));

const navigation = computed(() => [
    {
        name: "FEED",
        href: route("feed"),
        icon: HomeIcon,
        current: props.currentRoute === "feed",
    },
    {
        name: "PROFILE",
        href: route("profile.show", { username: props.auth.user.username }),
        icon: UserIcon,
        current: props.currentRoute === "profile.show",
    },
    {
        name: "EXPLORE",
        href: route("hashtag.show", "cyberpunk"),
        icon: HashtagIcon,
        current: props.currentRoute === "hashtag.show",
    },
    {
        name: "NOTIFICATIONS",
        href: "#",
        icon: BellIcon,
        current: false,
        badge: "3",
    },
    {
        name: "MESSAGES",
        href: "#",
        icon: EnvelopeIcon,
        current: false,
        badge: "5",
    },
    { name: "BOOKMARKS", href: "#", icon: BookmarkIcon, current: false },
    { name: "ANALYTICS", href: "#", icon: ChartBarIcon, current: false },
]);

// Mock trending topics - replace with real data
const trendingTopics = computed(() => [
    { tag: "#cyberpunk", count: 1337 },
    { tag: "#netrunner", count: 420 },
    { tag: "#chrome", count: 255 },
]);

const scrollToCreatePost = () => {
    // Scroll to top where the create post form is
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
};

const logout = () => {
    router.post(route("logout"));
};
</script>

<style scoped>
.shadow-neon {
    box-shadow: 0 0 15px theme("colors.neon-pink");
}

.shadow-glow-sm {
    box-shadow: 0 0 5px theme("colors.neon-pink");
}

.glitch-text {
    text-shadow: 2px 2px theme("colors.neon-pink"),
        -2px -2px theme("colors.neon-blue");
}

.glitch-effect {
    animation: glitch 2s infinite;
    background: rgba(255, 0, 60, 0.2);
    mix-blend-mode: overlay;
}

.scrollbar-cyberpunk {
    scrollbar-width: thin;
    scrollbar-color: theme("colors.neon-pink") theme("colors.gray.900");
}

.scrollbar-cyberpunk::-webkit-scrollbar {
    width: 6px;
}

.scrollbar-cyberpunk::-webkit-scrollbar-track {
    background: theme("colors.gray.900");
}

.scrollbar-cyberpunk::-webkit-scrollbar-thumb {
    background-color: theme("colors.neon-pink");
    border-radius: 3px;
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
