<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import CompanyDashboardLayout from '@/layouts/CompanyDashboardLayout.vue';
import CompanySettingsLayout from '@/layouts/CompanySettingsLayout.vue';
import PasswordController from '@/wayfinder/actions/App/Http/Controllers/Company/Settings/PasswordController';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.patch(PasswordController.update().url, {
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <CompanyDashboardLayout title="Password" description="Use a strong password of at least 8 characters.">
        <CompanySettingsLayout>
            <div class="max-w-lg">
                <form class="space-y-4" @submit.prevent="submit">
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

                    <div class="space-y-1.5">
                        <Label for="new-password">New password</Label>
                        <Input
                            id="new-password"
                            v-model="form.password"
                            type="password"
                            placeholder="••••••••"
                            :class="{ 'border-destructive': form.errors.password }"
                        />
                        <p v-if="form.errors.password" class="text-xs text-destructive">{{ form.errors.password }}</p>
                    </div>

                    <div class="space-y-1.5">
                        <Label for="password-confirmation">Confirm new password</Label>
                        <Input
                            id="password-confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="••••••••"
                            :class="{ 'border-destructive': form.errors.password_confirmation }"
                        />
                        <p v-if="form.errors.password_confirmation" class="text-xs text-destructive">
                            {{ form.errors.password_confirmation }}
                        </p>
                    </div>

                    <div class="pt-2">
                        <Button type="submit" :disabled="form.processing">Update password</Button>
                    </div>
                </form>
            </div>
        </CompanySettingsLayout>
    </CompanyDashboardLayout>
</template>
