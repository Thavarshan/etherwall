<template>
    <AppLayout title="Discussions">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Discussions
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="md:grid md:grid-cols-12 md:gap-6">
                <Link :href="route('threads.show', { thread: thread.id })" v-for="(thread, index) in threads" class="col-span-8 bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="sm:px-4 py-5 px-6" :key="index">
                    <div class="font-semibold text-base text-gray-800 mb-2">{{ thread.title }}</div>
                    <div class="text-sm text-gray-500">{{ thread.body }}</div>
                    <div class="mt-3 text-xs text-gray-500 flex items-center space-x-2">
                        <div>
                            <span class="text-indigo-500">{{ thread.user.name }}</span> posted {{ diffForHumans(thread.created_at) }}
                        </div>
                        <span>&middot;</span>
                        <div class="capitalize">{{ thread.category.name }}</div>
                    </div>
                </div>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import moment from 'moment';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        AppLayout,
        Link
    },

    props: {
        threads: Object
    },

    methods: {
        diffForHumans(timestamp) {
            return moment(timestamp).fromNow();
        }
    }
};
</script>
