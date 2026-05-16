<script setup lang="ts">
import { router, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import CompanyDashboardLayout from '@/layouts/CompanyDashboardLayout.vue';
import CompanySettingsLayout from '@/layouts/CompanySettingsLayout.vue';
import type { SharedPageProps } from '@/types';
import LogoController from '@/wayfinder/actions/App/Http/Controllers/Company/Settings/LogoController';

const page = usePage<SharedPageProps>();
const company = computed(() => page.props.auth);

const logoUrl = computed(() =>
    company.value?.logo ? `/storage/${company.value.logo}` : null,
);

const companyInitials = computed(() =>
    company.value?.name
        ?.split(' ')
        .slice(0, 2)
        .map((w) => w[0])
        .join('')
        .toUpperCase() ?? '??',
);

const logoInput = ref<HTMLInputElement | null>(null);
const logoForm = useForm<{ logo: File | null }>({ logo: null });

function onLogoSelected(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0];

    if (!file) {
return;
}

    logoForm.logo = file;
    logoForm.post(LogoController.store().url, {
        forceFormData: true,
        onSuccess: () => {
            logoForm.reset();

            if (logoInput.value) {
logoInput.value.value = '';
}
        },
    });
}

function removeLogo() {
    router.delete(LogoController.destroy().url);
}
</script>

<template>
    <CompanyDashboardLayout title="Company Logo" description="JPG, PNG or WebP · max 2 MB.">
        <CompanySettingsLayout>
            <div class="max-w-lg">
                <div class="flex items-center gap-5">
                    <Avatar class="size-20">
                        <AvatarImage v-if="logoUrl" :src="logoUrl" :alt="company?.name" />
                        <AvatarFallback class="bg-foreground text-xl font-semibold text-background">
                            {{ companyInitials }}
                        </AvatarFallback>
                    </Avatar>

                    <div class="flex flex-col gap-3">
                        <Button
                            type="button"
                            variant="outline"
                            size="sm"
                            :disabled="logoForm.processing"
                            @click="logoInput?.click()"
                        >
                            {{ logoUrl ? 'Change logo' : 'Upload logo' }}
                        </Button>

                        <Button
                            v-if="logoUrl"
                            type="button"
                            variant="destructive"
                            size="sm"
                            @click="removeLogo"
                        >
                            Remove logo
                        </Button>
                    </div>

                    <input
                        ref="logoInput"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        class="hidden"
                        @change="onLogoSelected"
                    />
                </div>
            </div>
        </CompanySettingsLayout>
    </CompanyDashboardLayout>
</template>
