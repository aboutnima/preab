<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import CompanyDashboardLayout from '@/layouts/CompanyDashboardLayout.vue';

defineOptions({ layout: CompanyDashboardLayout });

const page = usePage();
const company = computed(() => page.props.auth);
</script>

<template>
    <div class="px-8 py-8">
        <!-- Page header -->
        <div class="mb-8">
            <h1 class="text-2xl font-semibold tracking-tight text-foreground">
                Welcome back, {{ company?.name }}
            </h1>
            <p class="mt-1 text-sm text-muted-foreground">
                Here's what's happening with your account.
            </p>
        </div>

        <!-- Placeholder content area -->
        <div class="rounded-lg border border-border bg-card p-12 text-center">
            <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-muted">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="size-5 text-muted-foreground"
                >
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                </svg>
            </div>
            <h2 class="mt-4 text-sm font-medium text-foreground">Your dashboard is ready</h2>
            <p class="mt-1 text-sm text-muted-foreground">
                Content and modules will appear here as they are built.
            </p>
        </div>
    </div>
</template>

