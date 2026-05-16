<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import CompanyAuthenticationLayout from '@/layouts/CompanyAuthenticationLayout.vue';
import LoginController from '@/wayfinder/actions/App/Http/Controllers/Company/Authentication/LoginController';
import RegisterController from '@/wayfinder/actions/App/Http/Controllers/Company/Authentication/RegisterController';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post(RegisterController.store().url, {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <CompanyAuthenticationLayout title="Create account">
        <div class="space-y-6">
            <!-- Header -->
            <div class="space-y-1">
                <h1 class="text-xl font-semibold tracking-tight text-foreground">Create your account</h1>
                <p class="text-sm text-muted-foreground">Get started with your company today</p>
            </div>

            <!-- Form -->
            <form class="space-y-4" @submit.prevent="submit">
                <!-- Company name -->
                <div class="space-y-1.5">
                    <Label for="name">Company name</Label>
                    <Input
                        id="name"
                        v-model="form.name"
                        type="text"
                        autocomplete="organization"
                        placeholder="Acme Inc."
                        :class="{ 'border-destructive': form.errors.name }"
                        autofocus
                    />
                    <p v-if="form.errors.name" class="text-xs text-destructive">
                        {{ form.errors.name }}
                    </p>
                </div>

                <!-- Email -->
                <div class="space-y-1.5">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        v-model="form.email"
                        type="email"
                        autocomplete="email"
                        placeholder="company@example.com"
                        :class="{ 'border-destructive': form.errors.email }"
                    />
                    <p v-if="form.errors.email" class="text-xs text-destructive">
                        {{ form.errors.email }}
                    </p>
                </div>

                <!-- Password -->
                <div class="space-y-1.5">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        :class="{ 'border-destructive': form.errors.password }"
                    />
                    <p v-if="form.errors.password" class="text-xs text-destructive">
                        {{ form.errors.password }}
                    </p>
                </div>

                <!-- Confirm password -->
                <div class="space-y-1.5">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        :class="{ 'border-destructive': form.errors.password_confirmation }"
                    />
                    <p v-if="form.errors.password_confirmation" class="text-xs text-destructive">
                        {{ form.errors.password_confirmation }}
                    </p>
                </div>

                <!-- Submit -->
                <Button type="submit" size="lg" class="w-full" :disabled="form.processing">
                    <span v-if="form.processing">Creating account…</span>
                    <span v-else>Create account</span>
                </Button>
            </form>

            <!-- Divider -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <span class="w-full border-t border-border" />
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-background px-3 text-xs text-muted-foreground">
                        Already have an account?
                    </span>
                </div>
            </div>

            <!-- Login link -->
            <Button variant="outline" size="lg" class="w-full" as-child>
                <Link :href="LoginController.index().url">Sign in instead</Link>
            </Button>
        </div>
    </CompanyAuthenticationLayout>
</template>

