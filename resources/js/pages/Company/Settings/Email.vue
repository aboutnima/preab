<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import CompanyDashboardLayout from '@/layouts/CompanyDashboardLayout.vue';
import CompanySettingsLayout from '@/layouts/CompanySettingsLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { SharedPageProps } from '@/types';
import EmailController from '@/actions/App/Http/Controllers/Company/Settings/EmailController';

defineOptions({ layout: [CompanyDashboardLayout, CompanySettingsLayout] });

const page = usePage<SharedPageProps>();
const company = computed(() => page.props.auth);

const form = useForm({
    email: company.value?.email ?? '',
    current_password: '',
});

function submit() {
    form.patch(EmailController.update().url, {
        onSuccess: () => form.reset('current_password'),
    });
}
</script>

<template>
    <div class="max-w-lg">
        <div class="mb-6">
            <h2 class="text-base font-semibold text-foreground">Email Address</h2>
            <p class="mt-0.5 text-sm text-muted-foreground">Requires your current password to confirm.</p>
        </div>

        <form class="space-y-4" @submit.prevent="submit">
            <div class="space-y-1.5">
                <Label for="email">New email</Label>
                <Input
                    id="email"
                    v-model="form.email"
                    type="email"
                    :class="{ 'border-destructive': form.errors.email }"
                />
                <p v-if="form.errors.email" class="text-xs text-destructive">{{ form.errors.email }}</p>
            </div>

            <div class="space-y-1.5">
                <Label for="current-password">Current password</Label>
                <Input
                    id="current-password"
                    v-model="form.current_password"
                    type="password"
                    placeholder="••••••••"
                    :class="{ 'border-destructive': form.errors.current_password }"
                />
                <p v-if="form.errors.current_password" class="text-xs text-destructive">
                    {{ form.errors.current_password }}
                </p>
            </div>

            <div class="pt-2">
                <Button type="submit" :disabled="form.processing">Update email</Button>
            </div>
        </form>
    </div>
</template>

