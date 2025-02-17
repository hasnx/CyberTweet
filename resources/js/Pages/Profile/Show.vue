<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.vue";
import LogoutOtherBrowserSessionsForm from "@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import TwoFactorAuthenticationForm from "@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import { ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import CyberLayout from "@/Layouts/CyberLayout.vue";
import PostItem from "@/Components/PostItem.vue";

const props = defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
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
    likedPosts: Array,
});

const toggleFollow = () => {
    if (props.user.isFollowing) {
        router.delete(route("profile.unfollow", props.user.username), {
            preserveScroll: true,
        });
    } else {
        router.post(
            route("profile.follow", props.user.username),
            {},
            {
                preserveScroll: true,
            }
        );
    }
};

const activeTab = ref("posts");

const tabs = [
    { id: "posts", name: "POSTS" },
    { id: "likes", name: "LIKES" },
];

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

<template>
    <CyberLayout :auth="auth">
        <div class="max-w-2xl">
            <!-- Profile Header -->
            <div
                class="bg-gray-900/95 rounded-lg border border-neon-blue/50 p-6 mb-8"
            >
                <div class="flex items-start space-x-4">
                    <!-- Profile Image -->
                    <div class="relative">
                        <img
                            :src="user.profile_photo_url"
                            :alt="user.name"
                            class="w-24 h-24 rounded-full border-2 border-neon-pink"
                        />
                        <div
                            class="absolute inset-0 rounded-full glitch-effect"
                        ></div>
                    </div>

                    <!-- Profile Info -->
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-neon-pink mb-1">
                            {{ user.name }}
                        </h1>
                        <p class="text-gray-400 font-mono mb-4">
                            @{{ user.email.split("@")[0] }}
                        </p>

                        <!-- Stats -->
                        <div class="flex space-x-6">
                            <div class="text-center">
                                <p class="text-neon-pink font-bold">
                                    {{ stats.posts }}
                                </p>
                                <p class="text-xs text-gray-400 tracking-wider">
                                    POSTS
                                </p>
                            </div>
                            <div class="text-center">
                                <p class="text-neon-blue font-bold">
                                    {{ stats.following }}
                                </p>
                                <p class="text-xs text-gray-400 tracking-wider">
                                    FOLLOWING
                                </p>
                            </div>
                            <div class="text-center">
                                <p class="text-neon-pink font-bold">
                                    {{ stats.followers }}
                                </p>
                                <p class="text-xs text-gray-400 tracking-wider">
                                    FOLLOWERS
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Follow Button (if not current user) -->
                    <div v-if="user.id !== auth.user.id">
                        <button
                            @click="toggleFollow"
                            class="px-6 py-2 rounded-full text-sm font-bold transition-all duration-300"
                            :class="
                                user.isFollowing
                                    ? 'bg-gray-800 text-neon-pink border border-neon-pink'
                                    : 'bg-neon-pink text-black'
                            "
                        >
                            {{ user.isFollowing ? "DISCONNECT" : "CONNECT" }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Profile Tabs -->
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
                        }"
                    >
                        <span class="font-bold">{{ tab.name }}</span>
                        <div
                            v-if="activeTab === tab.id"
                            class="absolute bottom-0 left-0 right-0 h-0.5 bg-neon-pink shadow-glow"
                        ></div>
                    </button>
                </div>
            </div>

            <!-- Posts -->
            <div v-show="activeTab === 'posts'" class="space-y-4">
                <PostItem
                    v-for="post in posts"
                    :key="post.id"
                    :post="post"
                    @like="likePost"
                    @repost="repostPost"
                />
            </div>

            <!-- Likes -->
            <div v-show="activeTab === 'likes'" class="space-y-4">
                <PostItem
                    v-for="post in likedPosts"
                    :key="post.id"
                    :post="post"
                    @like="likePost"
                    @repost="repostPost"
                />
            </div>
        </div>
    </CyberLayout>
</template>
