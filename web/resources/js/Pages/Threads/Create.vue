<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Start new discussion
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-12 md:gap-6">
                <div class="col-span-full">
                    <FormSection @submitted="createDiscussion">
                        <template #title>
                            Before You Proceed
                        </template>

                        <template #description>
                            You are required to abide by a set of rules that promote healthy, informative conversation. These rules ensure discussions stay on topic and everyone feels comfortable with contributing. Additionally, the site also has a complaint and reporting process so users know what to do when they see someone break the rules of conduct.
                        </template>

                        <template #form>
                            <!-- Title -->
                            <div class="col-span-6 lg:col-span-4">
                                <TextInput
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    autocomplete="title"
                                    placeholder="Add a Title"
                                />
                                <InputError :message="form.errors.title" class="mt-2" />
                            </div>

                            <!-- Body -->
                            <div class="col-span-6 lg:col-span-6">
                                <textarea v-model="form.body" placeholder="What's on your mind?" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full" rows="5"></textarea>
                                <InputError :message="form.errors.body" class="mt-2" />
                            </div>

                            <!-- Categories -->
                            <div class="col-span-6 lg:col-span-3">
                                <InputLabel for="title" value="Select Category" />
                                <select v-model="form.category_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option>Select Category</option>
                                    <option v-for="(category, index) in categories" :key="index" :value="category.id">{{ category.name }}</option>
                                </select>
                                <InputError :message="form.errors.title" class="mt-2" />
                            </div>
                        </template>

                        <template #actions>
                            <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                                Saved.
                            </ActionMessage>

                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Post
                            </PrimaryButton>
                        </template>
                    </FormSection>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

export default {
    components: {
        AppLayout,
        Link,
        ActionMessage,
        FormSection,
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput
    },

    props: {
        categories: Array
    },

    data() {
        return {
            form: useForm({
                title: null,
                body: null,
                category_id: null
            })
        };
    },

    methods: {
        createDiscussion() {
            this.form.post(route('threads.store'), {
                errorBag: 'createNewDiscussion',
                preserveScroll: true
            });
        }
    }
};
</script>
