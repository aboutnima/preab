<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import CompanyDashboardLayout from '@/layouts/CompanyDashboardLayout.vue';
import type { Gender } from '@/types';
import EmployeeController from '@/wayfinder/actions/App/Http/Controllers/Company/Employees/EmployeeController';


const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
    gender: '' as Gender | '',
    username: '',
    bio: '',
    is_active: true,
});

function submit(): void {
    form.post(EmployeeController.store().url);
}
</script>

<template>
    <CompanyDashboardLayout title="Add Employee" description="Create a new team member for your company.">
        <div class="max-w-2xl">
            <Card>
                <CardHeader>
                    <CardTitle>Employee Details</CardTitle>
                    <CardDescription>Fill in the information below to create a new employee.</CardDescription>
                </CardHeader>
                <CardContent>
                    <form class="space-y-4" @submit.prevent="submit">
                        <!-- Name row -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <Label for="first_name">First name <span class="text-destructive">*</span></Label>
                                <Input
                                    id="first_name"
                                    v-model="form.first_name"
                                    type="text"
                                    placeholder="Jane"
                                    :class="{ 'border-destructive': form.errors.first_name }"
                                />
                                <p v-if="form.errors.first_name" class="text-xs text-destructive">
                                    {{ form.errors.first_name }}
                                </p>
                            </div>
                            <div class="space-y-1.5">
                                <Label for="last_name">Last name <span class="text-destructive">*</span></Label>
                                <Input
                                    id="last_name"
                                    v-model="form.last_name"
                                    type="text"
                                    placeholder="Doe"
                                    :class="{ 'border-destructive': form.errors.last_name }"
                                />
                                <p v-if="form.errors.last_name" class="text-xs text-destructive">
                                    {{ form.errors.last_name }}
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="space-y-1.5">
                            <Label for="email">Email <span class="text-destructive">*</span></Label>
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="jane@example.com"
                                :class="{ 'border-destructive': form.errors.email }"
                            />
                            <p v-if="form.errors.email" class="text-xs text-destructive">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- Password row -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <Label for="password">Password <span class="text-destructive">*</span></Label>
                                <Input
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    placeholder="••••••••"
                                    :class="{ 'border-destructive': form.errors.password }"
                                />
                                <p v-if="form.errors.password" class="text-xs text-destructive">
                                    {{ form.errors.password }}
                                </p>
                            </div>
                            <div class="space-y-1.5">
                                <Label for="password_confirmation">Confirm password <span class="text-destructive">*</span></Label>
                                <Input
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    type="password"
                                    placeholder="••••••••"
                                    :class="{ 'border-destructive': form.errors.password_confirmation }"
                                />
                                <p v-if="form.errors.password_confirmation" class="text-xs text-destructive">
                                    {{ form.errors.password_confirmation }}
                                </p>
                            </div>
                        </div>

                        <!-- Gender & Username row -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <Label for="gender">Gender</Label>
                                <select
                                    id="gender"
                                    v-model="form.gender"
                                    class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                                    :class="{ 'border-destructive': form.errors.gender }"
                                >
                                    <option value="">Select gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <p v-if="form.errors.gender" class="text-xs text-destructive">
                                    {{ form.errors.gender }}
                                </p>
                            </div>
                            <div class="space-y-1.5">
                                <Label for="username">Username</Label>
                                <Input
                                    id="username"
                                    v-model="form.username"
                                    type="text"
                                    placeholder="janedoe"
                                    :class="{ 'border-destructive': form.errors.username }"
                                />
                                <p v-if="form.errors.username" class="text-xs text-destructive">
                                    {{ form.errors.username }}
                                </p>
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="space-y-1.5">
                            <Label for="bio">Bio</Label>
                            <textarea
                                id="bio"
                                v-model="form.bio"
                                rows="3"
                                placeholder="A short bio about the employee…"
                                class="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring resize-none"
                                :class="{ 'border-destructive': form.errors.bio }"
                            />
                            <p v-if="form.errors.bio" class="text-xs text-destructive">
                                {{ form.errors.bio }}
                            </p>
                        </div>

                        <!-- Status -->
                        <div class="flex items-center gap-3">
                            <input
                                id="is_active"
                                v-model="form.is_active"
                                type="checkbox"
                                class="size-4 rounded border-input accent-primary"
                            />
                            <Label for="is_active" class="cursor-pointer font-normal">Active employee</Label>
                        </div>

                        <div class="flex justify-end gap-2 pt-2">
                            <Button
                                type="button"
                                variant="outline"
                                @click="() => $inertia.visit('/company/employees')"
                            >
                                Cancel
                            </Button>
                            <Button type="submit" :disabled="form.processing">
                                Create Employee
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </CompanyDashboardLayout>
</template>

