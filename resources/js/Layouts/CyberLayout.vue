<template>
    <div class="min-h-screen bg-black">
        <div class="max-w-7xl mx-auto">
            <div class="flex">
                <!-- Sidebar -->
                <div
                    class="w-64 fixed h-screen bg-gray-900 border-r border-neon-pink"
                >
                    <div class="flex flex-col h-full p-4">
                        <!-- Logo -->
                        <Link
                            :href="route('feed')"
                            class="flex items-center px-4 py-3 text-neon-blue hover:text-neon-pink transition-all duration-300 text-xl font-bold"
                        >
                            <RssIcon class="w-8 h-8 mr-2 icon-glitch" />
                            NETFEED
                        </Link>

                        <!-- Navigation -->
                        <nav class="mt-8 space-y-4">
                            <Link
                                :href="route('feed')"
                                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group hover:bg-gray-800"
                                :class="{
                                    'bg-gray-800 text-neon-pink':
                                        route().current('feed'),
                                }"
                            >
                                <HomeIcon class="w-6 h-6 mr-4 icon-glitch" />
                                <span class="text-lg">Home</span>
                                <div
                                    class="absolute inset-0 bg-neon-pink/20 opacity-0 group-hover:opacity-100 blur transition-opacity rounded-lg"
                                ></div>
                            </Link>

                            <Link
                                :href="route('profile.show', auth.user.id)"
                                class="flex items-center px-4 py-3 rounded-lg transition-all duration-300 group hover:bg-gray-800"
                                :class="{
                                    'bg-gray-800 text-neon-pink':
                                        route().current(
                                            'profile.show',
                                            auth.user.id
                                        ),
                                }"
                            >
                                <UserIcon class="w-6 h-6 mr-4 icon-glitch" />
                                <span class="text-lg">Profile</span>
                                <div
                                    class="absolute inset-0 bg-neon-pink/20 opacity-0 group-hover:opacity-100 blur transition-opacity rounded-lg"
                                ></div>
                            </Link>
                        </nav>

                        <!-- Post Button -->
                        <button
                            @click="showPostModal = true"
                            class="mt-6 w-full bg-neon-pink hover:bg-neon-pink/80 text-black px-6 py-3 rounded-full font-bold transition-all duration-300 shadow-neon text-lg"
                        >
                            CREATE POST
                        </button>

                        <!-- User Profile Section -->
                        <div class="mt-auto">
                            <div
                                class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-800 transition-all duration-300 group"
                            >
                                <img
                                    :src="auth.user.profile_photo_url"
                                    :alt="auth.user.name"
                                    class="w-10 h-10 rounded-full border-2 border-neon-pink"
                                />
                                <div class="ml-3 flex-1">
                                    <p class="font-bold text-neon-blue">
                                        {{ auth.user.name }}
                                    </p>
                                    <p class="text-gray-400 text-sm">
                                        @{{ auth.user.email.split("@")[0] }}
                                    </p>
                                </div>
                                <button
                                    @click="logout"
                                    class="p-2 text-neon-blue hover:text-neon-pink transition-all duration-300"
                                >
                                    <PowerIcon class="w-5 h-5 icon-glitch" />
                                </button>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <div class="mt-6">
                            <SearchBar />
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1 ml-64">
                    <main class="p-6">
                        <slot />
                    </main>
                </div>
            </div>
        </div>

        <!-- Post Modal -->
        <TransitionRoot appear :show="showPostModal" as="template">
            <Dialog
                as="div"
                @close="showPostModal = false"
                class="relative z-50"
            >
                <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" />

                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center p-4"
                    >
                        <DialogPanel
                            class="w-full max-w-xl bg-gray-900 border border-neon-pink rounded-lg p-6"
                        >
                            <CreatePost @posted="showPostModal = false" />
                        </DialogPanel>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { Dialog, DialogPanel, TransitionRoot } from "@headlessui/vue";
import {
    RssIcon,
    HomeIcon,
    UserIcon,
    PowerIcon,
} from "@heroicons/vue/24/solid";
import CreatePost from "@/Components/CreatePost.vue";
import SearchBar from "@/Components/SearchBar.vue";

defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

const showPostModal = ref(false);

const logout = () => {
    router.post(route("logout"));
};
</script>
