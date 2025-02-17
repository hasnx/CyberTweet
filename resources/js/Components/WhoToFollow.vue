<template>
    <div class="bg-gray-900 rounded-lg p-4 border border-neon-blue">
        <h2 class="text-lg font-bold text-neon-pink mb-4">Who to Follow</h2>
        <div class="space-y-4">
            <div
                v-for="user in users"
                :key="user.id"
                class="flex items-center justify-between"
            >
                <div class="flex items-center space-x-3">
                    <img
                        :src="user.profile_photo_url"
                        :alt="user.name"
                        class="w-10 h-10 rounded-full border border-neon-pink"
                    />
                    <div>
                        <p class="font-bold text-neon-blue">{{ user.name }}</p>
                        <p class="text-gray-400 text-sm">
                            @{{ user.email.split("@")[0] }}
                        </p>
                    </div>
                </div>
                <button
                    @click="followUser(user)"
                    class="px-4 py-1 rounded-full text-sm font-bold"
                    :class="
                        user.isFollowing
                            ? 'bg-gray-800 text-neon-pink border border-neon-pink'
                            : 'bg-neon-pink text-black'
                    "
                >
                    {{ user.isFollowing ? "Following" : "Follow" }}
                </button>
            </div>
        </div>
    </div>
</template>
