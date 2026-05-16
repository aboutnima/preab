<script setup lang="ts">
import { router, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import CompanyDashboardLayout from '@/layouts/CompanyDashboardLayout.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import type { SharedPageProps } from '@/types';
import EmailController from '@/actions/App/Http/Controllers/Company/Settings/EmailController';
import LogoController from '@/actions/App/Http/Controllers/Company/Settings/LogoController';
import PasswordController from '@/actions/App/Http/Controllers/Company/Settings/PasswordController';
import ProfileController from '@/actions/App/Http/Controllers/Company/Settings/ProfileController';

defineOptions({ layout: CompanyDashboardLayout });

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

// ── Profile ──────────────────────────────────────────────
const profileForm = useForm({
    name: company.value?.name ?? '',
    phone: company.value?.phone ?? '',
    address: company.value?.address ?? '',
});

function updateProfile() {
    profileForm.patch(ProfileController.update().url);
}

// ── Logo ─────────────────────────────────────────────────
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

// ── Email ─────────────────────────────────────────────────
const emailForm = useForm({
    email: company.value?.email ?? '',
    current_password: '',
});

function updateEmail() {
    emailForm.patch(EmailController.update().url, {
        onSuccess: () => emailForm.reset('current_password'),
    });
}

// ── Password ──────────────────────────────────────────────
const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

function updatePassword() {
    passwordForm.patch(PasswordController.update().url, {
        onSuccess: () => passwordForm.reset(),
    });
}
</script>

<template>
    <div class="mx-auto max-w-2xl px-6 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold tracking-tight text-foreground">Account Settings</h1>
            <p class="mt-1 text-sm text-muted-foreground">Manage your company profile and security.</p>
        </div>

        <div class="space-y-6">
            <!-- ── Profile ───────────────────────────────── -->
            <Card>
                <CardHeader>
                    <CardTitle>Profile</CardTitle>
                    <CardDescription>Update your company name, phone and address.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form class="space-y-4" @submit.prevent="updateProfile">
                        <div class="space-y-1.5">
                            <Label for="name">Company name</Label>
                            <Input
                                id="name"
                                v-model="profileForm.name"
                                type="text"
                                placeholder="Acme Inc."
                                :class="{ 'border-destructive': profileForm.errors.name }"
                            />
                            <p v-if="profileForm.errors.name" class="text-xs text-destructive">
                                {{ profileForm.errors.name }}
                            </p>
                        </div>

                        <div class="space-y-1.5">
                            <Label for="phone">Phone</Label>
                            <Input
                                id="phone"
                                v-model="profileForm.phone"
                                type="tel"
                                placeholder="+1 555 000 0000"
                                :class="{ 'border-destructive': profileForm.errors.phone }"
                            />
                            <p v-if="profileForm.errors.phone" class="text-xs text-destructive">
                                {{ profileForm.errors.phone }}
                            </p>
                        </div>

                        <div class="space-y-1.5">
                            <Label for="address">Address</Label>
                            <Input
                                id="address"
                                v-model="profileForm.address"
                                type="text"
                                placeholder="123 Main St, City"
                                :class="{ 'border-destructive': profileForm.errors.address }"
                            />
                            <p v-if="profileForm.errors.address" class="text-xs text-destructive">
                                {{ profileForm.errors.address }}
                            </p>
                        </div>

                        <div class="flex justify-end">
                            <Button type="submit" :disabled="profileForm.processing">
                                Save profile
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>

            <!-- ── Logo ─────────────────────────────────── -->
            <Card>
                <CardHeader>
                    <CardTitle>Company Logo</CardTitle>
                    <CardDescription>JPG, PNG or WebP · max 2 MB.</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="flex items-center gap-5">
                        <Avatar class="size-16">
                            <AvatarImage v-if="logoUrl" :src="logoUrl" :alt="company?.name" />
                            <AvatarFallback class="bg-foreground text-lg font-semibold text-background">
                                {{ companyInitials }}
                            </AvatarFallback>
                        </Avatar>

                        <div class="flex gap-2">
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
                                Remove
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
                </CardContent>
            </Card>

            <Separator />

            <!-- ── Email ────────────────────────────────── -->
            <Card>
                <CardHeader>
                    <CardTitle>Email Address</CardTitle>
                    <CardDescription>Requires your current password to confirm.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form class="space-y-4" @submit.prevent="updateEmail">
                        <div class="space-y-1.5">
                            <Label for="email">New email</Label>
                            <Input
                                id="email"
                                v-model="emailForm.email"
                                type="email"
                                :class="{ 'border-destructive': emailForm.errors.email }"
                            />
                            <p v-if="emailForm.errors.email" class="text-xs text-destructive">
                                {{ emailForm.errors.email }}
                            </p>
                        </div>

                        <div class="space-y-1.5">
                            <Label for="email-current-password">Current password</Label>
                            <Input
                                id="email-current-password"
                                v-model="emailForm.current_password"
                                type="password"
                                placeholder="••••••••"
                                :class="{ 'border-destructive': emailForm.errors.current_password }"
                            />
                            <p v-if="emailForm.errors.current_password" class="text-xs text-destructive">
                                {{ emailForm.errors.current_password }}
                            </p>
                        </div>

                        <div class="flex justify-end">
                            <Button type="submit" :disabled="emailForm.processing">
                                Update email
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>

            <!-- ── Password ──────────────────────────────── -->
            <Card>
                <CardHeader>
                    <CardTitle>Password</CardTitle>
                    <CardDescription>Use a strong password of at least 8 characters.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form class="space-y-4" @submit.prevent="updatePassword">
                        <div class="space-y-1.5">
                            <Label for="current-password">Current password</Label>
                            <Input
                                id="current-password"
                                v-model="passwordForm.current_password"
                                type="password"
                                placeholder="••••••••"
                                :class="{ 'border-destructive': passwordForm.errors.current_password }"
                            />
                            <p v-if="passwordForm.errors.current_password" class="text-xs text-destructive">
                                {{ passwordForm.errors.current_password }}
                            </p>
                        </div>

                        <div class="space-y-1.5">
                            <Label for="new-password">New password</Label>
                            <Input
                                id="new-password"
                                v-model="passwordForm.password"
                                type="password"
                                placeholder="••••••••"
                                :class="{ 'border-destructive': passwordForm.errors.password }"
                            />
                            <p v-if="passwordForm.errors.password" class="text-xs text-destructive">
                                {{ passwordForm.errors.password }}
                            </p>
                        </div>

                        <div class="space-y-1.5">
                            <Label for="password-confirmation">Confirm new password</Label>
                            <Input
                                id="password-confirmation"
                                v-model="passwordForm.password_confirmation"
                                type="password"
                                placeholder="••••••••"
                                :class="{ 'border-destructive': passwordForm.errors.password_confirmation }"
                            />
                            <p v-if="passwordForm.errors.password_confirmation" class="text-xs text-destructive">
                                {{ passwordForm.errors.password_confirmation }}
                            </p>
                        </div>

                        <div class="flex justify-end">
                            <Button type="submit" :disabled="passwordForm.processing">
                                Update password
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </div>
</template>

