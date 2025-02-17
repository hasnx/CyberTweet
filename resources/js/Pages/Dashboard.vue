<script setup>
import { Head } from "@inertiajs/vue3";
import CyberLayout from "@/Layouts/CyberLayout.vue";
import PostItem from "@/Components/PostItem.vue";
import { ref, onMounted } from "vue";
import {
    ChartBarIcon,
    UsersIcon,
    HashtagIcon,
    ClockIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    auth: Object,
    stats: Object,
    recentPosts: Array,
    topHashtags: Array,
    recentFollowers: Array,
});

const activeTab = ref("overview");
</script>

<template>
    <Head title="Dashboard" />

    <CyberLayout :auth="auth">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Dashboard Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-neon-pink mb-2 glitch-text">
                    SYSTEM_STATUS
                </h1>
                <p class="text-gray-400">
                    Welcome back, {{ auth.user.name }}. Your neural link is
                    stable.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-gray-900/95 rounded-lg p-6 border border-neon-blue/50 hover:border-neon-pink transition-all duration-300"
                >
                    <div class="flex items-center">
                        <ChartBarIcon class="w-8 h-8 text-neon-pink mr-3" />
                        <div>
                            <p class="text-gray-400 text-sm">TOTAL POSTS</p>
                            <p class="text-2xl font-bold text-neon-pink">
                                {{ stats.totalPosts }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gray-900/95 rounded-lg p-6 border border-neon-blue/50 hover:border-neon-pink transition-all duration-300"
                >
                    <div class="flex items-center">
                        <UsersIcon class="w-8 h-8 text-neon-blue mr-3" />
                        <div>
                            <p class="text-gray-400 text-sm">FOLLOWERS</p>
                            <p class="text-2xl font-bold text-neon-blue">
                                {{ stats.followers }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gray-900/95 rounded-lg p-6 border border-neon-blue/50 hover:border-neon-pink transition-all duration-300"
                >
                    <div class="flex items-center">
                        <HashtagIcon class="w-8 h-8 text-neon-pink mr-3" />
                        <div>
                            <p class="text-gray-400 text-sm">TRENDING TAGS</p>
                            <p class="text-2xl font-bold text-neon-pink">
                                {{ stats.trendingTags }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gray-900/95 rounded-lg p-6 border border-neon-blue/50 hover:border-neon-pink transition-all duration-300"
                >
                    <div class="flex items-center">
                        <ClockIcon class="w-8 h-8 text-neon-blue mr-3" />
                        <div>
                            <p class="text-gray-400 text-sm">ONLINE TIME</p>
                            <p class="text-2xl font-bold text-neon-blue">
                                {{ stats.onlineTime }}h
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Tabs -->
            <div class="bg-gray-900/95 rounded-lg border border-neon-blue/50">
                <!-- Tab Navigation -->
                <div class="border-b border-neon-blue/50 px-4">
                    <nav class="flex space-x-8">
                        <button
                            v-for="tab in ['overview', 'activity', 'network']"
                            :key="tab"
                            @click="activeTab = tab"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-300"
                            :class="[
                                activeTab === tab
                                    ? 'border-neon-pink text-neon-pink'
                                    : 'border-transparent text-gray-400 hover:text-neon-blue hover:border-neon-blue',
                            ]"
                        >
                            {{ tab.toUpperCase() }}
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Overview Tab -->
                    <div
                        v-if="activeTab === 'overview'"
                        class="grid grid-cols-1 lg:grid-cols-2 gap-6"
                    >
                        <!-- Recent Posts -->
                        <div>
                            <h3 class="text-neon-pink font-bold mb-4">
                                RECENT POSTS
                            </h3>
                            <div class="space-y-4">
                                <PostItem
                                    v-for="post in recentPosts"
                                    :key="post.id"
                                    :post="post"
                                />
                            </div>
                        </div>

                        <!-- Top Hashtags -->
                        <div>
                            <h3 class="text-neon-blue font-bold mb-4">
                                TOP HASHTAGS
                            </h3>
                            <div class="space-y-3">
                                <div
                                    v-for="tag in topHashtags"
                                    :key="tag.name"
                                    class="bg-gray-800/50 p-4 rounded-lg border border-neon-blue/30 hover:border-neon-pink/50 transition-all duration-300"
                                >
                                    <div
                                        class="flex justify-between items-center"
                                    >
                                        <span class="text-neon-pink font-mono">
                                            #{{ tag.name }}
                                        </span>
                                        <span class="text-gray-400 text-sm">
                                            {{ tag.count }} posts
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Tab -->
                    <div v-if="activeTab === 'activity'" class="space-y-6">
                        <h3 class="text-neon-pink font-bold mb-4">
                            RECENT ACTIVITY
                        </h3>
                        <!-- Add activity feed here -->
                    </div>

                    <!-- Network Tab -->
                    <div v-if="activeTab === 'network'" class="space-y-6">
                        <h3 class="text-neon-blue font-bold mb-4">
                            RECENT FOLLOWERS
                        </h3>
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                        >
                            <div
                                v-for="follower in recentFollowers"
                                :key="follower.id"
                                class="bg-gray-800/50 p-4 rounded-lg border border-neon-blue/30 hover:border-neon-pink/50 transition-all duration-300"
                            >
                                <div class="flex items-center space-x-3">
                                    <img
                                        :src="follower.profile_photo_url"
                                        :alt="follower.name"
                                        class="w-10 h-10 rounded-full border border-neon-pink"
                                    />
                                    <div>
                                        <p class="font-bold text-neon-pink">
                                            {{ follower.name }}
                                        </p>
                                        <p class="text-sm text-gray-400">
                                            @{{ follower.username }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </CyberLayout>
</template>

<style scoped>
.glitch-text {
    text-shadow: 2px 2px theme("colors.neon-pink"),
        -2px -2px theme("colors.neon-blue");
}
</style>
