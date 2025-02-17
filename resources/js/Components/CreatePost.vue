<template>
    <div class="mb-8">
        <div class="bg-gray-900/95 rounded-lg border border-neon-blue/50 p-4">
            <div class="flex items-start space-x-4">
                <div class="relative flex-shrink-0">
                    <img
                        :src="auth.user.profile_photo_url"
                        :alt="auth.user.name"
                        class="w-10 h-10 rounded-full border border-neon-pink"
                    />
                    <div
                        class="absolute inset-0 rounded-full glitch-effect"
                    ></div>
                </div>
                <div class="flex-1">
                    <textarea
                        v-model="content"
                        rows="3"
                        placeholder="What's happening in CyberTweet?"
                        class="w-full bg-gray-800/50 text-white border-none rounded-lg px-4 py-2 focus:ring-2 focus:ring-neon-pink placeholder-gray-500 resize-none"
                        @input="updateCharCount"
                    ></textarea>
                    <div class="mt-2 flex justify-between items-center">
                        <div class="text-sm text-gray-400">
                            {{ 280 - charCount }} characters remaining
                        </div>
                        <button
                            @click="createPost"
                            class="bg-neon-pink hover:bg-neon-pink/90 text-black px-6 py-2 rounded-full font-bold transition-all duration-300"
                            :disabled="!content.trim() || charCount > 280"
                        >
                            UPLOAD TO NETWORK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    auth: Object,
});

const content = ref("");
const charCount = ref(0);

const updateCharCount = () => {
    charCount.value = content.value.length;
};

const createPost = () => {
    if (content.value.trim() && charCount.value <= 280) {
        router.post(
            route("posts.store"),
            {
                content: content.value,
            },
            {
                preserveScroll: true,
                onSuccess: () => {
                    content.value = "";
                    charCount.value = 0;
                },
            }
        );
    }
};
</script>
