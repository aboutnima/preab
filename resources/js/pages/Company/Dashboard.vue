<script setup lang="ts">
import { DashboardSquare01Icon } from '@hugeicons/core-free-icons';
import { HugeiconsIcon } from '@hugeicons/vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import CompanyDashboardLayout from '@/layouts/CompanyDashboardLayout.vue';
import type { SharedPageProps } from '@/types';

const page = usePage<SharedPageProps>();
const company = computed(() => page.props.auth);
</script>

<template>
    <CompanyDashboardLayout
        :title="`Welcome back, ${company?.name}`"
        description="Here's what's happening with your account."
    >
        <div class="rounded-lg border border-border bg-card p-12 text-center">
            <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-muted">
                <HugeiconsIcon
                    :icon="DashboardSquare01Icon"
                    :size="20"
                    class="text-muted-foreground"
                    :stroke-width="1.5"
                />
            </div>
            <h2 class="mt-4 text-sm font-medium text-foreground">Your dashboard is ready</h2>
            <p class="mt-1 text-sm text-muted-foreground">
                Content and modules will appear here as they are built.
            </p>
        </div>
    </CompanyDashboardLayout>
</template>
