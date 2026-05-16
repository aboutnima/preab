<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

defineProps<{
    title?: string;
}>();
</script>

<template>
    <Head :title="title" />

    <div class="grid min-h-screen lg:grid-cols-2">
        <!-- Left branded panel -->
        <div class="relative hidden flex-col justify-between bg-foreground p-12 lg:flex">
            <!-- Logo / wordmark -->
            <div class="flex items-center gap-2.5">
                <div class="flex size-8 items-center justify-center rounded-lg bg-background">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="size-4 text-foreground"
                    >
                        <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        <path d="M2 17l10 5 10-5" />
                        <path d="M2 12l10 5 10-5" />
                    </svg>
                </div>
                <span class="text-base font-semibold tracking-tight text-background">Preab</span>
            </div>

            <!-- Center quote / tagline -->
            <div class="space-y-3">
                <p class="text-2xl font-medium leading-snug tracking-tight text-background">
                    Manage your business<br />
                    with confidence.
                </p>
                <p class="text-sm text-background/60">
                    One platform for all your company operations.
                </p>
            </div>

            <!-- Bottom feature list -->
            <ul class="space-y-2">
                <li
                    v-for="feature in ['Powerful team management', 'Real-time analytics', 'Secure & reliable']"
                    :key="feature"
                    class="flex items-center gap-2 text-sm text-background/70"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="size-3.5 shrink-0 text-background/50"
                    >
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    {{ feature }}
                </li>
            </ul>
        </div>

        <!-- Right form panel -->
        <div class="flex flex-col items-center justify-center bg-background px-6 py-12 sm:px-12">
            <!-- Mobile logo -->
            <div class="mb-8 flex items-center gap-2 lg:hidden">
                <div class="flex size-8 items-center justify-center rounded-lg bg-foreground">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="size-4 text-background"
                    >
                        <path d="M12 2L2 7l10 5 10-5-10-5z" />
                        <path d="M2 17l10 5 10-5" />
                        <path d="M2 12l10 5 10-5" />
                    </svg>
                </div>
                <span class="text-base font-semibold tracking-tight text-foreground">Preab</span>
            </div>

            <!-- Page content (form card) -->
            <div class="w-full max-w-sm">
                <slot />
            </div>
        </div>
    </div>
</template>

