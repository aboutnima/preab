<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { HugeiconsIcon } from '@hugeicons/vue';
import { Layers01Icon, Tick01Icon } from '@hugeicons/core-free-icons';

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
                    <HugeiconsIcon
                        :icon="Layers01Icon"
                        :size="16"
                        class="text-foreground"
                        :stroke-width="2"
                    />
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
                    <HugeiconsIcon
                        :icon="Tick01Icon"
                        :size="14"
                        class="shrink-0 text-background/50"
                        :stroke-width="2.5"
                    />
                    {{ feature }}
                </li>
            </ul>
        </div>

        <!-- Right form panel -->
        <div class="flex flex-col items-center justify-center bg-background px-6 py-12 sm:px-12">
            <!-- Mobile logo -->
            <div class="mb-8 flex items-center gap-2 lg:hidden">
                <div class="flex size-8 items-center justify-center rounded-lg bg-foreground">
                    <HugeiconsIcon
                        :icon="Layers01Icon"
                        :size="16"
                        class="text-background"
                        :stroke-width="2"
                    />
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
