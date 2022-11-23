<template>
    <AppLayout :title="thread.title">
        <template #header>
            <div class="space-y-4">
                <div>
                    <Link class="text-xs text-indigo-500 hover:text-indigo-600 inline-flex items-center space-x-1" :href="route('threads.index')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>

                        <span>Back to threads</span>
                    </Link>
                </div>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ thread.title }}
                </h2>

                <div class="max-w-3xl">
                    <p class="text-gray-600">
                        {{ thread.body }}
                    </p>
                </div>

                <div class="text-xs text-gray-500 flex items-center space-x-2">
                    <div>
                        <span class="text-indigo-500">{{ thread.user.name }}</span> posted {{ diffForHumans(thread.created_at) }}
                    </div>

                    <span>&middot;</span>

                    <div class="capitalize">
                        <span class="capitalize text-indigo-500">{{ thread.category.name }}</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="md:grid md:grid-cols-12 md:gap-6">
                <div class="col-span-8 bg-white overflow-hidden shadow-sm sm:rounded-xl">
                    <div class="sm:px-4 py-5 px-6">
                        <div class="flex items-start">
                            <div>
                                <Link href="/" v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                </Link>
                            </div>

                            <div class="ml-4 flex-1">
                                <form class="max-w-xl">
                                    <textarea v-model="form.body" placeholder="Type your reply" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full" rows="3"></textarea>

                                    <div class="mt-3 flex items-center">
                                        <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Reply
                                        </PrimaryButton>

                                        <div class="ml-3 text-xs text-gray-400">
                                            <span>You may use Markdown with GitHub-flavored code blocks. </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-full" v-if="thread.replies.length <= 0">
                    <span class="text-sm text-gray-500">No replies yet</span>
                </div>

                <div v-else class="col-span-8 bg-white overflow-hidden shadow-sm sm:rounded-xl">
                    <div class="sm:px-4 pt-5 pb-2 px-6">
                        <h2 class="font-semibold text-sm text-gray-800 leading-tight">
                            {{ thread.replies.length }} Replies
                        </h2>
                    </div>

                    <div class="divide-y divide-solid divide-gray-100">
                        <div v-for="(reply, index) in thread.replies">
                            <div :key="index" class="sm:px-4 py-5 px-6">
                                <div class="text-gray-600 max-w-2xl">{{ reply.body }}</div>
                                <div class="mt-3 text-xs text-gray-500">
                                    <span class="text-indigo-500">{{ reply.user.name }}</span> replied {{ diffForHumans(reply.created_at) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import moment from 'moment';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

export default {
    components: {
        PrimaryButton,
        AppLayout,
        Link
    },

    props: {
        thread: Object
    },

    data() {
        return {
            form: useForm({
                _method: 'POST',
                body: '',
            })
        };
    },

    methods: {
        diffForHumans(timestamp) {
            return moment(timestamp).fromNow();
        }
    }
};
</script>
