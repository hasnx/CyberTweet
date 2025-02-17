<template>
    <CyberLayout :auth="auth">
        <div class="max-w-2xl">
            <!-- Create Post -->
            <CreatePost :auth="auth" class="mb-8" />

            <!-- Posts Feed -->
            <div class="space-y-4">
                <PostItem
                    v-for="post in posts"
                    :key="post.id"
                    :post="post"
                    @like="likePost"
                    @repost="repostPost"
                />
            </div>
        </div>
    </CyberLayout>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import CyberLayout from "@/Layouts/CyberLayout.vue";
import PostItem from "@/Components/PostItem.vue";
import CreatePost from "@/Components/CreatePost.vue";

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
