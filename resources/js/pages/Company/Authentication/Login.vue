<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import CompanyAuthenticationLayout from '@/layouts/CompanyAuthenticationLayout.vue';
import LoginController from '@/wayfinder/actions/App/Http/Controllers/Company/Authentication/LoginController';
import RegisterController from '@/wayfinder/actions/App/Http/Controllers/Company/Authentication/RegisterController';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post(LoginController.store().url, {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <CompanyAuthenticationLayout title="Sign in">
        <div class="space-y-6">
            <!-- Header -->
            <div class="space-y-1">
                <h1 class="text-xl font-semibold tracking-tight text-foreground">Welcome back</h1>
                <p class="text-sm text-muted-foreground">Sign in to your company account</p>
            </div>

            <!-- Form -->
            <form class="space-y-4" @submit.prevent="submit">
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
                        autofocus
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
                        autocomplete="current-password"
                        placeholder="••••••••"
                        :class="{ 'border-destructive': form.errors.password }"
                    />
                    <p v-if="form.errors.password" class="text-xs text-destructive">
                        {{ form.errors.password }}
                    </p>
                </div>

                <!-- Remember me -->
                <div class="flex items-center gap-2">
                    <input
                        id="remember"
                        v-model="form.remember"
                        type="checkbox"
                        class="size-4 rounded border-border accent-foreground"
                    />
                    <Label for="remember" class="cursor-pointer font-normal text-muted-foreground">
                        Remember me
                    </Label>
                </div>

                <!-- Submit -->
                <Button type="submit" size="lg" class="w-full" :disabled="form.processing">
                    <span v-if="form.processing">Signing in…</span>
                    <span v-else>Sign in</span>
                </Button>
            </form>

            <!-- Divider -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <span class="w-full border-t border-border" />
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-background px-3 text-xs text-muted-foreground">
                        Don't have an account?
                    </span>
                </div>
            </div>

            <!-- Register link -->
            <Button variant="outline" size="lg" class="w-full" as-child>
                <Link :href="RegisterController.index().url">Create an account</Link>
            </Button>
        </div>
    </CompanyAuthenticationLayout>
</template>

