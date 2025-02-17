<template>
    <nav class="bg-gray-900 border-b border-neon-pink">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <Link
                        :href="route('feed')"
                        class="flex items-center px-4 text-neon-blue hover:text-neon-pink transition-all duration-300"
                        :class="{ 'text-neon-pink': route().current('feed') }"
                    >
                        <RssIcon class="w-6 h-6 mr-2 icon-glitch" />
                        NETFEED
                    </Link>
                </div>
                <div class="flex items-center space-x-4">
                    <Link
                        :href="route('profile.show', auth.user.id)"
                        class="flex items-center space-x-3 px-4 text-neon-blue hover:text-neon-pink transition-all duration-300 group relative"
                        :class="{
                            'text-neon-pink': route().current(
                                'profile.show',
                                auth.user.id
                            ),
                        }"
                    >
                        <img
                            :src="auth.user.profile_photo_url"
                            :alt="auth.user.name"
                            class="w-8 h-8 rounded-full border border-current"
                        />
                        <span class="font-bold">{{ auth.user.name }}</span>
                        <div
                            class="absolute inset-0 bg-neon-pink/20 opacity-0 group-hover:opacity-100 blur transition-opacity"
                        ></div>
                    </Link>
                    <button
                        @click="logout"
                        class="flex items-center px-4 text-neon-blue hover:text-neon-pink transition-all duration-300 group relative"
                    >
                        <PowerIcon class="w-6 h-6 icon-glitch" />
                        <div
                            class="absolute inset-0 bg-neon-pink/20 opacity-0 group-hover:opacity-100 blur transition-opacity"
                        ></div>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import { RssIcon, PowerIcon } from "@heroicons/vue/24/solid";

defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

const logout = () => {
    router.post(route("logout"));
};
</script>

<style scoped>
.router-link-active {
    position: relative;
}

.router-link-active::after {
    content: "";
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 2px;
    background: theme("colors.neon-pink");
    box-shadow: 0 0 8px theme("colors.neon-pink");
}
</style>
