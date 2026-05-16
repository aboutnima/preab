<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { HugeiconsIcon } from '@hugeicons/vue';
import {
    Add01Icon,
    Delete02Icon,
    PencilEdit01Icon,
    UserGroupIcon,
} from '@hugeicons/core-free-icons';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import CompanyDashboardLayout from '@/layouts/CompanyDashboardLayout.vue';
import type { EmployeeType } from '@/types';
import EmployeeController from '@/wayfinder/actions/App/Http/Controllers/Company/Employees/EmployeeController';

defineOptions({ layout: CompanyDashboardLayout });

defineProps<{
    employees: EmployeeType[];
}>();

function visitCreate(): void {
    router.visit(EmployeeController.create().url);
}

function visitEdit(employee: EmployeeType): void {
    router.visit(EmployeeController.edit({ employee: employee.id }).url);
}

function destroy(employee: EmployeeType): void {
    if (!confirm(`Delete ${employee.first_name} ${employee.last_name}? This cannot be undone.`)) {
        return;
    }
    router.delete(EmployeeController.destroy({ employee: employee.id }).url);
}
</script>

<template>
    <div class="px-8 py-8">
        <!-- Page header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-foreground">Employees</h1>
                <p class="mt-1 text-sm text-muted-foreground">
                    Manage your team members.
                </p>
            </div>
            <Button @click="visitCreate">
                <HugeiconsIcon :icon="Add01Icon" :size="16" :stroke-width="2" class="mr-1.5" />
                Add Employee
            </Button>
        </div>

        <!-- Empty state -->
        <Card v-if="employees.length === 0">
            <CardContent class="flex flex-col items-center py-16 text-center">
                <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-muted">
                    <HugeiconsIcon
                        :icon="UserGroupIcon"
                        :size="20"
                        class="text-muted-foreground"
                        :stroke-width="1.5"
                    />
                </div>
                <h2 class="mt-4 text-sm font-medium text-foreground">No employees yet</h2>
                <p class="mt-1 text-sm text-muted-foreground">
                    Add your first team member to get started.
                </p>
                <Button class="mt-4" size="sm" @click="visitCreate">
                    <HugeiconsIcon :icon="Add01Icon" :size="15" :stroke-width="2" class="mr-1.5" />
                    Add Employee
                </Button>
            </CardContent>
        </Card>

        <!-- Table -->
        <Card v-else>
            <CardHeader>
                <CardTitle>Team</CardTitle>
                <CardDescription>{{ employees.length }} employee{{ employees.length !== 1 ? 's' : '' }}</CardDescription>
            </CardHeader>
            <CardContent class="p-0">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-border bg-muted/40">
                            <th class="px-4 py-3 text-left font-medium text-muted-foreground">Name</th>
                            <th class="px-4 py-3 text-left font-medium text-muted-foreground">Email</th>
                            <th class="px-4 py-3 text-left font-medium text-muted-foreground">Username</th>
                            <th class="px-4 py-3 text-left font-medium text-muted-foreground">Gender</th>
                            <th class="px-4 py-3 text-left font-medium text-muted-foreground">Status</th>
                            <th class="px-4 py-3 text-right font-medium text-muted-foreground">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="employee in employees"
                            :key="employee.id"
                            class="border-b border-border last:border-0 hover:bg-muted/20 transition-colors"
                        >
                            <td class="px-4 py-3 font-medium text-foreground">
                                {{ employee.first_name }} {{ employee.last_name }}
                            </td>
                            <td class="px-4 py-3 text-muted-foreground">{{ employee.email }}</td>
                            <td class="px-4 py-3 text-muted-foreground">
                                {{ employee.username ?? '—' }}
                            </td>
                            <td class="px-4 py-3 capitalize text-muted-foreground">
                                {{ employee.gender ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <Badge :variant="employee.is_active ? 'default' : 'outline'">
                                    {{ employee.is_active ? 'Active' : 'Inactive' }}
                                </Badge>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <Button
                                        variant="ghost"
                                        size="sm"
                                        class="size-8 p-0"
                                        @click="visitEdit(employee)"
                                    >
                                        <HugeiconsIcon
                                            :icon="PencilEdit01Icon"
                                            :size="15"
                                            :stroke-width="1.8"
                                        />
                                    </Button>
                                    <Button
                                        variant="ghost"
                                        size="sm"
                                        class="size-8 p-0 text-destructive hover:text-destructive"
                                        @click="destroy(employee)"
                                    >
                                        <HugeiconsIcon
                                            :icon="Delete02Icon"
                                            :size="15"
                                            :stroke-width="1.8"
                                        />
                                    </Button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </CardContent>
        </Card>
    </div>
</template>

