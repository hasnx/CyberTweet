<template>
    <div class="min-h-screen bg-gray-950 text-white">
        <!-- Left Sidebar -->
        <CyberSidebar
            :auth="auth"
            :current-route="page.component.toLowerCase()"
        />

        <main class="pl-80">
            <!-- Content Container -->
            <div class="max-w-3xl mx-auto py-8 px-4">
                <slot />
            </div>
        </main>

        <!-- Right Sidebar -->
        <div class="fixed top-0 right-0 w-80 h-screen p-4 bg-gray-950">
            <!-- Who to Follow -->
            <div
                class="bg-gray-900/95 rounded-lg border border-neon-blue/50 p-4"
            >
                <h3
                    class="text-neon-blue font-bold mb-4 tracking-wider flex items-center"
                >
                    <UserPlusIcon class="w-4 h-4 mr-2" />
                    WHO TO FOLLOW
                </h3>
                <!-- Add suggested users here -->
            </div>

            <!-- Trending Topics -->
            <div
                class="bg-gray-900/95 rounded-lg border border-neon-blue/50 p-4 mt-4"
            >
                <h3
                    class="text-neon-blue font-bold mb-4 tracking-wider flex items-center"
                >
                    <ChartBarIcon class="w-4 h-4 mr-2" />
                    TRENDING_NOW
                </h3>
                <!-- Add trending topics here -->
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import CyberSidebar from "@/Components/CyberSidebar.vue";
import { usePage } from "@inertiajs/vue3";
import { UserPlusIcon, ChartBarIcon } from "@heroicons/vue/24/outline";

const props = defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

const page = usePage();
</script>
