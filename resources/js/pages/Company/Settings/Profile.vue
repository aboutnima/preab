<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import CompanyDashboardLayout from '@/layouts/CompanyDashboardLayout.vue';
import CompanySettingsLayout from '@/layouts/CompanySettingsLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { SharedPageProps } from '@/types';
import ProfileController from '@/wayfinder/actions/App/Http/Controllers/Company/Settings/ProfileController';

defineOptions({ layout: [CompanyDashboardLayout, CompanySettingsLayout] });

const page = usePage<SharedPageProps>();
const company = computed(() => page.props.auth);

const form = useForm({
    name: company.value?.name ?? '',
    phone: company.value?.phone ?? '',
    address: company.value?.address ?? '',
});

function submit() {
    form.patch(ProfileController.update().url);
}
</script>

<template>
    <div class="max-w-lg">
        <div class="mb-6">
            <h2 class="text-base font-semibold text-foreground">Profile</h2>
            <p class="mt-0.5 text-sm text-muted-foreground">Update your company name, phone and address.</p>
        </div>

        <form class="space-y-4" @submit.prevent="submit">
            <div class="space-y-1.5">
                <Label for="name">Company name</Label>
                <Input
                    id="name"
                    v-model="form.name"
                    type="text"
                    placeholder="Acme Inc."
                    :class="{ 'border-destructive': form.errors.name }"
                />
                <p v-if="form.errors.name" class="text-xs text-destructive">{{ form.errors.name }}</p>
            </div>

            <div class="space-y-1.5">
                <Label for="phone">Phone</Label>
                <Input
                    id="phone"
                    v-model="form.phone"
                    type="tel"
                    placeholder="+1 555 000 0000"
                    :class="{ 'border-destructive': form.errors.phone }"
                />
                <p v-if="form.errors.phone" class="text-xs text-destructive">{{ form.errors.phone }}</p>
            </div>

            <div class="space-y-1.5">
                <Label for="address">Address</Label>
                <Input
                    id="address"
                    v-model="form.address"
                    type="text"
                    placeholder="123 Main St, City"
                    :class="{ 'border-destructive': form.errors.address }"
                />
                <p v-if="form.errors.address" class="text-xs text-destructive">{{ form.errors.address }}</p>
            </div>

            <div class="pt-2">
                <Button type="submit" :disabled="form.processing">Save changes</Button>
            </div>
        </form>
    </div>
</template>

